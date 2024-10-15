<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class level extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_level';

    // Primary key
    protected $primaryKey = 'id_level';

    // Define fillable fields
    protected $fillable = [
        'level',
        // 'id_bagian_pemilu'
    ];
}
