<?php get_header(); ?>

<div id="content" class="content clear">
<div class='post-wrapper'>

	<?php if ( have_posts() ) : ?>

		<h1><?php echo sprintf( __('Search Results for &ldquo;%s&rdquo;', 'accessible-twin-cities' ), get_search_query() ); ?></h1>
		<div class="post-content">
			<dl id="searchresults">
			<?php while (have_posts()) : the_post(); ?>
				<dt id="post-<?php the_ID(); ?>"><a href="<?php the_permalink() ?>" rel="bookmark"><?php the_title(); ?></a> <?php edit_post_link('Edit', '&bull; (', ')'); ?></dt>
				<dd><?php the_excerpt() ?></dd>
			<?php endwhile; ?>
			</dl>
		</div>
	<?php else :

		get_template_part( 'no-posts', 'search' );

		endif; ?>
</div>
</div>
<?php get_sidebar(); ?>
<?php get_footer(); ?>