@extends('layouts.admin')

@section('title', 'Kelola Meja - Kopi Paste')
@section('page-title', 'Kelola Meja')

@section('content')
    @php
        $currentStatus = request('status');
        $okupansi = $totalTables > 0 ? round(($tableTerisi / $totalTables) * 100) : 0;
        $baseQuery = request()->except('page', 'status');
    @endphp

    <!-- Summary KPI Cards -->
    <div class="grid sm:grid-cols-3 gap-5 mb-6">
        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Total Meja</p>
                <p class="font-mono-num text-3xl font-bold text-espresso mt-1">{{ $totalTables }}</p>
                <p class="text-xs text-stone-500 mt-1">Tingkat okupansi: <strong class="font-mono-num text-caramel">{{ $okupansi }}%</strong></p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-cream border border-latte text-brown flex items-center justify-center">
                <i class="fas fa-border-all text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Meja Tersedia</p>
                <p class="font-mono-num text-3xl font-bold text-emerald-600 mt-1">{{ $tableTersedia }}</p>
                <p class="text-xs text-emerald-700 mt-1">Siap ditempati tamu</p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-emerald-50 border border-emerald-200/70 text-emerald-600 flex items-center justify-center">
                <i class="fas fa-check-circle text-xl"></i>
            </span>
        </div>

        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wider text-stone-500">Meja Terisi</p>
                <p class="font-mono-num text-3xl font-bold text-caramel mt-1">{{ $tableTerisi }}</p>
                <p class="text-xs text-amber-800 mt-1">Sedang digunakan</p>
            </div>
            <span class="w-12 h-12 rounded-2xl bg-amber-50 border border-amber-200/70 text-caramel flex items-center justify-center">
                <i class="fas fa-users text-xl"></i>
            </span>
        </div>
    </div>

    <!-- Filter & Action Toolbar -->
    <div class="bg-white border border-latte rounded-2xl p-4 sm:p-5 shadow-sm mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search by table number -->
                <form action="{{ route('admin.table.index') }}" method="GET" class="flex items-center gap-2">
                    @if($currentStatus)
                        <input type="hidden" name="status" value="{{ $currentStatus }}">
                    @endif
                    <div class="relative">
                        <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-xs"></i>
                        <input type="text"
                               name="search"
                               value="{{ request('search') }}"
                               placeholder="Cari nomor meja..."
                               class="pl-9 pr-3.5 py-2 rounded-xl border border-latte bg-cream/40 text-sm text-espresso w-44 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white">
                    </div>
                    <button type="submit" class="btn-espresso px-3.5 py-2 rounded-xl text-xs font-semibold">
                        Cari
                    </button>
                </form>

                <!-- Clickable Status Filter Pills -->
                <div class="flex flex-wrap items-center gap-1.5">
                    <a href="{{ route('admin.table.index', $baseQuery) }}"
                       class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ !$currentStatus ? 'bg-espresso text-gold' : 'bg-cream border border-latte text-stone-600 hover:border-caramel' }}">
                        Semua
                    </a>
                    <a href="{{ route('admin.table.index', array_merge($baseQuery, ['status' => 'tersedia'])) }}"
                       class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ $currentStatus === 'tersedia' ? 'bg-emerald-600 text-white' : 'bg-cream border border-latte text-stone-600 hover:border-emerald-500' }}">
                        Tersedia
                    </a>
                    <a href="{{ route('admin.table.index', array_merge($baseQuery, ['status' => 'terisi'])) }}"
                       class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ $currentStatus === 'terisi' ? 'bg-caramel text-white' : 'bg-cream border border-latte text-stone-600 hover:border-caramel' }}">
                        Terisi
                    </a>
                    <a href="{{ route('admin.table.index', array_merge($baseQuery, ['status' => 'reserved'])) }}"
                       class="px-3.5 py-2 rounded-xl text-xs font-semibold transition {{ $currentStatus === 'reserved' ? 'bg-sky-600 text-white' : 'bg-cream border border-latte text-stone-600 hover:border-sky-500' }}">
                        Reserved
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.table.create') }}"
               class="btn-gold px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center justify-center gap-2 shrink-0">
                <i class="fas fa-plus"></i>
                <span>Tambah Meja</span>
            </a>
        </div>
    </div>

    <!-- Floor-Plan Grid -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        @forelse($tables as $table)
        @php
            $topStrip = $table->status === 'tersedia' ? 'bg-emerald-500' : ($table->status === 'terisi' ? 'bg-caramel' : 'bg-sky-500');
            $badgeStyle = $table->status === 'tersedia' ? 'bg-emerald-100 text-emerald-800' : ($table->status === 'terisi' ? 'bg-amber-100 text-amber-800' : 'bg-sky-100 text-sky-800');
            $iconBg = $table->status === 'tersedia' ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : ($table->status === 'terisi' ? 'bg-amber-50 text-caramel border-amber-200' : 'bg-sky-50 text-sky-700 border-sky-200');
        @endphp
        <div class="bg-white border border-latte rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition flex flex-col">
            <div class="h-1.5 {{ $topStrip }}"></div>

            <div class="p-5 flex-1 flex flex-col">
                <div class="flex items-start justify-between gap-3 mb-5">
                    <div class="flex items-center gap-3">
                        <span class="w-12 h-12 rounded-2xl border flex items-center justify-center font-mono-num font-bold text-lg shrink-0 {{ $iconBg }}">
                            {{ $table->nomor }}
                        </span>
                        <div>
                            <h3 class="font-serif text-xl font-bold text-espresso">Meja {{ $table->nomor }}</h3>
                            <p class="text-xs text-stone-500 font-medium mt-0.5">
                                <i class="fas fa-users text-caramel mr-1"></i> {{ $table->kapasitas }} Kursi
                            </p>
                        </div>
                    </div>

                    <span class="px-2.5 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 {{ $badgeStyle }}">
                        @if($table->status === 'terisi')
                            <span class="w-1.5 h-1.5 rounded-full bg-amber-600 animate-pulse"></span>
                        @elseif($table->status === 'tersedia')
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-600"></span>
                        @else
                            <span class="w-1.5 h-1.5 rounded-full bg-sky-600"></span>
                        @endif
                        {{ ucfirst($table->status) }}
                    </span>
                </div>

                <div class="mt-auto pt-4 border-t border-latte/70 flex gap-2">
                    <a href="{{ route('admin.table.edit', $table) }}"
                       class="flex-1 py-2 px-3 rounded-xl bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white border border-sky-200 hover:border-sky-600 text-xs font-bold text-center transition inline-flex items-center justify-center gap-1.5">
                        <i class="fas fa-edit"></i>
                        <span>Edit</span>
                    </a>
                    <button type="button"
                            onclick="openDeleteTableModal(this)"
                            data-action="{{ route('admin.table.destroy', $table) }}"
                            data-nomor="{{ $table->nomor }}"
                            class="py-2 px-3.5 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 hover:border-rose-600 text-xs font-bold transition inline-flex items-center justify-center"
                            aria-label="Hapus Meja {{ $table->nomor }}">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="sm:col-span-2 lg:col-span-3 xl:col-span-4 bg-white border border-latte rounded-2xl p-12 text-center">
            <i class="fas fa-chair text-5xl text-stone-300 mb-3 block"></i>
            <p class="font-serif text-xl font-bold text-espresso mb-1">Belum ada data meja</p>
            <p class="text-xs text-stone-500 mb-5">Tambahkan meja baru untuk mulai mengatur denah kedai.</p>
            <a href="{{ route('admin.table.create') }}" class="btn-gold px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center gap-2">
                <i class="fas fa-plus"></i> Tambah Meja
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $tables->links() }}
    </div>

    <!-- Delete Table Confirmation Modal -->
    <div id="deleteTableModal"
         class="hidden fixed inset-0 bg-espresso/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         role="dialog"
         aria-modal="true">
        <div class="bg-white border border-latte rounded-3xl max-w-sm w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash-alt text-xl"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-espresso text-center mb-2">Hapus Meja?</h3>
            <p class="text-sm text-stone-600 text-center mb-6">
                <strong id="deleteTableLabel" class="text-espresso">Meja ini</strong> akan dihapus dari sistem kedai.
            </p>
            <form id="deleteTableForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteTableModal()" class="flex-1 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition">
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
    function openDeleteTableModal(trigger) {
        document.getElementById('deleteTableForm').action = trigger.dataset.action;
        document.getElementById('deleteTableLabel').textContent = 'Meja ' + (trigger.dataset.nomor || '');
        document.getElementById('deleteTableModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteTableModal() {
        document.getElementById('deleteTableModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    (function () {
        const modal = document.getElementById('deleteTableModal');
        if (modal) modal.addEventListener('click', closeDeleteTableModal);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeDeleteTableModal();
        });
    })();
</script>
@endpush
