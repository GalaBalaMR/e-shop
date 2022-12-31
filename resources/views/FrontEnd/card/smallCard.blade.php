<div class="small-card-background" id="small-card-background">
    <div class="border border-secondary rounded bg-light p-2" id="small-card">
        <div class="d-flex justify-content-around align-content-center flex-wrap">
            <h1 class="m-0 p-0 text-center">Nákupný košík</h1>
            <p class="m-0 p-0 text-center d-flex align-content-center flex-wrap">
                @if (isset($items_number) && $items_number != 0)
                    Počet položiek: <span class="card_pcs">{{ $items_number }}</span>.
                @else
                    Nepridal si žiadnu položku.
                @endif
            </p>
        </div>
        <hr class="">
        <div id="small-card-items">
            @forelse ($items_data as $item)
                <div class="small-card-item d-flex justify-content-around mt-2"
                    id="small-card-item-{{ $item['item']['id'] }}">
                    @forelse(explode('|',$item['item']['img']) as $img)
                        @if ($loop->first)
                            <img src="{{ Storage::url($img) }}" alt="Image">
                        @endif
                    @empty
                        <p>Bez obrázku</p>
                    @endforelse
                    <div class="col-3 col-md-2 col-lg-2 col-xl-2">
                        <h6 class="text-muted">item</h6>
                        <h6 class="text-black mb-0">{{ $item['item']['name'] }}</h6>
                    </div>
                    <form class="card_item_update col-2 col-md-2 col-xl-2 d-flex align-items-start flex-column"
                        action="{{ route('card.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="item_id" value="{{ $item['item']['id'] }}">
                        <div class="d-flex mb-1">
                            <button class="btn btn-link px-0"
                                onclick="this.parentNode.querySelector('input[type=number]').stepDown(); return false">
                                <i class="bi bi-dash"></i>
                            </button>

                            <input id="card-pcs-{{ $item['item']['id'] }}" min="0" name="item_pcs"
                                value="{{ $item['pcs'] }}" type="number"
                                class="form-control form-control-sm no-arrow" />

                            <button class="btn btn-link px-0"
                                onclick="this.parentNode.querySelector('input[type=number]').stepUp(); return false">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                        <button type="submit" class="d-block mx-auto btn btn-warning rounded-pill p-1 py-0 text-light">
                            Zmeniť
                        </button>
                    </form>
                    <div class="col-3 col-md-2 col-lg-2 col-xl-2 p-0">
                        <h6 class="mb-0">Kus za € {{ $item['item']['price'] }}</h6>
                    </div>
                    <div class="col-3 col-md-2 col-lg-2 col-xl-2 p-0">
                        <h6 class="mb-0">Dokopy: € <span
                                class="card-item-price-{{ $item['item']['id'] }}">{{ $item['fullPrice'] }}</span>
                        </h6>
                    </div>
                    <div class="col-1 col-md-1 col-lg-1 col-xl-1">
                        <form action="{{ route('card.remove') }}" method="post" class="card_item_delete">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item['item']['id'] }}">
                            <button type="submit" class=" btn link-danger decoration-none"><i
                                    class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
                <hr>

            @empty
                <div>
                    <p>Nepridal si nič do košíku</p>
                </div>
            @endforelse
            <a class="" href="/" id="close-card-link">Zatvoriť</a>
            <a class="" href="{{ route('card.show') }}" id="close-card-link">Prejsť do pokladne</a>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // delete item from card with ajax and hide them
        var card_item_delete = $(".card_item_delete");
        card_full_price = $(".card-full-price");

        card_item_delete.each(function() {
            $(this).on("submit", function(e) {
                e.preventDefault();

                var this_form = $(this);

                $.ajax({
                    url: $(this).attr("action"),
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        loader.removeClass("d-none");
                    },
                    complete: function() {
                        loader.addClass("d-none");
                    },
                    success: function(data) {
                        var card_item = $("#small-card-item-" + data.id);

                        $alert_p.text(data.flash);
                        $alert
                            .insertBefore(this_form.parent())
                            .hide()
                            .slideDown(500);
                        if (data.status == "1") {
                            $alert.addClass("alert-danger");
                            console.log(data.full_price);
                            card_pcs.text(data.items_number);
                            card_full_price.text(data.full_price);
                        } else {
                            $alert.addClass("alert-danger");
                            $alert_p.text("Niečo sa pokazilo.");
                        }
                        $alert.show();
                        $alert.delay(3000).hide(2000, function() {
                            card_item.hide(500, function() {
                                card_item.remove();
                            });
                        });

                        this_form.trigger("reset");
                    },
                });
            });
        });


        // update for card
        var card_item_update = $(".card_item_update");

        card_item_update.each(function() {
            $(this).on("submit", function(e) {
                e.preventDefault();

                var this_form = $(this);

                $.ajax({
                    url: $(this).attr("action"),
                    method: "POST",
                    data: $(this).serialize(),
                    beforeSend: function() {
                        loader.removeClass("d-none");
                    },
                    complete: function() {
                        loader.addClass("d-none");
                    },
                    success: function(data) {
                        var item_input = $("#card-pcs-" + data.id);
                        card_item_price = $(".card-item-price-" + data.id);

                        $alert_p.text(data.flash);
                        $alert
                            .insertBefore(this_form.parent())
                            .hide()
                            .slideDown(500);
                        if (data.status == "1") {
                            $alert.addClass("alert-danger");
                            card_pcs.text(data.items_number);
                            card_full_price.text(data.full_price);
                            card_item_price.text(data.item_price);
                            item_input.attr("value", data.item_pcs);
                            console.log(item_input);
                        } else {
                            $alert.addClass("alert-danger");
                            $alert_p.text("Niečo sa pokazilo.");
                        }
                        $alert.show();
                        $alert.delay(3000).hide(2000);

                        this_form.trigger("reset");
                    },
                });
            });
        });

        // Hide small card

        $('#close-card-link').on('click', function(event){
            event.preventDefault();
            $('#small-card-background').remove();
        });
    });

</script>
