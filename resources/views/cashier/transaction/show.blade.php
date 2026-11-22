@extends('layouts.cashier')

@section('title', 'Struk Transaksi - Kopi Paste')
@section('page-title', 'Detail Transaksi & Struk')

@push('styles')
<style>
    .struk {
        font-family: 'JetBrains Mono', 'Courier New', Courier, monospace;
    }

    @media print {
        body {
            background: #ffffff !important;
            font-size: 12px;
        }

        main {
            padding: 0 !important;
            overflow: visible !important;
        }

        .struk {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .receipt-card {
            box-shadow: none !important;
            border: none !important;
            padding: 12px !important;
        }
    }
</style>
@endpush

@section('content')
<div class="struk max-w-lg mx-auto">
    <div class="receipt-card bg-white border border-latte rounded-3xl shadow-lg p-6 sm:p-8">
        <!-- Brand Header -->
        <div class="text-center pb-5 mb-5 border-b-2 border-dashed border-stone-300">
            <div class="w-12 h-12 rounded-2xl bg-espresso text-gold flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-mug-hot text-xl"></i>
            </div>
            <h2 class="text-2xl font-bold tracking-wider text-espresso">KOPI PASTE</h2>
            <p class="text-xs text-stone-500 mt-1">Jl. Kopi No. 123, Medan, Sumatera Utara</p>
            <p class="text-xs text-stone-500">Telp: 0812-3456-7890</p>
        </div>

        <!-- Receipt Metadata -->
        <div class="grid grid-cols-2 gap-3 text-xs sm:text-sm pb-5 mb-5 border-b border-dashed border-stone-300">
            <div>
                <p class="text-stone-400 text-[11px] uppercase">No. Transaksi</p>
                <p class="font-bold text-espresso">#{{ str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="text-right">
                <p class="text-stone-400 text-[11px] uppercase">Tanggal</p>
                <p class="font-bold text-espresso">{{ $transaction->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-stone-400 text-[11px] uppercase">Pelanggan</p>
                <p class="font-bold text-espresso">{{ $transaction->order->nama_pelanggan }}</p>
            </div>
            <div class="text-right">
                <p class="text-stone-400 text-[11px] uppercase">Layanan</p>
                <p class="font-bold text-espresso">
                    @if($transaction->order->table)
                        Meja {{ $transaction->order->table->nomor }}
                    @else
                        Take Away
                    @endif
                </p>
            </div>
        </div>

        <!-- Items -->
        <div class="mb-5">
            <table class="w-full text-xs sm:text-sm">
                <thead class="border-b border-stone-300 text-stone-500 text-[11px] uppercase">
                    <tr>
                        <th class="text-left py-2 pr-2">Item</th>
                        <th class="text-center py-2 px-2">Qty</th>
                        <th class="hidden sm:table-cell print:table-cell text-right py-2 px-2">Harga</th>
                        <th class="text-right py-2 pl-2">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach($transaction->order->items as $item)
                    <tr>
                        <td class="py-2.5 pr-2 font-semibold text-espresso">
                            <span>{{ $item->menu->nama ?? 'Menu' }}</span>
                            <span class="block sm:hidden print:hidden text-[11px] text-stone-500 font-normal mt-0.5">
                                @ Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="py-2.5 px-2 text-center whitespace-nowrap">{{ $item->qty }}</td>
                        <td class="hidden sm:table-cell print:table-cell py-2.5 px-2 text-right text-stone-600 whitespace-nowrap">Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                        <td class="py-2.5 pl-2 text-right font-bold text-espresso whitespace-nowrap">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Summary -->
        <div class="border-t-2 border-dashed border-stone-300 pt-4 mb-6 space-y-2 text-xs sm:text-sm">
            <div class="flex justify-between items-center text-lg sm:text-xl font-bold text-espresso pb-2">
                <span>TOTAL</span>
                <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-stone-500">Metode Pembayaran</span>
                <span class="font-bold text-espresso">{{ $transaction->metode_pembayaran }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-stone-500">Status Pembayaran</span>
                <span class="px-2.5 py-0.5 bg-emerald-100 text-emerald-800 rounded-md font-bold text-xs">
                    {{ $transaction->status_pembayaran }}
                </span>
            </div>
        </div>

        <!-- Receipt Footer -->
        <div class="text-center pt-5 border-t border-dashed border-stone-300 text-xs text-stone-500 space-y-1">
            <p>Kasir: <strong class="text-espresso">{{ auth()->user()->name ?? 'Kasir' }}</strong></p>
            <p class="font-semibold text-espresso pt-1">Terima kasih atas kunjungan Anda!</p>
            <p>Sampai jumpa kembali di Kopi Paste</p>
        </div>

        <!-- Actions (Hidden on Print) -->
        <div class="no-print font-sans flex gap-3 mt-7 pt-5 border-t border-latte">
            <a href="{{ route('cashier.transaction.index') }}"
               class="flex-1 py-3 px-4 rounded-xl bg-stone-100 hover:bg-stone-200 text-espresso text-sm font-semibold text-center transition inline-flex items-center justify-center gap-2">
                <i class="fas fa-arrow-left text-xs"></i>
                <span>Kembali</span>
            </a>
            <button type="button"
                    onclick="window.print()"
                    class="flex-1 btn-gold py-3 px-4 rounded-xl text-sm font-bold inline-flex items-center justify-center gap-2">
                <i class="fas fa-print"></i>
                <span>Cetak Struk</span>
            </button>
        </div>
    </div>
</div>
@endsection
