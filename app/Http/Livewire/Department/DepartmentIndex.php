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
    public $departmentId;

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
        return view('livewire.department.department-index',compact('departments'))
        ->layout('admin.dashboard');
    }

    //show edit modal
    public function editShowModal($id)
    {
        $this->reset();
        # set edit mode to true
        $this->editMode = true;
        //find city
        $this->departmentId = $id;
        //load state
        $this->loadDepartments();
        //show modal
        $this->dispatchBrowserEvent('showModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
    }

    public function loadDepartments()
    {
        $department = Department::find($this->departmentId);
        $this->name = $department->name;
    }

    # update...
    public function update()
    {
        $validated=$this->validate([
            'name' => 'required|min:2',
        ]);
        $department=Department::find($this->departmentId);
        $department->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        session()->flash('department-message','department Updated successfully');
    }

    # Delete
    public function deleteDepartment($id)
    {
        $department=Department::find($id);
        $department->delete();
        session()->flash('department-message','department deleted successfully');
    }

    // close modal
    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        $this->reset();
    }
}
