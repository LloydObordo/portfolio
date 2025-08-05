<nav class="navbar navbar-expand-lg navbar-light bg-dark fixed-top navbar-custom">
    <div class="container">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" height="50">
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/#home') || Route::currentRouteName() === 'welcome') active @endif" href="{{ url('/#home') }}">
                        Home
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/#about')) active @endif" href="{{ url('/#about') }}">
                        About
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/#experience')) active @endif" href="{{ url('/#experience') }}">
                        Experience
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/#projects') || Route::currentRouteName() === 'projects' || Request::is('project/*')) active @endif" 
                       href="{{ url('/#projects') }}">
                        Projects
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/#skills')) active @endif" href="{{ url('/#skills') }}">
                        Skills
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link @if(Request::is('/#contact')) active @endif" href="{{ url('/#contact') }}">
                        Contact
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>