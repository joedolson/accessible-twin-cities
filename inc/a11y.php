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

/* 
 * Breadcrumb navigation support.
 * Breadcrumbs are important to accessibility because they provide contextual orientation for navigation.
 * These breadcrumbs are very basic; if Yoast's SEO plug-in or John Havlik's Breadcrumbs NavXT plug-ins are installed, those breadcrumbs will be automatically used instead.
 */
add_filter( 'atc_before_posts', 'atc_insert_breadcrumbs' );
function atc_insert_breadcrumbs() {
	if ( function_exists( 'bcn_display' ) ) {
		$reverse = false;
		if ( is_rtl() ) { $reverse = true; }
		bcn_display( false, true, $reverse );
	}
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
	}
	atc_breadcrumbs();
}

function atc_breadcrumbs() {
    global $post;
	$sep = ( is_rtl() ) ? "<span class='separator'> &laquo; </span>" : "<span class='separator'> &raquo; </span>";
    $breadcrumb = '<p class="breadcrumbs">';

	$link = '<span class="breadcrumb top-level"><a href="'.home_url().'">'.apply_filters( 'atc_breadcrumb_home_text', __( 'Home', 'accessible_twin_cities' ) ).'</a></span>';
	$crumb = sprintf( __( '<i>You are here:</i> %s', 'accessible-twin-cities' ), $link );
	$breadcrumbs[] = $crumb;
	if ( is_category() || is_single() ) {
		$breadcrumbs[] = '<span class="breadcrumb category">'.get_the_category_list( ', ' ).'</span>'; 
		if ( is_single() ) {
			$breadcrumbs[] = '<span class="breadcrumb single">'.get_the_title().'</span>';
		}
	} else if ( is_page() ) {
		if ( $post->post_parent ) {
			$parents = get_post_ancestors( $post->ID );
			$title = get_the_title();
			foreach ( $parents as $ancestor ) {
				$breadcrumbs[] = '<span class="breadcrumb page-parent"><a href="'.get_permalink( $ancestor ).'">'.get_the_title( $ancestor ).'</a></span>';
			}
		}
		$breadcrumbs[] = "<span class=\"breadcrumb page-current\">".get_the_title()."</span>";
	}
    if ( is_tag() ) {
		$breadcrumbs[] = "<span class=\"breadcrumb tag\">".single_tag_title( '', false )."</span>";     } else if ( is_tag() ) {
    } else if ( is_tax() ) {
		$breadcrumbs[] = "<span class=\"breadcrumb term\">".single_term_title( '', false )."</span>"; 
	} else if ( is_day() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb archive-day\">". sprintf( __( 'Archive for %s', 'accessible-twin-cities' ), get_the_time( 'F jS, Y' ) ) . "</span>"; 
	} else if ( is_month() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb archive-month\">". sprintf( __( 'Archive for %s', 'accessible-twin-cities' ), get_the_time( 'F, Y' ) ) . "</span>"; 
	} else if ( is_year() ) { 
		$breadcrumbs[] =  "<span class=\"breadcrumb archive-year\">". sprintf( __( 'Archive for %s', 'accessible-twin-cities' ), get_the_time( 'Y' ) ) . "</span>"; 
	} else if ( is_author() ) { 
		$breadcrumbs[] =  "<span class=\"breadcrumb archive-author\">". sprintf( __( 'Author Archive for %s', 'accessible-twin-cities' ), get_the_author() ) . "</span>";  
	} else if ( is_home() && is_page() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb blog-home\">".__( 'Blog Home', 'accessible-twin-cities' )."</span>"; 
	} else if ( is_search() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb search-results\">". sprintf( __( 'Search Results for &ldquo;%s&rdquo;', 'accessible-twin-cities' ), get_search_query() ). "</span"; 
	} else if ( is_404() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb missing\">". __( '404: File not found', 'accessible-twin-cities' ). "</span"; 
	}
	if ( is_rtl() && is_array( $breadcrumbs ) ) {
		$breadcrumbs = array_reverse( $breadcrumbs );	
	}
	$breadcrumb .= implode( $sep, $breadcrumbs );
    $breadcrumb .= '</p>';
	/* Only return breadcrumbs on internal pages */
	if ( !is_home() && !is_front_page() ) {
		echo $breadcrumb;
	}
}
?>