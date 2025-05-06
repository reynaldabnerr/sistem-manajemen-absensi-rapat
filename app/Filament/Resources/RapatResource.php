<?php
namespace App\Filament\Resources;

use App\Filament\Resources\RapatResource\Pages;
use App\Models\Rapat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table; 
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\TextColumn;

class RapatResource extends Resource
{
    protected static ?string $model = Rapat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Rapat';
    protected static ?string $navigationLabel = 'Rapat'; 
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('noDokumen_rapat')->label('No. Dokumen Rapat')->required(),
                TextInput::make('noRevisi_rapat')->label('No. Revisi Rapat')->nullable(),
                DatePicker::make('tgl_berlaku_rapat')->label('Tanggal Berlaku')->required(),
                TextInput::make('agenda_rapat')->label('Agenda Rapat')->required(),
                TextInput::make('hari_rapat')->label('Hari Rapat')->required(),
                DatePicker::make('tanggal_rapat')->label('Tanggal Rapat')->required(),
                TextInput::make('lokasi_rapat')->label('Lokasi Rapat')->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('agenda_rapat')->label('Agenda')->searchable(),
                // Gabungkan hari dan tanggal rapat dalam satu kolom
                TextColumn::make('hari_rapat')
                    ->label('Hari/Tanggal')
                    ->getStateUsing(function ($record) {
                        // Gabungkan hari dan tanggal rapat
                        return $record->hari_rapat . ' / ' . \Carbon\Carbon::parse($record->tanggal_rapat)->format('d M Y');
                    }),
                TextColumn::make('lokasi_rapat')->label('Lokasi'),
                // Menambahkan kolom Copy Link
                TextColumn::make('link_absensi')
                    ->label('Copy Link')
                    ->getStateUsing(function ($record) {
                        // Menyusun link URL untuk absensi
                        return 'http://127.0.0.1:8000/absensi/' . $record->link_absensi;
                    })
                    ->copyable() // Menambahkan kemampuan untuk menyalin link
                    ->limit(20), // Batasi panjang teks untuk ditampilkan
                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
            ])
            ->actions([
                // Tombol edit dan delete
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->defaultSort('tanggal_rapat', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRapats::route('/'),
            'create' => Pages\CreateRapat::route('/create'),
            'edit' => Pages\EditRapat::route('/{record}/edit'),
        ];
    }
}
