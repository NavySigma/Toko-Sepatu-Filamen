<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PelanggansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pelanggans')->delete();
        
        $data = [
            [
                'id' => 1,
                'nama' => 'Budi Santoso',
                'kontak' => '085612341234',
                'email' => 'budi@example.com',
                'alamat' => 'Jl. Mawar No. 12, Surabaya',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 2,
                'nama' => 'Siti Aminah',
                'kontak' => '082211223344',
                'email' => 'siti@example.com',
                'alamat' => 'Jl. Melati No. 5, Malang',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
        ];
        
        DB::table('pelanggans')->insert($data);
    }
}