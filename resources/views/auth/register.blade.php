<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Staf - Kopi Paste</title>
    @include('partials.theme-head')
</head>
<body class="font-sans bg-cream text-espresso min-h-screen flex items-center justify-center p-4 sm:p-6 antialiased relative overflow-x-hidden">
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
                    Registrasi Staf
                </span>
                <h2 class="font-serif text-3xl font-bold leading-snug mb-3">
                    Bergabung ke Tim Operasional Kedai
                </h2>
                <p class="text-white/75 text-sm leading-relaxed">
                    Daftarkan akun kasir atau admin baru untuk membantu pencatatan transaksi dan pengelolaan operasional Kopi Paste.
                </p>
            </div>

            <div class="relative z-10 space-y-3 pt-8 border-t border-white/15 text-xs text-white/80">
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-shield-alt text-gold w-4"></i>
                    <span>Akses berbasis peran (Kasir &amp; Admin)</span>
                </div>
                <div class="flex items-center gap-2.5">
                    <i class="fas fa-coffee text-gold w-4"></i>
                    <span>Terintegrasi dengan seluruh daftar menu &amp; meja</span>
                </div>
            </div>
        </div>

        <!-- Right Form Panel -->
        <div class="lg:col-span-7 p-6 sm:p-10">
            <div class="flex items-center justify-between mb-6">
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

            <div class="mb-6">
                <h1 class="font-serif text-2xl sm:text-3xl font-bold text-espresso mb-1">Buat Akun Baru</h1>
                <p class="text-sm text-stone-500">Lengkapi data di bawah ini untuk mendaftarkan akun staf.</p>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-semibold text-espresso mb-1.5">
                        Nama Lengkap
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400">
                            <i class="fas fa-user text-sm"></i>
                        </span>
                        <input
                            id="name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition @error('name') border-rose-500 @enderror"
                            required
                            autofocus
                            placeholder="Masukkan nama lengkap"
                        >
                    </div>
                    @error('name')
                        <p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email & Role -->
                <div class="grid sm:grid-cols-2 gap-4">
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
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition @error('email') border-rose-500 @enderror"
                                required
                                placeholder="staf@kopipaste.com"
                            >
                        </div>
                        @error('email')
                            <p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="role" class="block text-sm font-semibold text-espresso mb-1.5">
                            Peran (Role)
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400">
                                <i class="fas fa-user-tag text-sm"></i>
                            </span>
                            <select
                                id="role"
                                name="role"
                                class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition"
                                required
                            >
                                <option value="cashier" {{ old('role') === 'cashier' ? 'selected' : '' }}>Kasir</option>
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Password -->
                <div class="grid sm:grid-cols-2 gap-4">
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
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition @error('password') border-rose-500 @enderror"
                                required
                                placeholder="Minimal 8 karakter"
                            >
                            <button type="button"
                                    onclick="togglePasswordVisibility('password', this)"
                                    aria-label="Tampilkan password"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-stone-400 hover:text-espresso p-1.5 transition">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-espresso mb-1.5">
                            Konfirmasi Password
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400">
                                <i class="fas fa-lock text-sm"></i>
                            </span>
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition"
                                required
                                placeholder="Ulangi password"
                            >
                            <button type="button"
                                    onclick="togglePasswordVisibility('password_confirmation', this)"
                                    aria-label="Tampilkan konfirmasi password"
                                    class="absolute right-2.5 top-1/2 -translate-y-1/2 text-stone-400 hover:text-espresso p-1.5 transition">
                                <i class="fas fa-eye text-xs"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <button
                    type="submit"
                    class="w-full btn-espresso py-3.5 rounded-xl text-sm sm:text-base font-bold inline-flex items-center justify-center gap-2 mt-2"
                >
                    <i class="fas fa-user-plus text-gold"></i>
                    <span>Daftar Akun</span>
                </button>

                <div class="text-center pt-3 border-t border-latte">
                    <p class="text-sm text-stone-600">
                        Sudah memiliki akun?
                        <a href="{{ route('login') }}" class="text-caramel hover:text-brown font-bold transition">Masuk di sini</a>
                    </p>
                </div>
            </form>
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
    </script>
</body>
</html>
