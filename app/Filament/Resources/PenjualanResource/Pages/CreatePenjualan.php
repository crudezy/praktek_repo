<?php

namespace App\Filament\Resources\PenjualanResource\Pages;

use App\Filament\Resources\PenjualanResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

// Tambahan untuk akses ke model
use App\Models\Penjualan;
use App\Models\PenjualanLayanan;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\DB;

// Untuk notifikasi
use Filament\Notifications\Notification;

class CreatePenjualan extends CreateRecord
{
    protected static string $resource = PenjualanResource::class;

    // Penanganan jika status masih kosong
    protected function beforeCreate(): void
    {
        $this->data['status'] = $this->data['status'] ?? 'pesan';
    }

    // Tambahan untuk tombol simpan pembayaran
    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('bayar')
                ->label('Bayar')
                ->color('success')
                ->action(fn () => $this->simpanPembayaran())
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Pembayaran')
                ->modalDescription('Apakah Anda yakin ingin menyimpan pembayaran ini?')
                ->modalButton('Ya, Bayar'),
        ];
    }

    // Penanganan untuk menyimpan pembayaran
    protected function simpanPembayaran()
    {
        // Ambil data penjualan yang sedang dibuat
        $penjualan = $this->record ?? Penjualan::latest()->first();

        // Simpan ke tabel pembayaran
        Pembayaran::create([
            'penjualan_id' => $penjualan->id,
            'tgl_bayar'    => now(),
            'jenis_pembayaran' => 'tunai',
            'transaction_time' => now(),
            'gross_amount' => $penjualan->tagihan, // Total tagihan
            'order_id' => $penjualan->no_faktur,
        ]);

        // Update status penjualan menjadi "bayar"
        $penjualan->update(['status' => 'bayar']);

        // Notifikasi sukses
        Notification::make()
            ->title('Pembayaran Berhasil!')
            ->success()
            ->send();
    }
}