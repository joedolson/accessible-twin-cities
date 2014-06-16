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

/**
 * Append full text titles to continue reading links when not themable.
 */

add_filter( 'excerpt_more', 'atc_excerpt_more',100 );
function atc_excerpt_more( $more ) {
	global $id;
	return '&hellip; '.atc_continue_reading( $id );
}

add_filter( 'get_the_excerpt', 'atc_custom_excerpt_more',100 );
function atc_custom_excerpt_more( $output ) {
	if ( has_excerpt() && !is_attachment() ) {
		global $id;
		$output .= ' '.atc_continue_reading( $id ); // insert a blank space.
	}
	return $output;
}

function atc_continue_reading( $id ) {
    return '<a class="continue" href="'.get_permalink( $id ).'">Finish Reading<span> "'.get_the_title( $id ).'"</span></a>';
}