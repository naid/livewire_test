<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    public
        $headers,
        // $data,
        $first_name,
        $last_name,
        $email,
        // $password,
        $company_name,
        $company_email,
        $selected_id;
    public $updateMode = false;

    private function headerConfig()
    {
        return [
            'id' => 'ID',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'company_name' => 'Company Name',
            'company_email' => 'Company Email',
        ];
    }

    public function mount()
    {
        $this->headers = $this->headerConfig();
    }

    private function resultData()
    {
        //return User::all();
        return User::where('id', '!=', auth()->user()->id)->paginate(5);
    }

    public function render()
    {
        return view('livewire.user.list', [
            'data' => $this->resultData()
        ]);
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

    private function cancel()
    {
        $this->resetInput();
        $this->updateMode = false;
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