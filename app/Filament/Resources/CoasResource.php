<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\TextInput; //kita menggunakan textinput
use Filament\Forms\Components\Grid;

use Filament\Tables\Columns\TextColumn;

use App\Filament\Resources\CoasResource\Pages;
use App\Filament\Resources\CoasResource\RelationManagers;
use App\Models\Coas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoasResource extends Resource
{
    protected static ?string $model = Coas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Grid::make(1) // Membuat hanya 1 kolom
            ->schema([
                TextInput::make('header_akun')
                    ->required()
                    ->placeholder('Masukkan header akun')
                ,
                TextInput::make('kode_akun')
                    ->required()
                    ->placeholder('Masukkan kode akun')
                ,
                TextInput::make('nama_akun')
                    ->autocapitalize('words')
                    ->label('Nama akun')
                    ->required()
                    ->placeholder('Masukkan nama akun')
                ,
            ]),
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('header_akun'),
                TextColumn::make('kode_akun'),
                TextColumn::make('nama_akun'), 
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('header_akun')
                    ->options([
                        1 => 'Aset/Aktiva',
                        2 => 'Utang',
                        3 => 'Modal',
                        4 => 'Pendapatan',
                        5 => 'Beban',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListCoas::route('/'),
            'create' => Pages\CreateCoas::route('/create'),
            'edit' => Pages\EditCoas::route('/{record}/edit'),
        ];
    }
}
