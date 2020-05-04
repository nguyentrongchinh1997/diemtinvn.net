$(function(){
	if ($('.input').length) {
		id = $('.input').attr('id');
		value = $('.input').attr('value');
		valueClass = $('.' + id).attr('value');

		if (valueClass == value) {
			$('.' + id).addClass('active-color');
			//$('.home').removeClass('active-color');
			$('.home').css({'background':'#f0f0f0'});
			$('.home i').css({'color':'#4f4f4f'});
		}
	}

	$('.open-menu-mobile').click(function(){
		$('.menu-mobile-list').css({"left":"0px"});
	});
	$('.menu-mobile-list ul .dropdown').click(function(){
		$('.menu-mobile-list ul .dropdown').removeClass('dropdown-color');
		$(this).addClass('dropdown-color');
		$(this).children('ul').toggle('fast');
	});
	$('.menu-mobile-list .close-menu').click(function(){
		$('.menu-mobile-list').css({"left":"-100%"});
	})
})
