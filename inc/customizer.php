<?php
/**
 * Universal Theme Customizer
 *
 * @package universal
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
 
 /* .header, .sidebar, .content, .wrapper, .page-wrapper  */
add_action( 'customize_register', 'universal_customize_register' );
if ( ! function_exists( 'universal_customize_register' ) ) {
	function universal_customize_register( $wp_customize ) {
		$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
		$wp_customize->get_setting( 'background_color' )->transport  = 'postMessage';
		// Add Sections
		$wp_customize->add_section( 'universal_colors' , array(
			'title' => __( 'Universal Color Settings', 'universal' ),
			'priority' => 201,
			'description' => __( 'Modify selected background colors. Text colors are automatically adjusted for you.', 'universal' ),
		) );
		$wp_customize->add_section( 'universal_content' , array(
			'title' => __( 'Universal Content Settings', 'universal' ),
			'priority' => 202,
			'description' => __( 'Additional content & display options.', 'universal' ),
		) );	
		//Add Settings
		$wp_customize->add_setting( 'universal_header_bg', array( 
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color', 
		));
		$wp_customize->add_setting( 'universal_sidebar_bg', array( 
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color', 
		));
		$wp_customize->add_setting( 'universal_content_bg', array( 
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color', 
		));
		$wp_customize->add_setting( 'universal_wrapper_bg', array( 
			'default' => '#dddddd',
			'sanitize_callback' => 'sanitize_hex_color', 
		));
		$wp_customize->add_setting( 'universal_pw_bg', array( 
			'default' => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color', 
		));	
		$wp_customize->add_setting( 'universal_menu_bg', array( 
			'default' => '#111111',
			'sanitize_callback' => 'sanitize_hex_color', 
		));	
		$wp_customize->add_setting( 'universal_content_display', array( 
			'default' => 'full',
			'sanitize_callback' => 'universal_sanitize_content_display', 
		));
		$wp_customize->add_setting( 'universal_ajax_comments', array( 
			'default' => '1',
			'sanitize_callback' => 'universal_sanitize_checkbox', 
		));	
		// Header Background
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
				$wp_customize,
				'universal_header_bg',
				array(
					'label' => __( 'Header Background', 'universal' ),
					'section' => 'universal_colors',
					'settings' => 'universal_header_bg',
				)
			)
		);
		// Menu Background
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
				$wp_customize,
				'universal_menu_bg',
				array(
					'label' => __( 'Menu Background', 'universal' ),
					'section' => 'universal_colors',
					'settings' => 'universal_menu_bg',
				)
			)
		);	
		// Sidebar Background
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
				$wp_customize,
				'universal_sidebar_bg',
				array(
					'label' => __( 'Sidebar Background', 'universal' ),
					'section' => 'universal_colors',
					'settings' => 'universal_sidebar_bg',
				)
			)
		);
		// Content Background
		$wp_customize->add_control(
			new WP_Customize_Color_Control(
				$wp_customize,
				'universal_content_bg',
				array(
					'label' => __( 'Content Background', 'universal' ),
					'section' => 'universal_colors',
					'settings' => 'universal_content_bg',
				)
			)
		);
		// Wrapper Background
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
				$wp_customize,
				'universal_wrapper_bg',
				array(
					'label' => __( 'Wrapper Background', 'universal' ),
					'section' => 'universal_colors',
					'settings' => 'universal_wrapper_bg',
				)
			)
		);	
		// Page-Wrapper Background
		$wp_customize->add_control( 
			new WP_Customize_Color_Control(
				$wp_customize,
				'universal_pw_bg',
				array(
					'label' => __( 'Page Wrapper Background', 'universal' ),
					'section' => 'universal_colors',
					'settings' => 'universal_pw_bg',
				)
			)
		);
		// Content Display
		$wp_customize->add_control( 
			'universal_control_content', 
			array(
				'label'    => __( 'Display archive and home page content as', 'universal' ),
				'section'  => 'universal_content',
				'settings' => 'universal_content_display',
				'type'     => 'select',
				'choices'  => array(
					'full'    => 'Full Content',
					'excerpt' => 'Excerpt',
				),
			)
		);	
		
		// Content Display
		$wp_customize->add_control( 
			'universal_ajax_comments', 
			array(
				'label'    => __( 'Use AJAX Comments', 'universal' ),
				'section'  => 'universal_content',
				'settings' => 'universal_ajax_comments',
				'type'     => 'checkbox'
			)
		);		
	}
}

/**
 * Sanitize setting saved for content display. Only two values allowed.
*/
function universal_sanitize_content_display( $value ) {
	if ( $value == 'full' || $value == 'excerpt' ) {
		return $value;
	}
	return false;
}

/**
 * Sanitize the checkbox.
 *
 * @param boolean $input.
 * @return boolean (true|false).
 */
function universal_sanitize_checkbox( $input ) {
	if ( $input == 1 ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function universal_customize_preview_js() {
	wp_enqueue_script( 'universal_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'universal_customize_preview_js' );