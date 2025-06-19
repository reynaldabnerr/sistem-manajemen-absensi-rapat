@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
    use Carbon\Carbon;

    Carbon::setLocale('id');

    $url = $record->link_absensi ? url('/absensi/' . $record->link_absensi) : '#';
    $meetingTitle = $record->agenda_rapat ?? 'Rapat';
    $meetingDate = $record->tanggal_rapat
        ? Carbon::parse($record->tanggal_rapat)->translatedFormat('l, d F Y')
        : 'Tanggal tidak tersedia';
    $meetingTime = $record->waktu_mulai
        ? Carbon::parse($record->waktu_mulai)->format('H:i')
        : 'Waktu tidak tersedia';

    // Generate unique ID for QR download
    $qrId = 'qr-' . md5($url . time());
@endphp

<div class="p-6 rounded-lg shadow max-w-md mx-auto bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
    <!-- Header with accent border -->
    <div class="mb-6 text-center relative border-b border-gray-100 dark:border-gray-700 pb-4">
        <div class="absolute top-0 left-0 w-1/3 h-1 bg-gradient-to-r from-amber-400 to-amber-500 rounded-full"></div>
        <h3 class="text-lg font-bold text-gray-900 dark:text-white">{{ $meetingTitle }}</h3>
        <div class="flex items-center justify-center mt-2 mb-8 space-x-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $meetingDate }}</span>
            <span class="text-gray-300 dark:text-gray-600">•</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 dark:text-gray-400" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-sm text-gray-600 dark:text-gray-300">{{ $meetingTime }}</span>
        </div>
    </div>

    <!-- QR Code with adaptive styling -->
    <div class="flex justify-center mb-5 mt-8">
        <div class="p-4 border-2 border-gray-200 dark:border-gray-700 rounded-lg bg-white dark:bg-gray-900 shadow-sm">
            <div id="{{ $qrId }}" class="qr-container">
                {!! QrCode::size(250)->generate($url) !!}
            </div>
        </div>
    </div>



    <!-- Link and Copy button -->
    <div class="space-y-3">
        <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
            Pindai QR code atau gunakan tautan di bawah untuk melakukan presensi:
        </p>

        <div class="flex items-center">
            <div
                class="flex-1 bg-gray-100 dark:bg-gray-700 rounded-l-lg py-2.5 px-3 text-xs overflow-hidden overflow-ellipsis">
                <span class="text-gray-800 dark:text-gray-200">{{ $url }}</span>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ $url }}" target="_blank"
                class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200">
                <span>Buka di Peramban</span>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z"
                        transform="rotate(90, 10, 10)" />
                </svg>
            </a>
        </div>
    </div>
</div>

<script>
    function copyToClipboard(text, button) {
        navigator.clipboard.writeText(text);

        const originalInnerHTML = button.innerHTML;

        // Change to checkmark
        button.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
        </svg>
    `;
        button.classList.add('bg-green-500', 'dark:bg-green-600');
        button.classList.remove('bg-amber-500', 'dark:bg-amber-600', 'hover:bg-amber-600', 'dark:hover:bg-amber-700');

        // Revert after delay
        setTimeout(() => {
            button.innerHTML = originalInnerHTML;
            button.classList.remove('bg-green-500', 'dark:bg-green-600');
            button.classList.add('bg-amber-500', 'dark:bg-amber-600', 'hover:bg-amber-600', 'dark:hover:bg-amber-700');
        }, 2000);
    }

    function downloadQR(qrId, meetingTitle) {
        // Get the SVG element
        const svgElement = document.querySelector(`#${qrId} svg`);

        if (!svgElement) {
            console.error('SVG element not found');
            return;
        }

        // Create a clean title for the filename
        const cleanTitle = meetingTitle
            .replace(/[^\w\s]/gi, '')
            .replace(/\s+/g, '-')
            .toLowerCase();

        // Get the SVG as a string with white background styling
        let svgData = new XMLSerializer().serializeToString(svgElement);

        // Ensure we have a white background for the SVG
        if (!svgData.includes('style="background:')) {
            svgData = svgData.replace('<svg', '<svg style="background: white;"');
        }

        // Create a canvas element
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        // Create an image to draw on canvas
        const img = new Image();
        img.onload = function () {
            // Set canvas dimensions with padding
            const padding = 20;
            canvas.width = img.width + padding * 2;
            canvas.height = img.height + padding * 2;

            // Draw white background
            ctx.fillStyle = 'white';
            ctx.fillRect(0, 0, canvas.width, canvas.height);

            // Draw the image with padding
            ctx.drawImage(img, padding, padding);

            // Convert canvas to data URL and trigger download
            const dataURL = canvas.toDataURL('image/png');
            const a = document.createElement('a');
            a.href = dataURL;
            a.download = `qr-${cleanTitle}.png`;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
        };

        // Load the SVG data as an image
        img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
    }
</script>

<style>
    /* Ensure QR code looks good in dark mode */
    .dark .qr-container svg path[fill="#000000"] {
        fill: #000000;
        /* Keep black for QR */
    }

    .dark .qr-container svg path[fill="#ffffff"],
    .dark .qr-container svg rect[fill="#ffffff"] {
        fill: #ffffff;
        /* Keep white for QR background */
    }

    .qr-container {
        line-height: 0;
    }
</style>