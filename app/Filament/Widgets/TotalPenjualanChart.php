<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\penjualan;
use App\Models\Penjualanlayanan;

class TotalPenjualanChart extends ChartWidget
{
    protected static ?string $heading = 'Total Penjualan'; // Judul widget chart

    // Mendapatkan data untuk chart
    protected function getData(): array
    {
        // Ambil data total penjualan berdasarkan rumus (harga_jual - harga_beli) * jumlah
        $data = penjualan::query()
            ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
            ->join('layanans', 'penjualan_layanan.id_layanan', '=', 'layanans.id')
            ->where('penjualan.status', 'bayar') // Hanya status 'bayar'
            ->selectRaw('layanans.nama_paket, SUM(penjualan_layanan.harga_jual * penjualan_layanan.jml) as total_penjualan')
            ->groupBy('layanans.nama_paket')
            ->get()
            ->map(function ($penjualan) {
                return [
                    'nama_paket' => $penjualan->nama_paket,
                    'total_penjualan' => $penjualan->total_penjualan,
                ];
            });
            // dd($data); // untuk melihat data sebelum dikirim ke chart

        // Pastikan data ada sebelum dikirim ke chart
        if ($data->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        // Mengembalikan data dalam format yang dibutuhkan untuk chart
        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data->pluck('total_penjualan')->toArray(), // Data untuk chart
                    'backgroundColor' => '#36A2EB',
                ],
            ],
            'labels' => $data->pluck('nama_paket')->toArray(), // Label untuk sumbu X
        ];
    }

    // Jenis chart yang digunakan, misalnya bar chart
    protected function getType(): string
    {
        return 'bar'; // Tipe chart bisa diganti sesuai kebutuhan, seperti 'line', 'pie', dll.
    }
}