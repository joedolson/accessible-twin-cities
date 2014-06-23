<?php
/**
 * Accessible Twin Cities Theme Customizer
 *
 * @package accessible-twin-cities
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
 
 /* .header, .sidebar, .content, .wrapper, .page-wrapper  */
add_action( 'customize_register', 'atc_customize_register' );
function atc_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport  = 'postMessage';
	// Add Section
	$wp_customize->add_section( 'atc_colors' , array(
		'title' => __( 'Accessible Twin Cities Color Settings', 'atc' ),
		'priority' => 201,
		'description' => __( 'Modify selected background colors. Text colors are automatically adjusted for you.', 'atc' ),
	) );
	//Add Settings
	$wp_customize->add_setting( 'atc_header_bg', array( 
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color', 
	));
	$wp_customize->add_setting( 'atc_sidebar_bg', array( 
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color', 
	));
	$wp_customize->add_setting( 'atc_content_bg', array( 
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color', 
	));
	$wp_customize->add_setting( 'atc_wrapper_bg', array( 
		'default' => '#dddddd',
		'sanitize_callback' => 'sanitize_hex_color', 
	));
	$wp_customize->add_setting( 'atc_pw_bg', array( 
		'default' => '#ffffff',
		'sanitize_callback' => 'sanitize_hex_color', 
	));	
	$wp_customize->add_setting( 'atc_menu_bg', array( 
		'default' => '#111111',
		'sanitize_callback' => 'sanitize_hex_color', 
	));		
	// Header Background
	$wp_customize->add_control( 
	    new WP_Customize_Color_Control(
			$wp_customize,
			'atc_header_bg',
			array(
				'label' => 'Header Background',
				'section' => 'atc_colors',
				'settings' => 'atc_header_bg',
			)
		)
	);
	// Menu Background
	$wp_customize->add_control( 
	    new WP_Customize_Color_Control(
			$wp_customize,
			'atc_menu_bg',
			array(
				'label' => 'Menu Background',
				'section' => 'atc_colors',
				'settings' => 'atc_menu_bg',
			)
		)
	);	
	// Sidebar Background
	$wp_customize->add_control( 
	    new WP_Customize_Color_Control(
			$wp_customize,
			'atc_sidebar_bg',
			array(
				'label' => 'Sidebar Background',
				'section' => 'atc_colors',
				'settings' => 'atc_sidebar_bg',
			)
		)
	);
	// Content Background
	$wp_customize->add_control(
	    new WP_Customize_Color_Control(
			$wp_customize,
			'atc_content_bg',
			array(
				'label' => 'Content Background',
				'section' => 'atc_colors',
				'settings' => 'atc_content_bg',
			)
		)
	);
	// Wrapper Background
	$wp_customize->add_control( 
	    new WP_Customize_Color_Control(
			$wp_customize,
			'atc_wrapper_bg',
			array(
				'label' => 'Wrapper Background',
				'section' => 'atc_colors',
				'settings' => 'atc_wrapper_bg',
			)
		)
	);	
	// Page-Wrapper Background
	$wp_customize->add_control( 
	    new WP_Customize_Color_Control(
			$wp_customize,
			'atc_pw_bg',
			array(
				'label' => 'Page Wrapper Background',
				'section' => 'atc_colors',
				'settings' => 'atc_pw_bg',
			)
		)
	);
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function atc_customize_preview_js() {
	wp_enqueue_script( 'atc_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'atc_customize_preview_js' );