<?php

namespace App\Http\Controllers;

use App\Enums\Role;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('users.index');
        }

        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if ($user && $user->is_blocked) {
            return back()->withErrors([
                'email' => 'Akun anda diblokir karena terlalu banyak percobaan login yang gagal. Silakan hubungi admin.',
            ]);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user->update(['failed_login_attempts' => 0]);

            $request->session()->regenerate();

            if (Auth::user()->role === Role::ADMIN->value) {
                return redirect()->intended('users');
            } else {
                return redirect()->intended('customers');
            }
        }

        if ($user) {
            $user->increment('failed_login_attempts');

            if ($user->failed_login_attempts >= 3) {
                $user->update(['is_blocked' => true]);
                return back()->withErrors([
                    'email' => 'Akun anda telah diblokir setelah 3 kali percobaan gagal. Silakan hubungi admin.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'Email atau kata sandi salah.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
