$(function() {
    $(".submit").click(function(event) {
        event.preventDefault();
        $.ajax({
            type : "POST",
            url  : "/testimonial/add",
            data : {
                'name' : $('#name').val(),
                'testimonial' : $('#testimonial').val()
            },
            success : function(data) {
                alert(data);
            }
        });
    });
});