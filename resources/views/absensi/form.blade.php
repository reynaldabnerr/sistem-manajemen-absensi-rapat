@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-10 max-w-3xl">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-6 border-b pb-4">{{ $rapat->agenda_rapat }}</h1>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <!-- Heroicon name: solid/check-circle -->
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ url('/absensi/' . $rapat->link_absensi) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" 
                            class="peer block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Masukkan nama lengkap" required>
                    </div>

                    <div class="relative">
                        <label for="nip_nik" class="block text-sm font-medium text-gray-700 mb-1">NIP/NIK</label>
                        <input type="text" id="nip_nik" name="nip_nik" 
                            class="peer block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Masukkan NIP/NIK" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="relative">
                        <label for="unit_kerja" class="block text-sm font-medium text-gray-700 mb-1">Unit Kerja</label>
                        <input type="text" id="unit_kerja" name="unit_kerja" 
                            class="peer block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Masukkan unit kerja" required>
                    </div>

                    <div class="relative">
                        <label for="jabatan_tugas" class="block text-sm font-medium text-gray-700 mb-1">Jabatan/Tugas</label>
                        <input type="text" id="jabatan_tugas" name="jabatan_tugas" 
                            class="peer block w-full px-4 py-3 rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition"
                            placeholder="Masukkan jabatan atau tugas" required>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="signature-pad" class="block text-sm font-medium text-gray-700 mb-1">Tanda Tangan</label>
                    <div class="border border-gray-300 rounded-lg p-2 bg-gray-50">
                        <canvas id="signature-pad" class="w-full rounded-lg bg-white" height="200"></canvas>
                    </div>
                    <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                    <p class="text-xs text-gray-500 mt-1">Silakan tanda tangan di dalam kotak di atas</p>
                </div>

                <div class="flex flex-col sm:flex-row sm:justify-between gap-3 mt-8">
                    <button type="button" onclick="clearSignature()" 
                        class="inline-flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        Hapus Tanda Tangan
                    </button>
                    <button type="submit" 
                        class="inline-flex justify-center items-center px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Kirim Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const canvas = document.getElementById('signature-pad');
            
            // Create signature pad with proper configuration
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(0, 0, 0)',
                minWidth: 1,
                maxWidth: 2.5
            });

            // Fix signature pad resolution issues
            function resizeCanvas() {
                // Get the current content
                const data = signaturePad.toData();
                
                // When ratio changes, clear the canvas
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                
                // Set canvas dimensions correctly
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                
                // Scale the context to ensure correct drawing
                const context = canvas.getContext("2d");
                context.scale(ratio, ratio);
                
                // Clear and restore the signature if there was one
                signaturePad.clear();
                if (data) {
                    signaturePad.fromData(data);
                }
            }

            // Initial resize and setup
            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            // Form submission handler with validation
            document.querySelector('form').addEventListener('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    
                    // Create a styled alert
                    const alertBox = document.createElement('div');
                    alertBox.className = 'fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-md z-50';
                    alertBox.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">Tanda tangan tidak boleh kosong!</p>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(alertBox);
                    
                    // Remove the alert after 3 seconds
                    setTimeout(() => {
                        alertBox.remove();
                    }, 3000);
                } else {
                    document.getElementById('tanda_tangan').value = signaturePad.toDataURL();
                }
            });

            // Clear signature function
            window.clearSignature = function() {
                signaturePad.clear();
            }
        });
    </script>
    @endpush
@endsection
