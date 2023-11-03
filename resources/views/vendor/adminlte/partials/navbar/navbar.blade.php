<nav class="navbar navbar-expand-lg navbar-light navbar-fixed-top">
    <div class="container">
        <a class="navbar-brand w-50" href="/"><img class="img-fluid w-50"
                src="{{ asset('landingpage/img/icon/logo.png') }}" alt="logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
            aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                {{-- Custom right links --}}
                @yield('content_top_nav_right')
        
                {{-- Configured right links --}}
                @each('adminlte::partials.navbar.menu-item', $adminlte->menu('navbar-right'), 'item')
        
                {{-- User menu link --}}
                @if(Auth::user())
                    @if(config('adminlte.usermenu_enabled'))
                        @include('adminlte::partials.navbar.menu-item-dropdown-user-menu')
                    @else
                        @include('adminlte::partials.navbar.menu-item-logout-link')
                    @endif
                @endif
        
                {{-- Right sidebar toggler link --}}
                @if(config('adminlte.right_sidebar'))
                    @include('adminlte::partials.navbar.menu-item-right-sidebar-toggler')
                @endif
            </ul>
        </div>
    </div>
</nav>

   

