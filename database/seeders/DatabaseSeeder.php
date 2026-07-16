<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed roles & permissions first
        $this->call([
            RoleSeeder::class,
            BarangSeeder::class,
            MasterDataSeeder::class,
            PembelianSeeder::class,
            TransaksiSeeder::class,
        ]);

        // ─── Super Admin ─────────────────────────────────────────────
        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123'),
        ]);
        $admin->assignRole('super_admin');

        // ─── Kasir ───────────────────────────────────────────────────
        $kasir = User::factory()->create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@gmail.com',
            'password' => bcrypt('123'),
        ]);
        $kasir->assignRole('admin_kasir');

        // ─── Customer ────────────────────────────────────────────────
        $customer = User::factory()->create([
            'name' => 'Budi Customer',
            'email' => 'customer@gmail.com',
            'password' => bcrypt('123'),
        ]);
        $customer->assignRole('customer');
    }
}
