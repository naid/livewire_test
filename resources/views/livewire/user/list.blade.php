<div class="flex card col-lg-12">
    <div class="card-body">
    @if ($output != '')
        <p class="alert alert-{{ $outputStatus }}">{{ $output }}</p>
    @endif
    @if ($showList == TRUE)
    <div class="flex">
        <div class="flex flex-1">
            <h3>Users</h3>
        </div>
        <div class="flex flex-1 justify-end">
            <button wire:click.prevent="addUser()" class="btn btn-success">
                Add User
            </button>
        </div>
    </div>
    
    
    <table class="table table-striped" style="margin-top:20px;">
        <tr>
            @foreach($headers as $key => $value)
                <td>{{strtoupper($value)}}</td>
            @endforeach
            
            <!-- <td>FIRST NAME</td>
            <td>LAST NAME</td>
            <td>EMAIL</td>
            <td>COMPANY NAME</td>
            <td>COMPANY EMAIL</td>-->
            <td>ACTION</td> 
        </tr>

        @foreach($data as $row)
            <tr>
                @foreach($headers as $key => $value)
                    @if(in_array($key, ['id', 'email']))
                        <td><button wire:click="edit({{$row->id}})" class="btn btn-sm btn-link py-0">{{$row->$key}}</button></td>
                    @else
                        <td>{{$row->$key}}</td>
                    @endif
                    
                @endforeach
                <!-- <td>{{$loop->index + 1}}) {{$row->id}}</td>
                <td>{{$row->first_name}}</td>
                <td>{{$row->last_name}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->company_name}}</td>
                <td>{{$row->company_email}}</td> -->

                <td>
                    <button wire:click="edit({{$row->id}})" class="btn btn-sm btn-warning py-0">Edit</button> | 
                    <button wire:click="destroy({{$row->id}})" class="btn btn-sm btn-danger py-0">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
    {{$data->links()}}
    @endif
    </div>

    <div class="col-md-12">
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Sorry!</strong> invalid input.<br><br>
            <ul style="list-style-type:none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($showList == FALSE)
        @if($updateMode)
            @include('livewire.user.update')
        @else
            @include('livewire.user.create')
        @endif
    @endif
    </div>

</div> 