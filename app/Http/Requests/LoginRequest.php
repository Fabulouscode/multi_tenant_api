<?php

namespace App\Http\Requests;

use App\Models\User;
use Closure;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => ['required', 'email', 'min:2'],
            'password' => ['required', 'string', 'min:1'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return \App\Models\User
     */
    public function authenticate(Closure $callback)
    {
        $this->ensureRequestIsNotRateLimited();

        if (! $user = $callback($this)) {
            RateLimiter::hit($this->throttleKey());

            abort(HTTP_BAD_REQUEST, 'Invalid credentials');
        }

        RateLimiter::clear($this->throttleKey());

        return $user;
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function ensureRequestIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        abort(HTTP_TOO_MANY_REQUESTS, __('auth.throttle', [
            'seconds' => $seconds,
        ]));
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}
