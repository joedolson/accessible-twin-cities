(function( $ ) { 'use strict';
	// remove target attribute from links
	$('a').removeAttr('target');
	// add target attribute when rel=external
	$('a[rel=external]').attr( 'target', '_blank' );

}(jQuery));