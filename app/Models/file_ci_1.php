<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class file_ci_1 extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_file_c1';

    // Primary key
    protected $primaryKey = 'id_file';

    // Define fillable fields
    protected $fillable = [
        'url_file',
        'id_wilayah_saksi'
    ];

    // Define the relationship with the WilayahSaksi model
    public function wilayahSaksi()
    {
        return $this->belongsTo(wilayah_saksi::class, 'id_wilayah_saksi', 'id_wilayah_saksi');
    }
}
