<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Manajemen Absensi Rapat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .animate-fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .countdown {
            display: inline-block;
            min-width: 2.5rem;
        }
        .countdown.animate {
            animation: countdownPulse 1s ease-in-out;
        }
        @keyframes countdownPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body class="antialiased bg-white">
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-4xl mx-auto px-4 py-16 text-center animate-fade-in">
            <div class="bg-white rounded-2xl shadow-lg p-8 md:p-12">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    Sistem Manajemen Absensi Rapat
                </h1>
                <p class="text-xl text-gray-600 mb-8">
                    Mengelola dan memantau kehadiran rapat dengan mudah dan efisien
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="/admin" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                        Masuk ke Dashboard
                    </a>
                </div>
                <p class="mt-6 text-sm text-gray-500">
                    Mengalihkan ke dashboard dalam <span id="countdown" class="countdown font-semibold text-indigo-600">3</span> detik...
                </p>
            </div>
            
            <div class="mt-12">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Manajemen Waktu</h3>
                        <p class="text-sm text-gray-600">Kelola jadwal rapat dengan efisien</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Absensi Digital</h3>
                        <p class="text-sm text-gray-600">Catat kehadiran secara digital</p>
                    </div>
                    
                    <div class="bg-gray-50 rounded-xl p-6 shadow-sm">
                        <svg class="w-12 h-12 mx-auto mb-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <h3 class="text-xl font-semibold mb-2 text-gray-800">Laporan Real-time</h3>
                        <p class="text-sm text-gray-600">Pantau statistik kehadiran secara real-time</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let timeLeft = 3;
            const countdownElement = document.getElementById('countdown');
            
            function updateCountdown() {
                if (timeLeft > 0) {
                    countdownElement.textContent = timeLeft;
                    countdownElement.classList.add('animate');
                    setTimeout(() => countdownElement.classList.remove('animate'), 1000);
                    timeLeft--;
                    setTimeout(updateCountdown, 1000);
                }
            }

            // Start countdown
            updateCountdown();

            // Redirect after 3 seconds
            setTimeout(function() {
                window.location.href = '/admin';
            }, 3000);
        });
    </script>
</body>
</html>
