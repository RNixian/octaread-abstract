<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>OctaRead Members</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
</head>
<body class="bg-gray-100 min-h-screen">

@if($errors->any())
<ul>
@foreach ($errors->all() as $error)
    <li>{{$error}}</li>
@endforeach
</ul>
@endif

<div class="flex min-h-screen w-full">
  @include('admin.sidebar')

<div id="mainContent" class="md:ml-64 flex flex-col lg:flex-row items-start justify-center gap-8 w-full p-6">

  

    <!-- Member Entry Form -->
    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-8">
      <h2 class="text-2xl font-bold mb-6 text-center">Member Entry</h2>
      <form action="{{ route('admin.storemember') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div>
          <label for="fullname" class="block text-gray-700 font-bold mb-2">Full Name</label>
          <input type="text" id="fullname" name="fullname" required class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>

        <div>
          <label for="position" class="block text-gray-700 font-bold mb-2">Position</label>
          <select name="position" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="">-- Select Position --</option>
            @foreach ($positions as $mmbr)
              <option value="{{ $mmbr->position }}" {{ request('position') == $mmbr->position ? 'selected' : '' }}>{{ $mmbr->position }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="profile_imgpath" class="block text-gray-700 font-bold mb-2">Profile Photo</label>
          <input type="file" name="profile_imgpath" id="profile_imgpath" accept="image/jpeg,image/png,image/jpg" class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        <div class="flex justify-center">
          <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded">Submit</button>
        </div>
      </form>
    </div>

    <!-- Search + Table -->
    <div class="bg-white shadow-md rounded px-6 pt-6 pb-8 w-full">
      <form method="GET" action="{{ url('/admin/member') }}" class="flex flex-col md:flex-row gap-2 md:gap-4 mb-4">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Enter..." class="w-full md:w-1/2 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
        <select name="position" class="w-full md:w-1/3 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
          <option value="">-- Select Position --</option>
          @foreach ($positions as $mmbr)
            <option value="{{ $mmbr->position }}" {{ request('position') == $mmbr->position ? 'selected' : '' }}>{{ $mmbr->position }}</option>
          @endforeach
        </select>
        <div class="flex gap-2">
          <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Search</button>
          <a href="{{ url('/admin/member') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Reset</a>
        </div>
      </form>

      <div class="overflow-x-auto w-full">
        <table class="min-w-full border border-gray-200">
          <thead>
            <tr class="bg-blue-900 text-white">
              <th class="hidden">Id</th>
              <th class="px-4 py-2 border-b text-left">Full Name</th>
              <th class="px-4 py-2 border-b text-left">Position</th>
              <th class="px-4 py-2 border-b text-left">Profile Photo</th>
              <th class="hidden">Created at</th>
              <th class="hidden">Updated at</th>
              <th class="px-4 py-2 border-b text-left">Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($membersmodel as $data)
              <tr class="bg-white odd:bg-gray-100 hover:bg-gray-200">
                <td class="hidden">{{ $data->id }}</td>
                <td class="px-4 py-2 border-b">{{ $data->fullname }}</td>
                <td class="px-4 py-2 border-b">{{ $data->position }}</td>
                <td class="px-4 py-2 border-b">
                  @if($data->profile_imgpath)
                    <img src="{{ asset('storage/' . $data->profile_imgpath) }}" alt="Profile Photo" class="w-20 h-20 object-cover rounded-full border" />
                  @else
                    N/A
                  @endif
                </td>
                <td class="hidden">{{ $data->created_at }}</td>
                <td class="hidden">{{ $data->updated_at }}</td>
                <td class="px-4 py-2 border-b space-x-2">
                  <a href="{{ route('deletemember', $data->id) }}" class="bg-red-500 hover:bg-red-600 text-white font-bold py-1 px-3 rounded">Delete</a>
                  <button class="btn-edit bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded" data-id="{{ $data->id }}" data-fullname="{{ $data->fullname }}" data-position="{{ $data->position }}">Edit</button>
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
        <button id="closeModal" class="absolute top-2 right-2 text-gray-700 hover:text-gray-900 text-2xl">&times;</button>
        <h2 class="text-2xl font-bold mb-6">Update Member</h2>
        <form id="updateForm" action="{{ route('updatemember', ['id' => '__ID__']) }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" id="carousel_id" value="">

          <div>
            <label for="edit_fullname" class="block text-gray-700 font-bold mb-2">Full Name</label>
            <input type="text" name="fullname" id="edit_fullname" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" required>
          </div>

          <div class="mb-4">
            <label for="edit_position" class="block text-gray-700 font-bold mb-2">Position</label>
            <select name="edit_pposition" id="edit_position" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
              <option value="">-- Select Position --</option>
              @foreach ($positions as $mmbr)
                <option value="{{ $mmbr->position }}">{{ $mmbr->position }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-4">
            <label for="edit_profile_imgpath" class="block text-gray-700 font-bold mb-2">Profile Photo</label>
            <input type="file" name="profile_imgpath" id="edit_profile_imgpath" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400" accept="image/jpeg,image/png,image/jpg">
          </div>

          <div class="flex justify-end mt-4">
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Update</button>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>


<script>
  const updateModal = document.getElementById('updateModal');
  const closeModal = document.getElementById('closeModal');
  const updateForm = document.getElementById('updateForm');

  document.querySelectorAll('.btn-edit').forEach(button => {
    button.addEventListener('click', function () {
      const id = this.getAttribute('data-id');
      const fullname = this.getAttribute('data-fullname');
      const position = this.getAttribute('data-position');

      updateForm.action = updateForm.action.replace('__ID__', id);
      document.getElementById('carousel_id').value = id;
      document.getElementById('edit_fullname').value = fullname;
      document.getElementById('edit_position').value = position;
      updateModal.classList.remove('hidden');
    });
  });

  closeModal.addEventListener('click', function () {
    updateModal.classList.add('hidden');
    updateForm.action = updateForm.action.replace(/(\d+)$/, '__ID__');
  });

  window.addEventListener('click', function (e) {
    if (e.target === updateModal) {
      updateModal.classList.add('hidden');
    }
  });
</script>

</body>
</html>