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
            Tables\Columns\TextColumn::make('nama'),
            Tables\Columns\TextColumn::make('nip_nik'),
            Tables\Columns\TextColumn::make('unit_kerja'),
            Tables\Columns\TextColumn::make('jabatan_tugas'),
            Tables\Columns\ImageColumn::make('tanda_tangan'),
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
                ->label('Tambah Peserta Rapat')
                ->form([
                    TextInput::make('nama')->required(),
                    TextInput::make('nip_nik')->label('NIP/NIK')->required(),
                    TextInput::make('unit_kerja')->required(),
                    TextInput::make('jabatan_tugas')->required(),
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
                TextInput::make('nama')->required(),
                TextInput::make('nip_nik')->label('NIP/NIK')->required(),
                TextInput::make('unit_kerja')->required(),
                TextInput::make('jabatan_tugas')->required(),
                FileUpload::make('tanda_tangan')
                    ->label('Tanda Tangan')
                    ->image()
                    ->directory('tanda-tangan')
                    ->imagePreviewHeight('150')
                    ->required(),
            ]),
            Tables\Actions\DeleteAction::make(),
        ];
    }
}
