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



   <!-- Category Buttons -->
   <form action="{{ route('pages.ebook') }}" method="GET" class="mt-3 d-flex flex-wrap gap-2">
    @php
      $categories = ['graduate', 'under-graduate', 'employee'];
    @endphp

    @foreach ($categories as $category)
      <button 
        type="submit" 
        name="category" 
        value="{{ $category }}" 
        class="btn {{ request('category') == $category ? 'btn-dark' : 'btn-outline-dark' }}">
        {{ ucfirst($category) }}
      </button>
    @endforeach
  </form>


      <select name="department" class="form-select" style="min-width: 100px;">
        <option value="">All Departments</option>
        @foreach ($departments as $department)
          <option 
            value="{{ $department->department }}" 
            {{ request('department') == $department->department ? 'selected' : '' }}>
            {{ $department->department }}
          </option>
        @endforeach
      </select>

      @if (request('category'))
        <input type="hidden" name="category" value="{{ request('category') }}">
      @endif

    <!-- Search & Filter Form -->
    <form action="{{ route('pages.ebook') }}" method="GET" class="d-flex gap-1 flex-wrap align-items-center">
      <input 
        type="text" 
        name="search" 
        class="form-control flex-grow-1" 
        placeholder="Search book..." 
        value="{{ request('search') }}"
        style="min-width: 100px;"
      >


      <button type="submit" class="btn btn-custom-red">Search</button>
      <a href="{{ url('/pages/ebook') }}" class="btn btn-custom-green">Reset</a>
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
            <a href="{{ asset('storage/' . $book->pdf_filepath) }}"
              class="btn btn-sm btn-custom-red"
              target="_blank">
              Read
            </a>

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

 
  @include('pages.userfooter')


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
