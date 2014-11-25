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

add_filter('pre_get_posts','universal_filter');
function universal_filter( $query ) {
	if ( isset( $_GET['s'] ) && $_GET['s'] == '' ) { 
		$query->query_vars['s'] = '&#160;';
		$query->set( 'is_search', 1 );
		add_action( 'template_redirect','universal_search_error' );
	}
	return $query;
}

function universal_search_error() {
	$search = locate_template( 'search.php' );
	if ( $search ) {
		load_template( $search );
		exit;
	}
}

/**
 * Append full text titles to continue reading links when not themable.
 */

add_filter( 'excerpt_more', 'universal_excerpt_more',100 );
function universal_excerpt_more( $more ) {
	global $id;
	return '&hellip; '.universal_continue_reading( $id );
}

add_filter( 'get_the_excerpt', 'universal_custom_excerpt_more',100 );
function universal_custom_excerpt_more( $output ) {
	if ( has_excerpt() && !is_attachment() ) {
		global $id;
		$output .= ' '.universal_continue_reading( $id ); // insert a blank space.
	}
	return $output;
}

function universal_continue_reading( $id ) {
    return '<a class="continue" href="'.get_permalink( $id ).'">Finish Reading<span> "'.get_the_title( $id ).'"</span></a>';
}

/*
 * Invert colors
 * This function takes a hexadecimal value and selects the contrasting light or dark color that gives the best contrast with that color.
*/
function universal_inverse_color( $color ) {
    $color = str_replace('#', '', $color);
    if ( strlen( $color ) != 6 ) { return '#000000'; }
    $rgb = '';
	$total = 0; 
	$red = 0.299 * ( 255 - hexdec(substr($color,0,2)) );
	$green = 0.587 * ( 255 - hexdec(substr($color,2,2)) );
	$blue = 0.114 * ( 255 - hexdec(substr($color,4,2)) );
	$luminance = 1 - ( ( $red + $green + $blue )/255 );
	if ( $luminance < 0.5 ) {
		return '#ffffff';
	} else {
		return '#000000';
	}
}

/* 
 * Shift Colors
 * This function takes a given hexadecimal color and shifts it a step lighter or darker, depending on the current color band.
 * Used with theme customizer to prevent non-WCAG compliant color combinations.
 */
function universal_shift_color( $color ) {
	$color = str_replace('#','',$color);
	$rgb = ''; // Empty variable
	$percent = ( universal_inverse_color( $color ) == '#ffffff' ) ? -20 : 20;
    $per = $percent/100*255; // Creates a percentage to work with. Change the middle figure to control colour temperature
    if  ($per < 0 ) {
        // DARKER
        $per =  abs($per); // Turns Neg Number to Pos Number
        for ($x=0;$x<3;$x++) {
            $c = hexdec(substr($color,(2*$x),2)) - $per;
            $c = ($c < 0) ? 0 : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
    } else {
        // LIGHTER        
        for ($x=0;$x<3;$x++) {         
            $c = hexdec(substr($color,(2*$x),2)) + $per;
            $c = ($c > 255) ? 'ff' : dechex($c);
            $rgb .= (strlen($c) < 2) ? '0'.$c : $c;
        }
    }
    return '#'.$rgb; 	
}

/* 
 * Tests whether two hex colors meet color contrast requirements up to WCAG AA for regular text.
 * @uses universal_luminosity, universal_hex2rgb
 */
function universal_compare_contrast( $bg, $fg ) {
	$rgb1 = universal_hex2rgb( $fg );
	$rgb2 = universal_hex2rgb( $bg );
	$luminosity = universal_luminosity( $rgb1[0], $rgb2[0], $rgb1[1], $rgb2[1], $rgb1[2], $rgb2[2] );
	return  ( $luminosity >= 4.5 ) ? true : false;
}


function universal_luminosity($r,$r2,$g,$g2,$b,$b2) {
	$RsRGB = $r/255;
	$GsRGB = $g/255;
	$BsRGB = $b/255;
	$R = ($RsRGB <= 0.03928) ? $RsRGB/12.92 : pow(($RsRGB+0.055)/1.055, 2.4);
	$G = ($GsRGB <= 0.03928) ? $GsRGB/12.92 : pow(($GsRGB+0.055)/1.055, 2.4);
	$B = ($BsRGB <= 0.03928) ? $BsRGB/12.92 : pow(($BsRGB+0.055)/1.055, 2.4);

	$RsRGB2 = $r2/255;
	$GsRGB2 = $g2/255;
	$BsRGB2 = $b2/255;
	$R2 = ($RsRGB2 <= 0.03928) ? $RsRGB2/12.92 : pow(($RsRGB2+0.055)/1.055, 2.4);
	$G2 = ($GsRGB2 <= 0.03928) ? $GsRGB2/12.92 : pow(($GsRGB2+0.055)/1.055, 2.4);
	$B2 = ($BsRGB2 <= 0.03928) ? $BsRGB2/12.92 : pow(($BsRGB2+0.055)/1.055, 2.4);

	if ($r+$g+$b <= $r2+$g2+$b2) {	
		$l2 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
		$l1 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);
	} else {
		$l1 = (.2126 * $R + 0.7152 * $G + 0.0722 * $B);
		$l2 = (.2126 * $R2 + 0.7152 * $G2 + 0.0722 * $B2);	
	}
	$luminosity = round(($l1 + 0.05)/($l2 + 0.05),2);
	return $luminosity;
}

