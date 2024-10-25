<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pengguna extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_pengguna';

    // Primary key
    protected $primaryKey = 'id_pengguna';

    public $timestamps = false;


    // Define fillable fields
    protected $fillable = [
        'nama',
        'username',
        'password',
        'id_level'
    ];

    public function level()
    {
        return $this->belongsTo(level::class, 'id_level', 'id_level');
    }
}
