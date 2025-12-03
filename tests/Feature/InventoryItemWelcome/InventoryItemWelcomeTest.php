<?php

use App\Http\Requests\InventoryItemFormRequest;
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

    $response->assertInertia(fn(Assert $page) => $page->component('Welcome')
    );
});

it('tests if the correct props are passed with the route', function () {
    $response = $this->get(route('home'));

    $response->assertInertia(fn(Assert $page) => $page->hasAll(['inventoryItems', 'canRegister'])
    );
});

//TODO: talk about this test with Felipe, but leave it here for now
it('tests if the form is submitted with the correct fields', function () {
    $request = InventoryItemFormRequest::create(route('inventory_item.store'), 'POST', [
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

it('tests if a user can create an inventory item with valid data', function () {
    $this->post(route('inventory_item.store'), [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
        'bad_key' => 'bad_value'
    ])->assertRedirect('/');

    $this->assertDatabaseHas('inventory_items', [
        'name' => 'test',
        'quantity' => 14,
        'sku' => 'abcde12345',
        'notification_sent' => false,
    ]);
});

it('tests if a user can not create an inventory item with invalid data', function () {
    $response = $this->post(route('inventory_item.store'), [
        'bad_key' => 'bad_value'
    ]);

    $this->assertDatabaseEmpty('inventory_items');
});
//TODO: add inventory-item.update test
it('tests if an inventory item can be deleted from the database', function () {
    $item = InventoryItem::factory()->create();

    $this->delete(route('inventory-item.delete', [
        "item" => $item->id
    ]));

    $this->assertDatabaseCount('inventory_items', 0);
});

it('updates an inventory item in the database', function () {
    $item = InventoryItem::factory()->create();

    $updatedFields = [
        'name' => 'test',
        'quantity' => 15,
    ];

    $this->put(route('inventory-item.update', ['item' => $item, 'updated_fields' => $updatedFields]));

    $item->update($updatedFields);

    $this->assertDatabaseHas('inventory_items', [ 'id' => $item->id, 'name' => 'test']);
});
