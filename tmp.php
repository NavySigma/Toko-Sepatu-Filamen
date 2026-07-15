<?php

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

$adminPerms = Permission::where('guard_name', 'admin')->get();
foreach ($adminPerms as $perm) {
    if (!Permission::where('name', $perm->name)->where('guard_name', 'web')->exists()) {
        Permission::create(['name' => $perm->name, 'guard_name' => 'web']);
    }
}
Permission::where('guard_name', 'admin')->delete();

$superAdmin = Role::where('name', 'super_admin')->where('guard_name', 'web')->first();
if ($superAdmin) {
    $superAdmin->syncPermissions(Permission::where('guard_name', 'web')->get());
}
echo "Done!\n";
