<?php

use App\Http\Controllers\InventoryItemController;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
        'inventoryItems' => InventoryItem::all(),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/inventory_items', [InventoryItemController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('inventory_item.index');

require __DIR__.'/settings.php';
