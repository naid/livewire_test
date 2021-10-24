<div class="flex">
    <div class="card flex-1 m-1">
            <div class="card-body">
            <h3>Update User</h3>
                <input type="hidden" wire:model="selected_id">
                <div class="flex justify-center m-2">
                    <form wire:submit.prevent="savePhoto">
                        @if ($photoUploaded)
                            <img src="{{ $photoUploaded }}">
                        @endif
                        <input type="file" wire:model="photo">
                    
                        @error('photo') <span class="error">{{ $message }}</span> @enderror
                        @if ($photo)
                            <button type="submit" class="btn btn-sm btn-success">Save Photo</button>
                        @endif
                    </form>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">First Name</label>
                    <input type="text" wire:model="first_name" class="form-control input-sm"  placeholder="first_name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Last Name</label>
                    <input type="text" wire:model="last_name" class="form-control input-sm"  placeholder="last_name">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" class="form-control input-sm" placeholder="Enter email" wire:model="email">
                </div>

                <div class="form-group">
                    <label for="exampleInputPassword1">Company Name</label>
                    <input type="text" wire:model="company_name" class="form-control input-sm"  placeholder="company_name">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Company Email</label>
                    <input type="email" class="form-control input-sm" placeholder="Company email" wire:model="company_email">
                </div>
        </div>
                <div class="flex justify-center m-1">
                    <div class="m-1">
                        <button wire:click="update()" class="btn btn-success">
                            Update
                        </button>
                    </div>
                    <div class="m-1">
                        <button wire:click="cancel()" class="btn btn-danger">
                            Cancel
                        </button>
                    </div>
                </div>

            </div>
    <!-- DYNAMIC ADDRESS -->
    <div class="flex-1 m-1">
        <div class="mt-3 mb-2">
            <button wire:click.prevent="addAddress()" class="btn btn-success">
                Add Address
            </button>
        </div>
        @foreach($addresses as $a_index => $a_val)
        <div class="card mt-1 mb-2">
            <div class="card-body">
                <div class="flex justify-end">
                    <button wire:click.prevent="removeAddress({{$a_index}})" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash">Remove</i>
                    </button>
                </div>
                <div class="flex">
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Address1</label>
                        <input type="text" wire:model="address1.{{$a_index}}" class="form-control input-sm"  placeholder="Address1">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Address2</label>
                        <input type="text" wire:model="address2.{{$a_index}}" class="form-control input-sm"  placeholder="Address2">
                    </div>
                </div>
                <div class="flex">
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Suburb</label>
                        <input type="text" wire:model="suburb.{{$a_index}}" class="form-control input-sm"  placeholder="Suburb">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Post Code</label>
                        <input type="text" wire:model="post_code.{{$a_index}}" class="form-control input-sm"  placeholder="Post Code">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">City</label>
                        <input type="text" wire:model="city.{{$a_index}}" class="form-control input-sm"  placeholder="City">
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($updateAddresses as $a_index => $a_val)
        <div class="card mt-1 mb-2">
            <div class="card-body">
                <div class="flex justify-end">
                    <button wire:click.prevent="removeExistingAddress({{$a_val->id}})" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash">Remove</i>
                    </button>
                    <input type="hidden" wire:model="ua_address_id.{{$a_val->id}}">
                </div>
                <div class="flex">
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Address1</label>
                        <input type="text" wire:model="ua_address1.{{$a_val->id}}"
                            class="form-control input-sm"
                            placeholder="Address1"
                            value="{{$a_val->address1}}">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Address2</label>
                        <input type="text" wire:model="ua_address2.{{$a_val->id}}"
                            class="form-control input-sm"
                            placeholder="Address2"
                            value="{{$a_val->address2}}">
                    </div>
                </div>
                <div class="flex">
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Suburb</label>
                        <input type="text" wire:model="ua_suburb.{{$a_val->id}}"
                            class="form-control input-sm"
                            placeholder="Suburb"
                            value="{{$a_val->suburb}}">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Post Code</label>
                        <input type="text" wire:model="ua_post_code.{{$a_val->id}}"
                            class="form-control input-sm"
                            placeholder="Post Code"
                            value="{{$a_val->post_code}}">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">City</label>
                        <input type="text" wire:model="ua_city.{{$a_val->id}}"
                            class="form-control input-sm"
                            placeholder="City"
                            value="{{$a_val->city}}">
                    </div>
                </div>
            </div>
        </div>
        @endforeach        
    </div>


    <!-- DYNAMIC CONTACT -->
    <div class="flex-1 m-1">
        <div class="mt-3 mb-2">
            <button wire:click.prevent="addContact()" class="btn btn-success">
                Add Contact
            </button>
        </div>
        @foreach($contacts as $a_index => $a_val)
        <div class="card mt-1 mb-2">
            <div class="card-body">
                <div class="flex justify-end">
                    <button wire:click.prevent="removeContact({{$a_index}})" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash">Remove</i>
                    </button>
                </div>
                <div class="flex">
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Mobile Number</label>
                        <input type="text" wire:model="mobile_number.{{$a_index}}" class="form-control input-sm"  placeholder="Mobile Number">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Work Number</label>
                        <input type="text" wire:model="work_number.{{$a_index}}" class="form-control input-sm"  placeholder="Work Number">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Home Number</label>
                        <input type="text" wire:model="home_number.{{$a_index}}" class="form-control input-sm"  placeholder="Home Number">
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($updateContacts as $a_index => $a_val)
        <div class="card mt-1 mb-2">
            <div class="card-body">
                <div class="flex justify-end">
                    <button wire:click.prevent="removeExistingContact({{$a_val->id}})" class="btn btn-sm btn-danger">
                        <i class="bi bi-trash">Remove</i>
                    </button>
                    <input type="hidden" wire:model="uc_contact_id.{{$a_val->id}}">
                </div>
                <div class="flex">
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Mobile Number</label>
                        <input type="text" wire:model="uc_mobile_number.{{$a_val->id}}" class="form-control input-sm"  placeholder="Mobile Number">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Work Number</label>
                        <input type="text" wire:model="uc_work_number.{{$a_val->id}}" class="form-control input-sm"  placeholder="Work Number">
                    </div>
                    <div class="form-group flex-1 m-1">
                        <label for="exampleInputPassword1">Home Number</label>
                        <input type="text" wire:model="uc_home_number.{{$a_val->id}}" class="form-control input-sm"  placeholder="Home Number">
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    window.livewire.on('imageChosen', () => {
        let inputField = document.getElementById('image');
        let file = inputField.files[0];
        let reader = new FileReader();
        reader.onloadend = () => {
            window.livewire.emit('fileUpload', reader.result);
        };

        reader.readAsDataURL(file);
    });
</script>
