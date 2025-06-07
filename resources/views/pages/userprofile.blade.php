<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OctaReader's profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Header -->
  @include('pages.usersheader')

  <div class="container my-5 flex-grow-1">
    <div class="card shadow-sm border-0">
      <div class="card-body p-4">
        <h3 class="text-center mb-4">User Profile</h3>
 

        <form action="{{ route('pages.profile.update') }}" method="POST">
          @csrf

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="firstname" class="form-label">First Name</label>
              <input 
                type="text" 
                id="firstname" 
                name="firstname" 
                class="form-control" 
                value="{{ old('firstname', $user->firstname ?? '') }}" 
                required>
            </div>
            <div class="col-md-4">
              <label for="middlename" class="form-label">Middle Name</label>
              <input 
                type="text" 
                id="middlename" 
                name="middlename" 
                class="form-control" 
                value="{{ old('middlename', $user->middlename ?? '') }}" 
                required>
            </div>
            <div class="col-md-4">
              <label for="lastname" class="form-label">Last Name</label>
              <input 
                type="text" 
                id="lastname" 
                name="lastname" 
                class="form-control" 
                value="{{ old('lastname', $user->lastname ?? '') }}" 
                required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="schoolid" class="form-label">School ID</label>
              <input 
                type="text" 
                id="schoolid" 
                name="schoolid" 
                class="form-control" 
                value="{{ old('schoolid', $user->schoolid ?? '') }}" 
                required>
            </div>

            <div class="col-md-4">
              <label for="department" class="form-label">Department</label>
              <select 
                  id="department" 
                  name="department" 
                  class="form-select" 
                  required>
                  <option value="">-- Select Department --</option>
                  @foreach ($usertypes as $dept)
                      <option value="{{ $dept->user_department }}" 
                          {{ old('department', $user->department ?? '') == $dept->user_department ? 'selected' : '' }}>
                          {{ $dept->user_department }}
                      </option>
                  @endforeach
              </select>
          </div>
          
          
                  
            <div class="col-md-4">
              <label for="birthdate" class="form-label">Birthdate</label>
              <input 
                type="date" 
                id="birthdate" 
                name="birthdate" 
                class="form-control" 
                value="{{ old('birthdate', isset($user->birthdate) ? \Carbon\Carbon::parse($user->birthdate)->format('Y-m-d') : '') }}"

                required>
            </div>
          </div>

          <div class="row">
            <div class="col text-center">
              <button type="submit" class="btn btn-success">Update</button>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>
  
  @include('pages.userfooter')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
