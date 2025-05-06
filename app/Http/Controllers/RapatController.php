<?php
namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\KehadiranRapat;

class RapatController extends Controller
{
    // Menampilkan daftar peserta yang mengisi absensi
    public function showAbsensi($id)
    {
        $rapat = Rapat::findOrFail($id);
        $peserta = KehadiranRapat::where('rapat_id', $rapat->id)->get();
        
        return view('rapat.absensi', compact('rapat', 'peserta'));
    }
}
