// 
//  mobile navigations
// 
$(document).ready(function() {

    $('#mobile-nav-trigger').click(function() {
        $('.main-mobile-nav-wrapper').slideDown('fast');
    });
    $('#mobile-nav-close').click(function() {
        $('.main-mobile-nav-wrapper').slideUp('fast');
    });

    $('#ajaxcart').click(function() {
        $('#cart-desc').slideToggle(200);
    });

    $('#categories').click(function() {
        $('#mob-na').slideToggle('fast');
    });
});
// 
// end mobile navigation
//

// 
// AJAX CART
//
$(document).ready(function() {

    // the cart colors
    // the item-qty color changer







    // 
    // TO DO : ADDING A LOADING GIF SO DUMB PEOPLE KNOW THAT THE ACTION
    // IS HAPPENING

    // HEY, AM I DOING THIS CORRECTly ? WHO KNOWS? ATLEAST THIS WORKS. LOL

    // God, you know how much I love you? right? I love all the people, 
    // please make this script work. Thanks. 
    // 

    $('#ajaxcart').load('/store/elements/ajaxcart.php');
    $('form.cartsubmitAjax').on('submit', function(e) {
        e.preventDefault();
        /* Act on the event */
        //

        // getting the data
        //

        if (validate()) {
            var qty = $('#qty').val(),
                size = $('#size').val(),
                product_id = $('#product_id').val(),
                submit = $('#submit').val();

            var that = $(this),
                url = that.attr('action'),
                method = that.attr('method');

            var cart = {
                size: size,
                qty: qty,
                product_id: product_id,
                submit: submit
            }

            // initialize the warning box position
            var pos = $('#qty').position();
            var y = pos.top;
            var x = pos.left;

            $.ajax({
                url: url,
                type: method,
                data: cart,
                success: function(response) {

                    $('#warning').html(response);
                    $('#warning').css({
                        top: y + 10 + "px",
                        left: x + 90 + "px"
                    }).fadeIn('fast', function() {
                        setTimeout(function() {
                            $('#warning').fadeOut('fast');
                        }, 2000);
                    });

                    if (submit == "Add to Cart") {
                        var cart = $('#cart');
                        var imgtodrag = $('.productView-left').find('.imgFocus');
                        if (imgtodrag) {
                            var imgclone = imgtodrag.clone()
                                .offset({
                                    top: imgtodrag.offset().top,
                                    left: imgtodrag.offset().left
                                })
                                .css({
                                    'opacity': '0.5',
                                    'position': 'absolute',
                                    'height': '150px',
                                    'width': '150px',
                                    'z-index': '100'
                                })
                                .appendTo($('body'))
                                .animate({
                                    'top': cart.offset().top + 10,
                                    'left': cart.offset().left + 10,
                                    'width': 75,
                                    'height': 75
                                }, 1000, 'easeInOutExpo');

                            setTimeout(function() {
                                cart.effect("shake", {
                                    times: 2
                                }, 200);
                            }, 1500);

                            imgclone.animate({
                                'width': 0,
                                'height': 0
                            }, function() {
                                $(this).detach()
                            });
                        }
                    }

                },
                error: function() {
                    alert('Something went wrong');
                }
            }).done(function() {


                $('#ajaxcart').load('/store/elements/ajaxcart.php');
            });
        }

        // prevent further submitting
        $('.addSubmit').click(function(event) {
            /* Act on the event */


            event.preventDefault();

            $('#warning').html('Item already in cart');
            $('#warning').css({
                top: y + 10 + "px",
                left: x + 90 + "px"
            }).fadeIn('fast', function() {
                setTimeout(function() {
                    $('#warning').fadeOut('fast');
                }, 2000);
            });


        });

        return false;
    });



    // 
    // view_Cart AJAX
    // 


    // updating the quantity of the product
    $('form.update_qty_ajax').on('change', function(e) {
        e.preventDefault();
        // start working

        var form = $(this);
        var form_id = form.attr('id'),
            url = form.attr('action'),
            method = form.attr('method');

        var qty = $('#' + form_id).children().eq(0).val();
        var product_id = $('#' + form_id).children().eq(1).val();

        // initialize the warning box position
        var formpos = form.position();
        var y = formpos.top;
        var x = formpos.left;

        data = {
            qty: qty,
            product_id: product_id,
            action: 'updateQty'
        };

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                calculateAjax();
                $('#warning').html(response);
                $('#warning').css({
                    top: y + 12 + "px",
                    left: x + 110 + "px"
                }).fadeIn('fast', function() {
                    setTimeout(function() {
                        $('#warning').fadeOut('fast');
                    }, 2000);
                });
            }
        }).done(function() {
            $('#ajaxcart').load('/store/elements/ajaxcart.php');
            calculateAjax();
        });


        return false;
    });


    // updating the item size with AJAX POST
    $('form.update_size_ajax').on('change', function(e) {
        e.preventDefault();
        // start working

        var form = $(this);
        var form_id = form.attr('id'),
            url = form.attr('action'),
            method = form.attr('method');

        var size = $('#' + form_id).children().eq(0).val();
        var product_id = $('#' + form_id).children().eq(1).val();


        // initialize the warning box position
        var formpos = form.position();
        var y = formpos.top;
        var x = formpos.left;

        data = {
            size: size,
            product_id: product_id,
            action: 'updateSize'
        };

        $.ajax({
            url: url,
            type: method,
            data: data,
            success: function(response) {
                calculateAjax();
                $('#warning').html(response);
                $('#warning').css({
                    top: y + 12 + "px",
                    left: x + 110 + "px"
                }).fadeIn('fast', function() {
                    setTimeout(function() {
                        $('#warning').fadeOut('fast');
                    }, 2000);
                });
            }
        }).done(function() {
            $('#ajaxcart').load('/store/elements/ajaxcart.php');
            calculateAjax();
        });


        return false;
    });

    $('.remove').click(function() {
        var id = $(this).data('action');
        var method = "POST",
            url = "/store/processing/view_cart.php",
            action = "remove";

        data = {
            product_id: id,
            action: action
        };
        var perm = confirm("Do you really wanna remove this item?");
        if (perm) {
            $.ajax({
                url: url,
                type: method,
                data: data,
                success: function(response) {
                    $('tr#' + id).remove();
                    calculateAjax();

                },
            }).done(function() {
                $('#ajaxcart').load('/store/elements/ajaxcart.php');
                calculateAjax();
            });


        }

    });

    // 
    // CALCULATOR AJAX
    // 

    calculateAjax();
});


