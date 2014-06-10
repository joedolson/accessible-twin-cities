			</div>
		</main>
	</div> <?php // #content .content ?>
<?php
	$atc_options = get_option( 'atc_options' );
?>
<div id="sidebar" role="complementary" class="sidebar clear">
	<?php apply_filters( 'atc_top_of_sidebar', '' ); ?>
	<?php if ( is_front_page() ) {
		$sidebars = wp_get_sidebars_widgets();
		$home_sidebar = $sidebars['ps2'];
		$count = count( $home_sidebar );
		$class = " widgets-$count";
	} else {
		$class = "widgets";
	}	?>
	<div class='post-wrapper<?php echo $class; ?>'>
	<?php 
		/* Home sidebar displayed only on home page. Global sidebars on all other pages. */
		if ( is_front_page() ) {
		
			dynamic_sidebar('Home Sidebar'); 
			
		} else {
		
			dynamic_sidebar( 'Global Sidebar - Top' ); 
			if ( !is_page() ) { 
				dynamic_sidebar( 'Post Sidebar' );
			} else {
				dynamic_sidebar( 'Page Sidebar' );
			}
			dynamic_sidebar( 'Global Sidebar - Bottom' );	
			
		}
	?>
	</div>
	<?php apply_filters( 'atc_bottom_of_sidebar', '' ); ?>	
</div>