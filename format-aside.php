<?php
/*
 * Aside Post Format
 */
?>
<article>
	<div class='aside-format'>
	<?php if ( has_post_thumbnail() ) { ?>
		<div class='featured-image'><?php the_post_thumbnail(); ?></div>
	<?php }
		/* 
		 * Handles posts without titles 
		 */
		$post_link = ''; 
		if ( get_the_title() == '' && !is_single() ) {
			$post_link = wpautop( sprintf( __( '<a href="%s" rel="bookmark">View untitled aside</a>', 'universal' ), get_the_permalink() ) );
		}
		if ( get_the_title() != '' ) {
			if ( is_single() ) { ?>
				<h1 class="post-title" id="post-<?php the_ID(); ?>"><?php the_title(); ?></h1>
			<?php } else { ?>
				<h2 class="post-title" id="post-<?php the_ID(); ?>"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
			<?php }
		}
		get_template_part( 'post-meta' ); ?>
		<div class='post-content' id="post-<?php the_ID(); ?>">
			<?php 
			if ( universal_show_excerpt() ) { 
				the_excerpt();
			} else {
				the_content( sprintf( __( 'Finish reading <em>%s</em>', 'universal' ), get_the_title() ) ); 
			}	
			?>
			<?php echo $post_link; ?>
			<?php edit_post_link('Edit this entry.', '<p class="edit">', '</p>'); ?>
		</div> 
		<?php get_template_part( 'post-meta-tags' ); ?>
		<!--
		<?php trackback_rdf(); ?>
		-->
	</div>
</article>