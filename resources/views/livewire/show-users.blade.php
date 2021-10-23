@if (Auth::check())
    <div>
        @if($users)
            list users here:
            @foreach($users as $user)
                {{$user->first_name}}
            @endforeach
        @else
            NOT LOGGED IN SO NO LIST USERS
        @endif
    </div>
@else
NOT LOGGED INN
@endif
