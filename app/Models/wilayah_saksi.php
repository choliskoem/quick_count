<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class wilayah_saksi extends Model
{
    use HasFactory;

    // Set the table name
    protected $table = 'wilayah_saksi';

    // Primary Key
    protected $primaryKey = 'id_wilayah_saksi';

    // Since the primary key is a string (varchar), set $incrementing to false
    public $incrementing = false;

    // Define the key type as string
    protected $keyType = 'string';

    // Disable the timestamps if not needed
    public $timestamps = false;

    // Fillable fields to allow mass assignment
    protected $fillable = [
        'id_wilayah_saksi',
        'id_kabkota',
        'id_wilayah',
        'kd_saksi',
        'id_tps'
    ];

    /**
     * Relationship with `wilayah_pemilu` table (Kabkota).
     */
    public function wilayahPemilu()
    {
        return $this->belongsTo(wilayah_pemilu::class, 'id_kabkota', 'id_kabkota');
    }

    /**
     * Relationship with `wilayah` table.
     */
    public function wilayah()
    {
        return $this->belongsTo(wilayah::class, 'id_wilayah', 'id_wilayah');
    }

    /**
     * Relationship with `tps` table.
     */
    public function tps()
    {
        return $this->belongsTo(tps::class, 'id_tps', 'id_tps');
    }

    /**
     * Relationship with `t_saksi` table.
     */
    public function tSaksi()
    {
        return $this->belongsTo(saksi::class, 'kd_saksi', 'kd_saksi');
    }
}
