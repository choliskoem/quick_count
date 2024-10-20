<?php

namespace App\Http\Controllers;

use App\Models\bagian_pemilu;
use App\Models\saksi;
use App\Models\tps;
use App\Models\wilayah;
use Illuminate\Support\Str;
use App\Models\wilayah_pemilu;
use App\Models\wilayah_saksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaksiController extends Controller
{
    public function index()
    {
        $wilayah = $results = DB::table('wilayah_pemilu')
            ->where('id_kabkota', '!=', '7')
            ->get();

        $tpsList = tps::all();

        return view('pages.saksi.index', compact('wilayah', 'tpsList'));
    }




    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make(
            $request->all(),
            [
                'nama_saksi' => 'required|string|max:255',
                'no_hp' => 'required|string|max:15|unique:saksi,no_hp',
                'id_wilayah' => 'required|string',
                'id_desa' => 'required|string',
                'id_kabkota' => 'required|array',
                'id_kabkota.*' => 'string', // Validate each kabkota ID as a string
                'tps' => 'required|array',
                'tps.*' => 'string', // Validate each TPS ID as a string
            ],

            [
                'no_hp.unique' => 'Nomor HP sudah terdaftar. Silakan gunakan nomor lain.', // Custom error message
            ]
        );


        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new saksi instance
        $saksi = new saksi();
        $saksi->kd_saksi = Str::uuid(); // Generate your ID as needed
        $saksi->nama_saksi = $request->nama_saksi;
        $saksi->no_hp = $request->no_hp;

        // Save the saksi
        if ($saksi->save()) {
            // Save wilayah_saksi with the corresponding relationship
            foreach ($request->id_kabkota as $kabkota_id) {
                foreach ($request->tps as $tps_id) {
                    $wilayahSaksi = new wilayah_saksi();
                    $wilayahSaksi->id_wilayah_saksi = Str::uuid();
                    $wilayahSaksi->id_kabkota = $kabkota_id; // Use the current kabkota ID
                    $wilayahSaksi->id_wilayah = $request->id_wilayah;
                    $wilayahSaksi->kd_saksi = $saksi->kd_saksi; // Use the ID of the saved saksi
                    // $wilayahSaksi->id_desa = $request->id_desa; // Assuming you want to save id_desa as well
                    $wilayahSaksi->id_tps = $tps_id;
                    $wilayahSaksi->save();
                }
            }

            // Redirect with success message
            return redirect()->back()->with('success', 'Saksi Berhasil Ditambahkan.');
        }

        // Redirect with error message if save fails
        return redirect()->back()->with('error', 'Failed to add saksi.');
    }


    public function getDesaByKabkota($id_kabkota)
    {
        // Mengambil desa berdasarkan id_kabkota
        $desas = wilayah::where('id_kabkota', $id_kabkota)->get(['id_wilayah', 'id_kabkota', 'id_desa', 'nama_desa']);

        return response()->json($desas);
    }

    public function getBagianPemiluByKabkota($id_kabkota)
    {
        // Mengambil bagian pemilu berdasarkan id_kabkota
        $bagians = bagian_pemilu::where('id_kabkota', $id_kabkota)->get(['id_kabkota', 'id_bagian_pemilu', 'label']);

        return response()->json($bagians);
    }
}
