<!-- Font Awesome CDN (place in <head> ideally) -->
    <link rel="stylesheet" href="{{ url('css/all.min.css') }}">

    <header class="d-flex justify-content-between align-items-center p-3 custom-header-bg flex-wrap">
     <!-- Logo -->
<div class="d-flex align-items-center me-3">
    <img src="{{ asset('images/olpccr&m.png') }}" alt="Logo" style="height: 50px; width: auto; border: 2px solid black;">
</div>

<!-- Welcome Text -->
@if(session()->has('firstname'))
    <div class="text-white fw-semibold d-block me-auto">

        @if(str_starts_with(session('schoolid'), 'guest'))
            Welcome Guest: {{ session('firstname') }}
        @else
            Welcome: {{ session('firstname') }}
        @endif
    </div>
@endif

    
        <!-- Toggle Button for Small Screens -->
        <button class="navbar-toggler d-md-none text-white border-0 bg-transparent" type="button" onclick="toggleNav()">
            <i class="fas fa-bars fa-lg"></i>
        </button>
    
        <!-- Navigation Menu -->
        <div id="navbarMenu" class="d-none d-md-flex flex-column flex-md-row align-items-md-center ms-md-auto gap-3 mt-3 mt-md-0">
            <a href="{{ url('/pages/userdashboard') }}" class="nav-link">
                <i class="fas fa-house"></i> Home
            </a>
    
            @if(session()->has('firstname'))
                <a href="{{ url('/pages/ebook') }}" class="nav-link">
                    <i class="fas fa-book"></i> Research
                </a>
    
                @if(!str_starts_with(session('schoolid'), 'guest'))
                    <a href="{{ url('/pages/favorites') }}" class="nav-link">
                        <i class="fas fa-heart"></i> Favorites
                    </a>
                    <a href="{{ url('/pages/profile') }}" class="nav-link">
                        <i class="fas fa-user"></i> Profile
                    </a>
                @endif
    
                <form method="POST" action="{{ route('pages.logoutuser') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link logout-button" aria-label="Log out">
                        <i class="fas fa-right-from-bracket"></i> Log Out
                    </button>
                </form>
            @else
                <a href="{{ url('/pages/userlogin') }}" class="nav-link">
                    <i class="fas fa-sign-in-alt"></i> Login
                </a>
                <a href="{{ url('/pages/registeruser') }}" class="nav-link">
                    <i class="fas fa-user-plus"></i> Sign Up
                </a>
            @endif
        </div>
    </header>
    
    <!-- Style -->
    <style>
        .custom-header-bg {
            background-color: #001e3c;
        }
    
        .nav-link {
            color: white;
            text-decoration: none;
        }
    
        .nav-link:hover {
            text-decoration: underline;
        }
    
        .nav-link,
        .logout-button {
            padding: 0.5rem 1rem;
            color: white;
            text-decoration: none;
            border-radius: 5%;
            transition: background-color 0.3s, color 0.3s;
            margin-left: 0;
            display: inline-block;
        }
    
        .nav-link:hover,
        .logout-button:hover {
            background-color: rgba(255, 165, 0, 1);
            color: #001e3c;
            text-decoration: none;
            border-radius: 5%;
        }
    
        .logout-button {
            background: none;
            border: none;
            cursor: pointer;
        }
    
        @media (max-width: 768px) {
            #navbarMenu {
                flex-direction: column !important;
                width: 100%;
                background-color: #001e3c;
                padding: 10px 0;
                margin-top: 10px;
            }
    
            .nav-link,
            .logout-button {
                display: block;
                width: 100%;
                text-align: left;
                padding: 10px 15px;
                margin: 0;
            }
        }
    </style>
    
    <!-- Script -->
    <script>
        function toggleNav() {
            const nav = document.getElementById('navbarMenu');
            if (nav.classList.contains('d-none')) {
                nav.classList.remove('d-none');
                nav.classList.add('d-flex');
            } else {
                nav.classList.remove('d-flex');
                nav.classList.add('d-none');
            }
        }
    </script>
    