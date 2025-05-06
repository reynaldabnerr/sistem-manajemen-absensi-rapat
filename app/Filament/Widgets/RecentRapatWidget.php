<?php
namespace App\Filament\Widgets;

use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Table;
use App\Models\Rapat;
use Filament\Tables\Columns\TextColumn;
use Carbon\Carbon;  // Ensure Carbon is imported

class RecentRapatWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(Rapat::latest())  // Querying the 'Rapat' model and ordering by the most recent
            ->columns([
                TextColumn::make('agenda_rapat')
                    ->label('Agenda Rapat')
                    ->sortable(),
                
                // Custom column to display 'hari_rapat' and 'tanggal_rapat' combined
                TextColumn::make('combined_hari_tanggal')
                    ->label('Hari/Tanggal Rapat')
                    ->sortable()
                    ->getStateUsing(function ($record) {
                        $tanggalRapat = Carbon::parse($record->tanggal_rapat);  // Parse string to Carbon date
                        return $record->hari_rapat . ' / ' . $tanggalRapat->format('d-m-Y');  // Format the date
                    }),

                TextColumn::make('lokasi_rapat')
                    ->label('Lokasi Rapat')
                    ->sortable(),
                // You can add more columns as needed
            ]);
    }
}
