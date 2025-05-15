<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\LayananResource\Pages;
use App\Filament\Resources\LayananResource\RelationManagers;
use App\Models\Layanan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;



class LayananResource extends Resource
{
    protected static ?string $model = Layanan::class;

    protected static ?string $navigationIcon = 'heroicon-o-computer-desktop';
    protected static ?string $navigationLabel = 'Layanan';
    protected static ?string $navigationGroup = 'Transaksi';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_layanan')
                    ->default(fn () => Layanan::getIdLayanan())
                    ->label('Id Layanan')
                    ->readOnly()
                    ->required(),
                Select::make('nama_paket')
                    ->label('Nama Paket')
                    ->options([
                        'Cuci Kering' => 'Cuci Kering',
                        'Cuci Setrika' => 'Cuci Setrika'
                    ])
                    ->required()
                    ->reactive() // Membuat dropdown reaktif
                    ->afterStateUpdated(fn ($state, callable $set) => match ($state) {
                        'Cuci Kering' => tap($set('harga', 4000), fn () => $set('keterangan', 'Paket ini mencakup layanan pencucian dan pengeringan pakaian.')),
                        'Setrika' => tap($set('harga', 5000), fn () => $set('keterangan', 'Paket ini mencakup layanan penyetrikaan pakaian.')),
                        'Cuci Kering & Setrika' => tap($set('harga', 6000), fn () => $set('keterangan', 'Paket ini mencakup layanan pencucian dan penyetrikaan pakaian.')),
                        default => tap($set('harga', null), fn () => $set('keterangan', null)),
                    }),
    
                TextInput::make('harga')
                    ->dehydrateStateUsing(fn ($state) => (int) str_replace('.', '', $state ?? 0)) // Simpan data dalam format angka
                    ->required(),
                Select::make('time_estimasi')
                    ->label('Time Estimasi')
                    ->required()
                    ->options(
                        [
                        '1 Hari' =>'1 Hari', 
                        '2 Hari' =>'2 Hari', 
                        '3 Hari' =>'3 Hari'
                        ]),
                FileUpload::make('foto')
                        ->directory('foto')
                        ->required(),
                TextInput::make('keterangan')
                    ->label('Keterangan')
                    ->maxLength(255)
                    ->required()
                    ->readOnly(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_layanan')
                    ->label('ID Layanan')
                    ->sortable()
                    ->searchable(),
            
                TextColumn::make('nama_paket')
                    ->label('Nama Paket')
                    ->sortable()
                    ->searchable(),
            
                TextColumn::make('harga')
                    ->label('Harga')
                    ->sortable()
                    ->money('IDR'), // Format sebagai mata uang Rupiah
            
                TextColumn::make('time_estimasi')
                    ->label('Estimasi Waktu')
                    ->sortable(),

                ImageColumn::make('foto'),
            
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->sortable()
                    ->limit(50) // Batasi panjang teks agar tidak terlalu panjang
                    ->tooltip(fn ($state) => $state), // Tampilkan keterangan lengkap saat hover
            ])
            ->defaultSort('id_layanan', 'asc')
            ->filters([
                //
            ])
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
            'index' => Pages\ListLayanans::route('/'),
            'create' => Pages\CreateLayanan::route('/create'),
            'edit' => Pages\EditLayanan::route('/{record}/edit'),
        ];
    }
}