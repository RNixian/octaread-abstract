<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Login</title>

    <!-- Bootstrap CSS -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
@php
    $adminCount = \App\Models\adminmodel::count();
@endphp
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Admin Login</h2>

                    <script>
                        setTimeout(function() {
                            let alertBox = document.getElementById('logout-success');
                            if (alertBox) {
                                alertBox.style.display = 'none';
                            }
                        }, 3000); // 3 seconds
                    </script>
          
                
                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif



                      <form method="POST" action="{{ route('admin.adminlogin') }}">
    @csrf

    <!-- School ID -->
    <div class="mb-3">
        <label for="schoolid" class="form-label">School ID</label>
        <input type="text" class="form-control @error('schoolid') is-invalid @enderror" id="schoolid" name="schoolid" value="{{ old('schoolid') }}" required>
        @error('schoolid')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Birthdate -->
    <div class="mb-3">
        <label for="birthdate" class="form-label">Birthdate</label>
        <input type="date" class="form-control @error('birthdate') is-invalid @enderror" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>
        @error('birthdate')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <!-- Master Key -->
    <div class="mb-4">
        <label for="masterkey" class="form-label">Master Key</label>
        <input type="password" class="form-control @error('masterkey') is-invalid @enderror" id="masterkey" name="masterkey" required>
        @error('masterkey')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="d-grid">
        <button type="submit" class="btn btn-primary">Sign In</button>
   </div>
</form>
 <div class="d-grid mt-8">
@if ($adminCount === 0)
    <a href="{{ route('admin.adminregister') }}" class="btn btn-success">Register Admin</a>
@endif
 </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
