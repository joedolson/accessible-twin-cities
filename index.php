<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>
	<?php if ( !is_singular() ) { ?>
		<h1 class="screen-reader-text"><?php atc_archive_title(); ?></h1>
	<?php } ?>
    <?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class(); ?>>
		<?php
			$format = get_post_format();
			if ( $format === false ) {
				$format = 'format';
			}
			get_template_part( 'format', $format );
		?>	
		<div class="comments">
			<?php wp_link_pages(); ?>
			<?php comments_popup_link( __( 'Comments (0)', 'accessible-twin-cities' ), __( 'Comments (1)', 'accessible-twin-cities' ), __( 'Comments (%)', 'accessible-twin-cities' ) ); ?>
		</div>

		<?php
		/* Only render trackback_rdf when appropriate and allowed */
		if ( is_single() ) {
			echo '<!--';
			trackback_rdf();
			echo '-->' . "\n";
		}
		?>
	</div>
    <?php endwhile; ?>

	<?php comments_template(); ?>

    <?php else : 
	
			get_template_part( 'no-posts' );
	
	endif; ?>

    <div class="prev_next">
    <?php posts_nav_link( ' <span aria-hidden="true">&bull;</span> ', sprintf( __( '%s Previous Posts','accessible-twin-cities' ), '<span aria-hidden="true">&larr;</span>' ), sprintf( __( 'Next Posts %s','accessible-twin-cities' ), '<span aria-hidden="true">&rarr;</span>' ) ); ?>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>