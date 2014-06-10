<?php
register_sidebar( array(
	'name'=>'Post Sidebar',
	'description' => __( 'Widgets in this region will appear on all posts and post archives', 'accessible-twin-cities' ),
	'id' => 'ps1',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar( array(
	'name'=>'Home Sidebar',
	'id' => 'ps2',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar( array(
	'name'=>'Page Sidebar',
	'id' => 'ps3',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar( array(
	'name'=>'Global Sidebar - Top',
	'id' => 'ps4',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

register_sidebar( array(
	'name'=>'Global Sidebar - Bottom',
	'id' => 'ps5',
	'before_widget' => '<div id="%1$s" class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<h2>',
	'after_title' => '</h2>',
));

load_theme_textdomain( 'accessible-twin-cities', get_template_directory() . '/lang' );

// for demo purposes, I want this overridden by the inaccessible child; but will change after.
require_once( get_stylesheet_directory() . '/inc/a11y.php' );
//require_once( get_template_directory() . '/inc/a11y.php' );

if ( ! isset( $content_width ) ) $content_width = 600; 
if ( is_singular() ) wp_enqueue_script( "comment-reply" );

add_filter( 'wp_title', 'atc_home_title' );
function atc_home_title( $title ) {
	if ( ( is_front_page() || is_home() ) && empty( $title ) ) {
		return __( 'Home', 'accessible-twin-cities' ). ' &raquo; '.get_bloginfo( 'name' );
	} else {
		return $title . get_bloginfo( 'name' );
	}
	return $title;
}

add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
add_theme_support( 'post-thumbnails' );
add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'video' ) );
add_theme_support( 'automatic-feed-links' ); 
add_theme_support( 'custom-header', apply_filters( 'atc_custom_header_args', array(
		'default-color' => 'fff',
		'width' => 960, 
		'flex-width' => true,
		'height' => 180,
		'flex-height' => true,
		'default-image' => get_template_directory_uri() . '/images/header.jpg',
		'uploads' => true
	) ) );
add_theme_support( 'custom-background', apply_filters( 'atc_custom_background_args', array(
		'default-color' => 'f5f5f5',
		'default-image' => '',
	) ) );

add_action( 'init', 'atc_add_editor_styles' );
function atc_add_editor_styles() {
    add_editor_style( 'css/editor-style.css' );
}

if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menus( array( 
			'primary' => __( 'Main Menu', 'accessible-twin-cities' ),
			'secondary' => __( 'Footer Menu', 'accessible-twin-cities' )
		)
	);	
}

add_action('wp_print_styles', 'atc_load_styles');
function atc_load_styles() {
		wp_register_style('Raleway', 'http://fonts.googleapis.com/css?family=Raleway:400,700');
		wp_enqueue_style( 'atc-style', get_stylesheet_uri(), array( 'dashicons', 'Raleway' ), '1.0' );	
}


add_filter( 'atc_end_of_header', 'atc_custom_header_image' );
function atc_custom_header_image( $value ) {
	if ( get_header_image() ) {
		// until header image customizer supports alt attributes, leave alt attribute blank.
		echo "<img class='header-image' src='".get_header_image()."' width='".get_custom_header()->width."' height='".get_custom_header()->height."' alt='' />";
	}
}

/* Probably can't do this */
add_filter( 'the_title', 'atc_heading_title', 10, 2 );
function atc_heading_title( $title, $id ) {
	if ( get_post_meta( $id, 'h_title', true ) !== '' ) {
		return get_post_meta( $id, 'h_title', true );
	}
	return $title;
}

add_action( 'wp_enqueue_scripts','atc_enqueue_scripts' );
function atc_enqueue_scripts() {
	wp_enqueue_script( 'atc.a11y', get_template_directory_uri() . '/js/a11y.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'atc.general', get_template_directory_uri() . '/js/general.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'atc.skiplinks', get_template_directory_uri() . '/js/skiplinks.js', array(), '1.0.0', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}	
}