<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasOtp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            // Jika pengguna belum berhasil login
            $userEmail = $request->session()->get('email');

            // Periksa apakah pengguna memiliki OTP di database
            $user = User::where('email', $userEmail)->first();

            if ($user['otp']) {
                // Jika pengguna memiliki OTP, redirect ke halaman verifikasi OTP
                return redirect()->route('otp_verification');
            }
        }
        return $next($request);
    }
}
