<?php

namespace App\Http\Livewire\State;

use App\Models\Country;
use App\Models\State;
use Livewire\Component;
use Livewire\WithPagination;

class StateIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $editMode = false;
    public $stateId;
    public $name, $country_id;

    protected $rules = [
        'name' => 'required|min:2',
        'country_id' => 'required',
    ];

    # create ...
    public function store()
    {
        //Todo realtime validation
        $this->validate();
        State::create([
            'name' => $this->name,
            'country_id' => $this->country_id
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        session()->flash('state-message', 'country created');
    }

    public function render()
    {
        $countries=Country::all();
        $states = State::paginate(5);
        if (strlen($this->search > 2)) {
            $states = State::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.state.state-index',compact('states','countries'))
        ->layout('admin.dashboard');
    }

    //show edit modal
    public function editShowModal($id)
    {
        $this->reset();
        # set edit mode to true
        $this->editMode = true;
        //find country
        $this->stateId = $id;
        //load state
        $this->loadStates();
        //show modal
        $this->dispatchBrowserEvent('showModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
    }

    public function loadStates()
    {
        $state = State::find($this->stateId);
        $this->name = $state->name;
        $this->country_id = $state->country_id;
    }

    # update...
    public function update()
    {
        $validated=$this->validate([
            'name' => 'required|min:2',
        'country_id' => 'required',
        ]);
        $state=State::find($this->stateId);
        $state->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        session()->flash('country-message','Country Updated successfully');
    }

    # Delete
    public function deleteState($id)
    {
        $state=State::find($id);
        $state->delete();
        session()->flash('country-message','Country deleted successfully');
    }

    // close modal
    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        $this->reset();
    }
}
