<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <title>OctaRead Admin Registration</title>
</head>
<body class="bg-gray-100 min-h-screen flex">
  @include('admin.sidebar')

  <div id="mainContent" class="flex flex-1 items-center justify-center min-h-screen">


    <div class="flex-grow flex items-center justify-center px-4">
        <div class="max-w-md w-full">
            @if($errors->any())
                <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <h2 class="text-2xl font-bold mb-6 text-center">Admin Register</h2>

                <form action="{{ route('admin.storenewadmin') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="firstname">
                            First Name
                        </label>
                        <input id="firstname" name="firstname" type="text" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="middlename">
                            Middle Name
                        </label>
                        <input id="middlename" name="middlename" type="text" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="lastname">
                            Last Name
                        </label>
                        <input id="lastname" name="lastname" type="text" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="schoolid">
                            School ID
                        </label>
                        <input id="schoolid" name="schoolid" type="text" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
    
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="masterkey">
                            Master Key
                        </label>
                        <input id="masterkey" name="masterkey" type="text" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
    
                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="birthdate">
                            Birthdate
                        </label>
                        <input id="birthdate" name="birthdate" type="date" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
    
                    <div class="flex flex-col space-y-4 items-center">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-6 rounded focus:outline-none focus:shadow-outline">
                            Register
                        </button>  
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
