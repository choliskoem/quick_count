<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bagian_pemilu extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default naming convention
    protected $table = 't_bagian_pemilu';

    // Primary key
    protected $primaryKey = 'id_bagian_pemilu';

    // Define fillable fields
    protected $fillable = [
        'id_kabkota',
        'label'
    ];

    // Define the relationship with the Kabkota model
    public function kabkota()
    {
        return $this->belongsTo(wilayah_pemilu::class, 'id_kabkota', 'id_kabkota');
    }
}
