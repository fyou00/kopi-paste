<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['order.items.menu', 'order.table']);

        // Filter by date range
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('created_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        } elseif ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        } else {
            // Default: show today's transactions
            $query->whereDate('created_at', today());
        }

        // Filter by payment method
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Filter by payment status
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        // Search by customer name
        if ($request->filled('search')) {
            $query->whereHas('order', function ($q) use ($request) {
                $q->where('nama_pelanggan', 'like', '%' . $request->search . '%');
            });
        }

        $transactions = $query->latest()->paginate(20);

        // Statistics
        $totalTransaksi = $query->count();
        $totalPendapatan = $query->sum('total');
        $totalHariIni = Transaction::whereDate('created_at', today())->sum('total');
        $totalBulanIni = Transaction::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');

        // Payment method breakdown
        $paymentMethodStats = Transaction::whereDate('created_at', today())
            ->select('metode_pembayaran', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        return view('cashier.transaction.index', compact(
            'transactions',
            'totalTransaksi',
            'totalPendapatan',
            'totalHariIni',
            'totalBulanIni',
            'paymentMethodStats'
        ));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['order.items.menu', 'order.table']);
        return view('cashier.transaction.show', compact('transaction'));
    }

    public function print(Transaction $transaction)
    {
        $transaction->load(['order.items.menu', 'order.table']);
        return view('cashier.transaction.print', compact('transaction'));
    }

    public function report(Request $request)
    {
        $startDate = $request->filled('start_date') ? $request->start_date : now()->startOfMonth()->format('Y-m-d');
        $endDate = $request->filled('end_date') ? $request->end_date : now()->endOfMonth()->format('Y-m-d');

        $transactions = Transaction::with(['order.items.menu'])
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->get();

        // Summary
        $totalTransaksi = $transactions->count();
        $totalPendapatan = $transactions->sum('total');

        // Daily breakdown
        $dailyStats = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Top menus
        $topMenus = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('transactions', 'orders.id', '=', 'transactions.order_id')
            ->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select('menus.nama', 'menus.kategori', DB::raw('SUM(order_items.qty) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_sales'))
            ->groupBy('menus.id', 'menus.nama', 'menus.kategori')
            ->orderBy('total_sales', 'desc')
            ->take(10)
            ->get();

        // Payment method breakdown
        $paymentStats = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->select('metode_pembayaran', DB::raw('COUNT(*) as count'), DB::raw('SUM(total) as total'))
            ->groupBy('metode_pembayaran')
            ->get();

        return view('cashier.transaction.report', compact(
            'startDate',
            'endDate',
            'totalTransaksi',
            'totalPendapatan',
            'dailyStats',
            'topMenus',
            'paymentStats'
        ));
    }
}