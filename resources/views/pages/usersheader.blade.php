<!-- Font Awesome -->
<link rel="stylesheet" href="{{ url('css/all.min.css') }}">

<header class="d-flex justify-content-between align-items-center p-3 custom-header-bg flex-wrap">
    <!-- Logo -->
    <div class="d-flex align-items-center me-3">
        <img src="{{ url('images/load.png') }}" alt="Logo" style="height: 50px; width: auto;">
    </div>

    <!-- Welcome Text -->
  @if(Auth::guard('web')->check())
  <div class="text-white fw-semibold">
    @php $user = Auth::guard('web')->user(); @endphp

    @if(session('is_guest'))
        Welcome Guest: {{ $user->firstname }}
    @else
        Welcome: {{ $user->firstname }}
    @endif
  </div>
@endif


    <!-- Toggle Button for Small Screens -->
    <button class="navbar-toggler d-md-none text-white border-0 bg-transparent" type="button" onclick="toggleNav()">
        <i class="fas fa-bars fa-lg"></i>
    </button>

    <!-- Navigation Menu -->
    <div id="navbarMenu" class="d-none d-md-flex flex-column flex-md-row align-items-md-center ms-md-auto gap-3 mt-3 mt-md-0">
        <a href="{{ route('pages.userdashboard') }}" class="nav-link">
            <i class="fas fa-house"></i> Home
        </a>

       @if(Auth::guard('web')->check())
    <a href="{{ route('pages.ebook') }}" class="nav-link"><i class="fas fa-book"></i> Research</a>

    @if(!session('is_guest'))
        <a href="{{ route('pages.favorites') }}" class="nav-link"><i class="fas fa-heart"></i> Favorites</a>
        <a href="{{ route('pages.profile') }}" class="nav-link"><i class="fas fa-user"></i> Profile</a>
    @endif

    <form method="POST" action="{{ route('pages.logoutuser') }}" class="m-0 p-0">
        @csrf
        <button type="submit" class="nav-link logout-button"><i class="fas fa-right-from-bracket"></i> Log Out</button>
    </form>
@else
    <a href="{{ route('pages.userlogin') }}" class="nav-link"><i class="fas fa-sign-in-alt"></i> Login</a>
    <a href="{{ route('pages.registeruser') }}" class="nav-link"><i class="fas fa-user-plus"></i> Sign Up</a>
@endif

    </div>
</header>

<!-- Styles -->
<style>
    .custom-header-bg {
        background-color: #001e3c;
    }

    .nav-link,
    .logout-button {
        color: white;
        text-decoration: none;
        padding: 0.5rem 1rem;
        border: none;
        background: none;
        border-radius: 4px;
        transition: background-color 0.3s, color 0.3s;
        display: inline-block;
        text-align: left;
    }

    .nav-link:hover,
    .logout-button:hover {
        background-color: rgba(255, 165, 0, 1);
        color: #001e3c;
    }

    .logout-button {
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
            padding: 10px 15px;
            margin: 0;
        }
    }
</style>

<!-- Script -->
<script>
    function toggleNav() {
        const nav = document.getElementById('navbarMenu');
        nav.classList.toggle('d-none');
        nav.classList.toggle('d-flex');
    }
</script>
