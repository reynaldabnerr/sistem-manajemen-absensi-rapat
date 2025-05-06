<?php
namespace App\Filament\Resources\KehadiranRapatResource\Pages;

use App\Filament\Resources\KehadiranRapatResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKehadiranRapats extends ListRecords
{
    protected static string $resource = KehadiranRapatResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
