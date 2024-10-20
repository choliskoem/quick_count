<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_peserta extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_detail_peserta';

    // Primary key
    protected $primaryKey = 'id_detail_peserta';

    public $timestamps = false;


    // Define fillable fields
    protected $fillable = [
        'id_peserta',
        'nama_peserta',
        'posisi'
    ];

    // Define the relationship with the Peserta model
    public function peserta()
    {
        return $this->belongsTo(peserta::class, 'id_peserta', 'id_peserta');
    }
}
