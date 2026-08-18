<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

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

        $this->middleware("guest:$guard")->except('logout');
        $this->middleware($guard)->only('logout');
    }

    protected function guard()
    {
        return Auth::guard($this->getContext());
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
