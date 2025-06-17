<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// tambahan
use Illuminate\Support\Facades\DB;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai'; // Nama tabel eksplisit

    protected $guarded = []; //semua kolom boleh di isi

    public static function getKodePegawai()
    {
        // query kode pegawai
        $sql = "SELECT IFNULL(MAX(kode_pegawai), 'P-00000') as kode_pegawai 
                FROM pegawai ";
        $kodepegawai = DB::select($sql);

        // cacah hasilnya
        foreach ($kodepegawai as $kdpgw) {
            $kd = $kdpgw->kode_pegawai;
        }
        // Mengambil substring tiga digit akhir dari string PR-000
        $noawal = substr($kd,-5);
        $noakhir = $noawal+1; //menambahkan 1, hasilnya adalah integer cth 1
        $noakhir = 'P-'.str_pad($noakhir,5,"0",STR_PAD_LEFT); //menyambung dengan string P-00001
        return $noakhir;

    }

    // relasi ke tabel pegawai
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); 
        // pastikan 'user_id' adalah nama kolom foreign key
    }

    // relasi ke tabel penggajian
    public function penggajian()
    {
        return $this->hasMany(Penggajian::class, 'pegawai_id');
    }
}
