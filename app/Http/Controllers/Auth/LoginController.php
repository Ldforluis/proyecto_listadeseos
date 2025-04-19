<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    // Redirección después del login
    protected $redirectTo = '/deseos';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
