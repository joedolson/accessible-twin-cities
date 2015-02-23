<?php

add_action( 'comment_post', 'universal_ajax_comments', 20, 2 );
/**
 * Provide responses to comments.js based on detecting an XMLHttpRequest parameter.
 *
 * @param $comment_ID     ID of new comment.
 * @param $comment_status Status of new comment. 
 *
 * @return echo JSON encoded responses with HTML structured comment, success, and status notice.
 */
function universal_ajax_comments( $comment_ID, $comment_status ) {
	if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) {
		// This is an AJAX request. Handle response data. 
		switch ( $comment_status ) {
			case '0':
				// Comment needs moderation; notify comment moderator.
				wp_notify_moderator( $comment_ID );
				$return = array( 
					'response' => '', 
					'success'  => 1, 
					'status'   => __( 'Your comment has been sent for moderation. It should be approved soon!', 'universal' ) 
				);
				wp_send_json( $return );
				break;
			case '1':
				// Approved comment; generate comment output and notify post author.
				$comment            = get_comment( $comment_ID );
				$comment_class      = comment_class( 'universal-ajax-comment', $comment_ID, $comment->comment_post_ID, false );
				
				$comment_output     = '
						<li id="comment-' . $comment->comment_ID . '"' . $comment_class . ' tabindex="-1">
							<article id="div-comment-' . $comment->comment_ID . '" class="comment-body">
								<footer class="comment-meta">
								<div class="comment-author vcard">'.
									get_avatar( $comment->comment_author_email )
									.'<b class="fn">' . __( 'You said:', 'universal' ) . '</b> </div>

								<div class="comment-meta commentmetadata"><a href="#comment-'. $comment->comment_ID .'">' . 
									get_comment_date( 'F j, Y \a\t g:i a', $comment->comment_ID ) .'</a>
								</div>
								</footer>
								
								<div class="comment-content">' . $comment->comment_content . '</div>
							</article>
						</li>';
				
				if ( $comment->comment_parent == 0 ) {
					$output = $comment_output;
				} else {
					$output = "<ul class='children'>$comment_output</ul>";
				}

				wp_notify_postauthor( $comment_ID );
				$return = array( 
					'response'=>$output, 
					'success' => 1, 
					'status'=> sprintf( __( 'Thanks for commenting! Your comment has been approved. <a href="%s">Read your comment</a>', 'universal' ), "#comment-$comment_ID" ) 
				);
				wp_send_json( $return );
				break;
			default:
				// The comment status was not a valid value. Only 0 or 1 should be returned by the comment_post action.
				$return = array( 
					'response' => '', 
					'success'  => 0, 
					'status'   => __( 'There was an error posting your comment. Try again later!', 'universal' ) 
				);
				wp_send_json( $return );
		}
	}
}