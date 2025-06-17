<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

// untuk form dan table
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;

// untuk model ke user
use App\Models\User;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';
    // merubah nama label menjadi Pegawai
    protected static ?string $navigationLabel = 'Pegawai';

    // tambahan buat grup masterdata
    protected static ?string $navigationGroup = 'Master Data Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //direlasikan ke tabel user
                Select::make('user_id')
                    ->label('User Id')
                    ->relationship('user', 'email')
                    ->searchable() // Menambahkan fitur pencarian
                    ->preload() // Memuat opsi lebih awal untuk pengalaman yang lebih cepat
                    ->required()
                    ->live()
                , 

                TextInput::make('kode_pegawai')
                    ->default(fn () => Pegawai::getKodePegawai()) // Ambil default dari method getKodePegawai
                    ->label('Kode Pegawai')
                    ->required()
                    ->readonly() // Membuat field menjadi read-only
                ,
                TextInput::make('nama_pegawai')
                    ->required()
                    ->placeholder('Masukkan nama pegawai') // Placeholder untuk membantu pengguna
                ,
                TextInput::make('alamat')
                    ->required()
                    ->placeholder('Masukkan alamat pegawai') // Placeholder untuk membantu pengguna
                ,
                TextInput::make('telepon')
                    ->required()
                    ->placeholder('Masukkan nomor telepon') // Placeholder untuk membantu pengguna
                    ->numeric() // Validasi agar hanya angka yang diizinkan
                    ->prefix('+62') // Contoh: Menambahkan prefix jika diperlukan
                    ->extraAttributes(['pattern' => '^[0-9]+$', 'title' => 'Masukkan angka yang diawali dengan 0']) // Validasi dengan pattern regex
                ,
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_pegawai'),
                TextColumn::make('nama_pegawai'),
                TextColumn::make('alamat'),
                TextColumn::make('telepon'),
            ])
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
            'index' => Pages\ListPegawais::route('/'),
            'create' => Pages\CreatePegawai::route('/create'),
            'edit' => Pages\EditPegawai::route('/{record}/edit'),
        ];
    }
}