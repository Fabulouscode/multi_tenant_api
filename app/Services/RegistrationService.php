<?php

namespace App\Services;

use App\Http\Requests\RegistrationRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RegistrationService
{
    public function createUser(RegistrationRequest $request)
    {
        DB::transaction(function () use ($request) {
            $user = User::create($request->validatedData());

            $subdomain = 'https://' . $request->subdomain . '.tenant.com';

            Tenant::create([
                'uuid' => Str::orderedUuid(),
                'user_id' => $user->id,
                'subdomain' => $subdomain,
            ]);

            return $user;
        });
    }
}
