<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Layanan; // untuk akses kelas model layanan
use App\Models\Penjualan; // untuk akses kelas model penjualan
use App\Models\PenjualanLayanan; // untuk akses kelas model penjualan layanan
use App\Models\Pembayaran; // untuk akses kelas model pembayaran
use App\Models\Pembeli; // untuk akses kelas model pembeli
use Illuminate\Support\Facades\DB; // untuk menggunakan db
use Illuminate\Support\Facades\Auth; // agar bisa mengakses session user_id dari user yang login

class KeranjangController extends Controller
{
    // tampilan galeri daftar layanan
    public function daftarlayanan()
    {
        $id_user = Auth::user()->id;

        // dapatkan id_pembeli dari user_id di tabel users sesuai data yang login
        $pembeli = Pembeli::where('user_id', $id_user)
                        ->select(DB::raw('id'))
                        ->first();
        $id_pembeli = $pembeli->id;

        // ambil data layanan
        $layanan = Layanan::all();

        // jumlah layanan dibeli yang belum terbayar
        $jmllayanandibeli = DB::table('penjualan')
                            ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                            ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                            ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                            ->select(DB::raw('COUNT(DISTINCT id_layanan) as total'))
                            ->where('penjualan.pembeli_id', '=', $id_pembeli) 
                            ->where(function($query) {
                                $query->where('pembayaran.gross_amount', 0)
                                      ->orWhere(function($q) {
                                          $q->where('pembayaran.status_code', '!=', 200)
                                            ->where('pembayaran.jenis_pembayaran', 'pg');
                                      });
                            })
                            ->get();

        $t = DB::table('penjualan')
        ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
        ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
        ->select(DB::raw('SUM(harga_jual * jml) as total'))
        ->where('penjualan.pembeli_id', '=', $id_pembeli) 
        ->where(function($query) {
            $query->where('pembayaran.gross_amount', 0)
                  ->orWhere(function($q) {
                      $q->where('pembayaran.status_code', '!=', 200)
                        ->where('pembayaran.jenis_pembayaran', 'pg');
                  });
        })
        ->first();
        
        // kirim ke halaman view
        return view('galeri_layanan',
                        [ 
                            'layanan' => $layanan,
                            'total_belanja' => $t->total ?? 0,
                            'jmllayanandibeli' => $jmllayanandibeli[0]->total ?? 0
                        ]
                    ); 
    }

