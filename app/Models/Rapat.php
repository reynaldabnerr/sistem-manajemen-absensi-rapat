<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Rapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'noDokumen_rapat',
        'noRevisi_rapat',
        'tgl_berlaku_rapat',
        'agenda_rapat',
        'hari_rapat',
        'tanggal_rapat',
        'lokasi_rapat',
        'link_absensi',
        'waktu_mulai',
        'waktu_selesai',
    ];

    // Relasi ke KehadiranRapat
    public function kehadirans()
    {
        return $this->hasMany(KehadiranRapat::class, 'rapat_id'); // Relasi ke tabel kehadiran_rapat
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($rapat) {
            $rapat->link_absensi = Str::uuid();
        });
    }

    protected static function booted(): void
    {
        static::creating(function ($rapat) {
            $rapat->link_absensi = Str::uuid();
            $rapat->hari_rapat = \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->translatedFormat('l');
        });

        static::updating(function ($rapat) {
            $rapat->hari_rapat = \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->translatedFormat('l');
        });
    }
}
