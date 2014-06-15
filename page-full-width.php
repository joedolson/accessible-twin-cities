<?php
/*

	Template: Full Width

*/ ?>
<?php get_header(); ?>

    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
		<section>
		<h1 class="page-title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>

		<div <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<?php the_content( sprintf( __( 'Finish reading <em>%s</em>', 'accessible-twin-cities' ), get_the_title() ) ); ?>
		</div> 
		<p class="edit"><?php edit_post_link('Edit this entry.', '', ''); ?></p>
		</section>

    <?php endwhile; ?>

	<?php 
		if ( comments_open() ) {
			comments_template(); 
		}
	?>


	<?php else :
	
		get_template_part( 'no-posts' );	
	
	endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>