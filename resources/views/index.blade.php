<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome To R&M</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

  <div class="container-flex">
    <!-- LEFT GRID - LOGIN BUTTONS -->
    <div class="left-panel">
      <a href="/pages/userlogin" title="User Login">
        <button>
          <img src="{{ asset('images/qcuser.png') }}" alt="User Logo">
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
