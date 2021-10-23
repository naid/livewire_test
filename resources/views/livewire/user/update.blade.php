<div>
    <input type="hidden" wire:model="selected_id">
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
    <button wire:click="update()" class="btn btn-primary">Update</button>
    <button wire:click="update()" class="btn btn-primary">Cancel</button>
</div>