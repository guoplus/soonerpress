
// global variables

if( 'undefined' != typeof sp ) {
	var baseurl = sp.baseurl;
	var ajaxurl = sp.ajaxurl;
	var tplurl  = sp.tplurl;
}

// Useful functions

var isMobile = {
	android:     function() { return navigator.userAgent.match(/Android/i)     ? true : false; },
	blackberry:  function() { return navigator.userAgent.match(/BlackBerry/i)  ? true : false; },
	ios:         function() { return navigator.userAgent.match(/iPhone|iPod/i) ? true : false; },
	windows:     function() { return navigator.userAgent.match(/IEMobile/i)    ? true : false; },
	any:         function() { return (isMobile.android() || isMobile.blackberry() || isMobile.ios() || isMobile.windows()); }
};

function spScrollTo( $element, duration ) {
	if( 'undefined' == typeof duration )
		duration = 'slow';
	if( 'string' == typeof $element )
		$element = jQuery( $element );
	if( $element.length )
		jQuery('html, body').stop(true,false).animate( { 'scrollTop': $element.offset().top - ( jQuery('#wpadminbar').length ? jQuery('#wpadminbar').height() : 0 ) }, duration );
}

function spGetUrlParam( name ) {
	var reg = new RegExp( "(^|&\?)" + name + "=([^&]*)(&|$)" );
	var r = window.location.href.match(reg);
	if( r != null )
		return unescape(r[2]);
	return null;
}

