<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\TransaksiItem;
use App\Models\Pelanggan;
use App\Models\Barang;
use App\Models\User;
use Faker\Factory as Faker;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $pelanggans = Pelanggan::all();
        $barangs = Barang::all();
        $kasir = User::role('admin_kasir')->first() ?? User::first();

        if ($pelanggans->isEmpty() || $barangs->isEmpty() || !$kasir) {
            $this->command->warn('Seeder butuh Pelanggan, Barang, dan User Kasir. Silakan jalankan MasterDataSeeder dulu.');
            return;
        }

        // Create 20 Random Transaksi (Penjualan)
        for ($i = 0; $i < 20; $i++) {
            $pelanggan = $pelanggans->random();
            
            $transaksi = Transaksi::create([
                'nomor_invoice' => Transaksi::generateInvoice(),
                'user_id' => $kasir->id,
                'pelanggan_id' => $pelanggan->id,
                'tanggal_transaksi' => $faker->dateTimeBetween('-3 months', 'now'),
                'metode_pembayaran' => $faker->randomElement(['tunai', 'transfer', 'qris', 'kartu_debit', 'kartu_kredit']),
                'status' => $faker->randomElement(['selesai', 'pending', 'dibatalkan']),
                'catatan' => $faker->optional(0.3)->sentence(),
                'total_harga' => 0,
            ]);

            $totalHarga = 0;
            $itemsCount = rand(1, 3);
            $selectedBarangs = $barangs->random($itemsCount);

            foreach ($selectedBarangs as $barang) {
                $kuantitas = rand(1, 3); // Jual 1 sampai 3 sepatu per item
                $hargaSatuan = $barang->harga; 
                $subtotal = $hargaSatuan * $kuantitas;

                TransaksiItem::create([
                    'transaksi_id' => $transaksi->id,
                    'barang_id' => $barang->id,
                    'jumlah' => $kuantitas, // Assuming the column is 'jumlah' instead of 'kuantitas'
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal,
                ]);

                $totalHarga += $subtotal;
            }

            $transaksi->update(['total_harga' => $totalHarga]);
        }
    }
}
