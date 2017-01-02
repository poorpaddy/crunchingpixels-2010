$(document).ready(function(){

/* ===============================
   Arrow Movement
   =============================== */
	var active_pos = $('aside section li').position();
	var active_pos2 = $('aside section li.current').position();

	if ($('div.home')[0]) {
		$('.slide1').css({ 'top':(active_pos.top + 15)+'px' });
		$('.slide2').css({ 'top':(active_pos.top + 15)+'px' });
		$('.slide3').css({ 'top':(active_pos.top + 15)+'px' });
	}
	if ($('aside.categories')[0]) {
		$('.slide4').css({ 'top':(active_pos2.top + 12)+'px' }); 
	}
	$('aside.home section li').mouseenter(function(){
		var pos = $(this).position();
		$(this).parent().parent().children('div.arrow').stop().animate({ 'top': (pos.top + 15)+'px' });
	});

	$('aside.home section li').mouseleave(function(){
		$(this).parent().parent().children('div.arrow').stop().animate({ 'top':(active_pos.top + 15)+'px' }, 400, 'easeOutBounce');
	});

	$('aside.categories section li').mouseenter(function(){
		var pos = $(this).position();
		$(this).parent().parent().children('div.arrow').stop().animate({ 'top': (pos.top + 12)+'px' });
	});

	$('aside.categories section li').mouseleave(function(){
		$(this).parent().parent().children('div.arrow').stop().animate({ 'top':(active_pos2.top + 12)+'px' }, 400, 'easeOutBounce');
	});


/* ===============================
   Add First & Last Class to LI's
   =============================== */
   $('li:first-child').addClass('firstli');
   $('li:last-child').addClass('lastli');
   
});