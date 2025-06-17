<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan'; // Nama tabel eksplisit

    protected $guarded = [];

    // Fungsi untuk menghasilkan ID jabatan baru
    public static function getIdJabatan()
    {
        // Ambil ID jabatan terakhir
        $sql = "SELECT IFNULL(MAX(id_jabatan), 'JBT-000') AS id_jabatan 
                FROM jabatan";
        $idJabatan = DB::select($sql);

        // Cacah hasilnya
        foreach ($idJabatan as $idJab) {
            $kd = $idJab->id_jabatan;
        }

        // Ambil tiga digit terakhir
        $nomor = (int) substr($kd, -3);
        $nomor++; // Tambah 1 untuk ID berikutnya

        // Format ID baru (JBT-001, JBT-002, ...)
        return 'JBT-' . str_pad($nomor, 3, "0", STR_PAD_LEFT);
    }

    // Mutator untuk menghapus koma dari harga sebelum menyimpannya ke database
    public function setHargaAttribute($value)
    {
        $this->attributes['harga'] = str_replace(',', '', $value);
    }

    // Relasi dengan tabel penggajian_pegawai (many-to-many)
    public function penggajianPegawai()
    {
        return $this->hasMany(PenggajianPegawai::class, 'id_jabatan');
    }

}
