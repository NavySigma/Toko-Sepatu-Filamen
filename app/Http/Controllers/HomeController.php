<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Barang::where('stok', '>', 0)
            ->latest()
            ->take(8)
            ->get();

        $categories = Barang::select('kategori')
            ->distinct()
            ->pluck('kategori');

        $brands = Barang::select('merk')
            ->distinct()
            ->pluck('merk');

        return view('home', compact('featuredProducts', 'categories', 'brands'));
    }
}
