<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
    .custom-padding {
    padding: 2%;
}

</style>

<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header -->
    @include('pages.usersheader')

    <div class="bg-white rounded shadow-md w-50 mx-auto my-5 flex-grow-1 custom-padding">
        @if($errors->any())
        <ul>
        @foreach ($errors->all() as $error)
            <li>
        {{$error}}
            </li>
        @endforeach
        </ul>
        @endif
        <form action="{{ route('pages.storeuser') }}" method="POST">
            @csrf
    
            <div class="mb-3">
                <label for="type" class="form-label">Registration Type</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">-- Select Type --</option>
                    @foreach ($usertypes as $type)
                        <option value="{{ $type->user_type }}">{{ $type->user_type }}</option>
                    @endforeach
                </select>
            </div>
    
            <div class="row">
                @foreach (['firstname' => 'First Name', 'middlename' => 'Middle Name', 'lastname' => 'Last Name'] as $field => $label)
                    <div class="col-md-4 mb-3">
                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                        <input 
                            type="text" 
                            id="{{ $field }}" 
                            name="{{ $field }}" 
                            class="form-control" 
                            @if ($field !== 'middlename') required @endif
                        >
                    </div>
                @endforeach
            </div>
            

            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="schoolid" class="form-label">School Id</label>
                    <input type="text" id="schoolid" name="schoolid" class="form-control" required>
                </div>
            
                <div class="col-md-4 mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" id="department" class="form-control" required>
                        <option value="">-- Select Department --</option>
                    </select>
                </div>
            
                <div class="col-md-4 mb-3">
                    <label for="birthdate" class="form-label">Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" class="form-control" required>
                </div>
            </div>
            
            
            <div class="d-grid">
                <button type="submit" class="btn btn-success">Register</button>
            </div>
    
            <div class="text-center mt-3">
                <a href="{{ route('pages.userlogin') }}" class="text-decoration-none text-primary">Already have an account?</a>
            </div>
        </form>
    </div>
    
   @include('pages.userfooter')

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#type').change(function () {
                let type = $(this).val();
    
                $('#department').html('<option value="">-- Loading... --</option>');
    
                if (type) {
                    $.ajax({
                        url: '/get-depts/' + encodeURIComponent(type),
                        type: 'GET',
                        success: function (data) {
                            $('#department').empty().append('<option value="">-- Select Department --</option>');
                            $.each(data, function (key, value) {
                                $('#department').append('<option value="' + value + '">' + value + '</option>');
                            });
                        }
                    });
                } else {
                    $('#department').html('<option value="">-- Select Department --</option>');
                }
            });
        });
    </script>
    
    
</body>
</html>
