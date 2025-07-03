<?php

namespace App\Livewire;

use App\Services\ChoreService;
use Illuminate\Support\Facades\App;
use Livewire\Component;
use Carbon\Carbon;
use App\Models\ChoreOccurrence;

class ChoreIndex extends Component
{
    public $groupedOccurrences;
    protected  $choreService;

    public function mount()
    {
        $this->loadOccurrences();

    }

    public function loadOccurrences()
    {
        $this->choreService = App::make(ChoreService::class);
     $this->groupedOccurrences = $this->choreService
         ->getUpcomingOccurrencesForUserGrouped(auth()->id());
    }
    public function toggleCompletion($occurrenceId)
    {
        $occurrence = ChoreOccurrence::findOrFail($occurrenceId);
        $occurrence->toggleCompletion();
        $this->loadOccurrences();
    }

    public function render()
    {
        return view('livewire.chore-index', [
            'groupedOccurrences' => $this->groupedOccurrences,
        ]);
    }
}
