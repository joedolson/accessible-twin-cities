(function( $ ) { 'use strict';

	// remove target attribute from links
	$('a').removeAttr('target');
	
	// add target attribute when rel=external
	// @why There are good reasons for having links open in another window; this requires a higher level of knowledge to do it.
	$('a[rel=external]').attr( 'target', '_blank' );
	
	// make dropdowns functional on focus
	$( '.primary-menu' ).find( 'a' ).on( 'focus blur', function() {
		$( this ).parents().toggleClass( 'focus' );
	} );
	
}(jQuery));