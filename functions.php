<?php
/**
 * Univeresal functions and definitions
 * @package Universal
 */
add_action( 'after_setup_theme', 'universal_setup' );
if ( ! function_exists( 'universal_setup' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which runs
	 * before the init hook. The init hook is too late for some features, such as indicating
	 * support post thumbnails.
	 *
	 * To override universal_setup() in a child theme, add your own universal_setup to your child theme's
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
	 * @since Universal 0.9
	 */
	function universal_setup() {
	
		global $content_width;
		if ( ! isset( $content_width ) ) {
			$content_width = 600; 
		}

		load_theme_textdomain( 'universal', get_template_directory() . '/lang' );

		add_theme_support( 'html5', array( 'comment-list', 'search-form', 'comment-form' ) );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'post-formats', array( 'audio', 'gallery', 'image', 'video', 'aside', 'status', 'quote' ) );
		add_theme_support( 'automatic-feed-links' ); 
		add_theme_support( 'title-tag' );
		add_theme_support( 'custom-header', apply_filters( 'universal_custom_header_args', array(
				'default-color' => '#fff',
				'default-text-color' => '#fff',
				'header-text' => false,
				'width' => 960, 
				'flex-width' => true,
				'height' => 180,
				'flex-height' => true,
				'default-image' => get_template_directory_uri() . '/images/header.jpg',
				'uploads' => true
			) ) );
		add_theme_support( 'custom-background', apply_filters( 'universal_custom_background_args', array(
				'default-color' => 'f5f5f5',
				'default-image' => '',
			) ) );
		add_theme_support( 'woocommerce' );			
		$font_url = apply_filters( 'universal_custom_font', "//fonts.googleapis.com/css?family=Raleway:400,700" );
		add_editor_style( array( 'css/editor.css', str_replace( ',', '%2C', $font_url ) ) );
		
		register_nav_menus( array( 
				'primary' => __( 'Main Menu', 'universal' ),
				'secondary' => __( 'Footer Menu', 'universal' ),
				'site-map' => __( 'Site Map', 'universal' ),
				'social-networks' => __( 'Social Networks', 'universal' )
			)
		);
	}
}

if ( ! function_exists( '_wp_render_title_tag' ) ) {
    function universal_render_title() {
		?>
		<title><?php wp_title( ' &raquo; ', true, 'right' ); ?></title>
		<?php
    }
    add_action( 'wp_head', 'universal_render_title' );
}

add_action( 'widgets_init', 'universal_widgets_init' );
if ( ! function_exists( 'universal_widgets_init' ) ) {
	function universal_widgets_init() {
		register_sidebar( array(
			'name'=>'Post Sidebar',
			'description' => __( 'Widgets in this region will appear on all posts and post archives', 'universal' ),
			'id' => 'ps1',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2>',
			'after_title' => '</h2><div class="widget-inner">',
		));

		register_sidebar( array(
			'name'=>'Home Sidebar',
			'description' => __( 'Add up to 5 widgets to show on the bottom of your front page.', 'universal' ),
			'id' => 'ps2',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2>',
			'after_title' => '</h2><div class="widget-inner">',
		));

		register_sidebar( array(
			'name'=>'Page Sidebar',
			'description' => __( 'Widgets in this region will appear on WordPress Pages.', 'universal' ),
			'id' => 'ps3',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2>',
			'after_title' => '</h2><div class="widget-inner">',
		));

		register_sidebar( array(
			'name'=>'Global Sidebar - Top',
			'description' => __( 'These widgets appear globally on posts and pages, excluding the front page.', 'universal' ),
			'id' => 'ps4',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2>',
			'after_title' => '</h2><div class="widget-inner">',
		));

		register_sidebar( array(
			'name'=>'Global Sidebar - Bottom',
			'description' => __( 'These widgets appear globally on posts and pages, excluding the front page.', 'universal' ),
			'id' => 'ps5',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget' => '</div></div>',
			'before_title' => '<h2>',
			'after_title' => '</h2><div class="widget-inner">',
		));
	}
}

