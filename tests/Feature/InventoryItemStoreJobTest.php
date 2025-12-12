<?php

use App\Jobs\InventoryItemStoreJob;

it('creates a new inventory item when an InventoryItemStoreJob is dispatched', function() {
    $job = new InventoryItemStoreJob([
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
    ]);

    $job->handle(); // call handle directly in this case

    $this->assertDatabaseHas('inventory_items', [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
    ]);
});

