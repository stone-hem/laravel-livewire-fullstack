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


    public function render()
    {
        $employees = Employee::paginate(5);
        if (strlen($this->search > 2)) {
            $employees = Employee::where('name', 'like', "%{$this->search}%")->paginate(5);
        }
        return view('livewire.employee.employee-index', compact('employees'))->layout('admin.dashboard');
    }
    
    // close modal
    public function closeModal()
    {
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#countryModal', 'actionModal'=>'hide']);
        $this->reset();
    }
}
