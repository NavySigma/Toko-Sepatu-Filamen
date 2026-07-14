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
        ]);

        // ─── Kasir ───────────────────────────────────────────────────
        $kasir = User::factory()->create([
            'name' => 'Kasir Toko',
            'email' => 'kasir@tokosepatu.com',
        ]);
        $kasir->assignRole('admin_kasir');

        // ─── Customer ────────────────────────────────────────────────
        $customer = User::factory()->create([
            'name' => 'Budi Customer',
            'email' => 'customer@tokosepatu.com',
        ]);
        $customer->assignRole('customer');
    }
}
