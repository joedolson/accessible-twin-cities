<!DOCTYPE html>
<?php
/*
 *	Define the language and text direction in your HTML element.
 *	The WP function language_attributes() handles this, and makes sure that text is pronounced correctly in screen reading software.
 */
?>
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<title><?php wp_title( ' &raquo; ', true, 'right' ); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<?php 
		/*
		 *	The important thing in the viewport is what's not here: zoom control. Limiting or disallowing zoom on mobile prevents
		 * 	visitors from being able to enlarge your content (text or images) for a better reading or viewing experience.
		 */
	?>
	<meta name="viewport" content="width=device-width" />		
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php get_template_part( 'skiplinks' ); ?>
	<div id="wrapper" class='wrapper'>
		<?php 
		/*
		 *	Filters that allow adding content outside of a defined landmark role include the _role suffix.
		 *	When adding readable content to one of these filters, you must provide a role for that content. 
		 * 	Most of the time, role=complementary will be most appropriate, but each case should be treated differently.
		 */
		?>
		<?php apply_filters( 'atc_before_header_role', '' ); ?>
		<div id="header" class='header'>
			<header role="banner">
				<?php apply_filters( 'atc_top_of_header', '' ); ?>								
				<div class="text-header">
					<div class='site-title'><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></div>
					<div class='site-description'><?php bloginfo('description'); ?></div>
				</div>
				<?php apply_filters( 'atc_end_of_header', '' ); ?>	
			</header>
		</div>
		<?php apply_filters( 'atc_before_primary_menu_role', '' ); ?>		
		<div class='primary-menu'>
			<?php
				/*
				 * Aria Label: Provides a label to differentiate multiple navigation landmarks
				 * hidden heading: provides navigational structure to site for scanning with screen reader
				 */
			?>
			<nav role="navigation" aria-label='<?php _e( 'Primary Menu ', 'accessible-twin-cities' ); ?>'>
			<h1 class="screen-reader-text"><?php _e( 'Primary Menu', 'accessible-twin-cities' ); ?></h1>
			<button class='menu-toggle' title='<?php _e( 'Open Menu', 'accessible-twin-cities' ); ?>'><span class="screen-reader-text"><?php _e( 'Open Menu','accessible-twin-cities' ); ?></span></button>			
			<?php wp_nav_menu( array( 'theme_location'=>'primary' ) ); ?>
			</nav>
		</div>
		<?php apply_filters( 'atc_after_primary_menu_role', '' ); ?>
		<div id="page" class='page-wrapper clear'>
			<div id="content" class="content clear" tabindex="-1">
				<main role="main">
					<div class='post-wrapper'>
					<?php apply_filters( 'atc_before_posts', '' ); ?>