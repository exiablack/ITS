$(window).scroll(function() {
    if ($(this).scrollTop() > 1){  
        $('header').addClass("sticky");
		$('nav').addClass("sticky");
    }
    else{
        $('header').removeClass("sticky");
		$('nav').removeClass('sticky');
    }
	
});

$(document).ready(function(){

	setInterval(function(){
	$('.carousel ul').animate({marginLeft:'-960px'},2000,function(){
		$(this).find("li:last").after($(this).find("li:first"));
		$(this).css({marginLeft:0});
	});

},5000);

});