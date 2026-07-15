<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $items = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $barang = Barang::find($id);
            if ($barang) {
                $subtotal = $barang->harga * $item['qty'];
                $items[] = [
                    'barang' => $barang,
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('items', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);

        if ($barang->stok < $request->qty) {
            return back()->with('error', 'Stok tidak mencukupi.');
        }

        $cart = session()->get('cart', []);
        $id = $request->barang_id;

        if (isset($cart[$id])) {
            $newQty = $cart[$id]['qty'] + $request->qty;
            if ($newQty > $barang->stok) {
                return back()->with('error', 'Jumlah melebihi stok tersedia.');
            }
            $cart[$id]['qty'] = $newQty;
        } else {
            $cart[$id] = ['qty' => $request->qty];
        }

        session()->put('cart', $cart);
        return back()->with('success', "{$barang->nama} ditambahkan ke keranjang!");
    }

    public function update(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|integer|min:1',
        ]);

        $barang = Barang::findOrFail($request->barang_id);
        $cart = session()->get('cart', []);

        if ($request->qty > $barang->stok) {
            return back()->with('error', 'Jumlah melebihi stok tersedia.');
        }

        $cart[$request->barang_id]['qty'] = $request->qty;
        session()->put('cart', $cart);

        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove(Request $request)
    {
        $cart = session()->get('cart', []);
        unset($cart[$request->barang_id]);
        session()->put('cart', $cart);

        return back()->with('success', 'Item dihapus dari keranjang.');
    }
}
