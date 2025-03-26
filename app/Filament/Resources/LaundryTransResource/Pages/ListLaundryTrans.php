<?php

namespace App\Filament\Resources\LaundryTransResource\Pages;

use App\Filament\Resources\LaundryTransResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLaundryTrans extends ListRecords
{
    protected static string $resource = LaundryTransResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
