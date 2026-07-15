<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Keranjang kosong.');
        }

        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $barang = Barang::find($id);
            if ($barang) {
                $subtotal = $barang->harga * $item['qty'];
                $items[] = ['barang' => $barang, 'qty' => $item['qty'], 'subtotal' => $subtotal];
                $total += $subtotal;
            }
        }

        return view('checkout.index', compact('items', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'metode_pembayaran' => 'required|in:tunai,transfer,qris,kartu_debit,kartu_kredit',
            'catatan' => 'nullable|string|max:500',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect('/cart')->with('error', 'Keranjang kosong.');
        }

        try {
            DB::beginTransaction();

            $transaksi = Transaksi::create([
                'nomor_invoice' => Transaksi::generateInvoice(),
                'user_id' => Auth::id(),
                'nama_pelanggan' => Auth::user()->name,
                'tanggal_transaksi' => now(),
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'pending',
                'total_harga' => 0,
                'catatan' => $request->catatan,
            ]);

            $totalHarga = 0;
            foreach ($cart as $id => $item) {
                $barang = Barang::findOrFail($id);

                if ($barang->stok < $item['qty']) {
                    throw new \Exception("Stok {$barang->nama} tidak mencukupi.");
                }

                $subtotal = $barang->harga * $item['qty'];
                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['qty'],
                    'harga_satuan' => $barang->harga,
                    'subtotal' => $subtotal,
                ]);

                $barang->decrement('stok', $item['qty']);
                $totalHarga += $subtotal;
            }

            $transaksi->update(['total_harga' => $totalHarga]);
            session()->forget('cart');

            DB::commit();

            return redirect("/orders/{$transaksi->id}")->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }
}
