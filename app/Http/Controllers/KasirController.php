<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    public function index(Request $request)
    {
        $query = Barang::query()->where('stok', '>', 0);

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhereHas('merk', function ($q) use ($request) {
                      $q->where('nama', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori', $request->kategori);
        }

        $products = $query->get();
        $categories = Barang::select('kategori')->distinct()->pluck('kategori');

        return view('kasir.index', compact('products', 'categories'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'metode_pembayaran' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:barangs,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $transaksi = Transaksi::create([
                'nomor_invoice' => Transaksi::generateInvoice(),
                'tanggal_transaksi' => now(),
                'nama_pelanggan' => $request->nama_pelanggan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'status' => 'selesai',
                'user_id' => auth()->id(), // Record the cashier who made the transaction
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $barang = Barang::findOrFail($item['id']);
                
                if ($barang->stok < $item['qty']) {
                    throw new \Exception("Stok {$barang->nama} tidak mencukupi.");
                }

                $subtotal = $barang->harga * $item['qty'];
                $total += $subtotal;

                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $item['qty'],
                    'harga_satuan' => $barang->harga,
                    'subtotal' => $subtotal,
                ]);

                $barang->decrement('stok', $item['qty']);
            }

            $transaksi->update(['total_harga' => $total]);

            DB::commit();

            return response()->json([
                'success' => true, 
                'invoice' => $transaksi->nomor_invoice,
                'total' => $total
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 422);
        }
    }
}
