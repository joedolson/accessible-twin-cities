<!DOCTYPE html>
<!--[if IE 8 ]><html <?php language_attributes(); ?> class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html <?php language_attributes(); ?> class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
<head>
	<title><?php wp_title( ' &raquo; ', true, 'right' ); ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
	<meta name="viewport" content="width=device-width" />		
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php get_template_part( 'skiplinks' ); ?>
	<div id="wrapper" class='wrapper'>
		<?php apply_filters( 'atc_before_header', '' ); ?>
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
		<?php apply_filters( 'atc_before_primary_menu', '' ); ?>		
		<div class='primary-menu'>
			<button class='menu-toggle' title='<?php _e( 'Open Menu', 'accessible-twin-cities' ); ?>'><span class="screen-reader-text"><?php _e( 'Open Menu','accessible-twin-cities' ); ?></span></button>]
			<?php
				/*
				 * Aria Label: Provides a label to differentiate multiple navigation landmarks
				 * hidden heading: provides navigational structure to site for scanning with screen reader
				 */
			?>
			<nav role="navigation" aria-label='<?php _e( 'Primary Menu ', 'accessible-twin-cities' ); ?>'>
			<h1 class="screen-reader-text"><?php _( 'Primary Menu', 'accessible-twin-cities' ); ?></h1>
			<?php wp_nav_menu( array( 'theme_location'=>'primary' ) ); ?>
			</nav>
		</div>
		<?php apply_filters( 'atc_after_primary_menu', '' ); ?>
		<div id="page" class='page-wrapper'>
			<div id="content" class="content clear" tabindex="-1">
				<main role="main">
					<div class='post-wrapper'>