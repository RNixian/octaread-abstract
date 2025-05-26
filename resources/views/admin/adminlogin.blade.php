<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Login</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2 class="text-center mb-4">Admin Login</h2>

                        {{-- Validation Error --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>

                    <script>
                        setTimeout(function() {
                            let alertBox = document.getElementById('logout-success');
                            if (alertBox) {
                                alertBox.style.display = 'none';
                            }
                        }, 3000); // 3 seconds
                    </script>
                @endif
                
                {{-- Success Message --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                        <form method="POST" action="{{ route('admin.adminlogin') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="schoolid" class="form-label">School ID</label>
                                <input type="text" class="form-control" id="schoolid" name="schoolid" required>
                            </div>

                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" class="form-control" id="birthdate" name="birthdate" required>
                            </div>

                            <div class="mb-4">
                                <label for="masterkey" class="form-label">Master Key</label>
                                <input type="password" class="form-control" id="masterkey" name="masterkey" required>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary">Sign In</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
