<?php

namespace App\Filament\Resources;

use App\Models\User;
use App\Models\UnitKerja;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\UserResource\Pages;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Manajemen Pengguna';
    protected static ?string $navigationLabel = 'Users';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->label('Name')
                ->required(),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required(),

            TextInput::make('password')
                ->label('Password')
                ->password()
                ->minLength(8)
                ->required(fn(string $context): bool => $context === 'create')
                ->dehydrateStateUsing(fn($state) => $state ? bcrypt($state) : null)
                ->dehydrated(fn($state) => filled($state)),

            Select::make('role')
                ->label('Role')
                ->options([
                    'admin' => 'Admin',
                    'superadmin' => 'Superadmin',
                ])
                ->required(),

            Select::make('unit_kerja_id')
                ->label('Unit Kerja')
                ->relationship('unitKerja', 'nama')
                ->searchable()
                ->preload()
                ->required()
                ->visible(fn() => auth()->user()?->role === 'superadmin')
                ->createOptionForm([ // tetap bisa nambah unit kerja baru dari dropdown
                    TextInput::make('nama')
                        ->label('Nama Unit Kerja')
                        ->required()
                        ->unique(UnitKerja::class, 'nama'),
                ])
                ->createOptionUsing(fn(array $data): int => UnitKerja::create($data)->id),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->searchable()->sortable(),
                TextColumn::make('email')->label('Email')->searchable()->sortable(),
                TextColumn::make('role')
                    ->label('Role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'superadmin' => 'danger',
                        'admin' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('unitKerja.nama')->label('Unit Kerja')->sortable()->searchable(),
                TextColumn::make('created_at')->label('Created At')->dateTime()->sortable(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->check() && auth()->user()->role === 'superadmin';
    }

    public static function mutateFormDataBeforeCreate(array $data): array
    {
        // Jika superadmin, cari atau buat Unit Kerja bernama 'Superadmin'
        if ($data['role'] === 'superadmin') {
            $data['unit_kerja_id'] = UnitKerja::firstOrCreate(
                ['nama' => 'Superadmin']
            )->id;
        }

        // Jika admin tanpa unit kerja, fallback ke unit kerja pertama
        if ($data['role'] === 'admin' && empty($data['unit_kerja_id'])) {
            $data['unit_kerja_id'] = UnitKerja::first()?->id;
        }

        return $data;
    }
}
