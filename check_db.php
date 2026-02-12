<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->handle(Illuminate\Http\Request::capture());

use Illuminate\Support\Facades\Schema;

$columns = Schema::getColumnListing('users');
echo "Columns in 'users' table:\n";
foreach ($columns as $column) {
    echo "- " . $column . "\n";
}
