<?php
/*
Template Name: Sidebar Right
*/ 
get_header(); 
?>

    <?php if (have_posts()) : ?>
    <?php while (have_posts()) : the_post(); ?>
		<section>
		<?php if ( has_post_thumbnail() ) { ?>
			<div class='featured-image'><?php the_post_thumbnail(); ?></div>
		<?php } ?>		
		<h1 class="page-title" id="title-<?php the_ID(); ?>"><?php the_title(); ?></h1>

		<div <?php post_class( 'post-content' ); ?> id="post-<?php the_ID(); ?>">
		<?php the_content( sprintf( __( 'Finish reading <em>%s</em>', 'universal' ), get_the_title() ) ); ?>
		</div> 
		<?php edit_post_link( sprintf( __( 'Edit %s', 'universal' ), get_the_title() ), '<p class="edit">', '</p>' ); ?>
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