<?php
namespace App\View\Components;

use Illuminate\View\Component;

class ChoreChard extends Component
{
    public $chore;
    public $occurrence;
    public $showAssigned;
    public $canAssign;

    /**
     * Create a new component instance.
     */
    public function __construct($chore, $occurrence, $showAssigned = false, $canAssign = false)
    {
        $this->chore = $chore;
        $this->occurrence = $occurrence;
        $this->showAssigned = $showAssigned;
        $this->canAssign = $canAssign;
    }

    /**
     * Get the view that represents the component.
     */
    public function render()
    {
        return view('components.chore-chard');
    }
}

