<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Layanan extends Model
{
    use HasFactory;

    protected $table = 'layanans'; // Nama tabel eksplisit

    protected $guarded = [];

    // Fungsi untuk menghasilkan ID layanan baru
    public static function getIdLayanan()
    {
        // Ambil ID layanan terakhir
        $sql = "SELECT IFNULL(MAX(id_layanan), 'LYN-000') AS id_layanan 
                FROM layanans";
        $idLayanan = DB::select($sql);

        // Cacah hasilnya
        foreach ($idLayanan as $idLyn) {
            $kd = $idLyn->id_layanan;
        }

        // Ambil tiga digit terakhir
        $nomor = (int) substr($kd, -3);
        $nomor++; // Tambah 1 untuk ID berikutnya

        // Format ID baru (LYN-001, LYN-002, ...)
        return 'LYN-' . str_pad($nomor, 3, "0", STR_PAD_LEFT);
    }

    // Mutator untuk menghapus koma dari harga sebelum menyimpannya ke database
    public function setHargaAttribute($value)
    {
        $this->attributes['harga'] = str_replace(',', '', $value);
    }

    // Relasi dengan tabel penjualan_layanan (many-to-many)
    public function penjualanLayanan()
    {
        return $this->hasMany(PenjualanLayanan::class, 'id_layanan');
    }
}