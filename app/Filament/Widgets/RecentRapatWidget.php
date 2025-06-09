<?php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use App\Models\Rapat;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;

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
            ])
            ->defaultSort('tanggal_rapat', 'desc')
            ->striped()
            ->paginated(false);
    }
}
