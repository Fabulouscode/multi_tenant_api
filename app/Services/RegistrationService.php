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
            $subdomain = $request->subdomain . '.tenant.com';

            $validatedData = $request->validatedData();

            $tenant = Tenant::create([
                'uuid' => Str::orderedUuid(),
                'subdomain' => $subdomain,
            ]);    

            $user = User::create([
                'uuid' => Str::orderedUuid(),
                'email' => $validatedData['email'],
                'name' => $validatedData['name'],
                'password' => $validatedData['password'],
                'tenant_id' => $tenant->id,
            ]);

            return $user;
        });
    }
}
