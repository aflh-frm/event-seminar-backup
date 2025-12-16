<!DOCTYPE html>
<html>
<head>
    <title>E-Ticket</title>
    <style>
        body { font-family: sans-serif; color: #333; }
        .ticket-box { border: 2px dashed #333; padding: 20px; max-width: 700px; margin: 0 auto; position: relative; }
        .header { border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 20px; display: flex; justify-content: space-between; }
        .logo { font-size: 24px; font-weight: bold; color: #2563eb; }
        .event-title { font-size: 28px; font-weight: bold; margin-bottom: 5px; }
        .info-label { font-size: 12px; color: #666; text-transform: uppercase; margin-top: 15px; }
        .info-value { font-size: 16px; font-weight: bold; }
        .row { width: 100%; display: table; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        .qr-area { text-align: center; margin-top: 20px; border-top: 1px solid #eee; pt: 20px; }
        .status-paid { color: green; border: 2px solid green; padding: 5px 10px; border-radius: 5px; font-weight: bold; display: inline-block; }
    </style>
</head>
<body>
    <div class="ticket-box">
        <div class="header">
            <div class="logo">EventPro E-Ticket</div>
            <div style="text-align: right; font-size: 12px; color: #777;">
                Booking ID: #{{ $transaction->id }}
            </div>
        </div>

        <div class="event-title">{{ $transaction->event->title }}</div>
        <div>{{ $transaction->event->category->name ?? 'General Event' }}</div>

        <div class="row" style="margin-top: 20px;">
            <div class="col">
                <div class="info-label">Nama Peserta</div>
                <div class="info-value">{{ $transaction->user->name }}</div>

                <div class="info-label">Email</div>
                <div class="info-value">{{ $transaction->user->email }}</div>

                <div class="info-label">Tanggal Transaksi</div>
                <div class="info-value">{{ \Carbon\Carbon::parse($transaction->transaction_date)->format('d M Y') }}</div>
            </div>

            <div class="col">
                <div class="info-label">Waktu Pelaksanaan</div>
                <div class="info-value">
                    {{ \Carbon\Carbon::parse($transaction->event->event_date)->translatedFormat('l, d F Y') }}<br>
                    09:00 WIB - Selesai
                </div>

                <div class="info-label">Lokasi</div>
                <div class="info-value">{{ $transaction->event->location }}</div>
                
                <div style="margin-top: 20px;">
                    <span class="status-paid">LUNAS / CONFIRMED</span>
                </div>
            </div>
        </div>

        <div class="qr-area" style="text-align: center; margin-top: 30px;">
            <p style="margin-bottom: 10px; font-size: 12px; color: #777;">Tunjukkan QR Code ini di meja registrasi</p>
            <img src="data:image/svg+xml;base64,{{ $qrcode }}" width="150">
        </div>
    </div>
</body>
</html>