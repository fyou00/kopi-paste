@extends('layouts.app')

@section('title', 'Tentang Kami - Kopi Paste')

@section('content')
    <!-- Editorial Hero -->
    <section class="relative pt-32 pb-20 bg-gradient-to-br from-espresso via-roast to-brown text-white overflow-hidden">
        <div class="absolute inset-0 opacity-20 pointer-events-none"
             style="background-image: url('/images/coffee_hero.png'); background-size: cover; background-position: center;"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 text-center">
            <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs sm:text-sm font-semibold mb-5">
                <i class="fas fa-heart"></i>
                <span>Cerita &amp; Filosofi Kami</span>
            </span>
            <h1 class="font-serif text-4xl sm:text-5xl lg:text-6xl font-bold mb-4">
                Tentang Kopi Paste
            </h1>
            <p class="text-white/80 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed">
                Lebih dari sekadar kedai kopi — tempat di mana racikan kopi berkualitas, suasana hangat, dan obrolan penuh inspirasi bertemu setiap hari.
            </p>
        </div>
    </section>

    <!-- Brand Story Section -->
    <section class="py-16 lg:py-20 bg-cream">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white border border-latte rounded-3xl p-8 sm:p-12 shadow-xs mb-10">
                <div class="grid md:grid-cols-12 gap-10 items-center">
                    <div class="md:col-span-7">
                        <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-3">Cerita Kami</span>
                        <h2 class="font-serif text-3xl sm:text-4xl text-espresso font-bold mb-5">
                            Lahir dari Kecintaan pada Kopi &amp; Kebersamaan
                        </h2>
                        <p class="text-stone-700 text-base sm:text-lg leading-relaxed mb-4">
                            Kopi Paste didirikan dengan misi sederhana: menyajikan kopi berkualitas tinggi dengan suasana yang nyaman, hangat, dan pelayanan yang ramah. Kami percaya bahwa setiap cangkir kopi memiliki cerita unik yang layak dinikmati tanpa terburu-buru.
                        </p>
                        <p class="text-stone-700 text-base sm:text-lg leading-relaxed mb-7">
                            Dengan memilih biji kopi Nusantara terbaik serta teknik penyeduhan yang presisi, kami berkomitmen menghadirkan pengalaman ngopi yang konsisten — baik untuk memulai pagi, fokus bekerja, maupun bersantai bersama orang terdekat.
                        </p>

                        <div class="grid sm:grid-cols-3 gap-4">
                            <div class="bg-cream border border-latte rounded-2xl p-4">
                                <i class="fas fa-seedling text-caramel text-lg mb-2"></i>
                                <p class="font-bold text-sm text-espresso">Biji Lokal &amp; Nusantara</p>
                                <p class="text-xs text-stone-500 mt-0.5">Kualitas sangrai terjaga</p>
                            </div>
                            <div class="bg-cream border border-latte rounded-2xl p-4">
                                <i class="fas fa-fire-burner text-caramel text-lg mb-2"></i>
                                <p class="font-bold text-sm text-espresso">Seduh Fresh by Order</p>
                                <p class="text-xs text-stone-500 mt-0.5">Aroma segar setiap cangkir</p>
                            </div>
                            <div class="bg-cream border border-latte rounded-2xl p-4">
                                <i class="fas fa-laptop-house text-caramel text-lg mb-2"></i>
                                <p class="font-bold text-sm text-espresso">Ruang Kerja &amp; Nongkrong</p>
                                <p class="text-xs text-stone-500 mt-0.5">Nyaman sepanjang hari</p>
                            </div>
                        </div>
                    </div>

                    <div class="md:col-span-5 flex justify-center">
                        <div class="w-full max-w-sm rounded-3xl bg-cream border border-latte p-8">
                            <img src="/images/cup_coffee_beans.png"
                                 alt="Biji Kopi Kopi Paste"
                                 class="w-full h-auto object-contain mix-blend-multiply mx-auto">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vision & Mission -->
            <div class="grid md:grid-cols-2 gap-8 mb-14">
                <div class="bg-white border border-latte rounded-3xl p-8 shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-espresso text-gold flex items-center justify-center mb-5">
                        <i class="fas fa-eye text-xl"></i>
                    </div>
                    <h3 class="font-serif text-2xl text-espresso font-bold mb-3">Visi Kami</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Menjadi kedai kopi pilihan utama di kota ini yang dikenal lewat kualitas racikan kopi terbaik, suasana ruang yang bersahabat, serta pelayanan yang selalu membuat pelanggan merasa pulang.
                    </p>
                </div>

                <div class="bg-white border border-latte rounded-3xl p-8 shadow-xs hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-caramel/15 border border-caramel/30 text-caramel flex items-center justify-center mb-5">
                        <i class="fas fa-bullseye text-xl"></i>
                    </div>
                    <h3 class="font-serif text-2xl text-espresso font-bold mb-3">Misi Kami</h3>
                    <p class="text-stone-600 leading-relaxed">
                        Menyajikan kopi dan hidangan berkualitas dengan harga bersahabat, menciptakan ruang yang mendukung kreativitas, serta membangun komunitas pecinta kopi yang hangat dan inklusif.
                    </p>
                </div>
            </div>

            <!-- Contact & Location Section -->
            <div id="contact" class="scroll-mt-24 bg-white border border-latte rounded-3xl p-8 sm:p-10 shadow-xs">
                <div class="grid lg:grid-cols-12 gap-10 items-stretch">
                    <div class="lg:col-span-7">
                        <span class="inline-block text-xs font-bold uppercase tracking-widest text-caramel mb-2">Kontak &amp; Lokasi</span>
                        <h2 class="font-serif text-3xl sm:text-4xl text-espresso font-bold mb-6">
                            Kunjungi Kedai Kami
                        </h2>

                        <div class="grid sm:grid-cols-2 gap-5 mb-8">
                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-cream/70 border border-latte">
                                <span class="w-11 h-11 rounded-xl bg-espresso text-gold flex items-center justify-center shrink-0">
                                    <i class="fas fa-map-marker-alt"></i>
                                </span>
                                <div>
                                    <h4 class="font-bold text-espresso text-sm mb-1">Alamat</h4>
                                    <p class="text-stone-600 text-sm leading-relaxed">Jl. Kopi No. 123, Medan, Sumatera Utara</p>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-cream/70 border border-latte">
                                <span class="w-11 h-11 rounded-xl bg-espresso text-gold flex items-center justify-center shrink-0">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <div>
                                    <h4 class="font-bold text-espresso text-sm mb-1">Telepon / WhatsApp</h4>
                                    <a href="tel:081234567890" class="font-mono-num text-sm text-brown font-semibold hover:text-caramel transition">
                                        0812-3456-7890
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-cream/70 border border-latte">
                                <span class="w-11 h-11 rounded-xl bg-espresso text-gold flex items-center justify-center shrink-0">
                                    <i class="fas fa-envelope"></i>
                                </span>
                                <div>
                                    <h4 class="font-bold text-espresso text-sm mb-1">Email</h4>
                                    <a href="mailto:info@kopipaste.com" class="text-sm text-brown font-semibold hover:text-caramel transition">
                                        info@kopipaste.com
                                    </a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4 p-4 rounded-2xl bg-cream/70 border border-latte">
                                <span class="w-11 h-11 rounded-xl bg-espresso text-gold flex items-center justify-center shrink-0">
                                    <i class="fas fa-clock"></i>
                                </span>
                                <div>
                                    <h4 class="font-bold text-espresso text-sm mb-1">Jam Buka</h4>
                                    <p class="text-stone-600 text-xs">Senin – Jumat: <span class="font-mono-num font-semibold text-espresso">08:00 – 22:00</span></p>
                                    <p class="text-stone-600 text-xs mt-0.5">Sabtu – Minggu: <span class="font-mono-num font-semibold text-espresso">09:00 – 23:00</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-latte flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h4 class="font-bold text-espresso text-sm mb-1">Ikuti Media Sosial Kami</h4>
                                <p class="text-xs text-stone-500">Update menu musiman dan promo harian</p>
                            </div>
                            <div class="flex items-center gap-3">
                                <a href="#instagram" aria-label="Instagram"
                                   class="w-10 h-10 rounded-full bg-cream border border-latte text-espresso hover:bg-espresso hover:text-gold flex items-center justify-center transition">
                                    <i class="fab fa-instagram"></i>
                                </a>
                                <a href="#facebook" aria-label="Facebook"
                                   class="w-10 h-10 rounded-full bg-cream border border-latte text-espresso hover:bg-espresso hover:text-gold flex items-center justify-center transition">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="#tiktok" aria-label="TikTok"
                                   class="w-10 h-10 rounded-full bg-cream border border-latte text-espresso hover:bg-espresso hover:text-gold flex items-center justify-center transition">
                                    <i class="fab fa-tiktok"></i>
                                </a>
                                <a href="https://wa.me/6281234567890" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"
                                   class="w-10 h-10 rounded-full bg-emerald-600 text-white hover:bg-emerald-700 flex items-center justify-center transition">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Highlight Location Card -->
                    <div class="lg:col-span-5">
                        <div class="h-full rounded-3xl bg-gradient-to-br from-espresso via-roast to-brown text-white p-8 flex flex-col justify-between relative overflow-hidden">
                            <div class="absolute -bottom-10 -right-10 w-44 h-44 rounded-full bg-gold/10 pointer-events-none"></div>

                            <div>
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gold/15 border border-gold/30 text-gold text-xs font-semibold mb-5">
                                    <i class="fas fa-location-dot"></i> Pusat Kota Medan
                                </span>
                                <h3 class="font-serif text-2xl sm:text-3xl font-bold mb-3">
                                    Suasana Nyaman untuk Setiap Aktivitas
                                </h3>
                                <p class="text-white/80 text-sm leading-relaxed mb-6">
                                    Berlokasi strategis dan mudah dijangkau, lengkap dengan area indoor ber-AC maupun semi-outdoor yang asri.
                                </p>

                                <div class="flex flex-wrap gap-2 mb-8">
                                    <span class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-medium">
                                        <i class="fas fa-wifi text-gold mr-1"></i> Wi-Fi Cepat
                                    </span>
                                    <span class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-medium">
                                        <i class="fas fa-plug text-gold mr-1"></i> Stop Kontak Tiap Meja
                                    </span>
                                    <span class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-medium">
                                        <i class="fas fa-parking text-gold mr-1"></i> Parkir Luas
                                    </span>
                                    <span class="px-3 py-1.5 rounded-full bg-white/10 border border-white/15 text-xs font-medium">
                                        <i class="fas fa-qrcode text-gold mr-1"></i> Pembayaran Cashless
                                    </span>
                                </div>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3">
                                <a href="{{ route('menu.public') }}" class="btn-gold flex-1 py-3 px-5 rounded-full text-center text-sm font-bold">
                                    <i class="fas fa-mug-hot mr-1.5"></i> Lihat Daftar Menu
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
