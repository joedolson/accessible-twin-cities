<?php get_header(); ?>

    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
	<div <?php post_class(); ?>>
		<?php
			$format = get_post_format();
			if ( $format === false ) {
				$format = 'format';
			}
			get_template_part( 'format', $format );
		?>	
		<div class="comments">
			<?php 
				$args = array( 
							'before'=>'<p class="paginated">',
							'next_or_number' => 'next',
							'nextpagelink' => 'Next Page<span class="dashicon nextpage" aria-hidden="true"></span>',
							'previouspagelink' => '<span class="dashicon prevpage" aria-hidden="true"></span>Previous Page'
						);
				wp_link_pages( $args ); 
			?>
			<?php comments_popup_link( __( 'Comments (0)', 'accessible-twin-cities' ), __( 'Comments (1)', 'accessible-twin-cities' ), __( 'Comments (%)', 'accessible-twin-cities' ) ); ?>

		</div>
	</div>
    <?php endwhile; ?>

	<?php comments_template(); ?>

    <?php else : 
	
			get_template_part( 'no-posts' );
	
	endif; ?>

    <div class="prev_next">
    <?php posts_nav_link( '&nbsp; &nbsp;', __( '&larr; Previous Posts','accessible-twin-cities' ), __( 'Next Posts &rarr;','accessible-twin-cities' ) ); ?>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>