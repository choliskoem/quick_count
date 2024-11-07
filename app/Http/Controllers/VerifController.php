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

        $kabkotaId = $request->session()->get('pengguna_wilayah.kabkota_id');


        $results = DB::table('wilayah_saksi as w')
            ->leftJoin('t_wilayah as wl', 'wl.id_wilayah', '=', 'w.id_wilayah')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'w.id_kabkota')
            ->leftJoin('tps as t', 't.id_tps', '=', 'w.id_tps')
            ->join('t_count as c', 'c.id_wilayah_saksi', '=', 'w.id_wilayah_saksi')
            ->where('w.id_kabkota', $kabkotaId)
            ->where('c.status', '0')
            ->select(
                'w.id_kabkota',
                'w.id_wilayah_saksi',
                DB::raw('CONCAT(wl.nama_desa, " - ", wp.wilayah) AS nama_desa'),
                't.tps',
                'c.created_at'

            )
            ->groupBy(
                'w.id_wilayah_saksi',
                'c.created_at'
            )
            ->orderBy('wl.id_wilayah')
            ->orderBy('w.id_tps')
            ->limit(5)
            ->get();

        return view('pages.verifikasi.index', compact('results'));
    }

    public function create(Request $request)
    {
        // Ambil `id` dari URL query string
        $id = $request->query('id');
        $id2 = $request->query('id2');


        // Validasi apakah `id` ada
        if (is_null($id)) {
            return redirect()->back()->withErrors('ID Wilayah Saksi tidak ditemukan. Pastikan URL sudah benar.');
        }

        // Ambil data dari file_ci_1 dan file_papan
        $fileCi1 = file_ci_1::where('id_wilayah_saksi', $id)->first();
        $filePapan = file_papan::where('id_wilayah_saksi', $id)->first();

        // Check if the files are null and handle accordingly
        $fileCi1Url = $fileCi1 ? $fileCi1->url_file : null;
        $filePapanUrl = $filePapan ? $filePapan->url_file : null;

        // Ambil data dari tabel `t_count` dan `v_peserta`
        $results = DB::table('t_count as c')
            ->select(
                'p.id_peserta',
                'vp.nama_peserta',
                DB::raw('SUM(c.jumlah) AS jumlah'),
                'wp.id_kabkota',
                'wp.wilayah'
            )
            ->join('t_peserta as p', 'p.id_peserta', '=', 'c.id_peserta')
            ->leftJoin('t_bagian_pemilu as bp', 'p.id_bagian_pemilu', '=', 'bp.id_bagian_pemilu')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->join('v_peserta as vp', 'vp.id_peserta', '=', 'p.id_peserta')
            ->where('c.id_wilayah_saksi', $id)
            ->where('wp.id_kabkota', $id2)
            ->groupBy('p.id_peserta', 'vp.nama_peserta', 'wp.id_kabkota', 'wp.wilayah')
            ->get();

        return view('pages.verifikasi.create', compact('results', 'fileCi1Url', 'filePapanUrl'));
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
