<?php

namespace App\Http\Livewire\City;

use App\Models\City;
use Livewire\Component;
use Livewire\WithPagination;

class CityIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $editMode = false;
    public $cityId;
    public $name, $state_id;

    protected $rules = [
        'name' => 'required|min:2',
        'state_id' => 'required',
    ];

     # create ...
     public function store()
     {
         //Todo realtime validation
         $this->validate();
         City::create([
             'name' => $this->name,
             'state_id' => $this->state_id
         ]);
         $this->reset();
         $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
         session()->flash('city-message', 'city created');
     }


    public function render()
    {
        $cities = City::paginate(5);
        if (strlen($this->search > 2)) {
            $cities = City::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.city.city-index',compact('cities'))
        ->layout('admin.dashboard');
    }

     //show edit modal
     public function editShowModal($id)
     {
         $this->reset();
         # set edit mode to true
         $this->editMode = true;
         //find city
         $this->cityId = $id;
         //load state
         $this->loadCities();
         //show modal
         $this->dispatchBrowserEvent('showModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
     }
 
     public function loadCities()
     {
         $city = City::find($this->cityId);
         $this->name = $city->name;
         $this->state_id = $city->state_id;
     }
 
     # update...
     public function update()
     {
         $validated=$this->validate([
             'name' => 'required|min:2',
         'state_id' => 'required',
         ]);
         $city=City::find($this->cityId);
         $city->update($validated);
         $this->reset();
         $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
         session()->flash('city-message','City Updated successfully');
     }
 
     # Delete
     public function deleteCity($id)
     {
         $city=City::find($id);
         $city->delete();
         session()->flash('city-message','City deleted successfully');
     }
 
     // close modal
     public function closeModal()
     {
         $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
         $this->reset();
     }
}
