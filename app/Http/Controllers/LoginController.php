<?php

namespace App\Http\Controllers;

use App\Models\pengguna;
use App\Models\pengguna_wilayah;
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
        // Validasi kredensial
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        // Cek apakah login berhasil menggunakan kredensial yang diberikan
        if (Auth::attempt($credentials)) {
            // Regenerasi session untuk mencegah session fixation
            $request->session()->regenerate();

            // Ambil pengguna yang sedang login
            $user = Auth::user();

            // Ambil data pengguna_wilayah berdasarkan id_pengguna
            $penggunaWilayah = pengguna_wilayah::where('id_pengguna', $user->id_pengguna)->first();

            if ($penggunaWilayah) {
                // Menyimpan data pengguna_wilayah ke dalam session
                $request->session()->put('pengguna_wilayah.id', $penggunaWilayah->id_pengguna);
                $request->session()->put('pengguna_wilayah.kabkota_id', $penggunaWilayah->id_kabkota);

                // Jika Anda ingin menyimpan lebih banyak data dari hubungan lainnya, seperti wilayah atau pengguna
                $request->session()->put('pengguna_wilayah.wilayah', $penggunaWilayah->wilayahPemilu->wilayah ?? null); // Asumsi relasi 'wilayahPemilu' ada
            }

            // Menanggapi dengan response sukses
            return response()->json([
                'success' => true,
                'message' => 'Login berhasil'
            ]);
        } else {
            // Jika login gagal
            return response()->json([
                'success' => false,
                'message' => 'Username atau Password Salah'
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
