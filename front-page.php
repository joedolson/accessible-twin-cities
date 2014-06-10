<?php get_header(); ?>

    <?php if ( have_posts() ) : ?>
    <?php while ( have_posts() ) : the_post(); ?>
	<div <?php post_class(); ?>>
		<section>
		<div class='featured-image'><?php the_post_thumbnail(); ?></div>
		<?php
			$post_link = ''; 
			if ( get_the_title() == '' ) {
				$post_link = wpautop( sprintf( __( '<a href="%s" rel="bookmark">View untitled post</a>', 'accessible-twin-cities' ), get_the_permalink() ) );
			} else {
		?>
		<?php 
			}
			if ( is_page() ) { ?>
			
				<h1 class="post-title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
				<div class='post-content' id="post-<?php the_ID(); ?>">
					<?php the_content( sprintf( __( 'Finish reading <em>%s</em>', 'accessible-twin-cities' ), get_the_title() ) ); ?>
					<?php echo $post_link; ?>
					<?php edit_post_link('Edit this entry.', '<p class="edit">', '</p>'); ?>			
				</div> 
				
			<?php
			} else { ?>
				<h1 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a></h1>
				<?php
				get_template_part( 'post-meta' ); ?>

				<div class='post-content' id="post-<?php the_ID(); ?>">
					<?php the_excerpt(); ?>
					<?php echo $post_link; ?>
					<?php edit_post_link('Edit this entry.', '<p class="edit">', '</p>'); ?>			
				</div> 

				<!--
				<?php trackback_rdf(); ?>
				--><?php
			} ?>
		</section>
	</div>
    <?php endwhile; ?>

    <?php else : 
		
		get_template_part( 'no-posts' );
	
	endif; ?>

	<div class="prev_next">
    <?php posts_nav_link('&nbsp; &nbsp;', __( '&larr; Previous Posts','accessible-twin-cities' ), __( 'Next Posts &rarr;','accessible-twin-cities' ) ); ?>
	</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
