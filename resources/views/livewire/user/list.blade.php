<div>
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


    @if($updateMode)
        @include('livewire.user.update')
    @else
        @include('livewire.user.create')
    @endif

    <livewire:users-table/>
    <table class="table table-striped" style="margin-top:20px;">
        <tr>
            <td>NO</td>
            <td>FIRST NAME</td>
            <td>LAST NAME</td>
            <td>EMAIL</td>
            <td>COMPANY NAME</td>
            <td>COMPANY EMAIL</td>
            <td>ACTION</td>
        </tr>

        @foreach($data as $row)
            <tr>
                <td>{{$loop->index + 1}}) {{$row->id}}</td>
                <td>{{$row->first_name}}</td>
                <td>{{$row->last_name}}</td>
                <td>{{$row->email}}</td>
                <td>{{$row->company_name}}</td>
                <td>{{$row->company_email}}</td>

                <td>
                    <button wire:click="edit({{$row->id}})" class="btn btn-sm btn-outline-danger py-0">Edit</button> | 
                    <button wire:click="destroy({{$row->id}})" class="btn btn-sm btn-outline-danger py-0">Delete</button>
                </td>
            </tr>
        @endforeach
    </table>
    </div>

</div> 