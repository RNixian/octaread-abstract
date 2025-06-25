<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OctaRead EBook</title>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-icons.css') }}">
<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
  <style>
   /* === Ebook Card Styling === */
.book-card {
  height: 100%;
  box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* Responsive Image */
.responsive-cover-img {
  height: 200px;
  object-fit: cover;
}

@media (max-width: 768px) {
  .responsive-cover-img {
    height: 150px;
  }
}

@media (max-width: 576px) {
  .responsive-cover-img {
    height: 100px;
  }
}

/* Book Title Styling */
.responsive-book-title {
  font-size: 1rem;
  white-space: normal;
  overflow: visible;
  text-overflow: unset;
  word-wrap: break-word;
}

@media (max-width: 768px) {
  .responsive-book-title {
    font-size: 0.95rem;
  }
}

@media (max-width: 576px) {
  .responsive-book-title {
    font-size: 0.85rem;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }
}

/* === Buttons === */
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

/* Favorite Button */
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

/* === Folder Button Styles === */
#rocmodel-buttons button,
.responsive-folder-btn {
  width: 300px;
  height: 300px;
}

.responsive-folder-label {
  font-size: 14px;
}

.subcategory-folder {
  width: 300px;
}

@media (max-width: 768px) {
  #rocmodel-buttons button,
  .responsive-folder-btn {
    width: 150px !important;
    height: 150px !important;
  }

  .responsive-folder-label,
  #rocmodel-buttons span {
    font-size: 11px !important;
  }

  .subcategory-folder {
    width: 150px;
  }
}

@media (max-width: 480px) {
  #rocmodel-buttons button,
  .responsive-folder-btn {
    width: 120px !important;
    height: 120px !important;
  }

  .responsive-folder-label,
  #rocmodel-buttons span {
    font-size: 10px !important;
  }

  .subcategory-folder {
    width: 120px;
  }
}

  </style>
  </head>
  <body class="bg-light d-flex flex-column min-vh-100">
  
    <!-- Header -->
    @include('pages.usersheader')
  
    <div class="container py-5">
      <h1 class="mb-4">Research Abstract</h1>
  
    
    <!-- 📍 Breadcrumb -->
    <div id="breadcrumb-path" class="mb-3 fw-bold text-secondary">
      <span class="breadcrumb-item active" onclick="backToRocModels()" style="cursor:pointer">Category</span>
    </div>

   <!-- 📁 ROC Model Buttons -->
<div id="rocmodel-buttons" style="
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 20px;
  width: 100%;
">
  @foreach($rocmodels as $roc)
    <button 
      onclick="loadUnderCategories('{{ $roc->out_cat }}', this)"
      class="btn btn-primary"
      style="
        background-color: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 10px;
        width: 100%;
      "
    >
      <div style="
        background-image: url('https://cdn-icons-png.flaticon.com/512/716/716784.png');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        width: 150px;
        height: 150px;
        margin-bottom: 8px;
      "></div>
      <span style="
        font-size: 14px;
        text-align: center;
        color: black;
        line-height: 1.2;
        word-wrap: break-word;
      ">
        {{ $roc->out_cat }}
      </span>
    </button>
  @endforeach
</div>




    <!-- 🔘 UnderRocModel Buttons (Initially Hidden) -->
    <div id="subcategory-buttons" class="mb-4" style="display:none;"></div>
   
  <!-- 📚 Ebook Cards (Initially Hidden) -->
<div id="ebooks-container" class="row mt-4" style="display:none;">
  @forelse ($ebooks as $ebook)
  <div 
  class="col-lg-3 col-md-4 col-sm-6 col-6 mb-4 responsive-book-card"
  data-category="{{ $ebook->category }}"
  data-department="{{ $ebook->department }}"
>

      <div class="card h-100 shadow-sm d-flex flex-column">
        
        @php
    $extension = strtolower(pathinfo($ebook->pdf_filepath, PATHINFO_EXTENSION));

    if ($extension === 'pdf') {
        $defaultImage = 'images/default_pdf_picture.jpg';
    } elseif (in_array($extension, ['doc', 'docx'])) {
        $defaultImage = 'images/default_docx_img.png';
    } else {
        $defaultImage = 'storage/pdf_uploads/' . $ebook->pdf_filepath;
    }

    $image = $ebook->cover_photo ? 'images/' . $ebook->cover_photo : $defaultImage;
@endphp

<img 
    src="{{ asset($image) }}" 
    class="card-img-top responsive-cover-img" 
    alt="Book Cover"
/>

        <div class="card-body d-flex flex-column">
          <h5 class="card-title responsive-book-title">
            {{ $ebook->title }}
          </h5>
          <p class="card-text text-muted mb-2">
            <i class="bi bi-person-fill"></i> {{ $ebook->author }}
          </p>
          <div class="mt-auto d-flex justify-content-between align-items-center">
            <!-- Read Button -->
            <form action="{{ route('read.store') }}" method="POST" target="_blank">
              @csrf
              <input type="hidden" name="ebook_id" value="{{ $ebook->id }}">
              <input type="hidden" name="pdf_filepath" value="{{ $ebook->pdf_filepath }}">
              <button type="submit" class="btn btn-sm btn-custom-red">Read</button>
            </form>

         {{-- Only show "Add to Favorites" for logged-in non-guest users --}}
            @if(session()->has('userid') && session('is_guest') === false)
    @php
        $isFavorited = $favoriteIds->contains($ebook->id);
    @endphp
    <form action="{{ route('favorites.store') }}" method="POST" class="d-inline">
        @csrf
        <input type="hidden" name="ebook_id" value="{{ $ebook->id }}">
        <button type="submit"
                class="btn btn-sm favorite-btn {{ $isFavorited ? 'favorited' : '' }}"
                title="{{ $isFavorited ? 'Remove from Favorites' : 'Add to Favorites' }}">
            <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
        </button>
    </form>
