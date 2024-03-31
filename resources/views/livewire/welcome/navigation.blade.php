<ul class="flex gap-2 items-center flex-col list-none p-0">
    @auth
        <li><x-link href="{{ route('dashboard') }}" />Dashboard</li>
    @else
        <li><x-link href="{{ route('login') }}" />Log</li>
        @if (Route::has('register'))
            <li><x-link href="{{ route('register') }}" />Register</li>
        @endif
    @endauth
</ul>
