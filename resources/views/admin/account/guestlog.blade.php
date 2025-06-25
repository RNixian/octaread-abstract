<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Guest Logs</title>
   <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">
 <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="flex min-h-screen bg-gray-100 w-full">
   <!-- Sidebar -->
   @include('admin.sidebar')

   <!-- Main Content -->
   <div id="mainContent" class="md:ml-64 flex flex-col w-full p-6">
     
     <!-- Validation Errors -->
     @if($errors->any())
       <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
         <ul class="list-disc pl-5">
           @foreach ($errors->all() as $error)
             <li>{{ $error }}</li>
           @endforeach
         </ul>
       </div>
     @endif
 
     <!-- Card -->
     <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 w-full">
       <h2 class="text-2xl font-bold mb-6 text-center">Guest Log</h2>
 
       <!-- Search Form -->
       <form method="GET" action="{{ route('admin.account.guestlog') }}" class="flex flex-col md:flex-row justify-between items-center mb-4 gap-2">
         <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..."
           class="w-full shadow border rounded md:w-1/2 py-2 px-3 text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-400" />
         <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
           Search
         </button>
       </form>
 
       <!-- Table -->
       <div class="overflow-x-auto">
         <table class="min-w-full table-auto border-collapse">
           <thead>
             <tr class="bg-blue-900 text-white">
               <th class="px-4 py-2 border-b text-left">First Name</th>
               <th class="px-4 py-2 border-b text-left">Last Name</th>
               <th class="px-4 py-2 border-b text-left">Reference#</th>
               <th class="px-4 py-2 border-b text-left">Purpose</th>
               <th class="px-4 py-2 border-b text-left">Date Logged</th>
               <th class="px-4 py-2 border-b text-left">Actions</th>
             </tr>
           </thead>
           <tbody>
            @forelse($users as $data)
               <tr class="bg-white border-b hover:bg-gray-100">
                 <td class="px-4 py-2">{{ $data->firstname }}</td>
                 <td class="px-4 py-2">{{ $data->lastname }}</td>
                 <td class="px-4 py-2">{{ $data->schoolid }}</td>
                 <td class="px-4 py-2">{{ $data->department }}</td>
                 <td class="px-4 py-2 border-b">{{ \Carbon\Carbon::parse($data->birthdate)->format('d-m-Y') }}</td>
                 <td class="px-4 py-2 space-x-2">
                  <a href="{{ route('deleteuseracc', $data->id) }}"
                    class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">
                   Delete
                 </a>
                 </td>
               </tr>
             @empty
               <tr>
                 <td colspan="9" class="text-center py-4 text-gray-500">No users found.</td>
               </tr>
             @endforelse
           </tbody>
         </table>
       </div>
     </div>

</body>
</html>