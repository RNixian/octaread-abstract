<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link rel="stylesheet" href="{{ asset('css/tailwind.min.css') }}">

  <script src="{{ asset('js/chart.min.js') }}"></script>
</head>

<body class="bg-gray-100 flex items-start justify-start min-h-screen">
  <div class="flex w-full min-h-screen">
    @include('admin.sidebar')

    <div class="md:ml-64 flex-1 p-12">
      <div class="max-w-7xl w-full mx-auto">
        <h2 class="text-3xl font-bold mb-8 text-center">Dashboard</h2>

<!-- Filter Section -->
       <div class="mt-10">
<!-- Toggle Button ABOVE the entire container -->
<div class="flex justify-end max-w-5xl mx-auto mt-4 mb-2 w-full">
  <button 
    onclick="toggleMainContainer()" 
    id="mainToggleBtn"
    class="text-xl font-bold text-white bg-gray-700 hover:bg-gray-800 rounded-full w-8 h-8 flex items-center justify-center"
    title="Toggle Panel"
  >
    −
  </button>
</div>

<!-- Entire Content Container to be Toggled -->
<div id="mainContainer" class="bg-white shadow rounded p-4 flex flex-col items-center w-full max-w-5xl mx-auto" style="height: auto;">
  <form method="GET" action="{{ route('admin.admindashboard') }}" class="w-full text-sm">

    <!-- Category & Department -->
    <div class="flex flex-wrap gap-4 mb-4">
      <div class="flex-grow min-w-[160px]">
        <label class="block text-gray-700 mb-1">Category</label>
        <select name="category" class="w-full border rounded px-2 py-1">
          <option value="">All Categories</option>
          @foreach($categories as $category)
            <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
              {{ $category }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="flex-grow min-w-[160px]">
        <label class="block text-gray-700 mb-1">Department</label>
        <select name="department" class="w-full border rounded px-2 py-1">
          <option value="">-- Select Department --</option>
          @foreach($departments as $department)
            <option value="{{ $department }}" {{ request('department') == $department ? 'selected' : '' }}>
              {{ $department }}
            </option>
          @endforeach
        </select>
      </div>
    </div>

    <!-- Date & Year Range -->
    <div class="flex flex-wrap gap-4 mb-4">
      <!-- Created Date Range -->
      <div class="flex-grow w-auto">
        <label class="block text-gray-700 mb-1">Created From</label>
        <input type="date" name="from_date" value="{{ request('from_date') }}" class="w-full border rounded px-2 py-1" />
      </div>

     <div class="flex-grow w-auto">
        <label class="block text-gray-700 mb-1">Created To</label>
        <input type="date" name="to_date" value="{{ request('to_date') }}" class="w-full border rounded px-2 py-1" />
      </div>
    </div>
   <!-- Toggle Year Range Button -->
      <div class="flex-grow min-w-[160px] flex items-end">
        <button 
          type="button" 
          onclick="toggleYearFields()" 
          id="yearToggleBtn"
          class="text-sm bg-blue-500 text-white px-3 py-1.5 rounded hover:bg-blue-600"
        >
          +
        </button>
      </div>
    <!-- Year Range (Initially Hidden) -->
    <div id="yearFields" class="flex flex-wrap gap-4 mb-4" style="display: none;">
      <div class="flex-grow min-w-[160px]">
        <label class="block text-gray-700 mb-1">Year From</label>
        <input type="number" name="year_from" value="{{ request('year_from') }}" class="w-full border rounded px-2 py-1" placeholder="e.g. 2020" />
      </div>

      <div class="flex-grow min-w-[160px]">
        <label class="block text-gray-700 mb-1">Year To</label>
        <input type="number" name="year_to" value="{{ request('year_to') }}" class="w-full border rounded px-2 py-1" placeholder="e.g. 2024" />
      </div>
    </div>

    <!-- Buttons -->
    <div class="flex justify-end gap-2 mb-4">
      <a href="{{ route('admin.admindashboard') }}" class="bg-red-500 text-white px-4 py-1.5 rounded hover:bg-red-600">Reset</a>
      <button type="submit" class="bg-green-500 text-white px-4 py-1.5 rounded hover:bg-green-600">Apply Filters</button>
    </div>
  </form>

  <!-- Chart Section -->
  <div class="w-full">
    @if(!empty($filteredBooks) && !empty($filteredCounts))
      <canvas id="filteredChart" width="400" height="150"></canvas>
    @else
      <p class="text-gray-500 mt-6">No data available for the selected filters.</p>
    @endif
  </div>
</div>

<!-- JavaScript to toggle both main container and year fields -->
<script>
  function toggleMainContainer() {
    const container = document.getElementById('mainContainer');
    const btn = document.getElementById('mainToggleBtn');

    if (container.style.display === 'none') {
      container.style.display = 'block';
      btn.textContent = '−';
    } else {
      container.style.display = 'none';
      btn.textContent = '+';
    }
  }

  function toggleYearFields() {
    const yearFields = document.getElementById('yearFields');
    const toggleBtn = document.getElementById('yearToggleBtn');

    if (yearFields.style.display === 'none') {
      yearFields.style.display = 'flex';
      toggleBtn.textContent = '−';
    } else {
      yearFields.style.display = 'none';
      toggleBtn.textContent = '+';
    }
  }
</script>



<div class="mt-8"></div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 justify-center">
          <!-- Total Books -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Number of Books</h2>
            <h2 class="font-bold text-center text-6xl">{{ $totalBooks }}</h2>
          </div>

          <!-- Most Viewed -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-2 text-center">Most Viewed Book</h2>
            <p class="text-center mb-4 font-medium">"{{ $mostViewedTitle }}"<br>Count: {{ $mostViewedCount }}</p>
          </div>

          <!-- Most Favorite -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-2 text-center">Most Favorite Book</h2>
            <p class="text-center mb-4 font-medium">"{{ $mostFavoriteTitle }}"<br>Count: {{ $mostFavoriteCount }}</p>
          </div>

          <!-- Total Users -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Number of Users</h2>
            <h2 class="font-bold text-center text-6xl">{{ $totalUser }}</h2>
          </div>

          <!-- Guest Log -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Guest Log</h2>
            <h2 class="font-bold text-center text-6xl">{{ $totalGuest }}</h2>
          </div>

          <!-- Admin Count -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Number of Admin</h2>
            <h2 class="font-bold text-center text-6xl">{{ $totalAdmin }}</h2>
          </div>

          <!-- Category Pie Chart -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-6 text-center">Books Category Distribution</h2>
            <canvas id="booksPieChart" width="300" height="300"></canvas>
          </div>

          <!-- Yearly Bar Chart -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center w-[300px] h-[400px]">
            <h2 class="text-lg font-semibold mb-6 text-center">Books Count by Year</h2>
            <canvas id="byYearChart" width="300" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pie Chart Script -->
  <script>
    const pieCtx = document.getElementById('booksPieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: @json($pieData['labels']),
        datasets: [{
          data: @json($pieData['values']),
          backgroundColor: [
            'rgba(255, 99, 132, 0.6)',
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)'
          ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1
        }]
      }
    });
  </script>

  <!-- Books by Year Chart -->
  <script>
    const yearCtx = document.getElementById('byYearChart').getContext('2d');
    new Chart(yearCtx, {
      type: 'bar',
      data: {
        labels: @json($barDatabyyr['labels']),
        datasets: [{
          label: 'Books Count',
          data: @json($barDatabyyr['values']),
          backgroundColor: 'rgba(75, 192, 192, 0.6)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true,
            title: {
              display: true,
              text: 'Number of Books'
            }
          }
        }
      }
    });
  </script>

  <!-- Filtered Chart -->
  @if(!empty($filteredBooks) && !empty($filteredCounts))
<script>
  const filteredCtx = document.getElementById('filteredChart').getContext('2d');
  new Chart(filteredCtx, {
    type: 'bar',
    data: {
      labels: @json($filteredBooks),
      datasets: [{
        label: 'Filtered Books',
        data: @json($filteredCounts),
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            precision: 0
          }
        }
      },
      plugins: {
        legend: { display: false },
        title: { display: true, text: 'Filtered Book Count' }
      }
    }
  });
</script>
@endif


  <!-- Category to Department Dynamic Fetch -->
  <script>
    document.getElementById('category').addEventListener('change', function () {
      const categoryId = this.value;
      fetch(`/get-deptgraph/${categoryId}`)
        .then(response => response.json())
        .then(data => {
          const departmentSelect = document.getElementById('department');
          departmentSelect.innerHTML = '<option value="">-- Select Department --</option>';
          data.forEach(dep => {
            const option = document.createElement('option');
            option.value = dep;
            option.textContent = dep;
            departmentSelect.appendChild(option);
          });
        });
    });
  </script>
</body>
</html>
