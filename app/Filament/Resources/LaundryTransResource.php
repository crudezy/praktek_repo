<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaundryTransResource\Pages;
use App\Filament\Resources\LaundryTransResource\RelationManagers;
use App\Models\LaundryTrans;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;

use Illuminate\Database\Eloquent\SoftDeletingScope;

class LaundryTransResource extends Resource
{
    protected static ?string $model = LaundryTrans::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {

        return $form
        ->schema([
            TextInput::make('id_pelanggan')
                ->default(fn () => LaundryTrans::getIdPelanggan()) // Membuat ID pelanggan otomatis
                ->label('ID Pelanggan')
                ->required()
                ->maxLength(10)
                ->readOnly(),

            TextInput::make('nama_pelanggan')
                ->label('Nama Pelanggan')
                ->placeholder('Masukkan Nama Pelanggan')
                ->required()
                ->maxLength(255),

            DatePicker::make('tanggal_order')
                ->label('Tanggal Pesanan')
                ->required(),

            DatePicker::make('tanggal_pengambilan')
                ->label('Tanggal Pengambilan')
                ->required(),

            TextInput::make('total_berat')
                ->label('Berat/Kilo (6k)')
                ->placeholder('Masukkan Total Berat')
                ->required()
                ->numeric() // Pastikan input hanya angka
                ->step(0.01) // Izinkan input dengan dua angka desimal (contoh: 15.75 kg)
                ->minValue(0.1) // Minimal 0.1 kg, tidak boleh 0 atau negatif
                ->maxValue(10000) // Maksimal 10.000 kg
                ->live() // Perbarui nilai saat diubah
                ->dehydrateStateUsing(fn ($state) => (float) str_replace(',', '.', $state)) // Simpan sebagai angka desimal
                ->afterStateHydrated(fn ($state, callable $set) => 
                    $set('total_berat', number_format((float) $state, 2, '.', '')) // Pastikan format angka desimal benar saat diedit
                )
                ->afterStateUpdated(fn ($state, callable $set) => 
                    $set('total_harga', number_format((float) $state * 6000, 2, ',', '.')) // Hitung total harga otomatis dengan 2 desimal
                ),
            
            Select::make('paket_layanan')
                ->label('Paket Layanan')
                ->options([
                    'Laundry Kiloan' => 'Laundry Kiloan',
                    'Dry Cleaning' => 'Dry Cleaning',
                    'Laundry Self Service' => 'Laundry Self Service',
                    'Laundry On Demand' => 'Laundry On Demand',
                ])
                ->required(),

            Select::make('status_laundry')
                ->label('Status Laundry')
                ->options([
                    'Diproses' => 'Diproses',
                    'Selesai' => 'Selesai',
                    'Diambil' => 'Diambil',
                ])
                ->required(),

            TextInput::make('total_harga')
                ->label('Total Harga')
                ->required()
                ->minValue(0)
                ->reactive()
                ->dehydrateStateUsing(fn ($state) => (int) str_replace('.', '', $state ?? 0)) // Simpan sebagai angka
                ->afterStateHydrated(fn ($state, callable $set) => 
                    $set('total_harga', number_format((float) $state, 0, ',', '.')) // Format Rupiah
                )
                ->extraAttributes(['id' => 'total_harga'])
                ->placeholder('Masukkan Harga Total')
                ->disabled(), // Tidak bisa diedit manual, hanya otomatis dari total_berat
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_pelanggan')
                    ->label('ID Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('nama_pelanggan')
                    ->label('Nama Pelanggan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('tanggal_order')
                    ->label('Tanggal Pesanan')
                    ->date()
                    ->sortable(),

                TextColumn::make('tanggal_pengambilan')
                    ->label('Tanggal Pengambilan')
                    ->date()
                    ->sortable(),

                TextColumn::make('total_berat')
                    ->label('Total Berat (Kg)')
                    ->sortable(),

                TextColumn::make('paket_layanan')
                    ->label('Paket Layanan')
                    ->sortable(),

                TextColumn::make('status_laundry')
                    ->label('Status Laundry')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Diproses' => 'warning',
                        'Selesai' => 'success',
                        'Diambil' => 'gray',
                        default => 'secondary',
                    }),

                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->sortable()
                    ->money('IDR'), // Format sebagai mata uang Rupiah
            ])
            ->filters([
                SelectFilter::make('status_laundry')
                    ->label('Filter Status')
                    ->options([
                        'Diproses' => 'Diproses',
                        'Selesai' => 'Selesai',
                        'Diambil' => 'Diambil',
                    ]),
            ])
            ->defaultSort('tanggal_order', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListLaundryTrans::route('/'),
            'create' => Pages\CreateLaundryTrans::route('/create'),
            'edit' => Pages\EditLaundryTrans::route('/{record}/edit'),
        ];
    }
}
