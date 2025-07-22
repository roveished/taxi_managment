<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
    
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
    
            $user = Auth::user();
    
            if ($user->status !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'username' => 'حساب کاربری شما غیر فعال است.',
                ])->onlyInput('username');
            }
    
            if ($user->role === 'taxi_management') {
                return redirect()->intended('/home');
            } elseif ($user->role === 'inspector') {
                return redirect()->intended('/check');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'username' => 'نقش کاربری نامعتبر است.',
                ]);
            }
        }
    
        return back()->withErrors([
            'username' => 'نام کاربری یا رمز عبور اشتباه است.',
        ])->onlyInput('username');
    }
    

}