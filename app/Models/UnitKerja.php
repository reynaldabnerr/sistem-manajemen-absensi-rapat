<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitKerja extends Model
{
    use HasFactory;

    // Izinkan nama diisi lewat mass-assignment
    protected $fillable = ['nama'];

    /**
     * Relasi ke User
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relasi ke Rapat
     */
    public function rapats()
    {
        return $this->hasMany(Rapat::class);
    }
}
