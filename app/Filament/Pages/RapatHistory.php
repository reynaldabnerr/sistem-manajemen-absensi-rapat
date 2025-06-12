<?php
namespace App\Filament\Pages;

use App\Models\Rapat;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
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