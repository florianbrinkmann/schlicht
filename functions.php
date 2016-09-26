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

function schlicht_get_custom_logo() {
	if ( function_exists( 'get_custom_logo' ) ) {
		return get_custom_logo();
	}
}