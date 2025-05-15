<?php
namespace App\Http\Controllers;

use App\Models\Rapat;
use App\Models\KehadiranRapat;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    // Menampilkan form absensi berdasarkan UUID
    public function showForm($uuid)
    {
        $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail(); // Cari rapat berdasarkan UUID
        return view('absensi.form', compact('rapat'));
    }

    public function submitForm(Request $request, $uuid)
    {
        $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail();

        $request->validate([
            'nip_nik' => 'required|string',
            'tanda_tangan' => 'required|string',
        ]);

        $kehadiran = KehadiranRapat::where('rapat_id', $rapat->id)
            ->where('nip_nik', $request->nip_nik)
            ->first();

        if ($kehadiran) {
            // Update tanda tangan
            $kehadiran->update([
                'tanda_tangan' => $request->tanda_tangan,
            ]);
        } else {
            // Validasi tambahan jika peserta baru
            $request->validate([
                'nama' => 'required|string',
                'unit_kerja' => 'required|string',
                'jabatan_tugas' => 'required|string',
            ]);

            $rapat->kehadirans()->create([
                'nama' => $request->nama,
                'nip_nik' => $request->nip_nik,
                'unit_kerja' => $request->unit_kerja,
                'jabatan_tugas' => $request->jabatan_tugas,
                'tanda_tangan' => $request->tanda_tangan,
            ]);
        }
        return redirect()->back()->with('success', 'Absensi berhasil disubmit!');
    }
    
    public function getPesertaByNip(Request $request, $uuid)
    {
        $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail();

        $peserta = KehadiranRapat::where('rapat_id', $rapat->id)
            ->where('nip_nik', $request->nip_nik)
            ->first();

        return response()->json($peserta);
    }


}
