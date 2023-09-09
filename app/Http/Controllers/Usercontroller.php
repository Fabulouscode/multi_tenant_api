<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(UserRequest $request)
    {
        $validatedData = $request->validatedData();  

        $user = User::create([
            'uuid' => Str::orderedUuid(),
            'email' => $validatedData['email'],
            'name' => $validatedData['name'],
            'password' => $validatedData['password'],
            'tenant_id' => $request->user()->tenant_id,
        ]);

        return $this->jsonResponse(HTTP_CREATED, 'User added successful.', new UserResource($user));
    }
}
