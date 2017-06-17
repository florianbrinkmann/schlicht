<?php
/**
 * Functions file
 *
 * @package Schlicht
 */

if ( ! function_exists( 'schlicht_load_translation' ) ) {
	/**
	 * Load translation.
	 */
	function schlicht_load_translation() {
		/**
		 * Check if:
		 * - we do not have an AJAX call.
		 * - we are not on the login page.
		 * - we are not on the wp-comments-post.php.
		 */
		if ( ( ! defined( 'DOING_AJAX' ) && ! 'DOING_AJAX' ) || ! schlicht_is_login_page() || ! schlicht_is_wp_comments_post() ) {
			/**
			 * Load the translation.
			 */
			load_theme_textdomain( 'schlicht', get_theme_file_path() . '/languages' );
		}
	}
} // End if().

if ( ! function_exists( 'schlicht_is_login_page' ) ) {
	/**
	 * Check if we are on the login page.
	 *
	 * @return bool true if on login page, otherwise false.
	 */
	function schlicht_is_login_page() {
		return in_array( $GLOBALS['pagenow'], [ 'wp-login.php', 'wp-register.php' ], true );
	}
}

if ( ! function_exists( 'schlicht_is_wp_comments_post' ) ) {
	/**
	 * Check if we are on the wp-comments-post.php.
	 *
	 * @return bool true if on wp-comments.-post.php, otherwise false.
	 */
	function schlicht_is_wp_comments_post() {
		return in_array( $GLOBALS['pagenow'], [ 'wp-comments-post.php' ], true );
	}
}

/**
 * Set content width to 791 px
 */
if ( ! isset( $content_width ) ) {
	$content_width = 791;
}

if ( ! function_exists( 'schlicht_add_theme_support' ) ) {
	/**
	 * Adds theme support for feed links, custom head, html5, post formats, post thumbnails, title element and custom logo.
	 */
	function schlicht_add_theme_support() {
		/**
		 * Add theme support for the custom header feature.
		 */
		add_theme_support( 'custom-header' );

		/**
		 * Add theme support for automatic feed links (like post feed, comments feed, …).
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Add theme support for title tag.
		 */
		add_theme_support( 'title-tag' );

		/**
		 * Add theme support for post formats.
		 */
		add_theme_support( 'post-formats', [
			'aside',
			'link',
			'gallery',
			'status',
			'quote',
			'image',
			'video',
			'audio',
			'chat',
		] );

		/**
		 * Add theme support for HTML5 markup for core components.
		 */
		add_theme_support( 'html5', [
			'comment-list',
			'comment-form',
			'search-form',
			'gallery',
			'caption',
		] );

		/**
		 * Add theme support for post thumbnails.
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add theme support for custom logo feature.
		 */
		add_theme_support( 'custom-logo' );
	}
} // End if().

if ( ! function_exists( 'schlicht_add_editor_style' ) ) {
	/**
	 * Adds stylesheet for Tiny MCE editor in the backend.
	 */
	function schlicht_add_editor_style() {
		/**
		 * Get the value of the Vollkorn font customizer option.
		 */
		$vollkorn_font = get_theme_mod( 'schlicht_vollkorn_font', false );

		/**
		 * Check if Vollkorn option is disabled.
		 */
		if ( false === $vollkorn_font ) {
			/**
			 * Include editor styles with default font Sorts Mill Goudy.
			 */
			if ( is_rtl() ) {
				add_editor_style( 'css/editor-style-rtl.css' );
			} else {
				add_editor_style( 'css/editor-style.css' );
			}
		} else {
			/**
			 * Include editor styles with Vollkorn font.
			 */
			if ( is_rtl() ) {
				add_editor_style( 'css/editor-style-vollkorn-rtl.css' );
			} else {
				add_editor_style( 'css/editor-style-vollkorn.css' );
			}
		}
	}
} // End if().

