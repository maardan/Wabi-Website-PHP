(function ($) {
  $(document).ready(function(){
        if($(window).width()> 768){
            $('.navbar-inverse .navbar-nav>li>a').css({"color":'black'});
            $('.navbar-inverse').css({"background-color":'transparent', "border-color":'transparent'});
            $('#search-hide').css({"visibility":'hidden'});
            $('.navbar-brand').css({"visibility":'hidden'});
            $('.dropdown-toggle').css({"background-color":'transparent'});
        }

	$(function () {
		$(window).scroll(function () {
                    if ($(this).scrollTop() > 150) {
                        $('.navbar-inverse').css({"background-color":'#222'});
                        $('#search-hide').css({"visibility":'visible'});
                        $('.navbar-inverse .navbar-nav>li>a').css({"color":'#9d9d9d'});
                        $('.navbar-brand').css({"visibility":'visible'});
                    } else {
                        if($(window).width()> 768){
                            $('.navbar-inverse .navbar-nav>li>a').css({"color":'black'});
                            $('.navbar-inverse').css({"background-color":'transparent', "border-color":'transparent'});
                            $('#search-hide').css({"visibility":'hidden'});
                            $('.navbar-brand').css({"visibility":'hidden'});
                            $('.dropdown-toggle').css({"background-color":'transparent'});                            
                        }
                    } 
		});                
                
                $(window).resize(function (){
                    if($(window).width()< 768){
                        $('.navbar-inverse').css({"background-color":'#222'});
                        $('.navbar-inverse .navbar-nav>li>a').css({"color":'#9d9d9d'});
                        $('.navbar-brand').css({"visibility":'visible'});
                        $('#search-hide').css({"visibility":'visible'});
                    }
                });

	
	});

});
 }(jQuery));
