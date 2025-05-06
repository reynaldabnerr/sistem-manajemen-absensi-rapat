<?php

namespace App\Filament\Resources\KehadiranRapatResource\Pages;

use App\Filament\Resources\KehadiranRapatResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKehadiranRapat extends EditRecord
{
    protected static string $resource = KehadiranRapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
