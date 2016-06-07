// Inspiration for this was taken from:
// http://ninetofive.me/blog/build-a-live-search-with-ajax-php-and-mysql

// On Search Submit and Get Results
// On Search Submit and Get Results
function search() {
    var query_value = $('#image-search').val();
    if(query_value !== ''){
        $.ajax({
            type: "POST",
            url: "search.php",
            data: { query: query_value },
            cache: false,
            success: function(html){
                $("#search-results").html(html);
            }
        });
    }return false;
}

$("#image-search").keyup(function() {
	// Set Timeout
    clearTimeout($.data(this, 'timer'));

     // Set Search String
    var search_string = $(this).val();

    if (search_string == '') {
        $("#results-header").fadeOut();
        $("#search-results>*").remove();
    } else{
        $("#results-header").fadeIn();
        $(this).data('timer', setTimeout(search, 100));
    }
});

$('document').ready(function() {
    var viewport_height = $(window).height();
    var body_height = $('.wabi-page-container').height() + $('footer').height();

    if (body_height < viewport_height) {
        $('.wabi-page-container').css("padding-bottom", viewport_height-body_height - 40);
    }
});

