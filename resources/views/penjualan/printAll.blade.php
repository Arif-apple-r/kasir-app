<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Keseluruhan</title>
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
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        .filters {
            background-color: #f9f9f9;
            padding: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #007bff;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th {
            background-color: #f0f0f0;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border: 1px solid #ddd;
            font-size: 13px;
        }
        td {
            padding: 10px 12px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .total-row {
            font-weight: bold;
            background-color: #e8e8e8;
        }
        .status-selesai {
            background-color: #d4edda;
            color: #155724;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
        }
        .status-diproses {
            background-color: #d1ecf1;
            color: #0c5460;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
        }
        .status-dibatalkan {
            background-color: #f8d7da;
            color: #721c24;
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 11px;
        }
        .summary {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 5px;
            margin-top: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            font-size: 14px;
        }
        .summary-item {
            text-align: center;
        }
        .summary-label {
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }
        .summary-value {
            font-size: 24px;
            font-weight: bold;
            color: #333;
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
    <button class="print-btn no-print" onclick="window.print()">🖨️ Print / Simpan sebagai PDF</button>

    <div class="header">
        <h1>LAPORAN PENJUALAN KESELURUHAN</h1>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
        <p>Total Transaksi: {{ $penjualan->count() }} | Total Omzet: Rp {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</p>
    </div>

    @if(request('tanggal_awal') || request('tanggal_akhir'))
    <div class="filters">
        <strong>Filter:</strong>
        @if(request('tanggal_awal'))
            Dari {{ request('tanggal_awal') }}
        @endif
        @if(request('tanggal_akhir'))
            hingga {{ request('tanggal_akhir') }}
        @endif
    </div>
    @endif

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 8%">ID</th>
                <th style="width: 15%">Pelanggan</th>
                <th style="width: 15%">Kasir</th>
                <th style="width: 12%">Tanggal</th>
                <th style="width: 15%">Total</th>
                <th style="width: 12%">Status</th>
                <th style="width: 12%">Metode</th>
            </tr>
        </thead>
        <tbody>
            @forelse($penjualan as $idx => $p)
            <tr>
                <td>{{ $idx + 1 }}</td>
                <td>#{{ $p->id }}</td>
                <td>{{ $p->pelanggan->name ?? 'Umum' }}</td>
                <td>{{ optional($p->karyawan)->name ?? '-' }}</td>
                <td>{{ $p->tanggal_penjualan->format('d/m/Y H:i') ?? '-' }}</td>
                <td style="text-align: right; font-weight: bold;">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                <td>
                    <span class="status-{{ $p->status_pesanan }}">
                        {{ ucfirst($p->status_pesanan) }}
                    </span>
                </td>
                <td>{{ ucfirst($p->metode_pembayaran) }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; padding: 20px;">Tidak ada data penjualan</td>
            </tr>
            @endforelse

            <tr class="total-row">
                <td colspan="5" style="text-align: right;">TOTAL:</td>
                <td style="text-align: right;">Rp {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-item">
            <div class="summary-label">Total Transaksi</div>
            <div class="summary-value">{{ $penjualan->count() }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Total Omzet</div>
            <div class="summary-value">Rp {{ number_format($penjualan->sum('total_harga'), 0, ',', '.') }}</div>
        </div>
        <div class="summary-item">
            <div class="summary-label">Rata-rata Per Transaksi</div>
            <div class="summary-value">Rp {{ number_format($penjualan->avg('total_harga'), 0, ',', '.') }}</div>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            // Uncomment untuk auto-print saat halaman load
            // window.print();
        });
    </script>
</body>
</html>
