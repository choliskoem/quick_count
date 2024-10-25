<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $pengguna = Auth::user()->id_pengguna;

        // Get user-related region data
        $penggunaWilayah = DB::table('t_pengguna_wilayah')
            ->where('id_pengguna', $pengguna)
            ->get();


        $dataGubernur = DB::table('t_count as c')
            ->select('p.id_peserta', 'vp.nama_peserta', DB::raw('SUM(c.jumlah) as jumlah'), 'wp.id_kabkota', 'wp.wilayah')
            ->join('t_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->leftJoin('t_bagian_pemilu as bp', 'p.id_bagian_pemilu', '=', 'bp.id_bagian_pemilu')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->join('v_peserta as vp', 'vp.id_peserta', '=', 'p.id_peserta')
            ->where('wp.id_kabkota', 7)
            ->where('c.status', '1')
            ->groupBy('p.id_peserta', 'vp.nama_peserta')
            ->get();

        $dataGubernur2 = DB::table('t_count as c')
            ->select('p.id_peserta', 'vp.nama_peserta', DB::raw('SUM(c.jumlah) as jumlah'), 'wp.id_kabkota', 'wp.wilayah')
            ->join('t_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->leftJoin('t_bagian_pemilu as bp', 'p.id_bagian_pemilu', '=', 'bp.id_bagian_pemilu')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->join('v_peserta as vp', 'vp.id_peserta', '=', 'p.id_peserta')
            ->where('wp.id_kabkota', 7)
            ->where('c.status', '0')
            ->groupBy('p.id_peserta', 'vp.nama_peserta')
            ->get();

        $dataKabupaten = DB::table('t_count as c')
            ->select('p.id_peserta', 'vp.nama_peserta', DB::raw('SUM(c.jumlah) as jumlah'), 'wp.id_kabkota', 'wp.wilayah')
            ->join('t_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->leftJoin('t_bagian_pemilu as bp', 'p.id_bagian_pemilu', '=', 'bp.id_bagian_pemilu')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->join('v_peserta as vp', 'vp.id_peserta', '=', 'p.id_peserta')
            ->leftJoin('t_pengguna_wilayah as pw', 'wp.id_kabkota', '=', 'pw.id_kabkota')
            ->where('wp.id_kabkota', '!=', 7)
            ->where('c.status', '1')
            ->where('pw.id_pengguna', Auth::user()->id_pengguna)
            ->groupBy('p.id_peserta', 'vp.nama_peserta', 'wp.id_kabkota', 'wp.wilayah')
            ->get();

        $dataKabupaten2 = DB::table('t_count as c')
            ->select('p.id_peserta', 'vp.nama_peserta', DB::raw('SUM(c.jumlah) as jumlah'), 'wp.id_kabkota', 'wp.wilayah')
            ->join('t_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->leftJoin('t_bagian_pemilu as bp', 'p.id_bagian_pemilu', '=', 'bp.id_bagian_pemilu')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->join('v_peserta as vp', 'vp.id_peserta', '=', 'p.id_peserta')
            ->leftJoin('t_pengguna_wilayah as pw', 'wp.id_kabkota', '=', 'pw.id_kabkota')
            ->where('wp.id_kabkota', '!=', 7)
            ->where('c.status', '0')
            ->where('pw.id_pengguna', Auth::user()->id_pengguna)
            ->groupBy('p.id_peserta', 'vp.nama_peserta', 'wp.id_kabkota', 'wp.wilayah') // Added wp.id_kabkota and wp.wilayah
            ->get();

        $dataGroupedByKabupaten = $dataKabupaten->groupBy('id_kabkota');


        return view('pages.dashboard', compact('penggunaWilayah', 'dataGubernur', 'dataKabupaten', 'dataGubernur2', 'dataKabupaten2', 'dataGroupedByKabupaten'));
    }
}
