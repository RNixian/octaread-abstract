<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Admin Registration</title>
   <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">
</head>
<body class="bg-gray-100 min-h-screen flex">
  @include('admin.sidebar')

  <div id="mainContent" class="md:ml-64 flex items-center justify-center w-full min-h-screen px-4">
    <div class="w-full max-w-md">
      
      @if($errors->any())
        <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      @endif

      <div class="bg-white shadow-md rounded px-8 pt-6 pb-8">
        <h2 class="text-2xl font-bold mb-6 text-center">Admin Register</h2>

        <form action="{{ route('admin.storenewadmin') }}" method="POST">
          @csrf

          <div class="mb-4">
            <label for="firstname" class="block text-gray-700 font-bold mb-2">First Name</label>
            <input id="firstname" name="firstname" type="text" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:shadow-outline">
          </div>

        <div class="mb-4">
  <label for="middlename" class="block text-gray-700 font-bold mb-2">Middle Name</label>
  <input id="middlename" name="middlename" type="text" class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:shadow-outline">
</div>


          <div class="mb-4">
            <label for="lastname" class="block text-gray-700 font-bold mb-2">Last Name</label>
            <input id="lastname" name="lastname" type="text" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:shadow-outline">
          </div>

          <div class="mb-4">
            <label for="schoolid" class="block text-gray-700 font-bold mb-2">School ID</label>
            <input id="schoolid" name="schoolid" type="text" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:shadow-outline">
          </div>

          <div class="mb-4">
            <label for="masterkey" class="block text-gray-700 font-bold mb-2">Master Key</label>
            <input id="masterkey" name="masterkey" type="text" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:shadow-outline">
          </div>

          <div class="mb-6">
            <label for="birthdate" class="block text-gray-700 font-bold mb-2">Birthdate</label>
            <input id="birthdate" name="birthdate" type="date" required class="w-full px-3 py-2 border rounded shadow focus:outline-none focus:shadow-outline">
          </div>

          <div class="flex justify-center">
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
              Register
            </button>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>
</html>
