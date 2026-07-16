<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
\App\Models\Pembelian::whereNull('nomor_po')->get()->each(function($p) {
    $p->update(['nomor_po' => 'PO-' . date('Ymd') . '-OLD-' . str_pad($p->id, 4, '0', STR_PAD_LEFT)]);
});
echo 'Success';
