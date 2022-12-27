 @extends('layouts.guest')
 @section('main')
     <!-- ======= Breadcrumbs ======= -->
     <section id="breadcrumbs" class="breadcrumbs">
         <div class="container">

             <div class="d-flex justify-content-between align-items-center">
                 <h2>Portfolio Details</h2>
                 <ol>
                     <li><a href="index.html">Home</a></li>
                     <li>Portfolio Details</li>
                 </ol>
             </div>

         </div>
     </section><!-- End Breadcrumbs -->

     <!-- ======= Portfolio Details Section ======= -->
     <section id="portfolio-details" class="portfolio-details">
         <div class="container">

             <div class="row gy-4">

                 <div class="col-lg-8">
                     <div class="portfolio-details-slider swiper">
                         <div class="swiper-wrapper align-items-center">

                             @foreach (explode('|', $item->img) as $img)
                                 <div class="swiper-slide">
                                     <img src="{{ Storage::url($img) }}" alt="">
                                 </div>
                             @endforeach

                         </div>
                         <div class="swiper-pagination"></div>
                     </div>
                 </div>

                 <div class="col-lg-4">
                     <div class="portfolio-info">
                         <h3>Informácie o výrobku</h3>
                         <ul>
                             @if (isset($item->category))
                                 <li><strong>Kategória</strong>: {{ $item->category->name }}</li>
                             @elseif(isset($item->subCategory))
                                 <li><strong>Podkategória</strong>: {{ $item->subCategory->name }}</li>
                             @endif
                             <li><strong>Na sklade:</strong> {{ $item->storage_pcs }}</li>
                             <li><strong>Pridaný: </strong>: {{ Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                             </li>
                             <li><strong>Cena:</strong>: {{ $item->price }}</li>
                             <li>
                                 <div class=" text-warning">
                                     @if ($item->reviews()->exists())
                                         @for ($i = 1; $i <= $item->stars; $i++)
                                             <i class="bi bi-star-fill"></i>
                                         @endfor
                                         @for ($i = $item->stars; $i < 5; $i++)
                                             <i class="bi bi-star-fill text-dark"></i>
                                         @endfor
                                     @else
                                         <i class="bi bi-star-fill text-dark"></i>
                                         <i class="bi bi-star-fill text-dark"></i>
                                         <i class="bi bi-star-fill text-dark"></i>
                                         <i class="bi bi-star-fill text-dark"></i>
                                         <i class="bi bi-star-fill text-dark"></i>
                                     @endif
                                 </div>
                             </li>
                             <li>
                                 <form action="{{ route('card.store') }}" method="post"
                                     class="add-item-form">
                                     @csrf
                                     <input type="number" name="item_pcs" class="me-3" id="" min="1"
                                         max="{{ $item->storage_pcs }}">
                                     <input type="hidden" name="item_id" value="{{ $item->id }}">
                                     <input type="hidden" name="storage_pcs" value="{{ $item->storage_pcs }}">
                                     <button type="submit" class="btn btn-warning rounded-pill">Pridať do košíku</button>
                                 </form>
                             </li>
                             {{-- <li>{{ $items_number }}</li> --}}
                         </ul>
                     </div>
                     <div class="portfolio-description">
                         <h2>{{ $item->name }}</h2>
                         <p>
                             {{ $item->short_description }}
                         </p>
                         <p>
                             {{ $item->long_description }}
                         </p>
                         @if ($item->evaluated == true)
                             <p class="text-warning">Hodnotil si</p>
                         @else
                             <a href="" class="review-show-link link link-warning" data-id='{{ $item->id }}'>
                                 <p>Ohodnotiť?</p>
                             </a>
                         @endif
                         @if ($item->evaluated == false)
                             @auth
                                 <form action="{{ route('reviews.store') }}" method="post"
                                     id="review-form-{{ $item->id }}" class="review-form col-12 mt-3 d-flex flex-column">
                                     @csrf
                                     <textarea name="content" class="col-10 m-auto"></textarea>
                                     <div class="m-auto m-3">
                                         <input type="radio" name="stars" class="input-review"
                                             id="input-review-{{ $item->id }}" value="1">
                                         <label for="input-review-{{ $item->id }}" class="review-label">
                                             <i class="bi bi-star-fill"></i>
                                         </label>

                                         <input type="radio" name="stars" class="input-review"
                                             id="2-input-review-{{ $item->id }}" value="2">
                                         <label for="2-input-review-{{ $item->id }}" class="review-label m-auto">
                                             <i class="bi bi-star-fill"></i>
                                         </label>
                                         <input type="radio" name="stars" class="input-review"
                                             id="3-input-review-{{ $item->id }}" value="3">
                                         <label for="3-input-review-{{ $item->id }}" class="review-label m-auto">
                                             <i class="bi bi-star-fill"></i>
                                         </label>
                                         <input type="radio" name="stars" class="input-review"
                                             id="4-input-review-{{ $item->id }}" value="4">
                                         <label for="4-input-review-{{ $item->id }}" class="review-label m-auto">
                                             <i class="bi bi-star-fill"></i>
                                         </label>
                                         <input type="radio" name="stars" class="input-review"
                                             id="5-input-review-{{ $item->id }}" value="5">
                                         <label for="5-input-review-{{ $item->id }}" class="review-label m-auto">
                                             <i class="bi bi-star-fill"></i>
                                         </label>
                                     </div>
                                     <input type="hidden" name="item_id" value="{{ $item->id }}">
                                     <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                                     <button class="btn btn-warning col-6 m-auto" type="submit">Ohodnotiť</button>
                                 </form>
                             @endauth
                             @guest
                                 <div class="review-form" id="review-form-{{ $item->id }}">
                                     <a class="text-decoration-none link-danger" href="{{ route('login') }}">
                                         Pre pridanie recenzie musíš byť prihlásený
                                     </a>

                                 </div>

                             @endguest
                         @endif
                         <div class="d-flex flex-column">
                             <h2>Recenzie</h2>
                             @forelse ($item->reviews as $review)
                                 <div>
                                     <p class="d-inline">{{ $review->content }}</p>
                                     <q class="text-muted ms-1">{{ $review->user->name }}</q>
                                     @for ($i = 1; $i <= $review->stars; $i++)
                                         <i class="bi bi-star-fill text-warning"></i>
                                     @endfor
                                     <hr>
                                 </div>
                             @empty
                                 <p>Nie sú pridané žiadne recenzie</p>
                             @endforelse
                         </div>
                     </div>
                 </div>

             </div>

         </div>
     </section><!-- End Portfolio Details Section -->

 @endsection
