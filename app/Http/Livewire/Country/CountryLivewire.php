<?php

namespace App\Http\Livewire\Country;

use App\Models\Country;
use Livewire\Component;
use Livewire\WithPagination;

class CountryLivewire extends Component
{
    use WithPagination;
    public $search = '';
    public $editMode = false;
    public $countryId;
    public $name, $country_code;

    protected $rules = [
        'name' => 'required|min:2',
        'country_code' => 'required',
    ];


    # create ...
    public function store()
    {
        $this->validate();
        Country::create([
            'name' => $this->name,
            'country_code' => $this->country_code
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        session()->flash('country-message', 'country created');
    }

    # read and search...
    public function render()
    {
        $countries = Country::paginate(5);
        if (strlen($this->search > 2)) {
            $countries = Country::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.country.country-livewire', ['countries' => $countries])
            ->layout('admin.dashboard');
    }

    //show edit modal
    public function editShowModal($id)
    {
        $this->reset();
        # set edit mode to true
        $this->editMode = true;
        //find country
        $this->countryId = $id;
        //load user
        $this->loadCountry();
        //show modal
        $this->dispatchBrowserEvent('showModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
    }

    public function loadCountry()
    {
        $country = Country::find($this->countryId);
        $this->name = $country->name;
        $this->country_code = $country->country_code;
    }

    # update...
    public function update()
    {
        $validated=$this->validate([
            'name' => 'required|min:2',
        'country_code' => 'required',
        ]);
        $country=Country::find($this->countryId);
        $country->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        session()->flash('country-message','Country Updated successfully');
    }

    # Delete
    public function deleteCountry($id)
    {
        $country=Country::find($id);
        $country->delete();
        session()->flash('country-message','Country deleted successfully');
    }

    // close modal
    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        $this->reset();
    }
}
