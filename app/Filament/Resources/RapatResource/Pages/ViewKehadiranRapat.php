<?php

namespace App\Filament\Resources\RapatResource\Pages;

use App\Filament\Resources\RapatResource;
use App\Models\KehadiranRapat;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ViewKehadiranRapat extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = RapatResource::class;
    protected static string $view = 'filament.resources.rapat-resource.pages.view-kehadiran-rapat';

    public $record;

    public function getTitle(): string
    {
        return 'Daftar Kehadiran Rapat';
    }


    public function getTableQuery(): Builder
    {
        return KehadiranRapat::query()->where('rapat_id', $this->record);
    }

    public function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->limit(30)
                ->tooltip(fn ($record) => $record->nama),

            Tables\Columns\BadgeColumn::make('status')
                ->label('Jenis Peserta')
                ->sortable()
                ->searchable()
                ->colors([
                    'info' => fn ($state) => $state === 'pegawai',
                    'warning' => fn ($state) => $state === 'eksternal',
                ])
                ->formatStateUsing(fn ($state) => ucfirst($state)),

            Tables\Columns\TextColumn::make('nip_nik')
                ->label('NIP/NIK')
                ->limit(20)
                ->tooltip(fn ($record) => $record->nip_nik),

            Tables\Columns\TextColumn::make('unit_kerja')
                ->label('Unit Kerja')
                ->limit(20)
                ->tooltip(fn ($record) => $record->unit_kerja),

            Tables\Columns\TextColumn::make('jabatan_tugas')
                ->label('Jabatan/Tugas')
                ->limit(20)
                ->tooltip(fn ($record) => $record->jabatan_tugas),

            Tables\Columns\TextColumn::make('instansi')
                ->label('Instansi')
                ->limit(20)
                ->tooltip(fn ($record) => $record->instansi),

            Tables\Columns\TextColumn::make('no_telepon')
                ->label('No. Telepon')
                ->limit(20)
                ->tooltip(fn ($record) => $record->no_telepon),

            Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->limit(20)
                ->tooltip(fn ($record) => $record->email),

            Tables\Columns\ImageColumn::make('tanda_tangan')
                ->label('Tanda Tangan'),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Created At')
                ->limit(20)
                ->tooltip(fn ($record) => $record->created_at),
        ];
    }


    public function getTableHeaderActions(): array
    {
        return [
            Tables\Actions\Action::make('Export PDF')
                ->label('Export PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->url(route('rapats.kehadiran.export', $this->record))
                ->openUrlInNewTab(),
            Tables\Actions\CreateAction::make()
                ->label('+ Peserta Rapat')
                ->disableCreateAnother()
                ->modalHeading('Tambah Kehadiran')
                ->modalSubmitActionLabel('Simpan')
                ->form([
                    \Filament\Forms\Components\Select::make('status')
                        ->label('Jenis Peserta')
                        ->options([
                            'pegawai' => 'Pegawai',
                            'eksternal' => 'Eksternal',
                        ])
                        ->default('pegawai')
                        ->required()
                        ->reactive(),

                    TextInput::make('nama')->required(),
                    TextInput::make('nip_nik')->label('NIP/NIK')->required(),
                    TextInput::make('unit_kerja')->required(),
                    TextInput::make('jabatan_tugas')->label('Jabatan/Tugas')->required(),

                    TextInput::make('instansi')
                        ->required(fn ($get) => $get('status') === 'eksternal')
                        ->visible(fn ($get) => $get('status') === 'eksternal'),
                    TextInput::make('no_telepon')
                        ->label('No. Telepon')
                        ->visible(fn ($get) => $get('status') === 'eksternal'),
                    TextInput::make('email')
                        ->email()
                        ->visible(fn ($get) => $get('status') === 'eksternal'),

                    TextInput::make('tanda_tangan')->required(),
                ])
                ->mutateFormDataUsing(fn ($data) => array_merge($data, ['rapat_id' => $this->record]))
                ->after(function () {
                    $this->dispatch('notify', [
                        'title' => 'Kehadiran berhasil ditambahkan!',
                        'type' => 'success',
                    ]);
                }),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Tables\Actions\EditAction::make()
                ->form([
                    \Filament\Forms\Components\Select::make('status')
                        ->label('Jenis Peserta')
                        ->options([
                        'pegawai' => 'Pegawai',
                        'eksternal' => 'Eksternal',
                        ])
                        ->required()
                        ->reactive(),

                    TextInput::make('nama')->required(),
                    TextInput::make('nip_nik')->label('NIP/NIK')
                    ->required(fn ($get) => $get('status') === 'pegawai'),
                    TextInput::make('unit_kerja')->required(),
                    TextInput::make('jabatan_tugas')->required(),

                    TextInput::make('instansi')
                        ->required(fn ($get) => $get('status') === 'eksternal')
                        ->visible(fn ($get) => $get('status') === 'eksternal'),
                    TextInput::make('no_telepon')
                        ->visible(fn ($get) => $get('status') === 'eksternal'),
                    TextInput::make('email')
                        ->email()
                        ->visible(fn ($get) => $get('status') === 'eksternal'),

                    TextInput::make('tanda_tangan')
                        ->required(),
                ]),
            Tables\Actions\DeleteAction::make(),
        ];
    }
}