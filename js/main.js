$(function() {
function ScrolClass() {
  if($(this).scrollTop() != 0) {
          $('.topPanel').addClass('topPanel-top');
        } else {
          $('.topPanel').removeClass('topPanel-top');
        }
  }
  $(window).scroll(function() {
    ScrolClass();
  });
  $(document).ready(function() {
    ScrolClass();
  });
});

$(".menuButton").click(function(){
  $('.'+$(this).attr('data-class')).toggleClass("active");
  $(this).toggleClass("active");
});


$('.tab-button').click(function(){
	$('.tab-button').removeClass('active');
	$(this).addClass('active');
	$('.tab-block').removeClass('active');
	$('#'+$(this).attr('data-tab')).addClass('active');
})

$('.buttonTop').click(function(){
  $('body, html').animate({scrollTop:0},800);
});

$(document).ready(function() { 
    var overlay = $('#overlay'); 
    var open_modal = $('.open_modal'); 
    var close = $('.modal_close, #overlay'); 
    var modal = $('.modal_div'); 
     open_modal.click( function(event){ 
         event.preventDefault(); 
         var div = $(this).attr('href'); 
         overlay.fadeIn(400, 
             function(){ 
                 $(div) 
                     .css('display', 'flex') 
                     .animate({opacity: 1, top: '20%'}, 200); 
         });
     });

     close.click( function(){ 
            modal 
             .animate({opacity: 0, top: '15%'}, 200, 
                 function(){ 
                     $(this).css('display', 'none');
                     overlay.fadeOut(400); 
                 }
             );
     });
});

var swiper = new Swiper('.swiper-container', {
  autoplay: {
    delay: 4000,
  },
  speed: 1400,
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
});
