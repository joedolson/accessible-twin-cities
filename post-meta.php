	<div class="meta">
			<?php
				/*
				 *	These dashicons are hidden to screen readers. They are decorative, and we want to prevent the character 
				 *	represented from being read aloud.
				 */
			?>
			<span class="the-date dashicon" aria-hidden="true"></span> <?php the_time( get_option( 'date_format' ) ); ?> &bull; 
			<span class="the-category dashicon" aria-hidden="true"></span> <?php the_category( ', ' ); ?> &bull; 
			<span class="the-author dashicon" aria-hidden="true"></span> <?php the_author_link();
			if ( get_the_tags() ) { ?> &bull; 
				<?php the_tags( '<span class="the-tags dashicon" aria-hidden="true"></span> ', ', ', '' ); 
			} 
			if ( get_post_format() ) { ?>
				 &bull; <span class="<?php echo get_post_format(); ?> dashicon" aria-hidden="true"></span> <a href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
			<?php } ?>
	</div>