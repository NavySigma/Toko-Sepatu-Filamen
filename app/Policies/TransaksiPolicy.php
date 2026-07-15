<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Transaksi;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransaksiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view_any_transaksi');
    }

    public function view(AuthUser $authUser, Transaksi $transaksi): bool
    {
        return $authUser->can('view_transaksi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create_transaksi');
    }

    public function update(AuthUser $authUser, Transaksi $transaksi): bool
    {
        return $authUser->can('update_transaksi');
    }

    public function delete(AuthUser $authUser, Transaksi $transaksi): bool
    {
        return $authUser->can('delete_transaksi');
    }

    public function restore(AuthUser $authUser, Transaksi $transaksi): bool
    {
        return $authUser->can('restore_transaksi');
    }

    public function forceDelete(AuthUser $authUser, Transaksi $transaksi): bool
    {
        return $authUser->can('force_delete_transaksi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('force_delete_any_transaksi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('restore_any_transaksi');
    }

    public function replicate(AuthUser $authUser, Transaksi $transaksi): bool
    {
        return $authUser->can('replicate_transaksi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('reorder_transaksi');
    }

}