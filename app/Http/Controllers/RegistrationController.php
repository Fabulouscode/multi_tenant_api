<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Services\RegistrationService;

class RegistrationController extends Controller
{
    public function register(RegistrationRequest $request, RegistrationService $service)
    {
        $service->createUser($request);

        return $this->jsonResponse(HTTP_CREATED, 'Registration was successful.');
    }
}
