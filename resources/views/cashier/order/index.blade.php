@extends('layouts.cashier')

@section('title', 'Daftar Pesanan - Kopi Paste')
@section('page-title', 'Daftar Pesanan')

@section('content')
    @php
        $currentStatus = request('status');
        $baseQuery = request()->except('page', 'status');
    @endphp

    <!-- Top Filter Toolbar -->
    <div class="bg-white border border-latte rounded-2xl p-4 sm:p-5 shadow-sm mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <form action="{{ route('cashier.order.index') }}" method="GET" class="flex flex-wrap items-center gap-2.5 flex-1">
                <div class="relative flex-1 min-w-[200px] sm:max-w-xs">
                    <i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-stone-400 text-sm"></i>
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama pelanggan..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel focus:bg-white">
                </div>

                <select name="status"
                        class="px-4 py-2.5 rounded-xl border border-latte bg-cream/40 text-sm text-espresso focus:outline-none focus:ring-2 focus:ring-caramel"
                        onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="menunggu" {{ $currentStatus === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="diproses" {{ $currentStatus === 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $currentStatus === 'selesai' ? 'selected' : '' }}>Selesai</option>
                </select>

                <button type="submit" class="btn-espresso px-4 py-2.5 rounded-xl text-sm font-semibold inline-flex items-center gap-2">
                    <i class="fas fa-search text-xs text-gold"></i>
                    <span>Cari</span>
                </button>

                @if(request()->filled('search') || request()->filled('status'))
                    <a href="{{ route('cashier.order.index') }}"
                       class="px-4 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-stone-700 text-sm font-semibold transition inline-flex items-center gap-1.5">
                        <i class="fas fa-rotate-left text-xs"></i>
                        <span>Reset</span>
                    </a>
                @endif
            </form>

            <a href="{{ route('cashier.order.create') }}"
               class="btn-gold px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center justify-center gap-2 shrink-0">
                <i class="fas fa-plus-circle"></i>
                <span>Pesanan Baru</span>
            </a>
        </div>
    </div>

    <!-- Clickable Status Filter Cards -->
    <div class="grid sm:grid-cols-3 gap-4 mb-6">
        <a href="{{ route('cashier.order.index', array_merge($baseQuery, ['status' => $currentStatus === 'menunggu' ? '' : 'menunggu'])) }}"
           class="bg-amber-50/80 border rounded-2xl p-4 flex items-center justify-between transition hover:shadow-sm {{ $currentStatus === 'menunggu' ? 'border-amber-500 ring-2 ring-amber-400/40' : 'border-amber-200' }}">
            <div class="flex items-center gap-3.5">
                <span class="w-12 h-12 rounded-xl bg-amber-500 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-clock text-xl"></i>
                </span>
                <div>
                    <p class="font-mono-num text-2xl font-bold text-amber-900">{{ $countMenunggu }}</p>
                    <p class="text-xs font-semibold text-amber-700">Menunggu</p>
                </div>
            </div>
            <span class="text-xs font-semibold text-amber-700">
                {{ $currentStatus === 'menunggu' ? 'Aktif (klik reset)' : 'Filter' }}
            </span>
        </a>

        <a href="{{ route('cashier.order.index', array_merge($baseQuery, ['status' => $currentStatus === 'diproses' ? '' : 'diproses'])) }}"
           class="bg-sky-50/80 border rounded-2xl p-4 flex items-center justify-between transition hover:shadow-sm {{ $currentStatus === 'diproses' ? 'border-sky-500 ring-2 ring-sky-400/40' : 'border-sky-200' }}">
            <div class="flex items-center gap-3.5">
                <span class="w-12 h-12 rounded-xl bg-sky-600 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-mug-hot text-xl"></i>
                </span>
                <div>
                    <p class="font-mono-num text-2xl font-bold text-sky-900">{{ $countDiproses }}</p>
                    <p class="text-xs font-semibold text-sky-700">Diproses</p>
                </div>
            </div>
            <span class="text-xs font-semibold text-sky-700">
                {{ $currentStatus === 'diproses' ? 'Aktif (klik reset)' : 'Filter' }}
            </span>
        </a>

        <a href="{{ route('cashier.order.index', array_merge($baseQuery, ['status' => $currentStatus === 'selesai' ? '' : 'selesai'])) }}"
           class="bg-emerald-50/80 border rounded-2xl p-4 flex items-center justify-between transition hover:shadow-sm {{ $currentStatus === 'selesai' ? 'border-emerald-500 ring-2 ring-emerald-400/40' : 'border-emerald-200' }}">
            <div class="flex items-center gap-3.5">
                <span class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center shrink-0">
                    <i class="fas fa-check-circle text-xl"></i>
                </span>
                <div>
                    <p class="font-mono-num text-2xl font-bold text-emerald-900">{{ $countSelesai }}</p>
                    <p class="text-xs font-semibold text-emerald-700">Selesai</p>
                </div>
            </div>
            <span class="text-xs font-semibold text-emerald-700">
                {{ $currentStatus === 'selesai' ? 'Aktif (klik reset)' : 'Filter' }}
            </span>
        </a>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
        <div class="bg-white border border-latte rounded-2xl p-5 shadow-sm hover:shadow-md transition border-l-4 {{ $order->status === 'menunggu' ? 'border-l-amber-500' : ($order->status === 'diproses' ? 'border-l-sky-500' : 'border-l-emerald-500') }}">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-2.5 mb-2">
                        <h3 class="font-serif text-xl font-bold text-espresso">{{ $order->nama_pelanggan }}</h3>
                        <span class="font-mono-num text-xs px-2 py-0.5 rounded-md bg-cream border border-latte text-stone-600">
                            #{{ $order->id }}
                        </span>
                        <span class="px-3 py-1 rounded-full text-xs font-bold inline-flex items-center gap-1.5 {{ $order->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($order->status === 'diproses' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-4 text-xs text-stone-500 mb-3">
                        <span>
                            <i class="fas fa-clock text-caramel mr-1"></i> {{ $order->created_at->format('H:i, d M Y') }}
                        </span>
                        <span>
                            @if($order->table)
                                <i class="fas fa-chair text-caramel mr-1"></i> Meja {{ $order->table->nomor }}
                            @else
                                <i class="fas fa-shopping-bag text-caramel mr-1"></i> Take Away
                            @endif
                        </span>
                        <span>
                            <i class="fas fa-utensils text-caramel mr-1"></i> {{ $order->items->count() }} item
                        </span>
                    </div>

                    <div class="flex flex-wrap gap-1.5 mb-3">
                        @foreach($order->items as $item)
                            <span class="inline-flex items-center gap-1 bg-cream border border-latte rounded-lg px-2.5 py-1 text-xs text-espresso">
                                <strong class="font-mono-num text-caramel">{{ $item->qty }}x</strong>
                                <span>{{ $item->menu->nama ?? 'Menu' }}</span>
                            </span>
                        @endforeach
                    </div>

                    <p class="font-mono-num text-xl font-bold text-brown">
                        Rp {{ number_format($order->total, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Actions -->
                <div class="flex flex-wrap md:flex-col gap-2 shrink-0 md:w-44">
                    <a href="{{ route('cashier.order.show', $order) }}"
                       class="flex-1 md:flex-none px-4 py-2 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-xs font-bold text-center transition inline-flex items-center justify-center gap-1.5">
                        <i class="fas fa-eye"></i>
                        <span>Detail</span>
                    </a>

                    @if($order->status === 'menunggu')
                        <form action="{{ route('cashier.order.updateStatus', $order) }}" method="POST" class="flex-1 md:flex-none">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="diproses">
                            <button type="submit"
                                    class="w-full px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition inline-flex items-center justify-center gap-1.5">
                                <i class="fas fa-play"></i>
                                <span>Proses Pesanan</span>
                            </button>
                        </form>
                    @elseif($order->status === 'diproses')
                        <button type="button"
                                onclick="openPaymentModal(this)"
                                data-order-id="{{ $order->id }}"
                                data-customer="{{ $order->nama_pelanggan }}"
                                data-total="{{ $order->total }}"
                                class="flex-1 md:flex-none px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition inline-flex items-center justify-center gap-1.5">
                            <i class="fas fa-cash-register"></i>
                            <span>Bayar &amp; Selesai</span>
                        </button>
                    @endif

                    @if($order->status !== 'selesai')
                        <button type="button"
                                onclick="openDeleteModal(this)"
                                data-action="{{ route('cashier.order.destroy', $order) }}"
                                data-customer="{{ $order->nama_pelanggan }}"
                                class="px-4 py-2 rounded-xl bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white border border-rose-200 hover:border-rose-600 text-xs font-bold transition inline-flex items-center justify-center gap-1.5">
                            <i class="fas fa-trash"></i>
                            <span>Hapus</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="bg-white border border-latte rounded-2xl p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-cream border border-latte text-stone-400 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-clipboard-list text-2xl"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-espresso mb-1">Tidak ada pesanan</h3>
            <p class="text-sm text-stone-500 mb-5">Belum ada pesanan yang sesuai dengan filter saat ini.</p>
            <a href="{{ route('cashier.order.create') }}" class="btn-gold px-6 py-2.5 rounded-xl text-sm font-bold inline-flex items-center gap-2">
                <i class="fas fa-plus-circle"></i> Buat Pesanan Pertama
            </a>
        </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

    <!-- Payment Modal -->
    <div id="paymentModal"
         class="hidden fixed inset-0 bg-espresso/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         role="dialog"
         aria-modal="true">
        <div class="bg-white border border-latte rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
            <div class="bg-gradient-to-r from-roast to-espresso px-6 py-5 text-white flex items-center justify-between">
                <div>
                    <p class="text-xs text-gold uppercase tracking-wider font-semibold">Penyelesaian Pembayaran</p>
                    <h3 class="font-serif text-xl font-bold" id="payModalCustomer">Pelanggan</h3>
                </div>
                <button type="button" onclick="closePaymentModal()" class="text-white/70 hover:text-white p-1.5 rounded-lg" aria-label="Tutup modal">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <form id="paymentForm" method="POST" class="p-6">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="selesai">

                <!-- Order Total Display -->
                <div class="bg-cream border border-latte rounded-2xl p-4 mb-5 flex items-center justify-between">
                    <span class="text-sm font-semibold text-stone-600">Total Tagihan</span>
                    <span id="payModalTotal" class="font-mono-num text-2xl font-bold text-brown">Rp 0</span>
                </div>

                <!-- Payment Method Grid -->
                <p class="text-xs font-bold uppercase tracking-wider text-stone-500 mb-2.5">Pilih Metode Pembayaran</p>
                <div class="grid grid-cols-2 gap-3 mb-5">
                    <label class="radio-card flex items-center gap-3 p-3.5 border border-latte rounded-xl cursor-pointer hover:bg-cream/60">
                        <input type="radio" name="metode_pembayaran" value="Tunai" class="sr-only" required checked onchange="toggleCashCalculator()">
                        <span class="w-9 h-9 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
                            <i class="fas fa-money-bill-wave"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">Tunai</span>
                    </label>

                    <label class="radio-card flex items-center gap-3 p-3.5 border border-latte rounded-xl cursor-pointer hover:bg-cream/60">
                        <input type="radio" name="metode_pembayaran" value="Transfer" class="sr-only" onchange="toggleCashCalculator()">
                        <span class="w-9 h-9 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center shrink-0">
                            <i class="fas fa-university"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">Transfer Bank</span>
                    </label>

                    <label class="radio-card flex items-center gap-3 p-3.5 border border-latte rounded-xl cursor-pointer hover:bg-cream/60">
                        <input type="radio" name="metode_pembayaran" value="QRIS" class="sr-only" onchange="toggleCashCalculator()">
                        <span class="w-9 h-9 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                            <i class="fas fa-qrcode"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">QRIS</span>
                    </label>

                    <label class="radio-card flex items-center gap-3 p-3.5 border border-latte rounded-xl cursor-pointer hover:bg-cream/60">
                        <input type="radio" name="metode_pembayaran" value="Kartu Debit/Kredit" class="sr-only" onchange="toggleCashCalculator()">
                        <span class="w-9 h-9 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                            <i class="fas fa-credit-card"></i>
                        </span>
                        <span class="font-bold text-sm text-espresso">Kartu Debit/Kredit</span>
                    </label>
                </div>

                <!-- Cash Change Calculator (Frontend Helper) -->
                <div id="cashCalculator" class="bg-stone-50 border border-stone-200 rounded-2xl p-4 mb-5">
                    <div class="flex items-center justify-between mb-2">
                        <label for="cashReceivedInput" class="text-xs font-bold text-espresso">Uang Diterima (Opsional)</label>
                        <button type="button" onclick="setExactCash()" class="text-xs font-bold text-caramel hover:underline">Uang Pas</button>
                    </div>
                    <input type="number"
                           id="cashReceivedInput"
                           min="0"
                           placeholder="Contoh: 50000"
                           oninput="calculateChange()"
                           class="w-full px-3.5 py-2 rounded-xl border border-latte bg-white font-mono-num text-sm focus:outline-none focus:ring-2 focus:ring-caramel mb-2.5">
                    <div class="flex flex-wrap gap-1.5 mb-3">
                        <button type="button" onclick="setCashNominal(20000)" class="px-2.5 py-1 rounded-lg bg-white border border-latte text-xs font-mono-num font-semibold hover:border-caramel">Rp 20.000</button>
                        <button type="button" onclick="setCashNominal(50000)" class="px-2.5 py-1 rounded-lg bg-white border border-latte text-xs font-mono-num font-semibold hover:border-caramel">Rp 50.000</button>
                        <button type="button" onclick="setCashNominal(100000)" class="px-2.5 py-1 rounded-lg bg-white border border-latte text-xs font-mono-num font-semibold hover:border-caramel">Rp 100.000</button>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t border-stone-200 text-sm">
                        <span class="text-stone-600 font-medium">Kembalian</span>
                        <span id="cashChangeDisplay" class="font-mono-num font-bold text-emerald-700">Rp 0</span>
                    </div>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-3 rounded-xl font-bold text-sm transition inline-flex items-center justify-center gap-2">
                        <i class="fas fa-check"></i>
                        <span>Konfirmasi Pembayaran</span>
                    </button>
                    <button type="button" onclick="closePaymentModal()" class="px-5 py-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div id="deleteOrderModal"
         class="hidden fixed inset-0 bg-espresso/70 backdrop-blur-sm z-50 flex items-center justify-center p-4"
         role="dialog"
         aria-modal="true">
        <div class="bg-white border border-latte rounded-3xl max-w-sm w-full p-6 shadow-2xl" onclick="event.stopPropagation()">
            <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-trash-alt text-xl"></i>
            </div>
            <h3 class="font-serif text-xl font-bold text-espresso text-center mb-2">Hapus Pesanan?</h3>
            <p class="text-sm text-stone-600 text-center mb-6">
                Pesanan atas nama <strong id="deleteCustomerName" class="text-espresso">pelanggan</strong> akan dihapus secara permanen.
            </p>
            <form id="deleteOrderForm" method="POST" class="flex gap-3">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition">
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
    let activeOrderTotal = 0;

    function formatRupiah(amount) {
        return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
    }

    function openPaymentModal(trigger) {
        const orderId = trigger.dataset.orderId;
        const customer = trigger.dataset.customer || 'Pelanggan';
        activeOrderTotal = Number(trigger.dataset.total || 0);

        document.getElementById('paymentForm').action = `/cashier/pesanan/${orderId}/status`;
        document.getElementById('payModalCustomer').textContent = customer;
        document.getElementById('payModalTotal').textContent = formatRupiah(activeOrderTotal);

        const cashRadio = document.querySelector('input[name="metode_pembayaran"][value="Tunai"]');
        if (cashRadio) cashRadio.checked = true;
        const cashInput = document.getElementById('cashReceivedInput');
        if (cashInput) cashInput.value = '';
        toggleCashCalculator();
        calculateChange();

        document.getElementById('paymentModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closePaymentModal() {
        document.getElementById('paymentModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    function toggleCashCalculator() {
        const selected = document.querySelector('input[name="metode_pembayaran"]:checked');
        const calc = document.getElementById('cashCalculator');
        if (!calc) return;
        calc.classList.toggle('hidden', !selected || selected.value !== 'Tunai');
    }

    function setExactCash() {
        const cashInput = document.getElementById('cashReceivedInput');
        if (cashInput) {
            cashInput.value = activeOrderTotal;
            calculateChange();
        }
    }

    function setCashNominal(val) {
        const cashInput = document.getElementById('cashReceivedInput');
        if (cashInput) {
            cashInput.value = val;
            calculateChange();
        }
    }

    function calculateChange() {
        const cashInput = document.getElementById('cashReceivedInput');
        const display = document.getElementById('cashChangeDisplay');
        if (!cashInput || !display) return;

        const received = Number(cashInput.value || 0);
        if (!cashInput.value) {
            display.textContent = 'Rp 0';
            display.className = 'font-mono-num font-bold text-stone-500';
            return;
        }
        const diff = received - activeOrderTotal;
        if (diff < 0) {
            display.textContent = 'Kurang ' + formatRupiah(Math.abs(diff));
            display.className = 'font-mono-num font-bold text-rose-600';
        } else {
            display.textContent = formatRupiah(diff);
            display.className = 'font-mono-num font-bold text-emerald-700';
        }
    }

    function openDeleteModal(trigger) {
        document.getElementById('deleteOrderForm').action = trigger.dataset.action;
        document.getElementById('deleteCustomerName').textContent = trigger.dataset.customer || 'pelanggan';
        document.getElementById('deleteOrderModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteOrderModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    (function () {
        const payModal = document.getElementById('paymentModal');
        const delModal = document.getElementById('deleteOrderModal');
        if (payModal) payModal.addEventListener('click', closePaymentModal);
        if (delModal) delModal.addEventListener('click', closeDeleteModal);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closePaymentModal();
                closeDeleteModal();
            }
        });
    })();
</script>
@endpush
