<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SetUp-User-Department</title>
 <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="flex min-h-screen bg-gray-100 w-full">
    @include('admin.sidebar')

 <div id="mainContent" class="md:ml-64 md:flex">

          <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">User Department</h2>

            <form action="{{ route('admin.setup.storeuserdept') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
        
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="user_type_id">User Type</label>
                  <select name="user_type_id" id="user_type_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select User Type --</option>
                    @foreach ($usertypes as $types)
                      <option value="{{ $types->id }}" {{ old('user_type_id') == $types->id ? 'selected' : '' }}>
                        {{ $types->user_type }}
                      </option>                    
                    @endforeach
                  </select>
                </div>
        
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="user_department">User Department</label>
                  <input type="text" id="user_department" name="user_department" value="{{ old('user_department') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
        
                <div class="flex justify-center">
                  <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300">
                    Submit
                  </button>
                </div>
              </form>

              @if($errors->any())
              <ul>
              @foreach ($errors->all() as $error)
                  <li>
              {{$error}}
                  </li>
              @endforeach
              </ul>
              @endif
          </div>


        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">


   <!-- Search and Filter -->
 <form method="GET" action="{{ url('/admin/setup/userdepartment') }}" class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
  <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..." 
  class="w-full shadow appearance-none border rounded  md:w-1/2 py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"/>
<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>
</form>

          <div class="overflow-x-auto">
  <table class="min-w-full table-auto border-collapse">
    <thead>
      <tr class="bg-blue-900 text-white">
        <th class="hidden">Id</th>
        <th class="px-4 py-2 border-b text-left">User Type</th>
        <th class="px-4 py-2 border-b text-left">User Department</th>
        <th class="px-4 py-2 border-b text-left">Created at</th>
        <th class="px-4 py-2 border-b text-left">Updated at</th>
        <th class="px-4 py-2 border-b text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
    @foreach($userdeptmodel as $data)
  <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
    <td class="hidden">{{ $data->id }}</td>
    <td class="px-4 py-2 border-b text-start">
      {{ $data->userTypes ? $data->userTypes->user_type : 'N/A' }}
    </td>
    <td class="px-4 py-2 border-b text-start">{{ $data->user_department }}</td>
    <td class="px-4 py-2 border-b">{{ $data->created_at }}</td>
    <td class="px-4 py-2 border-b">{{ $data->updated_at }}</td>
    <td class="px-4 py-2 border-b space-x-4">
      <a href="{{ route('deleteuserdept', $data->id) }}"
         class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
        Delete
      </a>
      <button 
        class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
        data-id="{{ $data->id }}"
        data-user_type_id="{{ $data->user_type_id }}"
        data-user_department="{{ $data->user_department }}">
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
              <h2 class="text-2xl font-bold mb-6">Update User Department</h2>
          
              <!-- Form with dynamic ID in action -->
              <form id="updateForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" id="userdept_id" value="">
          
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="select_user_type_id">User Type</label>
                  <select name="user_type_id" id="select_user_type_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select User Types --</option>
                    @foreach ($usertypes as $types)
                      <option value="{{ $types->id }}" {{ old('user_type') == $types->id ? 'selected' : '' }}>
                        {{ $types->user_type }}
                      </option>
                    @endforeach
                  </select>
                </div>
          
                <!-- Text Input -->
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="edit_user_department">user Department </label>
                  <input type="text" name="user_department" id="edit_user_department" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
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
            const updateModal = document.getElementById('updateModal');
            const closeModal = document.getElementById('closeModal');
            const updateForm = document.getElementById('updateForm');
          
            document.querySelectorAll('.btn-edit').forEach(button => {
              button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const user_type_id = this.getAttribute('data-user_type_id');
                const user_department = this.getAttribute('data-user_department');
          
                // Set the form action with the correct ID
                updateForm.action = `{{ route('updateuserdept', ['id' => '__ID__']) }}`.replace('__ID__', id);
          
                // Fill the form fields
                document.getElementById('userdept_id').value = id;
                document.getElementById('select_user_type_id').value = user_type_id;
                document.getElementById('edit_user_department').value = user_department;
          
                updateModal.classList.remove('hidden');
              });
            });
          
            closeModal.addEventListener('click', function () {
              updateModal.classList.add('hidden');
              updateForm.reset();
            });
          </script>
          

</body>
</html>