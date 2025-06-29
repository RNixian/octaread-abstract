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
 
<!-- Search and Filter -->
<form method="GET" action="{{ url('/admin/account/guestlog') }}" class="flex flex-col md:flex-row items-center mb-4 gap-2 w-full">
  
  <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..." 
    class="flex-1 shadow appearance-none border rounded py-2 px-3 text-gray-700 focus:outline-none focus:shadow-outline w-full"/>

  <div class="flex gap-2">
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
      Search
    </button>
    
    <a href="{{ url('/admin/account/guestlog') }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
      Clear
    </a>
  </div>

</form>
 
       <!-- Table -->
       <div class="overflow-x-auto">
         <table class="min-w-full table-auto border-collapse text-sm">
  <thead>
    <tr class="bg-blue-900 text-white">
      <th class="px-2 py-1 border-b text-left">First Name</th>
      <th class="px-2 py-1 border-b text-left">Last Name</th>
      <th class="px-2 py-1 border-b text-left">Reference#</th>
      <th class="px-2 py-1 border-b text-left">Purpose</th>
      <th class="px-2 py-1 border-b text-left">Date Logged</th>
      <th class="px-2 py-1 border-b text-left">Actions</th>
    </tr>
  </thead>
  <tbody>
    @forelse($users as $data)
      <tr class="bg-white border-b hover:bg-gray-100">
        <td class="px-2 py-1">{{ $data->firstname }}</td>
        <td class="px-2 py-1">{{ $data->lastname }}</td>
        <td class="px-2 py-1">{{ $data->schoolid }}</td>
        <td class="px-2 py-1">{{ $data->department }}</td>
        <td class="px-2 py-1">{{ \Carbon\Carbon::parse($data->birthdate)->format('d-m-Y') }}</td>
        <td class="px-2 py-1">
          <a href="{{ route('deleteuseracc', $data->id) }}"
             class="bg-red-500 hover:bg-red-600 text-white text-xs font-semibold py-1 px-2 rounded">
            Delete
          </a>
        </td>
      </tr>
    @empty
      <tr>
        <td colspan="6" class="text-center py-3 text-gray-500 text-sm">No users found.</td>
      </tr>
    @endforelse
  </tbody>
</table>

          <div class="d-flex justify-content-center mt-4">
              {{ $users->links('pagination::tailwind') }}
          </div>
       </div>
     </div>

</body>
</html>