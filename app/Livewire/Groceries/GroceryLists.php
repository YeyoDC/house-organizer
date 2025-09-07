<?php

namespace App\Livewire\Groceries;

use App\Models\GroceryList;
use App\Services\GroceryListService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class GroceryLists extends Component
{
    public array $newList = [
        'name' => '',
        'due_date' => '',
        'scope' => '',
    ];

    public string $viewMode = 'household';

    public $groceryLists = []; // Make it a component property

    protected GroceryListService $groceryListService;

    public function boot(GroceryListService $groceryListService)
    {
        $this->groceryListService = $groceryListService;
    }

    public function mount()
    {
        $this->loadGroceryLists(); //  Load lists on mount
    }

    public function createList()
    {
        $data = $this->newList;
        $user = Auth::user();
        $data['user_id'] = $data['scope'] === 'personal' ? $user->id : null;
        $data['household_id'] = $data['scope'] === 'household' ? $user->household_id : null;
        $groceryList = $this->groceryListService->createGroceryList($data);
        $this->reset('newList');

        $this->loadGroceryLists(); // Refresh list after creating

        $this->dispatch('list-created');
    }

    public function loadGroceryLists()
    {
        $user = Auth::user();

        $this->groceryLists = $this->groceryListService->getActiveListsForUserOrHousehold(
            $user->id,
            $user->household_id,
            $this->viewMode
        );
    }

    public function render()
    {
        return view('livewire.groceries.grocery-lists');
    }
}

