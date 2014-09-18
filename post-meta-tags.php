	<div class="meta foot">
			<?php
				/*
				 *	These dashicons are hidden to screen readers. They are decorative, and we want to prevent the character 
				 *	represented from being read aloud.
				 */
			echo apply_filters( 'universal_article_footer_meta_before','' );				 
			?>
			<span class="the-category dashicon" aria-hidden="true"></span> <?php _e('Categories:','universal'); ?> <?php the_category( ', ' ); ?>
			<?php
			if ( get_the_tags() ) { ?> &bull; 
				<?php _e('Tags:','universal'); ?>
				<?php the_tags( '<span class="the-tags dashicon" aria-hidden="true"></span> ', ', ', '' ); 
			} 
			echo apply_filters( 'universal_article_footer_meta_after','' ); ?>
	</div>