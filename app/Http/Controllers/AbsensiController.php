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
        $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail();
        return view('absensi.form', compact('rapat'));
    }

    public function submitForm(Request $request, $uuid)
    {
        $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail();
        $status = $request->input('status');

        // Validasi umum
        $rules = [
            'status' => 'required|in:pegawai,eksternal',
            'nama' => 'required|string',
            'unit_kerja' => 'required|string',
            'jabatan_tugas' => 'required|string',
            'tanda_tangan' => 'required|string',
        ];

        if ($status === 'pegawai') {
            // Validasi khusus pegawai
            $rules['nip_nik'] = 'required|string';
        } else {
            // Validasi khusus eksternal
            $rules['instansi'] = 'required|string';
            $rules['nip_nik'] = 'nullable|string';
            $rules['no_telepon'] = 'nullable|string';
            $rules['email'] = 'nullable|email';
        }

        $validated = $request->validate($rules);

        // Cek apakah data pegawai sudah ada
        $kehadiran = null;
        if ($status === 'pegawai') {
            $kehadiran = KehadiranRapat::where('rapat_id', $rapat->id)
                ->where('nip_nik', $validated['nip_nik'])
                ->first();
        }

        if ($kehadiran) {
            // Sudah ada → update tanda tangan
            $kehadiran->update([
                'tanda_tangan' => $validated['tanda_tangan'],
            ]);
        } else {
            // Data baru → insert
            KehadiranRapat::create([
                'rapat_id' => $rapat->id,
                'status' => $status,
                'nama' => $validated['nama'],
                'nip_nik' => $validated['nip_nik'] ?? null,
                'unit_kerja' => $validated['unit_kerja'],
                'jabatan_tugas' => $validated['jabatan_tugas'],
                'tanda_tangan' => $validated['tanda_tangan'],
                'instansi' => $validated['instansi'] ?? null,
                'no_telepon' => $validated['no_telepon'] ?? null,
                'email' => $validated['email'] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil disubmit!');
    }

    // Untuk autofill by NIP/NIK
    public function getPesertaByNip(Request $request, $uuid)
    {
        $rapat = Rapat::where('link_absensi', $uuid)->firstOrFail();

        $peserta = KehadiranRapat::where('rapat_id', $rapat->id)
            ->where('nip_nik', $request->nip_nik)
            ->first();

        return response()->json($peserta);
    }
}
