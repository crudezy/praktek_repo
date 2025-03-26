<?php

namespace App\Filament\Resources\ShiftKerjasResource\Pages;

use App\Filament\Resources\ShiftKerjasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShiftKerjas extends EditRecord
{
    protected static string $resource = ShiftKerjasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
