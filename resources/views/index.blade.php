<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome To R&M</title>
 <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    .container-flex {
      display: grid;
      grid-template-columns: 1fr 2fr;
      height: 100%;
    }

    .left-panel {
      background-color: #f0f0f0;
      padding: 2rem;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
    }

    .left-panel img {
      height: 300px;
      width: auto;
    }

    .left-panel span {
      font-size: 1.2rem;
      margin-top: 1rem;
    }

    .right-panel {
      padding: 3rem 2rem;
      overflow-y: auto;
      background-color: #fff;
    }

    .feature-title {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 2rem;
    }

    .feature-box {
      background-color: #f9f9f9;
      border-left: 5px solid #007bff;
      padding: 1rem 1.5rem;
      margin-bottom: 1rem;
      border-radius: 0.5rem;
      font-size: 1.1rem;
    }

    footer {
      background-color: #f8f9fa;
      text-align: center;
      padding: 1rem;
    }

    button {
      border: none;
      background: none;
      padding: 0;
    }

    @media (max-width: 768px) {
      .container-flex {
        grid-template-columns: 1fr;
      }

      .left-panel, .right-panel {
        padding: 2rem 1rem;
      }

      .left-panel img {
        height: 200px;
      }
    }


  </style>
</head>
<body class="bg-light">

  <div>@include('dashboard')</div>
<style>
  .carousel-container {
    height: 50vh;
  }

  @media (max-width: 768px) {
    .carousel-container {
      height: 30vh;
    }
  }

  .carousel-item img {
    width: auto;
    height: 100%;
    object-fit: stretch; /* optional for better image fit */
  }
</style>

<div id="carouselExampleIndicators" class="carousel slide carousel-container" data-bs-ride="carousel" data-bs-interval="3000">
  <div class="carousel-inner h-100">
    @foreach($carouselItems as $item)
      <div class="carousel-item {{ $loop->first ? 'active' : '' }} h-100">
        <img src="{{ url('storage/' . $item->carousel_imgpath) }}" class="d-block w-100" alt="Slide">
      </div>
    @endforeach
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>

  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>



  <div class="container-flex">
    <!-- LEFT GRID - LOGIN BUTTONS -->
    <div class="left-panel">
      <a href="/pages/userlogin" title="User Login">
        <button>
          <img src="{{ url('images/qrcode.png') }}" alt="User Logo">
        </button>
      </a>
      <span>Scan to enter</span>
    </div>

    <!-- RIGHT GRID - FEATURES -->
    <div class="right-panel">
      <h3 class="feature-title">Explore Our Features</h3>

      <div class="feature-box">🔍 Recently Added Books</div>
      <div class="feature-box">👥 View All Members</div>
      <div class="feature-box">💼 Our Services</div>
      <div class="feature-box">🔐 Login Types (Student, Employee, Guest)</div>
      <div class="feature-box">📝 Sign Up Easily</div>
    </div>
  </div>

  <div>@include('pages.userfooter')</div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
