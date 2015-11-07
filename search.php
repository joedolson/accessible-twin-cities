<?php get_header(); ?>

	<?php if ( have_posts() ) : ?>

		<h1><?php echo sprintf( __('Search Results for &ldquo;%s&rdquo;', 'universal' ), get_search_query() ); ?></h1>
		<div class="post-content">
			<dl id="searchresults">
			<?php while (have_posts()) : the_post(); ?>
				<dt id="list-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link( sprintf( __( 'Edit<span class="screen-reader-text"> %s</span>', 'universal' ), get_the_title() ), '&bull; (', ')' ); ?></dt>
				<dd><?php the_excerpt() ?></dd>
			<?php endwhile; ?>
			</dl>
		</div>
	<?php else :

		get_template_part( 'no-posts', 'search' );

		endif; ?>

<?php get_sidebar(); ?>
<?php get_footer(); ?>