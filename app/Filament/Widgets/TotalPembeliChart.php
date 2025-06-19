<?php 
namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Penjualan;
use App\Models\Pembeli;
use App\Models\Penjualanlayanan;
use Illuminate\Support\Facades\DB;


class TotalPembeliChart extends ChartWidget
{
    protected static ?string $heading = 'Total Penjualan per Pembeli';

    protected function getData(): array
    {
        $data = DB::table('penjualan')
            ->join('penjualan_layanan', 'penjualan.id', '=', 'penjualan_layanan.penjualan_id')
            ->join('pembeli', 'penjualan.pembeli_id', '=', 'pembeli.id')
            ->where('penjualan.status', 'bayar')
            ->selectRaw('pembeli.nama_pembeli, SUM(penjualan_layanan.harga_jual * penjualan_layanan.jml) AS total_penjualan')
            ->groupBy('pembeli.nama_pembeli')
            ->get()

            ->map(function ($item) {
                return [
                    'label' => $item->nama_pembeli,
                    'value' => $item->total_penjualan,
                ];
            });

        // Cek jika kosong
        if ($data->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Penjualan',
                    'data' => $data->pluck('value')->toArray(),
                    'backgroundColor' => '#4BC0C0',
                ],
            ],
            'labels' => $data->pluck('label')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}