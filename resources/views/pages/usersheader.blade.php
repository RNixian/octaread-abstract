<!-- Font Awesome CDN (place in <head> ideally) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <header class="d-flex justify-content-between align-items-center p-3 custom-header-bg">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/RnMLogo.png') }}" alt="Logo" style="height: 40px; width: auto;">
        </div>
    
        @if(session()->has('firstname'))
            {{-- Welcome message in the center when logged in --}}
            <div class="text-white fw-semibold">
                Welcome: {{ session('firstname') }}
            </div>
        @endif
    
        <nav class="d-flex gap-3 align-items-center">
            <a href="{{ url('/pages/userdashboard') }}" class="nav-link">
                <i class="fas fa-house"></i> Home
            </a>
    
            @if(session()->has('firstname'))
                <a href="{{ url('/pages/ebook') }}" class="nav-link">
                    <i class="fas fa-book"></i> Research
                </a>
                <a href="{{ url('/pages/favorites') }}" class="nav-link">
                    <i class="fas fa-heart"></i> Favorites
                </a>
                <a href="{{ url('/pages/profile') }}" class="nav-link">
                    <i class="fas fa-user"></i> Profile
                </a>
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
        </nav>
    </header>
    
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
    
        .logout-button {
            color: white;
            background: none;
            border: none;
            cursor: pointer;
        }
    </style>
    