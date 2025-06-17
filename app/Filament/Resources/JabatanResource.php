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
    protected static ?string $navigationGroup = 'Master Data Karyawan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('id_jabatan')
                    ->default(fn () => Jabatan::getIdJabatan())
                    ->label('Id Jabatan')
                    ->readOnly()
                    ->required(),

                Select::make('nama_jabatan')
                    ->label('Nama Jabatan')
                    ->options([
                        'Manager' => 'Manager',
                        'Karyawan Cuci' => 'Karyawan Cuci',
                        'Kasir' => 'Kasir'
                    ])
                    ->required()
                    ->reactive() // Membuat dropdown reaktif
                    ->afterStateUpdated(fn ($state, callable $set) => match ($state) {
                        'Manager' => tap($set('harga', 10000)),
                        'Karyawan Cuci' => tap($set('harga', 4000)),
                        'Kasir' => tap($set('harga', 4000)),
                        default => tap($set('harga', null)),
                    }),
                TextInput::make('harga')
                    ->label('Gaji')
                    ->dehydrateStateUsing(fn ($state) => (int) str_replace('.', '', $state ?? 0)) // Simpan data dalam format angka
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id_jabatan')
                    ->label('ID Jabatan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('nama_jabatan')
                    ->label('Nama Jabatan')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('gaji')
                    ->label('Gaji')
                    ->sortable()
                    ->money('IDR'), // Format sebagai mata uang Rupiah

                TextColumn::make('created_at')
                    ->label('Created At')
            ])
            ->defaultSort('id_jabatan', 'asc')
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