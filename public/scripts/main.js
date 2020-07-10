// Document Ready
$(document).ready(function () {

	$('#loader').hide();

	$("input[type=range]").rangeslider({
		polyfill: false,
		onSlide: function (pos, value) {
			$('#distance-value').text(value);
		}
	});

	$(".wish_bt").each(function () {
		$(this).hover(function () {
			$(this).children("#bookmark-icon").removeClass("far");
			$(this).children("#bookmark-icon").addClass("fas");
		}, function () {
			$(this).children("#bookmark-icon").removeClass("fas");
			$(this).children("#bookmark-icon").addClass("far");
		});
	});	
});
