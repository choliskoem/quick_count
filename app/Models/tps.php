<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tps extends Model
{
    use HasFactory;
    // Define the table name
    // Define the table name
    protected $table = 'tps';

    // Set the primary key column name
    protected $primaryKey = 'id_tps';

    // Disable auto-incrementing if needed (since `id_tps` might not auto-increment)
    public $incrementing = false;

    // Specify the primary key type if not the default 'int'
    protected $keyType = 'integer';

    // Disable timestamps (if not needed)
    public $timestamps = false;

    // Define the fillable properties to allow mass assignment
    protected $fillable = [
        'id_tps',
        'tps',
    ];
}
