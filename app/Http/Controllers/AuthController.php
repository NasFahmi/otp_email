<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function indexLogin()
    {
        return view('login');
    }

    // Menampilkan halaman registrasi
    public function indexRegister()
    {
        return view('register');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi data masukan
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        // Coba autentikasi pengguna
        if (Auth::validate($credentials)) {
            // jika ini sudah terpenuhi maka bisadikatakan sudah login
            // Autentikasi berhasil, kirim OTP dan redirect ke halaman verifikasi OTP
            $this->sendOtp($request); 
            session()->put('email', $request->email);
            return redirect()->route('otp_verification');
        } else {
            // Autentikasi gagal, kembali ke halaman login dengan pesan kesalahan
            return back()->withInput()->withErrors(['email' => 'Email atau password salah']);
        }
    }

    // Proses registrasi
    public function register(Request $request)
    {
        // Validasi data masukan
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // // Autentikasi user setelah registrasi
        // auth()->login($user);

        // Redirect ke halaman yang diinginkan
        return redirect()->route('loginView');
    }

    // Logout
    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }

    // Mengirim OTP
    public function sendOtp(Request $request)
    {
        // Generate OTP
        $user = User::where('email', $request->email)->first();
        // dd($user);
        $this->sendingOtp($user);
        
        return response()->json(['message' => 'User not found'], 404);
    }

    // Menampilkan halaman verifikasi OTP
    public function otpVerification(){
        $email = session()->get('email'); 
        $user = User::where('email', $email)->first();
        // dd($user);
        $otp_expires_at = $user['otp_expired_at'];

        return view('otpverification', compact('email','otp_expires_at'));
    }

    public function verifyOtp(Request $request){
        $email = session()->get('email');
        $user = User::where('email', $email)->first();
        $otpSubmit = $request->otp;
        
        // Check if OTP is correct and not expired
        if ($user && $user->otp_code == $otpSubmit && $user->otp_expired_at > now()) {
            auth()->login($user);
            session()->forget('email');
            return redirect()->route('dashboard.index');
        } else {
            return response()->json(['message' => 'OTP salah atau telah kadaluarsa']);
        }
    }
    
    public function resendOtp(){

        $email = session()->get('email');
        $user = User::where('email', $email)->first();
        $this->sendingOtp($user);
    }
    public function sendingOtp($user)
    {
        $otp = rand(100000, 999999);
        $user->update([
            'otp_code'=>$otp,
            'otp_expired_at' => Carbon::now()->addMinutes(2) // Corrected method name
        ]);
        // Send OTP via email 
        // Mail::send('email.otp', ['otp' => $otp], function ($message) use ($request) {
        //     $message->to($request->input('email'))->subject('Your OTP');
        // });
        return response()->json(['message' => 'OTP sent successfully']);
    }
}
