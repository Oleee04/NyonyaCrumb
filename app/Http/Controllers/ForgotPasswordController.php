<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('v_customer.passwords.forgot');
    }

    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $email = $request->email;
        // Generate 6-digit OTP
        $otp = rand(100000, 999999);

        // Save to password_reset_tokens table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => $otp,
                'created_at' => Carbon::now()
            ]
        );

        // Send Email
        Mail::to($email)->send(new OtpMail($otp));

        // Store email in session to verify later
        session(['reset_email' => $email]);

        return redirect()->route('auth.verify-otp.form')->with('status', 'Kode OTP telah dikirim ke email Anda.');
    }

    public function showOtpForm()
    {
        if (!session('reset_email')) {
            return redirect()->route('auth.forgot-password.form')->withErrors(['email' => 'Silakan masukkan email Anda terlebih dahulu.']);
        }
        return view('v_customer.passwords.otp');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|numeric|digits:6']);
        $email = session('reset_email');

        if (!$email) {
            return redirect()->route('auth.forgot-password.form')->withErrors(['email' => 'Sesi telah habis. Silakan ulangi proses.']);
        }

        $record = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'OTP tidak ditemukan atau sudah tidak berlaku.']);
        }

        if ($record->token != $request->otp) {
            return back()->withErrors(['otp' => 'Kode OTP salah.']);
        }

        // Check if OTP is expired (e.g., 15 minutes)
        if (Carbon::parse($record->created_at)->addMinutes(15)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $email)->delete();
            return redirect()->route('auth.forgot-password.form')->withErrors(['email' => 'Kode OTP telah kedaluwarsa. Silakan minta kode baru.']);
        }

        // OTP is valid
        session(['otp_verified' => true]);

        return redirect()->route('auth.reset-password.form');
    }

    public function showResetForm()
    {
        if (!session('otp_verified') || !session('reset_email')) {
            return redirect()->route('auth.forgot-password.form');
        }
        return view('v_customer.passwords.reset');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $email = session('reset_email');

        if (!session('otp_verified') || !$email) {
            return redirect()->route('auth.forgot-password.form');
        }

        // Update password
        User::where('email', $email)->update([
            'password' => Hash::make($request->password)
        ]);

        // Clean up
        DB::table('password_reset_tokens')->where('email', $email)->delete();
        session()->forget(['reset_email', 'otp_verified']);

        return redirect()->route('auth.login')->with('status', 'Password berhasil diubah. Silakan masuk dengan password baru.');
    }
}
