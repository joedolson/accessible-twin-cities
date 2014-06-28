<?php
/**
 * Capitol functions and definitions
 * @package capitol
 */
add_action( 'after_setup_theme', 'atc_setup' );
if ( ! function_exists( 'atc_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * To override atc_setup() in a child theme, add your own atc_setup to your child theme's
	 * functions.php file.
	 *
	 * @uses add_theme_support() To add support for post thumbnails and automatic feed links.
	 * @uses register_nav_menus() To add support for navigation menus.
	 * @uses add_custom_background() To add support for a custom background.
	 * @uses add_editor_style() To style the visual editor.
	 * @uses load_theme_textdomain() For translation/localization support.
	 * @uses add_custom_image_header() To add support for a custom header.
	 * @uses register_default_headers() To register the default custom header images provided with the theme.
	 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
	 *
	 * @since Accessible Twin Cities 1.0
	 */
	function atc_setup() {
	
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 600; 
		}

		load_theme_textdomain( 'accessible-twin-cities', get_template_directory() . '/lang' );

		add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'video', 'aside', 'status', 'quote' ) );
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
		$font_url = "http://fonts.googleapis.com/css?family=Raleway:400,700";
		add_editor_style( array( 'css/editor.css', str_replace( ',', '%2C', $font_url ) ) );
	}
}


add_action( 'widgets_init', 'atc_widgets_init' );
if ( ! function_exists( 'atc_widgets_init' ) ) {
	function atc_widgets_init() {
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
			'description' => __( 'Add up to 5 widgets to show on the bottom of your front page.', 'accessible-twin-cities' ),
			'id' => 'ps2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));

		register_sidebar( array(
			'name'=>'Page Sidebar',
			'description' => __( 'Widgets in this region will appear on WordPress Pages.', 'accessible-twin-cities' ),
			'id' => 'ps3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));

		register_sidebar( array(
			'name'=>'Global Sidebar - Top',
			'description' => __( 'These widgets appear globally on posts and pages, excluding the front page.', 'accessible-twin-cities' ),
			'id' => 'ps4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));

		register_sidebar( array(
			'name'=>'Global Sidebar - Bottom',
			'description' => __( 'These widgets appear globally on posts and pages, excluding the front page.', 'accessible-twin-cities' ),
			'id' => 'ps5',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h2>',
			'after_title' => '</h2>',
		));
	}
}
// for demo purposes, I want this overridden by the inaccessible child; but will change after.
require_once( get_stylesheet_directory() . '/inc/a11y.php' );
require_once( get_template_directory() . '/inc/customizer.php' );

add_filter( 'wp_title', 'atc_home_title' );
function atc_home_title( $title ) {
	if ( ( is_front_page() || is_home() ) && empty( $title ) ) {
		return __( 'Home', 'accessible-twin-cities' ). ' &raquo; '.get_bloginfo( 'name' );
	} else {
		return $title . get_bloginfo( 'name' );
	}
	return $title;
}

if ( function_exists( 'register_nav_menu' ) ) {
	register_nav_menus( array( 
			'primary' => __( 'Main Menu', 'accessible-twin-cities' ),
			'secondary' => __( 'Footer Menu', 'accessible-twin-cities' )
		)
	);	
}

add_action( 'wp_print_styles', 'atc_load_styles' );
function atc_load_styles() {
		wp_register_style('Raleway', 'http://fonts.googleapis.com/css?family=Raleway:400,700');
		wp_enqueue_style( 'atc-style', get_stylesheet_uri(), array( 'dashicons', 'Raleway' ), '1.0' );	
}

/* 
 * Check for customizer color settings. 
 * If set, check whether links can be blue against that background. If not, use calculated inverse color. 
 */
add_action( 'wp_head', 'atc_customizer_styles' );
function atc_customizer_styles() {

	$header = atc_generate_custom_styles( 'header', '#ffffff' );
	$sidebar = atc_generate_custom_styles( 'sidebar', '#ffffff' );
	$content = atc_generate_custom_styles( 'content', '#ffffff' );
	$wrapper = atc_generate_custom_styles( 'wrapper', '#dddddd' );
	$menu = atc_generate_custom_styles( 'primary-menu', '#111111' );
	$pw = atc_generate_custom_styles( 'page-wrapper', '#ffffff' );

	if ( $header || $sidebar || $content || $wrapper || $pw || $menu ) {
		?>
		<style>
			<?php echo "$wrapper"; ?>
			<?php echo "$pw"; ?>
			<?php echo "$header"; ?>
			<?php echo "$menu"; ?>
			<?php echo "$sidebar"; ?>
			<?php echo "$content"; ?>
		</style>
		<?php
	}
}

function atc_generate_custom_styles( $setting, $default ) {
	$value = $color = '';
	if ( $setting == 'primary-menu' ) {
		$get_setting = 'menu'; 
	} else if ( $setting == 'page-wrapper' ) { 
		$get_setting = 'pw'; 
	} else {
		$get_setting = $setting;
	}
	
	if ( $setting == 'primary-menu' ) {
		$value = ( get_theme_mod( 'atc_'.$get_setting.'_bg' ) && get_theme_mod( 'atc_'.$get_setting.'_bg' ) != $default ) ? "\n.$setting, .$setting a { background-color: ".get_theme_mod( 'atc_'.$get_setting.'_bg' )."; }" : false;
	} else {
		$value = ( get_theme_mod( 'atc_'.$get_setting.'_bg' ) && get_theme_mod( 'atc_'.$get_setting.'_bg' ) != $default ) ? "\n.$setting { background-color: ".get_theme_mod( 'atc_'.$get_setting.'_bg' )."; }" : false;
	}
	if ( $value ) { 
		$viable = atc_compare_contrast( get_theme_mod( 'atc_'.$get_setting.'_bg' ), apply_filters( 'atc_custom_link_color','#0000dd' ) );
		if ( $viable ) { 
			$color = "\n.$setting { color: ".atc_inverse_color( get_theme_mod( 'atc_'.$get_setting.'_bg' ) )."; }\n.$setting a { color: #0000dd; }";
		} else {
			$color = "\n.$setting, .$setting a { color: ".atc_inverse_color( get_theme_mod( 'atc_'.$get_setting.'_bg' ) )."; }"; 
		}
	}
	return $value.$color;
}

add_filter( 'atc_end_of_header', 'atc_custom_header_image' );
function atc_custom_header_image( $value ) {
	if ( get_header_image() ) {
		// until header image customizer supports alt attributes, leave alt attribute blank.
		echo "<img class='header-image' src='".get_header_image()."' width='".get_custom_header()->width."' height='".get_custom_header()->height."' alt='' />";
	}
}

add_action( 'wp_enqueue_scripts','atc_enqueue_scripts' );
function atc_enqueue_scripts() {
	wp_enqueue_script( 'atc.a11y', get_template_directory_uri() . '/js/a11y.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script( 'atc.general', get_template_directory_uri() . '/js/general.js', array('jquery'), '1.0.0', true );
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}	
}

function atc_archive_title( $display = true ) {	
	if ( is_archive() ) {
		$title = post_type_archive_title();
	}
	if ( is_category() || is_tax() ) {
		$title = single_term_title();
	}
	if ( is_home() ) {
		$title = sprintf( __( '%s Posts', 'accessible-twin-cities' ), get_bloginfo( 'name' ) );
	}
	if ( $display ) {
		echo $title;
	} else {
		return $title;
	}
}