<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected function getContext(): string
    {
        return request()->segment(1) ?: 'admin';
    }

    protected function redirectTo(): string
    {
        return '/'.$this->getContext();
    }

    public function broker()
    {
        return Password::broker($this->getContext().'s');
    }

    protected function guard()
    {
        return Auth::guard($this->getContext());
    }
}
