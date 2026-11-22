@extends('layouts.admin')

@section('title', 'Edit Menu - Kopi Paste')
@section('page-title', 'Edit Menu')

@section('content')
<div class="max-w-3xl mx-auto space-y-5">
    <a href="{{ route('admin.menu.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brown hover:text-espresso transition">
        <i class="fas fa-arrow-left text-xs"></i>
        <span>Kembali ke Daftar Menu</span>
    </a>

    <div class="bg-white border border-latte rounded-3xl p-6 sm:p-8 shadow-sm">
        <div class="pb-5 mb-6 border-b border-latte">
            <h2 class="font-serif text-2xl font-bold text-espresso">Perbarui Menu: {{ $menu->nama }}</h2>
            <p class="text-sm text-stone-500 mt-0.5">Ubah nama, kategori, harga, status ketersediaan, atau foto menu.</p>
        </div>

        <form action="{{ route('admin.menu.update', $menu) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            @method('PUT')

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="nama" class="block text-sm font-semibold text-espresso mb-1.5">
                        Nama Menu <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="nama"
                           name="nama"
                           value="{{ old('nama', $menu->nama) }}"
                           class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('nama') border-rose-500 @enderror"
                           required>
                    @error('nama')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="kategori" class="block text-sm font-semibold text-espresso mb-1.5">
                        Kategori <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="kategori"
                           name="kategori"
                           value="{{ old('kategori', $menu->kategori) }}"
                           list="categories"
                           class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('kategori') border-rose-500 @enderror"
                           required>
                    <datalist id="categories">
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}">
                        @endforeach
                    </datalist>
                    @error('kategori')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid sm:grid-cols-2 gap-5">
                <div>
                    <label for="harga" class="block text-sm font-semibold text-espresso mb-1.5">
                        Harga (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number"
                           id="harga"
                           name="harga"
                           value="{{ old('harga', $menu->harga) }}"
                           min="0"
                           oninput="updatePricePreview(this.value)"
                           class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 font-mono-num text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('harga') border-rose-500 @enderror"
                           required>
                    <p class="text-xs text-stone-500 mt-1">
                        Preview tampilan: <strong id="pricePreviewText" class="font-mono-num text-caramel">Rp {{ number_format($menu->harga, 0, ',', '.') }}</strong>
                    </p>
                    @error('harga')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="status" class="block text-sm font-semibold text-espresso mb-1.5">
                        Status Ketersediaan <span class="text-rose-500">*</span>
                    </label>
                    <select id="status"
                            name="status"
                            class="w-full px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('status') border-rose-500 @enderror"
                            required>
                        <option value="tersedia" {{ old('status', $menu->status) === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="tidak tersedia" {{ old('status', $menu->status) === 'tidak tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    @error('status')<p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <!-- Interactive Photo Upload Zone -->
            <div>
                <label class="block text-sm font-semibold text-espresso mb-2">Foto Menu</label>
                <label for="fotoInput"
                       class="flex flex-col sm:flex-row items-center gap-5 p-5 rounded-2xl border-2 border-dashed border-latte hover:border-caramel bg-cream/40 hover:bg-amber-50/40 cursor-pointer transition">
                    <div class="w-28 h-28 rounded-2xl bg-white border border-latte flex items-center justify-center overflow-hidden shrink-0">
                        @if($menu->foto)
                            <img id="preview" src="{{ Storage::url($menu->foto) }}" alt="{{ $menu->nama }}" class="w-full h-full object-cover">
                            <i id="previewPlaceholder" class="hidden fas fa-cloud-upload-alt text-3xl text-stone-300"></i>
                        @else
                            <img id="preview" alt="Preview foto menu" class="w-full h-full object-cover hidden">
                            <i id="previewPlaceholder" class="fas fa-cloud-upload-alt text-3xl text-stone-300"></i>
                        @endif
                    </div>
                    <div class="text-center sm:text-left">
                        <p class="font-bold text-sm text-espresso">Ganti foto menu (opsional)</p>
                        <p id="fileNameDisplay" class="text-xs text-stone-500 mt-1">Biarkan kosong jika tidak ingin mengubah foto saat ini.</p>
                        <span class="inline-block mt-3 px-3.5 py-1.5 rounded-lg bg-espresso text-gold text-xs font-semibold">
                            Pilih Gambar Baru
                        </span>
                    </div>
                    <input type="file"
                           id="fotoInput"
                           name="foto"
                           accept="image/*"
                           class="sr-only"
                           onchange="previewImage(event)">
                </label>
                @error('foto')<p class="text-rose-600 text-xs font-medium mt-1.5">{{ $message }}</p>@enderror
            </div>

            <div class="flex flex-wrap gap-3 pt-4 border-t border-latte">
                <button type="submit" class="btn-gold px-6 py-3 rounded-xl text-sm font-bold inline-flex items-center gap-2">
                    <i class="fas fa-save"></i>
                    <span>Perbarui Menu</span>
                </button>
                <a href="{{ route('admin.menu.index') }}"
                   class="px-6 py-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition inline-flex items-center gap-2">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function updatePricePreview(val) {
        const num = Number(val || 0);
        const el = document.getElementById('pricePreviewText');
        if (el) el.textContent = 'Rp ' + num.toLocaleString('id-ID');
    }

    function previewImage(event) {
        const preview = document.getElementById('preview');
        const placeholder = document.getElementById('previewPlaceholder');
        const fileNameEl = document.getElementById('fileNameDisplay');
        const file = event.target.files[0];
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.classList.remove('hidden');
            if (placeholder) placeholder.classList.add('hidden');
            if (fileNameEl) fileNameEl.textContent = 'Foto baru: ' + file.name;
        }
    }

    updatePricePreview(document.getElementById('harga')?.value);
</script>
@endpush
