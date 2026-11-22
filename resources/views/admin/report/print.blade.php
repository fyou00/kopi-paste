<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Penjualan Kopi Paste - {{ $startDate->format('d/m/Y') }} s/d {{ $endDate->format('d/m/Y') }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif;
            background: #FAF5EE;
            color: #1A110B;
            padding: 28px;
            font-size: 12px;
            line-height: 1.5;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        .sheet {
            max-width: 960px;
            margin: 0 auto;
            background: #FFFFFF;
            border: 1px solid #EFE4D6;
            border-radius: 16px;
            padding: 32px;
            box-shadow: 0 10px 30px rgba(26, 17, 11, 0.08);
        }
        .toolbar {
            max-width: 960px;
            margin: 0 auto 16px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }
        .btn {
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .btn-print {
            background: #1A110B;
            color: #E8B86D;
        }
        .btn-close {
            background: #EFE4D6;
            color: #1A110B;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #3B2314;
            padding-bottom: 18px;
            margin-bottom: 24px;
            gap: 16px;
        }
        .brand h1 {
            font-size: 24px;
            color: #3B2314;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .brand p {
            font-size: 11px;
            color: #6B4423;
        }
        .report-meta {
            text-align: right;
        }
        .report-meta h2 {
            font-size: 16px;
            color: #1A110B;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 4px;
        }
        .report-meta p {
            font-size: 11px;
            color: #57534E;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 26px;
        }
        .summary-card {
            border: 1px solid #EFE4D6;
            border-left: 4px solid #C67A34;
            background: #FAF5EE;
            padding: 14px;
            border-radius: 10px;
        }
        .summary-card h3 {
            font-size: 10px;
            color: #6B4423;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }
        .summary-card p {
            font-size: 17px;
            font-weight: 700;
            color: #1A110B;
            font-variant-numeric: tabular-nums;
        }
        .section {
            margin-bottom: 26px;
            break-inside: avoid;
        }
        .section h3 {
            font-size: 13px;
            color: #3B2314;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #E8B86D;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th {
            background: #3B2314;
            color: #FAF5EE;
            padding: 9px 10px;
            text-align: left;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.4px;
        }
        table td {
            padding: 8px 10px;
            border-bottom: 1px solid #EFE4D6;
            font-variant-numeric: tabular-nums;
        }
        table tbody tr:nth-child(even) {
            background: #FCF9F5;
        }
        table tfoot td {
            background: #FAF5EE;
            font-weight: 700;
            border-top: 2px solid #3B2314;
        }
        .text-right {
            text-align: right;
        }
        .highlight {
            background: #FEF3C7 !important;
        }
        .empty-row {
            text-align: center;
            color: #78716C;
            padding: 18px !important;
        }
        .footer {
            margin-top: 30px;
            padding-top: 14px;
            border-top: 1px dashed #D6C7B5;
            display: flex;
            justify-content: space-between;
            color: #78716C;
            font-size: 10px;
        }
        @media print {
            body {
                background: #FFFFFF;
                padding: 0;
            }
            .sheet {
                box-shadow: none;
                border: none;
                padding: 0;
                max-width: 100%;
            }
            .no-print {
                display: none !important;
            }
            @page {
                margin: 1.2cm;
            }
        }
    </style>
</head>
<body>
    <div class="toolbar no-print">
        <button type="button" onclick="window.close()" class="btn btn-close">Tutup</button>
        <button type="button" onclick="window.print()" class="btn btn-print">Cetak Laporan</button>
    </div>

    <div class="sheet">
        <div class="header">
            <div class="brand">
                <h1>KOPI PASTE</h1>
                <p>Jl. Kopi No. 123, Medan, Sumatera Utara</p>
                <p>Telp: 0812-3456-7890 &bull; Email: info@kopipaste.com</p>
            </div>
            <div class="report-meta">
                <h2>Laporan Penjualan</h2>
                <p>Periode: <strong>{{ $startDate->format('d F Y') }}</strong> s/d <strong>{{ $endDate->format('d F Y') }}</strong></p>
                <p>Dicetak: {{ now()->format('d F Y H:i') }} WIB</p>
            </div>
        </div>

        <div class="summary">
            <div class="summary-card">
                <h3>Total Transaksi</h3>
                <p>{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
            </div>
            <div class="summary-card">
                <h3>Total Pendapatan</h3>
                <p>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
            <div class="summary-card">
                <h3>Total Pesanan</h3>
                <p>{{ number_format($totalPesanan, 0, ',', '.') }}</p>
            </div>
            <div class="summary-card">
                <h3>Rata-rata / Transaksi</h3>
                <p>Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="section">
            <h3>Penjualan per Kategori</h3>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th class="text-right">Total Qty</th>
                        <th class="text-right">Total Pendapatan</th>
                        <th class="text-right">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesByCategory as $category)
                    <tr>
                        <td><strong>{{ $category->kategori }}</strong></td>
                        <td class="text-right">{{ number_format($category->total_qty, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($category->total_pendapatan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $totalPendapatan > 0 ? number_format($category->total_pendapatan / $totalPendapatan * 100, 1) : 0 }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada data penjualan kategori pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h3>Top 10 Menu Terlaris</h3>
            <table>
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Nama Menu</th>
                        <th>Kategori</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Terjual</th>
                        <th class="text-right">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topMenus as $index => $menu)
                    <tr class="{{ $index < 3 ? 'highlight' : '' }}">
                        <td><strong>#{{ $index + 1 }}</strong></td>
                        <td>{{ $menu->nama }}</td>
                        <td>{{ $menu->kategori }}</td>
                        <td class="text-right">Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                        <td class="text-right"><strong>{{ number_format($menu->total_qty, 0, ',', '.') }}</strong></td>
                        <td class="text-right"><strong>Rp {{ number_format($menu->total_pendapatan, 0, ',', '.') }}</strong></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="empty-row">Belum ada data menu terjual pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h3>Metode Pembayaran</h3>
            <table>
                <thead>
                    <tr>
                        <th>Metode</th>
                        <th class="text-right">Total Transaksi</th>
                        <th class="text-right">Total Pendapatan</th>
                        <th class="text-right">Persentase</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($paymentMethods as $method)
                    <tr>
                        <td><strong>{{ $method->metode_pembayaran }}</strong></td>
                        <td class="text-right">{{ number_format($method->total_transaksi, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($method->total_pendapatan, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $totalPendapatan > 0 ? number_format($method->total_pendapatan / $totalPendapatan * 100, 1) : 0 }}%</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada transaksi pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h3>Penjualan Harian</h3>
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th class="text-right">Total Transaksi</th>
                        <th class="text-right">Total Pendapatan</th>
                        <th class="text-right">Rata-rata</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailySales as $sale)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}</td>
                        <td class="text-right">{{ number_format($sale->total_transaksi, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($sale->total_pendapatan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($sale->total_transaksi > 0 ? $sale->total_pendapatan / $sale->total_transaksi : 0, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="empty-row">Belum ada penjualan harian pada periode ini.</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td>TOTAL</td>
                        <td class="text-right">{{ number_format($totalTransaksi, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                        <td class="text-right">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            <span>Dokumen ini dicetak secara otomatis dari sistem Kopi Paste</span>
            <span>&copy; {{ date('Y') }} Kopi Paste &bull; Medan</span>
        </div>
    </div>
</body>
</html>
