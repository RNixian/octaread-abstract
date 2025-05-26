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

  <div class="flex w-full">
    @include('admin.sidebar')

    <div class="flex-1 p-8">
      <div class="max-w-6xl w-full mx-auto">
        <h2 class="text-2xl font-bold mb-6 text-center">Dashboard</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

          <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-md font-semibold mb-4 text-center">Total Number of Books</h2>
            <h2 class="text-10x5 font-bold mb-6 text-center" style="font-size: 8rem;">{{ $totalBooks }}</h2>

          </div>


          <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-md font-semibold mb-4 text-center">Books Category Distribution</h2>
            <canvas id="booksPieChart" width="200" height="200" class="mx-auto"></canvas>
          </div>

          <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-md font-semibold mb-4 text-center">Books Count by Department</h2>
            <canvas id="byDeptChart" width="200" height="200" class="mx-auto"></canvas>
          </div>

   
          <div class="bg-white shadow-md rounded p-4">
            <h2 class="text-md font-semibold mb-4 text-center">Books Count by Year</h2>
            <canvas id="byYearChart" width="200" height="200" class="mx-auto"></canvas>
          </div>

   <div class="bg-white shadow-md rounded p-4">
    <h2 class="text-md font-semibold mb-4 text-center">Books Count by Graduate Dept</h2>
    <canvas id="bygradDeptChart" width="200" height="200" class="mx-auto"></canvas>
  </div>

  <div class="bg-white shadow-md rounded p-4">
    <h2 class="text-md font-semibold mb-4 text-center">Books Count by Under-Graduate Dept</h2>
    <canvas id="byundergradDeptChart" width="200" height="200" class="mx-auto"></canvas>
  </div>

  <div class="bg-white shadow-md rounded p-4">
    <h2 class="text-md font-semibold mb-4 text-center">Books Count by Employee Dept</h2>
    <canvas id="byempDeptChart" width="200" height="200" class="mx-auto"></canvas>
  </div>




        </div>
      </div>
    </div>
  </div>

  <script>
    // Pie Chart for Book Categories
    const pieCtx = document.getElementById('booksPieChart').getContext('2d');
    new Chart(pieCtx, {
      type: 'pie',
      data: {
        labels: @json($pieData['labels']),
        datasets: [{
          data: @json($pieData['values']),
          backgroundColor: [
            'rgba(75, 192, 192, 0.6)',
            'rgba(255, 99, 132, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(153, 102, 255, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(54, 162, 235, 0.6)'
          ],
          borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 99, 132, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(54, 162, 235, 1)'
          ],
          borderWidth: 1
        }]
      }
    });

    // Bar Chart for Department
    const deptCtx = document.getElementById('byDeptChart').getContext('2d');
    new Chart(deptCtx, {
      type: 'bar',
      data: {
        labels: @json($barDatabydept['labels']),
        datasets: [{
          label: 'Books Count',
          data: @json($barDatabydept['values']),
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
        }
      }
    });

    // Bar Chart for Year
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
            ticks: {
              precision: 0
            }
          }
        }
      }
    });


   // Graduate Chart
const gradDeptCtx = document.getElementById('bygradDeptChart').getContext('2d');
new Chart(gradDeptCtx, {
  type: 'bar',
  data: {
    labels: @json($bygradDeptChart['labels']),
    datasets: [{
      label: 'Graduate Books Count',
      data: @json($bygradDeptChart['values']),
      backgroundColor: 'rgba(153, 102, 255, 0.6)',
      borderColor: 'rgba(153, 102, 255, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// Undergraduate Chart
const undergradDeptCtx = document.getElementById('byundergradDeptChart').getContext('2d');
new Chart(undergradDeptCtx, {
  type: 'bar',
  data: {
    labels: @json($byundergradDeptChart['labels']),
    datasets: [{
      label: 'Undergraduate Books Count',
      data: @json($byundergradDeptChart['values']),
      backgroundColor: 'rgba(75, 192, 192, 0.6)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});

// Employee Chart
const empDeptCtx = document.getElementById('byempDeptChart').getContext('2d');
new Chart(empDeptCtx, {
  type: 'bar',
  data: {
    labels: @json($byempDeptChart['labels']),
    datasets: [{
      label: 'Employee Books Count',
      data: @json($byempDeptChart['values']),
      backgroundColor: 'rgba(255, 159, 64, 0.6)',
      borderColor: 'rgba(255, 159, 64, 1)',
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


  </script>

</body>
</html>
