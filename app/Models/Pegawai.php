<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    /** @use HasFactory<\Database\Factories\PegawaiFactory> */
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'pegawai';
    protected $guarded = [];
=======
    protected $table = 'pegawai'; // atau 'pegawai', sesuaikan dengan nama tabelmu
    protected $primaryKey = 'id_pegawai';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_pegawai',
        'nama_pegawai',
        'alamat',
        'no_hp',
        'shift_kerja'
    ];

    public static function generateNewId()
{
    $lastId = self::orderBy('id_pegawai', 'desc')->first()?->id_pegawai;

    if ($lastId && preg_match('/PG(\d+)/', $lastId, $matches)) {
        $number = (int) $matches[1] + 1;
    } else {
        $number = 1;
    }

    return 'PG' . str_pad($number, 3, '0', STR_PAD_LEFT);
}


protected static function boot()
{
    parent::boot();

    static::creating(function ($model) {
        if (empty($model->id_pegawai)) {
            $model->id_pegawai = self::generateNewId();
        }
    });

    
}


>>>>>>> 5fb1c9b1e47b8631942b4405d37aff5825c47e39
}
