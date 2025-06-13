<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Absensi Rapat - Universitas Hasanuddin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
        }

        .hero-pattern {
            background-color: #4f46e5;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath fill-rule='evenodd' d='M0 0h40v40H0V0zm40 40h40v40H40V40zm0-40h2l-2 2V0zm0 4l4-4h2l-6 6V4zm0 4l8-8h2L40 10V8zm0 4L52 0h2L40 14v-2zm0 4L56 0h2L40 18v-2zm0 4L60 0h2L40 22v-2zm0 4L64 0h2L40 26v-2zm0 4L68 0h2L40 30v-2zm0 4L72 0h2L40 34v-2zm0 4L76 0h2L40 38v-2zm0 4L80 0v2L42 40h-2zm4 0L80 4v2L46 40h-2zm4 0L80 8v2L50 40h-2zm4 0l28-28v2L54 40h-2zm4 0l24-24v2L58 40h-2zm4 0l20-20v2L62 40h-2zm4 0l16-16v2L66 40h-2zm4 0l12-12v2L70 40h-2zm4 0l8-8v2l-6 6h-2zm4 0l4-4v2l-2 2h-2z'/%3E%3C/g%3E%3C/svg%3E");
        }

        /* Card Konsisten & Hover Effect */
        .meeting-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: white;
            border-radius: 0.75rem;
            /* 12px */
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .meeting-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
        }

        /* Konten Card untuk Flex Grow */
        .meeting-card-content {
            flex-grow: 1;
            padding: 1.5rem;
        }

        /* Header Card untuk Judul dan Badge */
        .meeting-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        /* Badge Status Baru */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            /* 4px 12px */
            font-size: 0.75rem;
            /* 12px */
            font-weight: 600;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .status-badge.status-ongoing {
            background-color: #dcfce7;
            /* Green 100 */
            color: #166534;
            /* Green 800 */
        }

        .status-badge.status-upcoming {
            background-color: #e0e7ff;
            /* Indigo 100 */
            color: #3730a3;
            /* Indigo 800 */
        }

        /* Animasi Pulse untuk Badge Ongoing */
        .pulse-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #22c55e;
            /* Green 500 */
            margin-right: 0.5rem;
            /* 8px */
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            }

            70% {
                transform: scale(1);
                box-shadow: 0 0 0 10px rgba(34, 197, 94, 0);
            }

            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
            }
        }

        /* Tombol Aksi */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            /* 10px 20px */
            border-radius: 0.5rem;
            /* 8px */
            font-weight: 500;
            font-size: 0.875rem;
            /* 14px */
            transition: all 0.2s ease;
            border: 1px solid transparent;
        }

        .btn-primary {
            background-color: #4f46e5;
            color: white;
        }

        .btn-primary:hover {
            background-color: #4338ca;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background-color: #f3f4f6;
            /* Gray 100 */
            color: #1f2937;
            /* Gray 800 */
            border-color: #d1d5db;
            /* Gray 300 */
        }

        .btn-secondary:hover {
            background-color: #e5e7eb;
            /* Gray 200 */
            border-color: #9ca3af;
            /* Gray 400 */
        }

        /* Utility Classes */
        .link-meeting-container {
            word-break: break-all;
        }
    </style>
</head>

