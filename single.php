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
			<?php comments_popup_link( __( 'Comments (0)', 'universal' ), __( 'Comments (1)', 'universal' ), __( 'Comments (%)', 'universal' ) ); ?>

		</div>
	</div>
    <?php endwhile; ?>

	<?php comments_template(); ?>

    <?php else : 
	
			get_template_part( 'no-posts' );
	
	endif; ?>

    <div class="prev_next">
    <?php posts_nav_link( ' <span aria-hidden="true">&bull;</span> ', sprintf( __( '%s Previous Post','universal' ), '<span aria-hidden="true">&larr;</span>' ), sprintf( __( 'Next Post %s','universal' ), '<span aria-hidden="true">&rarr;</span>' ) ); ?>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>