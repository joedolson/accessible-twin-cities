			</div>
		</main>
	</div> <?php // #content .content ?>
<?php
	$atc_options = get_option( 'atc_options' );
?>
<div id="sidebar" role="complementary" class="sidebar clear">
	<?php apply_filters( 'atc_top_of_sidebar', '' ); ?>
	<div class='post-wrapper'>
	<?php 
		dynamic_sidebar( 'Global Sidebar - Top' ); 
		if ( is_front_page() ) {
			dynamic_sidebar('Home Sidebar'); 
		} 
		if ( !is_page() ) { 
			dynamic_sidebar( 'Post Sidebar' );
		} else {
			dynamic_sidebar( 'Page Sidebar' );
		}
		dynamic_sidebar( 'Global Sidebar - Bottom' );
	?>
	</div>
	<?php apply_filters( 'atc_bottom_of_sidebar', '' ); ?>	
</div>