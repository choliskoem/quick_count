<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class count extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_count';

    // No need for a primary key as the table is defined with composite keys
    // protected $primaryKey = 'your_primary_key'; // Uncomment if there's a single primary key

    // Define fillable fields
    protected $fillable = [
        'id_peserta',
        'id_wilayah_saksi',
        'jumlah',
        'status'
    ];

    // Define relationships
    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'id_peserta', 'id_peserta');
    }

    public function wilayahSaksi()
    {
        return $this->belongsTo(wilayah_saksi::class, 'id_wilayah_saksi', 'id_wilayah_saksi');
    }
}
