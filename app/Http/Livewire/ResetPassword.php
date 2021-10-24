<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPassword extends Component
{
    public $successMessage = '';
    public $message = '';
    public $password ='';
    public $password_confirmation ='';

    protected $rules = [
        'password' => [
            'required',
            'min:6',
            'max:100',
            'confirmed'
        ]
    ];

    public function update($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    public function render()
    {
        return view('livewire.reset-password');
    }

    public function updatePassword()
    {
        $this->validate();

        $user = User::where('id', auth()->user()->id)->first();
        $user->password = Hash::make($this->password);
        $user->save();

        $this->successMessage = "Password updated successfully." ;

    }

}
