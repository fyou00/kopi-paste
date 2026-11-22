@extends('layouts.cashier')

@section('title', 'Detail Pesanan - Kopi Paste')
@section('page-title', 'Detail Pesanan')

@section('content')
@php
    $stepIndex = $order->status === 'menunggu' ? 1 : ($order->status === 'diproses' ? 2 : 3);
@endphp

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Breadcrumb Back -->
    <div class="flex items-center justify-between">
        <a href="{{ route('cashier.order.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brown hover:text-espresso transition">
            <i class="fas fa-arrow-left text-xs"></i>
            <span>Kembali ke Daftar Pesanan</span>
        </a>
        <span class="font-mono-num text-xs px-3 py-1 rounded-full bg-white border border-latte text-stone-600">
            Order #{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}
        </span>
    </div>

    <!-- Main Detail Card -->
    <div class="bg-white border border-latte rounded-3xl p-6 sm:p-8 shadow-xs">
        <!-- Header & Status Badge -->
        <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4 pb-6 border-b border-latte">
            <div>
                <h2 class="font-serif text-3xl font-bold text-espresso mb-2">{{ $order->nama_pelanggan }}</h2>
                <div class="flex flex-wrap items-center gap-4 text-sm text-stone-600">
                    <span>
                        <i class="fas fa-clock text-caramel mr-1.5"></i> {{ $order->created_at->format('H:i, d F Y') }}
                    </span>
                    <span>
                        @if($order->table)
                            <i class="fas fa-chair text-caramel mr-1.5"></i> Meja {{ $order->table->nomor }} (Kapasitas {{ $order->table->kapasitas }} orang)
                        @else
                            <i class="fas fa-shopping-bag text-caramel mr-1.5"></i> Take Away
                        @endif
                    </span>
                </div>
            </div>

            <span class="px-4 py-2 rounded-full text-sm font-bold inline-flex items-center gap-2 self-start {{ $order->status === 'menunggu' ? 'bg-amber-100 text-amber-800' : ($order->status === 'diproses' ? 'bg-sky-100 text-sky-800' : 'bg-emerald-100 text-emerald-800') }}">
                <span class="w-2 h-2 rounded-full {{ $order->status === 'menunggu' ? 'bg-amber-600' : ($order->status === 'diproses' ? 'bg-sky-600 animate-pulse' : 'bg-emerald-600') }}"></span>
                <span>{{ ucfirst($order->status) }}</span>
            </span>
        </div>

        <!-- 3-Step Order Progress Stepper -->
        <div class="py-6 border-b border-latte">
            <div class="grid grid-cols-3 gap-3 relative">
                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-mono-num text-sm font-bold mb-2 {{ $stepIndex >= 1 ? 'bg-espresso text-gold' : 'bg-latte text-stone-500' }}">
                        @if($stepIndex > 1) <i class="fas fa-check"></i> @else 1 @endif
                    </div>
                    <p class="text-xs sm:text-sm font-bold {{ $stepIndex >= 1 ? 'text-espresso' : 'text-stone-400' }}">Menunggu</p>
                    <p class="text-[11px] text-stone-500 hidden sm:block">Pesanan masuk antrean</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-mono-num text-sm font-bold mb-2 {{ $stepIndex >= 2 ? 'bg-sky-600 text-white' : 'bg-latte text-stone-500' }}">
                        @if($stepIndex > 2) <i class="fas fa-check"></i> @else 2 @endif
                    </div>
                    <p class="text-xs sm:text-sm font-bold {{ $stepIndex >= 2 ? 'text-espresso' : 'text-stone-400' }}">Diproses</p>
                    <p class="text-[11px] text-stone-500 hidden sm:block">Sedang diracik barista</p>
                </div>

                <div class="flex flex-col items-center text-center">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-mono-num text-sm font-bold mb-2 {{ $stepIndex >= 3 ? 'bg-emerald-600 text-white' : 'bg-latte text-stone-500' }}">
                        @if($stepIndex >= 3) <i class="fas fa-check"></i> @else 3 @endif
                    </div>
                    <p class="text-xs sm:text-sm font-bold {{ $stepIndex >= 3 ? 'text-emerald-700' : 'text-stone-400' }}">Selesai</p>
                    <p class="text-[11px] text-stone-500 hidden sm:block">Lunas &amp; tersaji</p>
                </div>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="py-6">
            <h3 class="font-serif text-xl font-bold text-espresso mb-4">Item Pesanan</h3>
            <div class="overflow-x-auto border border-latte rounded-2xl">
                <table class="w-full text-sm">
                    <thead class="bg-cream text-stone-600 text-xs uppercase tracking-wider">
                        <tr>
                            <th class="text-left p-4">Menu</th>
                            <th class="text-center p-4">Qty</th>
                            <th class="text-right p-4">Harga Satuan</th>
                            <th class="text-right p-4">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-latte/70">
                        @foreach($order->items as $item)
                        <tr class="hover:bg-cream/30">
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @if($item->menu && $item->menu->foto)
                                        <img src="{{ Storage::url($item->menu->foto) }}"
                                             alt="{{ $item->menu->nama }}"
                                             onerror="this.classList.add('hidden'); this.nextElementSibling.classList.remove('hidden');"
                                             class="w-11 h-11 object-cover rounded-xl border border-latte shrink-0">
                                        <div class="hidden w-11 h-11 bg-cream rounded-xl flex items-center justify-center text-stone-400 shrink-0">
                                            <i class="fas fa-mug-hot"></i>
                                        </div>
                                    @else
                                        <div class="w-11 h-11 bg-cream rounded-xl flex items-center justify-center text-stone-400 shrink-0">
                                            <i class="fas fa-mug-hot"></i>
                                        </div>
                                    @endif
                                    <span class="font-semibold text-espresso">{{ $item->menu->nama ?? 'Menu' }}</span>
                                </div>
                            </td>
                            <td class="p-4 text-center font-mono-num font-bold text-espresso">{{ $item->qty }}</td>
                            <td class="p-4 text-right font-mono-num text-stone-600">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td class="p-4 text-right font-mono-num font-bold text-brown">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-cream border-t border-latte">
                        <tr>
                            <td colspan="3" class="p-4 text-right font-bold text-base text-espresso">Total Tagihan</td>
                            <td class="p-4 text-right font-mono-num font-bold text-2xl text-caramel">
                                Rp {{ number_format($order->total, 0, ',', '.') }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Transaction Summary if Completed -->
        @if($order->transaction)
        <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-5 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h4 class="font-bold text-emerald-800 mb-2 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>Transaksi Selesai &amp; Tercatat</span>
                </h4>
                <div class="flex flex-wrap gap-x-6 gap-y-1 text-sm text-emerald-900">
                    <p><strong>Metode:</strong> {{ $order->transaction->metode_pembayaran }}</p>
                    <p><strong>Status:</strong> {{ $order->transaction->status_pembayaran }}</p>
                    <p><strong>Waktu:</strong> {{ $order->transaction->created_at->format('H:i, d F Y') }}</p>
                </div>
            </div>
            <a href="{{ route('cashier.transaction.show', $order->transaction) }}"
               class="btn-espresso px-5 py-2.5 rounded-xl text-sm font-bold inline-flex items-center justify-center gap-2 shrink-0">
                <i class="fas fa-print text-gold"></i>
                <span>Lihat &amp; Cetak Struk</span>
            </a>
        </div>
        @endif

        <!-- Action Footer -->
        <div class="flex flex-wrap items-center gap-3 pt-2">
            <a href="{{ route('cashier.order.index') }}"
               class="px-5 py-3 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold transition inline-flex items-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>

            @if($order->status === 'menunggu')
                <form action="{{ route('cashier.order.updateStatus', $order) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="diproses">
                    <button type="submit" class="px-6 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold transition inline-flex items-center gap-2">
                        <i class="fas fa-play"></i>
                        <span>Proses Pesanan</span>
                    </button>
                </form>
            @elseif($order->status === 'diproses')
                <button type="button" onclick="openPaymentModal()" class="px-6 py-3 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold transition inline-flex items-center gap-2">
                    <i class="fas fa-cash-register"></i>
                    <span>Selesaikan &amp; Bayar</span>
                </button>
            @endif
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal"
     class="hidden fixed inset-0 bg-espresso/70 backdrop-blur-xs z-50 flex items-center justify-center p-4"
     role="dialog"
     aria-modal="true">
    <div class="bg-white border border-latte rounded-3xl max-w-lg w-full overflow-hidden shadow-2xl" onclick="event.stopPropagation()">
        <div class="bg-gradient-to-r from-roast to-espresso px-6 py-5 text-white flex items-center justify-between">
            <div>
                <p class="text-xs text-gold uppercase tracking-wider font-semibold">Penyelesaian Pembayaran</p>
                <h3 class="font-serif text-xl font-bold">{{ $order->nama_pelanggan }}</h3>
            </div>
            <button type="button" onclick="closePaymentModal()" class="text-white/70 hover:text-white p-1.5 rounded-lg" aria-label="Tutup modal">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>

        <form action="{{ route('cashier.order.updateStatus', $order) }}" method="POST" class="p-6">
            @csrf
            @method('PATCH')
            <input type="hidden" name="status" value="selesai">

            <div class="bg-cream border border-latte rounded-2xl p-4 mb-5 flex items-center justify-between">
                <span class="text-sm font-semibold text-stone-600">Total Tagihan</span>
                <span class="font-mono-num text-2xl font-bold text-brown">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
            </div>

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

            <!-- Cash Change Calculator -->
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
@endsection

@push('scripts')
<script>
    const orderTotalAmount = {{ (int) $order->total }};

    function formatRupiah(amount) {
        return 'Rp ' + Number(amount || 0).toLocaleString('id-ID');
    }

    function openPaymentModal() {
        document.getElementById('paymentModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
        toggleCashCalculator();
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
        const input = document.getElementById('cashReceivedInput');
        if (input) {
            input.value = orderTotalAmount;
            calculateChange();
        }
    }

    function setCashNominal(val) {
        const input = document.getElementById('cashReceivedInput');
        if (input) {
            input.value = val;
            calculateChange();
        }
    }

    function calculateChange() {
        const input = document.getElementById('cashReceivedInput');
        const display = document.getElementById('cashChangeDisplay');
        if (!input || !display) return;
        if (!input.value) {
            display.textContent = 'Rp 0';
            display.className = 'font-mono-num font-bold text-stone-500';
            return;
        }
        const diff = Number(input.value || 0) - orderTotalAmount;
        if (diff < 0) {
            display.textContent = 'Kurang ' + formatRupiah(Math.abs(diff));
            display.className = 'font-mono-num font-bold text-rose-600';
        } else {
            display.textContent = formatRupiah(diff);
            display.className = 'font-mono-num font-bold text-emerald-700';
        }
    }

    (function () {
        const modal = document.getElementById('paymentModal');
        if (modal) modal.addEventListener('click', closePaymentModal);
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closePaymentModal();
        });
    })();
</script>
@endpush
