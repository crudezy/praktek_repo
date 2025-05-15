<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan'; 
    protected $primaryKey = 'id_jabatan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id_jabatan',
        'nama_jabatan',
        'gaji'
    ];

    public static function generateNewId()
    {
        $lastId = self::orderBy('id_jabatan', 'desc')->first()?->id_jabatan;

        if ($lastId && preg_match('/JBT(\d+)/', $lastId, $matches)) {
            $number = (int) $matches[1] + 1;
        } else {
            $number = 1;
        }

        return 'JBT' . str_pad($number, 3, '0', STR_PAD_LEFT);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id_jabatan)) {
                $model->id_jabatan = self::generateNewId();
            }
        });

        
    }

    public function getGajiFormatted(): string
    {
        return 'Rp ' . number_format($this->gaji, 0, ',', '.');
    }

    // Relasi dengan tabel relasi many to many nya
    public function penggajianpegawai()
    {
        return $this->hasMany(PenggajianPegawai::class, 'id_jabatan');
    }

}
