
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portal Absensi Rapat - Universitas Hasanuddin</title>
    <link rel="icon" href="{{ asset('logo/unhas.png') }}" type="image/png">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat:wght@700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        :root {
            --primary-color: #4f46e5;
            --primary-dark: #3730a3;
            --primary-light: #c7d2fe;
            --secondary-color: #0284c7;
            --accent-color: #f59e0b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            scroll-behavior: smooth;
        }

        .font-display {
            font-family: 'Montserrat', sans-serif;
        }

        /* Enhanced gradients and patterns */
        .hero-gradient {
            background: linear-gradient(135deg, #3730a3 0%, #4f46e5 50%, #6366f1 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-pattern {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.08' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.6;
            z-index: 0;
        }

        /* Enhanced card design */
        .meeting-card {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: white;
            border-radius: 1.25rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.2, 0.8, 0.2, 1);
            overflow: hidden;
            border: 1px solid rgba(229, 231, 235, 0.8);
            position: relative;
        }

        .meeting-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            z-index: 1;
            opacity: 0.8;
            transition: height 0.3s ease;
        }

        .meeting-card:hover {
            transform: translateY(-8px) scale(1.01);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-color: var(--primary-light);
        }

        .meeting-card:hover::before {
            height: 6px;
        }

        /* Enhanced card content */
        .meeting-card-content {
            flex-grow: 1;
            padding: 2rem;
            position: relative;
            z-index: 2;
        }

        .meeting-card-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            position: relative;
        }

        /* Enhanced status badges */
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.4rem 1.2rem;
            font-size: 0.75rem;
            font-weight: 600;
            border-radius: 9999px;
            white-space: nowrap;
            letter-spacing: 0.025em;
            box-shadow: 0 2px 5px -1px rgba(0, 0, 0, 0.15);
        }

        .status-badge.status-ongoing {
            background: linear-gradient(135deg, rgba(220, 252, 231, 1), rgba(167, 243, 208, 1));
            color: rgba(6, 95, 70, 1);
        }

        .status-badge.status-upcoming {
            background: linear-gradient(135deg, rgba(224, 231, 255, 1), rgba(199, 210, 254, 1));
            color: rgba(55, 48, 163, 1);
        }

        /* Enhanced pulse animation */
        .pulse-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: rgba(16, 185, 129, 1);
            margin-right: 0.5rem;
            box-shadow: 0 0 0 rgba(16, 185, 129, 0.7);
            animation: pulse-animation 2s infinite;
        }

        @keyframes pulse-animation {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        /* Enhanced buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.75rem 1.75rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.2, 0.8, 0.2, 1);
            border: 1px solid transparent;
            position: relative;
            overflow: hidden;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.2);
            transform: translateX(-100%);
            transition: transform 0.5s ease;
        }

        .btn:hover::after {
            transform: translateX(0);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: white;
            box-shadow: 0 6px 12px -3px rgba(79, 70, 229, 0.3), 0 3px 6px -2px rgba(79, 70, 229, 0.2);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -5px rgba(79, 70, 229, 0.4), 0 8px 10px -5px rgba(79, 70, 229, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
            color: #1f2937;
            border-color: #e2e8f0;
            box-shadow: 0 2px 6px -1px rgba(0, 0, 0, 0.08), 0 1px 3px -1px rgba(0, 0, 0, 0.05);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
            border-color: #cbd5e1;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px -2px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06);
        }

        /* Enhanced info icons */
        .info-icon {
            flex-shrink: 0;
            height: 1.35rem;
            width: 1.35rem;
            color: #6366f1;
            margin-right: 0.75rem;
            opacity: 0.9;
        }

        /* Enhanced link hover effects */
        .link-hover {
            position: relative;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .link-hover:after {
            content: '';
            position: absolute;
            width: 100%;
            transform: scaleX(0);
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            transform-origin: bottom right;
            transition: transform 0.3s cubic-bezier(0.65, 0, 0.35, 1);
        }

        .link-hover:hover:after {
            transform: scaleX(1);
            transform-origin: bottom left;
        }

        /* Utility Classes */
        .link-meeting-container {
            word-break: break-all;
        }

        /* Enhanced animations */
        .fade-in {
            animation: enhancedFadeIn 0.6s ease-in;
        }

        @keyframes enhancedFadeIn {
            0% {
                opacity: 0;
                transform: translateY(10px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Enhanced navigation on scroll */
        .sticky-nav {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.95);
            transition: all 0.35s ease;
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }

        /* Enhanced custom scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(180deg, #c7d2fe, #818cf8);
            border-radius: 8px;
            border: 2px solid #f1f5f9;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(180deg, #a5b4fc, #6366f1);
        }

        /* Enhanced responsive adjustments */
        @media (max-width: 640px) {
            .meeting-card-header {
                flex-direction: column;
                gap: 0.75rem;
            }

            .status-badge {
                align-self: flex-start;
            }
            
            .meeting-card-content {
                padding: 1.5rem;
            }
        }

        /* Enhanced wave divider */
        .wave-divider {
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            overflow: hidden;
            line-height: 0;
        }

        .wave-divider svg {
            display: block;
            width: calc(100% + 1.3px);
            height: 46px;
        }

        .wave-divider .shape-fill {
            fill: #FFFFFF;
        }
        
        /* Glossy effect for cards */
        .glossy {
            position: relative;
        }
        
        .glossy::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 30%;
            background: linear-gradient(to bottom, rgba(255,255,255,0.4), rgba(255,255,255,0));
            border-radius: 1.25rem 1.25rem 0 0;
            z-index: 1;
            pointer-events: none;
        }
        
        /* Enhanced empty state */
        .empty-state-container {
            background: radial-gradient(circle at center, rgba(255,255,255,1) 0%, rgba(248,250,252,1) 100%);
        }
        
        /* Glass effect for info boxes */
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
        }
    </style>
</head>

<body class="antialiased">
    <!-- Enhanced header with animation -->
    <header class="bg-white shadow-sm sticky top-0 z-50 sticky-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full blur opacity-30 animate__animated animate__pulse animate__infinite"></div>
                    <div class="relative">
                        <img src="{{ asset('logo/unhas.png') }}" alt="Logo Unhas" class="h-12 sm:h-14 animate__animated animate__fadeIn">
                    </div>
                </div>
                <div>
                    <h1 class="font-display font-extrabold text-transparent text-lg sm:text-xl bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-500">Universitas Hasanuddin</h1>
                    <p class="text-sm text-gray-600 font-medium">Portal Absensi Rapat</p>
                </div>
            </div>
            <a href="/admin"
                class="text-sm flex items-center font-medium relative group">
                <span class="absolute inset-0 w-full h-full transition duration-200 ease-out transform translate-x-1 translate-y-1 bg-indigo-500 group-hover:-translate-x-0 group-hover:-translate-y-0"></span>
                <span class="absolute inset-0 w-full h-full bg-white border-2 border-indigo-500 group-hover:bg-indigo-500"></span>
                <span class="relative text-indigo-500 group-hover:text-white px-4 py-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                            clip-rule="evenodd" />
                    </svg>
                    Login Admin
                </span>
            </a>
        </div>
    </header>

    <!-- Enhanced hero section -->
    <section class="hero-gradient py-20 sm:py-24 relative">
        <div class="hero-pattern"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-display font-extrabold text-white tracking-tight mb-4 animate__animated animate__fadeInUp">
                Jadwal Rapat Hari Ini
            </h2>
            <p class="text-indigo-100 text-xl md:text-2xl animate__animated animate__fadeInUp animate__delay-1s font-light">
                {{ \Carbon\Carbon::today()->locale('id')->translatedFormat('l, d F Y') }}
            </p>
        </div>
        <div class="wave-divider">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path d="M985.66,92.83C906.67,72,823.78,31,743.84,14.19c-82.26-17.34-168.06-16.33-250.45.39-57.84,11.73-114,31.07-172,41.86A600.21,600.21,0,0,1,0,27.35V120H1200V95.8C1132.19,118.92,1055.71,111.31,985.66,92.83Z" class="shape-fill"></path>
            </svg>
        </div>
    </section>

    <!-- Enhanced main content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 relative -mt-10">
        @if(isset($todayRapats) && $todayRapats->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8 lg:gap-10">
                @foreach($todayRapats as $index => $rapat)
                    @php
                        $now = \Carbon\Carbon::now();
                        $startTime = \Carbon\Carbon::parse($rapat->tanggal_rapat . ' ' . $rapat->waktu_mulai);
                        $endTime = $rapat->waktu_selesai ?
                            \Carbon\Carbon::parse($rapat->tanggal_rapat . ' ' . $rapat->waktu_selesai) :
                            $startTime->copy()->addHours(2);
                        $isOngoing = $now->between($startTime, $endTime);
                        $isUpcoming = $now->lessThan($startTime);
                    @endphp

                    <div class="meeting-card glossy animate__animated animate__fadeIn" style="animation-delay: {{ 150 * $index }}ms">
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

                            <div class="mb-6 space-y-5 text-gray-700">
                                <div class="flex items-center p-3 bg-indigo-50 rounded-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="info-icon" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="font-medium">
                                        {{ \Carbon\Carbon::parse($rapat->waktu_mulai)->format('H:i') }} -
                                        {{ $rapat->waktu_selesai ? \Carbon\Carbon::parse($rapat->waktu_selesai)->format('H:i') : 'Selesai' }}
                                        <span class="text-indigo-400 text-sm ml-1">WITA</span>
                                    </span>
                                </div>

                                <div class="flex items-start">
                                    @if($rapat->jenis_rapat == 'online')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="info-icon mt-0.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                        </svg>
                                        <span class="font-medium">Online Meeting</span>
                                    @elseif($rapat->jenis_rapat == 'hybrid')
                                        <svg xmlns="http://www.w3.org/2000/svg" class="info-icon mt-0.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                                        </svg>
                                        <span>{{ $rapat->lokasi_rapat }} <span class="text-indigo-600 font-medium">&
                                                Online</span></span>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="info-icon mt-0.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
                                        <svg xmlns="http://www.w3.org/2000/svg" class="info-icon mt-0.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                        </svg>
                                        <div class="link-meeting-container">
                                            <a href="{{ $rapat->link_meeting }}" target="_blank"
                                                class="text-indigo-600 hover:text-indigo-800 link-hover font-medium">
                                                Buka Link Meeting
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-5 flex items-center justify-end border-t">
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

            <!-- Enhanced instructions section -->
            <div class="mt-20 glass-effect rounded-2xl shadow-lg p-8 border border-indigo-100">
                <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600 mb-8 flex items-center">
                    <div class="bg-gradient-to-r from-indigo-100 to-blue-100 p-3 rounded-xl mr-5 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    Cara Mengisi Absensi
                </h3>
                <ol class="list-decimal ml-5 lg:ml-16 space-y-4 text-gray-700">
                    <li class="pl-2 border-l-4 border-indigo-200 py-1">Klik tombol <strong class="text-indigo-600 font-semibold px-2 py-0.5 bg-indigo-50 rounded-md">"Isi Absensi"</strong> pada rapat yang
                        sedang atau akan berlangsung.</li>
                    <li class="pl-2 border-l-4 border-indigo-200 py-1">Anda akan diarahkan ke halaman formulir absensi.</li>
                    <li class="pl-2 border-l-4 border-indigo-200 py-1">Isi formulir dengan data diri yang benar (Nama, NIP/NIK, Unit Kerja, dll.).</li>
                    <li class="pl-2 border-l-4 border-indigo-200 py-1">Berikan tanda tangan digital Anda pada kolom yang telah disediakan.</li>
                    <li class="pl-2 border-l-4 border-indigo-200 py-1">Pastikan semua data sudah benar, lalu klik tombol <strong
                            class="text-green-600 font-semibold px-2 py-0.5 bg-green-50 rounded-md">"Submit"</strong> untuk merekam kehadiran Anda.</li>
                </ol>
            </div>
        @else
            <!-- Enhanced empty state -->
            <div class="empty-state-container text-center py-24 px-6 bg-white rounded-2xl shadow-xl border border-indigo-100 animate__animated animate__fadeIn relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-b from-white via-indigo-50/20 to-blue-50/20 z-0"></div>
                <div class="relative z-10">
                    <img src="https://absensi.unhas.ac.id/images/no-meetings.svg" alt="Tidak Ada Rapat"
                        class="w-64 mx-auto mb-10 drop-shadow-lg"
                        onerror="this.src='https://cdn.pixabay.com/photo/2017/03/29/04/09/check-icon-2184719_1280.png';this.onerror='';">
                    <h3 class="text-3xl font-display font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600 mb-3">Tidak Ada Jadwal Rapat</h3>
                    <p class="text-gray-600 max-w-lg mx-auto mb-10 text-lg">Saat ini tidak ada jadwal rapat untuk hari ini. Silakan
                        periksa kembali nanti atau hubungi administrator untuk informasi lebih lanjut.</p>

                    <div class="inline-flex rounded-md shadow-lg">
                        <a href="/" class="btn btn-primary group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 transition-transform group-hover:rotate-180" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Refresh Halaman
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enhanced info box -->
            <div class="mt-16 p-8 bg-gradient-to-br from-indigo-50 to-white rounded-2xl border border-indigo-100/80 shadow-lg animate__animated animate__fadeIn animate__delay-1s">
                <div class="flex flex-col md:flex-row items-center">
                    <div class="bg-gradient-to-br from-indigo-100 to-blue-100 p-4 rounded-xl flex-shrink-0 mb-6 md:mb-0 md:mr-6 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-indigo-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-blue-600 mb-3">Jadwal Rapat Mendatang</h3>
                        <p class="text-gray-700 text-lg">Untuk melihat jadwal rapat di hari lain, silakan hubungi administrator atau
                            cek kembali portal ini secara berkala. Anda juga dapat menghubungi kami melalui email yang tersedia di bawah halaman ini.</p>
                    </div>
                </div>
            </div>
        @endif
    </main>

    <!-- Enhanced footer -->
    <footer class="mt-20">
        <div class="bg-gray-900 pt-12 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="md:flex md:items-center md:justify-between">
                    <div class="flex items-center justify-center md:justify-start">
                        <div class="mr-5 relative">
                            <div class="absolute -inset-1 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-full blur opacity-40"></div>
                            <img src="{{ asset('logo/unhas.png') }}" alt="Logo Unhas" class="h-12 relative">
                        </div>
                        <div>
                            <p class="font-display text-xl text-white font-bold">&copy; {{ date('Y') }} Universitas Hasanuddin</p>
                            <p class="text-indigo-300 mt-1">Sistem Manajemen Absensi Rapat</p>
                        </div>
                    </div>
                    <div class="mt-8 md:mt-0 text-center md:text-right">
                        <p class="text-indigo-300 mb-2 font-medium">Butuh bantuan?</p>
                        <a href="mailto:support@unhas.ac.id" 
                           class="inline-flex items-center text-white hover:text-indigo-200 font-medium bg-gradient-to-r from-indigo-800/50 to-blue-800/50 px-4 py-2 rounded-lg transition-all hover:from-indigo-700/50 hover:to-blue-700/50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                            </svg>
                            support@unhas.ac.id
                        </a>
                    </div>
                </div>
                <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                    <p class="text-gray-500 text-sm">
                        Dikembangkan oleh Tim Pengembang Sistem | Pusat Teknologi Informasi dan Komunikasi
                    </p>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>