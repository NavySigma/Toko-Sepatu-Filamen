<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksis';

    protected $fillable = [
        'nomor_invoice',
        'user_id',
        'pelanggan_id',
        'tanggal_transaksi',
        'metode_pembayaran',
        'status',
        'total_harga',
        'catatan',
    ];

    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'total_harga' => 'decimal:2',
    ];

    /**
     * Generate nomor invoice otomatis: INV-YYYYMMDD-XXXX
     */
    public static function generateInvoice(): string
    {
        $date = now()->format('Ymd');
        $prefix = "INV-{$date}-";

        $lastInvoice = static::where('nomor_invoice', 'like', "{$prefix}%")
            ->orderByDesc('nomor_invoice')
            ->first();

        if ($lastInvoice) {
            $lastNumber = (int) substr($lastInvoice->nomor_invoice, -4);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        return $prefix . str_pad((string) $newNumber, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Hitung ulang total harga dari items.
     */
    public function hitungTotal(): void
    {
        $this->total_harga = $this->items()->sum('subtotal');
        $this->saveQuietly();
    }

    // ─── Relations ───────────────────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TransaksiItem::class);
    }
}
