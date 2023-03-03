<?php

namespace App\Http\Livewire\Employee;

use App\Models\Employee;
use Livewire\Component;
use Livewire\WithPagination;

class EmployeeIndex extends Component
{
    use WithPagination;
    public $search = '';
    public $editMode = false;
    public $employeeId;
    public $first_name, $last_name, $department_id, $country_id, $city_id, $state_id, $date_hired;

    protected $rules = [
        'first_name' => 'required|min:2',
        'last_name' => 'required|min:2',
        'department_id' => 'required',
        'country_id' => 'required',
        'city_id' => 'required',
        'state_id' => 'required',
        'date_hired' => 'required',
    ];


    # create ...
    public function store()
    {
        //Todo realtime validation
        $this->validate();
        Employee::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'department_id' => $this->department_id,
            'country_id' => $this->country_id,
            'city_id' => $this->city_id,
            'state_id' => $this->state_id,
            'date_hired' => $this->date_hired,
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal', ['modalId' => '#countryModal', 'actionModal' => 'hide']);
        session()->flash('employee-message', 'Employee created');
    }


    public function render()
    {
        $employees = Employee::paginate(5);
        if (strlen($this->search > 2)) {
            $employees = Employee::where('first_name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.employee.employee-index', compact('employees'))->layout('admin.dashboard');
    }

    //show edit modal
    public function edit($id)
    {
        $this->reset();
        # set edit mode to true
        $this->editMode = true;
        //find country
        $this->employeeId = $id;
        //load state
        $this->load();
        //show modal
        $this->dispatchBrowserEvent('showModal', ['modalId' => '#countryModal', 'actionModal' => 'hide']);
    }

    public function load()
    {
        $employee = Employee::find($this->employeeId);
        $this->first_name = $employee->first_name;
        $this->last_name = $employee->last_name;
        $this->department_id = $employee->department_id;
        $this->country_id = $employee->country_id;
        $this->city_id = $employee->city_id;
        $this->state_id = $employee->state_id;
        $this->date_hired = $employee->date_hired;
    }

    # update...
    public function update()
    {
        $validated = $this->validate([
            'first_name' => 'required|min:2',
            'last_name' => 'required|min:2',
            'department_id' => 'required',
            'country_id' => 'required',
            'city_id' => 'required',
            'state_id' => 'required',
            'date_hired' => 'required',
        ]);
        $employee = Employee::find($this->employeeId);
        $employee->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal', ['modalId' => '#countryModal', 'actionModal' => 'hide']);
        session()->flash('employee-message', 'Employee Updated successfully');
    }


    # Delete
    public function destroy($id)
    {
        $employee = Employee::find($id);
        $employee->delete();
        session()->flash('employee-message', 'Employee deleted successfully');
    }

    // close modal
    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal', ['modalId' => '#countryModal', 'actionModal' => 'hide']);
        $this->reset();
    }
}
