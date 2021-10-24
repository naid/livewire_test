<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Address;
use Livewire\Component;
use Livewire\WithPagination;

class UserComponent extends Component
{
    use WithPagination;
    public $addresses = [];
    public $contacts = [];
    public $saved = FALSE;
    public $output = "NO OUTPUT";
    //USER PORTION
    public
        $headers,
        $first_name,
        $last_name,
        $email,
        $company_name,
        $company_email,
        $selected_id;
    //ADDRESS PORTION
    public
        $address1,
        $address2,
        $suburb,
        $post_code,
        $city;
    //CONTACT PORTION
    public
        $mobile_number,
        $work_number,
        $home_number;

    public $updateMode = false;

    private function headerConfig()
    {
        return [
            'id' => 'I453554D',
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

    public function addAddress()
    {
        $this->addresses[] = '';
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

    public function updated($key, $val)
    {
        $this->saved = FALSE;
        $this->output = "UPDATING $key:$val=".print_r($this->addresses, true);
        foreach($this->addresses as $zind => $zval) {
            //$this->output .= print_r([$zind,$zval);
        }
    }


    public function store()
    {$this->output = print_r($this->address1, true);
        $this->validate([
            'first_name' => ['required', 'string', 'min:5', 'max:125'],
            'last_name' => ['required', 'string', 'min:5', 'max:125'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['nullable', 'string', 'min:5', 'max:125'],
            'company_email' => ['nullable', 'string', 'email', 'max:255'],

        ]);

        $user = User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => mt_rand(5, 15),
            'company_name' => $this->company_name,
            'company_email' => $this->company_email
        ]);

        
        foreach($this->addresses as $a_index => $a_val) {
            $address = Address::create([
                'address1' => $this->address1[$a_index],
                'address2' => $this->address2[$a_index],
                'suburb' => $this->suburb[$a_index],
                'post_code' => $this->post_code[$a_index],
                'city' => $this->city[$a_index]
            ]);

            $address->users()->save($user);
        }

        $this->output .= "USER:ID CREATED: ".$user->id;

        //$this->resetInput();
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