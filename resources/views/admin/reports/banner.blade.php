<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Bus Banner</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- QRCode.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    
    <!-- JsBarcode for Barcode generation -->
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
    
    <!-- html2canvas for PNG download -->
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    <style>
        body { background: #fef9c3; }
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
            #download-btn { display: none !important; }
        }
    </style>
</head>
<body>
    <div id="banner-capture" class="banner-main">
        <!-- Header -->
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

        <!-- Targa -->
        <div class="targa-row">
            <div class="targa-big">
                {{ $bus->targa }}
            </div>
        </div>

        <div class="section-line"></div>

        <!-- QR and Barcode -->
        <div class="qr-bar-row">
            <!-- QR Code -->
            <div class="qr-side">
                <div id="qrcode"></div>
            </div>

            <!-- Barcode -->
            <div class="barcode-side">
                <div class="barcode-label">Barcode (Unique ID)</div>
                <svg id="barcode" style="margin:auto; display:block; max-width:420px; height:80px;"></svg>
                <div class="unique-id">{{ $bus->unique_bus_id }}</div>
            </div>
        </div>

        <div class="section-line"></div>

        <!-- Download Button -->
        <div class="text-center mt-8">
            <button id="download-btn" class="bg-yellow-700 hover:bg-yellow-800 text-white font-bold py-4 px-16 rounded-full shadow-lg text-2xl transition">
                Download as PNG
            </button>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Generate QR Code
            new QRCode(document.getElementById("qrcode"), {
                text: "{{ $bus->unique_bus_id }}",
                width: 260,
                height: 260,
                colorDark: "#78350f",
                colorLight: "#fffbe8",
                correctLevel: QRCode.CorrectLevel.H
            });

            // Generate Barcode
            JsBarcode("#barcode", "{{ $bus->unique_bus_id }}", {
                format: "CODE128",
                lineColor: "#000",
                width: 2,
                height: 80,
                displayValue: false
            });

            // Download as PNG
            document.getElementById('download-btn').addEventListener('click', function () {
                html2canvas(document.getElementById('banner-capture'), {
                    allowTaint: true,
                    useCORS: true
                }).then(function (canvas) {
                    const link = document.createElement('a');
                    link.download = 'bus-banner-{{ $bus->targa }}.png';
                    link.href = canvas.toDataURL();
                    link.click();
                });
            });
        });
    </script>
</body>
</html>
