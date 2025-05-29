<!-- filepath: d:\My comany\e-ticket\resources\views\admin\reports\banner.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bus Banner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Tailwind CDN for quick styling -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- QRCode.js for QR code generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <!-- html2canvas for PNG download -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
    <style>
        body { background: #ffffff; }
        .banner-main {
            background: #fffbe8;
            border: 4px dashed #fbbf24;
            min-width: 50cm;
            min-height: 50cm;
            max-width: 100vw;
            max-height: 100vh;
            margin: 0 auto;
            padding: 0;
        }
        .section-line {
            border-top: 3px dotted #fbbf24;
            margin: 0.5rem 0;
        }
        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 2rem 3rem 1rem 3rem;
        }
        .header-info {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .level-box {
            font-size: 3rem;
            font-weight: 900;
            color: #a16207;
            background: #fde68a;
            border-radius: 1rem;
            padding: 1.5rem 3rem;
            box-shadow: 0 2px 8px 0 rgba(251,191,36,0.12);
            letter-spacing: 0.1em;
            text-align: center;
            min-width: 320px;
        }
        .targa-row {
            text-align: center;
            margin: 3rem 0 2rem 0;
        }
        .targa-big {
            font-size: 8rem;
            font-weight: 900;
            color: #78350f;
            letter-spacing: 0.15em;
            text-shadow: 2px 2px 12px #fbbf24;
        }
        .qr-bar-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            padding: 2rem 3rem 1rem 3rem;
        }
        .qr-side, .barcode-side {
            flex: 1 1 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .barcode-label {
            font-size: 1.5rem;
            color: #a16207;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        .unique-id {
            font-size: 1.5rem;
            color: #78350f;
            font-family: monospace;
            margin-top: 1.5rem;
            font-weight: 700;
            letter-spacing: 0.1em;
        }
        @media print {
            body, html { background: #fff !important; }
            .banner-main { box-shadow: none !important; }
            button { display: none !important; }
        }
    </style>
</head>
<body>
    <div id="banner-capture" class="banner-main">
        <!-- Header Row -->
        <div class="header-row">
            <div class="header-info">
                <img src="{{ asset('logo.png') }}" alt="Sevastopol Logo" class="h-32 mb-2">
                <div class="text-4xl font-extrabold text-yellow-900 tracking-widest" style="letter-spacing:0.13em;">
                    SEVASTOPOL TECHNOLOGY
                </div>
                <div class="text-2xl text-yellow-700 font-semibold">E-Ticket System</div>
                <div class="text-xl text-yellow-800 font-medium">Contact: 0912-345678 | info@sevastopol.com</div>
            </div>
            <div class="level-box">
                LEVEL<br>
                {{ strtoupper($bus->level) }}
            </div>
        </div>
        <div class="section-line"></div>
        <!-- Targa Row -->
        <div class="targa-row">
            <div class="targa-big">
                {{ $bus->targa }}
            </div>
        </div>
        <div class="section-line"></div>
        <!-- QR and Barcode Row -->
        <div class="qr-bar-row">
            <!-- QR Side -->
            <div class="qr-side">
                <div id="qrcode"></div>
            </div>
            <!-- Barcode Side -->
            <div class="barcode-side">
                <div class="barcode-label">Barcode (Unique ID)</div>
                <img 
                    src="https://barcode.tec-it.com/barcode.ashx?data={{ $bus->unique_bus_id }}&code=Code128&translate-esc=off" 
                    alt="Barcode for {{ $bus->unique_bus_id }}" 
                    style="margin:auto; display:block; max-width:420px; height:80px;"
                >
                <div class="unique-id">{{ $bus->unique_bus_id }}</div>
            </div>
        </div>
        <div class="section-line"></div>
        <div class="text-center mt-8">
            <button id="download-btn" class="bg-yellow-700 hover:bg-yellow-800 text-white font-bold py-4 px-16 rounded-full shadow-lg text-2xl transition">
                Download as PNG
            </button>
        </div>
    </div>
    <script>
        // Only QR code for unique_bus_id
        document.addEventListener("DOMContentLoaded", function() {
            // Remove any previous QR code
            document.getElementById("qrcode").innerHTML = "";
            new QRCode(document.getElementById("qrcode"), {
                text: "{{ $bus->unique_bus_id }}",
                width: 260,
                height: 260,
                colorDark : "#78350f",
                colorLight : "#fffbe8",
                correctLevel : QRCode.CorrectLevel.H
            });
        });

        // Download as PNG functionality
        document.getElementById('download-btn').addEventListener('click', function() {
            html2canvas(document.getElementById('banner-capture')).then(function(canvas) {
                var link = document.createElement('a');
                link.download = 'bus-banner-{{ $bus->targa }}.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        });
    </script>
</body>
</html>