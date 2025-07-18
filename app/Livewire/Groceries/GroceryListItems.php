<?php

namespace App\Livewire\Groceries;

use Livewire\Component;
use App\Models\GroceryItem;
use App\Models\GroceryListItem;

class GroceryListItems extends Component
{
    public int $groceryListId;
    public bool $showAddItems = false;

    public array $groupedItems = []; // GroceryItems grouped by category, as array
    public $listItems;    // Collection of GroceryListItem models for this grocery list

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
        'Seasonal Items' => 'bg-red-200',
        'Supplements' => 'bg-green-700',
        'Party Supplies' => 'bg-pink-600',
        'Ice Cream & Desserts' => 'bg-pink-200',
        'Cooking Essentials' => 'bg-yellow-200',
        'Specialty Foods' => 'bg-rose-500',
    ];

    public array $addItemData = [];

    public function mount(int $groceryListId)
    {
        $this->groceryListId = $groceryListId;

        $items = GroceryItem::with('category')->get();
        $grouped = $items->groupBy(fn($item) => $item->category->name ?? 'Uncategorized');

        // Convert grouped collection to array for Livewire serialization
        $this->groupedItems = $grouped->map(fn($group) => $group->toArray())->toArray();

        $this->loadListItems();
    }

    public function loadListItems()
    {
        $this->listItems = GroceryListItem::with('groceryItem.category')
            ->where('grocery_list_id', $this->groceryListId)
            ->get();
    }

    public function toggleAddItems()
    {
        $this->showAddItems = !$this->showAddItems;
    }




    public function render()
    {
        return view('livewire.groceries.grocery-list-items', [
            'groupedItems' => $this->groupedItems,
            'listItems' => $this->listItems,
            'categoryColors' => $this->categoryColors,
            'showAddItems' => $this->showAddItems,
        ]);
    }
}
