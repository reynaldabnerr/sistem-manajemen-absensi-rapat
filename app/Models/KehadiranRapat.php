<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KehadiranRapat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'nip_nik',
        'unit_kerja',
        'jabatan_tugas',
        'tanda_tangan',
        'rapat_id', // Foreign key
        'status',
        'instansi',
        'no_telepon',
        'email',
    ];

    // Relasi ke Rapat
    public function rapat()
    {
        return $this->belongsTo(Rapat::class, 'rapat_id');
    }
    protected $table = 'kehadiran_rapat';
}
