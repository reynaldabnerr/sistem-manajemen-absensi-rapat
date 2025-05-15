<?php

use Illuminate\Support\Facades\Route;
use App\Models\Rapat;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\AbsensiController;

Route::get('/absensi/{uuid}', [AbsensiController::class, 'showForm']);
Route::post('/absensi/{uuid}', [AbsensiController::class, 'submitForm']);
Route::get('/absensi/{uuid}/cek-nip', [AbsensiController::class, 'getPesertaByNip']);

use App\Http\Controllers\RapatController;
Route::get('/rapat/{id}/absensi', [RapatController::class, 'showAbsensi'])->name('rapat.absensi');

Route::get('/admin/rapats/{rapat}/kehadiran/export', function (Rapat $rapat) {
    $kehadiran = $rapat->kehadirans;

    $pdf = Pdf::loadView('exports.kehadiran-pdf', [
        'rapat' => $rapat,
        'kehadiran' => $kehadiran,
    ]);

    $pdf->setPaper('A4', 'portrait');

    // ✅ Tempatkan teks tepat di lokasi kolom metadata "Halaman"
    $domPdf = $pdf->getDomPDF();
    $canvas = $domPdf->get_canvas();

    $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
        $text = "Halaman {$pageNumber} dari {$pageCount}";
        $font = $fontMetrics->getFont('Times New Roman', 'normal');
        $canvas->text(465, 95, $text, $font, 7); // ⬅️ sesuaikan posisi di dalam cell
    });

    return $pdf->download('kehadiran-rapat-' . $rapat->id . '.pdf');
})->name('rapats.kehadiran.export');
