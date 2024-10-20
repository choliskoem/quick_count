<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class peserta extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_peserta';

    // Primary key
    protected $primaryKey = 'id_peserta';

    // Disable auto-incrementing as it's a string primary key
    public $incrementing = true;

    public $timestamps = false;

    // Define fillable fields
    protected $fillable = [
        'id_peserta',
        'no_urut',
        'id_bagian_pemilu'
    ];

    // Define the relationship with the BagianPemilu model
    public function bagianPemilu()
    {
        return $this->belongsTo(bagian_pemilu::class, 'id_bagian_pemilu', 'id_bagian_pemilu');
    }

    public function detailPeserta()
    {
        return $this->hasMany(detail_peserta::class, 'id_peserta', 'id_peserta');
    }
}
