<?php
/**
 * Comments template
 *
 * @version 1.0
 */
if ( post_password_required() ) {
	return;
} ?>
<aside aria-labelledby="aside" class="comments-area">
	<?php if ( have_comments() ) {
		if ( ! empty( $comments_by_type['comment'] ) ) {
			$comment_number = count( $comments_by_type['comment'] ); ?>
			<h2 class="comments-title" id="comments-title">
				<?php /* translators: Title for comment list. 1=comment number, 2=post title */
				printf( _n(
					'%1$s Comment on “%2$s”',
					'%1$s Comments on “%2$s”',
					$comment_number,
					'schlicht'
				), number_format_i18n( $comment_number ),
					get_the_title() ) ?>
			</h2>

			<ul class="commentlist">
				<?php wp_list_comments( array(
					'callback' => 'schlicht_comments',
					'style'    => 'ul',
					'type'     => 'comment'
				) ); ?>
			</ul>
		<?php }
		if ( ! empty( $comments_by_type['pings'] ) ) {
			$trackback_number = count( $comments_by_type['pings'] ); ?>
			<h2 class="trackbacks-title" id="trackbacks-title">
				<?php /* translators: Title for trackback list. 1=trackback number, 2=post title */
				printf( _n(
					'%1$s Trackback on “%2$s”',
					'%1$s Trackbacks on “%2$s”',
					$trackback_number,
					'schlicht'
				), number_format_i18n( $trackback_number ), get_the_title() ) ?>
			</h2>

			<ul class="commentlist">
				<?php wp_list_comments( array(
					'type'       => 'pings',
					'short_ping' => true
				) ); ?>
			</ul>
		<?php }
		the_comments_navigation();
		if ( ! comments_open() && get_comments_number() ) { ?>
			<p class="nocomments"><?php _e( 'Comments are closed.', 'schlicht' ); ?></p>
		<?php }
	}
	comment_form( array( 'label_submit' => __( 'Submit Comment', 'schlicht' ) ) ); ?>
</aside>
