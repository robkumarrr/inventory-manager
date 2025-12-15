<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryItemCreateRequest;
use App\Http\Requests\InventoryItemUpdateRequest;
use App\Jobs\InventoryItemStoreJob;
use App\Jobs\InventoryItemUpdateJob;
use App\Models\InventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class InventoryItemController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response {

        Log::info('Returning InventoryItemController index');

        return Inertia::render('Dashboard', [
            'inventoryItems' => InventoryItem::all(),
            'canRegister' => fn() => !auth()->user()
        ]);
    }

    /**
     * @param string $item
     * @return Response
     */
    public function show(InventoryItem $item): Response
    {
        Log::info('Viewing a single item');

        return Inertia::render('inventoryItems/Show', [
           'inventoryItem' => $item
        ]);
    }

    /**
     * @param InventoryItemCreateRequest $request
     * @return RedirectResponse
     */
    public function store(InventoryItemCreateRequest $request):  RedirectResponse {
        Log::info('Attempting to create a new inventory item.');

        $data = $request->validated();

        InventoryItemStoreJob::dispatch($data);

        return redirect()->back();
    }

    /**
     * @param InventoryItem $item
     * @return void
     */
    public function delete(InventoryItem $item) {
        Log::info('Attempting to delete an inventory item', ["item" => $item]);

        $item->delete();
    }

    /**
     * @param InventoryItem $item
     * @param InventoryItemUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(InventoryItem $item, InventoryItemUpdateRequest $request) {
        Log::info('Attempting to update an inventory item', ["item" => $item]);

        Log::info('All request data = ', $request->all());

        $data = $request->validated();

        Log::info('Validated data:', $data); // See what validated() returns

        InventoryItemUpdateJob::dispatch($data, $item);

        return redirect()->back()->with('success', "Item with ID: {$item->id} updated successfully");
    }
}
