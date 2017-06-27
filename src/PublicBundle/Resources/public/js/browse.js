$(document).ready(function(){
    $("#search_results").css({'display':'none'});

    // Disabling inputs other than focused
    $('.search-criterium').on('focus', function(){
        $(this).removeClass('disabled');
        $('.search-criterium').not(this).addClass('disabled')
    });
    // AJAX call for browse images

    $('#browse_form').on('submit', function(e){
        e.preventDefault();

        // Making sure only relevant field is sent via AJAX
        $('.disabled').prop('disabled', true);

        var Data = new FormData(this),
            url = '/browse_process';
        $.ajax({
            type    : 'POST',
            url     : url,
            processData: false,
            contentType: false,
            data    : new FormData(this),
            success : function(response){
                console.log(response);

                showResults(response)
            }
        });
    });
    function showResults(response){
        // Clearing the form for next search
        $('.disabled').prop('disabled', false).removeClass('disabled');

        var $search_results = $("#search_results"),
            $template = "<img src=\"\"/>";

        // Clear previous results
        $search_results.empty();

        var i;
        console.log((response.length>0 && typeof response !== "string"))
        // check that the response is defined and that it contains images
        if(response.length>0 && typeof response !== "string"){
            for(i=0;i<response.length;i++){
                $search_results.append("<li class='img_miniature_box'><a href='/pick/"+response[i]['id']+"'>View</a><img class='img_miniature' src='"+response[i]['path']+"'/><p><em>"+response[i]['user']+"</em></p></li>");
            }
        }
        else
        {
            $search_results.append('<h2><em>No Results</em></h2>');
        }
    
        $search_results.fadeIn('slow');
    }
});