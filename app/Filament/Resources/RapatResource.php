<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RapatResource\Pages;
use App\Models\Rapat;
use App\Models\UnitKerja;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Support\Str;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Hidden;
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
                Select::make('jenis_rapat')
                    ->label('Jenis Rapat')
                    ->options([
                        'online' => 'Online',
                        'offline' => 'Offline',
                        'hybrid' => 'Hybrid',
                    ])
                    ->required()
                    ->reactive() // <-- WAJIB agar bisa trigger visibility field lain
                    ->afterStateUpdated(fn (callable $set) => $set('lokasi_rapat', null)), // opsional: reset saat berubah
                TextInput::make('lokasi_rapat')
                    ->label('Lokasi Rapat')
                    ->visible(fn ($get) => in_array($get('jenis_rapat'), ['offline', 'hybrid']))
                    ->required(fn ($get) => in_array($get('jenis_rapat'), ['offline', 'hybrid']))
                    ->dehydrated(fn ($get) => in_array($get('jenis_rapat'), ['offline', 'hybrid'])),
                TextInput::make('link_meeting')
                    ->label('Link Meeting')
                    ->visible(fn ($get) => in_array($get('jenis_rapat'), ['online', 'hybrid']))
                    ->nullable()
                    ->required()
                    ->dehydrated(fn ($get) => in_array($get('jenis_rapat'), ['online', 'hybrid'])),

                TimePicker::make('waktu_mulai')->label('Waktu Mulai')->required()->withoutSeconds(),
                TimePicker::make('waktu_selesai')->label('Waktu Selesai')->helperText('Boleh dikosongkan jika belum diketahui')->nullable()->withoutSeconds()
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
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

                TextColumn::make('link_absensi')
                    ->label('Copy Link')
                    ->getStateUsing(fn($record) => url('/absensi/' . $record->link_absensi))
                    ->copyable()
                    ->limit(20),

                TextColumn::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->modalHeading('Edit Rapat')
                    ->modalSubmitActionLabel('Simpan Perubahan'),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('lihatKehadiran')
                    ->label('Lihat Kehadiran')
                    ->icon('heroicon-o-eye')
                    ->url(fn($record) => RapatResource::getUrl('viewKehadiran', ['record' => $record])),
            ])
            ->defaultSort('tanggal_rapat', 'desc');
    }

    /**
     * Batasi query agar hanya superadmin bisa lihat semua.
     */
    public static function getEloquentQuery(): \Illuminate\Database\Eloquent\Builder
    {
        $query = parent::getEloquentQuery();
        
        $user = auth()->user();
        
        // Superadmin can see all rapats
        if ($user->role === 'superadmin') {
            return $query;
        }
        
        // Admin can only see rapats they created
        return $query->where('user_id', $user->id);
        
        // If using unit_kerja based filtering:
        // return $query->where('unit_kerja_id', $user->unit_kerja_id);
    }

    /**
     * Isi otomatis unit_kerja_id dan user_id saat membuat rapat
     */
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        // Make sure unit_kerja_id is set
        if (!isset($data['unit_kerja_id'])) {
            // If user is not superadmin, use their unit_kerja_id
            if (auth()->user()->role !== 'superadmin') {
                $data['unit_kerja_id'] = auth()->user()->unit_kerja_id;
            } else {
                // For superadmin, use the first unit_kerja if not specified
                $data['unit_kerja_id'] = $data['unit_kerja_id'] ?? \App\Models\UnitKerja::first()?->id;
            }
        }

        $data['user_id'] = auth()->id();
        
        return $data;
    }

    public static function mutateFormDataBeforeSave(array $data): array
    {
        // Make sure unit_kerja_id is set
        if (!isset($data['unit_kerja_id'])) {
            // If user is not superadmin, use their unit_kerja_id
            if (auth()->user()->role !== 'superadmin') {
                $data['unit_kerja_id'] = auth()->user()->unit_kerja_id;
            } else {
                // For superadmin, use the first unit_kerja if not specified
                $data['unit_kerja_id'] = $data['unit_kerja_id'] ?? \App\Models\UnitKerja::first()?->id;
            }
        }

        $data['user_id'] = auth()->id();
    
        return $data;
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRapats::route('/'),
            'viewKehadiran' => ViewKehadiranRapat::route('/{record}/kehadiran'),
        ];
    }
}
