( function( $ ) {
		$( '.primary-menu' ).find( 'a' ).on( 'focus blur', function() {
			$( this ).parents().toggleClass( 'focus' );
		} );
} )( jQuery );