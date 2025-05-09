<?php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use App\Models\Rapat;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Carbon\Carbon;

class RecentRapatWidget extends BaseWidget
{
    protected static ?string $heading = 'Rapat Terbaru';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(Rapat::latest()->limit(5))
            ->columns([
                TextColumn::make('agenda_rapat')
                    ->label('Agenda Rapat')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),

                TextColumn::make('tanggal_rapat')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('waktu_mulai')
                    ->label('Waktu')
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->format('H:i'))
                    ->sortable(),

                TextColumn::make('lokasi_rapat')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => fn ($state) => Carbon::parse($state)->isPast(),
                        'success' => fn ($state) => Carbon::parse($state)->isFuture(),
                        'warning' => fn ($state) => Carbon::parse($state)->isToday(),
                    ])
                    ->formatStateUsing(fn ($state) => Carbon::parse($state)->isPast() ? 'Selesai' : 
                        (Carbon::parse($state)->isToday() ? 'Hari Ini' : 'Akan Datang')),
            ])
            ->defaultSort('tanggal_rapat', 'desc')
            ->striped()
            ->paginated(false);
    }
}
