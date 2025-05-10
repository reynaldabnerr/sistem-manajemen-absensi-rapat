@extends('layouts.app')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-50 py-12">
        <div class="container mx-auto px-4 max-w-4xl">
            <div class="bg-white rounded-2xl shadow-2xl p-8 border border-gray-100 transform transition-all duration-300 hover:shadow-3xl">
                <div class="text-center mb-10">
                    <div class="inline-block p-3 rounded-full bg-blue-50 mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-3">{{ $rapat->agenda_rapat }}</h1>
                    <p class="text-gray-600 text-lg">Silakan isi form absensi di bawah ini</p>
                </div>

                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8 rounded-lg transform transition-all duration-300 animate-fade-in">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <form action="{{ url('/absensi/' . $rapat->link_absensi) }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="relative group">
                            <label for="nama" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Nama Lengkap
                            </label>
                            <input type="text" id="nama" name="nama" 
                                class="peer block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 ease-in-out bg-white"
                                placeholder="Masukkan nama lengkap" required>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 ease-in-out group-hover:ring-2 group-hover:ring-blue-100 pointer-events-none"></div>
                        </div>

                        <div class="relative group">
                            <label for="nip_nik" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                </svg>
                                NIP/NIK
                            </label>
                            <input type="text" id="nip_nik" name="nip_nik" 
                                class="peer block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 ease-in-out bg-white"
                                placeholder="Masukkan NIP/NIK" required>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 ease-in-out group-hover:ring-2 group-hover:ring-blue-100 pointer-events-none"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <div class="relative group">
                            <label for="unit_kerja" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Unit Kerja
                            </label>
                            <input type="text" id="unit_kerja" name="unit_kerja" 
                                class="peer block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 ease-in-out bg-white"
                                placeholder="Masukkan unit kerja" required>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 ease-in-out group-hover:ring-2 group-hover:ring-blue-100 pointer-events-none"></div>
                        </div>

                        <div class="relative group">
                            <label for="jabatan_tugas" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Jabatan/Tugas
                            </label>
                            <input type="text" id="jabatan_tugas" name="jabatan_tugas" 
                                class="peer block w-full px-4 py-3 rounded-xl border border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all duration-200 ease-in-out bg-white"
                                placeholder="Masukkan jabatan atau tugas" required>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 ease-in-out group-hover:ring-2 group-hover:ring-blue-100 pointer-events-none"></div>
                        </div>
                    </div>

                    <div class="mt-10">
                        <label for="signature-pad" class="block text-sm font-medium text-gray-700 mb-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                            </svg>
                            Tanda Tangan
                        </label>
                        <div class="border-2 border-gray-200 rounded-xl p-4 bg-gray-50 hover:border-blue-200 transition-all duration-200 ease-in-out group">
                            <canvas id="signature-pad" class="w-full rounded-lg bg-white shadow-sm" height="200"></canvas>
                            <div class="absolute inset-0 rounded-xl transition-all duration-200 ease-in-out group-hover:ring-2 group-hover:ring-blue-100 pointer-events-none"></div>
                        </div>
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                        <p class="text-xs text-gray-500 mt-3 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Silakan tanda tangan di dalam kotak di atas
                        </p>
                    </div>

                    <div class="flex flex-col sm:flex-row sm:justify-between gap-4 mt-12">
                        <button type="button" onclick="clearSignature()" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-red-500 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-400 transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Hapus Tanda Tangan
                        </button>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-8 py-3 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 ease-in-out transform hover:scale-105 hover:shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Kirim Absensi
                        </button>
                    </div>
                </form>
            </div>
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
                    alertBox.className = 'fixed top-4 right-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg shadow-lg z-50 transform transition-all duration-300 ease-in-out animate-fade-in';
                    alertBox.innerHTML = `
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium">Tanda tangan tidak boleh kosong!</p>
                            </div>
                        </div>
                    `;
                    document.body.appendChild(alertBox);
                    
                    // Remove the alert after 3 seconds with fade out effect
                    setTimeout(() => {
                        alertBox.style.opacity = '0';
                        setTimeout(() => alertBox.remove(), 300);
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
