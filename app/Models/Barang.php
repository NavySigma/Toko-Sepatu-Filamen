<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'merk_id',
        'kategori',
        'ukuran',
        'warna',
        'harga',
        'stok',
        'deskripsi',
        'gambar',
    ];

    public function merk()
    {
        return $this->belongsTo(Merk::class);
    }

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
    ];
}
