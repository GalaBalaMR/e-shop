$(document).ready(function () {
    // if is some session hide it after 3 seconds
    $("#flash-message").delay(3000).hide(3000);

    // if is some session status hide it after 3 seconds
    $("#status").delay(3000).hide(3000);

    // if is some session status hide it after 3 seconds
    $("#errors").delay(3000).hide(3000);

    var add_item_form = $(".add-item-form");
    card_pcs = $(".card_pcs");
    loader = $("#loader");
    $alert = $('<div class="alert"></div>');
    $alert_p = $('<p class="text-dark"></p>');

    $alert_p.appendTo($alert);

    // add item to card with AJAX
    // change items number in nav too
    add_item_form.each(function () {
        $(this).on("submit", function (e) {
            e.preventDefault();

            var this_form = $(this);

            $.ajax({
                url: $(this).attr("action"),
                method: "POST",
                data: $(this).serialize(),
                beforeSend: function () {
                    loader.removeClass("d-none");
                },
                complete: function () {
                    loader.addClass("d-none");
                },
                success: function (data) {
                    $alert_p.text(data.flash);
                    $alert
                        .insertBefore(this_form.parent())
                        .hide()
                        .slideDown(500);
                    if (data.status == "1") {
                        $alert.addClass("alert-success");
                        card_pcs.text(data.items_number);
                    } else {
                        $alert.addClass("alert-danger");
                        $alert_p.text("Niečo sa pokazilo.");
                    }
                    $alert.show();
                    $alert.delay(3000).hide(2000);
                    this_form.trigger("reset");
                    // show small card after add item
                    $.ajax({
                        url: '/card/show-small-card',
                        data: {
                            txtsearch: $('#small-card-background').val()
                        },
                        type: "GET",
                        dataType: "html",
                        success: function (data) {
                            var result = $('<div />').append(data);
                            $('#ajax-card-div').html(result);
                        }
                    });
                },
            });
        });
    });

    // delete item from card with ajax and hide them
    var card_item_delete = $(".card_item_delete");
    card_full_price = $(".card-full-price");

    card_item_delete.each(function () {
        $(this).on("submit", function (e) {
            e.preventDefault();

            var this_form = $(this);

            $.ajax({
                url: $(this).attr("action"),
                method: "POST",
                data: $(this).serialize(),
                beforeSend: function () {
                    loader.removeClass("d-none");
                },
                complete: function () {
                    loader.addClass("d-none");
                },
                success: function (data) {
                    var card_item = $("#card-item-" + data.id);

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
                    $alert.delay(3000).hide(2000, function () {
                        card_item.hide(500, function () {
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

    card_item_update.each(function () {
        $(this).on("submit", function (e) {
            e.preventDefault();

            var this_form = $(this);

            $.ajax({
                url: $(this).attr("action"),
                method: "POST",
                data: $(this).serialize(),
                beforeSend: function () {
                    loader.removeClass("d-none");
                },
                complete: function () {
                    loader.addClass("d-none");
                },
                success: function (data) {
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

    // for review label
    // if radio is checked, all prev label has color like checked

    var reviewLabel = $(".review-label");
    reviewInput = $(".input-review");

    reviewInput.each(function () {
        $(this).on("click", function () {
            if ($(this).is(":checked")) {
                $(this).prevAll("label").css("color", "#ffc451");
                $(this).nextAll("label").css("color", "#212529");
                $(this).next().css("color", "#ffc451");
            }
        });
    });

    // show and hide review form on click
    var reviewShowLink = $(".review-show-link");
    reviewForm = $(".review-form");

    reviewForm.children().hide();

    reviewShowLink.each(function () {
        $(this).on("click", function (event) {
            event.preventDefault();
            if (
                $("#review-form-" + $(this).data("id"))
                    .children()
                    .is(":visible")
            ) {
                $("#review-form-" + $(this).data("id"))
                    .children()
                    .hide(500);
            } else {
                $("#review-form-" + $(this).data("id"))
                    .children()
                    .show(500);
            }
        });
    });

    // Ajax for small card

    var linkSmallCard = $('#show-small-card');

    linkSmallCard.on('click', function(event){
        event.preventDefault();

        if($('#small-card-background').length){
            $('#small-card-background').remove();
        }else{
            $.ajax({
                url: $(this).attr("href"),
                data: {
                    txtsearch: $('#small-card-background').val()
                },
                type: "GET",
                dataType: "html",
                success: function (data) {
                    var result = $('<div />').append(data);
                    $('#ajax-card-div').html(result);
                }
            });
        }
    })


});
