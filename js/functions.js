function validate() {
    var pos = $('#qty').position();

    var y = pos.top;
    var x = pos.left;



    var origVal = $('#qty').val();
    var action = $('#submit').val();

    if (action == "Add to Cart" && origVal == "0") {
        $('#warning').html('Are you kidding me ?');
        $('#warning').css({
            top: y - 5 + "px",
            left: x + 90 + "px"
        }).fadeIn('fast', function() {
            setTimeout(function() {
                $('#warning').fadeOut('fast');
            }, 2000);
        });

        return false;
    }

    if (isNaN(origVal)) {
        $('#warning').html('Please enter a Numeric value');

        $('#warning').css({
            top: y - 5 + "px",
            left: x + 90 + "px"
        }).fadeIn('fast', function() {
            setTimeout(function() {
                $('#warning').fadeOut('fast');
            }, 2000);
        });
        return false;
    } else if (origVal == "" || origVal < "0") {
        $('#warning').html('Please enter a valid Value');
        $('#warning').css({
            top: y - 5 + "px",
            left: x + 90 + "px"
        }).fadeIn('fast', function() {
            setTimeout(function() {
                $('#warning').fadeOut('fast');
            }, 2000);
        });
        return false;
    } else {
        return true;
    }

}

function validateCart(qty, product_id) {

    var pos = $('#qty').position();
    var y = pos.top;
    var x = pos.left;

    // checking the values
    if (qty <= "0" || qty == "" || isNaN(qty)) {

        $('#warning').html('Please put a valid integer');
        $('#warning').css({
            top: y - 5 + "px",
            left: x + 100 + "px"
        }).fadeIn('fast', function() {
            setTimeout(function() {
                $('#warning').fadeOut('fast');
            }, 2000);
        });
        return false;
    } else {
        return true;
    }
}

function calculateAjax() {
    var calculate = $('#sum');
    $.ajax({
        url: '/processing/calculator.php',
        type: 'POST',
        data: {
            param1: 'value1'
        },
        success: function(response) {
            calculate.html('$' + response);
        }
    });
}



function validateSearch() {

var pos = $('#search_query').position();

    var y = pos.top;
    var x = pos.left;




    var val = $('#search_query').val();
    if (val == "" || val == " " || val == "null" || val == "undefined") {
                $('#warning').html("Please enter a search query");
                    $('#warning').css({
                        top: y - 5 + "px",
                        left: x + 225 + "px"
                    }).fadeIn('fast', function() {
                        setTimeout(function() {
                            $('#warning').fadeOut('fast');
                        }, 2000);
                    });
    return false;
    }
    else {
        return true;
    }
}