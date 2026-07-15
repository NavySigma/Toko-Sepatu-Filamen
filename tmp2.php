<?php
\Illuminate\Support\Facades\Event::listen('eloquent.*', function ($eventName, array $data) {
    if (str_starts_with($eventName, 'eloquent.saved')) {
        echo "Fired: $eventName\n";
    }
});
$b = App\Models\Barang::first();
$b->nama = $b->nama . ' test';
$b->save();
