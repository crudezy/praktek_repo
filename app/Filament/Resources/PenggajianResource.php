<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PenggajianResource\Pages;
use App\Models\Penggajian;
use App\Models\Pegawai;
use App\Models\Jabatan;
use App\Models\ListPenggajian;
use App\Models\PenggajianPegawai;
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

class PenggajianResource extends Resource
{
    protected static ?string $model = Penggajian::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';

    protected static ?string $navigationLabel = 'Penggajian';

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
                                        ->default(fn () => Penggajian::getKodeFaktur())
                                        ->label('Nomor Faktur')
                                        ->required()
                                        ->readonly(),
                                    DateTimePicker::make('tgl')->default(now()),
                                    Select::make('id_pegawai')
                                        ->label('Pegawai')
                                        ->options(Pegawai::pluck('nama_pegawai', 'id')->toArray())
                                        ->required()
                                        ->placeholder('Pilih Pegawai'),
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
                        Wizard\Step::make('Pilih Jabatan')
                        ->schema([
                            Repeater::make('items')
                                ->relationship('penggajianpegawai')
                                ->schema([
                                    Select::make('id_jabatan')
                                        ->label('Jabatan')
                                        ->options(Jabatan::pluck('nama_jabatan', 'id')->toArray())
                                        ->required()
                                        ->reactive()
                                        ->placeholder('Pilih Jabatan')
                                        ->afterStateUpdated(function ($state, $set) {
                                            $jabatan = Jabatan::find($state);
                                            $set('harga_beli', $jabatan ? $jabatan->gaji : 0);
                                            $set('harga_jual', $jabatan ? $jabatan->gaji : 0);
                                        }),
                                    TextInput::make('harga_beli')
                                        ->label('Harga Beli')
                                        ->numeric()
                                        ->default(fn ($get) => $get('id_jabatan') ? Jabatan::find($get('id_jabatan'))?->gaji ?? 0 : 0)
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
                                ->createItemButtonLabel('Tambah Jabatan')
                                ->minItems(1)
                                ->required(),
                    
                            // Tombol Proses
                            Forms\Components\Actions::make([
                                Forms\Components\Actions\Action::make('Proses')
                                    ->action(function ($get) {
                                        // Simpan data penjualan
                                        $penggajian = Penggajian::updateOrCreate(
                                            ['no_faktur' => $get('no_faktur')],
                                            [
                                                'tgl' => $get('tgl'),
                                                'id_pegawai' => $get('id_pegawai'),
                                                'status' => 'pesan',
                                                'tagihan' => $get('tagihan'),
                                            ]
                                        );
                    
                                        // Simpan data Jabatan yang dipilih
                                        foreach ($get('items') as $item) {
                                            PenggajianPegawai::updateOrCreate(
                                                [
                                                    'penggajian_id' => $penggajian->id,
                                                    'id_jabatan' => $item['id_jabatan'],
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
                                        $totalTagihan = PenggajianPegawai::where('penggajian_id', $penggajian->id)
                                            ->sum(DB::raw('harga_jual * jml'));
                    
                                        // Update tagihan di tabel Penggajian
                                        $penggajian->update(['tagihan' => $totalTagihan]);
                                    })
                                    ->label('Proses')
                                    ->color('primary'),
                            ]),
                        ]),
                    Wizard\Step::make('ListPenggajian')
                        ->schema([
                            Placeholder::make('Tabel ListPenggajian')
                                ->content(fn ($get) => view('filament.components.penggajian-table', [
                                    'penggajian' => Penggajian::where('no_faktur', $get('no_faktur'))->get(),
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
                TextColumn::make('pegawai.nama_pegawai')
                    ->label('Nama Pegawai')
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
                        $penggajian = Penggajian::all();

                        $pdf = Pdf::loadView('pdf.Penggajian', ['Penggajian' => $penggajian]);

                        return response()->streamDownload(
                            fn () => print($pdf->output()),
                            'Penggajian-list.pdf'
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
            'index' => Pages\ListPenggajians::route('/'),
            'create' => Pages\CreatePenggajian::route('/create'),
            'edit' => Pages\EditPenggajian::route('/{record}/edit'),
        ];
    }
}