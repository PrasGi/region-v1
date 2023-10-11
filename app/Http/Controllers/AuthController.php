<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    private $userModel;
    public function __construct()
    {
        $this->userModel = new User();
    }
    public function loginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (auth()->attempt($validate)) {
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors('failed', 'Email or password wrong');
    }

    public function registerForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required'
        ]);

        $validate['password'] = bcrypt($validate['password']);
        $validate['role_id'] = 2;

        if ($user = $this->userModel->create($validate)) {
            auth()->loginUsingId($user->id);
            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors('failed', 'Register failed');
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('login.form');
    }
}
