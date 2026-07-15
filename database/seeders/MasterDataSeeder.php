<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Pelanggan;
use App\Models\Supplier;
use App\Models\Pembelian;
use App\Models\PembelianItem;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Suppliers
        $supplier1 = Supplier::firstOrCreate(
            ['nama' => 'PT Sepatu Nusantara'],
            ['kontak' => '081234567890', 'email' => 'contact@sepatunusantara.com', 'alamat' => 'Jl. Industri No. 1, Jakarta', 'jumlah_cat_disupply' => 500]
        );
        $supplier2 = Supplier::firstOrCreate(
            ['nama' => 'CV Maju Jaya Footwear'],
            ['kontak' => '081987654321', 'email' => 'sales@majujaya.com', 'alamat' => 'Jl. Merdeka No. 45, Bandung', 'jumlah_cat_disupply' => 200]
        );

        // 2. Seed Pelanggan
        $pelanggan1 = Pelanggan::firstOrCreate(
            ['nama' => 'Budi Santoso'],
            ['kontak' => '085612341234', 'email' => 'budi@example.com', 'alamat' => 'Jl. Mawar No. 12, Surabaya']
        );
        $pelanggan2 = Pelanggan::firstOrCreate(
            ['nama' => 'Siti Aminah'],
            ['kontak' => '082211223344', 'email' => 'siti@example.com', 'alamat' => 'Jl. Melati No. 5, Malang']
        );

        // Get an Admin/Kasir user
        $kasir = User::role('super_admin')->first() ?? User::first();
        if (!$kasir) return;

        // Get some products
        $barang1 = Barang::inRandomOrder()->first();
        $barang2 = Barang::inRandomOrder()->where('id', '!=', $barang1->id)->first();

        if ($barang1 && $barang2) {
            // 3. Seed Pembelian (Restock)
            $pembelian = Pembelian::create([
                'nomor_po' => 'PO-' . date('Ymd') . '-0001',
                'supplier_id' => $supplier1->id,
                'tanggal_pembelian' => now(),
                'total_harga' => ($barang1->harga * 10) + ($barang2->harga * 5),
                'status' => 'Selesai',
                'catatan' => 'Restock awal bulan',
            ]);

            PembelianItem::create([
                'pembelian_id' => $pembelian->id,
                'barang_id' => $barang1->id,
                'kuantitas' => 10,
                'harga_beli' => $barang1->harga, // Assuming beli is same as jual for demo
                'subtotal' => $barang1->harga * 10,
            ]);

            PembelianItem::create([
                'pembelian_id' => $pembelian->id,
                'barang_id' => $barang2->id,
                'kuantitas' => 5,
                'harga_beli' => $barang2->harga,
                'subtotal' => $barang2->harga * 5,
            ]);

            // Add stock to barangs
            $barang1->increment('stok', 10);
            $barang2->increment('stok', 5);


            // 4. Seed Transaksi (Penjualan)
            $transaksi = Transaksi::create([
                'nomor_invoice' => Transaksi::generateInvoice(),
                'user_id' => $kasir->id,
                'pelanggan_id' => $pelanggan1->id,
                'tanggal_transaksi' => now(),
                'metode_pembayaran' => 'Cash',
                'status' => 'Lunas',
                'total_harga' => $barang1->harga * 1,
                'catatan' => 'Pembelian di toko',
            ]);

            TransaksiItem::create([
                'transaksi_id' => $transaksi->id,
                'barang_id' => $barang1->id,
                'kuantitas' => 1,
                'harga_satuan' => $barang1->harga,
                'subtotal' => $barang1->harga * 1,
            ]);

            $barang1->decrement('stok', 1);
        }
    }
}
