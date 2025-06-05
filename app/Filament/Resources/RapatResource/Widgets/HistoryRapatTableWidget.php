<?php

namespace App\Filament\Resources\RapatResource\Widgets;

use App\Filament\Resources\RapatResource;
use App\Models\Rapat;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str; // Untuk Str::words
use Carbon\Carbon; // Untuk format tanggal dan waktu

class HistoryRapatTableWidget extends BaseWidget
{
    protected static ?string $heading = 'Daftar Rapat yang Telah Terlaksana'; // Judul untuk widget tabel
    protected int | string | array $columnSpan = 'full'; // Agar widget memenuhi lebar halaman
    public $tableRecordsPerPage = 10; // Set records per page using the property

    /**
     * Mendefinisikan query untuk mengambil data rapat yang sudah lampau.
     */
    protected function getTableQuery(): Builder
    {
        return Rapat::query()
            ->where(function (Builder $query) {
                // Kasus 1: Rapat dengan waktu_selesai yang sudah terisi dan sudah lampau
                $query->whereNotNull('waktu_selesai')
                      ->where(DB::raw("TIMESTAMP(tanggal_rapat, waktu_selesai)"), '<', now());
            })
            ->orWhere(function (Builder $query) {
                // Kasus 2: Rapat dengan waktu_selesai kosong, gunakan waktu_mulai, dan sudah lampau
                // Ini berarti rapat dianggap lampau jika waktu mulainya sudah lewat
                $query->whereNull('waktu_selesai')
                      ->where(DB::raw("TIMESTAMP(tanggal_rapat, waktu_mulai)"), '<', now());
            })
            // Urutkan berdasarkan tanggal dan waktu efektif rapat (selesai atau mulai) secara descending
            // Sehingga rapat yang baru saja selesai muncul di atas
            ->orderByRaw("TIMESTAMP(tanggal_rapat, COALESCE(waktu_selesai, waktu_mulai)) DESC");
    }

    /**
     * Mendefinisikan kolom-kolom yang akan ditampilkan pada tabel history.
     */
    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('agenda_rapat')
                ->label('Agenda')
                ->limit(40) // Batasi panjang teks yang ditampilkan
                ->tooltip(fn ($record) => $record->agenda_rapat) // Tampilkan teks penuh saat hover
                ->searchable(),

            Tables\Columns\TextColumn::make('jadwal_pelaksanaan')
                ->label('Jadwal Pelaksanaan')
                ->getStateUsing(function (Rapat $record): string {
                    $tanggal = Carbon::parse($record->tanggal_rapat)->locale('id')->translatedFormat('l, d M Y');
                    $mulai = Carbon::parse($record->waktu_mulai)->format('H:i');
                    $selesai = $record->waktu_selesai ? Carbon::parse($record->waktu_selesai)->format('H:i') : 'Selesai';
                    return "{$tanggal} ({$mulai} - {$selesai} WITA)";
                })
                ->sortable(['tanggal_rapat', 'waktu_mulai']), // Memungkinkan sorting berdasarkan tanggal dan waktu mulai

            Tables\Columns\TextColumn::make('lokasi_rapat')
                ->label('Lokasi')
                ->limit(30)
                ->tooltip(fn ($record) => $record->lokasi_rapat)
                ->searchable(),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Dibuat Pada')
                ->dateTime('d M Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true), // Sembunyikan default, bisa ditampilkan user
        ];
    }

    /**
     * Mendefinisikan aksi yang bisa dilakukan pada setiap baris tabel.
     * Untuk history, biasanya hanya aksi lihat detail.
     */
    protected function getTableActions(): array
    {
        return [
            Tables\Actions\Action::make('lihatKehadiran')
                ->label('Lihat Kehadiran')
                ->icon('heroicon-o-eye')
                ->url(fn (Rapat $record): string => RapatResource::getUrl('viewKehadiran', ['record' => $record]))
                ->openUrlInNewTab(), // Opsional: buka di tab baru
        ];
    }

    /**
     * Menonaktifkan aksi massal (bulk actions) karena tidak relevan untuk history.
     */
    protected function getTableBulkActions(): array
    {
        return [];
    }

    /**
     * Mengaktifkan paginasi tabel.
     */
    protected function isTablePaginationEnabled(): bool
    {
        return true;
    }



}
