<?php

namespace App\Services;

use App\Models\Jurnal;
use App\Models\JurnalDetail;
use App\Models\Coas;
use Illuminate\Support\Facades\DB;

class JurnalService
{
    public function createJurnal($data)
    {
        return DB::transaction(function () use ($data) {
            // Buat jurnal
            $jurnal = Jurnal::create([
                'tgl' => $data['tgl'],
                'no_referensi' => $data['no_referensi'],
                'deskripsi' => $data['deskripsi']
            ]);

            // Proses detail jurnal dan update saldo
            foreach ($data['items'] as $detail) {
                $coas = Coas::findOrFail($detail['coas_id']);
                
                // Buat detail jurnal
                $jurnalDetail = JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'coas_id' => $detail['coas_id'],
                    'debit' => $detail['debit'] ?? 0,
                    'credit' => $detail['credit'] ?? 0
                ]);

                // Update saldo COAS
                $this->updateCoaSaldo($coas, $detail['debit'] ?? 0, $detail['credit'] ?? 0);
            }

            return $jurnal;
        });
    }

    public function updateJurnal($jurnal, $data)
    {
        return DB::transaction(function () use ($jurnal, $data) {
            // Hapus detail jurnal lama dan kembalikan saldo
            foreach ($jurnal->jurnaldetail as $detail) {
                $coas = Coas::findOrFail($detail->coas_id);
                // Kembalikan saldo (kebalikan dari transaksi awal)
                $this->updateCoaSaldo($coas, -$detail->debit, -$detail->credit);
                $detail->delete();
            }

            // Update jurnal
            $jurnal->update([
                'tgl' => $data['tgl'],
                'no_referensi' => $data['no_referensi'],
                'deskripsi' => $data['deskripsi']
            ]);

            // Buat detail jurnal baru dan update saldo
            foreach ($data['items'] as $detail) {
                $coas = Coas::findOrFail($detail['coas_id']);
                
                JurnalDetail::create([
                    'jurnal_id' => $jurnal->id,
                    'coas_id' => $detail['coas_id'],
                    'debit' => $detail['debit'] ?? 0,
                    'credit' => $detail['credit'] ?? 0
                ]);

                // Update saldo COA
                $this->updateCoaSaldo($coas, $detail['debit'] ?? 0, $detail['credit'] ?? 0);
            }

            return $jurnal;
        });
    }

    public function deleteJurnal($jurnal)
    {
        return DB::transaction(function () use ($jurnal) {
            // Kembalikan saldo untuk setiap detail
            foreach ($jurnal->jurnaldetail as $detail) {
                $coas = Coas::findOrFail($detail->coas_id);
                // Kembalikan saldo (kebalikan dari transaksi awal)
                $this->updateCoaSaldo($coas, -$detail->debit, -$detail->credit);
            }

            // Hapus jurnal (detail akan terhapus karena cascade)
            $jurnal->delete();
        });
    }

    protected function updateCoaSaldo($coas, $debit, $credit)
    {
        if ($coas->posisi === 'debit') {
            // Jika status debit, maka:
            // - Debit menambah saldo
            // - Credit mengurangi saldo
            $coas->saldo += ($debit - $credit);
        } else {
            // Jika status credit, maka:
            // - Debit mengurangi saldo
            // - Credit menambah saldo
            $coas->saldo += ($credit - $debit);
        }
        
        $coas->save();
    }
} 