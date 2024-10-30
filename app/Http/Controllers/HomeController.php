<?php

namespace App\Http\Controllers;

use App\Models\bagian_pemilu;
use App\Models\wilayah;
use App\Models\wilayah_pemilu;
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
            ->groupBy('p.id_peserta', 'vp.nama_peserta', 'wp.id_kabkota', 'wp.wilayah')
            // Added wp.id_kabkota and wp.wilayah
            ->get();

        $dataGroupedByKabupaten = $dataKabupaten->groupBy('id_kabkota');


        return view('pages.dashboard', compact('penggunaWilayah', 'dataGubernur', 'dataKabupaten', 'dataGubernur2', 'dataKabupaten2', 'dataGroupedByKabupaten'));
    }

    public function index2(Request $request)
    {
        $penggunaId = Auth::user()->id_pengguna;
        $idKabkota = $request->id_wilayah;
        $idDesa = $request->id_desa;

        // return $idWilayah;

        // echo $idWilayah;
        $user = Auth::user()->id_pengguna;

        $wilayah = DB::table('wilayah_pemilu as wp')
            ->leftJoin('t_pengguna_wilayah as pw', 'pw.id_kabkota', '=', 'wp.id_kabkota')
            ->whereIn('wp.id_kabkota', function ($query) {
                $query->select('id_kabkota')
                    ->from('t_pengguna_wilayah');
            })
            ->where('pw.id_pengguna', $user)
            ->get();; // Use all() instead of get() for better readability

        $results = DB::table('t_count as c')
            ->select(
                'p.id_peserta',
                'p.no_urut',
                'vp.nama_peserta',
                DB::raw('SUM(c.jumlah) as jumlah'),
                'wp.id_kabkota',
                'wp.wilayah',
                'tp.id_tps',
                'tp.tps',
                'w.id_desa',
                'w.nama_desa'
            )
            ->join('t_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->leftJoin('t_bagian_pemilu as bp', 'p.id_bagian_pemilu', '=', 'bp.id_bagian_pemilu')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->leftJoin('v_peserta as vp', 'vp.id_peserta', '=', 'p.id_peserta')
            ->leftJoin('wilayah_saksi as ws', 'ws.id_wilayah_saksi', '=', 'c.id_wilayah_saksi')
            ->leftJoin('t_wilayah as w', 'w.id_wilayah', '=', 'ws.id_wilayah')
            ->leftJoin('tps as tp', 'tp.id_tps', '=', 'ws.id_tps')
            ->where('c.status', '1')
            ->where('wp.id_kabkota', $idKabkota)
            ->where('w.id_desa', $idDesa)
            ->groupBy('p.id_peserta', 'p.no_urut', 'vp.nama_peserta', 'tp.id_tps', 'w.id_desa', 'w.nama_desa')
            ->orderBy('p.id_peserta', 'asc')
            ->orderBy('tp.tps', 'asc')
            ->get();

        // Return JSON response for AJAX request
        if ($request->ajax()) {
            return response()->json($results);
        }

        return view('pages.detail', compact('results', 'wilayah'));
    }


    public function getDesaByKabkota($id_kabkota)
    {
        // Mengambil desa berdasarkan id_kabkota
        if ($id_kabkota = 7) {
            $desas = wilayah::all(['id_provinsi', 'id_wilayah', 'id_kabkota', 'id_desa', 'nama_desa']);
        } else {
            $desas = wilayah::where('id_kabkota', $id_kabkota)->get(['id_provinsi', 'id_wilayah', 'id_kabkota', 'id_desa', 'nama_desa']);
        }


        return response()->json($desas);
    }


    public function getBagianPemiluByKabkota($id_kabkota)
    {
        // Mengambil bagian pemilu berdasarkan id_kabkota
        $bagians = bagian_pemilu::where('id_kabkota', $id_kabkota)->get(['id_kabkota', 'id_bagian_pemilu', 'label']);

        return response()->json($bagians);
    }
}
