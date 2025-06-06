<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>SetUp-Carousel</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
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
      <h2 class="text-2xl font-bold mb-6 text-center">Carousel</h2>
    
      <form action="{{ route('admin.setup.storecarousel') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
        @csrf
    
        <div class="mb-6">
          <label class="block text-gray-700 text-sm font-bold mb-2" for="carousel_imgpath">Carousel</label>
          <input class="block w-full text-sm text-gray-700 border border-gray-300 rounded py-2 px-3 focus:outline-none focus:shadow-outline" id="carousel_imgpath" type="file" name="carousel_imgpath" accept="image/jpeg,image/png,image/jpg">
        </div>
    
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="display_order">Display Order</label>
          <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" type="text" id="display_order" name="display_order" required>
        </div>
    
        <p class="text-sm text-gray-700 text-center mb-4 px-4 py-2 rounded" style="background-color: rgba(253, 224, 71, 0.3);">
          <strong>Note:</strong> Recommended size of picture is <span class="font-medium">1920x1080</span>.
        </p>
        
    
        <div class="flex justify-center space-x-4">
          <button class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300" type="submit">
            Submit
          </button>
        </div>
      </form>
    </div>
    


        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6">
       <div class="overflow-x-auto">
  <table class="min-w-full table-auto border-collapse">
    <thead>
      <tr class="bg-blue-900 text-white">
        <th class="hidden">Id</th>
        <th class="px-4 py-2 border-b text-left">Carousel</th>
        <th class="px-4 py-2 border-b text-left">Order</th>
        <th class="hidden">Created at</th>
        <th class="hidden">Updated at</th>
        <th class="px-4 py-2 border-b text-left">Actions</th>
      </tr>
    </thead>
    <tbody>
      @foreach($carouselmodel as $data)
        <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
          <td class="hidden">{{ $data->id }}</td>
          <td class="px-4 py-2 border-b text-start">
            @if($data->carousel_imgpath)
            <img src="{{ asset('storage/' . $data->carousel_imgpath) }}"
            alt="Carousel"
            class="w-70 h-40 object-cover rounded border" />
       
            @else
              N/A
            @endif
          </td>
          <td class="px-4 py-2 border-b text-start">{{ $data->display_order }}</td>
          <td class="hidden">{{ $data->created_at }}</td>
          <td class="hidden">{{ $data->updated_at }}</td>
          <td class="px-4 py-2 border-b space-x-2">
            <a href="{{ route('deletecarousel', $data->id) }}"
               class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
              Delete
            </a>
            <button 
              class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
              data-id="{{ $data->id }}"
              data-display_order="{{ $data->display_order }}">
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
            <h2 class="text-2xl font-bold mb-6">Update Carousel</h2>
            <form id="updateForm" action="{{ route('updatecarousel', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')

              <input type="hidden" name="id" id="carousel_id" value="">
             

              <div>
                <label class="block text-gray-700 font-bold mb-2" for="edit_display_order">Display Order</label>
                <input type="text" name="display_order" id="edit_display_order" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
              </div>

              <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2" for="edit_carousel_imgpath">Cover Photo</label>
                <input type="file" name="carousel_imgpath" id="edit_carousel_imgpath" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" accept="image/jpeg,image/png,image/jpg">
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
            const display_order = this.getAttribute('data-display_order');

            // Update the form action with the record id
            updateForm.action = updateForm.action.replace('__ID__', id);
            document.getElementById('carousel_id').value = id;
            // Populate form fields with current data
            document.getElementById('edit_display_order').value = display_order;
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