@extends('layouts.app')

@section('content')
        <div class="max-w-4xl mx-auto transform transition-all duration-300 hover:scale-[1.005]">
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div style="background-color: #002147;" class="px-8 py-6">
                    <div class="space-y-3">
                        <h1 class="text-2xl font-bold text-white">
                            {{ $rapat->agenda_rapat }}
                        </h1>

                        <div class="flex items-center text-sm text-white">
                            <x-heroicon-o-calendar class="h-5 w-5 mr-2" />
                            {{ \Carbon\Carbon::parse($rapat->tanggal_rapat)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                        </div>
                        
                        <div class="text-sm text-white space-y-3">
                            @if ($rapat->jenis_rapat === 'online')
                                <div class="flex items-center">
                                    <x-heroicon-o-link class="h-5 w-5 mr-2" />
                                    <a href="{{ $rapat->link_meeting }}" class="underline text-blue-200" target="_blank">Link Meeting</a>
                                </div>
                            @elseif ($rapat->jenis_rapat === 'offline')
                                <div class="flex items-center">
                                    <x-heroicon-o-map-pin class="h-5 w-5 mr-2" />
                                    {{ $rapat->lokasi_rapat }}
                                </div>
                            @elseif ($rapat->jenis_rapat === 'hybrid')
                                <div class="flex items-center">
                                    <x-heroicon-o-map-pin class="h-5 w-5 mr-2" />
                                    {{ $rapat->lokasi_rapat }}
                                </div>
                                <div class="flex items-center">
                                    <x-heroicon-o-link class="h-5 w-5 mr-2" />
                                    <a href="{{ $rapat->link_meeting }}" class="underline text-blue-200" target="_blank">Link Meeting</a>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center text-sm text-white">
                            <x-heroicon-o-clock class="h-5 w-5 mr-2" />
                            {{ \Carbon\Carbon::parse($rapat->waktu_mulai)->format('H:i') }} -
                            {{ $rapat->waktu_selesai ? \Carbon\Carbon::parse($rapat->waktu_selesai)->format('H:i') : 'selesai' }} WITA
                        </div>
                    </div>
                </div>

                <!-- Success Message -->
                @if (session('success'))
                <div x-data="{ show: true }" 
                     x-show="show" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-4"
                     x-init="setTimeout(() => show = false, 5000)"
                     class="bg-green-50 border-l-4 border-green-500 p-4 mx-6 mt-6 rounded-lg">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Form Section -->
                <form action="{{ url('/absensi/' . $rapat->link_absensi) }}" method="POST" class="px-8 py-0 pb-8 space-y-6">
                    @csrf

                    <!-- Personal Information Grid -->
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name Field -->
                        <div class="space-y-1">
                            <label for="nama" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <input type="text" id="nama" name="nama" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border-gray-300 rounded-md transition duration-150 ease-in-out"
                                    placeholder="Masukkan nama lengkap" required>
                            </div>
                        </div>

                        <!-- NIP/NIK Field -->
                        <div class="space-y-1">
                            <label for="nip_nik" class="block text-sm font-medium text-gray-700">NIP/NIK</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                    </svg>
                                </div>
                                <input type="text" id="nip_nik" name="nip_nik" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border-gray-300 rounded-md transition duration-150 ease-in-out"
                                    placeholder="Masukkan NIP/NIK" required>
                            </div>
                        </div>

                        <!-- Work Unit Field -->
                        <div class="space-y-1">
                            <label for="unit_kerja" class="block text-sm font-medium text-gray-700">Unit Kerja</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <input type="text" id="unit_kerja" name="unit_kerja" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border-gray-300 rounded-md transition duration-150 ease-in-out"
                                    placeholder="Masukkan unit kerja" required>
                            </div>
                        </div>

                        <!-- Position Field -->
                        <div class="space-y-1">
                            <label for="jabatan_tugas" class="block text-sm font-medium text-gray-700">Jabatan/Tugas</label>
                            <div class="relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <input type="text" id="jabatan_tugas" name="jabatan_tugas" 
                                    class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 pr-3 py-3 border-gray-300 rounded-md transition duration-150 ease-in-out"
                                    placeholder="Masukkan jabatan atau tugas" required>
                            </div>
                        </div>
                    </div>

                    <!-- Signature Section -->
                    <div class="mt-8">
                        <label for="signature-pad" class="block text-sm font-medium text-gray-700 mb-2">Tanda Tangan</label>
                        <div class="border-2 border-dashed border-gray-300 rounded-xl p-0 bg-gray-50 hover:border-blue-400 transition duration-200">
                            <div class="relative h-60">
                                <canvas id="signature-pad" class="w-full h-full rounded-lg bg-white shadow-inner absolute top-0 left-0"></canvas>
                            </div>
                        </div>
                        <input type="hidden" name="tanda_tangan" id="tanda_tangan">
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row sm:justify-between gap-4 mt-10">
                        <button type="button" onclick="clearSignature()" 
                            class="inline-flex justify-center items-center px-5 py-3 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Clear Tanda Tangan
                        </button>
                        <button type="submit" 
                            class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 transform hover:-translate-y-0.5 hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize signature pad
            const canvas = document.getElementById('signature-pad');
            const signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)',
                penColor: 'rgb(16, 24, 39)',
                minWidth: 1,
                maxWidth: 3,
                velocityFilterWeight: 0.7
            });

            // Handle canvas responsiveness
            function resizeCanvas() {
                const ratio = Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
                signaturePad.clear();
            }

            window.addEventListener('resize', resizeCanvas);
            resizeCanvas();

            // Form submission with validation
            document.querySelector('form').addEventListener('submit', function(e) {
                if (signaturePad.isEmpty()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Tanda Tangan Kosong',
                        text: 'Harap berikan tanda tangan Anda sebelum mengirim',
                        confirmButtonColor: '#3B82F6'
                    });
                } else {
                    document.getElementById('tanda_tangan').value = signaturePad.toDataURL('image/png');
                }
            });

            // Clear signature function
            window.clearSignature = function() {
                signaturePad.clear();
                        }
                    });

            document.getElementById('nip_nik').addEventListener('change', function () {
                const nip = this.value;
                const uuid = "{{ $rapat->link_absensi }}";

                fetch(`/absensi/${uuid}/cek-nip?nip_nik=${nip}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data) {
                            document.getElementById('nama').value = data.nama || '';
                            document.getElementById('unit_kerja').value = data.unit_kerja || '';
                            document.getElementById('jabatan_tugas').value = data.jabatan_tugas || '';
                        }
                    });
            });
    </script>
    @endpush
@endsection