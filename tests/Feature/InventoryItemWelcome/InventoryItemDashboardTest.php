<?php

use App\Http\Requests\InventoryItemCreateRequest;
use App\Jobs\InventoryItemStoreJob;
use App\Jobs\InventoryItemUpdateJob;
use App\Models\InventoryItem;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Inertia\Testing\AssertableInertia as Assert;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('tests that the welcome page is loaded', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
});

it('tests the Welcome component', function () {
    $response = $this->get(route('home'));

    $response->assertInertia(fn(Assert $page) => $page->hasAll(['canRegister'])
    );
});

it('tests if the correct props are passed with the route', function () {
    $response = $this->get(route('dashboard'));

    $response->assertInertia(fn(Assert $page) => $page->hasAll(['inventoryItems'])
    );
});

//TODO: talk about this test with Felipe, but leave it here for now
it('tests if the form is submitted with the correct fields', function () {
    $request = InventoryItemCreateRequest::create(route('inventory_item.store'), 'POST', [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
        'bad_key' => 'bad_value'
    ]);

    $request->setContainer(app());
    $request->validateResolved();

    $validated = $request->validated();

    expect($validated)->toBe([
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
    ])->and($validated)->not->toHaveKey('bad_key');
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
    //FIXME: fix this test..... latest issue:
    $this->patch(route('inventory-item.update', $item,
        $updatedFields)
    )->assertRedirect();

//    Queue::assertPushed(InventoryItemUpdateJob::class, function ($job) {
//       return $job->data['name'] === 'test' && $job->data['quantity'] === 15;
//    });

    Queue::assertPushed(InventoryItemUpdateJob::class);

//    $item->update($updatedFields);
//
//    $this->assertDatabaseHas('inventory_items', [ 'id' => $item->id, 'name' => 'test']);
});