if ( ! function_exists( 'schlicht_register_menus' ) ) {
	/**
	 * Register Menus.
	 */
	function schlicht_register_menus() {
		register_nav_menus(
			[
				/* translators: Name of menu position in the header */
				'primary' => __( 'Primary Menu', 'schlicht' ),
				/* translators: Name of menu position in the footer */
				'footer'  => __( 'Footer Menu', 'schlicht' ),
			]
		);
	}
} // End if().

if ( ! function_exists( 'schlicht_register_sidebars' ) ) {
	/**
	 * Register sidebar.
	 */
	function schlicht_register_sidebars() {
		/**
		 * Register the main sidebar.
		 */
		register_sidebar( [
			'name'          => __( 'Main Sidebar', 'schlicht' ),
			'id'            => 'sidebar-1',
			'description'   => __( 'Widgets in this area will be displayed on all posts and pages by default.', 'schlicht' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );

		/**
		 * Register the footer widget area.
		 */
		register_sidebar( [
			'name'          => __( 'Footer Sidebar', 'schlicht' ),
			'id'            => 'sidebar-footer',
			'description'   => __( 'Widgets will be displayed in the footer.', 'schlicht' ),
			'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		] );
	}
} // End if().

if ( ! function_exists( 'schlicht_scripts_styles' ) ) {
	/**
	 * Adds the scripts and styles to the header.
	 */
	function schlicht_scripts_styles() {
		/**
		 * Check if:
		 * - singular view.
		 * - comments are open.
		 * - Threaded comments are enabled.
		 */
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			/**
			 * Enqueue comment-reply script.
			 */
			wp_enqueue_script( 'comment-reply' );
		}

		/**
		 * Get value of Vollkorn customizer option.
		 */
		$vollkorn_font = get_theme_mod( 'schlicht_vollkorn_font', false );

		/**
		 * Check if Vollkorn option is disabled.
		 */
		if ( false === $vollkorn_font ) {
			/**
			 * Include default style.
			 */
			if ( is_rtl() ) {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri() . '/css/schlicht-rtl.css', [], null );
			} else {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri() . '/css/schlicht.css', [], null );
			}
		} else {
			/**
			 * Include Vollkorn style.
			 */
			if ( is_rtl() ) {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri() . '/css/schlicht-vollkorn-rtl.css', [], null );
			} else {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri() . '/css/schlicht-vollkorn.css', [], null );
			}
		}
	}
} // End if().

if ( ! function_exists( 'schlicht_admin_script' ) ) {
	/**
	 * Include admin script.
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	function schlicht_admin_script( $hook_suffix ) {
		/**
		 * Check for post or page edit page.
		 */
		if ( 'post.php' === $hook_suffix ) {
			/**
			 * Include the editor functions js.
			 */
			wp_enqueue_script( 'schlicht_editor-functions', get_theme_file_uri( 'js/backend-editor-functions.js' ), [], false, true );

		}
	}
} // End if().

if ( ! function_exists( 'schlicht_remove_more_link_scroll' ) ) {
	/**
	 * Removes the page jump after clicking on a read more link.
	 *
	 * @param string $link Post URL.
	 *
	 * @return string Link without more hash.
	 */
	function schlicht_remove_more_link_scroll( $link ) {
		/**
		 * Remove more hash from URL.
		 */
		$link = preg_replace( '/#more-[0-9]+/', '', $link );

		return $link;
	}
} // End if().

if ( ! function_exists( 'schlicht_get_custom_logo' ) ) {
	/**
	 * Get the custom logo.
	 *
	 * @return string Logo HTML or empty string.
	 */
	function schlicht_get_custom_logo() {
		/**
		 * Wrap inside function_exists() to preserve back compat with WordPress versions older than 4.5.
		 */
		if ( function_exists( 'get_custom_logo' ) ) {
			/**
			 * Check if we have a custom logo.
			 */
			if ( has_custom_logo() ) {
				/**
				 * Return the custom logo.
				 */
				return get_custom_logo();
			}
		}

		/**
		 * Return empty string, if we do not have a custom logo or WordPress is older than 4.5.
		 */
		return '';
	}
} // End if().

