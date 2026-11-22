@extends('layouts.admin')

@section('title', 'Laporan Penjualan - Kopi Paste')
@section('page-title', 'Laporan Penjualan')

@section('content')
@php
    $maxDailyRevenue = $dailySales->max('total_pendapatan') ?: 1;
    $maxHourlyTx = $hourlySales->max('total_transaksi') ?: 1;
    $peakHourObj = $hourlySales->sortByDesc('total_transaksi')->first();
    $peakHour = $peakHourObj ? (int) $peakHourObj->hour : null;
@endphp

<div class="space-y-6">
    <!-- Filter & Export Card -->
    <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm">
        <div class="flex flex-col xl:flex-row xl:items-end justify-between gap-5">
            <form id="reportFilterForm" method="GET" action="{{ route('admin.report.index') }}" class="flex flex-wrap gap-3.5 items-end flex-1">
                <div class="flex-1 min-w-[170px]">
                    <label for="startDateInput" class="block text-xs font-bold uppercase tracking-wider text-stone-500 mb-1.5">Tanggal Mulai</label>
                    <input type="date"
                           id="startDateInput"
                           name="start_date"
                           value="{{ $startDate->format('Y-m-d') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
                </div>

                <div class="flex-1 min-w-[170px]">
                    <label for="endDateInput" class="block text-xs font-bold uppercase tracking-wider text-stone-500 mb-1.5">Tanggal Akhir</label>
                    <input type="date"
                           id="endDateInput"
                           name="end_date"
                           value="{{ $endDate->format('Y-m-d') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
                </div>

                <!-- Quick Presets -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <button type="button" onclick="applyReportPreset('today')" class="px-3 py-2.5 rounded-xl bg-cream border border-latte hover:border-caramel text-xs font-semibold text-espresso transition">
                        Hari Ini
                    </button>
                    <button type="button" onclick="applyReportPreset('7days')" class="px-3 py-2.5 rounded-xl bg-cream border border-latte hover:border-caramel text-xs font-semibold text-espresso transition">
                        7 Hari
                    </button>
                    <button type="button" onclick="applyReportPreset('month')" class="px-3 py-2.5 rounded-xl bg-cream border border-latte hover:border-caramel text-xs font-semibold text-espresso transition">
                        Bulan Ini
                    </button>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="btn-espresso px-5 py-2.5 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                        <i class="fas fa-filter text-xs text-gold"></i>
                        <span>Filter</span>
                    </button>
                    <a href="{{ route('admin.report.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold transition inline-flex items-center gap-1.5">
                        <i class="fas fa-rotate-left text-xs"></i>
                        <span>Reset</span>
                    </a>
                </div>
            </form>

            <!-- Export Actions -->
            <div class="flex flex-wrap gap-2.5 shrink-0 pt-2 xl:pt-0 border-t xl:border-t-0 border-latte">
                <a href="{{ route('admin.report.print', request()->query()) }}"
                   target="_blank"
                   class="px-4 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-semibold transition inline-flex items-center gap-2">
                    <i class="fas fa-print"></i>
                    <span>Cetak Laporan</span>
                </a>
                <a href="{{ route('admin.report.export', request()->query()) }}"
                   class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold transition inline-flex items-center gap-2">
                    <i class="fas fa-file-csv"></i>
                    <span>Export CSV</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Transaksi</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ number_format($totalTransaksi, 0, ',', '.') }}</p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-200/70 text-sky-600 flex items-center justify-center shrink-0">
                <i class="fas fa-receipt text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Pendapatan</p>
                <p class="font-mono-num text-2xl font-bold text-emerald-700 mt-1 truncate">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-600 flex items-center justify-center shrink-0">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Pesanan</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ number_format($totalPesanan, 0, ',', '.') }}</p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-200/70 text-purple-600 flex items-center justify-center shrink-0">
                <i class="fas fa-shopping-bag text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Rata-rata / Transaksi</p>
                <p class="font-mono-num text-2xl font-bold text-caramel mt-1 truncate">
                    Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}
                </p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200/70 text-caramel flex items-center justify-center shrink-0">
                <i class="fas fa-chart-line text-xl"></i>
            </span>
        </div>
    </div>

    <!-- Payment Methods Breakdown -->
    <div class="bg-white border border-latte rounded-2xl p-6 shadow-sm">
        <div class="flex items-center justify-between mb-5">
            <h3 class="font-serif text-xl font-bold text-espresso flex items-center gap-2.5">
                <i class="fas fa-credit-card text-caramel text-base"></i>
                <span>Metode Pembayaran</span>
            </h3>
            <span class="text-xs text-stone-500">
                {{ $startDate->format('d M Y') }} – {{ $endDate->format('d M Y') }}
            </span>
        </div>

        @if($paymentMethods->count() > 0)
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($paymentMethods as $method)
                @php
                    $mName = $method->metode_pembayaran;
                    $mConfig = match($mName) {
                        'Tunai' => ['icon' => 'fa-money-bill-wave', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'bar' => 'bg-emerald-500'],
                        'Transfer' => ['icon' => 'fa-university', 'badge' => 'bg-sky-50 text-sky-700 border-sky-200', 'bar' => 'bg-sky-500'],
                        'QRIS' => ['icon' => 'fa-qrcode', 'badge' => 'bg-purple-50 text-purple-700 border-purple-200', 'bar' => 'bg-purple-500'],
                        default => ['icon' => 'fa-credit-card', 'badge' => 'bg-amber-50 text-amber-700 border-amber-200', 'bar' => 'bg-amber-500'],
                    };
                    $mPct = $totalPendapatan > 0 ? round(($method->total_pendapatan / $totalPendapatan) * 100, 1) : 0;
                @endphp
                <div class="rounded-2xl border border-latte bg-cream/40 p-4">
                    <div class="flex items-center justify-between mb-3">
                        <span class="font-bold text-sm text-espresso">{{ $mName }}</span>
                        <span class="w-9 h-9 rounded-xl border flex items-center justify-center {{ $mConfig['badge'] }}">
                            <i class="fas {{ $mConfig['icon'] }}"></i>
                        </span>
                    </div>
                    <p class="font-mono-num text-2xl font-bold text-espresso">
                        {{ number_format($method->total_transaksi, 0, ',', '.') }}
                        <span class="text-xs font-normal text-stone-500">trx</span>
                    </p>
                    <p class="font-mono-num text-sm font-bold text-brown mt-0.5 mb-3">
                        Rp {{ number_format($method->total_pendapatan, 0, ',', '.') }}
                    </p>
                    <div class="w-full h-1.5 bg-white rounded-full overflow-hidden mb-1">
                        <div class="h-full rounded-full {{ $mConfig['bar'] }}" style="width: {{ $mPct }}%"></div>
                    </div>
                    <p class="text-right font-mono-num text-[11px] font-semibold text-stone-500">{{ $mPct }}% kontribusi</p>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-8 text-stone-500 text-sm">
                Belum ada transaksi pada rentang tanggal ini.
            </div>
        @endif
    </div>

    <!-- Category Sales & Top Menus -->
    <div class="grid lg:grid-cols-12 gap-6">
        <!-- Sales by Category -->
        <div class="lg:col-span-5 bg-white border border-latte rounded-2xl p-6 shadow-sm">
            <h3 class="font-serif text-xl font-bold text-espresso mb-4 flex items-center gap-2.5">
                <i class="fas fa-chart-pie text-caramel text-base"></i>
                <span>Penjualan per Kategori</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-cream border-b border-latte text-stone-600 text-xs uppercase">
                        <tr>
                            <th class="px-3 py-2.5 text-left">Kategori</th>
                            <th class="px-3 py-2.5 text-right">Qty</th>
                            <th class="px-3 py-2.5 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-latte/60">
                        @forelse($salesByCategory as $category)
                        @php
                            $catPct = $totalPendapatan > 0 ? ($category->total_pendapatan / $totalPendapatan) * 100 : 0;
                        @endphp
                        <tr>
                            <td class="px-3 py-3">
                                <p class="font-bold text-espresso">{{ $category->kategori }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <div class="flex-1 bg-cream rounded-full h-1.5 max-w-[110px]">
                                        <div class="bg-gradient-to-r from-caramel to-gold h-1.5 rounded-full" style="width: {{ $catPct }}%"></div>
                                    </div>
                                    <span class="font-mono-num text-[11px] text-stone-500">{{ number_format($catPct, 1) }}%</span>
                                </div>
                            </td>
                            <td class="px-3 py-3 text-right font-mono-num font-semibold text-stone-700">
                                {{ number_format($category->total_qty, 0, ',', '.') }}
                            </td>
                            <td class="px-3 py-3 text-right font-mono-num font-bold text-brown whitespace-nowrap">
                                Rp {{ number_format($category->total_pendapatan, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-stone-500 text-sm">
                                Tidak ada data penjualan kategori.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Selling Menus -->
        <div class="lg:col-span-7 bg-white border border-latte rounded-2xl p-6 shadow-sm">
            <h3 class="font-serif text-xl font-bold text-espresso mb-4 flex items-center gap-2.5">
                <i class="fas fa-star text-gold text-base"></i>
                <span>Menu Terlaris (Top 10)</span>
            </h3>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-cream border-b border-latte text-stone-600 text-xs uppercase">
                        <tr>
                            <th class="px-3 py-2.5 text-left">Rank</th>
                            <th class="px-3 py-2.5 text-left">Nama Menu</th>
                            <th class="px-3 py-2.5 text-left">Kategori</th>
                            <th class="px-3 py-2.5 text-right">Terjual</th>
                            <th class="px-3 py-2.5 text-right">Pendapatan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-latte/60">
                        @forelse($topMenus as $index => $menu)
                        @php
                            $rankBadge = $index === 0 ? 'bg-gold text-espresso' : ($index === 1 ? 'bg-stone-300 text-espresso' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-cream border border-latte text-stone-600'));
                        @endphp
                        <tr class="{{ $index < 3 ? 'bg-amber-50/40' : '' }}">
                            <td class="px-3 py-3">
                                <span class="w-7 h-7 rounded-full inline-flex items-center justify-center font-mono-num text-xs font-bold {{ $rankBadge }}">
                                    {{ $index + 1 }}
                                </span>
                            </td>
                            <td class="px-3 py-3 font-bold text-espresso">{{ $menu->nama }}</td>
                            <td class="px-3 py-3">
                                <span class="px-2.5 py-0.5 rounded-full bg-cream border border-latte text-xs font-medium text-brown">
                                    {{ $menu->kategori }}
                                </span>
                            </td>
                            <td class="px-3 py-3 text-right font-mono-num font-bold text-caramel whitespace-nowrap">
                                {{ number_format($menu->total_qty, 0, ',', '.') }} item
                            </td>
                            <td class="px-3 py-3 text-right font-mono-num font-bold text-emerald-700 whitespace-nowrap">
                                Rp {{ number_format($menu->total_pendapatan, 0, ',', '.') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-stone-500 text-sm">
                                Belum ada data menu terjual pada periode ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Daily Sales Visual Bar Chart + Table -->
    <div class="bg-white border border-latte rounded-2xl p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <h3 class="font-serif text-xl font-bold text-espresso flex items-center gap-2.5">
                <i class="fas fa-chart-bar text-caramel text-base"></i>
                <span>Grafik Penjualan Harian</span>
            </h3>
            <span class="text-xs text-stone-500 font-mono-num">
                {{ $dailySales->count() }} hari tercatat
            </span>
        </div>

        @if($dailySales->count() > 0)
            <!-- Visual Proportional Bar Chart -->
            <div class="overflow-x-auto pb-3 mb-6 border-b border-latte">
                <div class="flex items-end gap-2.5 min-w-[520px] h-44 px-2 pt-6 bg-cream/50 rounded-2xl border border-latte/70">
                    @foreach($dailySales as $sale)
                    @php
                        $pct = $maxDailyRevenue > 0 ? max(8, round(($sale->total_pendapatan / $maxDailyRevenue) * 100)) : 8;
                        $dateObj = \Carbon\Carbon::parse($sale->date);
                    @endphp
                    <div class="flex-1 min-w-[34px] flex flex-col items-center h-full justify-end group relative">
                        <div class="hidden group-hover:block absolute -top-2 z-10 bg-espresso text-white text-[11px] px-2.5 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none">
                            <p class="font-bold text-gold">{{ $dateObj->format('d M Y') }}</p>
                            <p class="font-mono-num">Rp {{ number_format($sale->total_pendapatan, 0, ',', '.') }} ({{ $sale->total_transaksi }} trx)</p>
                        </div>
                        <div class="w-full max-w-[36px] bg-gradient-to-t from-brown to-gold rounded-t-lg group-hover:from-caramel group-hover:to-amber-300 transition-all"
                             style="height: {{ $pct }}%"></div>
                        <span class="text-[10px] font-mono-num text-stone-500 mt-1.5 pb-1.5">{{ $dateObj->format('d/m') }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Detailed Daily Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-cream border-b border-latte text-stone-600 text-xs uppercase">
                        <tr>
                            <th class="px-4 py-3 text-left">Tanggal</th>
                            <th class="px-4 py-3 text-right">Total Transaksi</th>
                            <th class="px-4 py-3 text-right">Total Pendapatan</th>
                            <th class="px-4 py-3 text-right">Rata-rata / Trx</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-latte/60">
                        @foreach($dailySales as $sale)
                        <tr>
                            <td class="px-4 py-3 font-medium text-espresso whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($sale->date)->format('d M Y') }}
                            </td>
                            <td class="px-4 py-3 text-right font-mono-num">{{ number_format($sale->total_transaksi, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-mono-num font-bold text-emerald-700 whitespace-nowrap">
                                Rp {{ number_format($sale->total_pendapatan, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-right font-mono-num text-stone-600 whitespace-nowrap">
                                Rp {{ number_format($sale->total_transaksi > 0 ? $sale->total_pendapatan / $sale->total_transaksi : 0, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-cream border-t border-latte font-bold">
                        <tr>
                            <td class="px-4 py-3 text-espresso">TOTAL</td>
                            <td class="px-4 py-3 text-right font-mono-num">{{ number_format($totalTransaksi, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-mono-num text-emerald-700">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-right font-mono-num">Rp {{ number_format($rataRataTransaksi, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        @else
            <div class="text-center py-10 text-stone-500 text-sm">
                Belum ada data penjualan harian pada periode ini.
            </div>
        @endif
    </div>

    <!-- Hourly Sales Pattern (True 24-Column Horizontal Timeline) -->
    <div class="bg-white border border-latte rounded-2xl p-6 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-5">
            <div>
                <h3 class="font-serif text-xl font-bold text-espresso flex items-center gap-2.5">
                    <i class="fas fa-clock text-caramel text-base"></i>
                    <span>Pola Penjualan per Jam (00:00 – 23:00)</span>
                </h3>
                <p class="text-xs text-stone-500 mt-0.5">Arahkan kursor pada batang grafik untuk melihat detail jam.</p>
            </div>
            @if($peakHour !== null && $peakHourObj->total_transaksi > 0)
                <span class="px-3.5 py-1.5 rounded-full bg-amber-50 border border-amber-200 text-xs font-bold text-caramel">
                    <i class="fas fa-fire mr-1"></i> Jam Tersibuk: {{ sprintf('%02d:00', $peakHour) }} ({{ $peakHourObj->total_transaksi }} trx)
                </span>
            @endif
        </div>

        <div class="overflow-x-auto pb-2">
            <div class="min-w-[720px] grid gap-1.5 items-end h-52 bg-cream/50 border border-latte/70 rounded-2xl p-4 pt-8"
                 style="grid-template-columns: repeat(24, minmax(0, 1fr));">
                @for($hour = 0; $hour < 24; $hour++)
                    @php
                        $hourData = $hourlySales->firstWhere('hour', $hour);
                        $transaksi = $hourData ? (int) $hourData->total_transaksi : 0;
                        $pendapatan = $hourData ? (int) $hourData->total_pendapatan : 0;
                        $heightPercent = $transaksi > 0 ? max(10, round(($transaksi / $maxHourlyTx) * 100)) : 4;
                        $isPeak = ($peakHour === $hour && $transaksi > 0);
                    @endphp
                    <div class="h-full flex flex-col items-center justify-end group relative">
                        @if($transaksi > 0)
                            <div class="hidden group-hover:block absolute -top-2 left-1/2 -translate-x-1/2 z-20 bg-espresso text-white text-[11px] px-2.5 py-1.5 rounded-lg shadow-lg whitespace-nowrap pointer-events-none">
                                <p class="font-bold text-gold">{{ sprintf('%02d:00', $hour) }}</p>
                                <p class="font-mono-num">{{ $transaksi }} trx &bull; Rp {{ number_format($pendapatan, 0, ',', '.') }}</p>
                            </div>
                        @endif

                        <div class="w-full flex-1 flex items-end justify-center">
                            <div class="w-full rounded-t-md transition-all flex items-start justify-center {{ $transaksi === 0 ? 'bg-latte/80' : ($isPeak ? 'bg-gradient-to-t from-caramel to-gold shadow-sm' : 'bg-brown/80 group-hover:bg-caramel') }}"
                                 style="height: {{ $heightPercent }}%">
                                @if($transaksi > 0 && $heightPercent >= 22)
                                    <span class="font-mono-num text-[10px] font-bold text-white pt-1">{{ $transaksi }}</span>
                                @endif
                            </div>
                        </div>

                        <p class="font-mono-num text-[10px] mt-1.5 {{ $isPeak ? 'font-bold text-caramel' : 'text-stone-500' }}">
                            {{ sprintf('%02d', $hour) }}
                        </p>
                    </div>
                @endfor
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatDateYMD(dateObj) {
        const y = dateObj.getFullYear();
        const m = String(dateObj.getMonth() + 1).padStart(2, '0');
        const d = String(dateObj.getDate()).padStart(2, '0');
        return `${y}-${m}-${d}`;
    }

    function applyReportPreset(preset) {
        const startInput = document.getElementById('startDateInput');
        const endInput = document.getElementById('endDateInput');
        const form = document.getElementById('reportFilterForm');
        if (!startInput || !endInput || !form) return;

        const now = new Date();
        let start = new Date(now);
        const end = new Date(now);

        if (preset === '7days') {
            start.setDate(now.getDate() - 6);
        } else if (preset === 'month') {
            start = new Date(now.getFullYear(), now.getMonth(), 1);
        }

        startInput.value = formatDateYMD(start);
        endInput.value = formatDateYMD(end);
        form.submit();
    }
</script>
@endpush
