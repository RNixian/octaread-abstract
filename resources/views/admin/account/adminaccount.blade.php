<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Admin Accounts</title>
  <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">

</head>
<body class="bg-gray-100 flex items-start justify-start min-h-screen">

  @if($errors->any())
  <ul>
  @foreach ($errors->all() as $error)
      <li>
  {{$error}}
      </li>
  @endforeach
  </ul>
  @endif


  <div class="flex min-h-screen w-full">
    @include('admin.sidebar')
    <div id="mainContent" class="md:ml-64 md:flex w-full">

      <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 flex-1 w-full">
    
        <div class="overflow-x-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">Admin Accounts</h2>
 <!-- Search and Filter -->
 <form method="GET" action="{{ url('/admin/account/adminaccount') }}" class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
  <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..." 
  class="w-full shadow appearance-none border rounded  md:w-1/2 py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"/>
<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>
</form>


<div class="overflow-x-auto ">
    <table class="min-w-full table-auto border-collapse">
      <thead>
        <tr class="bg-blue-900 text-white">
          <th class="hidden">ID</th>
          <th class="px-4 py-2 border-b text-left">First Name</th>
          <th class="px-4 py-2 border-b text-left">Middle Name</th>
          <th class="px-4 py-2 border-b text-left">Last Name</th>
          <th class="px-4 py-2 border-b text-left">School ID</th>
          <th class="px-4 py-2 border-b text-left">Birthdate</th>
          <th class="px-4 py-2 border-b text-left">Status</th>
          <th class="hidden">Created At</th>
          <th class="hidden">Updated At</th>
          <th class="px-4 py-2 border-b text-left">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($adminmodel as $data)
          <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
            <td class="hidden">{{ $data->id }}</td>
            <td class="px-4 py-2 border-b">{{ $data->firstname }}</td>
            <td class="px-4 py-2 border-b">{{ $data->middlename }}</td>
            <td class="px-4 py-2 border-b">{{ $data->lastname }}</td>
            <td class="px-4 py-2 border-b">{{ $data->schoolid }}</td>
            <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($data->birthdate)->format('d-m-Y') }}</td>
            <td class="px-4 py-2 border-b">{{ $data->status }}</td>
            <td class="hidden">{{ $data->created_at }}</td>
            <td class="hidden">{{ $data->updated_at }}</td>
            <td class="px-4 py-2 border-b space-x-4">
              <a href="{{ route('deleteadminacc', $data->id) }}"
                 class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
                Delete
              </a>
          
              <button 
                class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
                data-id="{{ $data->id }}"
                data-firstname="{{ $data->firstname }}"
                data-middlename="{{ $data->middlename }}"
                data-lastname="{{ $data->lastname }}"
                data-schoolid="{{ $data->schoolid }}"
                data-birthdate="{{ $data->birthdate }}">
                Edit
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
        </div>

        <div id="updateModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
          <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <!-- Close Button -->
            <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold mb-6">Update Account</h2>
            <form id="updateForm" action="{{ route('updateadminacc', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <input type="hidden" name="id" id="dept_id" value="">
             
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="edit_firstname">First Name</label>
                  <input type="text" name="firstname" id="edit_firstname" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit_middlename">Middle Name</label>
                    <input type="text" name="middlename" id="edit_middlename" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                  </div>

                  <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit_lastname">Last Name</label>
                    <input type="text" name="lastname" id="edit_lastname" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                  </div>

                  <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit_schoolid">School Id</label>
                    <input type="text" name="schoolid" id="edit_schoolid" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                  </div>

                  <div>
                    <label class="block text-gray-700 font-bold mb-2" for="edit_birthdate">Birthdate</label>
                    <input type="date" name="birthdate" id="edit_birthdate" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                  </div>
      
              <div class="flex justify-end mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                  Update
                </button>
              </div>
            </form>
        </div>
    </div>
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
            const firstname = this.getAttribute('data-firstname');
            const middlename = this.getAttribute('data-middlename');
            const lastname = this.getAttribute('data-lastname');
            const schoolid = this.getAttribute('data-schoolid');
            const birthdateRaw = this.getAttribute('data-birthdate');
      
          
            const birthdate = new Date(birthdateRaw).toISOString().split('T')[0];
      
            // Populate the form fields with data
            document.getElementById('dept_id').value = id;
            document.getElementById('edit_firstname').value = firstname;
            document.getElementById('edit_middlename').value = middlename;
            document.getElementById('edit_lastname').value = lastname;
            document.getElementById('edit_schoolid').value = schoolid;
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
          updateForm.action = "{{ route('updateadminacc', ['id' => '__ID__']) }}";
        });
      </script>
      


</body>
</html>