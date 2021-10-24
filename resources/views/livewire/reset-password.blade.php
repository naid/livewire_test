<div class="col-md-4">
    @if($successMessage != '')
        <div class="alert alert-success">
            {{$successMessage}}
        </div>
    @enderror
<div class="card">
    <div class="card-header">Reset Password</div>
    <div class="card-body">
            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ 'Password' }}</label>
                <div class="col-md-6">
                    <input type="password" 
                        class="form-control"
                        name="password"
                        wire:model="password"
                        >
                        {{$password}}

                        @error('password')
                        <span class="help-block text-danger">{{$message}}</span>
                        @enderror

                </div>
            </div>
            <div class="form-group row">
                <label for="password_confirmation" class="col-md-4 col-form-label text-md-right">{{ 'Confirm Password' }}</label>
                <div class="col-md-6">
                    <input type="password" class="form-control" name="password_confirmation"
                    wire:model="password_confirmation"
                    >
                    {{$password_confirmation}}
                </div>
            </div>
            
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" wire:click="updatePassword" class="btn btn-primary">
                        {{ 'Change Password' }}
                    </button>
                </div>
            </div>
    </div>
</div>
</div>
