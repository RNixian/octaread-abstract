<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Add New</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">


    @if($errors->any())
<ul>
@foreach ($errors->all() as $error)
    <li>
{{$error}}
    </li>
@endforeach
</ul>
@endif

    <div class="w-full max-w-lg bg-white rounded shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6">Add New</h2>

    <form action="{{ route('admin.storebooks') }}" method="POST" enctype="multipart/form-data" class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
    @csrf

    <!-- Title (full width) -->
    <div class="mb-4">
        <label class="block text-gray-700 font-bold mb-2" for="title">Title</label>
        <textarea class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                  id="title" name="title" rows="4" required>{{ old('title') }}</textarea>
        @error('title')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Author and Year (2 columns) -->
    <div class="mb-4 grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="author">Author</label>
            <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" type="text" id="author" name="author" value="{{ old('author') }}" required>
            @error('author')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="year">Year</label>
            <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" type="number" id="year" name="year" value="{{ old('year') }}" required>
            @error('year')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- Category and Department (2 columns) -->
    <div class="mb-4 grid grid-cols-2 gap-4">
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="category">Category</label>
            <select name="category" id="category" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Category --</option>
                @foreach ($res_out_cats as $category)
                    <option value="{{ $category->out_cat }}" {{ old('category') == $category->out_cat ? 'selected' : '' }}>{{ $category->out_cat }}</option>
                @endforeach
            </select>
            @error('category')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="block text-gray-700 font-bold mb-2" for="department">Department</label>
            <select name="department" id="department" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="">-- Select Department --</option>
            </select>
            @error('department')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <!-- PDF File (full width) -->
    <div class="mb-6">
        <label class="block text-gray-700 font-bold mb-2" for="pdf_filepath">File</label>
        <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" type="file" id="pdf_filepath" name="pdf_filepath" accept=".pdf,.docx" required>
        @error('pdf_filepath')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Buttons (2-column layout) -->
    <div class="flex justify-end gap-4">
        <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600 transition duration-200">
            Submit
        </button>
        <a href="{{ url('/admin/graduate') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-6 rounded focus:outline-none focus:ring-2 focus:ring-green-300 inline-block">
            Cancel
        </a>
    </div>
</form>


    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#category').change(function () {
            let category = $(this).val();

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
                    }
                });
            } else {
                $('#department').html('<option value="">-- Select Department --</option>');
            }
        });
    });
</script>




</body>
</html>