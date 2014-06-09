	<div class="meta">
			<span class="the-date dashicon"></span> <?php the_time( get_option( 'date_format' ) ); ?> &bull; 		
			<span class="the-category dashicon"></span> <?php the_category( ', ' ); ?> &bull; 
			<span class="the-author dashicon"></span> <?php the_author_link();
			if ( get_the_tags() ) { ?> &bull; 
				<?php the_tags( '<span class="the-tags dashicon"></span> ', ', ', '' ); 
			} ?>
	</div>