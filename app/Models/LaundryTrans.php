<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class LaundryTrans extends Model
{
    use HasFactory;

    protected $table = 'laundry_trans';

    protected $guarded = [];

    /**
     * Generate ID pelanggan otomatis (PLG-001, PLG-002, dst).
     */
    public static function getIdPelanggan()
    {
        // Ambil ID pelanggan terakhir
        $sql = "SELECT IFNULL(MAX(id_pelanggan), 'PLG-000') AS id_pelanggan 
                FROM laundry_trans";
        $idPelanggan = DB::select($sql);

        // Cacah hasilnya
        foreach ($idPelanggan as $idPlg) {
            $kd = $idPlg->id_pelanggan;
        }
        
        // Ambil tiga digit terakhir
        $nomor = (int) substr($kd, -3);
        $nomor++; // Tambah 1 untuk ID berikutnya

        // Format ID baru (PLG-001, PLG-002, ...)
        return 'PLG-' . str_pad($nomor, 3, "0", STR_PAD_LEFT);
    }


    /**
     * Mutator untuk menghitung total_harga berdasarkan total_berat.
     */
    public function setTotalBeratAttribute($value)
    {
        $this->attributes['total_berat'] = $value;
        $this->attributes['total_harga'] = $value * 6000; // 6k per kilo
    }


}
