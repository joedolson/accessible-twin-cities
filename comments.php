<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to atc_comment() which is
 * located in the functions.php file.
 *
 * @package WordPress
 * @subpackage Accessible Twin Cities
 * @since Accessible Twin Cities 1.0
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-wrapper">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf( _n( 'One opinion on &ldquo;%2$s&rdquo;', '%1$s opinions on &ldquo;%2$s&rdquo;', get_comments_number(), 'accessible-twin-cities' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
			?>
		</h2>

		<ol class="commentlist">
			<?php wp_list_comments( array( 'style' => 'ol', 'avatar_size'=>96 ) ); ?>
		</ol><!-- .commentlist -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<?php
		/*
		 * Add aria labelled by and a section header to provide easy access to comment navigation. 
		 * Comments label specifies what is being navigate for easy comprehension, and includes directional arrows
		 * to help cue sighted users with learning disabilities concerning the use of the links
		 */
		?>
		<nav id="comment-nav-below" class="navigation" role="navigation" aria-labelledby="comment-navigation">
			<h3 class="screen-reader-text" id="comment-navigation"><?php _e( 'Comment navigation', 'accessible-twin-cities' ); ?></h1>
			<div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'accessible-twin-cities' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'accessible-twin-cities' ) ); ?></div>
		</nav>
		<?php endif; // check for comment navigation ?>

		<?php
		/* If there are no comments and comments are closed, let's leave a note.
		 * But we only want the note on posts and pages that had comments in the first place.
		 */
		if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="nocomments"><?php _e( 'Comments are closed.' , 'accessible-twin-cities' ); ?></p>
		<?php endif; ?>

	<?php endif; // have_comments() ?>

	<?php comment_form(); ?>

</div><!-- #comments .comments-area -->