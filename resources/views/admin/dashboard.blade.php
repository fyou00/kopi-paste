@extends('layouts.admin')

@section('title', 'Admin Dashboard - Kopi Paste')
@section('page-title', 'Dashboard Admin')

@section('content')
    @php
        $maxTopQty = $topMenus->max('total_qty') ?: 1;
    @endphp

    <!-- Statistics KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">
        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Menu</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ $totalMenus }}</p>
                <div class="flex items-center gap-2 mt-2 text-xs">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold font-mono-num">{{ $menuTersedia }} tersedia</span>
                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 font-semibold font-mono-num">{{ $menuTidakTersedia }} habis</span>
                </div>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200/70 text-caramel flex items-center justify-center shrink-0">
                <i class="fas fa-mug-saucer text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Meja</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ $totalTables }}</p>
                <div class="flex items-center gap-2 mt-2 text-xs">
                    <span class="px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 font-semibold font-mono-num">{{ $tableTersedia }} tersedia</span>
                    <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold font-mono-num">{{ $tableTerisi }} terisi</span>
                </div>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-sky-50 border border-sky-200/70 text-sky-600 flex items-center justify-center shrink-0">
                <i class="fas fa-chair text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-start justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Pesanan Aktif</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ $totalPesananAktif }}</p>
                <div class="flex items-center gap-2 mt-2 text-xs">
                    <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700 font-semibold font-mono-num">{{ $pesananMenunggu }} menunggu</span>
                    <span class="px-2 py-0.5 rounded-full bg-sky-50 text-sky-700 font-semibold font-mono-num">{{ $pesananDiproses }} diproses</span>
                </div>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-600 flex items-center justify-center shrink-0">
                <i class="fas fa-clipboard-list text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-start justify-between gap-4">
            <div class="min-w-0">
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Transaksi Hari Ini</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ $transaksiHariIni }}</p>
                <p class="font-mono-num text-sm font-bold text-emerald-600 mt-2 truncate">
                    Rp {{ number_format($totalPendapatanHariIni, 0, ',', '.') }}
                </p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-purple-50 border border-purple-200/70 text-purple-600 flex items-center justify-center shrink-0">
                <i class="fas fa-money-bill-wave text-xl"></i>
            </span>
        </div>
    </div>

    <!-- Monthly Revenue & Quick Actions Banner -->
    <div class="grid lg:grid-cols-12 gap-6 mb-6">
        <div class="lg:col-span-7 bg-gradient-to-br from-espresso via-roast to-brown text-white rounded-3xl p-6 sm:p-7 shadow-sm relative overflow-hidden flex flex-col justify-between">
            <div class="absolute -right-8 -bottom-8 w-40 h-40 rounded-full bg-gold/10 pointer-events-none"></div>

            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <span class="inline-block px-3 py-1 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs font-semibold uppercase tracking-wider mb-2">
                        Ringkasan Bulanan
                    </span>
                    <h2 class="font-serif text-2xl font-bold">Pendapatan Bulan Ini</h2>
                </div>
                <span class="w-12 h-12 rounded-2xl bg-white/10 text-gold flex items-center justify-center">
                    <i class="fas fa-chart-pie text-xl"></i>
                </span>
            </div>

            <div class="grid sm:grid-cols-2 gap-6 pt-4 border-t border-white/15">
                <div>
                    <p class="text-xs text-white/70 uppercase tracking-wider">Total Transaksi</p>
                    <p class="font-mono-num text-3xl font-bold text-white mt-1">{{ number_format($transaksiBulanIni, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-xs text-white/70 uppercase tracking-wider">Total Pendapatan</p>
                    <p class="font-mono-num text-3xl font-bold text-gold mt-1">
                        Rp {{ number_format($totalPendapatanBulanIni, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-5 bg-white border border-latte rounded-3xl p-6 shadow-sm flex flex-col justify-between">
            <div>
                <h3 class="font-serif text-lg font-bold text-espresso mb-1">Aksi Cepat Admin</h3>
                <p class="text-xs text-stone-500 mb-4">Pintasan kelola inventaris dan laporan kedai</p>
            </div>

            <div class="space-y-2.5">
                <a href="{{ route('admin.menu.create') }}"
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-cream/70 border border-latte hover:border-caramel hover:bg-amber-50/60 transition group">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl bg-espresso text-gold flex items-center justify-center">
                            <i class="fas fa-plus text-sm"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">Tambah Menu Baru</span>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-stone-400 group-hover:text-caramel"></i>
                </a>

                <a href="{{ route('admin.table.create') }}"
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-cream/70 border border-latte hover:border-caramel hover:bg-amber-50/60 transition group">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl bg-caramel/15 text-caramel flex items-center justify-center">
                            <i class="fas fa-chair text-sm"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">Tambah Meja Kedai</span>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-stone-400 group-hover:text-caramel"></i>
                </a>

                <a href="{{ route('admin.report.index') }}"
                   class="flex items-center justify-between p-3.5 rounded-2xl bg-cream/70 border border-latte hover:border-caramel hover:bg-amber-50/60 transition group">
                    <div class="flex items-center gap-3">
                        <span class="w-9 h-9 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
                            <i class="fas fa-chart-line text-sm"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">Buka Laporan Penjualan</span>
                    </div>
                    <i class="fas fa-chevron-right text-xs text-stone-400 group-hover:text-caramel"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Bottom 2-Column Insights -->
    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Orders -->
        <div class="bg-white border border-latte rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-latte flex items-center justify-between">
                <h3 class="font-serif text-xl font-bold text-espresso">Pesanan Terbaru</h3>
                <span class="px-2.5 py-1 rounded-full bg-cream border border-latte text-xs font-semibold text-brown font-mono-num">
                    {{ $recentOrders->count() }} terbaru
                </span>
            </div>
            <div class="p-5">
                @if($recentOrders->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentOrders as $order)
                        <div class="rounded-2xl border border-latte bg-cream/40 p-4 border-l-4 {{ $order->status === 'menunggu' ? 'border-l-amber-500' : ($order->status === 'diproses' ? 'border-l-sky-500' : 'border-l-emerald-500') }}">
                            <div class="flex justify-between items-start gap-3 mb-2">
                                <div>
                                    <p class="font-bold text-espresso">{{ $order->nama_pelanggan }}</p>
                                    <p class="text-xs text-stone-500 mt-0.5">
                                        @if($order->table)
                                            <i class="fas fa-chair text-caramel mr-1"></i> Meja {{ $order->table->nomor }}
                                        @else
                                            <i class="fas fa-shopping-bag text-caramel mr-1"></i> Take Away
                                        @endif
                                        &bull; {{ $order->items->count() }} item
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $order->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($order->status === 'diproses' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <p class="font-mono-num font-bold text-brown text-sm">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-stone-500">
                        <i class="fas fa-clipboard-check text-3xl text-stone-300 mb-2 block"></i>
                        <p class="text-sm">Tidak ada pesanan aktif saat ini</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Top Selling Menus -->
        <div class="bg-white border border-latte rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-latte flex items-center justify-between">
                <h3 class="font-serif text-xl font-bold text-espresso">Menu Terlaris Bulan Ini</h3>
                <a href="{{ route('admin.report.index') }}" class="text-xs font-bold text-caramel hover:underline">
                    Detail Laporan &rarr;
                </a>
            </div>
            <div class="p-5">
                @if($topMenus->count() > 0)
                    <div class="space-y-4">
                        @foreach($topMenus as $index => $menu)
                        @php
                            $barPct = $maxTopQty > 0 ? round(($menu->total_qty / $maxTopQty) * 100) : 0;
                            $rankClass = $index === 0 ? 'bg-gold text-espresso' : ($index === 1 ? 'bg-stone-300 text-espresso' : ($index === 2 ? 'bg-amber-700 text-white' : 'bg-cream border border-latte text-stone-600'));
                        @endphp
                        <div>
                            <div class="flex items-center justify-between gap-3 mb-1.5">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-8 h-8 rounded-full font-mono-num text-xs font-bold flex items-center justify-center shrink-0 {{ $rankClass }}">
                                        #{{ $index + 1 }}
                                    </span>
                                    <div class="min-w-0">
                                        <p class="font-bold text-sm text-espresso truncate">{{ $menu->nama }}</p>
                                        <p class="text-xs text-stone-500 font-mono-num">{{ $menu->total_qty }} terjual</p>
                                    </div>
                                </div>
                                <p class="font-mono-num font-bold text-sm text-emerald-700 shrink-0">
                                    Rp {{ number_format($menu->total_sales, 0, ',', '.') }}
                                </p>
                            </div>
                            <div class="w-full h-1.5 bg-cream rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-caramel to-gold rounded-full" style="width: {{ $barPct }}%"></div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10 text-stone-500">
                        <i class="fas fa-chart-bar text-3xl text-stone-300 mb-2 block"></i>
                        <p class="text-sm">Belum ada data penjualan bulan ini</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
