<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryItemFormRequest;
use App\Jobs\InventoryItemCreateJob;
use App\Models\InventoryItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class InventoryItemController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index(): Response {

        Log::info('Returning InventoryItemController index');

        return Inertia::render('Welcome', [
            'inventoryItems' => InventoryItem::all(),
            'canRegister' => fn() => !auth()->user()
        ]);
    }

    public function store(InventoryItemFormRequest $request):  RedirectResponse {
        Log::info('Attempting to create a new inventory item.');

        $data = $request->validated();

//        $newItem = InventoryItem::create($data);

        InventoryItemCreateJob::dispatch($data);

//        if ($newItem) {
//            Log::info('Data validated, the new inventory item is being added to the database.', $data);
//        }

        return redirect()->back();
    }

    public function delete(InventoryItem $item) {
        Log::info('Attempting to delete an inventory item', ["item" => $item]);

        $item->delete();
    }

    public function update(InventoryItem $item, InventoryItemFormRequest $request) {
        Log::info('Attempting to update an inventory item', ["item" => $item]);

        $data = $request->validated();

        $item->update($data);
    }
}
