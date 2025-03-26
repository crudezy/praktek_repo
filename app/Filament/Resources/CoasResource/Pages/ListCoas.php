<?php

namespace App\Filament\Resources\CoasResource\Pages;

use App\Filament\Resources\CoasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoas extends ListRecords
{
    protected static string $resource = CoasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
