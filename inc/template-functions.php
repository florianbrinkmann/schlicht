<?php
/**
 * Functions that are not called from the template files
 * and cannot be grouped together into another file.
 *
 * @version 1.4.0
 *
 * @package Schlicht
 */

/**
 * Load translation.
 */
function schlicht_load_translation() {
	// Check if:
	// - we do not have an AJAX call.
	// - we are not on the login page.
	// - we are not on the wp-comments-post.php.
	if ( ( ! defined( 'DOING_AJAX' ) && ! 'DOING_AJAX' ) || ! schlicht_is_login_page() || ! schlicht_is_wp_comments_post() ) {
		// Load the translation.
		load_theme_textdomain( 'schlicht', get_theme_file_path() . '/languages' );
	}
}

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
 * Set the content width.
 */
function schlicht_set_content_width() {
	/**
	 * Make the content width filterable.
	 *
	 * @param int $content_width Content width in pixels.
	 */
	$GLOBALS['content_width'] = apply_filters( 'schlicht_content_width', 791 ); //phpcs:ignore
}

if ( ! function_exists( 'schlicht_add_theme_support' ) ) {
	/**
	 * Adds theme support for feed links, custom head, html5, post formats, post thumbnails, title element and custom logo.
	 */
	function schlicht_add_theme_support() {
		// Add theme support for the custom header feature.
		add_theme_support( 'custom-header' );

		// Add theme support for automatic feed links (like post feed, comments feed, …).
		add_theme_support( 'automatic-feed-links' );

		// Add theme support for title tag.
		add_theme_support( 'title-tag' );

		// Add theme support for post formats.
		add_theme_support(
			'post-formats',
			[
				'aside',
				'link',
				'gallery',
				'status',
				'quote',
				'image',
				'video',
				'audio',
				'chat',
			]
		);

		// Add theme support for HTML5 markup for core components.
		add_theme_support(
			'html5',
			[
				'comment-list',
				'comment-form',
				'search-form',
				'gallery',
				'caption',
			]
		);

		// Add theme support for post thumbnails.
		add_theme_support( 'post-thumbnails' );

		// Add theme support for custom logo feature.
		add_theme_support( 'custom-logo' );

		// Disable custom font sizes and colors in Gutenberg.
		add_theme_support( 'disable-custom-font-sizes' );
		add_theme_support( 'disable-custom-colors' );

		add_theme_support( 'editor-styles' );

		add_theme_support(
			'editor-color-palette',
			[
				[
					'name'  => __( 'Dark grey', 'schlicht' ),
					'slug'  => 'dark-grey',
					'color' => '#333',
				],
				[
					'name'  => __( 'White', 'schlicht' ),
					'slug'  => 'white',
					'color' => '#fff',
				],
			]
		);
	}
}

if ( ! function_exists( 'schlicht_add_editor_style' ) ) {
	/**
	 * Adds stylesheet for Tiny MCE editor in the backend.
	 */
	function schlicht_add_editor_style() {
		// Get the value of the Vollkorn font customizer option.
		$vollkorn_font = get_theme_mod( 'schlicht_vollkorn_font', false );

		// Check if Vollkorn option is disabled.
		if ( false === $vollkorn_font ) {
			// Include editor styles with default font Sorts Mill Goudy.
			add_editor_style( 'css/editor-style.css' );
		} else {
			add_editor_style( 'css/editor-style-vollkorn.css' );
		}
	}
}

if ( ! function_exists( 'schlicht_enqueue_block_editor_assets' ) ) {
	/**
	 * Add JS to block editor.
	 */
	function schlicht_enqueue_block_editor_assets() {
		wp_enqueue_script(
			'schlicht-gutenberg-block-editor-script',
			get_theme_file_uri( '/js/block-editor-script.js' ),
			[ 'wp-blocks', 'wp-element', 'wp-edit-post', 'lodash' ]
		);
	}
}

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
}

if ( ! function_exists( 'schlicht_register_sidebars' ) ) {
	/**
	 * Register sidebar.
	 */
	function schlicht_register_sidebars() {
		// Register the main sidebar.
		register_sidebar(
			[
				'name'          => __( 'Main Sidebar', 'schlicht' ),
				'id'            => 'sidebar-1',
				'description'   => __( 'Widgets in this area will be displayed on all posts and pages by default.', 'schlicht' ),
				'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);

		// Register the footer widget area.
		register_sidebar(
			[
				'name'          => __( 'Footer Sidebar', 'schlicht' ),
				'id'            => 'sidebar-footer',
				'description'   => __( 'Widgets will be displayed in the footer.', 'schlicht' ),
				'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			]
		);
	}
}

if ( ! function_exists( 'schlicht_scripts_styles' ) ) {
	/**
	 * Adds the scripts and styles to the header.
	 */
	function schlicht_scripts_styles() {
		// Check if:
		// - singular view.
		// - comments are open.
		// - Threaded comments are enabled.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			/**
			 * Enqueue comment-reply script.
			 */
			wp_enqueue_script( 'comment-reply' );
		}

		// Get value of Vollkorn customizer option.
		$vollkorn_font = get_theme_mod( 'schlicht_vollkorn_font', false );

		// Check if Vollkorn option is disabled.
		if ( false === $vollkorn_font ) {
			// Include default style.
			if ( is_rtl() ) {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri( '/css/schlicht-rtl.css' ), [], filemtime( get_theme_file_path( '/css/schlicht-rtl.css' ) ) );
			} else {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri( '/css/schlicht.css' ), [], filemtime( get_theme_file_path( '/css/schlicht.css' ) ) );
			}
		} else {
			// Include Vollkorn style.
			if ( is_rtl() ) {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri( '/css/schlicht-vollkorn-rtl.css' ), [], filemtime( get_theme_file_path( '/css/schlicht-vollkorn-rtl.css' ) ) );
			} else {
				wp_enqueue_style( 'schlicht-style', get_theme_file_uri( '/css/schlicht-vollkorn.css' ), [], filemtime( get_theme_file_path( '/css/schlicht-vollkorn.css' ) ) );
			}
		}
	}
}

if ( ! function_exists( 'schlicht_admin_script' ) ) {
	/**
	 * Include admin script.
	 *
	 * @param string $hook_suffix The current admin page.
	 */
	function schlicht_admin_script( $hook_suffix ) {
		// Check for post or page edit page.
		if ( 'post.php' === $hook_suffix ) {
			// Include the editor functions js.
			wp_enqueue_script( 'schlicht_editor-functions', get_theme_file_uri( 'js/backend-editor-functions.js' ), [], filemtime( get_theme_file_path( 'js/backend-editor-functions.js' ) ), true );
		}
	}
}

/**
 * Dequeue default Gutenberg block styles.
 */
function schlicht_dequeue_gutenberg_block_styles() {
	wp_dequeue_style( 'wp-block-library' );
	wp_deregister_style( 'wp-block-library' );
}
