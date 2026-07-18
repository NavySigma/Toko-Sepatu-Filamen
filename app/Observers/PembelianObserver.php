<?php

namespace App\Observers;

use App\Models\Pembelian;
use Revolution\Google\Sheets\Facades\Sheets;
use Illuminate\Support\Facades\Log;

class PembelianObserver
{
    /**
     * Handle the Pembelian "created" event.
     */
    public function created(Pembelian $pembelian): void
    {
        $this->syncToSheets($pembelian);
    }

    /**
     * Handle the Pembelian "updated" event.
     */
    public function updated(Pembelian $pembelian): void
    {
        $this->syncToSheets($pembelian, 'UPDATED');
    }

    /**
     * Handle the Pembelian "deleted" event.
     */
    public function deleted(Pembelian $pembelian): void
    {
        $this->syncToSheets($pembelian, 'DELETED');
    }

    private function syncToSheets(Pembelian $pembelian, $action = 'CREATED')
    {
        try {
            // Kita pisahkan data Pembelian ke Sheet2 atau tetap Sheet1 dengan awalan "PEMBELIAN"
            // Sebagai contoh, kita gabungkan di Sheet1 namun beri label 'Pembelian - ' di kolom action
            Sheets::spreadsheet(env('POST_SPREADSHEET_ID'))->sheet('Sheet1')->append([
                [
                    'Pembelian - ' . $action,
                    $pembelian->id,
                    $pembelian->nomor_po,
                    $pembelian->tanggal_pembelian ? \Carbon\Carbon::parse($pembelian->tanggal_pembelian)->format('Y-m-d') : '-',
                    $pembelian->supplier->nama ?? '-',
                    $pembelian->status,
                    $pembelian->total_harga,
                ]
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal sync Pembelian ke Google Sheets: ' . $e->getMessage());
        }
    }
}
