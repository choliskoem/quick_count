<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wilayah extends Model
{
    use HasFactory;

    protected $table = 'wilayah';

    protected $primaryKey = 'id_wilayah';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'id_provinsi',
        'id_kabkota',
        'id_kecamatan',
        'id_desa',
        'nama_provinsi',
        'nama_kabkota',
        'nama_kecamatan',
        'nama_desa',
    ];
}
