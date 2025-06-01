<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Graduate</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="flex min-h-screen bg-gray-100 w-full">
    @include('admin.sidebar')

    <div class="flex-1 p-8">
      <div class="max-w-6xl w-full mx-auto">
        <!-- Header -->
        <form id="filter-form" method="GET" action="{{ route('admin.graduate') }}" class="flex items-center space-x-4">
          <input type="hidden" name="out_cat" id="out_cat" value="{{ request('out_cat', '') }}">
      
          <button type="button" onclick="changeCategory(-1)" class="text-lg px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">&lt;</button>
      
          <span id="category-display" class="text-md font-medium">
              {{ request('out_cat') ?: '-- Select Category --' }}
          </span>
      
          <button type="button" onclick="changeCategory(1)" class="text-lg px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">&gt;</button>
      </form>
      
       <!-- Search and Filter -->
    <form method="GET" action="{{ url('/admin/graduate') }}" class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..." 
        class="shadow appearance-none border rounded w-full md:w-1/2 py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline"/>
        <div class="mb-4">
          <label class="block text-gray-700 font-bold mb-2" for="department">Department</label>
          <select name="department" id="department" class="border px-2 py-1 rounded">
              <option value="">-- Select Department --</option>
              @if(request('department'))
                  <option selected value="{{ request('department') }}">{{ request('department') }}</option>
              @endif
          </select>
      </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>
  <a href="{{ url('/admin/graduate') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Reset</a>
</form>

<!-- Display the count of results -->
@if($countgrads > 0)
    <p class="mt-4 text-sm text-gray-600">Count: {{ $countgrads }}</p>
@else
    <p class="mt-4 text-sm text-gray-600">Count: 0</p>
@endif

 <!-- Link to Add Books -->
 <a href="{{ url('/admin/add_new_books') }}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300 inline-block">
  Add Books
