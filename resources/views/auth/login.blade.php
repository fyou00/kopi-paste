<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Staf - Kopi Paste</title>
    @include('partials.theme-head')
</head>
<body class="font-sans bg-cream text-espresso min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased relative overflow-x-hidden">
    <!-- Subtle Background Accent -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden -z-10">
        <div class="absolute -top-32 -right-32 w-96 h-96 rounded-full bg-gold/20 blur-3xl"></div>
        <div class="absolute -bottom-32 -left-32 w-96 h-96 rounded-full bg-caramel/15 blur-3xl"></div>
    </div>

    <div class="w-full max-w-4xl bg-white border border-latte rounded-3xl shadow-2xl overflow-hidden grid lg:grid-cols-12">
        <!-- Left Brand Panel -->
        <div class="hidden lg:flex lg:col-span-5 relative bg-espresso text-white p-10 flex-col justify-between overflow-hidden">
            <div class="absolute inset-0 opacity-30 pointer-events-none"
                 style="background-image: url('/images/coffee_hero.png'); background-size: cover; background-position: center;"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-espresso via-espresso/80 to-espresso/60 pointer-events-none"></div>

            <div class="relative z-10">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-8">
                    <span class="w-11 h-11 rounded-xl bg-gold/15 border border-gold/30 text-gold flex items-center justify-center">
                        <i class="fas fa-mug-hot text-lg"></i>
                    </span>
                    <span class="font-script text-3xl text-gold">Kopi Paste</span>
                </a>

                <span class="inline-block px-3 py-1 rounded-full bg-white/10 border border-white/15 text-gold text-xs font-semibold uppercase tracking-wider mb-4">
                    Portal Operasional
                </span>
                <h2 class="font-serif text-3xl font-bold leading-snug mb-3">
                    Kelola Pesanan &amp; Kedai dengan Lebih Cepat
                </h2>
                <p class="text-white/75 text-sm leading-relaxed">
                    Akses panel kasir untuk pencatatan pesanan POS real-time atau panel admin untuk pengelolaan menu, meja, dan laporan penjualan.
                </p>
            </div>

            <div class="relative z-10 space-y-3 pt-8 border-t border-white/15 text-xs text-white/80">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-bolt text-gold w-4"></i>
                    <span>Input pesanan cepat &amp; cetak struk instan</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-chart-line text-gold w-4"></i>
                    <span>Pantau transaksi &amp; performa menu harian</span>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="lg:col-span-7 p-6 sm:p-10">
            <!-- Mobile Brand Header -->
            <div class="flex items-center justify-between mb-6 lg:mb-8">
                <div class="flex items-center gap-2.5 lg:hidden">
                    <span class="w-9 h-9 rounded-xl bg-espresso text-gold flex items-center justify-center">
                        <i class="fas fa-mug-hot"></i>
                    </span>
                    <span class="font-script text-2xl text-brown font-bold">Kopi Paste</span>
                </div>
                <a href="{{ route('home') }}" class="text-xs sm:text-sm font-semibold text-brown hover:text-caramel transition inline-flex items-center gap-1.5 ml-auto">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Kembali ke Beranda</span>
                </a>
            </div>

            <div class="mb-7">
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-espresso mb-1.5">Masuk ke Akun Staf</h1>
                <p class="text-sm text-stone-500">Masukkan email dan password Anda untuk melanjutkan ke panel kerja.</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Session Status -->
                @if (session('status'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('status') }}</span>
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-espresso mb-1.5">
                        Email
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400">
                            <i class="fas fa-envelope text-sm"></i>
                        </span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition @error('email') border-rose-500 @enderror"
                            required
                            autofocus
                            placeholder="nama@kopipaste.com"
                        >
                    </div>
                    @error('email')
                        <p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-espresso mb-1.5">
                        Password
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400">
                            <i class="fas fa-lock text-sm"></i>
                        </span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            class="w-full pl-10 pr-11 py-3 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition @error('password') border-rose-500 @enderror"
                            required
                            placeholder="Masukkan password"
                        >
                        <button type="button"
                                onclick="togglePasswordVisibility('password', this)"
                                aria-label="Tampilkan password"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-espresso p-1.5 transition">
                            <i class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember" class="inline-flex items-center gap-2 cursor-pointer select-none text-sm text-stone-600">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="w-4 h-4 rounded border-stone-300 text-caramel focus:ring-caramel"
                        >
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full btn-espresso py-3.5 rounded-xl text-sm sm:text-base font-bold inline-flex items-center justify-center gap-2 mt-2"
                >
                    <i class="fas fa-sign-in-alt text-gold"></i>
                    <span>Masuk Sekarang</span>
                </button>
            </form>

            <!-- Demo Accounts Autofill -->
            <div class="mt-7 pt-6 border-t border-latte">
                <div class="flex items-center justify-between mb-3">
                    <p class="text-xs font-bold uppercase tracking-wider text-stone-500">Akses Cepat Akun Demo</p>
                    <span id="demoFillHint" class="hidden text-xs font-semibold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                        Kredensial terisi
                    </span>
                </div>
                <div class="grid sm:grid-cols-2 gap-3">
                    <button type="button"
                            onclick="fillDemoCredentials('admin@kopipaste.com', 'password')"
                            class="text-left p-3 rounded-xl bg-cream/70 hover:bg-amber-50 border border-latte hover:border-caramel transition group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-espresso inline-flex items-center gap-1.5">
                                <i class="fas fa-user-tie text-caramel"></i> Isi Akun Admin
                            </span>
                            <span class="text-[10px] font-semibold text-caramel group-hover:underline">Isi otomatis</span>
                        </div>
                        <p class="font-mono-num text-[11px] text-stone-600 truncate">admin@kopipaste.com</p>
                    </button>

                    <button type="button"
                            onclick="fillDemoCredentials('kasir@kopipaste.com', 'password')"
                            class="text-left p-3 rounded-xl bg-cream/70 hover:bg-amber-50 border border-latte hover:border-caramel transition group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs font-bold text-espresso inline-flex items-center gap-1.5">
                                <i class="fas fa-cash-register text-caramel"></i> Isi Akun Kasir
                            </span>
                            <span class="text-[10px] font-semibold text-caramel group-hover:underline">Isi otomatis</span>
                        </div>
                        <p class="font-mono-num text-[11px] text-stone-600 truncate">kasir@kopipaste.com</p>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn ? btn.querySelector('i') : null;
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            if (icon) {
                icon.classList.toggle('fa-eye', !isPassword);
                icon.classList.toggle('fa-eye-slash', isPassword);
            }
        }

        function fillDemoCredentials(email, password) {
            const emailInput = document.getElementById('email');
            const passInput = document.getElementById('password');
            const hint = document.getElementById('demoFillHint');
            if (emailInput) emailInput.value = email;
            if (passInput) passInput.value = password;
            if (hint) {
                hint.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>
