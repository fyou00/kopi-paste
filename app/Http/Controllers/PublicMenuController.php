<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class PublicMenuController extends Controller
{
    public function index()
    {
        // Group menus by category
        $menus = Menu::tersedia()->orderBy('kategori')->orderBy('nama')->get();
        $menusByCategory = $menus->groupBy('kategori');
        
        // Get all unique categories
        $categories = Menu::select('kategori')->distinct()->orderBy('kategori')->pluck('kategori');
        
        return view('menu.public', compact('menusByCategory', 'categories'));
    }
}