<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Add New</title>
    <link rel="stylesheet" href="{{ url('css/tailwind.min.css') }}">
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

 @include('admin.sidebar')

<div id="mainContent" class="md:ml-64 flex flex-col items-center justify-center w-full p-6">
    <div class="bg-white shadow-md rounded px-8 md:px-32 pt-6 pb-12 w-full max-w-7xl">

        <h2 class="text-2xl font-bold text-center mb-6">Add New</h2>

        @if($errors->any())
            <ul class="mb-4 text-red-500 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif

        <form action="{{ route('admin.storebooks') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Column 1 -->
                <div class="flex flex-col gap-4">
                    <!-- Title -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="title">Title</label>
                        <textarea class="w-full border border-gray-300 rounded px-3 py-6 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                  id="title" name="title" rows="4" required>{{ old('title') }}</textarea>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Author -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="author">Author</label>
                        <textarea class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                  id="author" name="author" rows="4" required>{{ old('author') }}</textarea>
                        @error('author')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="flex flex-col gap-4">
                    <!-- Year -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="year">Year</label>
                        <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                               type="number" id="year" name="year" value="{{ old('year') }}" required>
                        @error('year')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="category">Category</label>
                        <select name="category" id="category"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">-- Select Category --</option>
                            @foreach ($res_out_cats as $category)
                                <option value="{{ $category->out_cat }}" {{ old('category') == $category->out_cat ? 'selected' : '' }}>{{ $category->out_cat }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Department -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="department">Department</label>
                        <select name="department" id="department"
                                class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">-- Select Department --</option>
                        </select>
                        @error('department')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- File -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2" for="pdf_filepath">File</label>
                        <input class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400"
                               type="file" id="pdf_filepath" name="pdf_filepath" accept=".pdf,.docx" required>
                        @error('pdf_filepath')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-center mt-10">
                <button type="submit"
                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-6 rounded transition duration-200">
                    Submit
                </button>
            </div>
        </form>
    </div>
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