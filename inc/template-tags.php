<?php
/**
 * Functions which are called from template files.
 *
 * @version 1.3.2
 *
 * @package Schlicht
 */

if ( ! function_exists( 'schlicht_get_custom_logo' ) ) {
	/**
	 * Get the custom logo.
	 *
	 * @return string Logo HTML or empty string.
	 */
	function schlicht_get_custom_logo() {
		// Wrap inside function_exists() to preserve back compat with WordPress versions older than 4.5.
		if ( function_exists( 'get_custom_logo' ) ) {
			// Check if we have a custom logo.
			if ( has_custom_logo() ) {
				// Return the custom logo.
				return get_custom_logo();
			}
		}

		// Return empty string, if we do not have a custom logo or WordPress is older than 4.5.
		return '';
	}
}

if ( ! function_exists( 'schlicht_the_title' ) ) {
	/**
	 * Displays the title of a post.
	 *
	 * @param string $heading Heading level.
	 * @param bool   $link    If the title should be linked to the single view.
	 */
	function schlicht_the_title( $heading, $link = true ) {
		if ( $link ) {
			the_title(
				sprintf(
					'<%1$s class="entry-title"><a href="%2$s" rel="bookmark">',
					$heading,
					esc_url( get_permalink() )
				),
				sprintf( '</a></%s>', $heading )
			);
		} else {
			the_title(
				sprintf(
					'<%1$s class="entry-title">',
					$heading,
					esc_url( get_permalink() )
				),
				sprintf( '</%s>', $heading )
			);
		}
	}
}

if ( ! function_exists( 'schlicht_the_content' ) ) {
	/**
	 * Displays the_content() with a more accessible more tag.
	 */
	function schlicht_the_content() {
		the_content(
			sprintf( /* translators: visible text for the more tag */
				'<span aria-hidden="true">%1s</span><span class="screen-reader-text">%2s</span>',
				__( 'Continue reading', 'schlicht' ),
				sprintf( /* translators: continue reading text for screen reader users. s=post title */
					__( 'Continue reading %s', 'schlicht' ),
					the_title( '', '', false )
				)
			)
		);
	}
}

if ( ! function_exists( 'schlicht_wp_link_pages' ) ) {
	/**
	 * Displays a pagination for paginated posts and pages.
	 */
	function schlicht_wp_link_pages() {
		/* translators: Label for pagination of paginated posts and pages */
		wp_link_pages(
			[
				'before'    => '<ul class="page-numbers"><li><span>' . __( 'Pages:', 'schlicht' ) . '</span></li><li>',
				'after'     => '</li></ul>',
				'separator' => '</li><li>',
			]
		);
	}
}