require_once( get_template_directory() . '/inc/a11y.php' );
require_once( get_template_directory() . '/inc/comments.php' );
require_once( get_template_directory() . '/inc/customizer.php' );

add_filter( 'tiny_mce_before_init', 'universal_tinymce_init' );
if ( ! function_exists( 'universal_tinymce_init' ) ) {
	function universal_tinymce_init( $init ) {
		// Remove H1 from TinyMCE so users are discouraged from breaking headings hierarchy.
		$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6';
		
		return $init;
	}
}

add_filter( 'wp_title', 'universal_home_title' );
if ( ! function_exists( 'universal_home_title' ) ) {
	function universal_home_title( $title ) {
		if ( ( is_front_page() || is_home() ) && empty( $title ) ) {
			return __( 'Home', 'universal' ). ' &raquo; '.get_bloginfo( 'name' );
		} 
		return $title;
	}
}

add_filter( 'universal_end_of_header', 'universal_social_media_menu' );
if ( ! function_exists( 'universal_social_media_menu' ) ) {
	function universal_social_media_menu( $return ) {
		if ( has_nav_menu( 'social-networks' ) ) {
			$return = "<div class='social-networks' role='navigation' aria-label='Social Media'>";
			$return .= wp_nav_menu( array( 'theme_location'=>'social-networks', 'fallback_cb'=>'', 'echo'=>false, 'link_before'=>'<span class="screen-reader-text">', 'link_after'=>'</span>' ) );
			$return .= "</div>";
		}
		echo $return;
	}
}

add_action( 'wp_print_styles', 'universal_load_styles' );
if ( ! function_exists( 'universal_load_styles' ) ) {
	function universal_load_styles() {
			wp_register_style('Raleway', '//fonts.googleapis.com/css?family=Raleway:400,700');
			wp_enqueue_style( 'universal-style', get_stylesheet_uri(), array( 'dashicons', 'Raleway' ), '1.0' );	
	}
}

if ( ! function_exists( 'universal_show_excerpt' ) ) {
	function universal_show_excerpt() {
		if ( !is_singular() && get_theme_mod( 'universal_content_display' ) == 'excerpt' ) {
			return true;
		}
		return false;
	}
}

/* 
 * Check for customizer color settings. 
 * If set, check whether links can be blue against that background. If not, use calculated inverse color. 
 */
