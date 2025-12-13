<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistics
        $totalMenus = Menu::count();
        $menuTersedia = Menu::tersedia()->count();
        $menuTidakTersedia = Menu::where('status', 'tidak tersedia')->count();
        
        $totalTables = Table::count();
        $tableTersedia = Table::tersedia()->count();
        $tableTerisi = Table::terisi()->count();
        
        $totalPesananAktif = Order::whereIn('status', ['menunggu', 'diproses'])->count();
        $pesananMenunggu = Order::menunggu()->count();
        $pesananDiproses = Order::diproses()->count();
        
        // Transactions today
        $transaksiHariIni = Transaction::whereDate('created_at', today())->count();
        $totalPendapatanHariIni = Transaction::whereDate('created_at', today())->sum('total');
        
        // Transactions this month
        $transaksiBulanIni = Transaction::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->count();
        $totalPendapatanBulanIni = Transaction::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->sum('total');
        
        // Recent orders
        $recentOrders = Order::with(['items.menu', 'table'])
            ->whereIn('status', ['menunggu', 'diproses'])
            ->latest()
            ->take(5)
            ->get();
        
        // Top selling menus this month
        $topMenus = DB::table('order_items')
            ->join('menus', 'order_items.menu_id', '=', 'menus.id')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereYear('orders.created_at', now()->year)
            ->whereMonth('orders.created_at', now()->month)
            ->select('menus.nama', DB::raw('SUM(order_items.qty) as total_qty'), DB::raw('SUM(order_items.subtotal) as total_sales'))
            ->groupBy('menus.id', 'menus.nama')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalMenus',
            'menuTersedia',
            'menuTidakTersedia',
            'totalTables',
            'tableTersedia',
            'tableTerisi',
            'totalPesananAktif',
            'pesananMenunggu',
            'pesananDiproses',
            'transaksiHariIni',
            'totalPendapatanHariIni',
            'transaksiBulanIni',
            'totalPendapatanBulanIni',
            'recentOrders',
            'topMenus'
        ));
    }
}