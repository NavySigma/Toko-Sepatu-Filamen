<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Merk;
use Illuminate\Auth\Access\HandlesAuthorization;

class MerkPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_merk');
    }

    public function view(AuthUser $authUser, Merk $merk): bool
    {
        return $authUser->can('view_merk');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_merk');
    }

    public function update(AuthUser $authUser, Merk $merk): bool
    {
        return $authUser->can('update_merk');
    }

    public function delete(AuthUser $authUser, Merk $merk): bool
    {
        return $authUser->can('delete_merk');
    }

    public function restore(AuthUser $authUser, Merk $merk): bool
    {
        return $authUser->can('restore_merk');
    }

    public function forceDelete(AuthUser $authUser, Merk $merk): bool
    {
        return $authUser->can('force_delete_merk');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_merk');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_merk');
    }

    public function replicate(AuthUser $authUser, Merk $merk): bool
    {
        return $authUser->can('replicate_merk');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_merk');
    }

}