add_action( 'wp_head', 'universal_customizer_styles' );
if ( ! function_exists( 'universal_customizer_styles' ) ) {
	function universal_customizer_styles() {

		$header = 	universal_generate_custom_styles( 'header', '#ffffff' );
		$sidebar = 	universal_generate_custom_styles( 'sidebar', '#ffffff' );
		$content = 	universal_generate_custom_styles( 'content', '#ffffff' );
		$wrapper =	universal_generate_custom_styles( 'wrapper', '#dddddd' );
		$menu = 	universal_generate_custom_styles( 'primary-menu', '#111111' );
		$pw = 		universal_generate_custom_styles( 'page-wrapper', '#ffffff' );

		if ( $header || $sidebar || $content || $wrapper || $pw || $menu ) {
			?>

	<style>
	/* Styles for Universal by Joe Dolson http://themes.joedolson.com/universal/ */
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
}

if ( ! function_exists( 'universal_generate_custom_styles' ) ) {
	function universal_generate_custom_styles( $setting, $default ) {
		$value = $color = '';
		if ( $setting == 'primary-menu' ) {
			$get_setting = 'menu'; 
		} else if ( $setting == 'page-wrapper' ) { 
			$get_setting = 'pw'; 
		} else {
			$get_setting = $setting;
		}
		
		$theme_mod = get_theme_mod( 'universal_'.$get_setting.'_bg' );
		
		if ( $setting == 'primary-menu' ) {
			$value = ( $theme_mod && $theme_mod != $default ) ? ".$setting, .$setting a { background-color: ".esc_attr( $theme_mod )."; }\n" : ".$setting, .$setting a { background-color: ".$default."; }\n";
		} else {
			$value = ( $theme_mod && $theme_mod != $default ) ? ".$setting { background-color: ".esc_attr( $theme_mod )."; }\n" : ".$setting { background-color: ".$default."; }\n";
		}
		if ( $value ) { 
			$test_color = ( $theme_mod != '' ) ? esc_attr( $theme_mod ) : $default;
			$viable = universal_compare_contrast( $test_color, apply_filters( 'universal_custom_link_color', '#0000dd' ) );
			if ( $viable ) { 
				$color = ".$setting { color: ".universal_inverse_color( $test_color )."; }\n.$setting a { color: #0000dd; }\n";
			} else {
				$color = ".$setting, .$setting a { color: ".universal_inverse_color( $test_color )."; }\n"; 
			}
		}
		return $value.$color;
	}
}

add_filter( 'universal_end_of_header', 'universal_custom_header_image' );
if ( ! function_exists( 'universal_custom_header_image' ) ) {
	function universal_custom_header_image( $value ) {
		if ( get_header_image() ) {
			// until header image customizer supports alt attributes, leave alt attribute blank.
			echo "<img class='header-image' src='".get_header_image()."' width='".get_custom_header()->width."' height='".get_custom_header()->height."' alt='' />";
		}
	}
}

add_action( 'wp_enqueue_scripts','universal_enqueue_scripts' );
if ( ! function_exists( 'universal_enqueue_scripts' ) ) {
	function universal_enqueue_scripts() {
		wp_enqueue_script( 'universal.a11y', get_template_directory_uri() . '/js/a11y.js', array('jquery'), '1.0.0', true );
		$a11y_i18n = array(
			'externalLink' => __( 'External link', 'universal' ),
			'newWindow' => __( 'Opens in a new window', 'universal' )
		);
		wp_localize_script( 'universal.a11y', 'universalA11y', $a11y_i18n );
		if ( get_theme_mod( 'universal_ajax_comments' ) == 1 ) {
			wp_enqueue_script( 'universal.comments', get_template_directory_uri() . "/js/comments.js", array('jquery'), '1.0.0', true );
			$comment_i18n = array( 
				'processing' => __( 'Processing...', 'universal' ),
				'flood' => sprintf( __( 'Your comment was either a duplicate or you are posting too rapidly. <a href="%s">Edit your comment</a>', 'universal' ), '#comment' ),
				'error' => __( 'There were errors in submitting your comment; complete the missing fields and try again!', 'universal' ),
				'emailInvalid' => __( 'That email appears to be invalid.', 'universal' ),
				'required' => __( 'This is a required field.', 'universal' )		
			);
			wp_localize_script( 'universal.comments', 'universalComments', $comment_i18n );
		}
		wp_enqueue_script( 'universal.general', get_template_directory_uri() . '/js/general.js', array('jquery'), '1.0.0', true );
		wp_register_style( 'universal.woocommerce', get_template_directory_uri() . '/css/woocommerce.css' ); 
		if ( class_exists( 'WC_Cart' ) ) {
			wp_enqueue_style( 'universal.woocommerce' );
		}
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}

if ( ! function_exists( 'universal_archive_title' ) ) {
	function universal_archive_title( $display = true ) {	
		if ( is_archive() ) {
			$title = post_type_archive_title();
		}
		if ( is_category() || is_tax() ) {
			$title = single_term_title();
		}
		if ( is_home() ) {
			$title = sprintf( __( '%s Posts', 'universal' ), get_bloginfo( 'name' ) );
		}
		if ( $display ) {
			echo $title;
		} else {
			return $title;
		}
	}
}

/* WooCommerce support */

add_action( 'woocommerce_before_main_content', 'universal_theme_wrapper_start', 10 );
add_action( 'woocommerce_after_main_content', 'universal_theme_wrapper_end', 10 );

function universal_theme_wrapper_start() {
  echo '<section>';
}

function universal_theme_wrapper_end() {
  echo '</section>';
}