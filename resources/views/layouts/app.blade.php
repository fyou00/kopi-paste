<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kopi Paste - Seduhan Hangat Mengawali Harimu')</title>
    @include('partials.theme-head')
    @stack('styles')
</head>
<body class="font-sans bg-cream text-espresso antialiased selection:bg-gold/40">

    @php
        $isHome = request()->routeIs('home');
    @endphp

    <!-- Navbar -->
    <nav id="navbar"
         data-home="{{ $isHome ? '1' : '0' }}"
         class="fixed top-0 inset-x-0 z-50 transition-all duration-300 {{ $isHome ? 'bg-gradient-to-b from-espresso/75 to-transparent' : 'navbar-scrolled' }}">
        <div class="max-w-7xl mx-auto px-5 sm:px-6">
            <div class="flex justify-between items-center h-[72px]">
                <!-- Brand Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <span class="w-10 h-10 rounded-xl bg-gold/15 border border-gold/30 text-gold flex items-center justify-center group-hover:bg-gold group-hover:text-espresso transition">
                        <i class="fas fa-mug-hot text-lg"></i>
                    </span>
                    <span class="font-script text-3xl text-gold tracking-wide">Kopi Paste</span>
                </a>

                <!-- Menu Desktop -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('home') }}"
                       class="relative py-2 text-sm font-medium transition {{ request()->routeIs('home') ? 'text-gold font-semibold' : 'text-white/90 hover:text-gold' }}">
                        Beranda
                        @if(request()->routeIs('home'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gold rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('menu.public') }}"
                       class="relative py-2 text-sm font-medium transition {{ request()->routeIs('menu.public') ? 'text-gold font-semibold' : 'text-white/90 hover:text-gold' }}">
                        Menu
                        @if(request()->routeIs('menu.public'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gold rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('about') }}"
                       class="relative py-2 text-sm font-medium transition {{ request()->routeIs('about') ? 'text-gold font-semibold' : 'text-white/90 hover:text-gold' }}">
                        Tentang Kami
                        @if(request()->routeIs('about'))
                            <span class="absolute bottom-0 left-0 right-0 h-0.5 bg-gold rounded-full"></span>
                        @endif
                    </a>
                    <a href="{{ route('about') }}#contact"
                       class="relative py-2 text-sm font-medium text-white/90 hover:text-gold transition">
                        Kontak
                    </a>
                </div>

                <!-- Right Action Slot -->
                <div class="hidden md:flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-gold px-5 py-2.5 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                            <i class="fas fa-gauge-high text-xs"></i>
                            <span>Dashboard</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-full text-sm font-medium text-white/90 border border-white/25 hover:border-gold hover:text-gold transition inline-flex items-center gap-2">
                            <i class="fas fa-user-shield text-xs"></i>
                            <span>Masuk Staf</span>
                        </a>
                        <a href="{{ route('menu.public') }}" class="btn-gold px-5 py-2.5 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                            <i class="fas fa-mug-saucer text-xs"></i>
                            <span>Lihat Menu</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <button type="button"
                        id="mobileMenuBtn"
                        class="md:hidden w-10 h-10 rounded-xl border border-white/20 text-white hover:border-gold hover:text-gold flex items-center justify-center transition"
                        onclick="toggleMobile()"
                        aria-label="Toggle navigasi"
                        aria-expanded="false">
                    <i class="fas fa-bars text-lg" id="mobileMenuIcon"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu Drawer -->
        <div id="mobileMenu" class="hidden md:hidden bg-espresso/95 glass-nav border-t border-white/10 shadow-xl">
            <div class="px-6 py-5 space-y-2">
                <a href="{{ route('home') }}"
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('home') ? 'bg-gold/15 text-gold font-semibold' : 'text-white/90 hover:bg-white/5' }}">
                    <span>Beranda</span>
                    <i class="fas fa-chevron-right text-xs opacity-60"></i>
                </a>
                <a href="{{ route('menu.public') }}"
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('menu.public') ? 'bg-gold/15 text-gold font-semibold' : 'text-white/90 hover:bg-white/5' }}">
                    <span>Daftar Menu</span>
                    <i class="fas fa-chevron-right text-xs opacity-60"></i>
                </a>
                <a href="{{ route('about') }}"
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium {{ request()->routeIs('about') ? 'bg-gold/15 text-gold font-semibold' : 'text-white/90 hover:bg-white/5' }}">
                    <span>Tentang Kami</span>
                    <i class="fas fa-chevron-right text-xs opacity-60"></i>
                </a>
                <a href="{{ route('about') }}#contact"
                   class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-white/90 hover:bg-white/5">
                    <span>Kontak &amp; Lokasi</span>
                    <i class="fas fa-chevron-right text-xs opacity-60"></i>
                </a>

                <div class="pt-3 mt-3 border-t border-white/10 flex flex-col gap-2.5">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-gold w-full py-2.5 rounded-xl text-center text-sm font-semibold">
                            <i class="fas fa-gauge-high mr-1.5"></i> Buka Dashboard
                        </a>
                    @else
                        <a href="{{ route('menu.public') }}" class="btn-gold w-full py-2.5 rounded-xl text-center text-sm font-semibold">
                            <i class="fas fa-mug-saucer mr-1.5"></i> Jelajahi Menu
                        </a>
                        <a href="{{ route('login') }}" class="w-full py-2.5 rounded-xl text-center text-sm font-medium text-white border border-white/25 hover:border-gold hover:text-gold transition">
                            <i class="fas fa-user-shield mr-1.5"></i> Masuk Staf
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-espresso text-white relative overflow-hidden border-t border-white/10">
        <div class="absolute inset-x-0 bottom-0 h-44 bg-bottom bg-no-repeat bg-contain opacity-25 pointer-events-none"
             style="background-image: url('/images/fotter_image.png');"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-16 pb-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">
                <!-- Brand -->
                <div>
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2.5 mb-4">
                        <span class="w-9 h-9 rounded-lg bg-gold/15 border border-gold/30 text-gold flex items-center justify-center">
                            <i class="fas fa-mug-hot"></i>
                        </span>
                        <span class="font-script text-3xl text-gold">Kopi Paste</span>
                    </a>
                    <p class="text-white/75 text-sm leading-relaxed mb-6">
                        Tempat terbaik untuk memulai pagi dan menemani produktivitas Anda dengan racikan biji kopi pilihan dan hidangan hangat.
                    </p>
                    <div class="flex items-center gap-3">
                        <a href="#instagram" aria-label="Instagram Kopi Paste"
                           class="w-9 h-9 rounded-full bg-white/10 border border-white/15 text-white hover:bg-gold hover:text-espresso hover:border-gold flex items-center justify-center transition">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#facebook" aria-label="Facebook Kopi Paste"
                           class="w-9 h-9 rounded-full bg-white/10 border border-white/15 text-white hover:bg-gold hover:text-espresso hover:border-gold flex items-center justify-center transition">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#tiktok" aria-label="TikTok Kopi Paste"
                           class="w-9 h-9 rounded-full bg-white/10 border border-white/15 text-white hover:bg-gold hover:text-espresso hover:border-gold flex items-center justify-center transition">
                            <i class="fab fa-tiktok text-sm"></i>
                        </a>
                        <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp Kopi Paste"
                           class="w-9 h-9 rounded-full bg-white/10 border border-white/15 text-white hover:bg-gold hover:text-espresso hover:border-gold flex items-center justify-center transition">
                            <i class="fab fa-whatsapp text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Navigasi -->
                <div>
                    <h4 class="font-serif text-lg font-bold text-gold mb-5">Navigasi</h4>
                    <ul class="space-y-3 text-sm">
                        <li>
                            <a href="{{ route('home') }}" class="text-white/75 hover:text-gold transition inline-flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs text-gold/70"></i> Beranda
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('menu.public') }}" class="text-white/75 hover:text-gold transition inline-flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs text-gold/70"></i> Daftar Menu
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-white/75 hover:text-gold transition inline-flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs text-gold/70"></i> Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}#contact" class="text-white/75 hover:text-gold transition inline-flex items-center gap-2">
                                <i class="fas fa-angle-right text-xs text-gold/70"></i> Kontak &amp; Lokasi
                            </a>
                        </li>
                        <li>
                            @auth
                                <a href="{{ route('dashboard') }}" class="text-white/75 hover:text-gold transition inline-flex items-center gap-2">
                                    <i class="fas fa-angle-right text-xs text-gold/70"></i> Dashboard Staf
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="text-white/75 hover:text-gold transition inline-flex items-center gap-2">
                                    <i class="fas fa-angle-right text-xs text-gold/70"></i> Portal Staf
                                </a>
                            @endauth
                        </li>
                    </ul>
                </div>

                <!-- Jam Operasional -->
                <div>
                    <h4 class="font-serif text-lg font-bold text-gold mb-5">Jam Operasional</h4>
                    <ul class="space-y-3 text-sm text-white/75">
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-clock text-gold mt-1"></i>
                            <div>
                                <p class="font-semibold text-white">Senin – Jumat</p>
                                <p class="font-mono-num text-xs text-white/70">08:00 – 22:00 WIB</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i class="fas fa-calendar-week text-gold mt-1"></i>
                            <div>
                                <p class="font-semibold text-white">Sabtu – Minggu</p>
                                <p class="font-mono-num text-xs text-white/70">09:00 – 23:00 WIB</p>
                            </div>
                        </li>
                        <li class="pt-1">
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-gold/15 border border-gold/25 text-gold text-xs font-medium">
                                <i class="fas fa-utensils"></i> Dine-In &amp; Take Away
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Kontak -->
                <div>
                    <h4 class="font-serif text-lg font-bold text-gold mb-5">Hubungi Kami</h4>
                    <ul class="space-y-3.5 text-sm text-white/75">
                        <li class="flex items-start gap-3">
                            <i class="fas fa-map-marker-alt text-gold mt-1"></i>
                            <span>Jl. Kopi No. 123, Medan, Sumatera Utara</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-phone text-gold"></i>
                            <a href="tel:081234567890" class="font-mono-num hover:text-gold transition">0812-3456-7890</a>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="fas fa-envelope text-gold"></i>
                            <a href="mailto:info@kopipaste.com" class="hover:text-gold transition">info@kopipaste.com</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-white/60">
                <p>&copy; {{ date('Y') }} Kopi Paste. Semua hak dilindungi.</p>
                <p>Diseduh segar setiap hari di Medan</p>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            const navbar = document.getElementById('navbar');
            const isHome = navbar && navbar.dataset.home === '1';

            function updateNavbar() {
                if (!navbar) return;
                const scrollTop = window.scrollY || window.pageYOffset || document.documentElement.scrollTop || 0;
                if (!isHome || scrollTop > 40) {
                    navbar.classList.remove('bg-transparent', 'bg-gradient-to-b', 'from-espresso/75', 'to-transparent');
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                    navbar.classList.add('bg-gradient-to-b', 'from-espresso/75', 'to-transparent');
                }
            }

            window.addEventListener('scroll', updateNavbar, { passive: true });
            document.addEventListener('scroll', updateNavbar, { passive: true });
            updateNavbar();
        })();

        function toggleMobile() {
            const menu = document.getElementById('mobileMenu');
            const btn = document.getElementById('mobileMenuBtn');
            const icon = document.getElementById('mobileMenuIcon');
            if (!menu) return;

            const isHidden = menu.classList.toggle('hidden');
            if (btn) btn.setAttribute('aria-expanded', String(!isHidden));
            if (icon) {
                icon.classList.toggle('fa-bars', isHidden);
                icon.classList.toggle('fa-times', !isHidden);
            }
        }

        // Smooth scroll for valid in-page anchors
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (!href || href === '#' || href.length < 2) {
                    return;
                }
                let target = null;
                try {
                    target = document.querySelector(href);
                } catch (_) {
                    return;
                }
                if (target) {
                    e.preventDefault();
                    target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    const mobileMenu = document.getElementById('mobileMenu');
                    if (mobileMenu) mobileMenu.classList.add('hidden');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
