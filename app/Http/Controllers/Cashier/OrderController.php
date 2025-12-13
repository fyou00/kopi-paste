<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Table;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['items.menu', 'table']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: show only active orders
            $query->whereIn('status', ['menunggu', 'diproses']);
        }

        // Search by customer name
        if ($request->filled('search')) {
            $query->where('nama_pelanggan', 'like', '%' . $request->search . '%');
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $orders = $query->latest()->paginate(20);

        // Statistics for current view
        $totalOrders = $query->count();
        $totalPendapatan = $query->sum('total');

        return view('cashier.order.index', compact('orders', 'totalOrders', 'totalPendapatan'));
    }

    public function create()
    {
        $menus = Menu::tersedia()->orderBy('kategori')->orderBy('nama')->get();
        $menusByCategory = $menus->groupBy('kategori');
        $tables = Table::tersedia()->orderBy('nomor')->get();

        return view('cashier.order.create', compact('menusByCategory', 'tables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'table_id' => 'nullable|exists:tables,id',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1',
            'catatan' => 'nullable|string|max:500'
        ]);

        // Verify table is available if selected
        if ($validated['table_id']) {
            $table = Table::find($validated['table_id']);
            if ($table->status !== 'tersedia') {
                return back()->with('error', 'Meja yang dipilih tidak tersedia')->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // Calculate total
            $total = 0;
            foreach ($validated['items'] as $item) {
                $menu = Menu::find($item['menu_id']);
                
                // Check if menu is available
                if ($menu->status !== 'tersedia') {
                    throw new \Exception("Menu {$menu->nama} tidak tersedia");
                }
                
                $total += $menu->harga * $item['qty'];
            }

            // Create order
            $order = Order::create([
                'nama_pelanggan' => $validated['nama_pelanggan'],
                'table_id' => $validated['table_id'] ?? null,
                'status' => 'menunggu',
                'total' => $total,
                'waktu' => now()
            ]);

            // Create order items
            foreach ($validated['items'] as $item) {
                $menu = Menu::find($item['menu_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'qty' => $item['qty'],
                    'harga' => $menu->harga,
                ]);
            }

            DB::commit();

            return redirect()->route('cashier.order.show', $order)
                ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load(['items.menu', 'table', 'transaction']);
        return view('cashier.order.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai',
            'metode_pembayaran' => 'required_if:status,selesai|in:Tunai,Transfer,QRIS,Kartu Debit/Kredit'
        ]);

        DB::beginTransaction();
        try {
            $order->update(['status' => $validated['status']]);

            // If status is selesai, create transaction
            if ($validated['status'] === 'selesai') {
                Transaction::create([
                    'order_id' => $order->id,
                    'metode_pembayaran' => $validated['metode_pembayaran'],
                    'status_pembayaran' => 'Lunas',
                    'total' => $order->total,
                ]);
            }

            DB::commit();

            $message = 'Status pesanan berhasil diupdate';
            if ($validated['status'] === 'selesai') {
                $message .= ' dan transaksi telah dicatat';
            }

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal update status: ' . $e->getMessage());
        }
    }

    public function destroy(Order $order)
    {
        // Only allow deleting orders that are not completed
        if ($order->status === 'selesai') {
            return back()->with('error', 'Pesanan yang sudah selesai tidak dapat dihapus');
        }

        DB::beginTransaction();
        try {
            $order->delete();
            DB::commit();

            return redirect()->route('cashier.order.index')
                ->with('success', 'Pesanan berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus pesanan: ' . $e->getMessage());
        }
    }

    public function print(Order $order)
    {
        $order->load(['items.menu', 'table']);
        return view('cashier.order.print', compact('order'));
    }
}