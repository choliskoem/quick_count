<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

}
