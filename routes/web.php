<?php

use App\Http\Controllers\InventoryItemController;
use App\Models\InventoryItem;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard', [
        'inventoryItems' => InventoryItem::all()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/inventory_items', [InventoryItemController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('inventory_item.index');

Route::post('/inventory_item/store', [InventoryItemController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('inventory_item.store');

// note to self: the {item} must match the name of the parameter in the delete method on the controller.
Route::delete('/inventory_item/{item}', [InventoryItemController::class, 'delete'])
    ->middleware(['auth', 'verified'])->name('inventory-item.delete');

Route::patch('inventory_item/{item}', [InventoryItemController::class, 'update'])
    ->middleware(['auth', 'verified'])->name('inventory-item.update');

require __DIR__.'/settings.php';
