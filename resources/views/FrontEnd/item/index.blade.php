@extends('layouts.guest')
@section('main')
    <!-- ======= Portfolio Section ======= -->
    <section id="portfolio" class="portfolio">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Portfolio</h2>
                <p>Check our Portfolio</p>
            </div>

            <div class="row" data-aos="fade-up" data-aos-delay="100">
                <div class="col-lg-12 d-flex justify-content-center">
                    <ul id="portfolio-flters">
                        <li data-filter="*" class="filter-active">All</li>

                        @forelse($mix as $mix)
                            {{-- If category has a subcategory, make dropdown --}}
                            @if ($mix->subCategories->count())
                                <div class="dropup d-inline">
                                    <button class="btn  dropdown-toggle dropup" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        {{ $mix->name }}
                                    </button>
                                    <ul class="dropdown-menu ">
                                        {{-- Make li in dropdown for all item in category --}}
                                        <li data-filter=".filter-cat-{{ $mix->id }}">Nezaradené</li>

                                        {{-- If has subcategory, make dropdown li --}}
                                        @foreach ($mix->subCategories as $sub)
                                            <li data-filter=".filter-sub-{{ $sub->id }}">{{ $sub->name }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <li data-filter=".filter-cat-{{ $mix->id }}">{{ $mix->name }}</li>
                            @endif
                        @empty
                            <p>nič</p>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

                @forelse($items as $item)
                    @if ($item->category_id == null)
                        <div class="col-lg-4 col-md-6 portfolio-item filter-sub-{{ $item->sub_category_id }}" id="portfolio-item-{{ $item->id }}">
                        @else
                            <div class="col-lg-4 col-md-6 portfolio-item filter-cat-{{ $item->category_id }}" id="portfolio-item-{{ $item->id }}">
                    @endif

                    <div class="portfolio-wrap mb-0">
                        @foreach (explode('|', $item->img) as $img)
                            @if ($loop->first)
                                <img src="{{ Storage::url($img) }}" class="img-fluid" alt="">
                            @endif
                        @endforeach
                        <div class="portfolio-info">

                            <a href="{{ route('item.show', ['id' => $item->id]) }}"
                                class="text-warning text-decoration-none">
                                <h4 class="mb-0">{{ $item->name }}</h4>
                            </a>
                            <p>
                                {{ $item->short_description }}
                            </p>
                            <div class="d-flex justify-content-between w-100 mb-2">
                                <blockquote class="text-warning mb-0">
                                    Na sklade: {{ $item->storage_pcs }} ks
                                </blockquote>
                                <blockquote class="text-warning mb-0 me-3">
                                    {{ $item->price }} €
                                </blockquote>
                            </div>
                            <div class="portfolio-links d-flex justify-content-around w-100">

                                {{-- foreach pictures and show just first --}}
                                @foreach (explode('|', $item->img) as $img)
                                    @if ($loop->first)
                                        <a href="{{ Storage::url($img) }}" data-gallery="portfolioGallery"
                                            class="portfolio-lightbox" title="{{ $item->name }}"><i
                                                class="bx bx-plus"></i></a>
                                    @endif
                                @endforeach

                                <a href="{{ route('item.show', ['id' => $item->id]) }}" title="More Details"><i
                                        class="bx bx-link"></i></a>

                                <form action="{{ route('card.store') }}" method="post"
                                    class="add-item-form d-flex justify-content-center pb-1">
                                    @csrf
                                    <input type="number" name="item_pcs" class="me-3" id="" min="1"
                                        max="{{ $item->storage_pcs }}" value="1">
                                    <input type="hidden" name="item_id" value="{{ $item->id }}">
                                    <input type="hidden" name="storage_pcs" value="{{ $item->storage_pcs }}">
                                    <button type="submit" class="btn btn-warning rounded-pill">Kúpiť</button>
                                </form>
                                <div>
                                    @if ($item->evaluated == true)
                                        <p>Hodnotil si</p>
                                    @else
                                        <a href="" class="review-show-link text-decoration-none"
                                            data-id='{{ $item->id }}'>
                                            <p class="link-warning">Ohodnotiť?</p>
                                        </a>
                                    @endif

                                    {{-- how many stars with for loop.
                                         first loop for render reviews star and 
                                         second loop for render other stars 
                                    --}}
                                    <div class=" text-warning">
                                        @if ($item->reviews()->exists())
                                            @for ($i = 1; $i <= $item->stars; $i++)
                                                <i class="bi bi-star-fill"></i>
                                            @endfor
                                            @for ($i = $item->stars; $i < 5; $i++)
                                                <i class="bi bi-star-fill text-light"></i>
                                            @endfor
                                        @else
                                            <i class="bi bi-star-fill text-light"></i>
                                            <i class="bi bi-star-fill text-light"></i>
                                            <i class="bi bi-star-fill text-light"></i>
                                            <i class="bi bi-star-fill text-light"></i>
                                            <i class="bi bi-star-fill text-light"></i>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($item->evaluated == false)
                                @auth
                                    <form action="{{ route('reviews.store') }}" method="post"
                                        id="review-form-{{ $item->id }}"
                                        class="review-form col-12 mt-3 d-flex flex-column">
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
                                        <a class="text-decoration-none" href="{{ route('login') }}"
                                            style="color: #ffffffb3;">Pre pridanie recenzie musíš byť prihlásený</a>

                                    </div>
                                @endguest
                            @endif
                        </div>
                    </div>
            </div>
        @empty
            <p>Eshop je prázdny.</p>
            @endforelse



        </div>

        </div>
    </section><!-- End Portfolio Section -->

@endsection