    // halaman tambah keranjang
    public function tambahKeranjang(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        try {
            $request->validate([
                'id_layanan' => 'required|exists:layanans,id',
                'quantity' => 'required|integer|min:1'
            ]);
    
            $id_user = Auth::user()->id;

            // dapatkan id_pembeli dari user_id di tabel users sesuai data yang login
            $pembeli = Pembeli::where('user_id', $id_user)
                            ->select(DB::raw('id'))
                            ->first();
            $id_pembeli = $pembeli->id;

            try{
                $layanan = Layanan::find($request->id_layanan); // ambil data layanan
                if (!$layanan) {
                    return response()->json(['success' => false, 'message' => 'Layanan tidak ditemukan!']);
                }
                $harga = $layanan->harga_layanan;
                $jumlah = (int) $request->quantity;
                $id_layanan = $request->id_layanan;

               // Cek apakah ada penjualan dengan gross_amount = 0
                $penjualanExist = DB::table('penjualan')
                ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                ->where('penjualan.pembeli_id', $id_pembeli)
                ->where(function($query) {
                    $query->where('pembayaran.gross_amount', 0)
                          ->orWhere(function($q) {
                              $q->where('pembayaran.status_code', '!=', 200)
                                ->where('pembayaran.jenis_pembayaran', 'pg');
                          });
                })
                ->select('penjualan.id') // Ambil ID saja untuk dicek
                ->first();

                if (!$penjualanExist) {
                    // Buat penjualan baru jika tidak ada
                    $penjualan = Penjualan::create([
                        'no_faktur'   => Penjualan::getKodeFaktur(),
                        'tgl'         => now(),
                        'pembeli_id'  => $id_pembeli,
                        'tagihan'     => 0,
                        'status'      => 'pesan',
                    ]);

                    // Buat pembayaran baru
                    $pembayaran = Pembayaran::create([
                        'penjualan_id'      => $penjualan->id,
                        'tgl_bayar'         => now(),
                        'jenis_pembayaran'  => 'pg',
                        'gross_amount'      => 0,
                    ]);
                }else{
                    $penjualan = Penjualan::find($penjualanExist->id);
                }

                // Tambahkan layanan ke penjualan_layanan
PenjualanLayanan::create([
                    'penjualan_id' => $penjualan->id,
                    'id_layanan' => $id_layanan,
                    'jml' => $jumlah,
                    'harga_beli' => $harga,
                    'harga_jual' => $harga * 1.2,
                    'tgl' => date('Y-m-d')
                ]);

                // Update total tagihan pada tabel penjualan
                $tagihan = DB::table('penjualan')
                ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                ->select(DB::raw('SUM(harga_jual * jml) as total'))
                ->where('penjualan.pembeli_id', '=', $id_pembeli) 
                ->where(function($query) {
                    $query->where('pembayaran.gross_amount', 0)
                          ->orWhere(function($q) {
                              $q->where('pembayaran.status_code', '!=', 200)
                                ->where('pembayaran.jenis_pembayaran', 'pg');
                          });
                })
                ->first();
                $penjualan->tagihan = $tagihan->total;
                $penjualan->save();

                // Jika layanan tidak memiliki stok, hapus bagian pengurangan stok

                // hitung total layanan
                $jmllayanandibeli = DB::table('penjualan')
                            ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                            ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                            ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                            ->select(DB::raw('COUNT(DISTINCT id_layanan) as total'))
                            ->where('penjualan.pembeli_id', '=', $id_pembeli) 
                            ->where(function($query) {
                                $query->where('pembayaran.gross_amount', 0)
                                      ->orWhere(function($q) {
                                          $q->where('pembayaran.status_code', '!=', 200)
                                            ->where('pembayaran.jenis_pembayaran', 'pg');
                                      });
                            })
                            ->get();

                return response()->json(['success' => true, 'message' => 'Transaksi berhasil ditambahkan!', 
                'total' => $penjualan->tagihan, 'jmllayanandibeli' => $jmllayanandibeli[0]->total ?? 0]);

            }catch(\Exception $e){
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
    
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => $e->getMessage()
            ]);
        }
    }

    // halaman lihat keranjang
    public function lihatkeranjang(){
        date_default_timezone_set('Asia/Jakarta');
        $id_user = Auth::user()->id;

        // dapatkan id_pembeli dari user_id di tabel users sesuai data yang login
        $pembeli = Pembeli::where('user_id', $id_user)
                        ->select(DB::raw('id'))
                        ->first();
        $id_pembeli = $pembeli->id;

        $layanan = DB::table('penjualan')
                        ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                        ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                        ->join('layanans', 'penjualan_layanan.id_layanan', '=', 'layanans.id')
                        ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                        ->select('penjualan.id','penjualan.no_faktur','pembeli.nama_pembeli', 'penjualan_layanan.id_layanan', 'layanans.nama_layanan','penjualan_layanan.harga_jual', 
                                 'layanans.foto','pembayaran.order_id',
                                  DB::raw('SUM(penjualan_layanan.jml) as total_layanan'),
                                  DB::raw('SUM(penjualan_layanan.harga_jual * penjualan_layanan.jml) as total_belanja'))
                        ->where('penjualan.pembeli_id', '=',$id_pembeli) 
                        ->where(function($query) {
                            $query->where('pembayaran.gross_amount', 0)
                                  ->orWhere(function($q) {
                                      $q->where('pembayaran.status_code', '!=', 200)
                                        ->where('pembayaran.jenis_pembayaran', 'pg');
                                  });
                        })
                        ->groupBy('penjualan.id','penjualan.no_faktur','pembeli.nama_pembeli','penjualan_layanan.id_layanan', 'layanans.nama_layanan','penjualan_layanan.harga_jual',
                                  'layanans.foto','pembayaran.order_id',
                                 )
                        ->get();

        // hitung jumlah total tagihan
        $ttl = 0; $jml_layanan = 0; $kode_faktur = '';
        foreach($layanan as $p){
            $ttl += $p->total_belanja;
            $jml_layanan += 1;
            $kode_faktur = $p->no_faktur;
            $idpenjualan = $p->id;
            $odid = $p->order_id;
        }

        // cek dulu apakah sudah ada di midtrans dan belum expired
        $ch = curl_init(); 
        $login = env('MIDTRANS_SERVER_KEY');
        $password = '';
        if(isset($odid)){
            $parts = explode('-', $odid);
            $substring = $parts[0] . '-' . $parts[1];
            $orderid = $substring;
        }else{
            $orderid =$kode_faktur.'-'.date('YmdHis'); //FORMAT
        }

        $URL =  'https://api.sandbox.midtrans.com/v2/'.$orderid.'/status';
        curl_setopt($ch, CURLOPT_URL, $URL);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");  
        $output = curl_exec($ch); 
        curl_close($ch);    
        $outputjson = json_decode($output, true); //parsing json dalam bentuk assosiative array

        // ambil statusnya
        if($outputjson['status_code']==404 or in_array($outputjson['transaction_status'], ['expire', 'cancel', 'deny'])){
            if($ttl>0){
                // proses generate token payment gateway
                $order_id = $kode_faktur.'-'.date('YmdHis');

                $myArray = array(); // untuk menyimpan objek array
                $i = 1;
                foreach($layanan as $k):
                    // untuk data item detail
                    $foo = array(
                            'id'=> $i,
                            'price' => $k->harga_jual,
                            'quantity' => $k->total_layanan,
                            'name' => $k->nama_layanan,
                    );
                    $i++;
                    array_push($myArray,$foo);
                endforeach;
                
                \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                \Midtrans\Config::$isProduction = false;
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;

                $params = array(
                    'transaction_details' => array(
                        'order_id' => $order_id, 
                        'gross_amount' => $ttl,
                    ),
                    'item_details' => $myArray,
                    'expiry' => [
                            'start_time' => date("Y-m-d H:i:s O"),
                            'unit' => 'minutes',
                            'duration' => 2
                    ]
                );

                $snapToken = \Midtrans\Snap::getSnapToken($params);

                $pembayaran = Pembayaran::updateOrCreate(
                    ['penjualan_id' => $idpenjualan],
                    [
                        'tgl_bayar'        => now(),
                        'jenis_pembayaran' => 'pg',
                        'order_id'         => $order_id,
                        'gross_amount'     => $ttl,
                        'status_code'      => '201',
                        'status_message'   => 'Pending payment',
                        'transaction_id'   => $snapToken,
                    ]
                );

                return view('keranjang',
                            [
                                'barang' => $layanan,
                                'total_tagihan' => $ttl,
                                'jml_brg' => $jml_layanan,
                                'snap_token' => $snapToken,
                            ]
                );
            }else{
                return redirect('/depan');
            }
        }else{
            $tagihan = DB::table('penjualan')
            ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
            ->select(DB::raw('transaction_id'))
            ->where('penjualan.pembeli_id', '=', $id_pembeli) 
            ->where(function($query) {
                $query->where('pembayaran.gross_amount', 0)
                      ->orWhere(function($q) {
                          $q->where('pembayaran.status_code', '!=', 200)
                            ->where('pembayaran.jenis_pembayaran', 'pg');
                      });
            })
            ->first();

            $layanan = DB::table('penjualan')
                        ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                        ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                        ->join('layanans', 'penjualan_layanan.id_layanan', '=', 'layanans.id')
                        ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                        ->select('penjualan.id','penjualan.no_faktur','pembeli.nama_pembeli', 'penjualan_layanan.id_layanan', 'layanans.nama_layanan','penjualan_layanan.harga_jual', 
                                 'layanans.foto',
                                  DB::raw('SUM(penjualan_layanan.jml) as total_layanan'),
                                  DB::raw('SUM(penjualan_layanan.harga_jual * penjualan_layanan.jml) as total_belanja'))
                        ->where('penjualan.pembeli_id', '=',$id_pembeli) 
                        ->where(function($query) {
                            $query->where('pembayaran.gross_amount', 0)
                                  ->orWhere(function($q) {
                                      $q->where('pembayaran.status_code', '!=', 200)
                                        ->where('pembayaran.jenis_pembayaran', 'pg');
                                  });
                        })
                        ->groupBy('penjualan.id','penjualan.no_faktur','pembeli.nama_pembeli','penjualan_layanan.id_layanan', 'layanans.nama_layanan','penjualan_layanan.harga_jual',
                                  'layanans.foto',
                                 )
                        ->get();

            return view('keranjang', [
                'barang' => $layanan,
                'total_tagihan' => $ttl,
                'jml_brg' => $jml_layanan,
                'snap_token' => $tagihan->transaction_id
            ]);
        }
    }

    // untuk menghapus layanan dari keranjang
    public function hapus($id_layanan)
    {
        date_default_timezone_set('Asia/Jakarta');
        $id_user = Auth::user()->id;

        // dapatkan id_pembeli dari user_id di tabel users sesuai data yang login
        $pembeli = Pembeli::where('user_id', $id_user)
                        ->select(DB::raw('id'))
                        ->first();
        $id_pembeli = $pembeli->id;

$sql = "DELETE FROM penjualan_layanan WHERE id_layanan = ? AND penjualan_id = (SELECT penjualan.id FROM penjualan join pembayaran on (penjualan.id=pembayaran.penjualan_id) WHERE penjualan.pembeli_id = ? AND ((pembayaran.gross_amount = 0) or (pembayaran.jenis_pembayaran='pg' and pembayaran.status_code<>'200')))";
        $deleted = DB::delete($sql, [$id_layanan,$id_pembeli]);

        $penjualan = DB::table('penjualan')
            ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
            ->select('penjualan.id')
            ->where('penjualan.pembeli_id', $id_pembeli)
            ->where(function($query) {
                $query->where('pembayaran.gross_amount', 0)
                      ->orWhere(function($q) {
                          $q->where('pembayaran.status_code', '!=', 200)
                            ->where('pembayaran.jenis_pembayaran', 'pg');
                      });
            })
            ->first();

        // Update total tagihan pada tabel penjualan
        $tagihan = DB::table('penjualan')
        ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
        ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
        ->select(DB::raw('SUM(harga_jual * jml) as total'))
        ->where('penjualan.pembeli_id', '=', $id_pembeli) 
        ->where(function($query) {
            $query->where('pembayaran.gross_amount', 0)
                  ->orWhere(function($q) {
                      $q->where('pembayaran.status_code', '!=', 200)
                        ->where('pembayaran.jenis_pembayaran', 'pg');
                  });
        })
        ->first();

        if ($penjualan) {
            DB::table('penjualan')
                ->where('id', $penjualan->id)
                ->update(['tagihan' => $tagihan->total]);
        }

        $jmllayanandibeli = DB::table('penjualan')
                            ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                            ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                            ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                            ->select(DB::raw('COUNT(DISTINCT id_layanan) as total'))
                            ->where('penjualan.pembeli_id', '=', $id_pembeli) 
                            ->where(function($query) {
                                $query->where('pembayaran.gross_amount', 0)
                                      ->orWhere(function($q) {
                                          $q->where('pembayaran.status_code', '!=', 200)
                                            ->where('pembayaran.jenis_pembayaran', 'pg');
                                      });
                            })
                            ->get();

        return response()->json(['success' => true, 'message' => 'Layanan berhasil dihapus', 'total' => $tagihan->total, 'jmllayanandibeli' => $jmllayanandibeli[0]->total ?? 0]);
    }

    // untuk autorefresh dari server midtrans yang sudah terbayarkan akan diupdatekan ke database
    // termasuk menangani ketika sudah expired
    public function cek_status_pembayaran_pg(){
        date_default_timezone_set('Asia/Jakarta');
        $pembayaranPending = Pembayaran::where('jenis_pembayaran', 'pg')
        ->where(DB::raw("IFNULL(status_code, '0')"), '<>', '200')
        ->orderBy('tgl_bayar', 'desc')
        ->get();    

        $id = array();
        $kode_faktur = array();
        foreach($pembayaranPending as $ks){
            array_push($id,$ks->order_id);
            $parts = explode('-', $ks->order_id);
            $substring = $parts[0] . '-' . $parts[1];
            array_push($kode_faktur,$substring);
        }

        for($i=0; $i<count($id); $i++){
            $ch = curl_init(); 
            $login = env('MIDTRANS_SERVER_KEY');
            $password = '';
            $orderid = $id[$i];
            $kode_faktur = $kode_faktur[$i];
            $URL =  'https://api.sandbox.midtrans.com/v2/'.$orderid.'/status';
            curl_setopt($ch, CURLOPT_URL, $URL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
            curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");  
            $output = curl_exec($ch); 
            curl_close($ch);    
            $outputjson = json_decode($output, true); 

            if($outputjson['status_code']!=404){
                if(in_array($outputjson['transaction_status'], ['expire', 'cancel', 'deny'])){
                    $affected = DB::update(
                        'update pembayaran 
                         set status_code = null,
                             transaction_time = null,
                             gross_amount = 0,
                             transaction_id = null
                         where order_id = ?',
                        [
                            $orderid
                        ]
                    );
                }else{
                    $affected = DB::update(
                        'update pembayaran 
                         set status_code = ?,
                             transaction_time = ?,
                             settlement_time = ?,
                             status_message = ?,
                             merchant_id = ?
                         where order_id = ?',
                        [
                            $outputjson['status_code'] ?? null, 
                            $outputjson['transaction_time'] ?? null, 
                            $outputjson['settlement_time'] ?? null, 
                            $outputjson['status_message'] ?? null, 
                            $outputjson['merchant_id'] ?? null, 
                            $orderid
                        ]
                    );

                    if($outputjson['status_code']=='200'){
                        $affected = DB::update(
                            'update penjualan 
                             set status = "bayar"
                             where no_faktur = ?',
                            [
                                $kode_faktur
                            ]
                        );
                    }
                }
            }

            if($outputjson['status_code']==404){
                $dataorderid = Pembayaran::where('order_id',$orderid)
                ->select(DB::raw('order_id'))
                ->first();
                if(isset($dataorderid->order_id)){
                    $affected = DB::update(
                        'update pembayaran 
                         set status_code = null,
                             transaction_time = null,
                             gross_amount = 0,
                             transaction_id = null,
                             order_id = null
                         where order_id = ?',
                        [
                            $orderid
                        ]
                    );
                }
            }
        }
        return view('autorefresh');
    }

    // melihat riwayat pesanan
    public function lihatriwayat(){
        date_default_timezone_set('Asia/Jakarta');
        $id_user = Auth::user()->id;

        // dapatkan id_pembeli dari user_id di tabel users sesuai data yang login
        $pembeli = Pembeli::where('user_id', $id_user)
                        ->select(DB::raw('id'))
                        ->first();
        $id_pembeli = $pembeli->id;

        $jmllayanandibeli = DB::table('penjualan')
                            ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                            ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                            ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                            ->select(DB::raw('COUNT(DISTINCT id_layanan) as total'))
                            ->where('penjualan.pembeli_id', '=', $id_pembeli) 
                            ->where(function($query) {
                                $query->where('pembayaran.gross_amount', 0)
                                      ->orWhere(function($q) {
                                          $q->where('pembayaran.status_code', '!=', 200)
                                            ->where('pembayaran.jenis_pembayaran', 'pg');
                                      });
                            })
                            ->get();

        $t = DB::table('penjualan')
        ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
        ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
        ->select(DB::raw('SUM(harga_jual * jml) as total'))
        ->where('penjualan.pembeli_id', '=', $id_pembeli) 
        ->where(function($query) {
            $query->where('pembayaran.gross_amount', 0)
                  ->orWhere(function($q) {
                      $q->where('pembayaran.status_code', '!=', 200)
                        ->where('pembayaran.jenis_pembayaran', 'pg');
                  });
        })
        ->first();

        $layanan = DB::table('penjualan')
                        ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
                        ->join('pembayaran', 'penjualan.id', '=', 'pembayaran.penjualan_id')
                        ->join('layanans', 'penjualan_layanan.id_layanan', '=', 'layanans.id')
                        ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
                        ->select('penjualan.id','penjualan.no_faktur','pembeli.nama_pembeli', 'penjualan_layanan.id_layanan', 'layanans.nama_layanan','penjualan_layanan.harga_jual', 
                                 'layanans.foto',
                                  DB::raw('SUM(penjualan_layanan.jml) as total_layanan'),
                                  DB::raw('SUM(penjualan_layanan.harga_jual * penjualan_layanan.jml) as total_belanja'))
                        ->where('penjualan.pembeli_id', '=',$id_pembeli) 
                        ->where(function($query) {
                            $query->where('pembayaran.gross_amount', 0)
                                  ->orWhere(function($q) {
                                      $q->where('pembayaran.status_code', '!=', 200)
                                        ->where('pembayaran.jenis_pembayaran', 'pg');
                                  });
                        })
                        ->groupBy('penjualan.id','penjualan.no_faktur','pembeli.nama_pembeli','penjualan_layanan.id_layanan', 'layanans.nama_layanan','penjualan_layanan.harga_jual',
                                  'layanans.foto',
                                 )
                        ->get();

        return view('riwayat',
                        [ 
                            'transaksi' => $layanan,
                            'total_tagihan' => $t->total ?? 0,
                            'total_belanja' => $t->total ?? 0,
                            'jmllayanandibeli' => $jmllayanandibeli[0]->total ?? 0
                        ]
                    ); 
    }
}
