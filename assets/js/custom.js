$(document).ready(function(){


//mobile menu

	$('.trigger_menu').click(function(){
		$('header nav').slideToggle();
	});


//more text visible

	$('#info_more').click(function() {
		// $('.info_text').css('height', 'auto');
		$('.info_text').toggleClass('active');
		return false;
	});


//form elements style

$(function() {
    $('.select, input[type="checkbox"]').styler({
      selectSearch: true
    });

  });  



//members slider

 $('.slider_members').slick({
    slidesToShow: 4,
  	slidesToScroll: 1,
  	arrows: false,
  	dots: true,
  	responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: 3
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2
      }
    },
    {
      breakpoint: 579,
      settings: {
        slidesToShow: 1
      }
    }
    ]
  });



//photo_album slider

$('.slider-for').slick({
  slidesToShow: 1,
  slidesToScroll: 1,
  arrows: false,
  fade: true,
  asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
  slidesToShow: 3,
  slidesToScroll: 1,
  asNavFor: '.slider-for',
  dots: false,
  focusOnSelect: true,
  nextArrow: '<div class="next"><span class="glyphicon glyphicon-chevron-right"></span></div>',
  prevArrow: '<div class="prev"><span class="glyphicon glyphicon-chevron-left"></span></div>',
  responsive: [
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2
      }
   	},
   	{
      breakpoint: 690,
      settings: {
        slidesToShow: 1
      }
   	}
   ]
});



//photo_album photo

$('.slider-for a').magnificPopup({
	type: 'image',
	closeOnContentClick: true,
	mainClass: 'mfp-img-mobile',
	image: {
		verticalFit: true
	},
	gallery: {
			enabled: true,
			navigateByImgClick: true,
			preload: [0,1] // Will preload 0 - before current, and 1 after the current image
		},
});





});