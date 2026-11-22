@extends('layouts.cashier')

@section('title', 'Buat Pesanan Baru - Kopi Paste')
@section('page-title', 'Buat Pesanan Baru (POS)')

@section('content')
<form action="{{ route('cashier.order.store') }}" method="POST" id="orderForm">
    @csrf

    <div class="grid lg:grid-cols-12 gap-6 items-start pb-20 lg:pb-0">
        <!-- Left: POS Menu Selection -->
        <div class="lg:col-span-8 space-y-5">
            <!-- Sticky Search & Category Pills -->
            <div class="bg-white border border-latte rounded-2xl p-4 shadow-xs sticky top-0 z-20">
                <div class="relative mb-3.5">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
                    <input type="text"
                           id="searchMenu"
                           placeholder="Cari menu kopi, non-kopi, atau makanan..."
                           aria-label="Cari menu"
                           class="w-full pl-10 pr-10 py-2.5 rounded-xl border border-latte bg-cream/50 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white transition">
                    <button type="button"
                            id="clearSearchMenu"
                            class="hidden absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-espresso p-1"
                            aria-label="Hapus pencarian">
                        <i class="fas fa-times-circle text-sm"></i>
                    </button>
                </div>

                <div class="flex items-center gap-2 overflow-x-auto no-scrollbar">
                    <button type="button"
                            data-pos-category="all"
                            class="pos-cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-espresso text-gold transition">
                        Semua
                    </button>
                    @foreach($menusByCategory as $kategori => $menus)
                        <button type="button"
                                data-pos-category="{{ Str::slug($kategori) }}"
                                class="pos-cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium bg-cream border border-latte text-espresso hover:border-caramel transition">
                            {{ $kategori }} ({{ $menus->count() }})
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Menu Categories -->
            <div id="posMenuContainer" class="space-y-6">
                @forelse($menusByCategory as $kategori => $menus)
                <div class="bg-white border border-latte rounded-2xl p-5 shadow-xs"
                     data-category-section="{{ Str::slug($kategori) }}">
                    <div class="flex items-center justify-between mb-4 pb-2.5 border-b border-latte/70">
                        <div class="flex items-center gap-2.5">
                            <span class="w-1.5 h-6 rounded-full bg-caramel"></span>
                            <h3 class="font-serif text-xl font-bold text-espresso">{{ $kategori }}</h3>
                        </div>
                        <span class="text-xs font-mono-num font-semibold text-stone-500 category-visible-count">
                            {{ $menus->count() }} menu
                        </span>
                    </div>

                    <div class="grid sm:grid-cols-2 xl:grid-cols-3 gap-3.5">
                        @foreach($menus as $menu)
                        <button type="button"
                                onclick="addItemFromCard(this)"
                                data-menu-id="{{ $menu->id }}"
                                data-menu-name="{{ $menu->nama }}"
                                data-menu-price="{{ $menu->harga }}"
                                data-menu-category="{{ Str::slug($kategori) }}"
                                data-search-text="{{ strtolower($menu->nama . ' ' . $kategori) }}"
                                class="menu-item group relative text-left bg-cream/40 hover:bg-amber-50/70 border border-latte hover:border-caramel rounded-2xl p-3.5 transition flex items-center gap-3.5 focus:outline-none focus:ring-2 focus:ring-caramel">
                            <!-- Live Qty Badge -->
                            <span data-badge-menu-id="{{ $menu->id }}"
                                  class="hidden absolute -top-2 -right-2 w-7 h-7 rounded-full bg-caramel text-white font-mono-num text-xs font-bold flex items-center justify-center shadow-md ring-2 ring-white">
                                0
                            </span>

                            @if($menu->foto)
                                <img src="{{ Storage::url($menu->foto) }}"
                                     alt="{{ $menu->nama }}"
                                     onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                     class="w-16 h-16 object-cover rounded-xl border border-latte shrink-0">
                                <div class="hidden w-16 h-16 bg-latte/60 rounded-xl flex items-center justify-center shrink-0 text-brown">
                                    <i class="fas fa-mug-hot text-lg"></i>
                                </div>
                            @else
                                <div class="w-16 h-16 bg-latte/60 rounded-xl flex items-center justify-center shrink-0 text-brown">
                                    <i class="fas fa-mug-hot text-lg"></i>
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <p class="font-bold text-sm text-espresso group-hover:text-brown line-clamp-2 leading-snug mb-1">
                                    {{ $menu->nama }}
                                </p>
                                <p class="font-mono-num text-sm font-bold text-caramel">
                                    Rp {{ number_format($menu->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </button>
                        @endforeach
                    </div>
                </div>
                @empty
                <div class="bg-white border border-latte rounded-2xl p-12 text-center">
                    <i class="fas fa-mug-hot text-5xl text-stone-300 mb-3"></i>
                    <p class="font-serif text-xl font-bold text-espresso">Tidak ada menu tersedia</p>
                </div>
                @endforelse
            </div>

            <!-- Empty Search State -->
            <div id="posEmptySearch" class="hidden bg-white border border-latte rounded-2xl p-10 text-center">
                <i class="fas fa-search text-3xl text-stone-300 mb-3"></i>
                <p class="font-bold text-espresso mb-1">Menu tidak ditemukan</p>
                <p class="text-xs text-stone-500 mb-4">Coba kata kunci lain atau pilih semua kategori.</p>
                <button type="button" onclick="resetPosMenuFilter()" class="px-4 py-2 rounded-xl bg-espresso text-gold text-xs font-semibold">
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Right: Order Summary -->
        <div class="lg:col-span-4" id="orderSummaryPanel">
            <div class="bg-white border border-latte rounded-2xl p-5 sm:p-6 shadow-sm lg:sticky lg:top-4">
                <div class="flex items-center justify-between mb-5 pb-3.5 border-b border-latte">
                    <div>
                        <h3 class="font-serif text-xl font-bold text-espresso">Ringkasan Pesanan</h3>
                        <p class="text-xs text-stone-500">Lengkapi data pelanggan &amp; cek item</p>
                    </div>
                    <span id="cartItemCount" class="px-3 py-1 rounded-full bg-amber-50 border border-amber-200 text-caramel text-xs font-bold font-mono-num">
                        0 item
                    </span>
                </div>

                <!-- Customer Name -->
                <div class="mb-4">
                    <label for="nama_pelanggan" class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">
                        Nama Pelanggan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text"
                           id="nama_pelanggan"
                           name="nama_pelanggan"
                           value="{{ old('nama_pelanggan') }}"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso placeholder:text-stone-400 focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white @error('nama_pelanggan') border-rose-500 @enderror"
                           placeholder="Contoh: Budi Santoso"
                           required>
                    @error('nama_pelanggan')
                        <p class="text-rose-600 text-xs font-medium mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Order Type Toggle + Table Select -->
                <div class="mb-5">
                    <label class="block text-xs font-bold uppercase tracking-wider text-stone-600 mb-1.5">
                        Tipe Pesanan &amp; Meja
                    </label>
                    <div class="grid grid-cols-2 gap-2 mb-2.5">
                        <button type="button"
                                id="btnTypeDineIn"
                                onclick="setOrderType('dine-in')"
                                class="py-2 px-3 rounded-xl border text-xs font-bold transition bg-espresso text-gold border-espresso inline-flex items-center justify-center gap-1.5">
                            <i class="fas fa-chair"></i> Dine-In
                        </button>
                        <button type="button"
                                id="btnTypeTakeAway"
                                onclick="setOrderType('take-away')"
                                class="py-2 px-3 rounded-xl border text-xs font-semibold transition bg-cream/60 text-stone-600 border-latte hover:border-caramel inline-flex items-center justify-center gap-1.5">
                            <i class="fas fa-shopping-bag"></i> Take Away
                        </button>
                    </div>

                    <div id="tableSelectWrapper">
                        <select name="table_id"
                                id="tableSelect"
                                onchange="onTableChange()"
                                class="w-full px-3.5 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel">
                            <option value="">Tanpa Meja / Take Away</option>
                            @foreach($tables as $table)
                                <option value="{{ $table->id }}" {{ old('table_id') == $table->id ? 'selected' : '' }}>
                                    Meja {{ $table->nomor }} ({{ $table->kapasitas }} orang)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Cart Items -->
                <div class="border-t border-latte pt-4 mb-4">
                    <div class="flex items-center justify-between mb-3">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-stone-600">Item Dipilih</h4>
                        <button type="button"
                                id="clearCartBtn"
                                onclick="clearCart()"
                                class="hidden text-xs font-semibold text-rose-600 hover:text-rose-800 transition">
                            <i class="fas fa-trash-alt mr-1"></i> Kosongkan
                        </button>
                    </div>

                    <div id="orderItems" class="space-y-2.5 max-h-64 overflow-y-auto pr-1">
                        <div class="text-center py-6 bg-cream/50 border border-dashed border-latte rounded-xl" id="emptyMessage">
                            <i class="fas fa-shopping-basket text-2xl text-stone-300 mb-2"></i>
                            <p class="text-xs text-stone-500">Klik menu di sebelah kiri untuk menambahkan</p>
                        </div>
                    </div>
                </div>

                <!-- Total -->
                <div class="bg-cream border border-latte rounded-2xl p-4 mb-5">
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-stone-600">Total Bayar</span>
                        <span class="font-mono-num text-2xl font-bold text-brown" id="totalPrice">Rp 0</span>
                    </div>
                </div>

                <div class="space-y-2.5">
                    <button type="submit"
                            id="submitBtn"
                            class="w-full btn-gold py-3.5 px-5 rounded-xl text-sm sm:text-base font-bold disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none disabled:shadow-none inline-flex items-center justify-center gap-2"
                            disabled>
                        <i class="fas fa-save"></i>
                        <span>Simpan Pesanan</span>
                    </button>
                    <a href="{{ route('cashier.order.index') }}"
                       class="w-full py-2.5 px-4 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold block text-center transition">
                        Batal
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="hiddenInputsContainer"></div>
</form>

<!-- Mobile Sticky Bottom Summary Bar -->
<div id="mobileCartBar" class="hidden lg:hidden fixed bottom-0 inset-x-0 z-30 bg-espresso text-white px-4 py-3 border-t border-white/10 shadow-2xl flex items-center justify-between gap-3">
    <div>
        <p class="text-xs text-white/70"><span id="mobileCartQty" class="font-mono-num font-bold text-gold">0</span> item dipilih</p>
        <p class="font-mono-num text-base font-bold text-white" id="mobileCartTotal">Rp 0</p>
    </div>
    <button type="button"
            onclick="document.getElementById('orderSummaryPanel').scrollIntoView({ behavior: 'smooth' })"
            class="btn-gold px-5 py-2.5 rounded-xl text-xs font-bold shrink-0">
        Lihat Ringkasan <i class="fas fa-arrow-down ml-1"></i>
    </button>
</div>
@endsection

@push('scripts')
<script>
    let orderItems = [];
    let itemIdCounter = 0;
    let activePosCategory = 'all';

    function addItemFromCard(el) {
        if (!el) return;
        const menuId = Number(el.dataset.menuId);
        const menuName = el.dataset.menuName || '';
        const price = Number(el.dataset.menuPrice || 0);
        addItem(menuId, menuName, price);
    }

    function addItem(menuId, menuName, price) {
        const existingIndex = orderItems.findIndex(item => item.menuId === menuId);
        if (existingIndex !== -1) {
            orderItems[existingIndex].qty++;
        } else {
            orderItems.push({
                id: itemIdCounter++,
                menuId: menuId,
                name: menuName,
                price: price,
                qty: 1
            });
        }
        updateOrderDisplay();
    }

    function removeItem(id) {
        orderItems = orderItems.filter(item => item.id !== id);
        updateOrderDisplay();
    }

    function clearCart() {
        orderItems = [];
        updateOrderDisplay();
    }

    function updateQty(id, change) {
        const item = orderItems.find(item => item.id === id);
        if (item) {
            item.qty += change;
            if (item.qty <= 0) {
                removeItem(id);
            } else {
                updateOrderDisplay();
            }
        }
    }

    function syncMenuCardBadges() {
        document.querySelectorAll('[data-badge-menu-id]').forEach(badge => {
            const menuId = Number(badge.dataset.badgeMenuId);
            const found = orderItems.find(item => item.menuId === menuId);
            if (found && found.qty > 0) {
                badge.textContent = found.qty;
                badge.classList.remove('hidden');
                badge.closest('.menu-item')?.classList.add('border-caramel', 'bg-amber-50/70');
            } else {
                badge.textContent = '0';
                badge.classList.add('hidden');
                badge.closest('.menu-item')?.classList.remove('border-caramel', 'bg-amber-50/70');
            }
        });
    }

    function updateOrderDisplay() {
        const container = document.getElementById('orderItems');
        const submitBtn = document.getElementById('submitBtn');
        const hiddenContainer = document.getElementById('hiddenInputsContainer');
        const clearCartBtn = document.getElementById('clearCartBtn');
        const cartItemCount = document.getElementById('cartItemCount');
        const mobileBar = document.getElementById('mobileCartBar');
        const mobileQty = document.getElementById('mobileCartQty');
        const mobileTotal = document.getElementById('mobileCartTotal');

        syncMenuCardBadges();

        if (orderItems.length === 0) {
            container.innerHTML = '<div class="text-center py-6 bg-cream/50 border border-dashed border-latte rounded-xl" id="emptyMessage"><i class="fas fa-shopping-basket text-2xl text-stone-300 mb-2"></i><p class="text-xs text-stone-500">Klik menu di sebelah kiri untuk menambahkan</p></div>';
            if (hiddenContainer) hiddenContainer.innerHTML = '';
            submitBtn.disabled = true;
            if (clearCartBtn) clearCartBtn.classList.add('hidden');
            if (cartItemCount) cartItemCount.textContent = '0 item';
            if (mobileBar) mobileBar.classList.add('hidden');
            document.getElementById('totalPrice').textContent = 'Rp 0';
            return;
        }

        submitBtn.disabled = false;
        if (clearCartBtn) clearCartBtn.classList.remove('hidden');

        container.innerHTML = '';
        let hiddenInputs = '';
        let total = 0;
        let totalQty = 0;

        orderItems.forEach((item, index) => {
            const subtotal = item.price * item.qty;
            total += subtotal;
            totalQty += item.qty;

            hiddenInputs += `
                <input type="hidden" name="items[${index}][menu_id]" value="${item.menuId}">
                <input type="hidden" name="items[${index}][qty]" value="${item.qty}">
            `;

            const row = document.createElement('div');
            row.className = 'flex items-center justify-between gap-2 bg-cream/70 border border-latte rounded-xl p-3';

            const infoDiv = document.createElement('div');
            infoDiv.className = 'min-w-0 flex-1';

            const nameP = document.createElement('p');
            nameP.className = 'font-bold text-xs sm:text-sm text-espresso truncate';
            nameP.textContent = item.name;

            const priceP = document.createElement('p');
            priceP.className = 'font-mono-num text-xs text-stone-500 mt-0.5';
            priceP.textContent = 'Rp ' + item.price.toLocaleString('id-ID') + ' • Sub: Rp ' + subtotal.toLocaleString('id-ID');

            infoDiv.appendChild(nameP);
            infoDiv.appendChild(priceP);

            const controlsDiv = document.createElement('div');
            controlsDiv.className = 'flex items-center gap-1.5 shrink-0';
            controlsDiv.innerHTML = `
                <button type="button" onclick="updateQty(${item.id}, -1)" class="w-7 h-7 rounded-lg bg-white border border-latte hover:bg-stone-100 text-espresso font-bold text-xs flex items-center justify-center">-</button>
                <span class="font-mono-num font-bold text-sm w-6 text-center text-espresso">${item.qty}</span>
                <button type="button" onclick="updateQty(${item.id}, 1)" class="w-7 h-7 rounded-lg bg-caramel hover:bg-brown text-white font-bold text-xs flex items-center justify-center">+</button>
                <button type="button" onclick="removeItem(${item.id})" class="w-7 h-7 rounded-lg text-rose-500 hover:bg-rose-50 flex items-center justify-center ml-0.5" aria-label="Hapus item">
                    <i class="fas fa-trash text-xs"></i>
                </button>
            `;

            row.appendChild(infoDiv);
            row.appendChild(controlsDiv);
            container.appendChild(row);
        });

        if (hiddenContainer) {
            hiddenContainer.innerHTML = hiddenInputs;
        }

        const formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('totalPrice').textContent = formattedTotal;
        if (cartItemCount) cartItemCount.textContent = totalQty + ' item';
        if (mobileBar) mobileBar.classList.remove('hidden');
        if (mobileQty) mobileQty.textContent = totalQty;
        if (mobileTotal) mobileTotal.textContent = formattedTotal;
    }

    // Order Type Toggle synced with table_id
    function setOrderType(type) {
        const btnDine = document.getElementById('btnTypeDineIn');
        const btnTake = document.getElementById('btnTypeTakeAway');
        const tableSelect = document.getElementById('tableSelect');
        const wrapper = document.getElementById('tableSelectWrapper');

        if (type === 'take-away') {
            if (tableSelect) tableSelect.value = '';
            if (wrapper) wrapper.classList.add('hidden');
            btnTake.className = 'py-2 px-3 rounded-xl border text-xs font-bold transition bg-espresso text-gold border-espresso inline-flex items-center justify-center gap-1.5';
            btnDine.className = 'py-2 px-3 rounded-xl border text-xs font-semibold transition bg-cream/60 text-stone-600 border-latte hover:border-caramel inline-flex items-center justify-center gap-1.5';
        } else {
            if (wrapper) wrapper.classList.remove('hidden');
            btnDine.className = 'py-2 px-3 rounded-xl border text-xs font-bold transition bg-espresso text-gold border-espresso inline-flex items-center justify-center gap-1.5';
            btnTake.className = 'py-2 px-3 rounded-xl border text-xs font-semibold transition bg-cream/60 text-stone-600 border-latte hover:border-caramel inline-flex items-center justify-center gap-1.5';
        }
    }

    function onTableChange() {
        const tableSelect = document.getElementById('tableSelect');
        if (tableSelect && tableSelect.value !== '') {
            setOrderType('dine-in');
        }
    }

    // Menu Search & Category Filtering
    function applyPosMenuFilters() {
        const searchInput = document.getElementById('searchMenu');
        const clearBtn = document.getElementById('clearSearchMenu');
        const emptySearch = document.getElementById('posEmptySearch');
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';

        if (clearBtn) {
            clearBtn.classList.toggle('hidden', query.length === 0);
        }

        let totalVisible = 0;

        document.querySelectorAll('[data-category-section]').forEach(section => {
            const sectionCat = section.dataset.categorySection;
            const items = section.querySelectorAll('.menu-item');
            let sectionVisible = 0;

            items.forEach(item => {
                const text = item.dataset.searchText || '';
                const itemCat = item.dataset.menuCategory;
                const matchCat = activePosCategory === 'all' || itemCat === activePosCategory;
                const matchSearch = !query || text.includes(query);
                const show = matchCat && matchSearch;

                item.classList.toggle('hidden', !show);
                if (show) {
                    sectionVisible++;
                    totalVisible++;
                }
            });

            const countLabel = section.querySelector('.category-visible-count');
            if (countLabel) countLabel.textContent = sectionVisible + ' menu';

            section.classList.toggle('hidden', sectionVisible === 0);
        });

        if (emptySearch) {
            emptySearch.classList.toggle('hidden', totalVisible > 0);
        }
    }

    function resetPosMenuFilter() {
        const searchInput = document.getElementById('searchMenu');
        if (searchInput) searchInput.value = '';
        activePosCategory = 'all';
        document.querySelectorAll('[data-pos-category]').forEach(btn => {
            const active = btn.dataset.posCategory === 'all';
            btn.className = active
                ? 'pos-cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-espresso text-gold transition'
                : 'pos-cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium bg-cream border border-latte text-espresso hover:border-caramel transition';
        });
        applyPosMenuFilters();
    }

    (function () {
        const searchInput = document.getElementById('searchMenu');
        const clearBtn = document.getElementById('clearSearchMenu');

        if (searchInput) {
            searchInput.addEventListener('input', applyPosMenuFilters);
        }
        if (clearBtn && searchInput) {
            clearBtn.addEventListener('click', function () {
                searchInput.value = '';
                applyPosMenuFilters();
                searchInput.focus();
            });
        }

        document.querySelectorAll('[data-pos-category]').forEach(btn => {
            btn.addEventListener('click', function () {
                activePosCategory = this.dataset.posCategory;
                document.querySelectorAll('[data-pos-category]').forEach(pill => {
                    const active = pill.dataset.posCategory === activePosCategory;
                    pill.className = active
                        ? 'pos-cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-semibold bg-espresso text-gold transition'
                        : 'pos-cat-pill shrink-0 px-3.5 py-1.5 rounded-full text-xs font-medium bg-cream border border-latte text-espresso hover:border-caramel transition';
                });
                applyPosMenuFilters();
            });
        });

        document.getElementById('orderForm').addEventListener('submit', function (e) {
            if (orderItems.length === 0) {
                e.preventDefault();
            }
        });
    })();
</script>
@endpush
