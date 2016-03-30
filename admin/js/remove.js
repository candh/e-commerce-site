$(document).ready(function() {
    $('.remove').click(function(event) {
        /* Act on the event */

        var id = $(this).data('id');
        var type = $(this).data('type');

        if (type == "primary") {
            if (confirm('Do you really want to remove this image?')) {
                $.ajax({
                        url: '/store/admin/processing/removeSecImg.php',
                        type: 'post',
                        data: {
                            img_id: id,
                            type: type
                        },
                        success: function(response) {
                            $('.response').html(response);
                        }
                    })
                    .done(function() {
                        $('tr#primaryImg_' + id).remove();
                    });
            }

        } else {
            if (confirm('Do you really want to remove this image?')) {
                $.ajax({
                        url: '/store/admin/processing/removeSecImg.php',
                        type: 'post',
                        data: {
                            img_id: id,
                            type: type
                        },
                        success: function(response) {
                            $('.response').html(response);
                        }
                    })
                    .done(function() {
                        $('tr#' + id).remove();
                    });
            }
        }
    });
});
