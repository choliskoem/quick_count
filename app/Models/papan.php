<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class papan extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_papan';

    // No need for a primary key as the table is defined with composite keys
    // protected $primaryKey = 'your_primary_key'; // Uncomment if there's a single primary key

    public $timestamps = false;
    // Define fillable fields
    protected $fillable = [
        'id_peserta',
        'id_wilayah_saksi',
        'jumlah',

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
