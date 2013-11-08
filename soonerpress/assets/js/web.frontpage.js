
// jQuery JS (compatible) begin

;(function($) {

$(document).ready( function() {

	// jQuery('input[placeholder], textarea[placeholder]').placeholder();

	$('#home-slider').flexslider({
		'animation': 'fade',
		'slideshow': true,
		'slideshowSpeed': 5000,
		'animationSpeed': 500,
		'controlNav': false,
		'directionNav': false,
	});

	// branch_map = new GMaps({
	// 	'div': '#branches-map',
	// 	'lat': sp.page_branches_init_location['lat'],
	// 	'lng': sp.page_branches_init_location['lng'],
	// 	'zoom': parseInt( sp.page_branches_init_zoom ),
	// });

} );

$(window).load( function() {

} );

})(jQuery);

