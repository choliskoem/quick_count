<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class saksi extends Model
{
    use HasFactory;
    // Define the table name
    protected $table = 'saksi';

    // Set the primary key column name
    protected $primaryKey = 'kd_saksi';

    // Disable auto-incrementing as it's a string primary key
    public $incrementing = false;

    // Specify the primary key type
    protected $keyType = 'string';

    // Disable timestamps (if not needed)
    public $timestamps = false;

    // Define the fillable properties to allow mass assignment
    protected $fillable = [
        'kd_saksi',
        'nama_saksi',
        'no_hp',
    ];
}
