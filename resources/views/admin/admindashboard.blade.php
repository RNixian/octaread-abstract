<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
</head>
<body class="bg-gray-100 flex items-start justify-start min-h-screen">
  <div id="mainContent" class="flex flex-1 items-center justify-center min-h-screen">
  <div class="flex w-full min-h-screen">
    @include('admin.sidebar')
    <div id="mainContent" class="md:ml-64 md:flex">
    <div class="flex-1 p-12">
      <div class="max-w-7xl w-full mx-auto">
        <h2 class="text-3xl font-bold mb-8 text-center">Dashboard</h2>
  
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 justify-center">
          <!-- Container 1 -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Number of Books</h2>
            <h2 class="font-bold text-center" style="font-size: 6rem;">{{ $totalBooks }}</h2>
          </div>

          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-2 text-center">Most Viewed Book</h2>
            <p class="text-center mb-4 font-medium">"{{ $mostViewedTitle }}" <br> Count: {{ $mostViewedCount }}</p>
        </div>

          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-2 text-center">Most Favorite Book</h2>
            <p class="text-center mb-4 font-medium">"{{ $mostFavoriteTitle }}" <br> Count: {{ $mostFavoriteCount }}</p>
        </div>
        

          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Number of Users</h2>
            <h2 class="font-bold text-center" style="font-size: 6rem;">{{ $totalUser }}</h2>
          </div>

          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Guest Log</h2>
            <h2 class="font-bold text-center" style="font-size: 6rem;">{{ $totalGuest }}</h2>
          </div>
  
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center justify-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-6 text-center">Total Number of Admin</h2>
            <h2 class="font-bold text-center" style="font-size: 6rem;">{{ $totalAdmin }}</h2>
          </div>

          <!-- Container 2 -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-6 text-center">Books Category Distribution</h2>
            <canvas id="booksPieChart" width="300" height="300"></canvas>
          </div>
  
          <!-- Container 3 -->
          <div class="bg-white shadow-md rounded p-8 flex flex-col items-center" style="width: 300px; height: 400px;">
            <h2 class="text-lg font-semibold mb-6 text-center">Books Count by Year</h2>
            <canvas id="byYearChart" width="300" height="300"></canvas>
          </div>
        </div>
    
 <!-- Container 4 -->
 <div style="margin-top: 5%">
<div class="bg-white shadow rounded p-4 flex flex-col items-center w-full" style="max-width: 990px; height: 600px;">
  <form method="GET" action="{{ route('admin.admindashboard') }}" class="w-full text-sm">

    <!-- Row 1: Search bar + Filter + Reset buttons -->
    <div class="flex flex-wrap items-center gap-3 mb-4">
      <div class="flex-grow min-w-[200px]">
        <label for="search" class="block text-gray-700 font-medium mb-1">Search</label>
        <input
          type="text"
          name="search"
          id="search"
          value="{{ request('search') }}"
          placeholder="Search by Year, Category, Department..."
          class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400"
        />
      </div>

      <div class="flex space-x-2 mt-5 sm:mt-0">
        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Filter</button>
        <a href="{{ route('admin.admindashboard') }}" class="bg-gray-300 text-gray-800 px-3 py-1 rounded hover:bg-gray-400">Reset</a>
      </div>
    </div>

    <!-- Row 2: Category & Department -->
    <div class="flex flex-wrap gap-4 mb-4">
      <div class="flex-grow min-w-[160px]">
        <label for="category" class="block text-gray-700 font-medium mb-1">Category</label>
        <select name="category" id="category" class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400">
          <option value="">All Categories</option>
          @foreach($categories as $category)
            <option value="{{ $category }}">{{ $category }}</option>
          @endforeach
        </select>
      </div>

      <div class="flex-grow min-w-[160px]">
        <label for="department" class="block text-gray-700 font-medium mb-1">Department</label>
        <select name="department" id="department" class="w-full border border-gray-300 rounded px-2 py-1">
          <option value="">-- Select Department --</option>
          <!-- Add dynamic options here -->
        </select>
      </div>
    </div>

    <!-- Row 3: From Date & To Date -->
    <div class="flex flex-wrap gap-4 mb-4">
      <div class="flex-grow min-w-[160px]">
        <label for="from_date" class="block text-gray-700 font-medium mb-1">From Date</label>
        <input
          type="date"
          name="from_date"
          id="from_date"
          value="{{ request('from_date') }}"
          class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400"
        />
      </div>

      <div class="flex-grow min-w-[160px]">
        <label for="to_date" class="block text-gray-700 font-medium mb-1">To Date</label>
        <input
          type="date"
          name="to_date"
          id="to_date"
          value="{{ request('to_date') }}"
          class="w-full border border-gray-300 rounded px-2 py-1 focus:outline-none focus:ring-1 focus:ring-blue-400"
        />
      </div>
    </div>

    <!-- Optional Submit Button at the bottom -->
    <div class="flex justify-end">
      <button type="submit" class="bg-green-500 text-white px-4 py-1.5 rounded hover:bg-green-600">
        Apply Filters
      </button>
    </div>
  </form>
  <canvas id="filteredChart" width="300" height="100"></canvas>
</div>
</div>
      </div>

    </div>
  </div>
</div>
</div>

<script>
  // Pie Chart
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

  // Bar Chart
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

<script>
    const ctx = document.getElementById('filteredChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($filteredBooks ?? []) !!},
            datasets: [{
                label: 'Filtered Books',
                data: {!! json_encode($filteredCounts ?? []) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.6)'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Filtered Book Count' }
            }
        }
    });
</script>


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
