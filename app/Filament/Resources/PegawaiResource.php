<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PegawaiResource\Pages;
use App\Filament\Resources\PegawaiResource\RelationManagers;
use App\Models\Pegawai;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;

// Added 
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;


use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PegawaiResource extends Resource
{
    protected static ?string $model = Pegawai::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Pegawai';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
             ->schema([
                        TextInput::make('id_pegawai')
                            ->label('ID Pegawai')
                            ->default(Pegawai::generateNewId())  // <- panggil generate ID dari model
                            ->disabled()  // readonly, tidak bisa diedit user
                            ->dehydrated(true) // tidak ikut submit, karena nanti otomatis di model juga
                            ->placeholder('ID akan dibuat otomatis'),

                        TextInput::make('nama_pegawai')
                            ->required()
                            ->label('Nama Pegawai')
                            ->placeholder('Masukkan nama pegawai'),

                        TextInput::make('alamat')
                            ->required()
                            ->label('Alamat')
                            ->placeholder('Masukkan alamat'),

                        TextInput::make('no_hp')
                            ->required()
                            ->label('Nomor Telepon')
                            ->placeholder('Masukkan nomor telepon'),

                        Select::make('shift_kerja')
                        ->options([
                            'Pagi' => 'Pagi',
                            'Malam' => 'Malam',
                        ])
                        ->default('Pagi')
             ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_pegawai')->label('ID Pegawai'),
                Tables\Columns\TextColumn::make('nama_pegawai')->label('Nama Pegawai'),
                Tables\Columns\TextColumn::make('alamat')->label('Alamat'),
                Tables\Columns\TextColumn::make('no_hp')->label('Nomor Telepon'),
                Tables\Columns\TextColumn::make('shift_kerja')->label('Shift Kerja'),
                Tables\Columns\TextColumn::make('created_at')->label('Created At')
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
