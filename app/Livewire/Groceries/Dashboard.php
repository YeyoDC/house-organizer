<?php

namespace App\Livewire\Groceries;

use Livewire\Component;

class Dashboard extends Component
{
    public $viewMode = 'household'; // or 'household'

    public function switchView($mode)
    {
        $this->viewMode = $mode;
    }
    public function render()
    {
        return view('livewire.groceries.dashboard');
    }
}