//checkout validation
// 
$(document).ready(function() {

    $(function() {
        $('form.checkout_form_validate').submit(function(event) {
            return validateField();
        });
    });

    function validateField() {
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var shipping_address = $('#shipping_address_1').val();
        var city = $('#city').val();
        var state = $('#state').val();
        var phone = $('#phone').val();

        if (first_name == "" || last_name == "" || shipping_address == "" || city == "" || state == "" || phone == "") {
            $('#errorcontainer').html('Fill out all the required fields <br/>');
            $('#errorcontainer').fadeIn('fast');
            return false;
        } else if (isNaN(phone)) {
            $('#errorcontainer').html('Phone Number must be a number');
            $('#errorcontainer').fadeIn('fast');
            return false;
        } else {
            return true;
        }
    }

});

$(document).ready(function() {
    $('form.searchForm').submit(function(event) {
        /* Act on the event */
        return validateSearch();
    });
});


// this is the product image section : 
// where we display mutiple images of a product

$(document).ready(function() {
    $('#mini_img_gallery_wrapper img').click(function(event) {
        /* Act on the event */

        if (!$(this).hasClass('activeImg')) {
            $('.activeImg').removeClass('activeImg');

            var mini = $(this).attr('src');
            $('.imgFocus').fadeOut('fast', function() {
                $(this).attr('src', mini).fadeIn('fast');
            });
            $(this).addClass('activeImg');
        }



    });
});
