<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRapat extends CreateRecord
{
    protected static string $resource = RapatResource::class;
    
    // Add this method to ensure user_id is set
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Set the user_id to the current authenticated user
        $data['user_id'] = auth()->id();
        
        // Set unit_kerja_id if not already set
        if (!isset($data['unit_kerja_id'])) {
            $data['unit_kerja_id'] = auth()->user()->unit_kerja_id;
        }
        
        return $data;
    }
}
