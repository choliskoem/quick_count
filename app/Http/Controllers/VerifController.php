<?php

namespace App\Http\Controllers;

use App\Models\file_ci_1;
use App\Models\file_papan;
use App\Models\papan;
use App\Models\quick;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VerifController extends Controller
{
    public function index(Request $request)
    {
        $results = DB::table('t_count as c')
            ->join('wilayah_saksi as ws', 'ws.id_wilayah_saksi', '=', 'c.id_wilayah_saksi')
            ->join('t_wilayah as w', 'w.id_wilayah', '=', 'ws.id_wilayah')
            ->join('tps as ps', 'ps.id_tps', '=', 'ws.id_tps')
            ->select('c.id_wilayah_saksi', 'w.nama_desa', 'ps.tps', 'c.created_at')
            ->where('status', '0')
            ->groupBy('w.nama_desa', 'ps.tps', 'c.created_at', 'c.id_wilayah_saksi')
            ->orderBy('c.created_at', 'ASC')
            ->limit(5)
            ->get();

        return view('pages.verifikasi.index', compact('results'));
    }

    public function create(Request $request)
    {
        // Ambil `id` dari URL query string
        $id = $request->query('id');
        $fileCi1 = file_ci_1::where('id_wilayah_saksi', $request->query('id'))->first();
        $filePapan = file_papan::where('id_wilayah_saksi', $request->query('id'))->first();


        // Validasi apakah `id` ada
        if (is_null($id)) {
            return redirect()->back()->withErrors('ID Wilayah Saksi tidak ditemukan. Pastikan URL sudah benar.');
        }

        // Ambil data dari tabel `t_count` dan `v_peserta`
        $results = DB::table('t_count as c')
            ->join('v_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->select('p.id_peserta', 'p.nama_peserta', 'c.jumlah')
            ->where('id_wilayah_saksi', $id)
            ->get();

        return view('pages.verifikasi.create', compact('results', 'fileCi1', 'filePapan'));
    }

    public function store(Request $request)
    {
        // Ambil `id` dari URL query string
        $idWilayahSaksi = $request->input('id_wilayah_saksi');

        // Cek apakah `idWilayahSaksi` null
        // if (is_null($idWilayahSaksi)) {
        //     return redirect()->back()->withErrors('ID Wilayah Saksi tidak ditemukan. Pastikan URL sudah benar.');
        // }

        // Ambil semua input array dari form
        $idPesertas = $request->input('id_peserta');
        $jumlahC1s = $request->input('jumlah_c1');
        $jumlahPapans = $request->input('jumlah_papan');

        // Validasi input
        if (empty($idPesertas) || empty($jumlahC1s) || empty($jumlahPapans)) {
            return redirect()->back()->withErrors('Data input tidak lengkap. Pastikan semua data diisi.');
        }

        // Iterasi untuk setiap item dalam array
        foreach ($idPesertas as $index => $idPeserta) {
            // Simpan data ke tabel `t_quick`
            quick::create([
                'id_peserta' => $idPeserta,
                'id_wilayah_saksi' => $idWilayahSaksi,
                'jumlah' => $jumlahC1s[$index],
            ]);

            // Simpan data ke tabel `t_papan`
            papan::create([
                'id_peserta' => $idPeserta,
                'id_wilayah_saksi' => $idWilayahSaksi,
                'jumlah' => $jumlahPapans[$index],
            ]);

            \App\Models\count::where('id_peserta', $idPeserta)
                ->where('id_wilayah_saksi', $idWilayahSaksi)
                ->update(['status' => '1']);
        }

        // Redirect atau return response
        return redirect()->route('verif.index')->with('success', 'Data Berhasil Ditambahkan.');
    }
}
