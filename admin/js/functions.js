function validateLogin() {
    var username = $('#username').val();
    var password = $('#password').val();
    var warning = $('#warning')
    warning.hide();
    if (username == '' || password == '') {
        warning.html('Both Fields should be filled').fadeIn('fast');
        setTimeout(function() {
            warning.fadeOut('fast');
        }, 2000);
        return false;
    } else {
        return true;
    }
}

function validateAddItems() {
    var name = $('#name').val();
    var price = $('#price').val();
    var stock = $('#stock').val();
    var token = true;
    if (name == "" || price == "" || stock == "") {
        $('.errorAdd').html("Please fill all the required fields and please attach an image");
        token = false;
    }
    if (isNaN(price)) {
        $('.errorAdd').html("Price should be numeric (without the currency sign)");
        token = false;
    }
    if (isNaN(stock) || stock == 0) {
        $('.errorAdd').html("Please enter the numeric value of the stock");
        token = false;
    }
    if (token) {
        return true;
    } else {
        return false;
    }
}

function validateUpdate() {
    var name = $('#name').val();
    var price = $('#price').val();
    var stock = $('#stock').val();

    var token = true;
    if (name == "" || price == "" || stock == "") {
        $('.errorAdd').html("Please fill all the required fields and please attach an image");
        token = false;
    }
    if (isNaN(price)) {
        $('.errorAdd').html("Price should be numeric (without the currency sign)");
        token = false;
    }
    if (isNaN(stock) || stock == 0) {
        $('.errorAdd').html("Please enter the numeric value of the stock");
        token = false;
    }

    if (token) {
        return true;
    } else {
        return false;
    }
}
