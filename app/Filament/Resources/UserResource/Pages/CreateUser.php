<?php
namespace App\Filament\Resources\UserResource\Pages;

use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = \App\Filament\Resources\UserResource::class;

    protected function getFormSchema(): array
    {
        return [
            // Other fields
            TextInput::make('name')
                ->label('Name')
                ->required(),
            TextInput::make('email')
                ->label('Email')
                ->required(),
            TextInput::make('role')
                ->label('Role')
                ->required(),
            TextInput::make('password')
                ->label('Password')
                ->required()
                ->password(),
        ];
    }

    // This function is used to handle the record creation
    protected function handleRecordCreation(array $data): \Illuminate\Database\Eloquent\Model
    {
        // Hash the password before saving it
        $data['password'] = Hash::make($data['password']);  // Ensure password is hashed before saving

        // Create the user record and return the instance
        return User::create($data);
    }
}
