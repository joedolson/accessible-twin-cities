<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>
	<?php if ( !is_singular() ) { ?>
		<h1 class="screen-reader-text"><?php _e( 'Posts','accessible-twin-cities' ); ?></h1>
	<?php } ?>
    <?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class(); ?>>
		<?php if ( has_post_thumbnail() ) { ?>
			<div class='featured-image'><?php the_post_thumbnail(); ?></div>
		<?php }
			/* Handles posts without titles */
			$post_link = ''; 
			if ( get_the_title() == '' ) {
				$post_link = wpautop( sprintf( __( '<a href="%s" rel="bookmark">View untitled post</a>', 'accessible-twin-cities' ), get_the_permalink() ) );
			} else {
		?>
		<h2 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h2>
		<?php 
			}	
			get_template_part( 'post-meta' ); ?>
		<div class='post-content' id="post-<?php the_ID(); ?>">
			<?php the_content( sprintf( __( 'Finish reading <em>%s</em>', 'accessible-twin-cities' ), get_the_title() ) ); ?>
			<?php echo $post_link; ?>
			<?php edit_post_link('Edit this entry.', '<p class="edit">', '</p>'); ?>
		</div> 

		<div class="comments">
			<?php wp_link_pages(); ?>
			<?php comments_popup_link( __( 'Comments (0)', 'accessible-twin-cities' ), __( 'Comments (1)', 'accessible-twin-cities' ), __( 'Comments (%)', 'accessible-twin-cities' ) ); ?>
		</div>

		<!--
		<?php trackback_rdf(); ?>
		-->
	</div>
    <?php endwhile; ?>

	<?php comments_template(); ?>

    <?php else : 
	
			get_template_part( 'no-posts' );
	
	endif; ?>

    <div class="prev_next">
    <?php posts_nav_link('&nbsp; &nbsp;', __( '&larr; Previous Posts','accessible-twin-cities' ), __( 'Next Posts &rarr;','accessible-twin-cities' ) ); ?>
    </div>

<?php get_sidebar(); ?>
<?php get_footer(); ?>