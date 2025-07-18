<?php

namespace App\Livewire\Groceries;

use App\Services\GroceryStockService;
use Livewire\Component;




class GroceryStock extends Component
{
    public string $viewMode = 'household';

    public $stock = []; // Declare the property to hold stock items

public array $categoryColors = [
    'Fruits' => 'bg-lime-400',
    'Vegetables' => 'bg-emerald-400',
    'Dairy' => 'bg-yellow-300',
    'Bakery' => 'bg-orange-400',
    'Meat' => 'bg-red-400',
    'Seafood' => 'bg-cyan-400',
    'Frozen Foods' => 'bg-sky-300',
    'Snacks' => 'bg-pink-400',
    'Beverages' => 'bg-indigo-400',
    'Condiments' => 'bg-amber-400',
    'Spices & Herbs' => 'bg-green-600',
    'Pantry Staples' => 'bg-gray-400',
    'Canned Goods' => 'bg-rose-400',
    'Grains & Pasta' => 'bg-yellow-500',
    'Baking Supplies' => 'bg-pink-300',
    'Breakfast & Cereal' => 'bg-amber-300',
    'Personal Care' => 'bg-violet-400',
    'Household Supplies' => 'bg-zinc-400',
    'Cleaning Products' => 'bg-slate-300',
    'Pet Supplies' => 'bg-rose-300',
    'Baby Products' => 'bg-fuchsia-400',
    'Health & Wellness' => 'bg-emerald-600',
    'Coffee & Tea' => 'bg-stone-400',
    'Sauces' => 'bg-amber-500',
    'Nuts & Seeds' => 'bg-yellow-600',
    'Oils & Vinegars' => 'bg-green-400',
    'Prepared Meals' => 'bg-red-300',
    'Deli' => 'bg-pink-500',
    'Toiletries' => 'bg-purple-400',
    'Paper Goods' => 'bg-gray-500',
    'International Foods' => 'bg-blue-500',
    'Gluten-Free' => 'bg-emerald-300',
    'Organic' => 'bg-green-300',
    'Vegan' => 'bg-lime-300',
    'Low-Carb/Keto' => 'bg-red-600',
    'Dips & Spreads' => 'bg-amber-600',
    'Cheese' => 'bg-yellow-400',
    'Eggs' => 'bg-orange-300',
    'Juices' => 'bg-cyan-300',
    'Energy Drinks' => 'bg-indigo-500',
    'Water' => 'bg-blue-300',
    'Alcohol' => 'bg-purple-500',

        // Optional extras
    'Seasonal Items' => 'bg-red-200',
    'Supplements' => 'bg-green-700',
    'Party Supplies' => 'bg-pink-600',
    'Ice Cream & Desserts' => 'bg-pink-200',
    'Cooking Essentials' => 'bg-yellow-200',
    'Specialty Foods' => 'bg-rose-500',
];


    protected GroceryStockService $stockService;

    public function boot(GroceryStockService $groceryStockService)
    {
        $this->stockService = $groceryStockService;
    }

    public function mount(string $viewMode = 'personal')
    {
        $this->viewMode = $viewMode;
        $this->loadStock();
    }

    public function loadStock()
    {
        if ($this->viewMode === 'household') {
            $this->stock = $this->stockService->getCurrentStockForHousehold(
                auth()->user()->household_id
            );
        } else {
            $this->stock = $this->stockService->getCurrentStockForUser(auth()->id());
        }

    }

    public function incrementQuantity($stockItemId)
    {
        $item = \App\Models\GroceryStock::find($stockItemId);

        if ($item) {
            app(GroceryStockService::class)->updateStockItem($stockItemId, [
                'quantity' => $item->quantity + 1,
            ]);
            $this->loadStock();
        }
    }

    public function decrementQuantity($stockItemId)
    {
        $item = \App\Models\GroceryStock::find($stockItemId);

        if ($item && $item->quantity > 0) {
            app(GroceryStockService::class)->updateStockItem($stockItemId, [
                'quantity' => $item->quantity - 1,
            ]);
            $this->loadStock();
        }
    }

    public function removeItem($stockItemId)
    {
        \App\Models\GroceryStock::destroy($stockItemId);
        $this->loadStock();
    }



    public function render()
    {
        return view('livewire.groceries.grocery-stock', [
            'stock' => $this->stock,
            'categoryColors' => $this->categoryColors,
        ]);
    }
}
