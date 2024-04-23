<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Barcode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ff7f0e; /* Warna latar belakang orange */
            border: 1px solid #ccc; /* Border */
            border-radius: 10px; /* Border radius */
        }

        .qr-code {
            text-align: center;
            margin-top: 20px;
        }

        .qr-code img {
            max-width: 100%;
            height: auto;
            border: 5px solid #fff; /* Border untuk QR Code */
            border-radius: 10px; /* Border radius */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Efek bayangan */
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 style="text-align: center; color: #fff;">SCAN FOR MENU & ORDER</h2>
        <h4 style="text-align: center; color: #fff;">TABLE - {{$data->no_meja}}</h4>

        <div class="qr-code">
            <?php
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::size(300)->generate($data->barcode);
            ?>
            <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
        </div>
    </div>
</body>

</html>
