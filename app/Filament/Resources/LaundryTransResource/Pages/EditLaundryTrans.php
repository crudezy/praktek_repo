<?php

namespace App\Filament\Resources\LaundryTransResource\Pages;

use App\Filament\Resources\LaundryTransResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaundryTrans extends EditRecord
{
    protected static string $resource = LaundryTransResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
