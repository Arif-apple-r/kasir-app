<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan #{{ $penjualan->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-item {
            font-size: 13px;
            line-height: 1.8;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f0f0f0;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        td {
            padding: 10px;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        .total-row {
            font-weight: bold;
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            text-align: center;
            font-size: 12px;
        }
        .signature {
            height: 60px;
        }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
        .print-btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <button class="print-btn no-print" onclick="window.print()">Print / Simpan sebagai PDF</button>

    <div class="header">
        <h1>LAPORAN PENJUALAN</h1>
        <p>No. Transaksi #{{ $penjualan->id }}</p>
        <p>Tanggal: {{ $penjualan->tanggal_penjualan->format('d/m/Y H:i') }}</p>
    </div>

    <div class="info-grid">
        <div class="info-item">
            <strong>Pelanggan:</strong> {{ $penjualan->pelanggan->name ?? 'Umum' }}<br>
            <strong>Email:</strong> {{ $penjualan->pelanggan->email ?? '-' }}<br>
        </div>
        <div class="info-item">
            <strong>Kasir:</strong> {{ $penjualan->karyawan->name }}<br>
            <strong>Status:</strong> <span style="background-color:
                @if($penjualan->status_pesanan === 'selesai') #90EE90 @elseif($penjualan->status_pesanan === 'pending') #FFD700 @else #FF6347 @endif;
                padding: 3px 8px; border-radius: 3px;">{{ ucfirst($penjualan->status_pesanan) }}</span>
        </div>
    </div>

    <div class="section">
        <div class="section-title">Detail Produk</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 40%">Nama Produk</th>
                    <th style="width: 15%; text-align: right;">Harga</th>
                    <th style="width: 15%; text-align: center;">Qty</th>
                    <th style="width: 20%; text-align: right;">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan->detail as $d)
                <tr>
                    <td>{{ $d->produk->nama }}</td>
                    <td style="text-align: right;">Rp {{ number_format($d->harga_saat_itu, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ $d->jumlah }}</td>
                    <td style="text-align: right;">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">TOTAL:</td>
                    <td style="text-align: right;">Rp {{ number_format($penjualan->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="section">
        <div class="section-title">Metode Pembayaran</div>
        <p>{{ ucfirst($penjualan->metode_pembayaran) }}</p>
    </div>

    <div class="footer">
        <div>
            <p>Pembeli</p>
            <div class="signature"></div>
            <p>{{ $penjualan->pelanggan->name ?? 'Umum' }}</p>
        </div>
        <div>
            <p>Kasir</p>
            <div class="signature"></div>
            <p>{{ $penjualan->karyawan->name }}</p>
        </div>
        {{-- <div>
            <p>Manager</p>
            <div class="signature"></div>
            <p>_______________</p>
        </div> --}}
    </div>

    <script>
        // Jika diakses langsung, tampilkan dialog print
        window.addEventListener('load', function() {
            // Uncomment line di bawah jika ingin auto-print saat halaman load
            // window.print();
        });
    </script>
</body>
</html>
