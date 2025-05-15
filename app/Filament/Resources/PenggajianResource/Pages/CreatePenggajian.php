<?php

namespace App\Filament\Resources\PenggajianResource\Pages;

use App\Filament\Resources\PenggajianResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

// Tambahan untuk akses ke model
use App\Models\Penggajian;
use App\Models\PenggajianPegawai;
use App\Models\ListPenggajian;
use Illuminate\Support\Facades\DB;

// Untuk notifikasi
use Filament\Notifications\Notification;

class CreatePenggajian extends CreateRecord
{
    protected static string $resource = PenggajianResource::class;

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
        $penggajian = $this->record ?? Penggajian::latest()->first();

        // Simpan ke tabel pembayaran
        ListPenggajian::create([
            'penggajian_id' => $penggajian->id,
            'tgl_gaji'    => now(),
            'jenis_penggajian' => 'tunai',
            'transaction_time' => now(),
            'gross_amount' => $penggajian->tagihan, // Total tagihan
            'order_id' => $penggajian->no_faktur,
        ]);

        // Update status penjualan menjadi "bayar"
        $penggajian->update(['status' => 'bayar']);

        // Notifikasi sukses
        Notification::make()
            ->title('Pembayaran Berhasil!')
            ->success()
            ->send();
    }
}