@endif

          </div>
        </div>
      </div>
    </div>
  @empty
    <p class="text-muted">No ebooks available.</p>
  @endforelse
</div>


    </div>

 
  <script>
    let currentCategory = '';
    let currentSubcategory = '';
    
    function backToRocModels() {
    currentCategory = '';
    currentSubcategory = '';

    const rocButtons = document.getElementById('rocmodel-buttons');
    rocButtons.style.display = 'grid';
    rocButtons.style.gridTemplateColumns = 'repeat(auto-fit, minmax(150px, 1fr))';
    rocButtons.style.gap = '20px';
    rocButtons.style.width = '100%';

    document.getElementById('subcategory-buttons').style.display = 'none';
    document.getElementById('ebooks-container').style.display = 'none';

    document.getElementById('breadcrumb-path').innerHTML = 
        `<span class="breadcrumb-item active" onclick="backToRocModels()" style="cursor:pointer">Category</span>`;
}

    
    function loadUnderCategories(outCat) {
    currentCategory = outCat;
    currentSubcategory = '';

    // Hide RocModel buttons
    document.getElementById('rocmodel-buttons').style.display = 'none';

    // ✅ Properly escaped string with template literals
    document.getElementById('breadcrumb-path').innerHTML = 
        `<span class="breadcrumb-item text-primary" onclick="backToRocModels()" style="cursor:pointer">Category</span> 
        > 
        <span class="breadcrumb-item active">${outCat}</span>`;

    fetch(`/get-deptres/${outCat}`)
        .then(res => res.json())
        .then(data => {
            const subcatContainer = document.getElementById('subcategory-buttons');
            subcatContainer.innerHTML = '';

            // 🧱 Apply grid layout
            subcatContainer.style.display = 'grid';
            subcatContainer.style.gridTemplateColumns = 'repeat(auto-fit, minmax(150px, 1fr))';
            subcatContainer.style.gap = '20px';
            subcatContainer.style.width = '100%';

            data.forEach(subcat => {
                const folderDiv = document.createElement('div');
                folderDiv.style.textAlign = 'center';
                folderDiv.style.display = 'flex';
                folderDiv.style.flexDirection = 'column';
                folderDiv.style.alignItems = 'center';
                folderDiv.style.justifyContent = 'flex-start';
                folderDiv.style.padding = '10px';

                const folderBtn = document.createElement('button');
                folderBtn.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/716/716784.png')";
                folderBtn.style.backgroundSize = 'contain';
                folderBtn.style.backgroundRepeat = 'no-repeat';
                folderBtn.style.backgroundPosition = 'center';
                folderBtn.style.backgroundColor = 'transparent';
                folderBtn.style.border = 'none';
                folderBtn.style.cursor = 'pointer';
                folderBtn.style.width = '150px';
                folderBtn.style.height = '150px';
                folderBtn.onclick = () => showEbooks(subcat);

                const label = document.createElement('span');
                label.style.fontSize = '14px';
                label.style.color = 'black';
                label.style.textAlign = 'center';
                label.style.marginTop = '8px';
                label.style.lineHeight = '1.2';
                label.textContent = subcat;

                folderDiv.appendChild(folderBtn);
                folderDiv.appendChild(label);
                subcatContainer.appendChild(folderDiv);
            });
        });

    // Hide ebooks initially
    document.getElementById('ebooks-container').style.display = 'none';
}

    
    function showEbooks(underCat) {
        currentSubcategory = underCat;
    
        // Hide subcategory buttons
        document.getElementById('subcategory-buttons').style.display = 'none';
    
        // ✅ Fixed breadcrumb with proper template literals
        document.getElementById('breadcrumb-path').innerHTML = 
            `<span class="breadcrumb-item text-primary" onclick="backToRocModels()" style="cursor:pointer">Category</span> 
            > 
            <span class="breadcrumb-item text-primary" onclick="loadUnderCategories('${currentCategory}')" style="cursor:pointer">${currentCategory}</span> 
            > 
            <span class="breadcrumb-item active">${underCat}</span>`;
    
        const cards = document.querySelectorAll('#ebooks-container > div');
        let anyVisible = false;
    
        cards.forEach(card => {
            const cat = card.getAttribute('data-category');
            const dept = card.getAttribute('data-department');
    
            if (cat === currentCategory && dept === underCat) {
                card.style.display = 'block';
                anyVisible = true;
            } else {
                card.style.display = 'none';
            }
        });
    
        document.getElementById('ebooks-container').style.display = anyVisible ? 'flex' : 'none';
    }
    </script>
    
<divc lass="w-full bg-gray-800 text-white p-4 mt-10">
  
    @include('pages.userfooter')
<div>




</body>
</html>
