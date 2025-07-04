<?php
namespace App\Livewire;

use App\Models\Chore;
use App\Models\ChoreAction;
use App\Models\ChoreLocation;
use App\Services\ChoreService;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
class CreateChoresBatch extends Component
{
    public $chores = [];

    protected $casts = [
        'is_recurring' => 'boolean',
    ];


    // current form inputs
    public $action_id = '';
    public $location_id = '';
    public $start_date = '';
    public $end_date = '';
    public $recurrence = 'none';
    public $notes = '';
    public $is_recurring = false; // this controls what fields are shown
    public $due_date = '';

    public function addChore()
    {
        $rules = [
            'action_id' => 'required|exists:chore_actions,id',
            'location_id' => 'required|exists:chore_locations,id',
        ];

        if ($this->is_recurring) {
            $rules['start_date'] = 'required|date';
            $rules['recurrence'] = 'required|in:daily,weekly,bi-weekly,monthly';
        } else {
            $rules['due_date'] = 'required|date';
        }

        $this->validate($rules);

        $this->chores[] = [
            'action_id' => $this->action_id,
            'location_id' => $this->location_id,
            'start_date' => $this->is_recurring ? $this->start_date : $this->due_date,
            'end_date' => $this->is_recurring ? $this->end_date : $this->due_date,
            'recurrence' => $this->is_recurring ? $this->recurrence : 'none',
            'notes' => $this->notes,
        ];


        // Reset inputs
        $this->reset(['action_id', 'location_id', 'start_date', 'end_date', 'recurrence', 'notes', 'due_date']);
        $this->recurrence = 'none';
    }


    public function getFilteredActions($locationId)
    {
        return ChoreAction::whereHas('locations', function ($query) use ($locationId) {
            $query->where('chore_locations.id', $locationId);
        })->get()->map(function ($action) {
            return [
                'id' => $action->id,
                'name' => $action->name,
            ];
        });
    }


    public function removeChore($index)
    {
        unset($this->chores[$index]);
        $this->chores = array_values($this->chores);
    }

    public function saveAll(ChoreService $choreService)
    {
        $this->validate(ChoreService::getValidationRules());

        foreach ($this->chores as $data) {
            $data['created_by'] = auth()->id();
            $data['household_id'] = auth()->user()->household_id;
            $choreService->createChore($data);
        }

        session()->flash('message', 'Chores saved successfully!');
        return redirect()->route('chores.index');
    }

    public function render()
    {
        return view('livewire.create-chores-batch', [
            'actions' => ChoreAction::all(),
            'locations' => ChoreLocation::all(),
        ]);
    }
}



