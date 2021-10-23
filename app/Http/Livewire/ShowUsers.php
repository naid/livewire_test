<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\User;

class ShowUsers extends Component
{
    public $users = [];

    public function mount()
    {
        if (Auth::check()) {
            $this->users = User::all();
        }
    }

    public function render()
    {
        return view('livewire.show-users');
    }
}
