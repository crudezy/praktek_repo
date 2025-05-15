<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggajianPegawai extends Model
{
    use HasFactory;

    protected $table = 'penggajian_pegawais';
    protected $fillable = ['penggajian_id', 'id_jabatan', 'harga_beli', 'harga_jual', 'jml', 'tgl'];

    public function penggajian()
    {
        return $this->belongsTo(Penggajian::class, 'penggajian_id');
    }

    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'id_jabatan');
    }
}