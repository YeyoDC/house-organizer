<?php

namespace App\Livewire\Groceries;

use App\Models\GroceryListItem;
use App\Models\GroceryStock;
use App\Services\GroceryListItemService;
use App\Services\GroceryStockService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use function Psy\debug;

class ShoppingList extends Component
{
    public int $groceryListId;
    public $listItems; // Eloquent Collection


    public string $view = 'household';
    public float $totalShopping = 0;
    public float $itemTotal = 0;

    public array $unitPrices = [];
    public array $totalPrices = [];
    public array $quantities = [];

    public  $statuses = [];
    public $previouslyPurchased = [];
    protected ?GroceryListItemService $service = null;
    protected ?GroceryStockService $stockService = null;

    public function mount()
    {
        // ✅ Initialize services early to avoid typed property error
        $this->service = app(GroceryListItemService::class);
        $this->stockService = app(GroceryStockService::class);

        $this->loadShoppingList();
    }

    public function loadShoppingList(): void
    {


        $items  = GroceryListItem::with(['groceryItem.category', 'purchasedByUser'])
            ->where('grocery_list_id', $this->groceryListId)
            ->orderBy('purchased')
            ->get();

        $this->listItems = $items;


        foreach ($items as $index => $item) {
            $this->unitPrices[$index] = $item->unit_price;

            $this->quantities[$index] = $item->quantity;

                if($item->purchased) {
                    $this->previouslyPurchased[$item->id] = $item->purchased;
                }
                else{
                    $this->totalPrices[$index] = $item->total_price;
                    $this->statuses[$item->id] = $item->purchased;
                }
        }


    }
// todo: save the final calculation and prices to DB for listItems, StockItems and Lists
    public function finalizeShopping()
    {
        if (!$this->service) {
            $this->service = app(GroceryListItemService::class);
        }
        if(!$this->stockService) {
            $this->stockService = app(GroceryStockService::class);
        }
        $user = Auth::user();

        foreach ($this->listItems as $index => $item) {
            if(!$item->purchased && $this->statuses[$item->id]) {
                $this->service->updateGroceryListItem($item->id, [
                    'purchased' => $this->statuses[$item->id],
                    'quantity' => $this->quantities[$index],
                    'notes' => $item->notes,
                    'unit_price' => $this->unitPrices[$index],
                    'total_price' => $this->totalPrices[$index],
                ]);
            }

        }

        //updating the grand total
        $this->service->updateGrandTotalList($this->groceryListId, $this->totalShopping);

        if (!$this->service->hasPendingItems($this->groceryListId)) {
            $this->service->completeGroceryList($this->groceryListId);
        }
//        reloading items as they have new update statuses
        $user = Auth::user();
        foreach ($this->listItems as $index => $item) {
            if (!array_key_exists($item->id, $this->previouslyPurchased) && $this->statuses[$item->id]) {
                $this->stockService->addStock([
                    'household_id' => $user->household_id,
                    'grocery_item_id' => $item->groceryItem->id,
                    'quantity' => $this->quantities[$index],
                    'unit_price' => $this->unitPrices[$index],
                    'total_price' => $this->totalPrices[$index],
                    'purchased_by' => $user->id
                ]);
            }
        }

        return redirect()->route('groceries.index')
            ->with('success', 'Shopping finalized! Items have been added to your stock.');
    }

    public function increaseQty($index): void
    {
        $this->quantities[$index] += 1;
//        dd($this->listItems[$index]);
//        dd($this->listItems[$index]->unitPrice);
        $this->updatePrice($index, $this->unitPrices[$index]);
    }

    public function decreaseQty($index): void
    {
        if ($this->quantities[$index] > 1) {
            $this->quantities[$index] -= 1;
//            dd($this->listItems[$index]->quantity);
            $this->updatePrice($index, $this->unitPrices[$index]);
        }
    }

    public function updatePrice($index, $price)
    {

        if (!$this->service) {
            $this->service = app(GroceryListItemService::class);
        }

        $unitPrice = $price;
        $quantity = $this->quantities[$index];

        $totalPrice = $this->service->calculateItemTotal( $unitPrice, $quantity);
        $this->totalPrices[$index] = $totalPrice;
        $this->unitPrices[$index] = $unitPrice;
//        dd($this->listItems[$index]);

        $this->updateTotalShopping();
       // dd($this->listItems[$index]);
    }

    public function updateTotalShopping()
    {
        $this->totalShopping = 0.0;
        foreach ($this->totalPrices as $item) {
            $this->totalShopping += $item;
        }
    }

    public function render()
    {
        return view('livewire.groceries.shopping-list');
    }
}
