<!-- Load Lucide Icons -->
<script src="{{ asset('js/lucide.min.js') }}"></script>

<!-- Toggle Button -->
<button id="toggleSidebar"
  class="fixed top-4 left-4 bg-yellow-300 text-black rounded p-1 w-9 h-9 flex items-center justify-center z-50 shadow-md md:hidden">
  ☰
</button>


<!-- Sidebar -->

<div id="sidebar"
class="fixed top-0 left-0 h-screen w-64 bg-blue-900 text-white p-4 shadow-md overflow-auto z-40 transform md:translate-x-0 -translate-x-full md:block transition-transform duration-300">
  <br><br>
  <div class="d-flex align-items-center">
    <img src="{{ asset('images/load.png') }}" alt="Logo" style="height: 150px; width: 150px; margin-left:15%;">
</div>

  @if(session()->has('firstname'))
  {{-- Welcome message in the center when logged in --}}
  <div class="text-white fw-semibold">
    <h2 class="text-xl font-bold mb-4 flex items-center gap-2">
      <i data-lucide="settings"></i> Admin: {{ session('firstname') }}
    </h2>  
  </div>
@endif

  <ul class="space-y-1">
    <li>
      <a href="{{ url('/admin/admindashboard') }}" class="flex items-center gap-2 py-2 px-4 hover:bg-yellow-200 rounded">
        <i data-lucide="layout-dashboard"></i> Dashboard
      </a>
    </li>
    <li>
      <a href="{{ url('/admin/graduate') }}" class="flex items-center gap-2 py-2 px-4 hover:bg-yellow-200 rounded">
        <i data-lucide="graduation-cap"></i> Research
      </a>
    </li>

      <a href="{{ url('/admin/member') }}" class="flex items-center gap-2 py-2 px-4 hover:bg-yellow-200 rounded">
        <i data-lucide="users"></i> Member
      </a>
    </li>

    <li class="relative">
      <button id="setupDropdownBtn" class="flex items-center gap-2 w-full text-left py-2 px-4 hover:bg-yellow-200 rounded focus:outline-none">
        <i data-lucide="sliders-horizontal"></i> SetUp
      </button>
      <ul id="setupDropdown" class="absolute left-0 mt-1 w-full bg-white shadow-md rounded hidden z-10 text-black">
       <!-- <li><a href="{{ url('/admin/setup/department') }}" class="block py-2 px-4 hover:bg-blue-200">Department</a></li>-->
        <li><a href="{{ url('/admin/setup/usertype') }}" class="block py-2 px-4 hover:bg-blue-200">User Type</a></li>
        <li><a href="{{ url('/admin/setup/userdepartment') }}" class="block py-2 px-4 hover:bg-blue-200">User Department</a></li>
        <li><a href="{{ url('/admin/setup/carousel') }}" class="block py-2 px-4 hover:bg-blue-200">Carousel</a></li>
        <li><a href="{{ url('/admin/setup/position') }}" class="block py-2 px-4 hover:bg-blue-200">Position</a></li>
        <li><a href="{{ url('/admin/setup/output_category') }}" class="block py-2 px-4 hover:bg-blue-200">Output Category</a></li>
        <li><a href="{{ url('/admin/setup/under_output_category') }}" class="block py-2 px-4 hover:bg-blue-200">Under Output Category</a></li>
      </ul>
    </li>
  
    <li class="relative">
      <!-- Button to toggle the dropdown -->
      <button id="accountsDropdownBtn"
        class="flex items-center gap-2 w-full text-left py-2 px-4 hover:bg-yellow-200 rounded focus:outline-none">
        <i data-lucide="user-cog"></i> Accounts
      </button>
    
      <!-- Dropdown menu -->
      <ul id="accountsDropdown"
        class="absolute left-0 mt-1 w-full bg-white shadow-md rounded hidden z-10 text-black">
        <li><a href="{{ url('/admin/account/useraccount') }}" class="block py-2 px-4 hover:bg-blue-200">User Accounts</a></li>
           @if(session('role') === 'superadmin')
        <li><a href="{{ url('/admin/account/adminaccount') }}" class="block py-2 px-4 hover:bg-blue-200">Admin Accounts</a></li>
        @endif
        <li><a href="{{ url('/admin/account/guestlog') }}" class="block py-2 px-4 hover:bg-blue-200">Guest Logs</a></li>
      </ul>
    </li>
    

 @if(session('role') !== 'admin')
  <li>
    <a href="{{ url('/admin/register') }}" class="flex items-center gap-2 py-2 px-4 hover:bg-yellow-200 rounded">
      <i data-lucide="user"></i> Register
    </a>
  </li>
@endif


</ul>

  <!-- Footer -->
  <div class="mt-20 pt-4 border-t border-gray-300">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit"
        class="flex items-center gap-2 hover:bg-red-600 text-white font-bold py-2 px-6 rounded focus:outline-none">
        <i data-lucide="log-out"></i> Log Out
      </button>
    </form>
  </div>
</div>

<!-- JS Script -->
<script>
  const toggleBtn = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const dropdownBtn = document.getElementById('setupDropdownBtn');
  const dropdown = document.getElementById('setupDropdown');
  const accdropdownBtn = document.getElementById('accountsDropdownBtn');
  const accdropdown = document.getElementById('accountsDropdown');
  const rocdropdownBtn = document.getElementById('rocsDropdownBtn');
  const rocdropdown = document.getElementById('rocsDropdown');


  toggleBtn.addEventListener('click', () => {
    sidebar.classList.toggle('-translate-x-full');
  });

  dropdownBtn.addEventListener('click', () => {
    dropdown.classList.toggle('hidden');
  });

  accdropdownBtn.addEventListener('click', () => {
    accdropdown.classList.toggle('hidden');
  });

  document.addEventListener('click', (e) => {
    if (!sidebar.contains(e.target) && !toggleBtn.contains(e.target) && window.innerWidth < 768) {
      sidebar.classList.add('-translate-x-full');
    }
  });

  // Load Lucide icons
  lucide.createIcons();
</script>
