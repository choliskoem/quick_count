<?php

namespace App\Http\Controllers;

use App\Models\level;
use App\Models\pengguna;
use App\Models\pengguna_wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Ramsey\Uuid\Uuid;

class UserController extends Controller
{

    public function index()
    {
        $result = DB::table('t_pengguna as p')
            ->leftJoin('t_level as l', 'p.id_level', '=', 'l.id_level')
            ->leftJoin('t_pengguna_wilayah as pw', 'pw.id_pengguna', '=', 'p.id_pengguna')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'pw.id_kabkota')
            ->select('p.nama', 'p.username', 'wp.wilayah')
            ->where('p.id_level', '!=', '1')
            ->paginate(10);
        return  view('pages.user.index', compact('result'));
    }

    public function create()
    {
        $result = DB::table('t_bagian_pemilu as bp')
            ->join('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->whereIn('bp.id_bagian_pemilu', function ($query) {
                $query->select('id_bagian_pemilu')
                    ->from('t_peserta');
            })

            ->select('wp.id_kabkota', 'wp.wilayah')
            ->get();

        return  view('pages.user.create', compact('result'));
    }


    public function store(Request $request)
    {
        $uuid = Uuid::uuid4()->toString();
        $pengguna = new pengguna();
        $pengguna->id_pengguna = $uuid; // Generate your ID as needed
        $pengguna->nama = $request->name;
        $pengguna->username = $request->username;
        $pengguna->password = Hash::make($request->password);
        $pengguna->id_level = '2';


        if ($pengguna->save()) {
            foreach ($request->id_kabkota as $kabkota) {
                $wilayah = new pengguna_wilayah();
                $wilayah->kd_pengguna_wilayah = Str::uuid();
                $wilayah->id_kabkota = $kabkota;
                $wilayah->id_pengguna = $uuid;
                $wilayah->save();
            }
        }
        //



        return redirect()->route('user.index')->with('success', 'Akun Berhasil Dibuat.');
    }
}
