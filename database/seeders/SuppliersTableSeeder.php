<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('suppliers')->delete();
        
        $data = [
            [
                'id' => 1,
                'nama' => 'PT Sepatu Nusantara',
                'kontak' => '081234567890',
                'email' => 'contact@sepatunusantara.com',
                'alamat' => 'Jl. Industri No. 1, Jakarta',
                'jumlah_cat_disupply' => 500,
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 2,
                'nama' => 'CV Maju Jaya Footwear',
                'kontak' => '081987654321',
                'email' => 'sales@majujaya.com',
                'alamat' => 'Jl. Merdeka No. 45, Bandung',
                'jumlah_cat_disupply' => 200,
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
        ];
        
        DB::table('suppliers')->insert($data);
    }
}