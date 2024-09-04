@auth
<a href="{{ route('logout') }}">Logout</a>
@endauth


@auth
    @if (Route::is('admin-*'))
        <a href="{{ route('index') }}">View Site</a>
    @else
        @if (auth()->user()->role_id == 1)
            <a href="{{ route('admin') }}">Admin Panel</a>
        @endif
    @endif
@endauth