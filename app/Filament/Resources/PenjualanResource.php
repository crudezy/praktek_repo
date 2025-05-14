<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenjualanResource\Pages;
use App\Models\Penjualan;
use App\Models\Pembeli;
use App\Models\Layanan;
use App\Models\Pembayaran;
use App\Models\PenjualanLayanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\DB;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\Action;
use Barryvdh\DomPDF\Facade\Pdf;

class PenjualanResource extends Resource
{
    protected static ?string $model = Penjualan::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Penjualan';

    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Pesanan')
                        ->schema([
                            Forms\Components\Section::make('Faktur')
                                ->icon('heroicon-m-document-duplicate')
                                ->schema([
                                    TextInput::make('no_faktur')
                                        ->default(fn () => Penjualan::getKodeFaktur())
                                        ->label('Nomor Faktur')
                                        ->required()
                                        ->readonly(),
                                    DateTimePicker::make('tgl')->default(now()),
                                    Select::make('pembeli_id')
                                        ->label('Pembeli')
                                        ->options(Pembeli::pluck('nama_pembeli', 'id')->toArray())
                                        ->required()
                                        ->placeholder('Pilih Pembeli'),
                                    TextInput::make('tagihan')
                                        ->default(0)
                                        ->hidden(),
                                    TextInput::make('status')
                                        ->default('pesan')
                                        ->hidden(),
                                ])
                                ->collapsible()
                                ->columns(3),
                        ]),
                        Wizard\Step::make('Pilih Layanan')
                        ->schema([
                            Repeater::make('items')
                                ->relationship('penjualanLayanan')
                                ->schema([
                                    Select::make('id_layanan')
                                        ->label('Layanan')
                                        ->options(Layanan::pluck('nama_paket', 'id')->toArray())
                                        ->required()
                                        ->reactive()
                                        ->placeholder('Pilih Layanan')
                                        ->afterStateUpdated(function ($state, $set) {
                                            $layanan = Layanan::find($state);
                                            $set('harga_beli', $layanan ? $layanan->harga : 0);
                                            $set('harga_jual', $layanan ? $layanan->harga * 1.2 : 0);
                                        }),
                                    TextInput::make('harga_beli')
                                        ->label('Harga Beli')
                                        ->numeric()
                                        ->default(fn ($get) => $get('id_layanan') ? Layanan::find($get('id_layanan'))?->harga ?? 0 : 0)
                                        ->readonly()
                                        ->hidden(),
                                    TextInput::make('harga_jual')
                                        ->label('Harga Jual')
                                        ->numeric()
                                        ->readonly(),
                                    TextInput::make('jml')
                                        ->label('Berat(KG)')
                                        ->default(1)
                                        ->reactive()
                                        ->required()
                                        ->afterStateUpdated(function ($state, $set, $get) {
                                            $totalTagihan = collect($get('items'))
                                                ->sum(fn ($item) => ($item['harga_jual'] ?? 0) * ($item['jml'] ?? 0));
                                            $set('tagihan', $totalTagihan);
                                        }),
                                    DatePicker::make('tgl')
                                        ->default(today())
                                        ->required(),
                                ])
                                ->columns(['md' => 4])
                                ->addable()
                                ->deletable()
                                ->reorderable()
                                ->createItemButtonLabel('Tambah Layanan')
                                ->minItems(1)
                                ->required(),
                    
                            // Tombol Proses
                            Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('Proses')
                                    ->action(function ($get) {
                                        // Simpan data penjualan
                                        $penjualan = Penjualan::updateOrCreate(
                                            ['no_faktur' => $get('no_faktur')],
                                            [
                                                'tgl' => $get('tgl'),
                                                'pembeli_id' => $get('pembeli_id'),
                                                'status' => 'pesan',
                                                'tagihan' => $get('tagihan'),
                                            ]
                                        );
                    
                                        // Simpan data layanan yang dipilih
                                        foreach ($get('items') as $item) {
                                            PenjualanLayanan::updateOrCreate(
                                                [
                                                    'penjualan_id' => $penjualan->id,
                                                    'id_layanan' => $item['id_layanan'],
                                                ],
                                                [
                                                    'harga_beli' => $item['harga_beli'],
                                                    'harga_jual' => $item['harga_jual'],
                                                    'jml' => $item['jml'],
                                                    'tgl' => $item['tgl'],
                                                ]
                                            );
                                        }
                    
                                        // Hitung total tagihan
                                        $totalTagihan = PenjualanLayanan::where('penjualan_id', $penjualan->id)
                                            ->sum(DB::raw('harga_jual * jml'));
                    
                                        // Update tagihan di tabel penjualan
                                        $penjualan->update(['tagihan' => $totalTagihan]);
                                    })
                                    ->label('Proses')
                                    ->color('primary'),
                            ]),
                        ]),
                    Wizard\Step::make('Pembayaran')
                        ->schema([
                            Placeholder::make('Tabel Pembayaran')
                                ->content(fn ($get) => view('filament.components.penjualan-table', [
                                    'pembayarans' => Penjualan::where('no_faktur', $get('no_faktur'))->get(),
                                ])),
                        ]),
                ])->columnSpan(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('no_faktur')->label('No Faktur')->searchable(),
                TextColumn::make('pembeli.nama_pembeli')
                    ->label('Nama Pembeli')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'bayar' => 'success',
                        'pesan' => 'warning',
                    }),
                TextColumn::make('tagihan')
                    ->formatStateUsing(fn (string|int|null $state): string => rupiah($state))
                    ->sortable()
                    ->alignment('end'),
                TextColumn::make('created_at')->label('Tanggal')->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'pesan' => 'Pemesanan',
                        'bayar' => 'Pembayaran',
                    ])
                    ->searchable()
                    ->preload(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->headerActions([
                Action::make('downloadPdf')
                    ->label('Unduh PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->color('success')
                    ->action(function () {
                        $penjualan = Penjualan::all();

                        $pdf = Pdf::loadView('pdf.penjualan', ['penjualan' => $penjualan]);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'penjualan-list.pdf'
                        );
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPenjualans::route('/'),
            'create' => Pages\CreatePenjualan::route('/create'),
            'edit' => Pages\EditPenjualan::route('/{record}/edit'),
        ];
    }
}