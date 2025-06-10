<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRapat extends CreateRecord
{
    protected static string $resource = RapatResource::class;
    
    // This is the critical part - make sure this method exists
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Force set the user_id to the current user
        $data['user_id'] = auth()->id();
        
        return $data;
    }
}
