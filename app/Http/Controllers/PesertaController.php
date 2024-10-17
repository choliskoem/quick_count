<?php

namespace App\Http\Controllers;

use App\Models\bagian_pemilu;
use App\Models\detail_peserta;
use App\Models\peserta;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesertaController extends Controller
{
    public function index()
    {
        return view('pages.peserta.index', [
            'peserta' => peserta::with('bagianPemilu.kabkota')->with([
                'detailPeserta' => function (Builder $builder) {
                    $builder->orderBy('posisi');
                }
            ])->get()
        ]);
    }

    public function create()
    {
        return view('pages.peserta.create', ['bagianPemilu' => bagian_pemilu::with('kabkota')->get()]);
    }

    public function createPost(Request $request)
    {
        $validated = $request->validate([
            'bagian-pemilu' => 'required',
            'no-urut' => [
                'required',
                'numeric',
                'min:1',
                'max:99',
                function (string $attribute, mixed $value, Closure $fail) use ($request) {
                    if (empty($request['bagian-pemilu'])) {
                        $fail("Silihkan pilih bagian pemilu.");
                    } else if (peserta::where('no_urut', str_pad($value, 2, '0', STR_PAD_LEFT))->where('id_bagian_pemilu', $request['bagian-pemilu'])->exists()) {
                        $fail("{$attribute} sudah ada.");
                    }
                },
            ],
            'nama-posisi-1' => 'required',
            'nama-posisi-2' => 'required'
        ]);

        DB::transaction(function () use ($validated) {
            $peserta = peserta::create([
                'no_urut' => str_pad($validated['no-urut'], 2, '0', STR_PAD_LEFT),
                'id_bagian_pemilu' => $validated['bagian-pemilu'],
            ]);
            detail_peserta::create([
                'id_peserta' => $peserta['id_peserta'],
                'nama_peserta' => $validated['nama-posisi-1'],
                'posisi' => 1,
            ]);
            detail_peserta::create([
                'id_peserta' => $peserta['id_peserta'],
                'nama_peserta' => $validated['nama-posisi-2'],
                'posisi' => 2,
            ]);
        });

        $request->session()->flash('success', 'Berhasil menambah peserta');
        return redirect(route('peserta'));
    }

    public function update($id)
    {
        return view('pages.peserta.update', [
            'bagianPemilu' => bagian_pemilu::with('kabkota')->get(),
            'peserta' => peserta::with([
                'detailPeserta' => function (Builder $builder) {
                    $builder->orderBy('posisi');
                }
            ])->find($id),
        ]);
    }

    public function updatePost(Request $request, $id)
    {
        $validated = $request->validate([
            'bagian-pemilu' => 'required',
            'no-urut' => [
                'required',
                'numeric',
                'min:1',
                'max:99',
                function (string $attribute, mixed $value, Closure $fail) use ($request, $id) {
                    if (empty($request['bagian-pemilu'])) {
                        $fail("Silihkan pilih bagian pemilu.");
                    } else if (peserta::where('no_urut', str_pad($value, 2, '0', STR_PAD_LEFT))->where('id_bagian_pemilu', $request['bagian-pemilu'])->whereNot('id_peserta', $id)->exists()) {
                        $fail("{$attribute} sudah ada.");
                    }
                },
            ],
            'nama-posisi-1' => 'required',
            'nama-posisi-2' => 'required'
        ]);

        DB::transaction(function () use ($validated, $id) {
            peserta::where('id_peserta', $id)->update([
                'no_urut' => str_pad($validated['no-urut'], 2, '0', STR_PAD_LEFT),
                'id_bagian_pemilu' => $validated['bagian-pemilu'],
            ]);
            detail_peserta::where('id_peserta', $id)->where('posisi', 1)->update([
                'nama_peserta' => $validated['nama-posisi-1'],
            ]);
            detail_peserta::where('id_peserta', $id)->where('posisi', 2)->update([
                'nama_peserta' => $validated['nama-posisi-2'],
            ]);
        });

        $request->session()->flash('success', 'Berhasil mengedit peserta');
        return redirect(route('peserta'));
    }
}
