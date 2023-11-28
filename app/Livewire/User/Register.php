<?php

namespace App\Livewire\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Register extends Component
{
    public $first_name,
        $last_name,
        $email,
        $password;
    public function render()
    {
        return view('livewire.user.register')->layout('layouts.user-login');
    }
    public function create()
    {
        $users = new User();
        $this->validate([
            'first_name' => ['required', 'string', 'min:3', 'max:10'],
            'last_name' => ['required', 'string', 'min:3', 'max:10'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'max:12'],
        ]);

        $users->first_name = $this->first_name;
        $users->last_name = $this->last_name;
        $users->email = $this->email;
        $users->password = Hash::make($this->password);

        $result = $users->save();
        if ($result) {
            session()->flash('success', 'Login With Your Details');
            $this->first_name = '';
            $this->last_name = '';
            $this->email = '';
            $this->password = '';
            //$this->c_password = '';
            return redirect(route('user.login'));
        }
    }
}
