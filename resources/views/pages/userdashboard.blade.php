<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OctaRead Dashboard</title>
  <script src="{{ url('js/tailwind-loader.js') }}"></script>
  <script src="{{ url('js/alpine.min.js') }}"></script>
  <link rel="stylesheet" href="{{ url('css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ url('css/bootstrap-icons.css') }}">
  <script src="{{ url('js/bootstrap.bundle.min.js') }}"></script>

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
  border: 1px solid #ccc;
  color: #6c757d; /* gray color */
  border-radius: 50%;
  padding: 0.3rem 0.6rem;
  transition: transform 0.2s ease;
}

.favorite-btn.favorited {
  background: #dc3545;
  color: #fff;
  border-color: #dc3545;
}

.favorite-btn:hover {
  transform: scale(1.2);
}



.carousel-item img {
            width: auto;
            height: 100%;
        }

        .carousel-container {
    height: 70vh;
}

@media (max-width: 768px) {
    .carousel-container {
        height: 40vh; /* or any percentage/px value that fits */
    }
}


</style>


<body class="bg-light d-flex flex-column min-vh-100">

    <!-- Header -->
    @include('pages.usersheader')

<div class="container-fluid p-0 carousel-container">

  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000" style="height: 100%;">
      <div class="carousel-inner" style="height: 100%;">
          @foreach($carouselItems as $item)
              <div class="carousel-item {{ $loop->first ? 'active' : '' }}" style="height: 100%;">
                  <img src="{{ asset('storage/' . $item->carousel_imgpath) }}"
                       class="d-block w-100"
                       alt="Slide">
              </div>
          @endforeach
      </div>

      <!-- Controls -->
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

  <div x-data="{ open: false, selected: {} }" class="max-w-7xl mx-auto mt-16 px-6">

    <h3 class="mb-12 text-center text-4xl font-extrabold text-gray-900">Research & Marketing Team</h3>
  
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
      @foreach($members as $position => $group)
        <div class="bg-white rounded-2xl shadow-xl border border-gray-300 p-8">
          <h4 class="text-2xl font-bold text-gray-800 mb-6 text-center uppercase tracking-wide">{{ $position }}</h4>
          <ul class="space-y-4">
            @foreach($group as $member)
              <li>
                <button 
                  class="text-blue-700 hover:underline font-semibold text-lg text-left w-full"
                  @click="selected = {
                    name: '{{ $member->fullname }}',
                    position: '{{ $member->position }}',
                    image: '{{ asset('storage/' . $member->profile_imgpath) }}'
                  }; open = true"
                >
                  {{ $member->fullname }}
                </button>
              </li>
            @endforeach
          </ul>
        </div>
      @endforeach
    </div>
  
    <!-- Modal -->
    <div 
      x-show="open" 
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
      x-transition
    >
      <div 
        x-show="open"
        @click.away="open = false"
        class="bg-white rounded-2xl shadow-2xl p-8 w-full max-w-md text-center"
        x-transition
      >
        <img :src="selected.image" alt="" class="h-48 w-48 object-cover rounded-full mx-auto mb-6 border-4 border-gray-300">
        <h3 class="text-2xl font-bold text-gray-900 mb-2" x-text="selected.name"></h3>
        <p class="text-gray-700 text-lg mb-6" x-text="selected.position"></p>
        <button 
          @click="open = false" 
          class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-base font-semibold"
        >
          Close
        </button>
      </div>
    </div>
  </div>
  
  


  <section class="py-16 px-4 text-center container mx-auto mt-10">
    <h2 class="text-4xl font-extrabold mb-6 text-gray-900">PROGRAMS AND SERVICES</h2>
    <h1 class="text-2xl font-medium mb-12 text-gray-600 max-w-3xl mx-auto">
      The Research Center shall implement the following programs and attributes
    </h1>
  
    <div class="flex flex-wrap justify-center gap-6">
      
      <!-- Service Card Template -->
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">📚</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Research Support Resources</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Provides resources, workshops, and consultations for all research stages (proposal writing, methodology, data analysis, publication).
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">🤝</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Mentorship Connections</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Connects experienced faculty researchers with students for guidance and project development.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">💰</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Student Research Funding</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Offers funding and support for outstanding student-led research projects.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">🌐</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Interdisciplinary Research</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Facilitates the creation of interdisciplinary research groups to tackle complex problems.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">🎤</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Guest Researcher Lectures</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Invites renowned researchers to present their work and foster collaboration with on-campus researchers.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">🖼️</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Research Showcases</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Provides a platform for faculty and students to showcase their research to the wider community.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">📝</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Grant Application Support</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Offers dedicated staff support to help researchers navigate the grant application process.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">🧪</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Research Technology Access</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Provides access to cutting-edge equipment and technologies for various research disciplines.
          </p>
        </div>
      </div>
  
      <div class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4 px-2">
        <div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 h-full px-8 py-8">
          <div class="text-5xl mb-6 select-none">📊</div>
          <h3 class="text-xl font-semibold mb-3 text-gray-900">Data Training & Ethics</h3>
          <p class="text-sm text-gray-700 leading-relaxed">
            Offers training and support for researchers in data collection, storage, analysis, and ethical use.
          </p>
        </div>
      </div>
  
    </div>
  </section>

