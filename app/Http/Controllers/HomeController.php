<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $data = DB::select("
        SELECT c.id_peserta,
               GROUP_CONCAT(DISTINCT dp.nama_peserta ORDER BY dp.posisi SEPARATOR ' & ') AS nama_peserta
        FROM t_count c
        LEFT JOIN t_peserta p ON c.id_peserta = p.id_peserta
        LEFT JOIN t_detail_peserta dp ON dp.id_peserta = p.id_peserta
        WHERE p.id_bagian_pemilu = '1'
        GROUP BY c.id_peserta
    ");


        $data2 = DB::select("
        SELECT p.id_peserta, SUM(c.jumlah) as jumlah FROM `t_count` c LEFT JOIN t_peserta p on p.id_peserta= c.id_peserta WHERE p.id_bagian_pemilu ='1' and c.status = '1' GROUP BY p.id_peserta;

        ");

        $data3 = DB::select("
        SELECT p.id_peserta, SUM(c.jumlah) as jumlah FROM `t_count` c LEFT JOIN t_peserta p on p.id_peserta= c.id_peserta WHERE p.id_bagian_pemilu ='1' and c.status = '0' GROUP BY p.id_peserta;

        ");
        // Prepare the labels and data for Chart.js
        $labels = [];
        $verifData = []; // Replace with your actual data for "Suara verif"
        $belumverifData = []; // Replace with your actual data for "Suara Belum verif"

        foreach ($data as $row) {
            $labels[] = $row->nama_peserta;
            // Populate verifData and belumverifData based on your logic
        }

        foreach ($data2 as $row) {
            $verifData[] = $row->jumlah;
            // Populate masukData and belumMasukData based on your logic
        }

        foreach ($data3 as $row) {
            $belumverifData[] = $row->jumlah;
            // Populate masukData and belumMasukData based on your logic
        }




        $datakabkota = DB::select("
        SELECT c.id_peserta,
               GROUP_CONCAT(DISTINCT dp.nama_peserta ORDER BY dp.posisi SEPARATOR ' & ') AS nama_peserta
        FROM t_count c
        LEFT JOIN t_peserta p ON c.id_peserta = p.id_peserta
        LEFT JOIN t_detail_peserta dp ON dp.id_peserta = p.id_peserta
        WHERE p.id_bagian_pemilu = '4'
        GROUP BY c.id_peserta
    ");

        $datakabkota2 = DB::select("
        SELECT p.id_peserta, SUM(c.jumlah) as jumlah FROM `t_count` c LEFT JOIN t_peserta p on p.id_peserta= c.id_peserta WHERE p.id_bagian_pemilu ='4' and c.status = '1' GROUP BY p.id_peserta;

        ");

        $datakabkota3 = DB::select("
        SELECT p.id_peserta, SUM(c.jumlah) as jumlah FROM `t_count` c LEFT JOIN t_peserta p on p.id_peserta= c.id_peserta WHERE p.id_bagian_pemilu ='4' and c.status = '0' GROUP BY p.id_peserta;

        ");



        // Prepare the labels and data for Chart.js
        $labelskabkota = [];
        $masukVerifkabkota = []; // Replace with your actual data for "Suara Masuk"
        $belumVerifkabkota = []; // Replace with your actual data for "Suara Belum Masuk"

        foreach ($datakabkota as $row) {
            $labelskabkota[] = $row->nama_peserta;
            // Populate masukData and belumMasukData based on your logic
        }

        foreach ($datakabkota2 as $row) {
            $masukVerifkabkota[] = $row->jumlah;
            // Populate masukData and belumMasukData based on your logic
        }
        foreach ($datakabkota3 as $row) {
            $belumVerifkabkota[] = $row->jumlah;
            // Populate masukData and belumMasukData based on your logic
        }

        // return $labels;
        return view('pages.dashboard', compact('labels', 'labelskabkota', 'verifData', 'belumverifData', 'masukVerifkabkota', 'belumVerifkabkota'));
    }
}
