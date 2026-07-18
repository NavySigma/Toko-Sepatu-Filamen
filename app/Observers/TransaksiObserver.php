<?php

namespace App\Observers;

use App\Models\Transaksi;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Log;

class TransaksiObserver
{
    /**
     * Handle the Transaksi "created" event.
     */
    public function created(Transaksi $transaksi): void
    {
        $this->syncToSheets($transaksi);
    }

    /**
     * Handle the Transaksi "updated" event.
     */
    public function updated(Transaksi $transaksi): void
    {
        // For Google Sheets, usually we just append. Updating an existing row by ID requires a bit more logic.
        // For now, we will append it as a new log or you can just leave it for "created" only.
        // If we just want a running log of changes, appending is fine.
        $this->syncToSheets($transaksi, 'UPDATED');
    }

    /**
     * Handle the Transaksi "deleted" event.
     */
    public function deleted(Transaksi $transaksi): void
    {
        $this->syncToSheets($transaksi, 'DELETED');
    }

    private function syncToSheets(Transaksi $transaksi, $action = 'CREATED')
    {
        try {
            Sheets::spreadsheet(env('POST_SPREADSHEET_ID'))->sheet('Sheet1')->append([
                [
                    $action,
                    $transaksi->id,
                    $transaksi->nomor_invoice,
                    $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('Y-m-d H:i:s') : '-',
                    $transaksi->pelanggan->nama ?? '-',
                    $transaksi->status,
                    $transaksi->total_harga,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal sync ke Google Sheets: ' . $e->getMessage());
        }
    }
}
