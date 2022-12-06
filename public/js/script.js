$( document ).ready(function() {

    // if is some session hide it after 3 seconds
    $('#flash-message').delay(3000).hide(3000);

    // if is some session status hide it after 3 seconds
    $('#status').delay(3000).hide(3000);


    var add_item_form = $('.add-item-form');
        card_pcs = $('.card_pcs');
        loader = $('#loader');
        $alert = $('<div class="alert"></div>');
        $alert_p = $('<p class="text-dark"></p>');

    $alert_p.appendTo($alert);

    // add item to card with AJAX
    // change items number in nav too
    add_item_form.each(function(){
        $(this).on('submit', function(e){
            e.preventDefault();

            var this_form = $(this);

            $.ajax({
                url:  $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function(){
                  loader.removeClass('d-none');
                },
                complete: function(){
                  loader.addClass('d-none');
                  
                },
                success: function(data){
          
                  $alert_p.text(data.flash);
                  $alert.insertBefore(this_form.parent()).hide().slideDown(500);
                  if(data.status == '1'){
                    $alert.addClass('alert-success');
                    card_pcs.text(data.items_number);
                  }else{
                    $alert.addClass('alert-danger');
                    $alert_p.text('Niečo sa pokazilo.');
                  }
                  $alert.show();
                  $alert.delay(3000).hide(2000);
                  this_form.trigger("reset");
          
                }
            });
        })
    })


    var card_item_delete = $('.card_item_delete');
        card_full_price = $('.card-full-price');

    card_item_delete.each(function(){
        $(this).on('submit', function(e){
            e.preventDefault();

            var this_form = $(this);

            $.ajax({
                url:  $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function(){
                  loader.removeClass('d-none');
                },
                complete: function(){
                  loader.addClass('d-none');
                  
                },
                success: function(data){
                    var card_item = $('#card-item-'+ data.id);

                    $alert_p.text(data.flash);
                    $alert.insertBefore(this_form.parent()).hide().slideDown(500);
                    if(data.status == '1'){
                        $alert.addClass('alert-danger');
                        console.log(data.full_price);
                        card_pcs.text(data.items_number);
                        card_full_price.text(data.full_price);

                    }else{
                        $alert.addClass('alert-danger');
                        $alert_p.text('Niečo sa pokazilo.');
                    }
                    $alert.show();
                    $alert.delay(3000).hide(2000, function(){card_item.hide(500, function(){card_item.remove();});});
                    
                    this_form.trigger("reset");
          
                }
            });
        })
    })

    var card_item_update = $('.card_item_update');

    card_item_update.each(function(){
        $(this).on('submit', function(e){
            e.preventDefault();

            var this_form = $(this);

            $.ajax({
                url:  $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                beforeSend: function(){
                  loader.removeClass('d-none');
                },
                complete: function(){
                  loader.addClass('d-none');
                  
                },
                success: function(data){
                    var item_input = $('#card-pcs-'+ data.id);
                        card_item_price = $('.card-item-price-'+ data.id);

                    $alert_p.text(data.flash);
                    $alert.insertBefore(this_form.parent()).hide().slideDown(500);
                    if(data.status == '1'){
                        $alert.addClass('alert-danger');
                        card_pcs.text(data.items_number);
                        card_full_price.text(data.full_price);
                        card_item_price.text(data.item_price);
                        item_input.attr('value', data.item_pcs);
                        console.log(item_input);

                    }else{
                        $alert.addClass('alert-danger');
                        $alert_p.text('Niečo sa pokazilo.');
                    }
                    $alert.show();
                    $alert.delay(3000).hide(2000);
                    
                    this_form.trigger("reset");
          
                }
            });
        })
    })

});