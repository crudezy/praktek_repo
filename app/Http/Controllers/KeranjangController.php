<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Layanan; //

class KeranjangController extends Controller
{
    public function daftarlayanan()
    {
        // ambil data barang
        $layanans = Layanan::all();
        // kirim ke halaman view
        return view('galeri',
                        [ 
                            'layanans'=>$layanans,
                        ]
                    ); 
    }
}