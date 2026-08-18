<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    use VerifiesEmails;

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
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    protected function guard()
    {
        return Auth::guard($this->getContext());
    }
}
