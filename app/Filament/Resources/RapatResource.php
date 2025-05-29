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
use Filament\Forms\Components\TimePicker;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\RapatResource\Pages\ViewKehadiranRapat;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Filament\Tables\Columns\ImageColumn;

class RapatResource extends Resource
{
    protected static ?string $model = Rapat::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Manajemen Rapat';
    protected static ?string $navigationLabel = 'Rapat'; 
    protected static ?int $navigationSort = 1;
    protected static ?string $pluralModelLabel = 'Rapat';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('noDokumen_rapat')->label('No. Dokumen Rapat')->required(),
                TextInput::make('noRevisi_rapat')->label('No. Revisi Rapat')->nullable(),
                DatePicker::make('tgl_berlaku_rapat')->label('Tanggal Berlaku')->required(),
                TextInput::make('agenda_rapat')->label('Agenda Rapat')->required(),
                DatePicker::make('tanggal_rapat')->label('Tanggal Rapat')->required(),
                TextInput::make('lokasi_rapat')->label('Lokasi Rapat')->required(),
                TimePicker::make('waktu_mulai')->label('Waktu Mulai')->required(),
                TimePicker::make('waktu_selesai')->label('Waktu Selesai')->helperText('Boleh dikosongkan jika belum diketahui')->nullable(),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('agenda_rapat')
                    ->label('Agenda')
                    ->getStateUsing(fn ($record) => Str::words($record->agenda_rapat, 3, '...'))
                    ->tooltip(fn ($record) => $record->agenda_rapat)
                    ->searchable(),
                // Gabungkan hari dan tanggal rapat dalam satu kolom
                TextColumn::make('tanggal_rapat')
                    ->label('Jadwal')
                    ->getStateUsing(fn ($record) =>
                        \Carbon\Carbon::parse($record->tanggal_rapat)
                            ->locale('id')
                            ->translatedFormat('l, d M Y') // Contoh: Senin, 13 Mei 2025
                    ),
                TextColumn::make('lokasi_rapat')
                    ->label('Lokasi')
                    ->getStateUsing(fn ($record) => Str::words($record->lokasi_rapat, 3, '...'))
                    ->tooltip(fn ($record) => $record->lokasi_rapat),
                TextColumn::make('waktu')
                    ->label('Waktu')
                    ->getStateUsing(fn ($record) =>
                        \Carbon\Carbon::parse($record->waktu_mulai)->format('H:i') .
                        ' - ' .
                        ($record->waktu_selesai
                            ? \Carbon\Carbon::parse($record->waktu_selesai)->format('H:i')
                            : 'selesai'
                        ) . ' WITA'
                    ),
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
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Rapat')
                    ->modalSubmitActionLabel('Simpan Perubahan'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('lihatKehadiran')
                    ->label('Lihat Kehadiran')
                    ->icon('heroicon-o-eye')
                    ->url(fn ($record) => RapatResource::getUrl('viewKehadiran', ['record' => $record])),
            ])
            ->defaultSort('tanggal_rapat', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRapats::route('/'),
            'history' => Pages\HistoryRapat::route('/history'),
            'viewKehadiran' => ViewKehadiranRapat::route('/{record}/kehadiran'),
        ];
    }
}
