<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OctaRead EBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    .book-card img {
      height: 200px;
      object-fit: cover;
    }

    .btn-custom-red {
      background-color: #dc3545;
      color: white;
      font-weight: bold;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: all 0.3s ease;
      border: none;
    }

    .btn-custom-red:hover {
      background-color: white;
      color: #dc3545;
      border: 1px solid #dc3545;
    }

    .btn-custom-green {
      background-color: #28a745;
      color: white;
      font-weight: bold;
      padding: 0.5rem 1rem;
      border-radius: 0.375rem;
      transition: all 0.3s ease;
      border: none;
    }

    .btn-custom-green:hover {
      background-color: white;
      color: #28a745;
      border: 1px solid #28a745;
    }

    .favorite-btn {
  background: #fff;
  border: 1px solid #dc3545;
  color: #dc3545;
  border-radius: 50%;
  padding: 0.3rem 0.6rem;
}

.favorite-btn.favorited {
  background: #dc3545;
  color: #fff;
}


    .favorite-btn:hover {
      transform: scale(1.2);
    }
  </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Header -->
  @include('pages.usersheader')

  <div class="container py-5">
    <h1 class="mb-4">Research Abstract</h1>

    <form action="{{ route('pages.ebook') }}" method="GET" class="mt-3">
      <!-- Row 1: Category & Department -->
      <div class="d-flex flex-wrap gap-3 mb-3 align-items-center">
        <!-- Category: auto width, flex-grow -->
        <div style="width: 250px;">
          <label for="category" class="form-label fw-bold">Category</label>
          <select name="category" id="category" class="form-select">
            <option value="">All Categories</option>
            @foreach($categories as $category)
              <option value="{{ $category }}" 
                {{ request('category') == $category ? 'selected' : '' }}>
                {{ $category }}
              </option>
            @endforeach
          </select>
        </div>
    
        <!-- Department: fixed width -->
        <div class="flex-grow-1">
          <label for="department" class="form-label fw-bold">Department</label>
          <select name="department" id="department" class="form-select">
            <option value="">-- Select Department --</option>
            <!-- Dynamic options need to be populated via JS -->
            <!-- We'll make sure the selected option remains -->
            @if(request('department'))
              <option value="{{ request('department') }}" selected>{{ request('department') }}</option>
            @endif
          </select>
        </div>
      </div>
    
      <!-- Row 2: Search input + buttons -->
      <div class="d-flex align-items-center gap-2">
        <input 
          type="text" 
          name="search" 
          class="form-control flex-grow-1"
          placeholder="Search book..." 
          value="{{ request('search') }}"
          style="min-width: 150px;"
        >
        <div class="d-flex gap-2">
          <button type="submit" class="btn btn-custom-red">Search</button>
          <a href="{{ url('/pages/ebook') }}" class="btn btn-custom-green">Reset</a>
        </div>
      </div>
    </form>
    
 
   <!-- Book Grid -->
<div class="row mt-4">
  @forelse ($ebooks as $book)
    <div class="col-md-3 mb-4">
      <div class="card book-card h-100 shadow-sm">
        <img src="{{ asset('images/default_pdf_picture.jpg/' . $book->cover_photo) }}" class="card-img-top" alt="Book Cover">
        <div class="card-body d-flex flex-column">
          <h5 class="card-title">{{ $book->title }}</h5>
          <p class="card-text text-muted mb-1">
            <i class="bi bi-person-fill"></i> {{ $book->author }}
          </p>
          <p class="card-text">
            <small>{{ $book->department }} | {{ $book->category }}</small>
          </p>
          <div class="mt-auto d-flex justify-content-between align-items-center">
            <!-- Read Button -->
            <form action="{{ route('read.store') }}" method="POST" class="ml-2" target="_blank">
              @csrf
              <input type="hidden" name="ebook_id" value="{{ $book->id }}">
              <input type="hidden" name="pdf_filepath" value="{{ $book->pdf_filepath }}">
              <button type="submit" class="btn btn-sm btn-custom-red">
                Read
              </button>
            </form>
            
            

              {{-- Only show "Add to Favorites" for logged-in non-guest users --}}
          @if(session()->has('userid') && session('is_guest') === false)
          <form action="{{ route('favorites.store') }}" method="POST" class="ml-2">
              @csrf
              <input type="hidden" name="ebook_id" value="{{ $book->id }}">
              <button 
                type="submit" 
                class="text-red-600 hover:text-red-700 focus:outline-none"
                title="Add to Favorites"
              >
                <i class="bi bi-heart-fill text-gray-300"></i>
              </button>
          </form>
          @endif
          </div>
        </div>
      </div>
    </div>
  @empty
    <div class="col-12">
      <div class="alert alert-warning text-center" role="alert">
        No books found.
      </div>
    </div>
  @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
  {{ $ebooks->withQueryString()->links() }}
</div>

</div>
 


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.getElementById('category').addEventListener('change', function () {
        const categoryId = this.value;

        fetch(`/get-deptres/${categoryId}`)
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
<div>@include('pages.userfooter')</div>

</body>
</html>
