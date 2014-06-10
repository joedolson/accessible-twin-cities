(function( $ ) { 'use strict';
	// menu toggle
	var width = $( window ).width();
	if ( width <= 800 ) {
		$( '.primary-menu nav').hide();
	}
	$( window ).resize(function() {
		var width = $( window ).width();
		if ( width <= 800 ) {
			$( '.primary-menu nav').hide();
		} else {
			$( '.primary-menu nav').show();
		}
	});
	$( '.menu-toggle' ).on( 'click', function() { $( '.primary-menu nav' ).toggle() } );
}(jQuery));