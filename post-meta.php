	<div class="meta head">
			<?php
				/*
				 *	These dashicons are hidden to screen readers. They are decorative, and we want to prevent the character 
				 *	represented from being read aloud.
				 * 
				 *  Brief meta data is presented before the article (author, format, date), but tags and categories are after the article.
				 *  This is to reduce the amount of material to pass through before reaching the actual content of the article.
				 */
			apply_filters( 'universal_article_header_meta_before','' );				 
			?>
			<span class="the-date dashicon" aria-hidden="true"></span> <?php the_time( get_option( 'date_format' ) ); ?> &bull; 
			<span class="the-author dashicon" aria-hidden="true"></span> <?php the_author_link();
			if ( get_post_format() ) { ?>
				 &bull; <span class="<?php echo get_post_format(); ?> dashicon" aria-hidden="true"></span> <a href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
			<?php } 
			apply_filters( 'universal_article_header_meta_after','' ); ?>
	</div>