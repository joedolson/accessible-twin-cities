<div class="searchform">
<form method="get" action="<?php echo home_url(); ?>/" role="search">
	<p>
	<label for="s" class='screen-reader-text'><?php _e( 'Search', 'universal' ); ?></label> 
	<input type="text" name="s" id="s" placeholder="<?php _e( 'Search', 'universal' ); ?>" value="<?php echo trim( get_search_query() ); ?>" /> 
	<input type="submit" name="submit" value="<?php _e( 'Search', 'universal' ); ?>" class="button" />
	</p>
</form>
</div>
