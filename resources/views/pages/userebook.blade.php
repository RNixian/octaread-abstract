<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>OctaRead EBook</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    height: 80px;
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
    <div id="rocmodel-buttons" style="display: flex; flex-wrap: wrap; gap: 10px;">
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
            justify-content: flex-end;
            padding: 1px;
            position: relative;
          "
        >
          <div style="
            background-image: url('https://cdn-icons-png.flaticon.com/512/716/716784.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            width: 100%;
            height: 100%;
          "></div>
          <span style="font-size: 12px; text-align: center; margin-top: 5px; color:black;">
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
        <img 
          src="{{ asset($ebook->cover_photo ? 'images/' . $ebook->cover_photo : 'images/default_pdf_picture.jpg') }}" 
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

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let currentCategory = '';
    let currentSubcategory = '';
    
    function backToRocModels() {
        currentCategory = '';
        currentSubcategory = '';
    
        // Show RocModel buttons (force flex display)
        document.getElementById('rocmodel-buttons').style.display = 'flex';
        document.getElementById('subcategory-buttons').style.display = 'none';
        document.getElementById('ebooks-container').style.display = 'none';
    
        // ✅ Proper string with backticks
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
                subcatContainer.style.display = 'flex';
                subcatContainer.style.flexWrap = 'wrap';
                subcatContainer.style.gap = '10px';
                subcatContainer.style.justifyContent = 'start';
    
                data.forEach(subcat => {
                    const folderDiv = document.createElement('div');
                    folderDiv.className = 'subcategory-folder';
                    folderDiv.style.textAlign = 'center';
    
                    const folderBtn = document.createElement('button');
                    folderBtn.className = 'responsive-folder-btn';
                    folderBtn.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/716/716784.png')";
                    folderBtn.style.backgroundSize = 'contain';
                    folderBtn.style.backgroundRepeat = 'no-repeat';
                    folderBtn.style.backgroundPosition = 'center';
                    folderBtn.style.backgroundColor = 'transparent';
                    folderBtn.style.border = 'none';
                    folderBtn.style.cursor = 'pointer';
                    folderBtn.onclick = () => showEbooks(subcat);
    
                    const label = document.createElement('span');
                    label.className = 'responsive-folder-label';
                    label.style.display = 'block';
                    label.style.marginTop = '8px';
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
    

<div>@include('pages.userfooter')</div>

</body>
</html>
