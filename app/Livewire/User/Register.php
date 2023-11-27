<?php

namespace App\Livewire\User;

use Livewire\Component;

class Register extends Component
{
    public function render()
    {
        return view('livewire.user.register')->layout('layouts.user-login');
    }
}
