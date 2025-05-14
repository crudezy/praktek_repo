<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenjualanLayanan extends Model
{
    use HasFactory;

    protected $table = 'penjualan_layanan'; // Nama tabel di database
    protected $fillable = ['penjualan_id', 'id_layanan', 'harga_beli', 'harga_jual', 'jml', 'tgl'];

    public function penjualan()
    {
        return $this->belongsTo(Penjualan::class, 'penjualan_id'); // Relasi ke tabel penjualan
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, 'id_layanan'); // Relasi ke tabel layanans
    }
}