$(function(){
	if ($('.input').length) {
		id = $('.input').attr('id');
		value = $('.input').attr('value');
		valueClass = $('.' + id).attr('value');

		if (valueClass == value) {
			$('.' + id).addClass('active-color');
			$('.home').removeClass('active-color');
		}
	}

})
