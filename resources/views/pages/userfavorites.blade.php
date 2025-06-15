<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>My Favorites - OctaRead</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <style>
    .book-card img {
      height: 150px;
      object-fit: cover;
    }

    .card-body h5 {
      font-size: 1rem;
    }

    .card-body p {
      font-size: 0.85rem;
      margin-bottom: 0.3rem;
    }

    .book-card {
      max-width: 250px;
      margin: 0 auto;
    }

    .favorite-btn {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #dc3545;
      transition: transform 0.3s ease;
    }

    .favorite-btn:hover {
      transform: scale(1.2);
    }

    .no-favorites {
      text-align: center;
      margin-top: 50px;
      color: #999;
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

    @media (max-width: 576px) {
      .card-body h5 {
        font-size: 0.9rem;
      }

      .card-body p {
        font-size: 0.75rem;
      }

      .book-card img {
        height: 120px;
      }
    }
  </style>
</head>
<body class="bg-light d-flex flex-column min-vh-100">

  <!-- Header -->
  @include('pages.usersheader')

  <div class="container py-5">
    <h1 class="mb-4">My Favorite eBooks</h1>

    @if ($ebooks->isEmpty())
      <div class="no-favorites">
        <i class="bi bi-emoji-frown fs-1"></i>
        <p class="mt-3">You haven't added any favorite eBooks yet.</p>
      </div>
    @else
      <div class="row justify-content-center">
        @foreach ($ebooks as $ebook)
          <div class="col-6 col-md-3 mb-4">
            <div class="card book-card h-100">
              @if ($ebook->cover_image)
                <img src="{{ asset('images/ebooks/' . $ebook->cover_image) }}" class="card-img-top" alt="Book Cover">
              @else
                <img src="{{ asset('images/default_pdf_picture.jpg') }}" class="card-img-top" alt="Default Cover">
              @endif

              <div class="card-body d-flex flex-column">
                <h5 class="card-title">
                  <i class="bi bi-clipboard-fill"></i> {{ Str::limit($ebook->title, 50) }}
                </h5>
                
                <p class="card-text text-muted"><i class="bi bi-person-fill"></i> {{ $ebook->author }}</p>
                <p class="card-text text-muted">
                  <i class="bi bi-tags-fill"></i> {{ $ebook->category }}<br>
                  <i class="bi bi-building-fill"></i> {{ $ebook->department }}
                </p>
                <p class="card-text">{{ Str::limit($ebook->description, 80) }}</p>

                <div class="mt-auto d-flex justify-content-between align-items-center">
                  <a href="{{ asset('storage/' . $ebook->pdf_filepath) }}"
                    class="btn btn-sm btn-custom-red"
                    target="_blank">
                    Read
                  </a>
                  <form action="{{ route('toggle.favorite', $ebook->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="favorite-btn" title="Unfavorite">
                      <i class="bi bi-heart-fill"></i>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>

  @include('pages.userfooter')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
