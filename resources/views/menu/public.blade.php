@extends('layouts.app')

@section('title', 'Daftar Menu - Kopi Paste')

@push('styles')
<style>
    .hero-menu {
        background: linear-gradient(135deg, #1A110B 0%, #2D1B12 55%, #4A2E1B 100%);
        position: relative;
        overflow: hidden;
    }

    .hero-menu::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: url('/images/coffee_hero.png');
        background-size: cover;
        background-position: center;
        opacity: 0.18;
    }
</style>
@endpush

@section('content')
    @php
        $totalMenuItems = $menusByCategory->sum(function ($items) {
            return $items->count();
        });
    @endphp

    <!-- Hero Section -->
    <section class="hero-menu pt-32 pb-16">
        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs sm:text-sm font-semibold mb-5">
                <i class="fas fa-mug-saucer"></i>
                <span>Freshly Brewed &amp; Prepared Daily</span>
            </span>
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl text-white font-bold mb-4">
                Daftar Menu Kopi Paste
            </h1>
            <p class="text-white/80 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed mb-8">
                Temukan pilihan kopi signature, racikan non-kopi yang menyegarkan, hingga makanan dan camilan pendamping terbaik.
            </p>

            <div class="flex flex-wrap justify-center items-center gap-3 text-sm">
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/15 text-white">
                    <i class="fas fa-mug-hot text-gold"></i>
                    <strong class="font-mono-num">{{ $totalMenuItems }}</strong> Menu Tersedia
                </span>
                <span class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/15 text-white">
                    <i class="fas fa-layer-group text-gold"></i>
                    <strong class="font-mono-num">{{ $menusByCategory->count() }}</strong> Kategori
                </span>
            </div>
        </div>
    </section>

    <!-- Sticky Filter & Category Bar -->
    @if($menusByCategory->count() > 0)
    <div class="sticky top-[72px] z-30 bg-white/95 glass-nav border-b border-latte shadow-xs">
        <div class="max-w-7xl mx-auto px-6 py-3.5">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-3.5">
                <!-- Category Pills -->
                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar pb-1 lg:pb-0" role="tablist" aria-label="Filter kategori menu">
                    <button type="button"
                            data-category-btn="all"
                            class="category-pill shrink-0 px-4 py-2 rounded-full text-xs sm:text-sm font-semibold transition bg-espresso text-gold shadow-xs">
                        Semua Menu
                    </button>
                    @foreach($categories as $cat)
                        @if($menusByCategory->has($cat))
                        <button type="button"
                                data-category-btn="{{ Str::slug($cat) }}"
                                class="category-pill shrink-0 px-4 py-2 rounded-full text-xs sm:text-sm font-medium transition bg-cream text-espresso border border-latte hover:border-caramel">
                            {{ $cat }}
                        </button>
                        @endif
                    @endforeach
                </div>

                <!-- Search & Visible Counter -->
                <div class="flex items-center gap-3 shrink-0">
                    <div class="relative flex-1 sm:w-64 lg:w-72">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
                        <input type="text"
                               id="menuSearch"
                               placeholder="Cari kopi, teh, atau makanan..."
                               aria-label="Cari menu"
                               class="w-full pl-10 pr-9 py-2 rounded-full bg-cream/70 border border-latte text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition">
                        <button type="button"
                                id="clearMenuSearch"
                                class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-espresso text-xs p-1"
                                aria-label="Hapus pencarian">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <span id="visibleMenuCounter" class="hidden sm:inline-flex items-center px-3 py-1.5 rounded-full bg-cream border border-latte text-xs font-semibold text-brown font-mono-num">
                        {{ $totalMenuItems }} item
                    </span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Menu Content -->
    <section class="py-14 lg:py-16 bg-cream">
        <div class="max-w-7xl mx-auto px-6">
            @if($menusByCategory->count() > 0)
                <div id="menuSectionsWrapper">
                    @foreach($menusByCategory as $kategori => $menus)
                    <div id="{{ Str::slug($kategori) }}"
                         data-category-section="{{ Str::slug($kategori) }}"
                         class="mb-16 last:mb-0 scroll-mt-40">
                        <!-- Category Header -->
                        <div class="flex flex-wrap items-center justify-between gap-3 mb-7 pb-3 border-b border-latte">
                            <div class="flex items-center gap-3.5">
                                <span class="w-1.5 h-8 rounded-full bg-gradient-to-b from-caramel to-gold"></span>
                                <h2 class="font-serif text-3xl sm:text-4xl text-espresso font-bold">{{ $kategori }}</h2>
                            </div>
                            <span class="px-3.5 py-1 rounded-full bg-white border border-latte text-xs font-semibold text-brown font-mono-num">
                                <span class="category-count">{{ $menus->count() }}</span> menu
                            </span>
                        </div>

                        <!-- Menu Grid -->
                        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach($menus as $menu)
                            <div data-menu-card
                                 data-category="{{ Str::slug($kategori) }}"
                                 data-name="{{ strtolower($menu->nama) }}"
                                 class="group bg-white border border-latte rounded-2xl overflow-hidden shadow-xs hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col h-full">
                                <!-- Image Container -->
                                <div class="relative h-52 overflow-hidden bg-latte/50 shrink-0">
                                    @if($menu->foto)
                                        <img src="{{ Storage::url($menu->foto) }}"
                                             alt="{{ $menu->nama }}"
                                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        <div class="hidden w-full h-full flex items-center justify-center bg-gradient-to-br from-latte to-amber-100 text-brown">
                                            <i class="fas fa-mug-hot text-5xl opacity-50"></i>
                                        </div>
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-latte to-amber-100 text-brown">
                                            <i class="fas fa-mug-hot text-5xl opacity-50"></i>
                                        </div>
                                    @endif

                                    <!-- Status Badge -->
                                    @if($menu->status === 'tidak tersedia')
                                        <span class="absolute top-3 right-3 px-3 py-1 rounded-full bg-rose-600/95 text-white text-xs font-semibold shadow-sm inline-flex items-center gap-1">
                                            <i class="fas fa-times-circle"></i> Habis
                                        </span>
                                    @else
                                        <span class="absolute top-3 right-3 px-2.5 py-1 rounded-full bg-emerald-600/90 text-white text-[11px] font-semibold shadow-xs inline-flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-white"></span> Tersedia
                                        </span>
                                    @endif
                                </div>

                                <!-- Content Container -->
                                <div class="p-5 flex flex-col flex-grow">
                                    <div class="flex-grow">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-md bg-cream border border-latte text-[11px] font-semibold text-brown mb-2">
                                            <i class="fas fa-tag text-[10px] text-caramel"></i> {{ $menu->kategori }}
                                        </span>
                                        <h3 class="font-serif text-xl text-espresso font-bold mb-2 line-clamp-2">{{ $menu->nama }}</h3>
                                    </div>

                                    <div class="pt-3 mt-2 border-t border-latte/70">
                                        <div class="flex items-center justify-between mb-3.5">
                                            <span class="text-xs text-stone-500">Harga</span>
                                            <span class="font-mono-num text-xl text-brown font-bold">
                                                Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                            </span>
                                        </div>

                                        @if($menu->status === 'tersedia')
                                            <button type="button"
                                                    onclick="openOrderInfoModal(this)"
                                                    data-menu-name="{{ $menu->nama }}"
                                                    data-menu-category="{{ $menu->kategori }}"
                                                    data-menu-price="Rp {{ number_format($menu->harga, 0, ',', '.') }}"
                                                    class="w-full btn-gold py-2.5 px-4 rounded-full text-sm font-bold inline-flex items-center justify-center gap-2">
                                                <i class="fas fa-shopping-bag text-xs"></i>
                                                <span>Pesan di Kasir</span>
                                            </button>
                                        @else
                                            <button type="button" disabled
                                                    class="w-full bg-stone-200 text-stone-500 py-2.5 px-4 rounded-full text-sm font-semibold cursor-not-allowed inline-flex items-center justify-center gap-2">
                                                <i class="fas fa-ban text-xs"></i>
                                                <span>Stok Habis</span>
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Filtered Empty State -->
                <div id="menuFilterEmpty" class="hidden text-center py-16 bg-white border border-latte rounded-3xl">
                    <div class="w-16 h-16 rounded-2xl bg-cream border border-latte text-caramel flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-search text-2xl"></i>
                    </div>
                    <h3 class="font-serif text-2xl text-espresso font-bold mb-2">Menu tidak ditemukan</h3>
                    <p class="text-stone-600 text-sm sm:text-base mb-6 max-w-md mx-auto">
                        Tidak ada menu yang cocok dengan kata kunci atau kategori yang dipilih.
                    </p>
                    <button type="button" id="resetMenuFilterBtn" class="btn-espresso px-6 py-2.5 rounded-full text-sm font-semibold">
                        <i class="fas fa-rotate-left mr-1.5"></i> Tampilkan Semua Menu
                    </button>
                </div>
            @else
                <!-- Database Empty State -->
                <div class="text-center py-20 bg-white border border-latte rounded-3xl">
                    <i class="fas fa-mug-hot text-6xl text-stone-300 mb-5"></i>
                    <h3 class="font-serif text-3xl text-espresso font-bold mb-3">Menu Belum Tersedia</h3>
                    <p class="text-stone-500 text-base">Kami sedang memperbarui daftar menu. Silakan kembali beberapa saat lagi!</p>
                </div>
            @endif
        </div>
    </section>

    <!-- How to Order Section -->
    <section class="py-20 bg-white border-t border-latte">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-3">Cara Pemesanan</span>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-espresso font-bold mb-3">
                    Langkah Mudah Menikmati Sajian
                </h2>
                <p class="text-stone-600 text-base sm:text-lg">
                    Proses pemesanan cepat langsung di meja kasir kedai kami.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                <div class="bg-cream/60 border border-latte rounded-2xl p-6 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-gradient-to-br from-brown to-roast rounded-2xl flex items-center justify-center text-gold text-xl font-bold font-mono-num shadow-sm">
                        1
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Pilih Menu</h3>
                    <p class="text-stone-600 text-sm">Jelajahi kategori minuman dan makanan favorit Anda di halaman ini.</p>
                </div>

                <div class="bg-cream/60 border border-latte rounded-2xl p-6 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-gradient-to-br from-brown to-roast rounded-2xl flex items-center justify-center text-gold text-xl font-bold font-mono-num shadow-sm">
                        2
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Datang ke Kedai</h3>
                    <p class="text-stone-600 text-sm">Kunjungi kedai Kopi Paste di Jl. Kopi No. 123, Medan dan pilih meja nyaman Anda.</p>
                </div>

                <div class="bg-cream/60 border border-latte rounded-2xl p-6 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-gradient-to-br from-brown to-roast rounded-2xl flex items-center justify-center text-gold text-xl font-bold font-mono-num shadow-sm">
                        3
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Pesan di Kasir</h3>
                    <p class="text-stone-600 text-sm">Sebutkan pesanan Anda kepada kasir dan pilih metode pembayaran yang tersedia.</p>
                </div>

                <div class="bg-cream/60 border border-latte rounded-2xl p-6 text-center">
                    <div class="w-14 h-14 mx-auto mb-4 bg-gradient-to-br from-brown to-roast rounded-2xl flex items-center justify-center text-gold text-xl font-bold font-mono-num shadow-sm">
                        4
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Nikmati Sajian</h3>
                    <p class="text-stone-600 text-sm">Duduk santai sementara barista kami menyiapkan pesanan segar Anda.</p>
                </div>
            </div>

            <div class="max-w-2xl mx-auto bg-gradient-to-r from-amber-50 to-cream border border-gold/40 rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-start gap-4 text-left">
                    <span class="w-12 h-12 rounded-xl bg-espresso text-gold flex items-center justify-center shrink-0">
                        <i class="fas fa-store text-lg"></i>
                    </span>
                    <div>
                        <p class="font-serif text-lg font-bold text-espresso">Kunjungi Kedai Kami</p>
                        <p class="text-sm text-stone-600 mt-0.5">Jl. Kopi No. 123, Medan &bull; Buka 08:00 – 22:00 WIB</p>
                        <p class="text-sm text-brown font-mono-num font-semibold mt-1">Telp: 0812-3456-7890</p>
                    </div>
                </div>
                <a href="{{ route('about') }}#contact" class="btn-gold px-6 py-3 rounded-full text-sm font-bold shrink-0">
                    Lihat Lokasi &amp; Info
                </a>
            </div>
        </div>
    </section>

    <!-- Order Info Modal -->
    <div id="orderInfoModal"
         class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-espresso/70 backdrop-blur-xs"
         role="dialog"
         aria-modal="true"
         aria-labelledby="modalMenuTitle">
        <div class="bg-white border border-latte rounded-3xl max-w-md w-full overflow-hidden shadow-2xl transform transition-all" onclick="event.stopPropagation()">
            <div class="bg-gradient-to-r from-espresso to-roast px-6 py-5 text-white flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="w-10 h-10 rounded-xl bg-gold/15 border border-gold/30 text-gold flex items-center justify-center">
                        <i class="fas fa-mug-hot"></i>
                    </span>
                    <div>
                        <p class="text-xs text-gold uppercase tracking-wider font-semibold">Informasi Pemesanan</p>
                        <h3 id="modalMenuTitle" class="font-serif text-xl font-bold">Menu Pilihan</h3>
                    </div>
                </div>
                <button type="button" onclick="closeOrderInfoModal()" class="text-white/70 hover:text-white p-1.5 rounded-lg transition" aria-label="Tutup modal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <div class="p-6">
                <div class="bg-cream border border-latte rounded-2xl p-4 mb-5 flex items-center justify-between gap-3">
                    <div>
                        <span id="modalMenuCategory" class="text-xs font-semibold text-caramel uppercase tracking-wide">Kategori</span>
                        <p id="modalMenuName" class="font-serif text-lg font-bold text-espresso">Nama Menu</p>
                    </div>
                    <span id="modalMenuPrice" class="font-mono-num text-lg font-bold text-brown shrink-0">Rp 0</span>
                </div>

                <p class="text-sm text-stone-600 leading-relaxed mb-5">
                    Pemesanan dilakukan langsung di meja kasir kami agar kopi diseduh segar saat Anda tiba atau memesan di tempat (Dine-In / Take Away).
                </p>

                <div class="space-y-2.5 text-sm text-stone-700 bg-stone-50 border border-stone-200/80 rounded-2xl p-4 mb-6">
                    <div class="flex items-start gap-2.5">
                        <i class="fas fa-map-marker-alt text-caramel mt-1"></i>
                        <span>Jl. Kopi No. 123, Medan, Sumatera Utara</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="fas fa-clock text-caramel"></i>
                        <span>Senin – Jumat: 08:00 – 22:00 | Akhir Pekan: 09:00 – 23:00</span>
                    </div>
                    <div class="flex items-center gap-2.5">
                        <i class="fas fa-phone text-caramel"></i>
                        <span class="font-mono-num font-semibold">0812-3456-7890</span>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('about') }}#contact" class="btn-gold flex-1 py-3 px-4 rounded-xl text-center text-sm font-bold">
                        <i class="fas fa-directions mr-1.5"></i> Lihat Kontak &amp; Lokasi
                    </a>
                    <button type="button" onclick="closeOrderInfoModal()" class="px-5 py-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    (function () {
        let activeCategory = 'all';
        const searchInput = document.getElementById('menuSearch');
        const clearSearchBtn = document.getElementById('clearMenuSearch');
        const counterEl = document.getElementById('visibleMenuCounter');
        const emptyState = document.getElementById('menuFilterEmpty');
        const resetBtn = document.getElementById('resetMenuFilterBtn');
        const categoryBtns = document.querySelectorAll('[data-category-btn]');
        const categorySections = document.querySelectorAll('[data-category-section]');

        function applyFilters() {
            const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
            if (clearSearchBtn) {
                clearSearchBtn.classList.toggle('hidden', query.length === 0);
            }

            let totalVisible = 0;

            categorySections.forEach(section => {
                const sectionCat = section.dataset.categorySection;
                const cards = section.querySelectorAll('[data-menu-card]');
                let sectionVisible = 0;

                cards.forEach(card => {
                    const cardCat = card.dataset.category;
                    const cardName = card.dataset.name || '';
                    const matchesCategory = activeCategory === 'all' || cardCat === activeCategory;
                    const matchesQuery = !query || cardName.includes(query);

                    const show = matchesCategory && matchesQuery;
                    card.classList.toggle('hidden', !show);
                    if (show) {
                        sectionVisible++;
                        totalVisible++;
                    }
                });

                const countBadge = section.querySelector('.category-count');
                if (countBadge) countBadge.textContent = sectionVisible;

                section.classList.toggle('hidden', sectionVisible === 0);
            });

            if (counterEl) {
                counterEl.textContent = totalVisible + ' item';
            }

            if (emptyState) {
                emptyState.classList.toggle('hidden', totalVisible > 0);
            }
        }

        function setCategory(cat) {
            activeCategory = cat;
            categoryBtns.forEach(btn => {
                const isSelected = btn.dataset.categoryBtn === cat;
                btn.classList.toggle('bg-espresso', isSelected);
                btn.classList.toggle('text-gold', isSelected);
                btn.classList.toggle('font-semibold', isSelected);
                btn.classList.toggle('shadow-xs', isSelected);

                btn.classList.toggle('bg-cream', !isSelected);
                btn.classList.toggle('text-espresso', !isSelected);
                btn.classList.toggle('border', !isSelected);
                btn.classList.toggle('border-latte', !isSelected);
                btn.classList.toggle('font-medium', !isSelected);
            });
            applyFilters();
        }

        categoryBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const cat = this.dataset.categoryBtn;
                setCategory(cat);
                if (cat !== 'all') {
                    const section = document.getElementById(cat);
                    if (section) {
                        const y = section.getBoundingClientRect().top + window.scrollY - 150;
                        window.scrollTo({ top: Math.max(0, y), behavior: 'smooth' });
                    }
                }
            });
        });

        if (searchInput) {
            searchInput.addEventListener('input', applyFilters);
        }

        if (clearSearchBtn && searchInput) {
            clearSearchBtn.addEventListener('click', function () {
                searchInput.value = '';
                applyFilters();
                searchInput.focus();
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function () {
                if (searchInput) searchInput.value = '';
                setCategory('all');
            });
        }
    })();

    function openOrderInfoModal(button) {
        const modal = document.getElementById('orderInfoModal');
        if (!modal || !button) return;

        document.getElementById('modalMenuName').textContent = button.dataset.menuName || 'Menu Pilihan';
        document.getElementById('modalMenuCategory').textContent = button.dataset.menuCategory || 'Menu';
        document.getElementById('modalMenuPrice').textContent = button.dataset.menuPrice || '';

        modal.classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeOrderInfoModal() {
        const modal = document.getElementById('orderInfoModal');
        if (!modal) return;
        modal.classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    (function () {
        const modal = document.getElementById('orderInfoModal');
        if (modal) {
            modal.addEventListener('click', closeOrderInfoModal);
        }
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeOrderInfoModal();
            }
        });
    })();
</script>
@endpush
