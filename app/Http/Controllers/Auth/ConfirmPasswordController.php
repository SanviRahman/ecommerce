<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;
use Illuminate\Support\Facades\Auth;

class ConfirmPasswordController extends Controller
{
    use ConfirmsPasswords;

    protected function getContext(): string
    {
        return request()->segment(1) ?: 'admin';
    }

    protected function redirectTo(): string
    {
        return '/'.$this->getContext();
    }

    public function __construct()
    {
        $guard = $this->getContext();
        $this->middleware("auth:$guard");
    }

    protected function guard()
    {
        return Auth::guard($this->getContext());
    }
}
