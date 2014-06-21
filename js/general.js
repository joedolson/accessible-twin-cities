(function( $ ) { 'use strict';
	// menu toggle
	var width = $( window ).width();
	if ( width <= 800 ) {
		$( '.primary-menu nav ul').hide();
	}
	$( window ).resize(function() {
		var width = $( window ).width();
		if ( width <= 800 ) {
			$( '.primary-menu nav ul').hide();
		} else {
			$( '.primary-menu nav ul').show();
		}
	});
	$( '.menu-toggle' ).on( 'click', function() { $( '.primary-menu nav ul' ).toggle() } );
}(jQuery));