function universal_hex2rgb($color){
	$color = str_replace('#', '', $color);
	if (strlen($color) != 6){ return array(0,0,0); }
	$rgb = array();
	for ($x=0;$x<3;$x++){
		$rgb[$x] = hexdec(substr($color,(2*$x),2));
	}
	return $rgb;
}

/* 
 * Breadcrumb navigation support.
 * Breadcrumbs are important to accessibility because they provide contextual orientation for navigation.
 * These breadcrumbs are very basic; if Yoast's SEO plug-in or John Havlik's Breadcrumbs NavXT plug-ins are installed, those breadcrumbs will be automatically used instead.
 */
add_filter( 'universal_before_posts', 'universal_insert_breadcrumbs' );
function universal_insert_breadcrumbs() {
	if ( function_exists( 'bcn_display' ) ) {
		$reverse = false;
		if ( is_rtl() ) { $reverse = true; }
		bcn_display( false, true, $reverse );
	}
	if ( function_exists( 'yoast_breadcrumb' ) ) {
		yoast_breadcrumb( '<p class="breadcrumbs">','</p>' );
	}
	universal_breadcrumbs();
}

function universal_breadcrumbs() {
    global $post;
	$sep = ( is_rtl() ) ? "<span class='separator'> &laquo; </span>" : "<span class='separator'> &raquo; </span>";
    $breadcrumb = '<p class="breadcrumbs">';

	$link = '<span class="breadcrumb top-level"><a href="'.home_url().'">'.apply_filters( 'universal_breadcrumb_home_text', __( 'Home', 'accessible_twin_cities' ) ).'</a></span>';
	$crumb = sprintf( __( '<i>You are here:</i> %s', 'universal' ), $link );
	$breadcrumbs[] = $crumb;
	if ( is_category() || is_single() ) {
		if ( is_attachment() ) {
			$breadcrumbs[] = '<span class="breadcrumb parent"><a href="'.get_permalink( $post->post_parent ).'">'.get_the_title( $post->post_parent ).'</a></span>';
		} else {
			$breadcrumbs[] = '<span class="breadcrumb category">'.get_the_category_list( ', ' ).'</span>'; 
		}
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
		$breadcrumbs[] = "<span class=\"breadcrumb archive-day\">". sprintf( __( 'Archive for %s', 'universal' ), get_the_time( 'F jS, Y' ) ) . "</span>"; 
	} else if ( is_month() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb archive-month\">". sprintf( __( 'Archive for %s', 'universal' ), get_the_time( 'F, Y' ) ) . "</span>"; 
	} else if ( is_year() ) { 
		$breadcrumbs[] =  "<span class=\"breadcrumb archive-year\">". sprintf( __( 'Archive for %s', 'universal' ), get_the_time( 'Y' ) ) . "</span>"; 
	} else if ( is_author() ) { 
		$breadcrumbs[] =  "<span class=\"breadcrumb archive-author\">". sprintf( __( 'Author Archive for %s', 'universal' ), get_the_author() ) . "</span>";  
	} else if ( is_home() && is_page() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb blog-home\">".__( 'Blog Home', 'universal' )."</span>"; 
	} else if ( is_search() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb search-results\">". sprintf( __( 'Search Results for &ldquo;%s&rdquo;', 'universal' ), get_search_query() ). "</span"; 
	} else if ( is_404() ) { 
		$breadcrumbs[] = "<span class=\"breadcrumb missing\">". __( '404: File not found', 'universal' ). "</span"; 
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


add_filter( 'comment_form_default_fields', 'universal_comment_form_default_fields', 10, 1 );
function universal_comment_form_default_fields( $fields ) {
	// set global values
	$commenter = wp_get_current_commenter();
	$req = get_option( 'require_name_email' );
	$aria_req = ( $req ? " aria-required='true'" : '' );
	
	$fields['author'] = '<p class="comment-form-author"><label for="author">' . __( 'Name', 'domainreference' ) . 
    ( $req ? ' <span class="required">(required)</span>' : '' ) . '</label> ' .  
    '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) .
    '" size="30"' . $aria_req . ' required /></p>';
	
	$fields['email'] = '<p class="comment-form-email"><label for="email" id="comment-email">' . __( 'Email', 'domainreference' ) . 
    ( $req ? ' <span class="required">(required)</span>' : '' ) . '</label> ' .
    '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) .
    '" size="30"' . $aria_req . ' required aria-labelledby="comment-email, comment-notes" /></p>';
	
	return $fields;
}