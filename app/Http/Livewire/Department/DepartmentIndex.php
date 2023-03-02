<?php

namespace App\Http\Livewire\Department;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithPagination;

class DepartmentIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $editMode = false;
    public $name;

    protected $rules = [
        'name' => 'required|min:2',
    ];

     # create ...
     public function store()
     {
         //Todo realtime validation
         $this->validate();
         Department::create([
             'name' => $this->name,
         ]);
         $this->reset();
         $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
         session()->flash('department-message', 'Department created');
     }

    public function render()
    {
        $departments = Department::paginate(5);
        if (strlen($this->search > 2)) {
            $departments = Department::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.department.department-index')
        ->layout('admin.dashboard');
    }
}
