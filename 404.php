<?php get_header(); ?>

		<div class="post-content">
			<h1><?php _e( 'Error: Page not found!', 'accessible-twin-cities' ); ?></h1>
			<p>
			<?php _e( 'Sorry, the page you requested could not be located.', 'accessible-twin-cities' ); ?>
			</p>
			<p>
			<?php _e( 'Thanks for your patience!', 'accessible-twin-cities' ); ?>
			</p>
			<p>
			<?php bloginfo( 'author' ); ?>
			</p>
		</div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>