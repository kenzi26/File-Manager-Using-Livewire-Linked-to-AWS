<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function render()
    {
        return view('livewire.user.logout');
    }

    public function logout()
    {
        Auth::logout();
        return redirect(route('user.login'));
    }
}
