<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Address;
use App\Models\Contact;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Carbon\Carbon;
use App\Jobs\SendEmail;

class UserComponent extends Component
{
    use WithPagination, WithFileUploads;

    public $showList = TRUE;
    public $output = '';
    public $photo;
    public $photoUploaded;

    public $addresses = [];
    public $contacts = [];
    public $updateAddresses = [];
    public $updateContacts = [];

    public $outputStatus = 'success';
    
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
        $address_id,
        $address1,
        $address2,
        $suburb,
        $post_code,
        $city;
    //CONTACT PORTION
    public
        $contact_id,
        $mobile_number,
        $work_number,
        $home_number;
    //ADDRESS PORTION
    public
        $ua_address_id,
        $ua_address1,
        $ua_address2,
        $ua_suburb,
        $ua_post_code,
        $ua_city;
    //CONTACT PORTION
    public
        $uc_contact_id,
        $uc_mobile_number,
        $uc_work_number,
        $uc_home_number;

    public $updateMode = FALSE;
    
    public function readPhoto($id) 
    {
        $user_id = $id;
        $path = 'http://'.$_SERVER['HTTP_HOST']."/storage/$user_id/image";

        $imgArr = [
            '.jpg',
            '.jpeg',
            '.png',
            '.gif',
        ];

        foreach($imgArr as $ext) {
            if ($data = @getimagesize($path.$ext)) {
                $this->photoUploaded = $path.$ext;
                return;
            }
        }
    }

    public function savePhoto() 
    {
        $user_id = $this->selected_id;
        $file_ext = $this->photo->extension();
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

        // /{user_id}/{file_name}
        $imageName = 'image.'.$file_ext;

        // get all file names
        $path = config('filesystems.disks.public.root').'/'.$user_id;
        $files = glob("$path/*"); 
        

        //delete all files first
        foreach($files as $file) { // iterate files
            if(is_file($file)) {
                unlink($file); // delete file
            }   
        }

        //SAVE NEW IMAGE FILE
        $this->photo->storeAs("public/$user_id", $imageName);

    }

    private function clearData()
    {
        unset($this->addresses);
        unset($this->contacts);
        unset($this->updateAddresses);
        unset($this->updateContacts);

        $this->addresses = [];
        $this->contacts = [];
        $this->updateAddresses = [];
        $this->updateContacts = [];

        $this->resetInput();
    }

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

    private function resetInput()
    {
        $this->first_name = null;
        $this->last_name = null;
        $this->email = null;
        // $this->password = null;
        $this->company_name = null;
        $this->company_email = null;

        unset($this->address_id);
        unset($this->address1);
        unset($this->address2);
        unset($this->suburb);
        unset($this->post_code);
        unset($this->city);

        unset($this->contact_id);
        unset($this->mobile_number);
        unset($this->work_number);
        unset($this->home_number);

        unset($this->ua_address_id);
        unset($this->ua_address1);
        unset($this->ua_address2);
        unset($this->ua_suburb);
        unset($this->ua_post_code);
        unset($this->ua_city);

        unset($this->uc_contact_id);
        unset($this->uc_mobile_number);
        unset($this->uc_work_number);
        unset($this->uc_home_number);
    }

    private function resultData()
    {
        return User::paginate(10);
    }

    public function mount()
    {
        $this->headers = $this->headerConfig();
        $this->clearData();
    }

    public function cancel()
    {
        $this->showList = TRUE;
        $this->updateMode = FALSE;
    }

    public function addUser()
    {
        $this->output = "";

        $this->clearData();
        $this->showList = FALSE;
        $this->updateMode = FALSE;
    }

    public function addAddress()
    {
        $this->addresses[] = '';
    }

    public function addContact()
    {
        $this->contacts[] = '';
    }

    public function removeAddress($index)
    {
        unset($this->addresses[$index]);
    }

    public function removeContact($index)
    {
        unset($this->contacts[$index]);
    }

    public function removeExistingAddress($index)
    {
        $address = ADDRESS::findOrFail($index);
        $address->users()->detach();
        $address->delete();

        foreach($this->updateAddresses as $ind => $val) {
            if($val->id == $index) {
                unset($this->updateAddresses[$ind]);
            }
        }

        $this->output = "Address Removed.";
        $this->outputStatus = "success";
    }

    public function removeExistingContact($index)
    {
        $this->output = "Removing Contact: $index";
        $contact = CONTACT::findOrFail($index);
        $contact->users()->detach();
        $contact->delete();

        foreach($this->updateContacts as $ind => $val) {
            if($val->id == $index) {
                unset($this->updateContacts[$ind]);
            }
        }

        $this->output = "Contact Removed.";
        $this->outputStatus = "success";
    }

    public function render()
    {
        return view('livewire.user.list', [
            'data' => $this->resultData()
        ]);

        $this->output = "";
    }