if ( ! function_exists( 'schlicht_the_title' ) ) {
	/**
	 * Displays the title of a post.
	 *
	 * @param string $heading Heading level.
	 * @param bool   $link    If the title should be linked to the single view.
	 */
	function schlicht_the_title( $heading, $link = true ) {
		if ( $link ) {
			the_title( sprintf(
				'<%1$s class="entry-title"><a href="%2$s" rel="bookmark">',
				$heading, esc_url( get_permalink() )
			), sprintf( '</a></%s>', $heading ) );
		} else {
			the_title( sprintf(
				'<%1$s class="entry-title">',
				$heading, esc_url( get_permalink() )
			), sprintf( '</%s>', $heading ) );
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
		wp_link_pages( [
			'before'    => '<ul class="page-numbers"><li><span>' . __( 'Pages:', 'schlicht' ) . '</span></li><li>',
			'after'     => '</li></ul>',
			'separator' => '</li><li>',
		] );
	}
}

if ( ! function_exists( 'schlicht_the_post_meta' ) ) {
	/**
	 * Displays footer meta for a post.
	 */
	function schlicht_the_post_meta() {
		/**
		 * Check if we have categories.
		 */
		if ( get_the_category() ) { ?>
			<p class="entry-footer-block categories"><span class="entry-footer-block-label">
				<?php
				/**
				 * Display label in singular or plural.
				 */
				printf( _n( /* translators: Label for category list in entry footer. s=categories */
					'Category',
					'Categories',
					count( get_the_category() ),
					'schlicht'
				) )
				?><span class="screen-reader-text">:</span></span>
				<?php
				/**
				 * Display the category list.
				 */
				/* translators: term delimiter */
				echo get_the_category_list( __( ', ', 'schlicht' ) ); ?>
			</p>
		<?php }

		/**
		 * Check if we have tags.
		 */
		if ( get_the_tags() ) { ?>
			<p class="entry-footer-block tags"><span class="entry-footer-block-label">
				<?php
				/**
				 * Display label in singular or plural.
				 */
				printf( _n( /* translators: Label for tags list in entry footer. */
					'Tag',
					'Tags',
					count( get_the_tags() ),
					'schlicht'
				) )
				?><span class="screen-reader-text">:</span></span>
				<?php
				/**
				 * Display the tag list.
				 */
				/* translators: term delimiter */
				echo get_the_tag_list( '', __( ', ', 'schlicht' ) ); ?>
			</p>
		<?php }

		/**
		 * Get the post reactions by type.
		 */
		$comments_by_type = schlicht_get_comments_by_type();

		/**
		 * Check if we have comments.
		 */
		if ( $comments_by_type['comment'] ) {
			/**
			 * Count the comments.
			 */
			$comment_number = count( $comments_by_type['comment'] ); ?>
			<p class="entry-footer-block comments"><span class="entry-footer-block-label">
				<?php /* translators: Label for comment number in entry footer. */
				_e( 'Comments', 'schlicht' );
				?><span class="screen-reader-text">:</span></span>
				<a href="<?php the_permalink(); ?>#comments-title">
					<?php
					/**
					 * Display the comments number in the correct internationalized format for the site’s locale.
					 */
					/* translators: term delimiter */
					echo number_format_i18n( $comment_number ); ?>
				</a>
			</p>
		<?php }

		/**
		 * Check if we have pings.
		 */
		if ( $comments_by_type['pings'] ) {
			/**
			 * Count the pings.
			 */
			$trackback_number = count( $comments_by_type['pings'] ); ?>
			<p class="entry-footer-block trackbacks"><span class="entry-footer-block-label">
				<?php /* translators: Label for trackback number in entry footer. */
				_e( 'Trackbacks', 'schlicht' );
				?><span class="screen-reader-text">:</span></span>
				<a href="<?php the_permalink(); ?>#trackbacks-title">
					<?php
					/**
					 * Display the pings number in the correct internationalized format for the site’s locale.
					 */
					/* translators: term delimiter */
					echo number_format_i18n( $trackback_number ); ?>
				</a>
			</p>
		<?php };
	}
} // End if().

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

if ( ! function_exists( 'schlicht_body_classes' ) ) {
	/**
	 * Adds class to body if sidebar is used and other class if alternate
	 * post layout is enabled.
	 *
	 * @return array Array of body classes.
	 */
	function schlicht_body_classes( $classes ) {
		/**
		 * Check if we have an active sidebar and we are not on a page with the »No sidebar« template.
		 */
		if ( is_active_sidebar( 'sidebar-1' ) && get_page_template_slug() !== 'page-templates/no-sidebar.php' ) {
			/**
			 * Add sidebar-template class to the classes array.
			 */
			$classes[] = 'sidebar-template';
		}

		/**
		 * Get the customizer option value for alternative layout.
		 */
		$alternate_post_layout_option = get_theme_mod( 'schlicht_alternate_post_layout', false );

		/**
		 * Check if the alternative layout is active and no widget is in the sidebar.
		 */
		if ( true === $alternate_post_layout_option && ! is_active_sidebar( 'sidebar-1' ) ) {
			/**
			 * Add alternate-layout class to the classes array.
			 */
			$classes[] = 'alternate-layout';
		}

		return $classes;
	}
} // End if().

if ( ! function_exists( 'schlicht_comments' ) ) {
	/**
	 * Callback function for displaying the comment list.
	 *
	 * @param object $comment WP_Comment object.
	 * @param array  $args    Array of arguments.
	 * @param int    $depth   Depth of comment.
	 */
	function schlicht_comments( $comment, $args, $depth ) { ?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<div id="comment-<?php comment_ID(); ?>">
			<div class="comment-meta">
				<?php echo get_avatar( $comment, 50 ); ?>
				<p class="comment-author-name">
					<?php
					/**
					 * Display the name of the comment author. Linked to the site he submitted in the Website field.
					 */
					comment_author_link(); ?>
				</p>

				<?php
				/**
				 * Display the comment date, linked to the comment’s permalink.
				 */
				printf(
					'<p class="comment-date"><a href="%1$s"><time datetime="%2$s">%3$s</time></a></p>',
					get_comment_link( $comment->comment_ID ),
					get_comment_time( 'c' ),
					/* translators: 1=date 2=time */
					sprintf( __( '%1$s @ %2$s', 'schlicht' ), get_comment_date(), get_comment_time() )
				); ?>
			</div>

			<?php
			/**
			 * Check if the comment is not approved yet.
			 */
			if ( '0' === $comment->comment_approved ) { ?>
				<p class="comment-awaiting-moderation">
					<?php _e( 'Your comment is awaiting moderation.', 'schlicht' ); ?>
				</p>
			<?php } ?>

			<div class="comment-content-wrapper">
				<div class="comment-content">
					<?php
					/**
					 * Display the comment text.
					 */
					comment_text();

					/**
					 * Display the edit link (only visible for users with the right capabilities).
					 */
					edit_comment_link( __( 'Edit', 'schlicht' ), '<p class="edit-link">', '</p>' ); ?>
				</div>
			</div>

			<div class="reply">
				<?php
				/**
				 * Display the reply link.
				 */
				comment_reply_link(
					[
						'reply_text' => __( 'Reply', 'schlicht' ),
						'depth'      => $depth,
						'max_depth'  => $args['max_depth'],
					]
				); ?>
			</div>
		</div>
		<?php
	}
} // End if().

/**
 * Include file with add_action() calls.
 */
require_once locate_template( 'inc/actions.php' );

/**
 * Include customizer functions.
 */
require_once locate_template( 'inc/customizer.php' );

/**
 * Include functions for theme update handling.
 */
require_once locate_template( 'inc/theme-updates.php' );
