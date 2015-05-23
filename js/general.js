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
	
	$('.menu-item a').on('keydown', function(e) {

		// left key
		if(e.which === 37) {
			e.preventDefault();
			$(this).parent().prev().children('a').focus();
		}
		// right key
		else if(e.which === 39) {
			e.preventDefault();
			$(this).parent().next().children('a').focus();
		}
		// down key
		else if(e.which === 40) {
			e.preventDefault();
			if($(this).next().length){
				$(this).next().find('li:first-child a').first().focus();
			} else {
				$(this).parent().next().children('a').focus();
			}
		}
		// up key
		else if(e.which === 38) {
			e.preventDefault();
			if($(this).parent().prev().length){
				$(this).parent().prev().children('a').focus();
			}
			else {
				$(this).parents('ul').first().prev('a').focus();
			}
		}

	});

}(jQuery));