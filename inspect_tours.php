<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Tour;

$tours = Tour::take(3)->get();

foreach ($tours as $tour) {
    echo "Tour ID: " . $tour->id . "\n";
    echo "Name: " . $tour->name . "\n";
    echo "Images Type: " . gettype($tour->images) . "\n";
    echo "Images Value: " . json_encode($tour->images) . "\n";
    echo "Raw DB Value: " . $tour->getRawOriginal('images') . "\n";
    echo "--------------------------------\n";
}
