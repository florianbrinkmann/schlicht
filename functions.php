<?php
/**
 * Functions file
 */

/**
 * Set content width to 845 px
 */
if ( ! isset( $content_width ) ) {
	$content_width = 806;
}

/**
 * Set width of large image size to 845 px
 */
update_option( 'large_size_w', 806 );

/**
 * Adds theme support for feed links, custom head, html5, post formats, post thumbnails, title element and custom logo
 */
function schlicht_add_theme_support() {
	add_theme_support( 'custom-header' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-formats', array(
		'aside',
		'link',
		'gallery',
		'status',
		'quote',
		'image',
		'video',
		'audio',
		'chat'
	) );
	add_theme_support( 'html5', array(
		'comment-list',
		'comment-form',
		'search-form',
		'gallery',
		'caption',
	) );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'custom-logo' );
}

add_action( 'after_setup_theme', 'schlicht_add_theme_support' );

/**
 * Register Menus
 */
function schlicht_register_menus() {
	register_nav_menus(
		array(
			/* translators: Name of menu position in the header */
			'primary' => __( 'Primary Menu', 'schlicht' ),
			/* translators: Name of menu position in the footer */
			'footer'  => __( 'Footer Menu', 'schlicht' ),
		)
	);
}

add_action( 'init', 'schlicht_register_menus' );

/**
 * Register sidebar
 */
