<h1 class="text-center">{{ $slot }}</h1>
<div class="row row-cols-1 row-cols-md-2 g-4 mb-4">

    @foreach($items as $item)
        <div class="col">
            <div class="card h-100">
                <img src="..." class="card-img-top" alt="...">
                <div class="card-body">
                    <h1 class="card-title"><a href="{{ route('item.show', $item->id) }}" class="link link-success text-decoration-none">{{ $item->name }}</a></h1>
                    <p class="card-text">
                        {{ $item->short_description }}
                    </p>
                    <form action="{{ route('card.store') }}" method="post">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item->id }}">
                        <input type="number" name="item_pcs">
                        <button type="submit">Pridať do košíka!</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
    