    public function store()
    {
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
            'company_name' => $this->company_name ?? '',
            'company_email' => $this->company_email ?? '',
        ]);

        //assign role as generic
        $user->assignRole('moderator');

        foreach($this->addresses as $a_index => $a_val) {
            $address = Address::create([
                'address1' => $this->address1[$a_index] ?? '',
                'address2' => $this->address2[$a_index] ?? '',
                'suburb' => $this->suburb[$a_index] ?? '',
                'post_code' => $this->post_code[$a_index] ?? '',
                'city' => $this->city[$a_index] ?? '',
            ]);

            $address->users()->save($user);
        }

        foreach($this->contacts as $a_index => $a_val) {
            $contact = Contact::create([
                'mobile_number' => $this->mobile_number[$a_index] ?? '',
                'work_number' => $this->work_number[$a_index] ?? '',
                'home_number' => $this->home_number[$a_index] ?? '',
            ]);

            $contact->users()->save($user);
        }

        //SEND EMAIL
        $details = ['email' => $this->email];
        $emailJob = (new SendEmail($details))->delay(Carbon::now()->addMinutes(5));
        dispatch($emailJob);

        $this->showList = TRUE;
        $this->clearData();

        $this->output = "User Added.";
        $this->outputStatus = "success";
    }

    public function edit($id)
    {
        $this->output = "";
        $this->readPhoto($id);

        $this->showList = FALSE;
        $record = User::findOrFail($id);
        $this->selected_id = $id;
        $this->first_name = $record->first_name;
        $this->last_name = $record->last_name;
        $this->email = $record->email;

        $this->company_name = $record->company_name;
        $this->company_email = $record->company_email;

        $this->updateMode = TRUE;
        $this->updateAddresses = $record->addresses;
        $this->updateContacts = $record->contacts;

        //Get Address DATA to bind to data on frontend
        foreach($record->addresses as $a_index => $a_val) {
            $this->ua_address_id[$a_val->id] = $a_val->id;
            $this->ua_address1[$a_val->id] = $a_val->address1;
            $this->ua_address2[$a_val->id] = $a_val->address2;
            $this->ua_suburb[$a_val->id] = $a_val->suburb;
            $this->ua_post_code[$a_val->id] = $a_val->post_code;
            $this->ua_city[$a_val->id] = $a_val->city;
        }

        //Get Contacts DATA to bind to data on frontend
        foreach($record->contacts as $a_index => $a_val) {
            $this->uc_contact_id[$a_val->id] = $a_val->id;
            $this->uc_mobile_number[$a_val->id] = $a_val->mobile_number;
            $this->uc_work_number[$a_val->id] = $a_val->work_number;
            $this->uc_home_number[$a_val->id] = $a_val->home_number;
        }

    }

    public function update()
    {
        $this->validate([
            'selected_id' => 'required|numeric',
            'first_name' => ['required', 'string', 'min:5', 'max:125'],
            'last_name' => ['required', 'string', 'min:5', 'max:125'],
            'email' => ['required', 'string', 'email', 'max:255'],//, 'unique:users'
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            'company_name' => ['nullable', 'string', 'min:5', 'max:125'],
            'company_email' => ['nullable', 'string', 'email', 'max:255'],

        ]);
        if ($this->selected_id) {
            $user = User::find($this->selected_id);
            $user->update([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                // 'password' => $this->password,
                'company_name' => $this->company_name,
                'company_email' => $this->company_email
            ]);

            //ADD NEW ADDRESSES
            foreach($this->addresses as $a_index => $a_val) {
                $address = Address::create([
                    'address1' => $this->address1[$a_index] ?? '',
                    'address2' => $this->address2[$a_index] ?? '',
                    'suburb' => $this->suburb[$a_index] ?? '',
                    'post_code' => $this->post_code[$a_index] ?? '',
                    'city' => $this->city[$a_index] ?? '',
                ]);
    
                $address->users()->save($user);
            }
    
            //ADD NEW CONTACTS
            foreach($this->contacts as $a_index => $a_val) {
                $contact = Contact::create([
                    'mobile_number' => $this->mobile_number[$a_index] ?? '',
                    'work_number' => $this->work_number[$a_index] ?? '',
                    'home_number' => $this->home_number[$a_index] ?? '',
                ]);
    
                $contact->users()->save($user);
            }

            //UPDATE ADDRESSES
            foreach($this->updateAddresses as $a_index => $a_val) {
                $address = Address::find($this->ua_address_id[$a_val->id]);
                $address->update([
                    'address1' => $this->ua_address1[$a_val->id] ?? '',
                    'address2' => $this->ua_address2[$a_val->id] ?? '',
                    'suburb' => $this->ua_suburb[$a_val->id] ?? '',
                    'post_code' => $this->ua_post_code[$a_val->id] ?? '',
                    'city' => $this->ua_city[$a_val->id] ?? '',
                ]);
            }
    
            //UPDATE CONTACTS
            foreach($this->updateContacts as $a_index => $a_val) {
                $contact = Contact::find($this->uc_contact_id[$a_val->id]);
                $contact->update([
                    'mobile_number' => $this->uc_mobile_number[$a_val->id] ?? '',
                    'work_number' => $this->uc_work_number[$a_val->id] ?? '',
                    'home_number' => $this->uc_home_number[$a_val->id] ?? '',
                ]);
            }

            $this->updateMode = FALSE;
        }
        $this->clearData();
        $this->showList = TRUE;

        $this->output = 'User Updated.';
        $this->outputStatus = 'success';
    }

    public function destroy($id)
    {
        if ($id) {
            $record = User::find($id);
            $record->addresses()->delete();
            $record->addresses()->detach();
            $record->contacts()->delete();
            $record->contacts()->detach();
            $record->delete();
        }

        $this->output = 'User Deleted.';
        $this->outputStatus = 'success';
    }
}