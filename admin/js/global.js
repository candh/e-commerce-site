$(document).ready(function() {
    // 
    // LOGIN FORM AJAX 
    //
    $('form.login').submit(function(event) {
        event.preventDefault();
        var method = $(this).attr('method'),
            url = $(this).attr('action'),
            warning = $('#warning');

        if (validateLogin()) {
            var username = $('#username').val();
            var password = $('#password').val();
            var token = $('#token').val();
            var data = {
                username: username,
                password: password,
                token: token
            }

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('#warning').html(response).fadeIn('fast');
                    if (response == "Successfully Logged In") {
                        window.location.assign("../admin/index.php");
                    }
                },
            });
        };
        return false;
    });

    // 
    // Processed
    //
    var alert = $('#alert').hide();
    $('form.process').submit(function(event) {
        /* Act on the event */
        event.preventDefault();

        var perm = confirm('This customer will be deleted? Are you sure?');
        if (perm) {
            var method = $(this).attr('method'),
                url = $(this).attr('action');

            var order_id = $('#order_id').val();
            var customer_id = $('#customer_id').val();

            var data = {
                order_id: order_id,
                customer_id: customer_id
            }

            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('.alertcontent h5').html(response);
                    alert.fadeIn('fast', function() {
                        setTimeout(function() {
                            alert.fadeOut('fast');
                        }, 3000);
                    });
                }
            });
        }
        return false;
    });

    // modal window
    // modal window
    // modal window


    $('#remove_item_wrapper').hide();

    $('#remove').click(function(event) {
        /* Act on the event */
        var id = $('#product_id').val();
        if (id == "") {
            $('.error').html('Please enter a Product Id');
            return false;
        }
    });

    $('.closer_modal').click(function(event) {


        $('#remove_item_wrapper').slideUp('fast');

    });

    $('form.removeItem').submit(function(event) {
        /* Act on the event */
        event.preventDefault();

        $('#remove_item_wrapper').slideDown('fast');
        var id = $('#product_id').val();
        var action = $('#remove').val();

        console.log(action);
        if (id == "") {
            $('.error').html('Please enter a Product Id');
            return false;
        } else {
            var url = $(this).attr('action'),
                method = $(this).attr('method');

            var data = {
                product_id: id,
                remove: action
            }


            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('.confirm_remove').html(response);
                },
            }).done(function() {
                $('form.confirmRemoveItem').submit(function(event) {
                    /* Act on the event */
                    event.preventDefault();

                    var confirm_delete = $('#confirm_delete').val();
                    var id = $('#product_id').val();

                    var data = {
                        confirm_delete: confirm_delete,
                        product_id: id
                    }
                    $.ajax({
                        url: 'processing/remove.php',
                        type: 'post',
                        data: data,
                        success: function(response) {
                            $('.confirm_remove').html(response);
                        }
                    });
                    return false;
                });

            });

        }

    });

});

// adding items validation
$(document).ready(function() {
    $('form#upload').submit(function(event) {
        /* Act on the event */
        return validateAddItems();
    });
});

// adding the items 
$(document).ready(function() {

    $('#shoeSize').hide();
    $('#clothingSize').hide();


    $('#cat').change(function(event) {

        $('#shoeSize').hide();
        $('#clothingSize').hide();

        var itemCat = $('#cat').val();

        if (itemCat == "Shoes") {

            $('#shoeSize').show();
        } else if (itemCat == "Clothing") {

            $('#clothingSize').show();
        }
    });

});
$(document).ready(function() {
    $('form#updateItem').submit(function(event) {
        /* Act on the event */
        return validateUpdate();
    });
});

//
// UPDATING INVENTORY VIA AJAX
// 
$(document).ready(function() {
    $('.updateInventory').submit(function(event) {
        /* Act on the event */
        event.preventDefault();

        // the primary variables
        var productId = $(this).attr('id');
        var stock = $('#stock_' + productId).val();

        var data = {
            product_id: productId,
            stock: stock
        }

        $.ajax({
            url: '/store/admin/processing/inventory_submit.php',
            type: 'POST',
            data: data,
            success: function(response) {
                $('#status_' + productId).html("<div style='color:red';>" + response + "</div>");
            }
        });

    });
});
