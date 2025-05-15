<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JabatanResource\Pages;
use App\Filament\Resources\JabatanResource\RelationManagers;
use App\Models\Jabatan;
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

class JabatanResource extends Resource
{
    protected static ?string $model = Jabatan::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';
    protected static ?string $navigationLabel = 'Jabatan';
    protected static ?string $navigationGroup = 'Master Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_jabatan')
                    ->label('ID Jabatan')
                    ->default(Jabatan::generateNewId())  // <- panggil generate ID dari model
                    ->readOnly()
                    ->dehydrated(true) // tidak ikut submit, karena nanti otomatis di model juga
                    ->placeholder('ID akan dibuat otomatis'),

                TextInput::make('nama_jabatan')
                    ->required()
                    ->label('Nama Jabatan')
                    ->placeholder('Masukkan nama jabatan'),
                TextInput::make('gaji')
                    ->label('Gaji')
                    ->numeric()
                    ->required()
                    ->placeholder('Masukkan gaji')
                    ->prefix('Rp ')  
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id_jabatan')
                    ->label('ID Jabatan'),

                Tables\Columns\TextColumn::make('nama_jabatan')
                    ->label('Nama Jabatan'),

                Tables\Columns\TextColumn::make('gaji')
                    ->label('Gaji')
                    ->money('IDR'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
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
            'index' => Pages\ListJabatans::route('/'),
            'create' => Pages\CreateJabatan::route('/create'),
            'edit' => Pages\EditJabatan::route('/{record}/edit'),
        ];
    }
}