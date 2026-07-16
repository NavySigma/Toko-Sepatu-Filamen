<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhereHas('merk', function ($q) use ($search) {
                      $q->where('nama', 'like', "%{$search}%");
                  })
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori', $kategori);
        }

        if ($merk = $request->input('merk')) {
            $query->whereHas('merk', function ($q) use ($merk) {
                $q->where('nama', $merk);
            });
        }

        if ($warna = $request->input('warna')) {
            $query->where('warna', $warna);
        }

        $sort = $request->input('sort', 'terbaru');
        switch ($sort) {
            case 'harga_asc':
                $query->orderBy('harga', 'asc');
                break;
            case 'harga_desc':
                $query->orderBy('harga', 'desc');
                break;
            case 'nama':
                $query->orderBy('nama', 'asc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        $categories = Barang::select('kategori')->distinct()->pluck('kategori');
        $brands = \App\Models\Merk::whereHas('barangs')->pluck('nama');
        $colors = Barang::select('warna')->distinct()->pluck('warna');

        return view('products.index', compact('products', 'categories', 'brands', 'colors'));
    }

    public function show(Barang $barang)
    {
        $relatedProducts = Barang::where('kategori', $barang->kategori)
            ->where('id', '!=', $barang->id)
            ->where('stok', '>', 0)
            ->take(4)
            ->get();

        return view('products.show', ['product' => $barang, 'relatedProducts' => $relatedProducts]);
    }
}
