<?php

namespace App\Filament\Resources\CoasResource\Pages;

use App\Filament\Resources\CoasResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoas extends EditRecord
{
    protected static string $resource = CoasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
