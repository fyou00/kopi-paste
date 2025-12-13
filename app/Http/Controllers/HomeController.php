<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Get featured menus (bisa diambil random atau berdasarkan kategori tertentu)
        $featuredMenus = Menu::tersedia()->take(6)->get();
        
        return view('home', compact('featuredMenus'));
    }

    public function about()
    {
        return view('about');
    }
}
