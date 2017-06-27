$(document).ready(function(){
    $('.delete_image').on('click', function(){
        var data = $(this).attr('data-image-id'),
            url = $(this).attr('data-url');
        $.ajax({
            type    : 'POST',
            url     : url,
            data    : data,
            success : function(response){
                $('.delete_image[data-image-id='+data+']').parent('li').fadeOut();
            }
        });

    });

});