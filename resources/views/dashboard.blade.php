<!-- Font Awesome CDN (place in <head> ideally) -->
  <link rel="stylesheet" href="{{ url('css/all.min.css') }}">
    <!-- Responsive Header -->
    <header class="d-flex justify-content-between align-items-center p-3 custom-header-bg flex-wrap">
        <!-- Left Logo -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <img src="{{ asset('images/olpccr&m.png') }}" alt="Logo" style="height: 60px; width: auto; border: 2px solid black;">
        </div> 
    
        <!-- Right Logo -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <img src="{{ asset('images/logo2.jpg') }}" alt="Logo" 
                 style="height: 60px; width: auto; border-radius: 5%; border: 2px solid white;">
        </div> 
    </header>
    
    <!-- Custom CSS -->
    <style>
        .custom-header-bg {
            background-color: #001e3c;
        }
    
        @media (max-width: 576px) {
            header {
                flex-direction: column !important;
                text-align: center;
            }
            header > div {
                justify-content: center;
                width: 100%;
            }
        }
    </style>
    