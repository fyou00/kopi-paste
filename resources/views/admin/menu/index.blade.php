@extends('layouts.admin')

@section('title', 'Kelola Menu - Kopi Paste')
@section('page-title', 'Kelola Menu')

@section('content')
    <!-- Filter & Action Toolbar -->
    <div class="bg-white border border-latte rounded-2xl p-4 sm:p-5 shadow-sm mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form action="{{ route('admin.menu.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
                <div class="relative flex-1 min-w-[200px] sm:max-w-xs">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama menu..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white">
                </div>

                <select name="kategori"
                        class="px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel"
                        onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('kategori') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>

                <select name="status"
                        class="px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel"
                        onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="tidak tersedia" {{ request('status') === 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                </select>

                <button type="submit" class="btn-espresso px-4 py-2.5 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                    <i class="fas fa-search text-xs text-gold"></i>
                    <span>Cari</span>
                </button>

                @if(request()->filled('search') || request()->filled('kategori') || request()->filled('status'))
                    <a href="{{ route('admin.menu.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold transition inline-flex items-center gap-1.5">
                        <i class="fas fa-rotate-left text-xs"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>

            <a href="{{ route('admin.menu.create') }}"
               class="btn-gold px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center justify-center gap-2 shrink-0">
                <i class="fas fa-plus"></i>
                <span>Tambah Menu</span>
            </a>
        </div>
    </div>

    <!-- Menu Table -->
    <div class="bg-white border border-latte rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-cream border-b border-latte text-stone-600 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-3.5 text-left">Foto</th>
                        <th class="px-5 py-3.5 text-left">Nama Menu</th>
                        <th class="px-5 py-3.5 text-left">Kategori</th>
                        <th class="px-5 py-3.5 text-right">Harga</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-latte/60">
                    @forelse($menus as $menu)
                    <tr class="hover:bg-cream/40 transition">
                        <td class="px-5 py-3.5">
                            @if($menu->foto)
                                <img src="{{ Storage::url($menu->foto) }}"
                                     alt="{{ $menu->nama }}"
                                     onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                     class="w-14 h-14 object-cover rounded-xl border border-latte">
                                <div class="hidden w-14 h-14 bg-cream border border-latte rounded-xl flex items-center justify-center text-stone-400">
                                    <i class="fas fa-mug-hot"></i>
                                </div>
                            @else
                                <div class="w-14 h-14 bg-cream border border-latte rounded-xl flex items-center justify-center text-stone-400">
                                    <i class="fas fa-mug-hot"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 font-bold text-espresso">{{ $menu->nama }}</td>
                        <td class="px-5 py-3.5">
                            <span class="px-3 py-1 rounded-full bg-cream border border-latte text-xs font-semibold text-brown">
                                {{ $menu->kategori }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right font-mono-num font-bold text-caramel whitespace-nowrap">
                            Rp {{ number_format($menu->harga, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-3.5 text-center whitespace-nowrap">
                            @if($menu->status === 'tersedia')
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span> Tersedia
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-600"></span> Habis
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('admin.menu.edit', $menu) }}"
                                   class="px-3 py-1.5 rounded-lg bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white border border-sky-200 hover:border-sky-600 text-xs font-semibold transition inline-flex items-center gap-1.5">
                                    <i class="fas fa-edit"></i>
                                    <span>Edit</span>
                                </a>
                                <button type="button"
                                        onclick="openDeleteMenuModal(this)"
                                        data-action="{{ route('admin.menu.destroy', $menu) }}"
                                        data-name="{{ $menu->nama }}"
                                        class="px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 hover:border-rose-600 text-xs font-semibold transition inline-flex items-center gap-1.5">
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-14 text-center text-stone-500">
                            <i class="fas fa-mug-saucer text-5xl text-stone-300 mb-3 block"></i>
                            <p class="font-serif text-lg font-bold text-espresso">Tidak ada data menu</p>
                            <p class="text-xs text-stone-400 mt-1">Tambahkan menu baru atau ubah filter pencarian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $menus->links() }}
    </div>

    <!-- Delete Menu Confirmation Modal -->
    <div id="deleteMenuModal"
         class="hidden fixed inset-0 bg-espresso/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         role="dialog"
         aria-modal="true">
        <div class="bg-white border border-latte rounded-3xl max-w-sm w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash-alt text-xl"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-espresso text-center mb-2">Hapus Menu?</h3>
            <p class="text-sm text-stone-600 text-center mb-6">
                Menu <strong id="deleteMenuName" class="text-espresso">ini</strong> akan dihapus dari daftar menu kedai.
            </p>
            <form id="deleteMenuForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteMenuModal()" class="flex-1 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold transition">
                    Ya, Hapus
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function openDeleteMenuModal(trigger) {
        document.getElementById('deleteMenuForm').action = trigger.dataset.action;
        document.getElementById('deleteMenuName').textContent = trigger.dataset.name || 'ini';
        document.getElementById('deleteMenuModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteMenuModal() {
        document.getElementById('deleteMenuModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    (function () {
        const modal = document.getElementById('deleteMenuModal');
        if (modal) modal.addEventListener('click', closeDeleteMenuModal);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDeleteMenuModal();
        });
    })();
</script>
@endpush
