<?php
require __DIR__ . '/vendor/autoload.php';
echo "Filament\\Tables\\Actions\\BulkActionGroup: " . (class_exists('Filament\\Tables\\Actions\\BulkActionGroup') ? "YES" : "NO") . "\n";
echo "Filament\\Tables\\Actions\\DeleteBulkAction: " . (class_exists('Filament\\Tables\\Actions\\DeleteBulkAction') ? "YES" : "NO") . "\n";
echo "Filament\\Actions\\BulkActionGroup: " . (class_exists('Filament\\Actions\\BulkActionGroup') ? "YES" : "NO") . "\n";
echo "Filament\\Actions\\DeleteBulkAction: " . (class_exists('Filament\\Actions\\DeleteBulkAction') ? "YES" : "NO") . "\n";
