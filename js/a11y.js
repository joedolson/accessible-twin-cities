(function( $ ) { 'use strict';

	// remove target attribute from links
	$('a').removeAttr('target');
	
	// add target attribute when rel=external
	// @why There are reasons for links to open in a new tab; this requires a higher knowledge barrier to do it.
	$('a[rel=external]').attr( 'target', '_blank' );
	
	// make dropdowns functional on focus
	$( '.primary-menu' ).find( 'a' ).on( 'focus blur', function() {
		$( this ).parents( 'ul, li' ).toggleClass( 'focus' );
	} );
	
	// fix cases where blog post photos have title attributes but not alt attributes
    // this is caused by WP using title for title but not requiring alt attribute through version 3.6
    $('img[title]').not(':has([alt])').each(function () {
        var theTitle = $(this).attr('title');
        $(this).attr('alt', theTitle).removeAttr('title');
    } );	
	
	
	// Remove title attributes when the title attribute is the same as the link text
    $('*').each( function () {
        var self = $(this);
        var theTitle = $.trim( self.attr( 'title' ) );
        var theText = $.trim( self.text() );
        if ( theTitle === theText ) {
            self.removeAttr( 'title' );
        }
    } );
	
}(jQuery));