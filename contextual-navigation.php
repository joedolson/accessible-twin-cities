<?php if ( get_the_title( $post->post_parent ) != the_title( '' , '',false ) || wp_list_pages( "child_of=".$post->ID."&echo=0" ) ) { ?>
<div class="navigation block">
<?php if ( is_404() ) { ?>
<h2>Site Map</h2>
<?php } else { ?>
<h2>In This Section</h2>
<?php } ?>
<ul>
<?php }
if( get_the_title( $post->post_parent ) != the_title( '' , '',false ) ) {
	wp_list_pages( "child_of=".$post->post_parent."&title_li=&sort_column=menu_order" );
}
if( wp_list_pages( "child_of=".$post->ID."&echo=0" ) ) {
	wp_list_pages( "title_li=&child_of=".$post->ID."&sort_column=menu_order" );
} 
if ( get_the_title( $post->post_parent ) != the_title( '' , '',false ) || wp_list_pages( "child_of=".$post->ID."&echo=0" ) ) { ?>
</ul>
</div>
<?php } ?>