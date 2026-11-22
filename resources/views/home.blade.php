@extends('layouts.app')

@section('title', 'Kopi Paste - Seduhan Hangat Mengawali Harimu')

@push('styles')
<style>
    .hero-bg {
        background-image:
            linear-gradient(95deg, rgba(20, 12, 8, 0.92) 0%, rgba(20, 12, 8, 0.68) 48%, rgba(20, 12, 8, 0.22) 100%),
            url('/images/coffee_hero.png');
        background-size: cover;
        background-position: center;
    }

    @media (max-width: 767px) {
        .hero-bg {
            background-image:
                linear-gradient(180deg, rgba(20, 12, 8, 0.85) 0%, rgba(20, 12, 8, 0.72) 55%, rgba(20, 12, 8, 0.88) 100%),
                url('/images/coffee_hero.png');
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section id="home" class="hero-bg min-h-screen flex items-center pt-24 pb-16">
        <div class="max-w-7xl mx-auto px-6 w-full">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs sm:text-sm font-semibold tracking-wide mb-6">
                    <span class="w-2 h-2 rounded-full bg-gold animate-pulse"></span>
                    <span>Specialty Roastery &bull; Medan</span>
                </div>

                <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl xl:text-7xl text-white font-bold leading-[1.1] mb-6">
                    Seduhan Terbaik untuk <span class="text-gold">Mengawali Harimu</span>
                </h1>

                <p class="text-white/85 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                    Nikmati cita rasa kopi Nusantara yang disangrai segar setiap minggu. Dari espresso klasik hingga kopi susu gula aren favorit, kami sajikan penuh kehangatan di setiap cangkir.
                </p>

                <div class="flex flex-wrap items-center gap-4 mb-12">
                    <a href="{{ route('menu.public') }}" class="btn-gold px-8 py-4 rounded-full text-base font-bold inline-flex items-center gap-2.5">
                        <i class="fas fa-mug-hot"></i>
                        <span>Jelajahi Menu</span>
                    </a>
                    <a href="{{ route('about') }}" class="px-8 py-4 rounded-full text-base font-semibold text-white border border-white/30 hover:border-gold hover:text-gold hover:bg-white/5 transition inline-flex items-center gap-2">
                        <span>Cerita Kami</span>
                        <i class="fas fa-arrow-right text-sm"></i>
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-8 pt-8 border-t border-white/15 max-w-lg">
                    <div>
                        <p class="font-serif text-xl sm:text-2xl font-bold text-gold">100%</p>
                        <p class="text-xs sm:text-sm text-white/75 mt-0.5">Arabika &amp; Robusta Pilihan</p>
                    </div>
                    <div>
                        <p class="font-serif text-xl sm:text-2xl font-bold text-gold">40+</p>
                        <p class="text-xs sm:text-sm text-white/75 mt-0.5">Varian Menu Segar</p>
                    </div>
                    <div>
                        <p class="font-serif text-xl sm:text-2xl font-bold text-gold">08–23</p>
                        <p class="text-xs sm:text-sm text-white/75 mt-0.5">Buka Setiap Hari</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Story Section -->
    <section id="about" class="py-20 lg:py-24 bg-cream">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-12 gap-12 items-center">
                <div class="md:col-span-6 lg:col-span-6">
                    <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-3">Tentang Kopi Paste</span>
                    <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-espresso font-bold leading-tight mb-6">
                        Temukan Kenikmatan Kopi Asli di Setiap Tegukan
                    </h2>
                    <p class="text-stone-700 text-base sm:text-lg leading-relaxed mb-6">
                        Kopi Paste hadir sebagai ruang singgah yang memadukan kualitas seduhan barista dengan suasana hangat untuk bekerja, berdiskusi, atau sekadar melepas penat. Setiap biji kami pilih dengan teliti demi menjaga karakter aroma dan rasa yang konsisten.
                    </p>

                    <div class="flex flex-wrap gap-2.5 mb-8">
                        <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-white border border-latte text-sm font-medium text-espresso shadow-xs">
                            <i class="fas fa-fire text-caramel"></i> Roasting Segar
                        </span>
                        <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-white border border-latte text-sm font-medium text-espresso shadow-xs">
                            <i class="fas fa-user-check text-caramel"></i> Barista Berpengalaman
                        </span>
                        <span class="inline-flex items-center gap-2 px-3.5 py-2 rounded-full bg-white border border-latte text-sm font-medium text-espresso shadow-xs">
                            <i class="fas fa-wifi text-caramel"></i> Ruang Nyaman &amp; Wi-Fi
                        </span>
                    </div>

                    <a href="{{ route('about') }}" class="btn-espresso px-7 py-3.5 rounded-full text-sm font-semibold inline-flex items-center gap-2">
                        <span>Kenali Kami Lebih Dekat</span>
                        <i class="fas fa-arrow-right text-xs text-gold"></i>
                    </a>
                </div>

                <div class="md:col-span-6 lg:col-span-6 flex justify-center">
                    <div class="relative w-full max-w-md rounded-3xl bg-gradient-to-br from-latte/70 to-white border border-latte p-8 sm:p-10 shadow-sm">
                        <div class="absolute -top-4 -right-4 w-20 h-20 rounded-2xl bg-gold/25 -z-10"></div>
                        <div class="absolute -bottom-4 -left-4 w-24 h-24 rounded-full bg-caramel/15 -z-10"></div>
                        <img src="/images/cup_coffee_beans.png"
                             alt="Biji Kopi Pilihan Kopi Paste"
                             class="w-full h-auto object-contain mix-blend-multiply mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Menu Section -->
    <section id="menu" class="py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                <div class="max-w-2xl">
                    <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-3">Menu Pilihan</span>
                    <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-espresso font-bold mb-3">
                        Sajian Favorit Hari Ini
                    </h2>
                    <p class="text-stone-600 text-base sm:text-lg">
                        Jelajahi racikan kopi klasik, minuman non-kopi, hingga sajian pendamping favorit pelanggan kami.
                    </p>
                </div>
                <a href="{{ route('menu.public') }}" class="btn-gold px-6 py-3 rounded-full text-sm font-bold inline-flex items-center gap-2 self-start md:self-auto shrink-0">
                    <span>Lihat Semua Menu</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>

            @if(isset($featuredMenus) && $featuredMenus->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-7">
                    @foreach($featuredMenus->take(4) as $menu)
                        <div class="card-hover bg-cream/60 border border-latte rounded-2xl overflow-hidden flex flex-col">
                            <div class="relative aspect-[4/3] bg-latte/60 overflow-hidden">
                                @if($menu->foto)
                                    <img src="{{ Storage::url($menu->foto) }}"
                                         alt="{{ $menu->nama }}"
                                         onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                         class="w-full h-full object-cover">
                                    <div class="hidden w-full h-full flex items-center justify-center bg-gradient-to-br from-latte to-amber-100 text-brown">
                                        <i class="fas fa-mug-hot text-4xl opacity-60"></i>
                                    </div>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-latte to-amber-100 text-brown">
                                        <i class="fas fa-mug-hot text-4xl opacity-60"></i>
                                    </div>
                                @endif
                                <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-espresso/85 text-gold text-xs font-semibold backdrop-blur-xs">
                                    {{ $menu->kategori }}
                                </span>
                            </div>

                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-serif text-xl text-espresso font-bold mb-1 line-clamp-1">{{ $menu->nama }}</h3>
                                <p class="text-xs text-stone-500 mb-4">Tersedia untuk Dine-In &amp; Take Away</p>

                                <div class="mt-auto flex items-center justify-between gap-3 pt-3 border-t border-latte">
                                    <span class="font-mono-num text-lg font-bold text-brown">
                                        Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('menu.public') }}#{{ Str::slug($menu->kategori) }}"
                                       class="px-4 py-2 rounded-full bg-espresso text-gold hover:bg-brown text-xs font-semibold transition inline-flex items-center gap-1.5">
                                        <span>Detail</span>
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                @php
                    $fallbackMenus = [
                        ['nama' => 'Cappuccino', 'kategori' => 'Kopi', 'desc' => 'Espresso seimbang dengan susu lembut dan foam creamy.', 'harga' => 18000, 'img' => '/images/cappucino.png'],
                        ['nama' => 'Kopi Susu Gula Aren', 'kategori' => 'Kopi', 'desc' => 'Perpaduan signature espresso, susu segar, dan gula aren murni.', 'harga' => 16000, 'img' => '/images/kopi-susu-gula-aren.png'],
                        ['nama' => 'Cafe Latte', 'kategori' => 'Kopi', 'desc' => 'Shot espresso halus dipadukan dengan steamed milk silky.', 'harga' => 18000, 'img' => '/images/cafe-latte.png'],
                        ['nama' => 'Espresso', 'kategori' => 'Kopi', 'desc' => 'Ekstraksi murni biji Arabika pilihan dengan crema tebal.', 'harga' => 12000, 'img' => '/images/espresso.png'],
                    ];
                @endphp
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-7">
                    @foreach($fallbackMenus as $item)
                        <div class="card-hover bg-cream/60 border border-latte rounded-2xl overflow-hidden flex flex-col">
                            <div class="relative aspect-[4/3] bg-latte/60 overflow-hidden">
                                <img src="{{ $item['img'] }}" alt="{{ $item['nama'] }}" class="w-full h-full object-cover">
                                <span class="absolute top-3 left-3 px-3 py-1 rounded-full bg-espresso/85 text-gold text-xs font-semibold">
                                    {{ $item['kategori'] }}
                                </span>
                            </div>
                            <div class="p-5 flex flex-col flex-grow">
                                <h3 class="font-serif text-xl text-espresso font-bold mb-1.5">{{ $item['nama'] }}</h3>
                                <p class="text-xs text-stone-600 leading-relaxed mb-4">{{ $item['desc'] }}</p>
                                <div class="mt-auto flex items-center justify-between gap-3 pt-3 border-t border-latte">
                                    <span class="font-mono-num text-lg font-bold text-brown">
                                        Rp {{ number_format($item['harga'], 0, ',', '.') }}
                                    </span>
                                    <a href="{{ route('menu.public') }}"
                                       class="px-4 py-2 rounded-full bg-espresso text-gold hover:bg-brown text-xs font-semibold transition inline-flex items-center gap-1.5">
                                        <span>Lihat Menu</span>
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 lg:py-24 bg-cream">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-3">Keunggulan Kami</span>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-espresso font-bold mb-4">
                    Mengapa Memilih Kopi Paste?
                </h2>
                <p class="text-stone-600 text-base sm:text-lg">
                    Kami tidak sekadar menyeduh kopi, kami merancang pengalaman hangat untuk menemani aktivitas Anda.
                </p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-14">
                <div class="bg-white border border-latte p-7 rounded-2xl text-center card-hover">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-50 border border-amber-200/70 text-brown flex items-center justify-center">
                        <i class="fas fa-seedling text-2xl"></i>
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Biji Kopi Pilihan</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">Dipilih langsung dari petani lokal terbaik dengan profil sangrai terjaga.</p>
                </div>

                <div class="bg-white border border-latte p-7 rounded-2xl text-center card-hover">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-50 border border-amber-200/70 text-brown flex items-center justify-center">
                        <i class="fas fa-award text-2xl"></i>
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Racikan Presisi</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">Diseduh dengan takaran dan suhu ideal agar rasa konsisten di setiap gelas.</p>
                </div>

                <div class="bg-white border border-latte p-7 rounded-2xl text-center card-hover">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-50 border border-amber-200/70 text-brown flex items-center justify-center">
                        <i class="fas fa-couch text-2xl"></i>
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Suasana Hangat</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">Area duduk nyaman untuk WFC, meeting santai, maupun berkumpul bersama teman.</p>
                </div>

                <div class="bg-white border border-latte p-7 rounded-2xl text-center card-hover">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-2xl bg-amber-50 border border-amber-200/70 text-brown flex items-center justify-center">
                        <i class="fas fa-tags text-2xl"></i>
                    </div>
                    <h3 class="font-serif text-xl text-espresso font-bold mb-2">Harga Bersahabat</h3>
                    <p class="text-stone-600 text-sm leading-relaxed">Kualitas specialty coffee dengan harga ramah untuk dinikmati setiap hari.</p>
                </div>
            </div>

            <div class="text-center">
                <p class="text-stone-600 text-base sm:text-lg mb-2">Ide terbaik sering lahir dari secangkir kopi yang tepat.</p>
                <h3 class="font-serif text-2xl sm:text-3xl text-espresso font-bold mb-6">Mulai momen Anda hari ini.</h3>
                <a href="{{ route('menu.public') }}" class="btn-gold px-8 py-3.5 rounded-full text-base font-bold inline-flex items-center gap-2">
                    <span>Pilih Menu Favoritmu</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Signature CTA Banner -->
    <section class="relative py-20 lg:py-24 bg-gradient-to-br from-espresso via-roast to-brown overflow-hidden">
        <div class="absolute inset-0 opacity-15 pointer-events-none"
             style="background-image: url('/images/coffee_hero.png'); background-size: cover; background-position: center;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6">
            <div class="grid md:grid-cols-12 gap-10 items-center">
                <div class="md:col-span-7 text-white">
                    <span class="inline-block px-3.5 py-1 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs font-semibold uppercase tracking-wider mb-5">
                        Freshly Brewed Daily
                    </span>
                    <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-5">
                        Rasakan Pagi yang Lebih Bertenaga Bersama Kopi Paste
                    </h2>
                    <p class="text-white/80 text-base sm:text-lg leading-relaxed mb-8 max-w-xl">
                        Singgah sejenak ke kedai kami di Jl. Kopi No. 123, Medan atau cek daftar menu lengkap kami sebelum memesan langsung di meja kasir.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('menu.public') }}" class="btn-gold px-8 py-4 rounded-full text-base font-bold inline-flex items-center gap-2">
                            <i class="fas fa-mug-hot"></i>
                            <span>Pesan Sekarang</span>
                        </a>
                        <a href="{{ route('about') }}#contact" class="px-7 py-4 rounded-full text-base font-semibold text-white border border-white/25 hover:border-gold hover:text-gold transition inline-flex items-center gap-2">
                            <i class="fas fa-map-marker-alt text-gold"></i>
                            <span>Lokasi Kedai</span>
                        </a>
                    </div>
                </div>

                <div class="md:col-span-5 flex justify-center">
                    <img src="/images/cup.png"
                         alt="Signature Take Away Cup Kopi Paste"
                         class="w-48 sm:w-56 md:w-64 lg:w-72 h-auto animate-float drop-shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Carousel Section -->
    <section class="py-20 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-3">Kata Pelanggan</span>
                <h2 class="font-serif text-3xl sm:text-4xl lg:text-5xl text-espresso font-bold mb-3">
                    Cerita Hangat dari Meja Kami
                </h2>
                <p class="text-stone-600 text-base sm:text-lg">
                    Pendapat tulus dari para penikmat kopi yang rutin berkunjung ke Kopi Paste.
                </p>
            </div>

            <div id="testimonialCarousel" class="max-w-3xl mx-auto relative">
                <div class="bg-cream border border-latte rounded-3xl p-8 sm:p-12 shadow-sm relative overflow-hidden">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center gap-1 text-gold text-sm">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <i class="fas fa-quote-right text-3xl text-gold/40"></i>
                    </div>

                    <div class="min-h-[160px] flex flex-col justify-between">
                        <p id="testimonialQuote" class="text-stone-700 text-base sm:text-xl leading-relaxed mb-8 transition-opacity duration-300">
                            &ldquo;Kopi Susu Gula Aren di sini punya keseimbangan rasa pahit dan manis yang pas banget. Tempatnya juga tenang untuk kerja dari pagi sampai sore.&rdquo;
                        </p>

                        <div class="flex items-center justify-between gap-4 pt-6 border-t border-latte">
                            <div class="flex items-center gap-4">
                                <div id="testimonialAvatar" class="w-12 h-12 rounded-full bg-espresso text-gold font-serif font-bold text-lg flex items-center justify-center shrink-0">
                                    RN
                                </div>
                                <div>
                                    <h4 id="testimonialName" class="font-serif text-lg sm:text-xl text-espresso font-bold">Raka Pratama</h4>
                                    <p id="testimonialRole" class="text-xs sm:text-sm text-stone-500">Product Designer &bull; Pelanggan Tetap</p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2">
                                <button type="button" id="prevTestimonial" aria-label="Testimoni sebelumnya"
                                        class="w-10 h-10 rounded-full bg-white border border-latte text-espresso hover:bg-gold hover:border-gold transition flex items-center justify-center">
                                    <i class="fas fa-arrow-left text-xs"></i>
                                </button>
                                <button type="button" id="nextTestimonial" aria-label="Testimoni berikutnya"
                                        class="w-10 h-10 rounded-full bg-white border border-latte text-espresso hover:bg-gold hover:border-gold transition flex items-center justify-center">
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dots -->
                <div class="flex justify-center items-center gap-2 mt-6" id="testimonialDots"></div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="relative py-20 bg-roast overflow-hidden border-t border-white/10">
        <div class="absolute inset-0 opacity-15 pointer-events-none"
             style="background-image: url('/images/coffee_hero.png'); background-size: cover; background-position: center;"></div>
        <div class="relative z-10 max-w-3xl mx-auto px-6 text-center">
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-gold mb-3">Info &amp; Promo</span>
            <h2 class="font-serif text-3xl sm:text-4xl text-white font-bold mb-3">
                Dapatkan Kabar Menu &amp; Promo Terbaru
            </h2>
            <p class="text-white/80 text-base sm:text-lg mb-8">
                Jangan lewatkan info racikan musiman, promo pagi, dan acara komunitas di Kopi Paste.
            </p>

            <form id="newsletterForm" class="flex flex-col sm:flex-row gap-3 max-w-xl mx-auto">
                <input type="email"
                       id="newsletterEmail"
                       placeholder="Masukkan alamat email Anda..."
                       aria-label="Alamat email untuk newsletter"
                       class="flex-1 px-6 py-4 rounded-full bg-white text-espresso placeholder:text-stone-400 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-gold"
                       required>
                <button type="submit" class="btn-gold px-8 py-4 rounded-full text-sm sm:text-base font-bold shrink-0">
                    Berlangganan
                </button>
            </form>
            <p id="newsletterFeedback" class="hidden mt-4 text-sm text-gold font-medium"></p>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function () {
        // Testimonial Carousel
        const testimonials = [
            {
                initials: 'RP',
                name: 'Raka Pratama',
                role: 'Product Designer • Pelanggan Tetap',
                quote: '“Kopi Susu Gula Aren di sini punya keseimbangan rasa pahit dan manis yang pas banget. Tempatnya juga tenang untuk kerja dari pagi sampai sore.”'
            },
            {
                initials: 'NA',
                name: 'Nadia Aulia',
                role: 'Content Strategist • Medan',
                quote: '“Croissant-nya renyah disajikan hangat bareng Cappuccino. Pelayanannya cepat dan ramah, jadi tempat favorit tim kami buat meeting mingguan.”'
            },
            {
                initials: 'DW',
                name: 'Dimas Wijaya',
                role: 'Software Engineer • WFC Regular',
                quote: '“Espresso dan Americano-nya konsisten setiap kali datang. Harganya bersahabat dengan kualitas biji kopi yang terasa segar.”'
            }
        ];

        let currentIndex = 0;
        let autoTimer = null;

        const quoteEl = document.getElementById('testimonialQuote');
        const avatarEl = document.getElementById('testimonialAvatar');
        const nameEl = document.getElementById('testimonialName');
        const roleEl = document.getElementById('testimonialRole');
        const dotsContainer = document.getElementById('testimonialDots');
        const carousel = document.getElementById('testimonialCarousel');

        function renderDots() {
            if (!dotsContainer) return;
            dotsContainer.innerHTML = '';
            testimonials.forEach((_, idx) => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.ariaLabel = 'Lihat testimoni ' + (idx + 1);
                btn.className = idx === currentIndex
                    ? 'w-7 h-2.5 rounded-full bg-caramel transition-all'
                    : 'w-2.5 h-2.5 rounded-full bg-latte hover:bg-gold transition-all';
                btn.addEventListener('click', () => {
                    currentIndex = idx;
                    renderSlide();
                });
                dotsContainer.appendChild(btn);
            });
        }

        function renderSlide() {
            const item = testimonials[currentIndex];
            if (!item || !quoteEl) return;
            quoteEl.textContent = item.quote;
            if (avatarEl) avatarEl.textContent = item.initials;
            if (nameEl) nameEl.textContent = item.name;
            if (roleEl) roleEl.textContent = item.role;
            renderDots();
        }

        function nextSlide() {
            currentIndex = (currentIndex + 1) % testimonials.length;
            renderSlide();
        }

        function prevSlide() {
            currentIndex = (currentIndex - 1 + testimonials.length) % testimonials.length;
            renderSlide();
        }

        const prevBtn = document.getElementById('prevTestimonial');
        const nextBtn = document.getElementById('nextTestimonial');
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);

        function startAuto() {
            stopAuto();
            autoTimer = setInterval(nextSlide, 6000);
        }

        function stopAuto() {
            if (autoTimer) {
                clearInterval(autoTimer);
                autoTimer = null;
            }
        }

        if (carousel) {
            carousel.addEventListener('mouseenter', stopAuto);
            carousel.addEventListener('mouseleave', startAuto);
        }

        renderSlide();
        startAuto();

        // Newsletter client-side feedback
        const newsletterForm = document.getElementById('newsletterForm');
        const newsletterEmail = document.getElementById('newsletterEmail');
        const newsletterFeedback = document.getElementById('newsletterFeedback');

        if (newsletterForm && newsletterEmail && newsletterFeedback) {
            newsletterForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const emailVal = newsletterEmail.value.trim();
                if (!emailVal) return;
                newsletterFeedback.textContent = 'Terima kasih! Email ' + emailVal + ' telah terdaftar untuk kabar & promo Kopi Paste.';
                newsletterFeedback.classList.remove('hidden');
                newsletterForm.reset();
            });
        }
    })();
</script>
@endpush
