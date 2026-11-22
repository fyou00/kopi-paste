@extends('layouts.admin')

@section('title', 'Edit Meja - Kopi Paste')
@section('page-title', 'Edit Meja')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">
    <a href="{{ route('admin.table.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brown hover:text-espresso transition">
        <i class="fas fa-arrow-left text-xs"></i>
        <span>Kembali ke Kelola Meja</span>
    </a>

    <div class="bg-white border border-latte rounded-3xl p-6 sm:p-8 shadow-xs">
        <div class="pb-5 mb-6 border-b border-latte">
            <h2 class="font-serif text-2xl font-bold text-espresso">Perbarui Meja {{ $table->nomor }}</h2>
            <p class="text-sm text-stone-500 mt-0.5">Ubah nomor meja, kapasitas kursi, atau status ketersediaan meja.</p>
        </div>

        <form action="{{ route('admin.table.update', $table) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="nomor" class="block text-sm font-semibold text-espresso mb-1.5">
                    Nomor Meja <span class="text-rose-500">*</span>
                </label>
                <input type="number"
                       id="nomor"
                       name="nomor"
                       value="{{ old('nomor', $table->nomor) }}"
                       min="1"
                       class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 font-mono-num text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('nomor') border-rose-500 @enderror"
                       required>
                @error('nomor')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="kapasitas" class="block text-sm font-semibold text-espresso mb-1.5">
                    Kapasitas Kursi <span class="text-rose-500">*</span>
                </label>
                <input type="number"
                       id="kapasitas"
                       name="kapasitas"
                       value="{{ old('kapasitas', $table->kapasitas) }}"
                       min="1"
                       max="50"
                       class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 font-mono-num text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('kapasitas') border-rose-500 @enderror"
                       required>

                <div class="flex flex-wrap items-center gap-2 mt-2.5">
                    <span class="text-xs text-stone-500">Pilih cepat:</span>
                    @foreach([2, 4, 6, 8] as $preset)
                        <button type="button"
                                onclick="document.getElementById('kapasitas').value = {{ $preset }}"
                                class="px-3 py-1 rounded-lg bg-cream border border-latte hover:border-caramel text-xs font-mono-num font-semibold text-espresso transition">
                            {{ $preset }} Orang
                        </button>
                    @endforeach
                </div>
                @error('kapasitas')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="status" class="block text-sm font-semibold text-espresso mb-1.5">
                    Status Meja <span class="text-rose-500">*</span>
                </label>
                <select id="status"
                        name="status"
                        class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('status') border-rose-500 @enderror"
                        required>
                    <option value="tersedia" {{ old('status', $table->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="terisi" {{ old('status', $table->status) === 'terisi' ? 'selected' : '' }}>Terisi</option>
                    <option value="reserved" {{ old('status', $table->status) === 'reserved' ? 'selected' : '' }}>Reserved</option>
                </select>
                @error('status')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-4 border-t border-latte">
                <button type="submit" class="btn-gold px-6 py-3 rounded-xl text-sm font-bold inline-flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Perbarui Meja</span>
                </button>
                <a href="{{ route('admin.table.index') }}"
                   class="px-6 py-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition inline-flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
