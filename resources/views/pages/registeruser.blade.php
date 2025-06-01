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

<!-- Trigger Modal Button -->
<button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#roleModal">
    Choose Registration Type
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="roleModal" tabindex="-1" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="roleModalLabel">Select Role</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <select id="userType" class="form-select">
            <option value="">-- Select User Type --</option>
            <option value="employee">Employee</option>
            <option value="student">Student</option>
          </select>
        </div>
      </div>
    </div>
  </div>
  



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
                                @foreach (['schoolid' => 'School Id'] as $field => $label)
                                    <div class="col-md-6 mb-3">
                                        <label for="{{ $field }}" class="form-label">{{ $label }}</label>
                                        <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control" required>
                                    </div>
                                @endforeach
                           

                      <!-- Wrap the dynamic part in divs with IDs -->
                            <div id="employeeFields" class="mb-3 d-none">
                                <label for="department" class="form-label">Department</label>
                                <select name="department" class="form-select">
                                    @foreach ($departments as $dept)
                                        <option value="{{ $dept->department }}">{{ $dept->department }}</option>
                                    @endforeach
                                </select>

                                <label for="programplus" class="form-label mt-3">Program Plus</label>
                                <select name="programplus" class="form-select">
                                    @foreach ($programpluses as $prog)
                                        <option value="{{ $prog->programplus }}">{{ $prog->programplus }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div id="studentFields" class="mb-3 d-none">
                                <label for="program" class="form-label">Program</label>
                                <select name="program" class="form-select">
                                    @foreach ($programs as $prog)
                                        <option value="{{ $prog->program }}">{{ $prog->program }}</option>
                                    @endforeach
                                </select>
                            </div>

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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const userType = document.getElementById('userType');
            const employeeFields = document.getElementById('employeeFields');
            const studentFields = document.getElementById('studentFields');
        
            userType.addEventListener('change', function () {
                employeeFields.classList.add('d-none');
                studentFields.classList.add('d-none');
        
                if (this.value === 'employee') {
                    employeeFields.classList.remove('d-none');
                } else if (this.value === 'student') {
                    studentFields.classList.remove('d-none');
                }
            });
        });
        </script>
</body>
</html>
