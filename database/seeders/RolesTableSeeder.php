<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();
        
        $data = [
            [
                'id' => 1,
                'name' => 'admin_kasir',
                'guard_name' => 'web',
                'created_at' => '2026-07-15 08:14:41',
                'updated_at' => '2026-07-15 08:14:41',
            ],
            [
                'id' => 2,
                'name' => 'customer',
                'guard_name' => 'web',
                'created_at' => '2026-07-15 08:14:41',
                'updated_at' => '2026-07-15 08:14:41',
            ],
            [
                'id' => 3,
                'name' => 'super_admin',
                'guard_name' => 'web',
                'created_at' => '2026-07-15 08:14:41',
                'updated_at' => '2026-07-15 08:14:41',
            ],
            [
                'id' => 4,
                'name' => 'super_admin',
                'guard_name' => 'admin',
                'created_at' => '2026-07-15 08:15:15',
                'updated_at' => '2026-07-15 08:15:15',
            ],
        ];
        
        DB::table('roles')->insert($data);
    }
}