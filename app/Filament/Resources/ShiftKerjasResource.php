<?php

namespace App\Filament\Resources;

use Filament\Forms\Components\Radio;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\ImageColumn; 
use Filament\Tables\Columns\TimeColumn; 
use Filament\Forms\Components\FileUpload;

use App\Filament\Resources\ShiftKerjasResource\Pages;
use App\Filament\Resources\ShiftKerjasResource\RelationManagers;
use App\Models\ShiftKerjas;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShiftKerjasResource extends Resource
{
    protected static ?string $model = ShiftKerjas::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Radio::make('nama_shift')
                ->label('Nama Shift')
                ->options([
                    'Pagi' => 'Pagi',
                    'Siang' => 'Siang',
                    'Malam' => 'Malam',
                ])
                ->required(),

            TextInput::make('nama_karyawan')
                ->label('Nama Karyawan')
                ->required(),

            DatePicker::make('tanggal_shift')
                ->label('Tanggal Shift Kerja')
                ->required(),

            TimePicker::make('jam_mulai')
                ->label('Jam Mulai')
                ->required(),
            
            TimePicker::make('jam_selesai')
                ->label('Jam Selesai')
                ->required(),

            FileUpload::make('bukti_shift')
                ->label('Bukti Shift')
                ->image()
                ->directory('images')
                ->required()
            //
        ]);

    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('nama_shift')
                ->label('Nama Shift')
                ->sortable(),

            TextColumn::make('nama_karyawan')
                ->label('Nama Karyawan')
                ->sortable(),

            TextColumn::make('tanggal_shift')
                ->label('Tanggal Shift Kerja')
                ->sortable()
                ->date('d-m-Y'), // Format tanggal (contoh: 27-03-2025)

            TextColumn::make('jam_mulai')
                ->label('Jam Mulai')
                ->sortable()
                ->time('H:i'), // Format 24 jam (contoh: 14:30)

            TextColumn::make('jam_selesai')
                ->label('Jam Mulai')
                ->sortable()
                ->time('H:i'), // Format 24 jam (contoh: 14:30)

            ImageColumn::make('bukti_shift')
                ->label('Bukti Shift')
                ->disk('public') // Sesuai dengan konfigurasi di config/filesystems.php
                ->visibility('public'),
            
                //
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
            'index' => Pages\ListShiftKerjas::route('/'),
            'create' => Pages\CreateShiftKerjas::route('/create'),
            'edit' => Pages\EditShiftKerjas::route('/{record}/edit'),
        ];
    }
}
