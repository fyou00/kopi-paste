<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $query = Menu::query();

        // Filter by category
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $menus = $query->latest()->paginate(15);
        $categories = Menu::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');

        return view('admin.menu.index', compact('menus', 'categories'));
    }

    public function create()
    {
        $categories = Menu::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $validated['foto'] = $file->storeAs('menus', $filename, 'public');
        }

        Menu::create($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function show(Menu $menu)
    {
        $menu->load('orderItems.order');
        return view('admin.menu.show', compact('menu'));
    }

    public function edit(Menu $menu)
    {
        $categories = Menu::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        return view('admin.menu.edit', compact('menu', 'categories'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:255',
            'harga' => 'required|integer|min:0',
            'status' => 'required|in:tersedia,tidak tersedia',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('foto')) {
            // Delete old photo
            if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
                Storage::disk('public')->delete($menu->foto);
            }
            
            $file = $request->file('foto');
            $filename = time() . '_' . Str::slug($request->nama) . '.' . $file->getClientOriginalExtension();
            $validated['foto'] = $file->storeAs('menus', $filename, 'public');
        }

        $menu->update($validated);

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil diupdate');
    }

    public function destroy(Menu $menu)
    {
        // Check if menu has orders
        if ($menu->orderItems()->count() > 0) {
            return back()->with('error', 'Menu tidak dapat dihapus karena sudah memiliki riwayat pesanan');
        }

        // Delete photo
        if ($menu->foto && Storage::disk('public')->exists($menu->foto)) {
            Storage::disk('public')->delete($menu->foto);
        }

        $menu->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu berhasil dihapus');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:menus,id'
        ]);

        Menu::whereIn('id', $request->ids)->delete();

        return redirect()->route('admin.menu.index')
            ->with('success', 'Menu yang dipilih berhasil dihapus');
    }
}