<!-- Book Grid -->
<div class="max-w-7xl mx-auto mt-10 px-4">
  <h2 class="mb-8 text-center text-3xl font-extrabold text-gray-900">Recently Added</h2>

  <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

    @forelse ($ebooks as $book)
     @php
    $extension = strtolower(pathinfo($book->pdf_filepath, PATHINFO_EXTENSION));

    if ($extension === 'pdf') {
        $image = 'images/default_pdf_picture.jpg';
    } elseif (in_array($extension, ['doc', 'docx'])) {
        $image = 'images/default_docx_img.png';
    } else {
        $image = 'storage/pdf_uploads/' . $book->pdf_filepath; // adjust this path to your actual image storage
    }
@endphp

<div class="bg-white rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-200 flex flex-col h-full">
    <img 
        src="{{ asset($image) }}" 
        alt="Book Cover" 
        class="rounded-t-xl object-cover w-full h-40 sm:h-48 md:h-56"
/>

        <div class="p-6 flex flex-col flex-grow">
          <!-- Short title for small screens -->
<h5 class="text-base sm:hidden font-semibold text-gray-900 mb-2 break-words whitespace-normal">
  {{ \Illuminate\Support\Str::limit($book->title, 50, '...') }}
</h5>

<!-- Full title for medium and up -->
<h5 class="hidden sm:block text-base sm:text-lg font-semibold text-gray-900 mb-2 break-words whitespace-normal">
  {{ $book->title }}
</h5>

          <p class="text-xs sm:text-sm text-gray-600 mb-1 flex items-center gap-2 break-words whitespace-normal">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 16 16"><path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3z"/><path fill-rule="evenodd" d="M8 8a3 3 0 100-6 3 3 0 000 6z"/></svg>
            {{ $book->author }}
          </p>
          <p class="text-xs sm:text-sm text-gray-500 mb-4 break-words whitespace-normal">
            <small>{{ $book->department }} | {{ $book->category }}</small>
          </p>
          
          @if(isset($book->description))
          <p class="text-gray-700 text-sm mb-4 break-words whitespace-normal max-h-24 overflow-auto">
            {{ $book->description }}
          </p>
          @endif

          <div class="mt-auto flex justify-between items-center">
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

        @php
            $isFavorited = isset($favoritedIds) && in_array($book->id, $favoritedIds);
        @endphp
        <button 
            type="submit" 
            class="favorite-btn {{ $isFavorited ? 'favorited' : '' }}" 
            title="{{ $isFavorited ? 'Remove from Favorites' : 'Add to Favorites' }}"
        >
            <i class="bi bi-heart-fill"></i>
        </button>
    </form>
@endif



          </div>
        </div>
      </div>
    @empty
      <div class="col-span-full">
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded text-center" role="alert">
          No books found.
        </div>
      </div>
    @endforelse
  </div>
</div>

   @include('pages.userfooter')


   
   

</body>
</html>
