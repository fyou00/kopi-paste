@extends('layouts.cashier')

@section('title', 'Riwayat Transaksi - Kopi Paste')
@section('page-title', 'Riwayat Transaksi')

@section('content')
    <!-- Filter Card -->
    <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs mb-6">
        <form action="{{ route('cashier.transaction.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-3.5 items-end">
            <div class="lg:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-500 mb-1.5">Dari Tanggal</label>
                <input type="date"
                       name="start_date"
                       value="{{ request('start_date') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
            </div>

            <div class="lg:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-500 mb-1.5">Sampai Tanggal</label>
                <input type="date"
                       name="end_date"
                       value="{{ request('end_date') }}"
                       class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
            </div>

            <div class="lg:col-span-3">
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-500 mb-1.5">Metode Pembayaran</label>
                <select name="metode_pembayaran"
                        class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
                    <option value="">Semua Metode</option>
                    <option value="Tunai" {{ request('metode_pembayaran') === 'Tunai' ? 'selected' : '' }}>Tunai</option>
                    <option value="Transfer" {{ request('metode_pembayaran') === 'Transfer' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="QRIS" {{ request('metode_pembayaran') === 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    <option value="Kartu Debit/Kredit" {{ request('metode_pembayaran') === 'Kartu Debit/Kredit' ? 'selected' : '' }}>Kartu Debit/Kredit</option>
                </select>
            </div>

            <div class="lg:col-span-3">
                <label class="block text-xs font-bold uppercase tracking-wider text-stone-500 mb-1.5">Pelanggan</label>
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari nama pelanggan..."
                       class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
            </div>

            <div class="lg:col-span-2 flex gap-2">
                <button type="submit" class="flex-1 btn-espresso py-2.5 px-4 rounded-xl text-sm font-semibold inline-flex items-center justify-center gap-1.5">
                    <i class="fas fa-search text-xs text-gold"></i>
                    <span>Cari</span>
                </button>
                <a href="{{ route('cashier.transaction.index') }}"
                   class="py-2.5 px-3.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold transition inline-flex items-center justify-center"
                   title="Reset Filter">
                    <i class="fas fa-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>

    <!-- Summary KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs">
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-500 mb-1">Total Transaksi</p>
            <p class="font-mono-num text-3xl font-bold text-espresso">{{ $totalTransaksi }}</p>
            <p class="text-xs text-stone-400 mt-1">Sesuai filter aktif</p>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs">
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-500 mb-1">Total Pendapatan</p>
            <p class="font-mono-num text-2xl font-bold text-emerald-600">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            <p class="text-xs text-stone-400 mt-1">Akumulasi hasil filter</p>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs">
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-500 mb-1">Hari Ini</p>
            <p class="font-mono-num text-2xl font-bold text-caramel">Rp {{ number_format($totalHariIni, 0, ',', '.') }}</p>
            <p class="text-xs text-stone-400 mt-1">Pendapatan harian</p>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs">
            <p class="text-xs font-semibold uppercase tracking-wider text-stone-500 mb-1">Bulan Ini</p>
            <p class="font-mono-num text-2xl font-bold text-sky-600">Rp {{ number_format($totalBulanIni, 0, ',', '.') }}</p>
            <p class="text-xs text-stone-400 mt-1">Akumulasi bulanan</p>
        </div>
    </div>

    <!-- Today Payment Methods Breakdown -->
    @if($paymentMethodStats->count() > 0)
    <div class="bg-white border border-latte rounded-2xl p-6 shadow-xs mb-6">
        <h3 class="font-serif text-lg font-bold text-espresso mb-4">Metode Pembayaran Hari Ini</h3>
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach($paymentMethodStats as $stat)
            @php
                $method = $stat->metode_pembayaran;
                $iconClass = $method === 'Tunai' ? 'fa-money-bill-wave text-emerald-600 bg-emerald-50' :
                    ($method === 'Transfer' ? 'fa-university text-sky-600 bg-sky-50' :
                    ($method === 'QRIS' ? 'fa-qrcode text-purple-600 bg-purple-50' : 'fa-credit-card text-amber-600 bg-amber-50'));
                $pct = $totalHariIni > 0 ? round(($stat->total / $totalHariIni) * 100) : 0;
            @endphp
            <div class="p-4 rounded-2xl bg-cream/60 border border-latte">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-bold text-espresso">{{ $method }}</span>
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center {{ $iconClass }}">
                        <i class="fas {{ explode(' ', $iconClass)[0] }} text-sm"></i>
                    </span>
                </div>
                <p class="font-mono-num text-2xl font-bold text-espresso">{{ $stat->count }} <span class="text-xs font-normal text-stone-500">transaksi</span></p>
                <div class="flex items-center justify-between text-xs text-stone-600 mt-1">
                    <span class="font-mono-num font-semibold text-brown">Rp {{ number_format($stat->total, 0, ',', '.') }}</span>
                    <span class="font-mono-num font-bold text-caramel">{{ $pct }}%</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Transactions Table -->
    <div class="bg-white border border-latte rounded-2xl shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-cream border-b border-latte text-stone-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-left">Waktu</th>
                        <th class="px-5 py-3.5 text-left">Pelanggan</th>
                        <th class="px-5 py-3.5 text-left">Meja</th>
                        <th class="px-5 py-3.5 text-left">Item</th>
                        <th class="px-5 py-3.5 text-left">Metode</th>
                        <th class="px-5 py-3.5 text-right">Total</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-latte/60">
                    @forelse($transactions as $transaction)
                    @php
                        $m = $transaction->metode_pembayaran;
                        $badgeStyle = $m === 'Tunai' ? 'bg-emerald-100 text-emerald-800' :
                            ($m === 'Transfer' ? 'bg-sky-100 text-sky-800' :
                            ($m === 'QRIS' ? 'bg-purple-100 text-purple-800' : 'bg-amber-100 text-amber-800'));
                    @endphp
                    <tr class="hover:bg-cream/40 transition">
                        <td class="px-5 py-4 font-mono-num text-xs text-stone-600 whitespace-nowrap">
                            {{ $transaction->created_at->format('H:i, d/m/Y') }}
                        </td>
                        <td class="px-5 py-4 font-bold text-espresso whitespace-nowrap">
                            {{ $transaction->order->nama_pelanggan }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($transaction->order->table)
                                <span class="px-2.5 py-1 rounded-lg bg-cream border border-latte text-xs font-semibold text-espresso">
                                    Meja {{ $transaction->order->table->nomor }}
                                </span>
                            @else
                                <span class="text-xs text-stone-500">Take Away</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 font-mono-num text-stone-600 whitespace-nowrap">
                            {{ $transaction->order->items->count() }} item
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badgeStyle }}">
                                {{ $transaction->metode_pembayaran }}
                            </span>
                        </td>
                        <td class="px-5 py-4 text-right font-mono-num font-bold text-emerald-700 whitespace-nowrap">
                            Rp {{ number_format($transaction->total, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 text-center whitespace-nowrap">
                            <a href="{{ route('cashier.transaction.show', $transaction) }}"
                               class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-espresso text-gold hover:bg-brown text-xs font-semibold transition">
                                <i class="fas fa-receipt"></i>
                                <span>Detail / Struk</span>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-14 text-center text-stone-500">
                            <i class="fas fa-receipt text-5xl text-stone-300 mb-3 block"></i>
                            <p class="font-serif text-lg font-bold text-espresso">Tidak ada transaksi ditemukan</p>
                            <p class="text-xs text-stone-400 mt-1">Coba ubah rentang tanggal atau kata kunci pencarian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $transactions->links() }}
    </div>
@endsection
