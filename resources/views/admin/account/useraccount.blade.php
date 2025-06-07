<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>User Accounts</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="flex min-h-screen bg-gray-100 w-full">
   <!-- Sidebar -->
   @include('admin.sidebar')

   <!-- Main Content -->
   <div id="mainContent" class="md:ml-64 flex flex-col w-full p-6">
     
     <!-- Validation Errors -->
     @if($errors->any())
       <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
         <ul class="list-disc pl-5">
           @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
           @endforeach
         </ul>
       </div>
     @endif
 
     <!-- Card -->
     <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 w-full">
       <h2 class="text-2xl font-bold mb-6 text-center">User Accounts</h2>
 
       <!-- Search Form -->
       <form method="GET" action="{{ route('admin.account.useraccount') }}" class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
         <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
           class="w-full shadow border rounded md:w-1/2 py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" />
         <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
           Search
         </button>
       </form>
 
       <!-- Table -->
       <div class="overflow-x-auto">
         <table class="min-w-full table-auto border-collapse">
           <thead>
             <tr class="bg-blue-900 text-white">
               <th class="px-4 py-2 border-b text-left">First Name</th>
               <th class="px-4 py-2 border-b text-left">Middle Name</th>
               <th class="px-4 py-2 border-b text-left">Last Name</th>
               <th class="px-4 py-2 border-b text-left">School ID</th>
               <th class="px-4 py-2 border-b text-left">Department</th>
               <th class="px-4 py-2 border-b text-left">Birthdate</th>
               <th class="px-4 py-2 border-b text-left">Status</th>
               <th class="px-4 py-2 border-b text-left">Type</th>
               <th class="px-4 py-2 border-b text-left">Actions</th>
             </tr>
           </thead>
           <tbody>
            @forelse($usermodel->where('user_type_id', '!=', 0) as $data)
              <tr class="bg-white border-b hover:bg-gray-100">
                <td class="px-4 py-2">{{ $data->firstname }}</td>
                <td class="px-4 py-2">{{ $data->middlename }}</td>
                <td class="px-4 py-2">{{ $data->lastname }}</td>
                <td class="px-4 py-2">{{ $data->schoolid }}</td>
                <td class="px-4 py-2">{{ $data->department }}</td>
                <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($data->birthdate)->format('d-m-Y') }}</td>
                <td class="px-4 py-2">{{ $data->status }}</td>
                <td class="px-4 py-2 border-b text-start">
                  {{ $data->userType ? $data->userType->user_type : 'Guest' }}
                </td>
                <td class="px-4 py-2 space-x-2">
                  <button 
                  class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
                  data-id="{{ $data->id }}"
                  data-firstname="{{ $data->firstname }}"
                  data-middlename="{{ $data->middlename }}"
                  data-lastname="{{ $data->lastname }}"
                  data-schoolid="{{ $data->schoolid }}"
                  data-department="{{ $data->department }}"
                  data-birthdate="{{ $data->birthdate }}"
                  data-user_type_id="{{ $data->user_type_id }}"
                  >
                  Edit
                </button>
                  
                   <form action="{{ route('deleteuseracc', $data->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this user?');">
                     @csrf
                     @method('DELETE')
                     <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">Delete</button>
                   </form>
                 </td>
              </tr>
            @empty
              <tr>
                <td colspan="9" class="text-center py-4 text-gray-500">No users found.</td>
              </tr>
            @endforelse
          </tbody>
          
         </table>
       </div>
     </div>

    
    <!-- Update Account Modal -->
<div id="updateModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6 relative">
    <!-- Close Button -->
    <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
    
    <h2 class="text-2xl font-bold mb-6">Update Account</h2>
    
    <form id="updateForm" action="{{ route('updateuseracc', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <input type="hidden" name="id" id="user_id" value="">

      <!-- User Type -->
      <div class="mb-4">
        <label for="edit_type" class="block text-gray-700 font-bold mb-2">User Type</label>
        <select name="edit_type" id="edit_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
            @foreach ($usertypes as $type)
                <option value="{{ $type->id }}">{{ $type->user_type }}</option>
            @endforeach
        </select>
    </div>

      <!-- Firstname, Middlename, Lastname -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
        <div>
          <label for="edit_firstname" class="block text-gray-700 font-bold mb-2">First Name</label>
          <input type="text" name="firstname" id="edit_firstname" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div>
          <label for="edit_middlename" class="block text-gray-700 font-bold mb-2">Middle Name</label>
          <input type="text" name="middlename" id="edit_middlename" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div>
          <label for="edit_lastname" class="block text-gray-700 font-bold mb-2">Last Name</label>
          <input type="text" name="lastname" id="edit_lastname" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
      </div>

      <!-- School ID, Department, Birthdate -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div>
          <label for="edit_schoolid" class="block text-gray-700 font-bold mb-2">School ID</label>
          <input type="text" name="schoolid" id="edit_schoolid" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="edit_department">Department</label>
          <select name="edit_department" id="edit_department" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
              <option value="">-- Select Department --</option>
          </select>
      </div>
        <div>
          <label class="block text-gray-700 font-bold mb-2" for="edit_birthdate">Birthdate</label>
          <input type="date" name="birthdate" id="edit_birthdate" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
      </div>

      <!-- Submit Button -->
      <div class="text-right">
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600 transition duration-200">Update</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Get modal elements
  const updateModal = document.getElementById('updateModal');
  const closeModal = document.getElementById('closeModal');
  const updateForm = document.getElementById('updateForm');

  // When user clicks any "Edit" button
  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
      // Retrieve data attributes from the clicked button
      const id = this.getAttribute('data-id');
      const user_type_id = this.getAttribute('data-user_type_id');
      const firstname = this.getAttribute('data-firstname');
      const middlename = this.getAttribute('data-middlename');
      const lastname = this.getAttribute('data-lastname');
      const schoolid = this.getAttribute('data-schoolid');
      const department = this.getAttribute('data-department');
      const birthdateRaw = this.getAttribute('data-birthdate');

      const birthdate = new Date(birthdateRaw).toISOString().split('T')[0];

      // Populate the form fields with data
      document.getElementById('user_id').value = id;
      document.getElementById('edit_type').value = user_type_id;
      document.getElementById('edit_firstname').value = firstname;
      document.getElementById('edit_middlename').value = middlename;
      document.getElementById('edit_lastname').value = lastname;
      document.getElementById('edit_schoolid').value = schoolid;
      document.getElementById('edit_department').value = department;
      document.getElementById('edit_birthdate').value = birthdate;

      // Update the form action URL
      updateForm.action = updateForm.action.replace('__ID__', id);

      // Show modal
      updateModal.classList.remove('hidden');
    });
  });

  // Close modal
  closeModal.addEventListener('click', function () {
    updateModal.classList.add('hidden');

    // Optional: Reset the form action so the ID can be replaced again correctly
    updateForm.action = "{{ route('updateuseracc', ['id' => '__ID__']) }}";
  });
</script>

<script>
  $(document).ready(function () {
      $('#edit_type').change(function () {
          let type = $(this).val();

          $('#edit_department').html('<option value="">-- Loading... --</option>');

          if (type) {
              $.ajax({
                  url: '/get-userdepts/' + encodeURIComponent(type),
                  type: 'GET',
                  success: function (data) {
                      $('#edit_department').empty().append('<option value="">-- Select Department --</option>');
                      $.each(data, function (key, value) {
                          $('#edit_department').append('<option value="' + value + '">' + value + '</option>');
                      });
                  }
              });
          } else {
              $('#edit_department').html('<option value="">-- Select Department --</option>');
          }
      });
  });
</script>






</body>
</html>