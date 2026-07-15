<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = ['nama', 'kontak', 'email', 'alamat', 'jumlah_cat_disupply'];

    public function pembelians()
    {
        return $this->hasMany(Pembelian::class);
    }
}
