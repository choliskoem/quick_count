<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengguna_wilayah extends Model
{
    protected $table = 't_pengguna_wilayah';

    // Primary key
    protected $primaryKey = 'kd_pengguna_wilayah';

    public $timestamps = false;


    // Define fillable fields
    protected $fillable = [
        'id_pengguna',
        'id_kabkota'
    ];

    public function wilayahPemilu()
    {
        return $this->belongsTo(wilayah_pemilu::class, 'id_kabkota', 'id_kabkota');
    }

    public function pengguna()
    {
        return $this->belongsTo(pengguna::class, 'id_pengguna', 'id_pengguna');
    }
}
