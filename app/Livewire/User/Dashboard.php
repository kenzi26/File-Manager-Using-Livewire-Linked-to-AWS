<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\Document;


class Dashboard extends Component
{   
    public $totalDocument;
    public function render()

    {
        $this->totalDocument = Document::count();
        return view('livewire.user.dashboard')->layout('layouts.user-app');
    }
}
