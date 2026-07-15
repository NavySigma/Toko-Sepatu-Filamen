<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Pembelian;
use Illuminate\Auth\Access\HandlesAuthorization;

class PembelianPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_pembelian');
    }

    public function view(AuthUser $authUser, Pembelian $pembelian): bool
    {
        return $authUser->can('view_pembelian');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_pembelian');
    }

    public function update(AuthUser $authUser, Pembelian $pembelian): bool
    {
        return $authUser->can('update_pembelian');
    }

    public function delete(AuthUser $authUser, Pembelian $pembelian): bool
    {
        return $authUser->can('delete_pembelian');
    }

    public function restore(AuthUser $authUser, Pembelian $pembelian): bool
    {
        return $authUser->can('restore_pembelian');
    }

    public function forceDelete(AuthUser $authUser, Pembelian $pembelian): bool
    {
        return $authUser->can('force_delete_pembelian');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_pembelian');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_pembelian');
    }

    public function replicate(AuthUser $authUser, Pembelian $pembelian): bool
    {
        return $authUser->can('replicate_pembelian');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_pembelian');
    }

}