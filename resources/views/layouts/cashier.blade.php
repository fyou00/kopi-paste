<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kasir - Kopi Paste')</title>
    @include('partials.theme-head')
    @stack('styles')
</head>
<body class="font-sans bg-cream text-espresso antialiased">
    @php
        $userName = auth()->user()->name ?? 'Kasir';
        $userInitials = strtoupper(substr($userName, 0, 2));
    @endphp

    <div class="flex h-screen overflow-hidden">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay"
             class="hidden fixed inset-0 bg-espresso/60 backdrop-blur-xs z-40 md:hidden no-print"
             onclick="toggleSidebar()"></div>

        <!-- Sidebar -->
        <aside id="cashierSidebar"
               class="fixed inset-y-0 left-0 z-50 w-64 bg-roast text-white flex flex-col transform -translate-x-full md:translate-x-0 md:static transition-transform duration-200 ease-out shrink-0 border-r border-white/10 no-print">
            <!-- Brand Block -->
            <div class="px-5 py-5 border-b border-white/10 flex items-center justify-between">
                <a href="{{ route('cashier.dashboard') }}" class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gold/15 border border-gold/30 text-gold flex items-center justify-center shrink-0">
                        <i class="fas fa-mug-hot text-lg"></i>
                    </span>
                    <div>
                        <span class="font-script text-2xl text-gold block leading-none">Kopi Paste</span>
                        <span class="inline-block mt-1 px-2 py-0.5 rounded-md bg-caramel/25 text-gold text-[10px] font-bold uppercase tracking-wider">
                            Panel Kasir
                        </span>
                    </div>
                </a>
                <button type="button"
                        onclick="toggleSidebar()"
                        class="md:hidden text-white/70 hover:text-white p-1.5 rounded-lg"
                        aria-label="Tutup menu samping">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <!-- Primary POS Shortcut -->
            <div class="px-4 pt-4">
                <a href="{{ route('cashier.order.create') }}"
                   class="w-full btn-gold py-2.5 px-4 rounded-xl text-sm font-bold flex items-center justify-center gap-2 shadow-sm">
                    <i class="fas fa-plus-circle"></i>
                    <span>Buat Pesanan</span>
                </a>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-3 py-4 space-y-1.5 overflow-y-auto">
                <p class="px-3 pb-1 text-[11px] font-bold uppercase tracking-wider text-white/40">Operasional</p>

                <a href="{{ route('cashier.dashboard') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('cashier.dashboard') ? 'bg-caramel/20 text-gold border border-gold/25 font-semibold' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-gauge-high w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>

                <a href="{{ route('cashier.order.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('cashier.order.*') ? 'bg-caramel/20 text-gold border border-gold/25 font-semibold' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-clipboard-list w-5 text-center"></i>
                    <span>Pesanan</span>
                </a>

                <a href="{{ route('cashier.transaction.index') }}"
                   class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-medium transition {{ request()->routeIs('cashier.transaction.*') ? 'bg-caramel/20 text-gold border border-gold/25 font-semibold' : 'text-white/75 hover:bg-white/5 hover:text-white' }}">
                    <i class="fas fa-receipt w-5 text-center"></i>
                    <span>Transaksi</span>
                </a>
            </nav>

            <!-- User Footer -->
            <div class="mt-auto p-4 border-t border-white/10 bg-espresso/40">
                <div class="flex items-center gap-3 mb-3.5">
                    <div class="w-10 h-10 rounded-full bg-caramel text-white font-bold text-sm flex items-center justify-center shrink-0">
                        {{ $userInitials }}
                    </div>
                    <div class="min-w-0">
                        <p class="font-semibold text-sm text-white truncate">{{ $userName }}</p>
                        <p class="text-xs text-gold/80">Kasir Aktif</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full py-2 px-3 rounded-xl bg-rose-600/90 hover:bg-rose-600 text-white text-xs font-semibold transition flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Keluar</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
            <!-- Top Bar -->
            <header class="bg-white/95 glass-nav border-b border-latte shrink-0 no-print">
                <div class="px-4 sm:px-6 h-16 flex justify-between items-center gap-4">
                    <div class="flex items-center gap-3 min-w-0">
                        <button type="button"
                                onclick="toggleSidebar()"
                                class="md:hidden w-10 h-10 rounded-xl border border-latte text-espresso hover:bg-cream flex items-center justify-center shrink-0 transition"
                                aria-label="Buka menu navigasi">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="font-serif text-xl sm:text-2xl font-bold text-espresso truncate">@yield('page-title', 'Dashboard')</h1>
                    </div>

                    <div class="flex items-center gap-3 sm:gap-4 shrink-0">
                        <a href="{{ route('cashier.order.create') }}"
                           class="hidden sm:inline-flex items-center gap-2 btn-gold px-4 py-2 rounded-xl text-xs font-bold">
                            <i class="fas fa-plus"></i>
                            <span>Pesanan Baru</span>
                        </a>

                        <a href="{{ route('home') }}"
                           title="Lihat Website"
                           class="w-9 h-9 rounded-xl border border-latte text-brown hover:bg-cream flex items-center justify-center transition">
                            <i class="fas fa-globe text-sm"></i>
                        </a>

                        <div class="text-right pl-3 border-l border-latte hidden sm:block">
                            <p id="currentDate" class="text-xs text-stone-500 font-medium"></p>
                            <p id="currentTime" class="font-mono-num text-sm font-bold text-caramel"></p>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                @include('partials.flash-alerts')

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('cashierSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (!sidebar || !overlay) return;
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const sidebar = document.getElementById('cashierSidebar');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar && !sidebar.classList.contains('-translate-x-full') && window.innerWidth < 768) {
                    sidebar.classList.add('-translate-x-full');
                    if (overlay) overlay.classList.add('hidden');
                }
            }
        });

        function updateClock() {
            const now = new Date();
            const dateEl = document.getElementById('currentDate');
            const timeEl = document.getElementById('currentTime');

            if (dateEl) {
                dateEl.textContent = new Intl.DateTimeFormat('id-ID', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'short',
                    year: 'numeric'
                }).format(now);
            }

            if (timeEl) {
                timeEl.textContent = new Intl.DateTimeFormat('id-ID', {
                    hour: '2-digit',
                    minute: '2-digit',
                    second: '2-digit',
                    hour12: false
                }).format(now).replace(/\./g, ':') + ' WIB';
            }
        }
        updateClock();
        setInterval(updateClock, 1000);
    </script>

    @stack('scripts')
</body>
</html>