function schlicht_register_sidebars() {
	register_sidebar( array(
		'name'          => __( 'Main Sidebar', 'schlicht' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Widgets in this area will be displayed on all posts and pages by default.', 'schlicht' ),
		'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
	register_sidebar( array(
		'name'          => __( 'Footer Sidebar', 'schlicht' ),
		'id'            => 'sidebar-footer',
		'description'   => __( 'Widgets will be displayed in the footer.', 'schlicht' ),
		'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'schlicht_register_sidebars' );

/**
 * Adds the scripts and styles to the header
 */
function schlicht_scripts_styles() {
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	wp_enqueue_style( 'schlicht-style', get_template_directory_uri() . '/css/schlicht.css', array(), null );
	wp_enqueue_style( 'schlicht-fonts', '//brick.a.ssl.fastly.net/Sorts+Mill+Goudy:400,400i', array(), null );

	$dropcaps_enabled = get_theme_mod( 'schlicht_dropcap' );
	if ( $dropcaps_enabled == 1 ) {
		wp_enqueue_script( 'schlicht-dropcap', get_template_directory_uri() . '/js/dropcap.js', array( 'jquery' ), null, true );
	}
}

add_action( 'wp_enqueue_scripts', 'schlicht_scripts_styles' );

/**
 * Removes the page jump after clicking on a read more link
 *
 * @param $link
 *
 * @return mixed
 */
function schlicht_remove_more_link_scroll( $link ) {
	$link = preg_replace( '/#more-[0-9]+/', '', $link );

	return $link;
}

add_filter( 'the_content_more_link', 'schlicht_remove_more_link_scroll' );

/**
 * Wrap inside function_exists() to preserve back compat with WordPress versions older than 4.5
 *
 * @return string
 */
function schlicht_get_custom_logo() {
	if ( function_exists( 'get_custom_logo' ) ) {
		if ( has_custom_logo() ) {
			return get_custom_logo();
		}
	}
}

/**
 * Displays the title of a post
 *
 * @param $heading
 * @param $link
 *
 * @return void
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

/**
 * Displays the_content with a more accessible more tag
 *
 * @return void
 */
function schlicht_the_content() {
	/* translators: visible text for the more tag */
	the_content(
		sprintf(
			'<span aria-hidden="true">%1s</span><span class="screen-reader-text">%2s</span>',
			__( 'Continue reading', 'schlicht' ),
			sprintf( /* translators: continue reading text for screen reader users. s=post title */
				__( 'Continue reading %s', 'schlicht' ),
				the_title( '', '', false )
			)
		)
	);
}

/**
 * Displays footer meta for a post
 *
 * @return void
 */
function schlicht_the_post_meta() {
	if ( get_the_category() ) { ?>
		<p class="entry-footer-block categories"><span class="entry-footer-block-label">
				<?php /* translators: Label for category list in entry footer. s=categories */
				printf( _n(
					'Category',
					'Categories',
					count( get_the_category() ),
					'schlicht'
				) )
				?><span class="screen-reader-text">:</span></span>
			<?php /* translators: term delimiter */
			echo get_the_category_list( __( ', ', 'schlicht' ) ); ?>
		</p>
	<?php }
	if ( get_the_tags() ) { ?>
		<p class="entry-footer-block tags"><span class="entry-footer-block-label">
				<?php /* translators: Label for tags list in entry footer. */
				printf( _n(
					'Tag',
					'Tags',
					count( get_the_tags() ),
					'schlicht'
				) )
				?><span class="screen-reader-text">:</span></span>
			<?php /* translators: term delimiter */
			echo get_the_tag_list( '', __( ', ', 'hannover' ) ); ?>
		</p>
	<?php }
	$comments_by_type = schlicht_get_comments_by_type();
	if ( $comments_by_type['comment'] ) {
		$comment_number = count( $comments_by_type['comment'] ); ?>
		<p class="entry-footer-block comments"><span class="entry-footer-block-label">
				<?php /* translators: Label for comment number in entry footer. */
				_e( 'Comments', 'schlicht' );
				?><span class="screen-reader-text">:</span></span>
			<?php /* translators: term delimiter */
			echo number_format_i18n( $comment_number ); ?>
		</p>
	<?php }
	if ( $comments_by_type['pings'] ) {
		$trackback_number = count( $comments_by_type['pings'] ); ?>
		<p class="entry-footer-block trackbacks"><span class="entry-footer-block-label">
				<?php /* translators: Label for trackback number in entry footer. */
				_e( 'Trackbacks', 'schlicht' );
				?><span class="screen-reader-text">:</span></span>
			<?php /* translators: term delimiter */
			echo number_format_i18n( $trackback_number ); ?>
		</p>
	<?php };
}

/**
 * Gets the comments seperated by type
 *
 * @return array
 */
function schlicht_get_comments_by_type() {
	$comment_args     = array(
		'order'   => 'ASC',
		'orderby' => 'comment_date_gmt',
		'status'  => 'approve',
		'post_id' => get_the_ID(),
	);
	$comments         = get_comments( $comment_args );
	$comments_by_type = separate_comments( $comments );

	return $comments_by_type;
}

/**
 * Adds class to body if sidebar is used
 *
 * @return array
 */
function schlicht_body_classes( $classes ) {
	$display_sidebar_option = get_theme_mod( 'sidebar_visibility' );
	if ( ( is_active_sidebar( 'sidebar-1' )
	       && ( ( get_page_template_slug() != 'page-templates/no-sidebar.php' )
	            && ( ( $display_sidebar_option == 'blog_view' && ! is_single() )
	                 || ( $display_sidebar_option == 'single_view' && is_single() )
	                 || ( $display_sidebar_option == 'everywhere' ) ) ) )
	) {
		$classes[] = 'sidebar-template';
	}

	return $classes;
}


add_filter( 'body_class', 'schlicht_body_classes' );

/**
 * Callback function for displaying the comment list
 *
 * @param $comment
 * @param $args
 * @param $depth
 *
 * @return void
 */
function schlicht_comments( $comment, $args, $depth ) { ?>
<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
	<div id="comment-<?php comment_ID(); ?>" class="<?php comment_class(); ?>">
		<div class="comment-meta">
			<?php echo get_avatar( $comment, 50 ); ?>
			<p class="comment-author-name">
				<?php comment_author_link(); ?>
			</p>

			<?php printf(
				'<p class="comment-date"><a href="%1$s"><time datetime="%2$s">%3$s</time></a></p>',
				get_comment_link( $comment->comment_ID ),
				get_comment_time( 'c' ),
				/* translators: 1=date 2=time */
				sprintf( __( '%1$s @ %2$s', 'schlicht' ), get_comment_date(), get_comment_time() )
			); ?>
		</div>

		<?php if ( '0' == $comment->comment_approved ) { ?>
			<p class="comment-awaiting-moderation">
				<?php _e( 'Your comment is awaiting moderation.', 'schlicht' ); ?>
			</p>
		<?php } ?>

		<div class="comment-content-wrapper">
			<div class="comment-content">
				<?php comment_text(); ?>
				<?php edit_comment_link( __( 'Edit', 'schlicht' ), '<p class="edit-link">', '</p>' ); ?>
			</div>
		</div>

		<div class="reply">
			<?php comment_reply_link(
				array(
					'reply_text' => __( 'Reply', 'schlicht' ),
					'depth'      => $depth,
					'max_depth'  => $args['max_depth']
				)
			); ?>
		</div>
	</div>
	<?php
}

require_once 'inc/customizer.php';