</a>

        </div>
        <!-- Table -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
          <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
              <thead>
                <tr class="bg-blue-900 text-white">
                  <th class="hidden">Id</th>
                  <th class="px-4 py-2 border-b text-left w-[200px]">Title</th>
                  <th class="px-4 py-2 border-b text-left">Author</th>
                  <th class="px-4 py-2 border-b text-left">Year</th>
                  <th class="px-4 py-2 border-b text-left">Category</th>
                  <th class="px-4 py-2 border-b text-left">Department</th>
                  <th class="px-4 py-2 border-b text-left">PDF File</th>
                  <th class="hidden">Created at</th>
                  <th class="hidden">Updated at</th>
                  <th class="px-4 py-2 border-b text-left" colspan="2">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($books as $data)
               
                    <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
                      <td class="hidden border-b">{{ $data->id }}</td>
                      <td class="text-start border-b px-4 py-2 w-[200px]">{{ $data->title }}</td>
                      <td class="text-start border-b px-4 py-2">{{ $data->author }}</td>
                      <td class="text-start border-b px-4 py-2">{{ $data->year }}</td>
                      <td class="text-start border-b px-4 py-2">{{ $data->category }}</td>
                      <td class="text-start border-b px-4 py-2">{{ $data->department }}</td>
                      <td class="text-start border-b px-4 py-2">
                        <a href="{{ asset('storage/' . $data->pdf_filepath) }}"
                           class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
                           target="_blank">
                          View
                        </a>
                      </td>
                      <td class="hidden border-b">{{ $data->created_at }}</td>
                      <td class="hidden border-b">{{ $data->updated_at }}</td>
                      <td colspan="2" class="border-b px-4 py-2">
                        <div class="flex flex-col space-y-2">
                          <a href="{{ route('deletebook', $data->id) }}"
                             class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded text-center">
                            Delete
                          </a>
                          <button 
                            class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded"
                            data-id="{{ $data->id }}">
                            Edit
                          </button>
                        </div>
                      </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
        
        

        <!-- Update Modal -->
        <div id="updateModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden">
          <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
            <!-- Close Button -->
            <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
            <h2 class="text-2xl font-bold mb-6">Update Book</h2>
            <form id="updateForm" action="{{ route('updatebook', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
              <!-- Hidden field for book id -->
              <input type="hidden" name="id" id="book_id" value="">
              
              <!-- Two Columns Grid for Text Inputs -->
              <div class="grid grid-cols-2 gap-4">
                <!-- Title -->
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="edit_title">Title</label>
                  <input type="text" name="title" id="edit_title" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Author -->
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="edit_author">Author</label>
                  <input type="text" name="author" id="edit_author" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Year -->
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="edit_year">Year</label>
                  <input type="number" name="year" id="edit_year" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Category -->
                <div>
                  <label class="block text-gray-700 font-bold mb-2" for="edit_category">Category</label>
                  <select class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" id="edit_category" name="category" required>
                      <option value="">Select Category</option>
                      <option value="Graduate">Graduate</option>
                      <option value="Under-Graduate">Under-Graduate</option>
                      <option value="Employee">Employee</option>
                  </select>
              </div>
              <div>
                <label class="block text-gray-700 font-bold mb-2" for="edit_department">Department</label>
                <select class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" name="department" id="edit_department">
                  <option value="">-- Select Department --</option>
                    @foreach ($under_res_out_cats as $category)
                      <option value="{{ $category->department }}" {{ request('department') == $category->department ? 'selected' : '' }}>
                        {{ $category->department }}
                      </option>
                    @endforeach
                </select>
              </div>
              <!-- File Uploads -->
              <div class="mt-4">
                <div class="mb-4">
                  <label class="block text-gray-700 font-bold mb-2" for="edit_pdf">PDF File</label>
                  <input type="file" name="pdf_filepath" id="edit_pdf" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" accept=".pdf">
                </div>
                
              </div>
            </div>
              <!-- Submit Button -->
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
  </div>

  <!-- JavaScript to handle modal behavior -->
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
        const title = this.getAttribute('data-title');
        const author = this.getAttribute('data-author');
        const year = this.getAttribute('data-year');
        const category = this.getAttribute('data-category');
        const department = this.getAttribute('data-department');

        // Update the form action with the record id
        updateForm.action = updateForm.action.replace('__ID__', id);
        document.getElementById('book_id').value = id;
        // Populate form fields with current data
        document.getElementById('edit_title').value = title;
        document.getElementById('edit_author').value = author;
        document.getElementById('edit_year').value = year;
        document.getElementById('edit_category').value = category;
        document.getElementById('edit_department').value = department;

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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Grouped Script -->
<script>
$(document).ready(function () {
    // Get categories from the controller (passed as $categories)
    const categories = @json($categories->toArray());
    let current = $('#out_cat').val();

    function getCurrentCategoryIndex() {
        return categories.indexOf(current);
    }

    function loadDepartments(category) {
        $('#department').html('<option value="">-- Loading... --</option>');

        if (category) {
            $.ajax({
                url: '/get-departments/' + encodeURIComponent(category),
                type: 'GET',
                success: function (data) {
                    $('#department').empty().append('<option value="">-- Select Department --</option>');
                    $.each(data, function (key, value) {
                        $('#department').append('<option value="' + value + '">' + value + '</option>');
                    });

                    // Re-select if department was already chosen
                    const selectedDept = '{{ request('department') }}';
                    if (selectedDept) {
                        $('#department').val(selectedDept);
                    }
                },
                error: function () {
                    $('#department').html('<option value="">-- Error loading departments --</option>');
                }
            });
        } else {
            $('#department').html('<option value="">-- Select Department --</option>');
        }
    }

    // Load departments on initial load based on current category
    loadDepartments(current);

    // Global function to change category
    window.changeCategory = function (direction) {
        let index = getCurrentCategoryIndex();
        if (index === -1) index = 0;
        else index += direction;

        // Bounds check
        if (index < 0) index = 0;
        if (index >= categories.length) index = categories.length - 1;

        const newCategory = categories[index];
        current = newCategory;

        $('#out_cat').val(newCategory);
        $('#category-display').text(newCategory);
        $('#filter-form').submit();
    };
});
</script>

</body>
</html>