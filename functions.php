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
		'id'            => 'sidebar-1',
		'description'   => __( 'Widgets will be displayed in the footer.', 'schlicht' ),
		'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

add_action( 'widgets_init', 'schlicht_register_sidebars' );

/**
 * Wrap inside function_exists() to preserve back compat with WordPress versions older than 4.5
 *
 * @return string
 */
function schlicht_get_custom_logo() {
	if ( function_exists( 'get_custom_logo' ) ) {
		return get_custom_logo();
	}
}

/**
 * Displays the title of a post
 *
 * @param $heading , $link
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