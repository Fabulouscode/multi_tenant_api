<?php

namespace App\Http\Controllers;

class StatusController extends Controller
{
    public function index()
    {
        return $this->jsonResponse(HTTP_SUCCESS, 'Welcome to Multi Tenant API');
    }
}
