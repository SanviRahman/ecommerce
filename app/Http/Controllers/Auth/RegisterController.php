<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

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
        $this->middleware('guest:admin');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function create(array $data): Admin
    {
        return Admin::create([
            'name' => $data['name'],
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'status' => true,
        ]);
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
