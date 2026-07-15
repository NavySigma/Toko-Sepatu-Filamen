<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Seed the roles and assign permissions.
     *
     * Hierarchy:
     *  - super_admin  : Full access (already exists, gets all permissions)
     *  - admin_kasir  : Manage users, view activity logs, access profile
     *  - customer     : View own profile only
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ─── Admin / Kasir ───────────────────────────────────────────
        // Can manage users (CRUD, but no force-delete or role management)
        // Can view activity logs (read-only)
        // Can access profile page
        $adminKasirPermissions = [
            // User management — day-to-day operations
            'view_any_user',
            'view_user',
            'create_user',
            'update_user',
            'delete_user',

            // Barang management — full CRUD for products
            'view_any_barang',
            'view_barang',
            'create_barang',
            'update_barang',
            'delete_barang',

            // Transaksi management
            'view_any_transaksi',
            'view_transaksi',
            'create_transaksi',
            'update_transaksi',
            'delete_transaksi',

            // Activity log — read-only for audit
            'view_any_activity',
            'view_activity',

            // Pages
            'view_my_profile_page',
        ];

        foreach ($adminKasirPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $adminKasirRole = Role::firstOrCreate(
            ['name' => 'admin_kasir', 'guard_name' => 'web']
        );
        $adminKasirRole->syncPermissions($adminKasirPermissions);

        // ─── Customer ────────────────────────────────────────────────
        // Can view products (browse catalog) and own profile
        $customerPermissions = [
            'view_any_barang',
            'view_barang',
            'view_my_profile_page',
        ];

        foreach ($customerPermissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }

        $customerRole = Role::firstOrCreate(
            ['name' => 'customer', 'guard_name' => 'web']
        );
        $customerRole->syncPermissions($customerPermissions);

        // ─── Sync super_admin with ALL permissions ───────────────────
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );
        $superAdminRole->syncPermissions(Permission::all());

        $this->command->info('Roles seeded successfully:');
        $this->command->table(
            ['Role', 'Permissions Count'],
            [
                ['super_admin', $superAdminRole->permissions()->count()],
                ['admin_kasir', $adminKasirRole->permissions()->count()],
                ['customer', $customerRole->permissions()->count()],
            ]
        );
    }
}
