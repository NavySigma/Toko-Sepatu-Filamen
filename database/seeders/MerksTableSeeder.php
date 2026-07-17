<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MerksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('merks')->delete();
        
        $data = [
            [
                'id' => 1,
                'nama' => 'Nike',
                'deskripsi' => 'Brand Nike',
                'created_at' => '2026-07-15 08:14:41',
                'updated_at' => '2026-07-15 08:14:41',
            ],
            [
                'id' => 2,
                'nama' => 'Adidas',
                'deskripsi' => 'Brand Adidas',
                'created_at' => '2026-07-15 08:14:41',
                'updated_at' => '2026-07-15 08:14:41',
            ],
            [
                'id' => 3,
                'nama' => 'Puma',
                'deskripsi' => 'Brand Puma',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 4,
                'nama' => 'New Balance',
                'deskripsi' => 'Brand New Balance',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 5,
                'nama' => 'Converse',
                'deskripsi' => 'Brand Converse',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 6,
                'nama' => 'Vans',
                'deskripsi' => 'Brand Vans',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 7,
                'nama' => 'Reebok',
                'deskripsi' => 'Brand Reebok',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 8,
                'nama' => 'Asics',
                'deskripsi' => 'Brand Asics',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 9,
                'nama' => 'Skechers',
                'deskripsi' => 'Brand Skechers',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
            [
                'id' => 10,
                'nama' => 'Dr. Martens',
                'deskripsi' => 'Brand Dr. Martens',
                'created_at' => '2026-07-15 08:14:42',
                'updated_at' => '2026-07-15 08:14:42',
            ],
        ];
        
        DB::table('merks')->insert($data);
    }
}