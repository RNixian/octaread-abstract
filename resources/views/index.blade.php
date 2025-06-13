<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Folder Loader with Login Buttons</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    .link-button {
      background-image: url('https://cdn-icons-png.flaticon.com/512/716/716784.png');
      background-size: contain;
      background-repeat: no-repeat;
      background-position: center;
      width: 300px;
      height: 300px;
      border: none;
      cursor: pointer;
      background-color: transparent;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .login-buttons {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-wrap: wrap;
      gap: 4rem;
    }

    footer {
      background-color: #f8f9fa;
    }
  </style>
</head>
<body class="bg-light">

  <div>@include('dashboard')</div>

  <div class="login-buttons">
    <a href="/pages/userlogin">
      <button class="link-button" title="User Login">
        <img src="{{ asset('images/user.png') }}" alt="User Logo" style="height: 150px; width: auto; margin-top: 50px;">
      </button>
    </a>
    <a href="/admin/adminlogin">
      <button class="link-button" title="Admin Login">
        <img src="{{ asset('images/admin.png') }}" alt="Admin Logo" style="height: 150px; width: auto; margin-top: 50px;">
      </button>
    </a>
  </div>

  <footer>@include('pages.userfooter')</footer>

</body>
</html>
