<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pembelian;
use App\Models\PembelianItem;
use App\Models\Supplier;
use App\Models\Barang;
use Faker\Factory as Faker;

class PembelianSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $suppliers = Supplier::all();
        $barangs = Barang::all();

        if ($suppliers->isEmpty() || $barangs->isEmpty()) {
            $this->command->warn('Seeder butuh Supplier dan Barang. Silakan jalankan MasterDataSeeder dulu.');
            return;
        }

        // Create 15 Random Pembelians
        for ($i = 0; $i < 15; $i++) {
            $supplier = $suppliers->random();
            
            $pembelian = Pembelian::create([
                'nomor_po' => 'PO-' . date('Ymd') . '-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'supplier_id' => $supplier->id,
                'tanggal_pembelian' => $faker->dateTimeBetween('-6 months', 'now'),
                'status' => $faker->randomElement(['Selesai', 'Proses', 'Batal']),
                'catatan' => $faker->sentence(6),
                'total_harga' => 0,
            ]);

            $totalHarga = 0;
            $itemsCount = rand(1, 4);
            $selectedBarangs = $barangs->random($itemsCount);

            foreach ($selectedBarangs as $barang) {
                $kuantitas = rand(5, 50);
                // Beli harga grosir (misal lebih murah 30% dari harga jual)
                $hargaBeli = $barang->harga * 0.7; 
                $subtotal = $hargaBeli * $kuantitas;

                PembelianItem::create([
                    'pembelian_id' => $pembelian->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $kuantitas,
                    'harga_beli' => $hargaBeli,
                    'subtotal' => $subtotal,
                ]);

                $totalHarga += $subtotal;
            }

            $pembelian->update(['total_harga' => $totalHarga]);
        }
    }
}
