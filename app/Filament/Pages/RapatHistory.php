<?php
namespace App\Filament\Pages;

use App\Models\Rapat;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Carbon\Carbon;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

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
                $now = now(); // Current date and time
                
                $query = Rapat::query()
                    ->where(function ($q) use ($now) {
                        // Show only meetings that have truly ended
                        $q->where(function ($subQuery) use ($now) {
                            // Past dates
                            $subQuery->whereDate('tanggal_rapat', '<', $now->toDateString());
                        })->orWhere(function ($subQuery) use ($now) {
                            // Today with end time passed
                            $subQuery->whereDate('tanggal_rapat', '=', $now->toDateString())
                                    ->where(function ($endTimeQuery) use ($now) {
                                        // Either has passed end time
                                        $endTimeQuery->where(function ($setEndTime) use ($now) {
                                                $setEndTime->whereNotNull('waktu_selesai')
                                                          ->whereTime('waktu_selesai', '<', $now->toTimeString());
                                            })
                                            // Or has no end time but start time was more than 2 hours ago
                                            // (assuming meetings without end times last about 2 hours)
                                            ->orWhere(function ($noEndTime) use ($now) {
                                                $twoHoursAgo = $now->copy()->subHours(2);
                                                $noEndTime->whereNull('waktu_selesai')
                                                         ->whereTime('waktu_mulai', '<', $twoHoursAgo->toTimeString());
                                            });
                                    });
                        });
                    });
                    
                // If not superadmin, only show own meetings
                $user = auth()->user();
                if ($user->role !== 'superadmin') {
                    $query->where('user_id', $user->id);
                }
                
                return $query->orderBy('tanggal_rapat', 'desc')
                             ->orderBy('waktu_mulai', 'desc');
            })
            ->columns([
                Tables\Columns\TextColumn::make('agenda_rapat')
                    ->label('Agenda')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn($record) => $record->agenda_rapat),

                Tables\Columns\TextColumn::make('tanggal_rapat')
                    ->label('Tanggal')
                    ->sortable()
                    ->date('d M Y'),
                    
                Tables\Columns\TextColumn::make('waktu_mulai')
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
                    
                Tables\Columns\TextColumn::make('jenis_rapat')
                    ->label('Jenis')
                    ->badge()
                    ->formatStateUsing(fn($state) => ucfirst($state))
                    ->color(fn($state) => match ($state) {
                        'online' => 'success',
                        'offline' => 'warning',
                        'hybrid' => 'info',
                        default => 'gray',
                    }),
                    
                Tables\Columns\TextColumn::make('kehadirans_count')
                    ->counts('kehadirans')
                    ->label('Jumlah Peserta')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('viewAttendance')
                    ->label('Lihat Kehadiran')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => route('filament.admin.resources.rapats.viewKehadiran', $record))
                    ->visible(fn($record) => $record->kehadirans()->count() > 0),

                Tables\Actions\Action::make('exportPDF')
                    ->label('Export PDF')
                    ->icon('heroicon-o-document-arrow-down')
                    ->url(fn($record) => route('rapats.kehadiran.export', $record))
                    ->openUrlInNewTab()
                    ->visible(fn($record) => $record->kehadirans()->count() > 0),
                
                // Add delete action here
                Tables\Actions\DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading(fn($record) => "Hapus Rapat \"{$record->agenda_rapat}\"?")
                    ->modalDescription('Rapat yang dihapus tidak dapat dikembalikan dan semua data kehadiran akan ikut terhapus.')
                    ->modalSubmitActionLabel('Hapus Permanen')
                    ->successNotificationTitle('Rapat berhasil dihapus')
            ])
            ->defaultSort('tanggal_rapat', 'desc')
            ->filters([
                // You can add filters here if needed
            ])
            ->bulkActions([
                // Add bulk delete action if you want to delete multiple records at once
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Rapat Terpilih?')
                        ->modalDescription('Semua rapat yang dipilih akan dihapus secara permanen beserta data kehadirannya.')
                        ->modalSubmitActionLabel('Hapus Permanen')
                        ->successNotificationTitle('Rapat terpilih berhasil dihapus')
                ]),
            ]);
    }
}