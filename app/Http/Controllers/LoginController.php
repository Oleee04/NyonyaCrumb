<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function loginBackend()
    {
        return view('backend.v_login.login', [
            'judul' => 'Login',
        ]);
    }

    public function authenticateBackend(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required'
        ]);

        // Find admin/superadmin by username
        $user = \App\Models\User::where('username', $request->username)
                ->whereIn('role', ['0', '1'])
                ->first();

        if ($user && \Illuminate\Support\Facades\Auth::attempt(['email' => $user->email, 'password' => $request->password])) {
            if (Auth::user()->status == 0) {
                Auth::logout();
                return back()->with('error', 'User belum aktif');
            }
            $request->session()->regenerate();
            return redirect()->intended(route('backend.beranda'));
        }

        return back()->with('error', 'Username atau password salah, atau akun tidak memiliki akses admin.');
    }


    public function logoutBackend()
    {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect(route('backend.login'));
    }

}
