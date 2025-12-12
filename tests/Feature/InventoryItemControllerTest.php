<?php

// treat app like black box
// assess the test failing too
use App\Jobs\InventoryItemStoreJob;
use App\Jobs\InventoryItemUpdateJob;
use App\Models\InventoryItem;
use App\Models\User;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('ignores custom payload entries when creating inventory items', function () {
    $this->post(route('inventory_item.store'), [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
        'bad_key' => 'bad_value'
    ])->assertRedirect()->assertSessionHasNoErrors();

    $this->assertDatabaseHas('inventory_items', [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
    ]);
});

it('tests if a user can submit a new inventory item with valid data using a job', function () {
    Queue::fake();

    $this->post(route('inventory_item.store'), [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
        'bad_key' => 'bad_value'
    ])->assertRedirect('/');

    Queue::assertPushed(InventoryItemStoreJob::class, function($job) {
        return $job->data['name'] === 'test' &&
            $job->data['quantity'] === 14 &&
            $job->data['sku'] === 'abcde12345' &&
            $job->data['notification_sent'] === false;
    });
});

it('tests if a user can only create an inventory item with valid data', function () {
    $this->post(route('inventory_item.store'), [
        'bad_key' => 'bad_value'
    ]);

    $this->assertDatabaseEmpty('inventory_items');
});

it('tests if an inventory item can be deleted from the database', function () {
    $item = InventoryItem::factory()->create();

    $this->delete(route('inventory-item.delete', [
        "item" => $item->id
    ]));

    $this->assertDatabaseCount('inventory_items', 0);
});

it('updates an inventory item in the database', function () {
    Queue::fake();

    $item = InventoryItem::factory()->create();

    $updatedFields = [
        'name' => 'test',
        'quantity' => 15,
    ];

    $this->patch(route('inventory-item.update', $item),
        $updatedFields
    )->assertRedirect();

    Queue::assertPushed(InventoryItemUpdateJob::class, function ($job) {
        return $job->data['name'] === 'test' &&
            $job->data['quantity'] === 15;
    });
});
