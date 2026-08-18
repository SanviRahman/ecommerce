<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $guard = request()->segment(1) ?: 'admin';
        $this->middleware("guest:$guard");
    }

    public function broker()
    {
        $context = request()->segment(1) ?: 'admin';
        return Password::broker($context.'s');
    }
}
