<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\Menu;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Order statistics
        $pesananMenunggu = Order::menunggu()->count();
        $pesananDiproses = Order::diproses()->count();
        $totalPesananAktif = $pesananMenunggu + $pesananDiproses;
        
        // Transaction statistics today
        $transaksiHariIni = Transaction::whereDate('created_at', today())->count();
        $totalPendapatanHariIni = Transaction::whereDate('created_at', today())->sum('total');
        
        // Recent orders
        $recentOrders = Order::with(['items.menu', 'table'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->latest()
            ->take(10)
            ->get();
        
        // Available tables
        $tableTersedia = Table::tersedia()->count();
        $tableTerisi = Table::terisi()->count();
        
        // Popular menus today
        $popularMenusToday = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereDate('orders.created_at', today())
            ->select('menus.nama', 'menus.foto', DB::raw('SUM(order_items.qty) as total_qty'))
            ->groupBy('menus.id', 'menus.nama', 'menus.foto')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        return view('cashier.dashboard', compact(
            'pesananMenunggu',
            'pesananDiproses',
            'totalPesananAktif',
            'transaksiHariIni',
            'totalPendapatanHariIni',
            'recentOrders',
            'tableTersedia',
            'tableTerisi',
            'popularMenusToday'
        ));
    }
}