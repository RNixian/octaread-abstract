<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SetUp-User-Type</title>
<link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  @if($errors->any())
  <ul>
  @foreach ($errors->all() as $error)
      <li>
  {{$error}}
      </li>
  @endforeach
  </ul>
  @endif

  <div class="flex min-h-screen bg-gray-100 w-full">
  @include('admin.sidebar')

  <div id="mainContent" class="md:ml-64 flex flex-col lg:flex-row items-start justify-center gap-8 w-full p-6">

   <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 w-full max-w-6xl mx-auto">


      <h2 class="text-2xl font-bold mb-6 text-center text-blue-900">User Type</h2>

      <!-- Add User Type Form -->
      <form action="{{ route('admin.setup.storeusertype') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="mb-4">
          <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" type="text" id="out_cat" name="out_cat" required>
        </div>
       <div class="flex justify-center space-x-4">
                <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300" type="submit">
                  Submit
                </button>
              </div>
      </form>

<div class="mt-8"></div>

        <!-- Search and Filter -->
 <form method="GET" action="{{ url('/admin/setup/usertype') }}" id="searchForm" class="w-full mb-6 flex flex-col md:flex-row items-center gap-2">
  <input 
    type="text" 
    name="search" 
    value="{{ request('search') }}" 
    placeholder="Enter..." 
    class="w-full shadow appearance-none border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline" 
  />

  <button 
    type="submit" 
    class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
  >
    Search
  </button>

  <a 
    href="{{ url('/admin/setup/usertype') }}" 
    class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-center"
  >
    Clear
  </a>
</form>




      <!-- User Type Table -->
      <div class="overflow-x-auto">
        <table class="min-w-full table-auto border-collapse">
          <thead>
            <tr class="bg-blue-900 text-white">
              <th class="hidden">Id</th>
              <th class="px-4 py-2 border-b text-left">User Type</th>
              <th class="hidden">Created at</th>
              <th class="hidden">Updated at</th>
              <th class="px-4 py-2 border-b text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($usertypemodel as $data)
              <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
                <td class="hidden">{{ $data->id }}</td>
                <td class="px-4 py-2 border-b text-start">{{ $data->user_type }}</td>
                <td class="hidden">{{ $data->created_at }}</td>
                <td class="hidden">{{ $data->updated_at }}</td>
                <td class="px-4 py-2 border-b space-x-4">
                  <a href="{{ route('deleteusertype', $data->id) }}"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
                    Delete
                  </a>
                  <button 
                    class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
                    data-id="{{ $data->id }}"
                    data-user_type="{{ $data->user_type }}">
                    Edit
                  </button>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
         <div class="d-flex justify-content-center mt-4">
              {{ $usertypemodel->links('pagination::tailwind') }}
          </div>
      </div>

    </div>

    <!-- Update Modal -->
    <div id="updateModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
      <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
        <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold mb-6">Update User Type</h2>
        <form id="updateForm" action="{{ route('updateusertype', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" id="user_type_id" value="">
          <div>
            <label class="block text-gray-700 font-bold mb-2" for="edit_user_type">User Type</label>
            <input type="text" name="user_type" id="edit_user_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
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
            button.addEventListener('click', function() {
              // Retrieve data attributes from the clicked button
              const id = this.getAttribute('data-id');
              const user_type = this.getAttribute('data-user_type');

              // Update the form action with the record id
              updateForm.action = updateForm.action.replace('__ID__', id);
              document.getElementById('user_type_id').value = id;
              // Populate form fields with current data
              document.getElementById('edit_user_type').value = user_type;

              // Show the modal
              updateModal.classList.remove('hidden');
            });
          });

          // Close the modal when close button is clicked
          closeModal.addEventListener('click', function() {
            updateModal.classList.add('hidden');
            // Reset action placeholder for next use
            updateForm.action = updateForm.action.replace(/(\d+)$/, '__ID__');
          });

          // Close modal on clicking outside the modal content
          window.addEventListener('click', function(e) {
            if (e.target === updateModal) {
              updateModal.classList.add('hidden');
            }
          });
        </script>
 

</body>
</html>