(function( $ ) { 'use strict';
	// menu toggle
	var width = $( window ).width();
	
	if ( width < 800 ) {
		$( '.primary-menu nav ul' ).hide();
	}
	
	if ( window.innerWidth > 800 ) {
		$( window ).resize(function() {
			if ( $(this).width() != width ) {
				var width = $( this ).width();
				if ( width <= 800 ) {
					$( '.primary-menu nav ul').hide();
				} else {
					$( '.primary-menu nav ul').show();
				}
			}
		});
	}
	
	$( '.menu-toggle' ).on( 'click', function() { 
		$( '.primary-menu nav ul' ).toggle();
		var visible = $( '.primary-menu nav ul' ).is( ':visible' );
		if ( visible ) {
			$(this).addClass( 'open' ).attr( 'aria-expanded', 'true' );
		} else {
			$(this).removeClass( 'open' ).attr( 'aria-expanded', 'false' );
		}
	} );
}(jQuery));