<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class UserComponent extends Component
{
    public 
        $data,
        $first_name,
        $last_name,
        $email,
        // $password,
        $company_name,
        $company_email,
        $selected_id;
    public $updateMode = false;

    public function render()
    {
        $this->data = User::all();
        return view('livewire.user.list');
    }
    private function resetInput()
    {
        $this->first_name = null;
        $this->last_name = null;
        $this->email = null;
        // $this->password = null;
        $this->company_name = null;
        $this->company_email = null;
    }
    public function store()
    {
        $this->validate([
            'first_name' => ['required', 'string', 'min:5', 'max:125'],
            'last_name' => ['required', 'string', 'min:5', 'max:125'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'min:5', 'max:125'],
            'company_email' => ['required', 'string', 'email', 'max:255'],

        ]);
        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            // 'password' => $this->password,
            'company_name' => $this->company_name,
            'company_email' => $this->company_email
        ]);
        $this->resetInput();
    }
    public function edit($id)
    {
        $record = User::findOrFail($id);
        $this->selected_id = $id;
        $this->first_name = $record->first_name;
        $this->last_name = $record->last_name;
        $this->email = $record->email;
        // $this->password = $record->password;
        $this->company_name = $record->company_name;
        $this->company_email = $record->company_email;

        $this->updateMode = true;
    }
    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'first_name' => ['required', 'string', 'min:5', 'max:125'],
            'last_name' => ['required', 'string', 'min:5', 'max:125'],
            'email' => ['required', 'string', 'email', 'max:255'],//, 'unique:users'
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['required', 'string', 'min:5', 'max:125'],
            'company_email' => ['required', 'string', 'email', 'max:255'],

        ]);
        if ($this->selected_id) {
            $record = User::find($this->selected_id);
            $record->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                // 'password' => $this->password,
                'company_name' => $this->company_name,
                'company_email' => $this->company_email
            ]);
            $this->resetInput();
            $this->updateMode = false;
        }
    }
    public function destroy($id)
    {
        if ($id) {
            $record = User::where('id', $id);
            $record->delete();
        }
    }
}