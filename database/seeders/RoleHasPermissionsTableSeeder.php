<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleHasPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('role_has_permissions')->delete();
        
        $data = [
            [
                'permission_id' => 1,
                'role_id' => 1,
            ],
            [
                'permission_id' => 2,
                'role_id' => 1,
            ],
            [
                'permission_id' => 3,
                'role_id' => 1,
            ],
            [
                'permission_id' => 4,
                'role_id' => 1,
            ],
            [
                'permission_id' => 5,
                'role_id' => 1,
            ],
            [
                'permission_id' => 6,
                'role_id' => 1,
            ],
            [
                'permission_id' => 7,
                'role_id' => 1,
            ],
            [
                'permission_id' => 8,
                'role_id' => 1,
            ],
            [
                'permission_id' => 9,
                'role_id' => 1,
            ],
            [
                'permission_id' => 10,
                'role_id' => 1,
            ],
            [
                'permission_id' => 11,
                'role_id' => 1,
            ],
            [
                'permission_id' => 12,
                'role_id' => 1,
            ],
            [
                'permission_id' => 13,
                'role_id' => 1,
            ],
            [
                'permission_id' => 14,
                'role_id' => 1,
            ],
            [
                'permission_id' => 15,
                'role_id' => 1,
            ],
            [
                'permission_id' => 16,
                'role_id' => 1,
            ],
            [
                'permission_id' => 17,
                'role_id' => 1,
            ],
            [
                'permission_id' => 18,
                'role_id' => 1,
            ],
            [
                'permission_id' => 6,
                'role_id' => 2,
            ],
            [
                'permission_id' => 7,
                'role_id' => 2,
            ],
            [
                'permission_id' => 18,
                'role_id' => 2,
            ],
            [
                'permission_id' => 1,
                'role_id' => 3,
            ],
            [
                'permission_id' => 2,
                'role_id' => 3,
            ],
            [
                'permission_id' => 3,
                'role_id' => 3,
            ],
            [
                'permission_id' => 4,
                'role_id' => 3,
            ],
            [
                'permission_id' => 5,
                'role_id' => 3,
            ],
            [
                'permission_id' => 6,
                'role_id' => 3,
            ],
            [
                'permission_id' => 7,
                'role_id' => 3,
            ],
            [
                'permission_id' => 8,
                'role_id' => 3,
            ],
            [
                'permission_id' => 9,
                'role_id' => 3,
            ],
            [
                'permission_id' => 10,
                'role_id' => 3,
            ],
            [
                'permission_id' => 11,
                'role_id' => 3,
            ],
            [
                'permission_id' => 12,
                'role_id' => 3,
            ],
            [
                'permission_id' => 13,
                'role_id' => 3,
            ],
            [
                'permission_id' => 14,
                'role_id' => 3,
            ],
            [
                'permission_id' => 15,
                'role_id' => 3,
            ],
            [
                'permission_id' => 16,
                'role_id' => 3,
            ],
            [
                'permission_id' => 17,
                'role_id' => 3,
            ],
            [
                'permission_id' => 18,
                'role_id' => 3,
            ],
            [
                'permission_id' => 119,
                'role_id' => 3,
            ],
            [
                'permission_id' => 120,
                'role_id' => 3,
            ],
            [
                'permission_id' => 121,
                'role_id' => 3,
            ],
            [
                'permission_id' => 122,
                'role_id' => 3,
            ],
            [
                'permission_id' => 123,
                'role_id' => 3,
            ],
            [
                'permission_id' => 124,
                'role_id' => 3,
            ],
            [
                'permission_id' => 125,
                'role_id' => 3,
            ],
            [
                'permission_id' => 126,
                'role_id' => 3,
            ],
            [
                'permission_id' => 127,
                'role_id' => 3,
            ],
            [
                'permission_id' => 128,
                'role_id' => 3,
            ],
            [
                'permission_id' => 129,
                'role_id' => 3,
            ],
            [
                'permission_id' => 130,
                'role_id' => 3,
            ],
            [
                'permission_id' => 131,
                'role_id' => 3,
            ],
            [
                'permission_id' => 132,
                'role_id' => 3,
            ],
            [
                'permission_id' => 133,
                'role_id' => 3,
            ],
            [
                'permission_id' => 134,
                'role_id' => 3,
            ],
            [
                'permission_id' => 135,
                'role_id' => 3,
            ],
            [
                'permission_id' => 136,
                'role_id' => 3,
            ],
            [
                'permission_id' => 137,
                'role_id' => 3,
            ],
            [
                'permission_id' => 138,
                'role_id' => 3,
            ],
            [
                'permission_id' => 139,
                'role_id' => 3,
            ],
            [
                'permission_id' => 140,
                'role_id' => 3,
            ],
            [
                'permission_id' => 141,
                'role_id' => 3,
            ],
            [
                'permission_id' => 142,
                'role_id' => 3,
            ],
            [
                'permission_id' => 143,
                'role_id' => 3,
            ],
            [
                'permission_id' => 144,
                'role_id' => 3,
            ],
            [
                'permission_id' => 145,
                'role_id' => 3,
            ],
            [
                'permission_id' => 146,
                'role_id' => 3,
            ],
            [
                'permission_id' => 147,
                'role_id' => 3,
            ],
            [
                'permission_id' => 148,
                'role_id' => 3,
            ],
            [
                'permission_id' => 149,
                'role_id' => 3,
            ],
            [
                'permission_id' => 150,
                'role_id' => 3,
            ],
            [
                'permission_id' => 151,
                'role_id' => 3,
            ],
            [
                'permission_id' => 152,
                'role_id' => 3,
            ],
            [
                'permission_id' => 153,
                'role_id' => 3,
            ],
            [
                'permission_id' => 154,
                'role_id' => 3,
            ],
            [
                'permission_id' => 155,
                'role_id' => 3,
            ],
            [
                'permission_id' => 156,
                'role_id' => 3,
            ],
            [
                'permission_id' => 157,
                'role_id' => 3,
            ],
            [
                'permission_id' => 158,
                'role_id' => 3,
            ],
            [
                'permission_id' => 159,
                'role_id' => 3,
            ],
            [
                'permission_id' => 160,
                'role_id' => 3,
            ],
            [
                'permission_id' => 161,
                'role_id' => 3,
            ],
            [
                'permission_id' => 162,
                'role_id' => 3,
            ],
            [
                'permission_id' => 163,
                'role_id' => 3,
            ],
            [
                'permission_id' => 164,
                'role_id' => 3,
            ],
            [
                'permission_id' => 165,
                'role_id' => 3,
            ],
            [
                'permission_id' => 166,
                'role_id' => 3,
            ],
            [
                'permission_id' => 167,
                'role_id' => 3,
            ],
            [
                'permission_id' => 168,
                'role_id' => 3,
            ],
            [
                'permission_id' => 169,
                'role_id' => 3,
            ],
            [
                'permission_id' => 170,
                'role_id' => 3,
            ],
            [
                'permission_id' => 171,
                'role_id' => 3,
            ],
            [
                'permission_id' => 172,
                'role_id' => 3,
            ],
            [
                'permission_id' => 173,
                'role_id' => 3,
            ],
            [
                'permission_id' => 174,
                'role_id' => 3,
            ],
            [
                'permission_id' => 175,
                'role_id' => 3,
            ],
            [
                'permission_id' => 176,
                'role_id' => 3,
            ],
            [
                'permission_id' => 177,
                'role_id' => 3,
            ],
            [
                'permission_id' => 178,
                'role_id' => 3,
            ],
            [
                'permission_id' => 179,
                'role_id' => 3,
            ],
            [
                'permission_id' => 180,
                'role_id' => 3,
            ],
            [
                'permission_id' => 181,
                'role_id' => 3,
            ],
            [
                'permission_id' => 182,
                'role_id' => 3,
            ],
            [
                'permission_id' => 183,
                'role_id' => 3,
            ],
            [
                'permission_id' => 184,
                'role_id' => 3,
            ],
            [
                'permission_id' => 185,
                'role_id' => 3,
            ],
            [
                'permission_id' => 186,
                'role_id' => 3,
            ],
            [
                'permission_id' => 187,
                'role_id' => 3,
            ],
            [
                'permission_id' => 188,
                'role_id' => 3,
            ],
            [
                'permission_id' => 189,
                'role_id' => 3,
            ],
            [
                'permission_id' => 190,
                'role_id' => 3,
            ],
            [
                'permission_id' => 191,
                'role_id' => 3,
            ],
            [
                'permission_id' => 192,
                'role_id' => 3,
            ],
            [
                'permission_id' => 193,
                'role_id' => 3,
            ],
            [
                'permission_id' => 194,
                'role_id' => 3,
            ],
            [
                'permission_id' => 195,
                'role_id' => 3,
            ],
            [
                'permission_id' => 196,
                'role_id' => 3,
            ],
            [
                'permission_id' => 197,
                'role_id' => 3,
            ],
            [
                'permission_id' => 198,
                'role_id' => 3,
            ],
            [
                'permission_id' => 199,
                'role_id' => 3,
            ],
            [
                'permission_id' => 200,
                'role_id' => 3,
            ],
        ];
        
        DB::table('role_has_permissions')->insert($data);
    }
}