<body class="antialiased">
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('logo/unhas.png') }}" alt="Logo Unhas" class="h-12">
                <div>
                    <h1 class="font-bold text-lg text-gray-900">Universitas Hasanuddin</h1>
                    <p class="text-sm text-gray-600">Portal Absensi Rapat</p>
                </div>
            </div>
            <a href="/admin" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Login Admin</a>
        </div>
    </header>

    <section class="hero-pattern py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold text-white tracking-tight mb-2">Jadwal Rapat Hari Ini</h2>
            <p class="text-indigo-200 text-xl">{{ \Carbon\Carbon::today()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
    </section>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        @if(isset($todayRapats) && $todayRapats->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @foreach($todayRapats as $rapat)
                    @php
                        $now = \Carbon\Carbon::now();
                        $startTime = \Carbon\Carbon::parse($rapat->tanggal_rapat . ' ' . $rapat->waktu_mulai);
                        $endTime = $rapat->waktu_selesai ?
                            \Carbon\Carbon::parse($rapat->tanggal_rapat . ' ' . $rapat->waktu_selesai) :
                            $startTime->copy()->addHours(2);
                        $isOngoing = $now->between($startTime, $endTime);
                        $isUpcoming = $now->lessThan($startTime);
                    @endphp

                    <div class="meeting-card">
                        <div class="meeting-card-content">
                            <div class="meeting-card-header">
                                <h3 class="font-bold text-xl text-gray-800 leading-tight">{{ $rapat->agenda_rapat }}</h3>
                                @if($isOngoing)
                                    <span class="status-badge status-ongoing">
                                        <div class="pulse-dot"></div>
                                        Berlangsung
                                    </span>
                                @elseif($isUpcoming)
                                    <span class="status-badge status-upcoming">Akan Datang</span>
                                @endif
                            </div>

                            <div class="mb-6 space-y-4 text-gray-700">
                                <div class="flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 mr-3 flex-shrink-0"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span>
                                        {{ \Carbon\Carbon::parse($rapat->waktu_mulai)->format('H:i') }} -
                                        {{ $rapat->waktu_selesai ? \Carbon\Carbon::parse($rapat->waktu_selesai)->format('H:i') : 'Selesai' }}
                                    </span>
                                </div>

                                <div class="flex items-start">
                                    @if($rapat->jenis_rapat == 'online')
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">Online Meeting</span>
                                    @elseif($rapat->jenis_rapat == 'hybrid')
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                        <span>{{ $rapat->lokasi_rapat }} & Online</span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>{{ $rapat->lokasi_rapat }}</span>
                                    @endif
                                </div>

                                @if(($rapat->jenis_rapat == 'online' || $rapat->jenis_rapat == 'hybrid') && isset($rapat->link_meeting))
                                    <div class="flex items-start">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-5 w-5 text-gray-400 mr-3 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                        <div class="link-meeting-container">
                                            <a href="{{ $rapat->link_meeting }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-800 hover:underline font-medium">
                                                Buka Link Meeting
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 flex items-center justify-end border-t">
                            <a href="{{ url('/absensi/' . $rapat->link_absensi) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Isi Absensi
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16 bg-white rounded-xl shadow-sm p-8 border">
                <h3 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3 text-indigo-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Cara Mengisi Absensi
                </h3>
                <ol class="list-decimal ml-5 space-y-2 text-gray-600">
                    <li>Klik tombol <strong>"Isi Absensi"</strong> pada rapat yang sedang atau akan berlangsung.</li>
                    <li>Anda akan diarahkan ke halaman formulir absensi.</li>
                    <li>Isi formulir dengan data diri yang benar (Nama, NIP/NIK, Unit Kerja, dll.).</li>
                    <li>Berikan tanda tangan digital Anda pada kolom yang telah disediakan.</li>
                    <li>Pastikan semua data sudah benar, lalu klik tombol "Submit" untuk merekam kehadiran Anda.</li>
                </ol>
            </div>
        @else
            <div class="text-center py-20 px-6 bg-white rounded-xl shadow-sm border">
                <img src="https://absensi.unhas.ac.id/images/no-meetings.svg" alt="Tidak Ada Rapat"
                    class="w-52 mx-auto mb-8"
                    onerror="this.src='https://cdn.pixabay.com/photo/2017/03/29/04/09/check-icon-2184719_1280.png';this.onerror='';">
                <h3 class="text-3xl font-bold text-gray-800 mb-2">Tidak Ada Jadwal Rapat</h3>
                <p class="text-gray-600 max-w-lg mx-auto mb-8">Saat ini tidak ada jadwal rapat untuk hari ini. Silakan
                    periksa kembali nanti atau hubungi administrator untuk informasi lebih lanjut.</p>

                <div class="inline-flex rounded-md shadow-sm">
                    <a href="/" class="btn btn-secondary">
                        Refresh Halaman
                    </a>
                </div>
            </div>

            <div class="mt-12 p-6 bg-indigo-50 rounded-xl border border-indigo-200">
                <div class="flex items-start">
                    <div class="bg-indigo-100 p-3 rounded-lg mr-4 flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Jadwal Rapat Mendatang</h3>
                        <p class="text-gray-700">Untuk melihat jadwal rapat di hari lain, silakan hubungi administrator atau
                            cek kembali portal ini secara berkala.</p>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <footer class="bg-gray-800 mt-16">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="md:flex md:items-center md:justify-between">
                <div class="flex items-center justify-center md:justify-start">
                    <img src="{{ asset('logo/unhas.png') }}" alt="Logo Unhas" class="h-10 mr-4">
                    <div class="text-gray-400 text-center md:text-left">
                        <p class="text-sm">&copy; {{ date('Y') }} Universitas Hasanuddin</p>
                        <p class="text-xs">Sistem Manajemen Absensi Rapat</p>
                    </div>
                </div>
                <div class="mt-4 md:mt-0 text-center md:text-right">
                    <p class="text-sm text-gray-400">Butuh bantuan? Hubungi <a href="mailto:support@unhas.ac.id"
                            class="text-indigo-400 hover:text-indigo-300 underline">support@unhas.ac.id</a></p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>