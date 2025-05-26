<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

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


<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header -->
    @include('pages.usersheader')


    <div class="container p-0" style="max-width: 100%; height: 70vh;">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="height: 100%;">
          <div class="carousel-inner" style="height: 100%;">
              @foreach($carouselItems as $item)
                  <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 100%;">
                      <img src="{{ asset('storage/' . $item->carousel_imgpath) }}" 
                           class="d-block w-100" 
                           style="height: 100%; object-fit: cover;" 
                           alt="Slide">
                  </div>
              @endforeach
          </div>
  
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
          </button>
      </div>
  </div>

  <div class="container mt-5">
    <h3 class="mb-4 text-center">Library Team</h3>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4">
        @foreach($members as $member)
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="{{ asset('storage/' . $member->profile_imgpath) }}" 
                         class="card-img-top" 
                         alt="Profile Image" 
                         style="object-fit: cover; height: 250px;">
                    <div class="card-body text-center">
                        <h5 class="card-title mb-1">{{ $member->fullname }}</h5>
                        <p class="card-text text-muted">{{ $member->position }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

 
<div class="container mt-5 card h-100 shadow-sm border-0">
    <h3 class="mb-4 text-center">Services</h3>
<ul>
<li>tulog</li>
<li>kain</li>
<li>laro</li>
<li>mang-bash</li>
</ul>
</div>

<!-- Book Grid -->
<div class="container mt-5 card h-100 shadow-sm border-0">
    <h3 class="mb-4 text-center">Recently Added</h3>
<div class="row mt-3">
    @forelse ($ebooks as $book)
      <div class="col-md-3 mb-4">
        <div class="card book-card h-100 shadow-sm">
          <img src="{{ asset('images/default_pdf_picture.jpg/' . $book->cover_photo) }}" class="card-img-top" alt="Book Cover">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ $book->title }}</h5>
            <p class="card-text text-muted mb-1"><i class="bi bi-person-fill"></i> {{ $book->author }}</p>
            <p class="card-text"><small>{{ $book->department }} | {{ $book->category }}</small></p>
            <div class="mt-auto d-flex justify-content-between align-items-center">
                 <a href="{{ asset('storage/' . $book->pdf_filepath) }}"
                  class="btn btn-sm btn-custom-red"
                  target="_blank">
                 Read
               </a>

                 <form action="{{ route('favorites.store') }}" method="POST">

                  @php
                  $isFavorited = auth()->user() && auth()->user()->favorites->contains($book->id);
                @endphp
                
                  @csrf
                  <input type="hidden" name="ebook_id" value="{{ $book->id }}">
                  <button type="submit" class="favorite-btn {{ $isFavorited ? 'favorited' : '' }}" title="Add to Favorites">
                    <i class="bi bi-heart-fill"></i>
                  </button>
                </form>
                
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
</div>


   @include('pages.userfooter')

  

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
