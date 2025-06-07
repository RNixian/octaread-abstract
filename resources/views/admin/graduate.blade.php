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
    <div id="mainContent" class="md:ml-64 md:flex">
    <div class="flex-1 p-8">
      <div class="max-w-6xl w-full mx-auto space-y-4">
        <!-- Category and Department Filter Container -->
        <form id="filter-form" method="GET" action="{{ route('admin.graduate') }}" class="space-y-2">
          <input type="hidden" name="out_cat" id="out_cat" value="{{ request('out_cat', '') }}">
          <!-- Category Header (Full Width) -->
          <div class="w-full bg-gray-100 px-4 py-2 rounded flex justify-between items-center">
            <button type="button" onclick="changeCategory(-1)" class="text-lg px-2 py-1 bg-gray-200 rounded hover:bg-gray-300"><</button>
            <span id="category-display" class="text-xl font-bold text-center flex-1">
              {{ request('out_cat') ?: 'All Category' }}
            </span>
            <button type="button" onclick="changeCategory(1)" class="text-lg px-2 py-1 bg-gray-200 rounded hover:bg-gray-300">></button>
          </div>
      
          <!-- Department Header (Full Width) -->
          <div class="w-full px-4 py-2 bg-gray-50 rounded">
            <label class="block text-lg font-semibold text-gray-700 mb-1" for="department">Department</label>
            <select name="department" id="department" class="w-full border px-2 py-1 rounded">
              <option value="">-- Select Department --</option>
              <!-- Add dynamic options here -->
            </select>
          </div>
        </form>
      
        <!-- Search, Add Books, and Count Container -->
        <div class="w-full px-4 py-2 bg-white rounded shadow flex flex-col md:flex-row md:items-center md:justify-between gap-4 flex-wrap">
          <!-- Search and Buttons -->
          <form method="GET" action="{{ url('/admin/graduate') }}" class="flex flex-1 flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..."
              class="flex-grow shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline font-bold" />
            
              <!--  <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button> -->
            <a href="{{ url('/admin/graduate') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Reset</a>
          </form>
      
          <!-- Add Books Button -->
          <a href="{{ url('/admin/add_new_books') }}"
            class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300">
            Add Books
          </a>
      
          <!-- Count -->
          <p class="text-sm text-gray-600 font-bold">
            Count: {{ $countgrads > 0 ? $countgrads : 0 }}
          </p>
        </div>
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
                            data-id="{{ $data->id }}"
                            data-title="{{ $data->title }}"
                            data-author="{{ $data->author }}"
                            data-year="{{ $data->year }}"
                            >
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
<div id="updateModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 hidden z-50">
  <div class="bg-white rounded-lg shadow-lg w-full max-w-2xl p-6 relative">
    
    <!-- Close Button -->
    <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
    
    <h2 class="text-2xl font-bold mb-6">Update Book</h2>

    <form id="updateForm" action="{{ route('updatebook', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')
      <input type="hidden" name="id" id="book_id">

      <div class="grid grid-cols-2 gap-4">
        
        <!-- Title -->
        <div>
          <label for="edit_title" class="block text-gray-700 font-bold mb-2">Title</label>
          <input type="text" name="title" id="edit_title" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- Author -->
        <div>
          <label for="edit_author" class="block text-gray-700 font-bold mb-2">Author</label>
          <input type="text" name="author" id="edit_author" class="w-full border rounded px-3 py-2" required>
        </div>

        <!-- Year -->
        <div>
          <label for="edit_year" class="block text-gray-700 font-bold mb-2">Year</label>
          <input type="number" name="year" id="edit_year" class="w-full border rounded px-3 py-2" required>
        </div>

              <!-- Category -->
      <div>
        <label for="edit_category" class="block text-gray-700 font-bold mb-2">Category</label>
        <select name="category" id="edit_category" class="w-full border rounded px-3 py-2" >
          <option value="">-- Select Category --</option>
          @foreach ($res_out_cats as $cat)
            <option value="{{ $cat->out_cat }}">{{ $cat->out_cat }}</option>
          @endforeach
        </select>
      </div>

      <!-- Department (will load dynamically) -->
      <div>
        <label for="edit_department" class="block text-gray-700 font-bold mb-2">Department</label>
        <select name="department" id="edit_department" class="w-full border rounded px-3 py-2" >
          <option value="">-- Select Department --</option>
        </select>
      </div>


    <!-- File Uploads -->
    <div class="mt-4">
      <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="edit_pdf">PDF File</label>
        <input type="file" name="pdf_filepath" id="edit_pdf" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" accept=".pdf">
      </div>
     
    </div>

      <!-- Submit -->
      <div class="mt-6 text-right">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Update</button>
      </div>
    </form>
  </div>
</div>



        </div>
      </div>
    </div>
  </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

      $(document).ready(function () {
    $('#edit_category').change(function () {
        let category = $(this).val();

        $('#edit_department').html('<option value="">-- Loading... --</option>');

        if (category) {
            $.ajax({
                url: '/get-departments/' + encodeURIComponent(category),
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


<!-- Grouped Script -->
<script>
  $(document).ready(function () {
    const categories = @json(array_merge(
        ['All Category'],
        $categories->filter(fn($c) => $c !== 'All Category')->values()->toArray()
    ));

    let current = $('#out_cat').val() || "All Category";

    function getCurrentCategoryIndex() {
        return categories.indexOf(current);
    }

    function loadDepartments(out_cat) {
        $('#department').html('<option value="">-- Loading... --</option>');

        if (out_cat && out_cat !== "All Category") {
            $.ajax({
                url: '/get-departments/' + encodeURIComponent(out_cat),
                type: 'GET',
                success: function (data) {
                    $('#department').empty().append('<option value="">-- Select Department --</option>');

                    if (Array.isArray(data)) {
                        data.forEach(function (value) {
                            $('#department').append('<option value="' + value + '">' + value + '</option>');
                        });
                    }

                    let selected = @json(request('department'));
                    if (selected) {
                        $('#department').val(selected);
                    }
                },
                error: function (xhr) {
                    console.error("AJAX error:", xhr.responseText);
                    $('#department').html('<option value="">-- Error loading departments --</option>');
                }
            });
        } else {
            $('#department').html('<option value="">-- Select Department --</option>');
        }
    }
    loadDepartments(current);
    window.changeCategory = function (direction) {
        let index = getCurrentCategoryIndex();
        if (index === -1) index = 0;
        else index = (index + direction + categories.length) % categories.length;

        current = categories[index];

        $('#out_cat').val(current === "All Category" ? "" : current);
        $('#category-display').text(current);

        // Automatically submit form on category change
        $('#filter-form').submit();
    };

    $('#out_cat').on('change', function () {
        current = $(this).val() || "All Category";
        loadDepartments(current);
        $('#filter-form').submit();  // Submit form automatically when out_cat changes
    });

    $('#department').on('change', function () {
        $('#filter-form').submit();  // Submit form automatically on department change
    });

    $('#search-input').on('input', function () {
        // You can debounce this to avoid too many requests:
        clearTimeout($.data(this, 'timer'));
        var wait = setTimeout(() => {
            $('#filter-form').submit();
        }, 500);
        $(this).data('timer', wait);
    });
});
</script>


  
</body>
</html>