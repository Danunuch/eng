$(function() {
	$('.dos-tabs li').on('click', function() {
		var tabId = $(this).attr('data-tab');

		$('.dos-tabs li').removeClass('current'); 
		$('.tab-pane').fadeOut(0).removeClass('current'); 

		$(this).fadeIn(500).addClass('current');
		$('#' + tabId).fadeIn(500).addClass('current');
	});
});


