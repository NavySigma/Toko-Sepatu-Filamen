<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        
        $data = [
            [
                'id' => 1,
                'name' => 'Super Admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => '2026-07-15 08:14:43',
                'password' => '$2y$12$PDec2cKAv5F4GXt07Eu5l.EZ2SjPn6OTcGLJRq0Q6CB2abgA/XzIK',
                'remember_token' => 'g12axImA6FBNImlI7jGZF8xjSkwRSrhMu32R7NzmtwLvesCNcBVahTHUsVd4',
                'created_at' => '2026-07-15 08:14:43',
                'updated_at' => '2026-07-15 08:14:43',
            ],
            [
                'id' => 2,
                'name' => 'Kasir Toko',
                'email' => 'kasir@gmail.com',
                'email_verified_at' => '2026-07-15 08:14:43',
                'password' => '$2y$12$M57AqmnHWb3IfbUu84GNlufyMGYtXoWM/rI2WpjynTlDCUzEGxjsC',
                'remember_token' => 'Y6expVRaZIIpVNkwaHY7KSQbh0hf94b9E8GUg20lbNeTiACgHhgOXV8CwKhQ',
                'created_at' => '2026-07-15 08:14:43',
                'updated_at' => '2026-07-17 02:46:29',
            ],
            [
                'id' => 3,
                'name' => 'Budi Customer',
                'email' => 'customer@gmail.com',
                'email_verified_at' => '2026-07-15 08:14:44',
                'password' => '$2y$12$.RyRpyR6pGjSE20UGIiPWunHiH2m5Xza46QaXmgt6vcdq3RhE/DTS',
                'remember_token' => 'LEoNQFo0zt',
                'created_at' => '2026-07-15 08:14:44',
                'updated_at' => '2026-07-15 08:14:44',
            ],
            [
                'id' => 4,
                'name' => 'admin2',
                'email' => 'admin2@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$qqeaXvi.yCTgYPN0.yT3UudBlnLJP4xssmk8npGZKslQuBdBXaPce',
                'remember_token' => NULL,
                'created_at' => '2026-07-15 08:46:49',
                'updated_at' => '2026-07-15 08:46:49',
            ],
        ];
        
        DB::table('users')->insert($data);
    }
}