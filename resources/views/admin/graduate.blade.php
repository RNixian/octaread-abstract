
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Graduate</title>
  <link rel="stylesheet" href="{{ url('css/tailwind.min.css') }}">
  <script src="{{ url('js/jquery-3.6.0.min.js') }}"></script>
</head>
<style>
  .page-item.active .page-link {
    background-color: #ffc107 !important; /* Yellow */
    border-color: #ffc107 !important;
    color: white !important;
}
.page-link:hover, .page-link:focus {
    background-color: #e0a800;
    border-color: #d39e00;
    color: white;
}
 
</style>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="flex min-h-screen bg-gray-100 w-full">
    @include('admin.sidebar')
   <div id="mainContent" class="md:ml-64 flex flex-col lg:flex-row items-start justify-center gap-8 w-full p-6">

   <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-6 w-full max-w-6xl mx-auto">
      
   <div class="max-w-6xl w-full mx-auto space-y-4">
  <!-- Filter Form -->
  <form id="filter-form" method="GET" action="{{ route('admin.graduate') }}" class="space-y-4">
    
    <!-- Category & Department Row -->
    <div class="flex flex-wrap gap-4">
      <!-- Category -->
      <div class="flex-grow min-w-[200px]">
        <label class="block font-bold mb-1">Category</label>
        <select name="category" id="category" class="w-full border px-2 py-1 rounded">
          <option value="">All Category</option>
          @foreach($res_out_cats as $category)
            <option value="{{ $category->out_cat }}" {{ request('category') == $category->out_cat ? 'selected' : '' }}>
              {{ $category->out_cat }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Department -->
      <div class="flex-grow min-w-[200px]">
        <label class="block font-bold mb-1">Department</label>
        <select name="department" id="department" class="w-full border px-2 py-1 rounded">
          <option value="">-- Select Department --</option>
          @if(request('out_cat') && count($preloadedDepartments))
            @foreach($preloadedDepartments as $dept)
              <option value="{{ $dept }}" {{ request('department') == $dept ? 'selected' : '' }}>{{ $dept }}</option>
            @endforeach
          @endif
        </select>
      </div>
    </div>

    <!-- Search + Buttons + Add Books -->
    <div class="w-full px-4 py-2 bg-white rounded shadow flex flex-wrap md:flex-nowrap items-center gap-4">
      <!-- Search Input -->
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..."
        class="flex-grow shadow border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline font-bold" />

      <!-- Preserve Filters -->
      <input type="hidden" name="out_cat" id="out_cat" value="{{ request('out_cat') }}">

      <!-- Action Buttons -->
      <div class="flex gap-2">
        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">Search</button>
        <a href="{{ url('/admin/graduate') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Reset</a>
      </div>

      <!-- Add Books Button -->
      <a href="{{ url('/admin/add_new_books') }}"
        class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300 whitespace-nowrap">
        Add Books
      </a>
    </div>
  </form>
</div>


        <!-- Table -->
        <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
          <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse text-xs">
  <thead>
    <tr class="bg-blue-900 text-white">
      <th class="hidden">Id</th>
      <th class="px-1 py-0.5 border-b text-left w-[200px]">Title</th>
      <th class="px-1 py-0.5 border-b text-left">Author</th>
      <th class="px-1 py-0.5 border-b text-left">Year</th>
      <th class="px-1 py-0.5 border-b text-left">Category</th>
      <th class="px-1 py-0.5 border-b text-left">Department</th>
      <th class="px-1 py-0.5 border-b text-left">PDF File</th>
      <th class="hidden">Created at</th>
      <th class="hidden">Updated at</th>
      <th class="px-1 py-0.5 border-b text-left" colspan="2">Actions</th>
    </tr>
  </thead>
  <tbody>
    @foreach($books as $data)
    <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
      <td class="hidden border-b">{{ $data->id }}</td>
      <td class="text-start border-b px-1 py-0.5 w-[200px]">{{ $data->title }}</td>
      <td class="text-start border-b px-1 py-0.5">{{ $data->author }}</td>
      <td class="text-start border-b px-1 py-0.5">{{ $data->year }}</td>
      <td class="text-start border-b px-1 py-0.5">{{ $data->category }}</td>
      <td class="text-start border-b px-1 py-0.5">{{ $data->department }}</td>
      <td class="text-start border-b px-1 py-0.5">
  <button 
    onclick="logAndOpen({{ $data->id }}, '{{ route('pdf.view', ['path' => $data->pdf_filepath]) }}')"
    class="bg-green-600 hover:bg-green-700 text-white font-bold text-xs sm:text-sm px-2 py-1 sm:px-2 sm:py-1 rounded w-full sm:w-auto">
    View
  </button>
</td>

      <td class="hidden border-b">{{ $data->created_at }}</td>
      <td class="hidden border-b">{{ $data->updated_at }}</td>
      <td colspan="2" class="border-b px-1 py-0.5">
        <div class="flex flex-col space-y-1">
          <a href="{{ route('deletebook', $data->id) }}"
             class="bg-red-500 hover:bg-red-600 text-white font-semibold py-0.5 px-1 rounded text-center text-xs">
            Delete
          </a>
          <button 
            class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-semibold py-0.5 px-1 rounded text-xs"
            data-id="{{ $data->id }}"
            data-title="{{ $data->title }}"
            data-author="{{ $data->author }}"
            data-year="{{ $data->year }}">
            Edit
          </button>
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
            <div class="d-flex justify-content-center mt-4">
              {{ $books->links('pagination::tailwind') }}
          </div>
               
          </div>
        </div>
         <script>
          function logAndOpen(ebook_id, pdfUrl) {
            fetch('{{ route('read.store') }}', {
              method: 'POST',
              headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
              },
              body: JSON.stringify({ ebook_id: ebook_id }),
            })
            .then(response => {
              if (response.ok) {
                window.open(pdfUrl, '_blank');
              } else {
                alert('Failed to log view.');
              }
            });
          }
        </script>


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

      <!-- Title (Full Width) -->
      <div class="mb-4">
        <label for="edit_title" class="block text-gray-700 font-bold mb-2">Title</label>
        <textarea name="title" id="edit_title" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required></textarea>
      </div>

      <!-- Author and Year (2 Columns) -->
      <div class="mb-4 grid grid-cols-2 gap-4">
        <div>
          <label for="edit_author" class="block text-gray-700 font-bold mb-2">Author</label>
          <input type="text" name="author" id="edit_author" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
        <div>
          <label for="edit_year" class="block text-gray-700 font-bold mb-2">Year</label>
          <input type="number" name="year" id="edit_year" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        </div>
      </div>

      <!-- Category and Department (2 Columns) -->
      <div class="mb-4 grid grid-cols-2 gap-4">
        <div>
          <label for="edit_category" class="block text-gray-700 font-bold mb-2">Category</label>
          <select name="category" id="edit_category" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">-- Select Category --</option>
            @foreach ($res_out_cats as $cat)
              <option value="{{ $cat->out_cat }}">{{ $cat->out_cat }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label for="edit_department" class="block text-gray-700 font-bold mb-2">Department</label>
          <select name="department" id="edit_department" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">-- Select Department --</option>
          </select>
        </div>
      </div>

      <!-- PDF File (Full Width) -->
      <div class="mb-6">
        <label class="block text-gray-700 font-bold mb-2" for="edit_pdf">PDF File</label>
        <input type="file" name="pdf_filepath" id="edit_pdf" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" accept=".pdf">
      </div>

      <!-- Submit Button -->
      <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition duration-200">Update</button>
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
    function loadDepartments(category) {
        $('#department').html('<option value="">-- Loading... --</option>');

        if (category) {
            $.ajax({
                url: '{{ url("/get-departments") }}/' + encodeURIComponent(category),
                type: 'GET',
                success: function (data) {
                    $('#department').empty().append('<option value="">-- Select Department --</option>');
                    if (Array.isArray(data)) {
                        data.forEach(function (dept) {
                            $('#department').append('<option value="' + dept + '">' + dept + '</option>');
                        });

                        let selected = @json(request('department'));
                        if (selected) {
                            $('#department').val(selected);
                        }
                    }
                },
                error: function (xhr) {
                    console.error('Department loading failed:', xhr.responseText);
                    $('#department').html('<option value="">-- Failed to load --</option>');
                }
            });
        } else {
            $('#department').html('<option value="">-- Select Department --</option>');
        }
    }

   // Trigger department load and submit when category changes
$('#category').on('change', function () {
    let selected = $(this).val();
    $('#out_cat').val(selected); // sync hidden input
    loadDepartments(selected);
    $('#filter-form').submit(); // auto-submit
});

    // Auto-submit when department is selected
    $('#department').on('change', function () {
        $('#filter-form').submit();
    });

    // Initial load if category is pre-selected
    const currentCategory = $('#category').val();
    if (currentCategory) {
        loadDepartments(currentCategory);
    }
});
</script>
  
</body>
</html>
