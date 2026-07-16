<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    protected $fillable = ['nomor_po', 'supplier_id', 'tanggal_pembelian', 'total_harga', 'status', 'catatan'];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PembelianItem::class);
    }
}
