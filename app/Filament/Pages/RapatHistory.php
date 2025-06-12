<?php
namespace App\Filament\Pages;

use App\Models\Rapat;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\Action;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;
use Illuminate\Support\Str;

class RapatHistory extends Page implements HasTable
{
    use InteractsWithTable;
    
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationLabel = 'Riwayat Rapat';
    protected static ?string $navigationGroup = 'Manajemen Rapat';
    protected static ?int $navigationSort = 2;
    protected static string $view = 'filament.pages.rapat-history';
    
    public function getTitle(): string
    {
        return 'Riwayat Rapat';
    }
    
    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                $query = Rapat::query()
                    ->where('tanggal_rapat', '<', Carbon::today());
                    
                // If not superadmin, only show own meetings
                $user = auth()->user();
                if ($user->role !== 'superadmin') {
                    $query->where('user_id', $user->id);
                }
                
                return $query;
            })
            ->columns([
                TextColumn::make('agenda_rapat')
                    ->label('Agenda')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn($record) => $record->agenda_rapat),

                TextColumn::make('tanggal_rapat')
                    ->label('Tanggal')
                    ->sortable()
                    ->date('d M Y'),
                    
                TextColumn::make('waktu_mulai')
                    ->label('Waktu')
                    ->formatStateUsing(
                        fn($record) =>
                        Carbon::parse($record->waktu_mulai)->format('H:i') .
                        ' - ' .
                        ($record->waktu_selesai
                            ? Carbon::parse($record->waktu_selesai)->format('H:i')
                            : 'selesai'
                        )
                    ),
                    
                TextColumn::make('jenis_rapat')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'online' => 'success',
                        'offline' => 'warning',
                        'hybrid' => 'info',
                        default => 'gray',
                    }),
                    
                TextColumn::make('kehadirans_count')
                    ->counts('kehadirans')
                    ->label('Jumlah Peserta')
                    ->sortable(),
            ])
            ->actions([
                Action::make('viewAttendance')
                    ->label('Lihat Kehadiran')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.resources.rapats.viewKehadiran', $record))
                    ->visible(fn($record) => $record->kehadirans()->count() > 0),

                Action::make('exportPDF')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('rapats.kehadiran.export', $record))
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->kehadirans()->count() > 0),
            ])
            ->defaultSort('tanggal_rapat', 'desc')
            ->filters([
                // You can add filters here if needed
            ]);
    }
}