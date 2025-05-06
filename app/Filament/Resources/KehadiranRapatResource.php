<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KehadiranRapatResource\Pages;
use App\Models\KehadiranRapat;
use App\Models\Rapat;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Forms\Form;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\ImageColumn;

class KehadiranRapatResource extends Resource
{
    protected static ?string $model = KehadiranRapat::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';
    protected static ?string $navigationGroup = 'Manajemen Rapat';
    protected static ?string $navigationLabel = 'Kehadiran Rapat'; 
    protected static ?int $navigationSort = 2; 

    // Form untuk menambahkan peserta secara manual
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama')->label('Nama')->required(),
                TextInput::make('nip_nik')->label('NIP/NIK')->required(),
                TextInput::make('unit_kerja')->label('Unit Kerja')->required(),
                TextInput::make('jabatan_tugas')->label('Jabatan/Tugas')->required(),
                TextInput::make('tanda_tangan')->label('Tanda Tangan')->required(),
            ]);
    }

    // Tabel yang menampilkan peserta dan tanda tangan mereka
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama')->label('Nama')->searchable(),
                TextColumn::make('nip_nik')->label('NIP/NIK'),
                TextColumn::make('unit_kerja')->label('Unit Kerja'),
                TextColumn::make('jabatan_tugas')->label('Jabatan/Tugas'),
                ImageColumn::make('tanda_tangan')
                    ->label('Tanda Tangan')
                    ->getStateUsing(function ($record) {
                        // Jika tanda tangan berupa URL atau base64 image, tampilkan gambarnya
                        return $record->tanda_tangan ? $record->tanda_tangan : 'default-image.jpg'; // ganti default-image.jpg dengan gambar default jika tidak ada tanda tangan
                    })
                    ->size(50), // Anda dapat mengatur ukuran gambar sesuai kebutuhan
            ])
            ->filters([
                // Menambahkan filter opsional untuk memilih rapat
                SelectFilter::make('rapat_id')
                    ->label('Rapat')
                    ->relationship('rapat', 'agenda_rapat') // Relasi untuk memilih rapat
                    ->searchable()
                    ->default(null), // Defaultnya tidak memilih rapat, menampilkan semua rapat
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }

    // Halaman untuk mengakses dan mengelola peserta
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKehadiranRapats::route('/'),
            'create' => Pages\CreateKehadiranRapat::route('/create'),
            'edit' => Pages\EditKehadiranRapat::route('/{record}/edit'),
        ];
    }
}
