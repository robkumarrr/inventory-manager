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

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard', [
        'inventoryItems' => InventoryItem::all()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/inventory_items', [InventoryItemController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('inventory_item.index');

Route::get('/inventory_item/{item}', [InventoryItemController::class, 'show'])
    ->middleware(['auth', 'verified'])->name('inventory-item.show');

Route::post('/inventory_item/store', [InventoryItemController::class, 'store'])
    ->middleware(['auth', 'verified'])->name('inventory_item.store');

// note to self: the {item} must match the name of the parameter in the method on the controller.
Route::delete('/inventory_item/{item}', [InventoryItemController::class, 'delete'])
    ->middleware(['auth', 'verified'])->name('inventory-item.delete');

Route::patch('/inventory_item/{item}', [InventoryItemController::class, 'update'])
    ->middleware(['auth', 'verified'])->name('inventory-item.update');

require __DIR__.'/settings.php';
//TODO: create route for visiting a single page
//TODO: make sure test coverage for the job dispatch is sufficient (test async functionality of job)
//TODO: create form for updating a single record
//TODO: dispatch a delete job too
