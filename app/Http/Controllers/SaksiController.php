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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SaksiController extends Controller
{
    public function index(Request $request)
    {
        // $result = DB::table('wilayah_saksi as ws')
        //     ->when($request->input('name'), function ($query, $name) {
        //         return $query->where('s.nama_saksi', 'like', '%' . $name . '%');
        //     })
        //     ->leftJoin('saksi as s', 's.kd_saksi', '=', 'ws.kd_saksi')
        //     ->leftJoin('t_wilayah as tw', 'tw.id_wilayah', '=', 'ws.id_wilayah')
        //     ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'ws.id_kabkota')
        //     ->leftJoin('tps as tp', 'tp.id_tps', '=', 'ws.id_tps')
        //     ->select(
        //         's.nama_saksi',
        //         's.no_hp',
        //         DB::raw("GROUP_CONCAT(tp.tps ORDER BY tp.tps ASC SEPARATOR ' , ') as tps_list"),
        //         'wp.wilayah',
        //         'tw.nama_kecamatan',
        //         'tw.nama_desa'
        //     )
        //     ->groupBy('s.nama_saksi', 's.no_hp', 'ws.id_kabkota', 'wp.wilayah', 'tw.nama_kecamatan', 'tw.nama_desa')
        //     ->paginate(10);
        $id_pengguna = Auth::user()->id_pengguna; // Pastikan id_pengguna diambil dari request

        $result = DB::table('wilayah_saksi as ws')
            ->leftJoin('saksi as s', 's.kd_saksi', '=', 'ws.kd_saksi')
            ->leftJoin('t_wilayah as tw', 'tw.id_wilayah', '=', 'ws.id_wilayah')
            ->leftJoin('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'ws.id_kabkota')
            ->leftJoin('tps as tp', 'tp.id_tps', '=', 'ws.id_tps')
            ->leftJoin('t_pengguna_wilayah as pw', 'pw.id_kabkota', '=', 'wp.id_kabkota')
            ->whereIn('pw.id_kabkota', function ($query) use ($id_pengguna) {
                $query->select('id_kabkota')
                    ->from('t_pengguna_wilayah')
                    ->where('id_pengguna', $id_pengguna); // Gunakan parameter binding
            })
            ->groupBy(
                // 'ws.id_wilayah_saksi',
                'tw.id_wilayah',
                's.nama_saksi',
                's.no_hp',
                'ws.id_kabkota',
                'wp.wilayah',
                'tw.nama_kecamatan',
                'tw.nama_desa'
            )
            ->select(
                // 'ws.id_wilayah_saksi',
                // 'tw.id_wilayah',
                'wp.id_kabkota',
                'tw.id_wilayah',
                's.kd_saksi',
                's.nama_saksi',
                's.no_hp',
                DB::raw("GROUP_CONCAT(DISTINCT tp.tps ORDER BY tp.tps ASC SEPARATOR ' , ') AS tps_list"),
                'wp.wilayah',
                'tw.nama_kecamatan',
                'tw.nama_desa'
            )
            ->paginate(10);
        return view('pages.saksi.index', compact('result'));
    }
    public function create()
    {

        $wilayah = $results = DB::table('t_bagian_pemilu as bp')
            ->join('wilayah_pemilu as wp', 'wp.id_kabkota', '=', 'bp.id_kabkota')
            ->whereIn('bp.id_bagian_pemilu', function ($query) {
                $query->select('id_bagian_pemilu')
                    ->from('t_peserta');
            })
            ->where('wp.id_kabkota', '!=', '7')
            ->select('wp.id_kabkota', 'wp.wilayah')
            ->get();

        $tpsList = tps::all();

        return view('pages.saksi.create', compact('wilayah', 'tpsList'));
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
            return redirect()->route('saksi.index')->with('success', 'Saksi Berhasil Ditambahkan.');
        }

        // Redirect with error message if save fails
        return redirect()->back()->with('error', 'Failed to add saksi.');
    }


    public function create2(Request $request)
    {
        $saksiList = Saksi::all();

        // $wilayah = $results = DB::table('wilayah_pemilu')
        //     ->where('id_kabkota', '!=', '7')
        //     ->where('id_kabkota', '!=', '0')
        //     ->get();

        $kabkotaId = $request->session()->get('pengguna_wilayah.kabkota_id');

        $id3 = $request->query('id3');

        $wilayah =  $results = DB::table('wilayah_pemilu')
            ->whereIn('id_kabkota', function ($query) {
                $query->select('id_kabkota')
                    ->from('wilayah_saksi');
            })
            ->where('id_kabkota', $kabkotaId)
            ->where('id_kabkota', '!=', '0')
            // ->where('id_kabkota', '!=', '7')
            ->get();

        $tpsList = Tps::whereNotIn('id_tps', function ($query) use ($id3) {
            $query->select('id_tps')
                ->from('wilayah_saksi')
                ->where('kd_saksi', $id3);
        })->get();

        return view('pages.saksi.create2', compact('saksiList',  'wilayah', 'tpsList'));
    }
    public function getNoHp($kd_saksi)
    {
        // Mencari data saksi berdasarkan kd_saksi
        $saksi = Saksi::where('kd_saksi', $kd_saksi)->first();

        // Jika saksi ditemukan, kembalikan data no_hp, jika tidak, kembalikan string kosong
        return response()->json(['no_hp' => $saksi ? $saksi->no_hp : '']);
    }




    public function store2(Request $request)
    {
        // Validate that required fields are provided
        // $request->validate([
        //     'id_kabkota' => 'required|array',
        //     'tps' => 'required|array',
        //     'kd_saksi' => 'required' // Ensure kd_saksi is selected from the dropdown
        // ]);

        // try {
        // Use the selected kd_saksi from the dropdown
        $kdSaksi = $request->kd_saksi;
        $saved  = [];

        // Save wilayah_saksi with the corresponding relationship
        // foreach ($request->id_kabkota as $kabkota_id) {
        foreach ($request->tps as $tps_id) {
            $wilayahSaksi = new wilayah_saksi();
            $wilayahSaksi->id_wilayah_saksi = Str::uuid();
            $wilayahSaksi->id_kabkota = $request->id_kabkota;
            $wilayahSaksi->id_wilayah = $request->id_wilayah;
            $wilayahSaksi->kd_saksi = $kdSaksi; // Use the selected kd_saksi
            $wilayahSaksi->id_tps = $tps_id;

            // return $wilayahSaksi;
            $wilayahSaksi->save();
            // return     $saved[] = $wilayahSaksi->toArray();
        }
        // }


        // Redirect with success message
        return redirect()->route('saksi.index')->with('success', 'Saksi Berhasil Ditambahkan.');
        // } catch (\Exception $e) {
        //     // Log error and redirect with an error message
        //     // \Log::error('Failed to save saksi: ' . $e->getMessage());
        //     return redirect()->back()->with('error', 'Failed to add saksi.');
        // }
    }


    public function show($id)
    {
        // Retrieve the specific `Saksi` record by ID and pass it to the view.
        $saksi = Saksi::findOrFail($id);
        return view('saksi.show', compact('saksi'));
    }



    public function getDesaKabkota($id_kabkota)
    {
        // Mengambil desa berdasarkan id_kabkota
        if ($id_kabkota == '7') {
            $desasaksi = wilayah::all(['id_provinsi', 'id_wilayah', 'id_kabkota', 'id_desa', 'nama_desa']);
        } else {
            $desasaksi = wilayah::where('id_kabkota', $id_kabkota)->get(['id_provinsi', 'id_wilayah', 'id_kabkota', 'id_desa', 'nama_desa']);
        }
        // $desasaksi = wilayah::where('id_kabkota', $id_kabkota)->get(['id_wilayah', 'id_kabkota', 'id_desa', 'nama_desa']);x
        return response()->json($desasaksi);
    }

    public function getBagianPemiluKabkota($id_kabkota)
    {
        // Mengambil bagian pemilu berdasarkan id_kabkota
        $bagiansaksi = bagian_pemilu::where('id_kabkota', $id_kabkota)->get(['id_kabkota', 'id_bagian_pemilu', 'label']);

        return response()->json($bagiansaksi);
    }
}
