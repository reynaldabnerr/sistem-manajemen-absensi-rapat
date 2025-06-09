<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRapats extends ListRecords
{
    protected static string $resource = RapatResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('+ Rapat') // Ubah label sesuai keinginan
                ->modalHeading('Form Tambah Rapat')
                ->modalSubmitActionLabel('Simpan Rapat')
        ];
    }
}
