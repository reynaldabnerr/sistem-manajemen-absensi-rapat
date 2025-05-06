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
    // Cari rapat berdasarkan link_absensi
    $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail();

    // Validasi input
    $request->validate([
        'nama' => 'required|string',
        'nip_nik' => 'required|unique:kehadiran_rapat,nip_nik,NULL,id,rapat_id,' . $rapat->id,
        'unit_kerja' => 'required|string',
        'jabatan_tugas' => 'required|string',
        'tanda_tangan' => 'required|string',
    ]);

    // Menyimpan data absensi ke tabel kehadiran_rapat
    $kehadiran = $rapat->kehadirans()->create([
        'nama' => $request->nama,
        'nip_nik' => $request->nip_nik,
        'unit_kerja' => $request->unit_kerja,
        'jabatan_tugas' => $request->jabatan_tugas,
        'tanda_tangan' => $request->tanda_tangan, // Simpan Base64 di sini
    ]);

    // Redirect kembali dengan pesan sukses
    return redirect()->back()->with('success', 'Absensi berhasil disubmit!');
}

}
