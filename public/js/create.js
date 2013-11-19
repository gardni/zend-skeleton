$(document).ready(function() {
    $('#create').on('submit', function() {
        $.ajax({
            url     : 'testimonial/add',
            type    : 'POST',
            dataType: 'json',
            data    : $(this).serialize(),
            success : function( data ) {
                         location.href = "testimonial"
            },
            error   : function( xhr, err ) {
                         alert('Error');
            }
        });
        return false;
    });
});