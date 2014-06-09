<?php
/**
 * Filter search results so empty searches return a search error.
 * 
 * If a search query is detected, the query is currently the main query, and the search query is empty, load the search template with an empty result set.
 * 
 * @since 1.0.0
 *
 * @param object $query WP Query object
 * @return $query
 */

add_filter('pre_get_posts','atc_filter');
function atc_filter( $query ) {
	if ( isset( $_GET['s'] ) && $_GET['s'] == '' ) { 
		$query->query_vars['s'] = '&#160;';
		$query->set( 'is_search', 1 );
		add_action( 'template_redirect','atc_search_error' );
	}
	return $query;
}

function atc_search_error() {
	$search = locate_template( 'search.php' );
	if ( $search ) {
		load_template( $search );
		exit;
	}
}