<?php
$b = App\Models\Barang::first();
$b->nama = $b->nama . ' 123';
$b->save();
echo "Notifs: " . \Illuminate\Notifications\DatabaseNotification::count() . "\n";
