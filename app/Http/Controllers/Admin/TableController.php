<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    public function index(Request $request)
    {
        $query = Table::query();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by number
        if ($request->filled('search')) {
            $query->where('nomor', 'like', '%' . $request->search . '%');
        }

        $tables = $query->orderBy('nomor')->paginate(20);

        // Statistics
        $totalTables = Table::count();
        $tableTersedia = Table::tersedia()->count();
        $tableTerisi = Table::terisi()->count();

        return view('admin.table.index', compact('tables', 'totalTables', 'tableTersedia', 'tableTerisi'));
    }

    public function create()
    {
        return view('admin.table.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor' => 'required|integer|unique:tables,nomor|min:1',
            'kapasitas' => 'required|integer|min:1|max:50',
            'status' => 'required|in:tersedia,terisi,reserved'
        ]);

        Table::create($validated);

        return redirect()->route('admin.table.index')
            ->with('success', 'Meja berhasil ditambahkan');
    }

    public function edit(Table $table)
    {
        return view('admin.table.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $validated = $request->validate([
            'nomor' => 'required|integer|unique:tables,nomor,' . $table->id . '|min:1',
            'kapasitas' => 'required|integer|min:1|max:50',
            'status' => 'required|in:tersedia,terisi,reserved'
        ]);

        $table->update($validated);

        return redirect()->route('admin.table.index')
            ->with('success', 'Meja berhasil diupdate');
    }

    public function destroy(Table $table)
    {
        // Check if table has active orders
        $activeOrders = $table->orders()->whereIn('status', ['menunggu', 'diproses'])->count();
        
        if ($activeOrders > 0) {
            return back()->with('error', 'Meja tidak dapat dihapus karena masih memiliki pesanan aktif');
        }

        $table->delete();

        return redirect()->route('admin.table.index')
            ->with('success', 'Meja berhasil dihapus');
    }

    public function updateStatus(Request $request, Table $table)
    {
        $validated = $request->validate([
            'status' => 'required|in:tersedia,terisi,reserved'
        ]);

        $table->update($validated);

        return back()->with('success', 'Status meja berhasil diupdate');
    }

    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:tables,id',
            'status' => 'required|in:tersedia,terisi,reserved'
        ]);

        Table::whereIn('id', $request->ids)->update(['status' => $request->status]);

        return redirect()->route('admin.table.index')
            ->with('success', 'Status meja yang dipilih berhasil diupdate');
    }
}