<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SetUp-Under-Output-Category</title>
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

 <div id="mainContent" class="md:ml-64 md:flex">

          <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 mx-auto">
            <h2 class="text-2xl font-bold mb-6 text-center">Research Output Category - Under</h2>

            <form action="{{ route('admin.setup.storeunder_out_cat') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
        
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="out_cat_id">Category</label>
                  <select name="out_cat_id" id="out_cat_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Output Category --</option>
                    @foreach ($res_out_category as $category)
                      <option value="{{ $category->id }}" {{ old('out_cat_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->out_cat }}
                      </option>                    
                    @endforeach
                  </select>
                </div>
        
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="under_roc">Under Output Category</label>
                  <input type="text" id="under_roc" name="under_roc" value="{{ old('under_roc') }}"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
        
                <div class="flex justify-center">
                  <button type="submit"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300">
                    Submit
                  </button>
                </div>
              </form>
          </div>


        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">


   <!-- Search and Filter -->
 <form method="GET" action="{{ url('/admin/setup/output_category') }}" class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
  <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..." 
  class="w-full shadow appearance-none border rounded  md:w-1/2 py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"/>
<button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>
</form>

          <div class="overflow-x-auto">
  <table class="min-w-full table-auto border-collapse">
    <thead>
      <tr class="bg-blue-900 text-white">
        <th class="hidden">Id</th>
        <th class="px-4 py-2 border-b text-left">Output Category</th>
        <th class="px-4 py-2 border-b text-left">Under Output Category</th>
        <th class="hidden">Created at</th>
        <th class="hidden">Updated at</th>
        <th class="px-4 py-2 border-b text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
    @foreach($underrocmodel as $data)
  <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
    <td class="hidden">{{ $data->id }}</td>
    <td class="px-4 py-2 border-b text-start">
      {{ $data->outputCategory ? $data->outputCategory->out_cat : 'N/A' }}
    </td>
    <td class="px-4 py-2 border-b text-start">{{ $data->under_roc }}</td>
    <td class="hidden">{{ $data->created_at }}</td>
    <td class="hidden">{{ $data->updated_at }}</td>
    <td class="px-4 py-2 border-b space-x-4">
      <a href="{{ route('deleteout_cat', $data->id) }}"
         class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
        Delete
      </a>
      <button 
        class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
        data-id="{{ $data->id }}"
        data-out_cat_id="{{ $data->out_cat_id }}"
        data-under_roc="{{ $data->under_roc }}">
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
              <h2 class="text-2xl font-bold mb-6">Update Under Output Category</h2>
          
              <!-- Form with dynamic ID in action -->
              <form id="updateForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
          
                <!-- Hidden ID field for underrocmodel record -->
                <input type="hidden" name="id" id="record_id" value="">
          
                <!-- Output Category Select -->
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="select_out_cat_id">Category</label>
                  <select name="out_cat_id" id="select_out_cat_id" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="">-- Select Output Category --</option>
                    @foreach ($res_out_category as $category)
                      <option value="{{ $category->id }}" {{ old('out_cat_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->out_cat }}
                      </option>
                    @endforeach
                  </select>
                </div>
          
                <!-- Text Input -->
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="edit_under_roc">Output Category</label>
                  <input type="text" name="under_roc" id="edit_under_roc" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
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
                const out_cat_id = this.getAttribute('data-out_cat_id');
                const under_roc = this.getAttribute('data-under_roc');
          
                // Set the form action with the correct ID
                updateForm.action = `{{ route('updateunder_out_cat', ['id' => '__ID__']) }}`.replace('__ID__', id);
          
                // Fill the form fields
                document.getElementById('record_id').value = id;
                document.getElementById('select_out_cat_id').value = out_cat_id;
                document.getElementById('edit_under_roc').value = under_roc;
          
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