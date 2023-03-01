<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;
    public $search='';
    public $username,$first_name,$last_name,$email,$password;
    public $userId;
    public $editMode=false;

    protected $rules = [
        'username' => 'required|min:3',
        'first_name' => 'required|min:3',
        'last_name' => 'required|min:3',
        'email' => 'required|email',
        'password' => 'required|min:6',
    ];

    public function store(){
        $this->validate();
        User::create([
            'username'=> $this->username,
            'first_name'=> $this->first_name,
            'last_name'=> $this->last_name,
            'email'=> $this->email,
            'password'=> Hash::make($this->password),
        ]);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#userModal', 'actionModal'=>'hide']);
        session()->flash('message','User created successfully');
    }
    //edit
    public function editShowModal($id){
        $this->reset();
        $this->editMode=true;
        //find user
        $this->userId=$id;
        //load user
        $this->loadUser();
        //show modal
        $this->dispatchBrowserEvent('showModal',['modalId'=>'#userModal','actionModal'=>'show']);
    }
    public function loadUser(){
        $user=User::find($this->userId);
        $this->username=$user->username;
        $this->first_name=$user->first_name;
        $this->last_name=$user->last_name;
        $this->email=$user->email;
    }

    public function update(){
        $validated=$this->validate([
            'username' => 'required|min:3',
            'first_name' => 'required|min:3',
            'last_name' => 'required|min:3',
            'email' => 'required|email',
        ]);
        $user=User::find($this->userId);
        $user->update($validated);
        $this->reset();
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#userModal', 'actionModal'=>'hide']);
        session()->flash('message','User Updated successfully');
    }

    public function userDelete($id){
        $user=User::find($id);
        $user->delete();
        session()->flash('message','User deleted successfully');
    }

    public function closeModal(){
        $this->dispatchBrowserEvent('closeModal',['modalId'=>'#userModal', 'actionModal'=>'hide']);
        $this->reset();
    }

    public function render()
    {
        $users=User::paginate(5);
        if (strlen($this->search>2)) {
            $users=User::where('username','like',"%{$this->search}%")->paginate(5);
        }
        return view('livewire.users.user-index',['users'=>$users])
        ->layout('admin.dashboard');
    }
}
