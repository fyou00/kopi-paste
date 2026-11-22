@extends('layouts.cashier')

@section('title', 'Dashboard Kasir - Kopi Paste')
@section('page-title', 'Dashboard Kasir')

@section('content')
    @php
        $totalMeja = $tableTersedia + $tableTerisi;
        $okupansiPersen = $totalMeja > 0 ? round(($tableTerisi / $totalMeja) * 100) : 0;
    @endphp

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Pesanan Menunggu</p>
                <p class="font-mono-num text-3xl font-bold text-amber-600 mt-1">{{ $pesananMenunggu }}</p>
                <p class="text-xs text-stone-500 mt-1">Perlu segera diproses</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200/70 text-amber-600 flex items-center justify-center shrink-0">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Pesanan Diproses</p>
                <p class="font-mono-num text-3xl font-bold text-sky-600 mt-1">{{ $pesananDiproses }}</p>
                <p class="text-xs text-stone-500 mt-1">Sedang disiapkan barista</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-200/70 text-sky-600 flex items-center justify-center shrink-0">
                <i class="fas fa-mug-hot text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Transaksi Hari Ini</p>
                <p class="font-mono-num text-3xl font-bold text-emerald-600 mt-1">{{ $transaksiHariIni }}</p>
                <p class="text-xs text-stone-500 mt-1">Pembayaran selesai</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-600 flex items-center justify-center shrink-0">
                <i class="fas fa-receipt text-xl"></i>
            </div>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Pendapatan Hari Ini</p>
                <p class="font-mono-num text-2xl font-bold text-caramel mt-1 truncate">
                    Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}
                </p>
                <p class="text-xs text-stone-500 mt-1">Akumulasi omzet hari ini</p>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-orange-50 border border-orange-200/70 text-caramel flex items-center justify-center shrink-0">
                <i class="fas fa-wallet text-xl"></i>
            </div>
        </div>
    </div>

    <!-- Quick Actions Bar -->
    <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
            <div>
                <h2 class="font-serif text-lg font-bold text-espresso">Aksi Cepat Kasir</h2>
                <p class="text-xs text-stone-500">Akses instan ke alur kerja kasir harian</p>
            </div>
        </div>
        <div class="grid md:grid-cols-3 gap-4">
            <a href="{{ route('cashier.order.create') }}"
               class="group flex items-center gap-4 p-4 rounded-2xl bg-gradient-to-r from-roast to-brown text-white hover:shadow-lg transition">
                <span class="w-12 h-12 rounded-xl bg-gold text-espresso flex items-center justify-center shrink-0 group-hover:scale-105 transition">
                    <i class="fas fa-plus-circle text-xl"></i>
                </span>
                <div>
                    <p class="font-bold text-base">Buat Pesanan Baru</p>
                    <p class="text-xs text-white/75">Buka layar POS input menu</p>
                </div>
            </a>

            <a href="{{ route('cashier.order.index') }}"
               class="group flex items-center gap-4 p-4 rounded-2xl bg-cream/80 border border-latte hover:border-caramel hover:bg-amber-50/60 transition">
                <span class="w-12 h-12 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-clipboard-list text-xl"></i>
                </span>
                <div>
                    <p class="font-bold text-base text-espresso">Kelola Pesanan Aktif</p>
                    <p class="text-xs text-stone-500">Proses &amp; selesaikan pembayaran</p>
                </div>
            </a>

            <a href="{{ route('cashier.transaction.index') }}"
               class="group flex items-center gap-4 p-4 rounded-2xl bg-cream/80 border border-latte hover:border-caramel hover:bg-amber-50/60 transition">
                <span class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-history text-xl"></i>
                </span>
                <div>
                    <p class="font-bold text-base text-espresso">Riwayat Transaksi</p>
                    <p class="text-xs text-stone-500">Cek pembayaran &amp; cetak struk</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Main Operational Grid -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Active Orders Column -->
        <div class="lg:col-span-2 bg-white border border-latte rounded-2xl shadow-xs flex flex-col overflow-hidden">
            <div class="px-6 py-4 border-b border-latte flex flex-wrap items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <h3 class="font-serif text-xl font-bold text-espresso">Pesanan Aktif</h3>
                    <span class="px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-caramel text-xs font-bold font-mono-num">
                        {{ $totalPesananAktif }} Pesanan
                    </span>
                </div>

                <!-- Client-Side Tab Filter -->
                <div class="inline-flex rounded-xl bg-cream p-1 border border-latte text-xs font-semibold" role="tablist">
                    <button type="button" data-dash-filter="all" class="dash-tab px-3 py-1.5 rounded-lg bg-espresso text-gold transition">Semua</button>
                    <button type="button" data-dash-filter="menunggu" class="dash-tab px-3 py-1.5 rounded-lg text-stone-600 hover:text-espresso transition">Menunggu</button>
                    <button type="button" data-dash-filter="diproses" class="dash-tab px-3 py-1.5 rounded-lg text-stone-600 hover:text-espresso transition">Diproses</button>
                </div>
            </div>

            <div class="p-5 max-h-[520px] overflow-y-auto flex-1">
                @if($recentOrders->count() > 0)
                    <div id="dashboardOrdersList" class="space-y-3.5">
                        @foreach($recentOrders as $order)
                        <div data-order-status="{{ $order->status }}"
                             class="dashboard-order-card rounded-2xl border border-latte bg-cream/40 hover:bg-white hover:shadow-sm transition p-4 border-l-4 {{ $order->status === 'menunggu' ? 'border-l-amber-500' : 'border-l-sky-500' }}">
                            <div class="flex flex-wrap items-start justify-between gap-3 mb-2.5">
                                <div>
                                    <div class="flex items-center gap-2.5">
                                        <p class="font-bold text-base text-espresso">{{ $order->nama_pelanggan }}</p>
                                        <span class="font-mono-num text-xs text-stone-400">#{{ $order->id }}</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3 text-xs text-stone-500 mt-1">
                                        <span>
                                            @if($order->table)
                                                <i class="fas fa-chair text-caramel mr-1"></i> Meja {{ $order->table->nomor }}
                                            @else
                                                <i class="fas fa-shopping-bag text-caramel mr-1"></i> Take Away
                                            @endif
                                        </span>
                                        <span>
                                            <i class="fas fa-clock mr-1"></i> {{ $order->created_at->format('H:i') }}
                                        </span>
                                        <span>
                                            <i class="fas fa-utensils mr-1"></i> {{ $order->items->count() }} item
                                        </span>
                                    </div>
                                </div>

                                <span class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 {{ $order->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $order->status === 'menunggu' ? 'bg-amber-600' : 'bg-sky-600 animate-pulse' }}"></span>
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            @if($order->items->count() > 0)
                            <div class="flex flex-wrap gap-1.5 mb-3">
                                @foreach($order->items->take(4) as $item)
                                    <span class="px-2.5 py-0.5 rounded-md bg-white border border-latte text-xs text-stone-700">
                                        <strong class="font-mono-num text-caramel">{{ $item->qty }}x</strong> {{ $item->menu->nama ?? 'Menu' }}
                                    </span>
                                @endforeach
                                @if($order->items->count() > 4)
                                    <span class="px-2 py-0.5 rounded-md bg-latte/60 text-xs text-stone-600">
                                        +{{ $order->items->count() - 4 }} lainnya
                                    </span>
                                @endif
                            </div>
                            @endif

                            <div class="flex items-center justify-between pt-2.5 border-t border-latte/70">
                                <span class="font-mono-num text-base font-bold text-brown">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </span>
                                <a href="{{ route('cashier.order.show', $order) }}"
                                   class="inline-flex items-center gap-1.5 text-xs font-bold text-caramel hover:text-espresso transition">
                                    <span>Lihat Detail</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div id="dashboardOrdersFilterEmpty" class="hidden text-center py-10 text-stone-500 text-sm">
                        Tidak ada pesanan dengan status ini.
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="w-14 h-14 rounded-2xl bg-cream border border-latte text-stone-400 flex items-center justify-center mx-auto mb-3">
                            <i class="fas fa-check-double text-2xl"></i>
                        </div>
                        <p class="font-semibold text-espresso">Semua pesanan selesai!</p>
                        <p class="text-xs text-stone-500 mt-1">Belum ada pesanan aktif saat ini.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Insights Column -->
        <div class="space-y-6">
            <!-- Table Status Card -->
            <div class="bg-white border border-latte rounded-2xl p-6 shadow-xs">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-serif text-lg font-bold text-espresso">Status Meja</h3>
                    <span class="px-2.5 py-1 rounded-full bg-cream border border-latte text-xs font-bold font-mono-num text-brown">
                        {{ $okupansiPersen }}% Terisi
                    </span>
                </div>

                <!-- Occupancy Progress -->
                <div class="w-full h-2.5 bg-latte/70 rounded-full overflow-hidden mb-5">
                    <div class="h-full bg-gradient-to-r from-caramel to-gold rounded-full transition-all" style="width: {{ $okupansiPersen }}%"></div>
                </div>

                <div class="grid grid-cols-2 gap-3.5">
                    <div class="bg-emerald-50 border border-emerald-200/70 p-4 rounded-xl text-center">
                        <p class="font-mono-num text-3xl font-bold text-emerald-700">{{ $tableTersedia }}</p>
                        <p class="text-xs font-semibold text-emerald-800 mt-1">Meja Tersedia</p>
                    </div>
                    <div class="bg-amber-50 border border-amber-200/70 p-4 rounded-xl text-center">
                        <p class="font-mono-num text-3xl font-bold text-caramel">{{ $tableTerisi }}</p>
                        <p class="text-xs font-semibold text-amber-900 mt-1">Meja Terisi</p>
                    </div>
                </div>
            </div>

            <!-- Popular Menus Today -->
            <div class="bg-white border border-latte rounded-2xl shadow-xs overflow-hidden">
                <div class="px-6 py-4 border-b border-latte">
                    <h3 class="font-serif text-lg font-bold text-espresso">Menu Populer Hari Ini</h3>
                </div>
                <div class="p-5">
                    @if($popularMenusToday->count() > 0)
                        <div class="space-y-3.5">
                            @foreach($popularMenusToday as $idx => $menu)
                            <div class="flex items-center justify-between gap-3">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-6 h-6 rounded-full text-xs font-bold font-mono-num flex items-center justify-center shrink-0 {{ $idx === 0 ? 'bg-gold text-espresso' : 'bg-cream border border-latte text-brown' }}">
                                        {{ $idx + 1 }}
                                    </span>
                                    @if($menu->foto)
                                        <img src="{{ Storage::url($menu->foto) }}"
                                             alt="{{ $menu->nama }}"
                                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                             class="w-11 h-11 object-cover rounded-xl border border-latte shrink-0">
                                        <div class="hidden w-11 h-11 bg-cream border border-latte rounded-xl flex items-center justify-center shrink-0 text-stone-400">
                                            <i class="fas fa-utensils text-sm"></i>
                                        </div>
                                    @else
                                        <div class="w-11 h-11 bg-cream border border-latte rounded-xl flex items-center justify-center shrink-0 text-stone-400">
                                            <i class="fas fa-utensils text-sm"></i>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-semibold text-sm text-espresso truncate">{{ $menu->nama }}</p>
                                        <p class="text-xs text-stone-500 font-mono-num">{{ $menu->total_qty }} terjual</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-6 text-stone-500 text-sm">
                            <i class="fas fa-mug-saucer text-2xl text-stone-300 mb-2 block"></i>
                            Belum ada penjualan hari ini
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        const tabs = document.querySelectorAll('.dash-tab');
        const cards = document.querySelectorAll('.dashboard-order-card');
        const emptyEl = document.getElementById('dashboardOrdersFilterEmpty');

        tabs.forEach(tab => {
            tab.addEventListener('click', function () {
                const status = this.dataset.dashFilter;

                tabs.forEach(t => {
                    const active = t.dataset.dashFilter === status;
                    t.classList.toggle('bg-espresso', active);
                    t.classList.toggle('text-gold', active);
                    t.classList.toggle('text-stone-600', !active);
                });

                let visibleCount = 0;
                cards.forEach(card => {
                    const show = status === 'all' || card.dataset.orderStatus === status;
                    card.classList.toggle('hidden', !show);
                    if (show) visibleCount++;
                });

                if (emptyEl) {
                    emptyEl.classList.toggle('hidden', visibleCount > 0);
                }
            });
        });
    })();
</script>
@endpush
