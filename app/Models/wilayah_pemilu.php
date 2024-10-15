<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wilayah_pemilu extends Model
{
    use HasFactory;

    protected $table = 'wilayah_pemilu';

    protected $primaryKey = 'id_kabkota';

    protected $fillable = [
        'wilayah',
    ];
}