if ( ! function_exists( 'schlicht_the_post_meta' ) ) {
	/**
	 * Displays footer meta for a post.
	 */
	function schlicht_the_post_meta() {
		// Check if we have categories.
		if ( get_the_category() ) { ?>
			<p class="entry-footer-block categories"><span class="entry-footer-block-label">
				<?php
				// Display label in singular or plural.
				printf(
					_n( /* translators: Label for category list in entry footer. s=categories */
						'Category',
						'Categories',
						count( get_the_category() ),
						'schlicht'
					)
				)
				?>
				<span class="screen-reader-text">:</span></span>
				<?php
				// Display the category list.
				/* translators: term delimiter */
				echo get_the_category_list( __( ', ', 'schlicht' ) );
				?>
			</p>
			<?php
		}

		// Check if we have tags.
		if ( get_the_tags() ) {
			?>
			<p class="entry-footer-block tags"><span class="entry-footer-block-label">
				<?php
				// Display label in singular or plural.
				printf(
					_n( /* translators: Label for tags list in entry footer. */
						'Tag',
						'Tags',
						count( get_the_tags() ),
						'schlicht'
					)
				)
				?>
				<span class="screen-reader-text">:</span></span>
				<?php
				// Display the tag list.
				/* translators: term delimiter */
				echo get_the_tag_list( '', __( ', ', 'schlicht' ) );
				?>
			</p>
			<?php
		}

		// Get the post reactions by type.
		$comments_by_type = schlicht_get_comments_by_type();

		// Check if we have comments.
		if ( $comments_by_type['comment'] ) {
			// Count the comments.
			$comment_number = count( $comments_by_type['comment'] );
			?>
			<p class="entry-footer-block comments"><span class="entry-footer-block-label">
				<?php
				/* translators: Label for comment number in entry footer. */
				_e( 'Comments', 'schlicht' );
				?>
				<span class="screen-reader-text">:</span></span>
				<a href="<?php the_permalink(); ?>#comments-title">
					<?php
					// Display the comments number in the correct internationalized format for the site’s locale.
					/* translators: term delimiter */
					echo number_format_i18n( $comment_number );
					?>
				</a>
			</p>
			<?php
		}

		// Check if we have pings.
		if ( $comments_by_type['pings'] ) {
			// Count the pings.
			$trackback_number = count( $comments_by_type['pings'] );
			?>
			<p class="entry-footer-block trackbacks"><span class="entry-footer-block-label">
				<?php
				/* translators: Label for trackback number in entry footer. */
				_e( 'Trackbacks', 'schlicht' );
				?>
				<span class="screen-reader-text">:</span></span>
				<a href="<?php the_permalink(); ?>#trackbacks-title">
					<?php
					// Display the pings number in the correct internationalized format for the site’s locale.
					/* translators: term delimiter */
					echo number_format_i18n( $trackback_number );
					?>
				</a>
			</p>
			<?php
		};
	}
}

if ( ! function_exists( 'schlicht_get_comments_by_type' ) ) {
	/**
	 * Gets the reactions seperated by type.
	 *
	 * @return array Post reactions separated by type.
	 */
	function schlicht_get_comments_by_type() {
		$comment_args     = [
			'order'   => 'ASC',
			'orderby' => 'comment_date_gmt',
			'status'  => 'approve',
			'post_id' => get_the_ID(),
		];
		$comments         = get_comments( $comment_args );
		$comments_by_type = separate_comments( $comments );

		return $comments_by_type;
	}
}

if ( ! function_exists( 'schlicht_comments' ) ) {
	/**
	 * Callback function for displaying the comment list.
	 *
	 * @param object $comment WP_Comment object.
	 * @param array  $args    Array of arguments.
	 * @param int    $depth   Depth of comment.
	 */
	function schlicht_comments( $comment, $args, $depth ) {
		?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-meta">
				<?php echo get_avatar( $comment, 50 ); ?>
				<p class="comment-author-name">
					<?php
					// Display the name of the comment author. Linked to the site he submitted in the Website field.
					comment_author_link();
					?>
				</p>

				<?php
				// Display the comment date, linked to the comment’s permalink.
				printf(
					'<p class="comment-date"><a href="%1$s"><time datetime="%2$s">%3$s</time></a></p>',
					get_comment_link( $comment->comment_ID ),
					get_comment_time( 'c' ),
					/* translators: 1=date 2=time */
					sprintf( __( '%1$s @ %2$s', 'schlicht' ), get_comment_date(), get_comment_time() )
				);
				?>
			</div>

			<?php
			// Check if the comment is not approved yet.
			if ( '0' === $comment->comment_approved ) {
				?>
				<p class="comment-awaiting-moderation">
					<?php _e( 'Your comment is awaiting moderation.', 'schlicht' ); ?>
				</p>
			<?php } ?>

			<div class="comment-content-wrapper">
				<div class="comment-content">
					<?php
					// Display the comment text.
					comment_text();

					// Display the edit link (only visible for users with the right capabilities).
					edit_comment_link( __( 'Edit', 'schlicht' ), '<p class="edit-link">', '</p>' );
					?>
				</div>
			</div>

			<div class="reply">
				<?php
				// Display the reply link.
				comment_reply_link(
					[
						'reply_text' => __( 'Reply', 'schlicht' ),
						'depth'      => $depth,
						'max_depth'  => $args['max_depth'],
					]
				);
				?>
			</div>
		</div>
		<?php
	}
}
