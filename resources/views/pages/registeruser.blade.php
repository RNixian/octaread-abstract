<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Registration</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header -->
    @include('pages.usersheader')

    <!-- Registration Section -->
    <div class="container my-5 flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <h3 class="text-center mb-4">User Register</h3>

                        {{-- Validation Errors --}}
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('pages.storeuser') }}" method="POST">
                            @csrf

                            <div class="row">
                                @foreach (['firstname' => 'First Name', 'middlename' => 'Middle Name', 'lastname' => 'Last Name'] as $field => $label)
                                    <div class="col-md-4 mb-3">
                                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                        <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row">
                                @foreach (['schoolid' => 'School Id','course' => 'Course'] as $field => $label)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                        <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control" required>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mb-3">
                                <label for="birthdate" class="form-label">Birthdate</label>
                                <input type="date" id="birthdate" name="birthdate" class="form-control" required>
                            </div>
                            

                            <div class="d-grid">
                                <button type="submit" class="btn btn-success">Register</button>
                            </div>

                            <div class="text-center mt-3">
                                <a href="{{ route('pages.userlogin') }}" class="text-decoration-none text-primary">Already have an account?</a>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

   @include('pages.userfooter')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
