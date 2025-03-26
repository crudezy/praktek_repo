<?php

namespace App\Filament\Resources\ShiftKerjasResource\Pages;

use App\Filament\Resources\ShiftKerjasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShiftKerjas extends ListRecords
{
    protected static string $resource = ShiftKerjasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
