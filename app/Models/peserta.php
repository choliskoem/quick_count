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

    // Define fillable fields
    protected $fillable = [
        'no_urut',
        'id_bagian_pemilu'
    ];

    // Define the relationship with the BagianPemilu model
    public function bagianPemilu()
    {
        return $this->belongsTo(bagian_pemilu::class, 'id_bagian_pemilu', 'id_bagian_pemilu');
    }
}