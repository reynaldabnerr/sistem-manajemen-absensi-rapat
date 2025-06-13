<?php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use App\Models\Rapat;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RecentRapatWidget extends BaseWidget
{
    protected static ?string $heading = 'Rapat Terbaru';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Rapat::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('agenda_rapat')
                    ->label('Agenda')
                    ->getStateUsing(fn($record) => Str::words($record->agenda_rapat, 3, '...'))
                    ->tooltip(fn($record) => $record->agenda_rapat)
                    ->searchable(),

                TextColumn::make('tanggal_rapat')
                    ->label('Jadwal')
                    ->sortable()
                    ->getStateUsing(
                        fn($record) =>
                        \Carbon\Carbon::parse($record->tanggal_rapat)
                            ->locale('id')
                            ->translatedFormat('l, d M Y')
                    ),

                TextColumn::make('jenis_rapat')
                    ->label('Jenis')
                    ->badge()
                    ->sortable()
                    ->color(fn($state) => match ($state) {
                        'online' => 'success',
                        'offline' => 'warning',
                        'hybrid' => 'info',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn($state) => ucfirst($state)),

                TextColumn::make('lokasi_rapat')
                    ->label('Lokasi/Link')
                    ->getStateUsing(fn($record) => match ($record->jenis_rapat) {
                        'online' => Str::limit($record->link_meeting, 15, '...'),
                        'offline' => Str::words($record->lokasi_rapat, 3, '...'),
                        'hybrid' => Str::words($record->lokasi_rapat, 3, '...') . ' | ' . Str::limit($record->link_meeting, 15, '...'),
                    })
                    ->tooltip(fn($record) => match ($record->jenis_rapat) {
                        'online' => $record->link_meeting,
                        'offline' => $record->lokasi_rapat,
                        'hybrid' => 'Lokasi: ' . $record->lokasi_rapat . ' | Link: ' . $record->link_meeting,
                    }),

                TextColumn::make('waktu_mulai')
                    ->label('Waktu')
                    ->getStateUsing(
                        fn($record) =>
                        \Carbon\Carbon::parse($record->waktu_mulai)->format('H:i') .
                        ' - ' .
                        ($record->waktu_selesai
                            ? \Carbon\Carbon::parse($record->waktu_selesai)->format('H:i')
                            : 'selesai'
                        ) . ' WITA'
                    ),

                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
            ])
            ->defaultSort('tanggal_rapat', 'desc');
    }
}

