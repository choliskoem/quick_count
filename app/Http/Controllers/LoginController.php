<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        // $qr = DB::table('qrcodes')
        //     ->select('id')
        //     ->first();

        // $qrCode = QrCode::size(100)->generate($qr->id);
        return view('pages.auth.login');
    }


    public function proses_login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // $user = Auth::user();

            // if ($user->status !== 'Aktif') {
            //     Auth::logout();
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Akun Anda belum aktif.'
            //     ]);
            // }

            $request->session()->regenerate();
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username Atau Password Salah'
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/');
    // }
}
