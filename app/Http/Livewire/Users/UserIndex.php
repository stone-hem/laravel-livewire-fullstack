<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class UserIndex extends Component
{
    public $search='';
    public $username,$first_name,$last_name,$email,$password;
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
        $this->dispatchBrowserEvent('closeModal');
    }
    public function render()
    {
        $users=User::all();
        if (strlen($this->search>2)) {
            $users=User::where('username','like',"%{$this->search}%")->get();
        }
        return view('livewire.users.user-index',['users'=>$users])
        ->layout('admin.dashboard');
    }
}
