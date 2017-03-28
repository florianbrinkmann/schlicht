<?php
/**
 * Functions file
 *
 * @package Schlicht
 */

if ( ! function_exists( 'schlicht_load_translation' ) ) {
	/**
	 * Load translation
	 */
	function schlicht_load_translation() {
		if ( ( ! defined( 'DOING_AJAX' ) && ! 'DOING_AJAX' ) || ! schlicht_is_login_page() || ! schlicht_is_wp_comments_post() ) {
			load_theme_textdomain( 'schlicht', get_template_directory() . '/languages' );
		}
	}
}

add_action( 'after_setup_theme', 'schlicht_load_translation' );

if ( ! function_exists( 'schlicht_is_login_page' ) ) {
	/**
	 * Check if we are on the login page
	 *
	 * @return bool
	 */
	function schlicht_is_login_page() {
		return in_array( $GLOBALS['pagenow'], array( 'wp-login.php', 'wp-register.php' ) );
	}
}

if ( ! function_exists( 'schlicht_is_wp_comments_post' ) ) {
	/**
	 * Check if we are on the wp-comments-post.php
	 *
	 * @return bool
	 */
	function schlicht_is_wp_comments_post() {
		return in_array( $GLOBALS['pagenow'], array( 'wp-comments-post.php' ) );
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
			'chat',
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
}

add_action( 'after_setup_theme', 'schlicht_add_theme_support' );

if ( ! function_exists( 'schlicht_add_editor_style' ) ) {
	/**
	 * Adds stylesheet for Tiny MCE editor in the backend
	 */
	function schlicht_add_editor_style() {
		add_editor_style( 'css/editor-style.css' );
	}
}

add_action( 'after_setup_theme', 'schlicht_add_editor_style' );

if ( ! function_exists( 'schlicht_register_menus' ) ) {
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
}

add_action( 'init', 'schlicht_register_menus' );

if ( ! function_exists( 'schlicht_register_sidebars' ) ) {
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
}

add_action( 'widgets_init', 'schlicht_register_sidebars' );

if ( ! function_exists( 'schlicht_scripts_styles' ) ) {
	/**
	 * Adds the scripts and styles to the header
	 */
	function schlicht_scripts_styles() {
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		wp_enqueue_style( 'schlicht-style', get_template_directory_uri() . '/css/schlicht.css', array(), null );
	}
}

add_action( 'wp_enqueue_scripts', 'schlicht_scripts_styles' );

if ( ! function_exists( 'schlicht_dropcap_inline_script' ) ) {
	/**
	 * Inserts inline script for small caps after drop cap.
	 */
	function schlicht_dropcap_inline_script() {
		$dropcaps_enabled = get_theme_mod( 'schlicht_dropcap' );
		if ( $dropcaps_enabled == 1 ) {
			$no_auto_dropcaps = get_theme_mod( 'schlicht_no_auto_dropcap' );
			if ( $no_auto_dropcaps == 0 ) {
				$auto_dropcaps_only_for_posts = get_theme_mod( 'schlicht_auto_dropcaps_for_posts' );
				if ( $auto_dropcaps_only_for_posts == 1 ) {
					$container = '.post .entry-content';
				} else {
					$container = '.entry-content';
				}
				echo "<script>var container_selector = '$container';
var dropcaps = document.querySelectorAll(container_selector + ' .dropcap');
// regex from http://beutelevision.com/blog2/2011/06/17/get-the-first-n-words-with-javascript/
for(var i = 0; i < dropcaps.length; i++){
	if ( dropcaps[i].parentElement.className == 'small-caps' ) {
	} else {
		dropcaps[i].parentElement.innerHTML = dropcaps[i].parentElement.innerHTML.replace(/(([^\s]+\s\s*){2})/, '<span class=\"small-caps\">$1</span>');
	}
}</script>";
			}
		}
	}
}

add_action( 'wp_footer', 'schlicht_dropcap_inline_script' );

if ( ! function_exists( 'schlicht_remove_more_link_scroll' ) ) {
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
}

add_filter( 'the_content_more_link', 'schlicht_remove_more_link_scroll' );

if ( ! function_exists( 'schlicht_get_custom_logo' ) ) {
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
}

if ( ! function_exists( 'schlicht_the_title' ) ) {
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
}

if ( ! function_exists( 'schlicht_the_content' ) ) {
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
}

if ( ! function_exists( 'schlicht_wp_link_pages' ) ) {
	/**
	 * Displays a pagination for paginated posts and pages
	 *
	 * @return void
	 */
	function schlicht_wp_link_pages() {
		/* translators: Label for pagination of paginated posts and pages */
		wp_link_pages( array(
			'before'    => '<ul class="page-numbers"><li><span>' . __( 'Pages:', 'schlicht' ) . '</span></li><li>',
			'after'     => '</li></ul>',
			'separator' => '</li><li>',
		) );
	}
}

if ( ! function_exists( 'schlicht_the_post_meta' ) ) {
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
				echo get_the_tag_list( '', __( ', ', 'schlicht' ) ); ?>
			</p>
		<?php }
		$comments_by_type = schlicht_get_comments_by_type();
		if ( $comments_by_type['comment'] ) {
			$comment_number = count( $comments_by_type['comment'] ); ?>
			<p class="entry-footer-block comments"><span class="entry-footer-block-label">
				<?php /* translators: Label for comment number in entry footer. */
				_e( 'Comments', 'schlicht' );
				?><span class="screen-reader-text">:</span></span>
				<a href="<?php the_permalink(); ?>#comments-title">
					<?php /* translators: term delimiter */
					echo number_format_i18n( $comment_number ); ?>
				</a>
			</p>
		<?php }
		if ( $comments_by_type['pings'] ) {
			$trackback_number = count( $comments_by_type['pings'] ); ?>
			<p class="entry-footer-block trackbacks"><span class="entry-footer-block-label">
				<?php /* translators: Label for trackback number in entry footer. */
				_e( 'Trackbacks', 'schlicht' );
				?><span class="screen-reader-text">:</span></span>
				<a href="<?php the_permalink(); ?>#trackbacks-title">
					<?php /* translators: term delimiter */
					echo number_format_i18n( $trackback_number ); ?>
				</a>
			</p>
		<?php };
	}
}

if ( ! function_exists( 'schlicht_get_comments_by_type' ) ) {
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
}

if ( ! function_exists( 'schlicht_body_classes' ) ) {
	/**
	 * Adds class to body if sidebar is used and other class if alternate
	 * post layout is enabled
	 *
	 * @return array
	 */
	function schlicht_body_classes( $classes ) {
		if ( is_active_sidebar( 'sidebar-1' ) && get_page_template_slug() != 'page-templates/no-sidebar.php' ) {
			$classes[] = 'sidebar-template';
		}

		$alternate_post_layout_option = get_theme_mod( 'schlicht_alternate_post_layout' );
		if ( $alternate_post_layout_option == 1 ) {
			$classes[] = 'alternate-layout';
		}

		return $classes;
	}
}

add_filter( 'body_class', 'schlicht_body_classes' );

if ( ! function_exists( 'schlicht_comments' ) ) {
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
						'max_depth'  => $args['max_depth'],
					)
				); ?>
			</div>
		</div>
		<?php
	}
}

require_once 'inc/SmartDomDocument.php';

if ( ! function_exists( 'schlicht_add_dropcap_markup' ) ) {
	/**
	 * Adds markup for drop caps to post content
	 *
	 * @param $content
	 *
	 * @return string
	 */
	function schlicht_add_dropcap_markup( $content ) {
		if ( $content == '' ) {
			return $content;
		}
		$dropcaps_enabled = get_theme_mod( 'schlicht_dropcap' );
		$no_auto_dropcaps = get_theme_mod( 'schlicht_no_auto_dropcap' );
		if ( $dropcaps_enabled == 1 && $no_auto_dropcaps == 0 ) {
			$auto_dropcaps_only_for_posts = get_theme_mod( 'schlicht_auto_dropcaps_for_posts' );
			if ( $auto_dropcaps_only_for_posts == 0 || ( $auto_dropcaps_only_for_posts == 1 && ! is_page() ) ) {
				$dom = new \archon810\SmartDOMDocument();
				$dom->loadHTML( $content );

				/**
				 * get all paragraphs
				 */
				$paragraphs = $dom->getElementsByTagName( 'p' );

				if ( ! $paragraphs ) {
					return $content;
				}

				/**
				 * get content of first paragraph
				 */
				$first_paragraph_text = $dom->saveXML( $paragraphs->item( 0 ) );

				/**
				 * Remove paragraph tags from beginning and end
				 * Regex from http://stackoverflow.com/a/4713811
				 */
				$pattern = '=^<p>(.*)</p>$=i';
				preg_match( $pattern, $first_paragraph_text, $matches );
				if ( ! $matches ) {
					return $content;
				}
				$first_paragraph_text = $matches[1];

				/**
				 * Check if text starts with “<”
				 */
				$pattern = '|^<|i';
				preg_match( $pattern, $first_paragraph_text, $matches );
				if ( $matches ) {
					return $content;
				}

				/**
				 * get first word
				 * http://stackoverflow.com/a/10635638
				 */
				$first_word = preg_split( '/[\s,]+/', $first_paragraph_text )[0];

				/**
				 * Get first letter of paragraph
				 * http://stackoverflow.com/a/1972111
				 */
				$first_letter = mb_substr( $first_paragraph_text, 0, 1 );

				/**
				 * remove first word from paragraph
				 */
				$first_paragraph_text_without_first_word = preg_replace( "|$first_word|", "", $first_paragraph_text, 1 );
				if ( ! $first_paragraph_text_without_first_word ) {
					return $content;
				}

				/**
				 * Create markup for small caps part
				 * Result: <span class="small-caps"></span>
				 */
				$sc_class_attribute        = $dom->createAttribute( 'class' );
				$small_caps_element        = $dom->createElement( 'span' );
				$sc_class_attribute->value = 'small-caps';
				$small_caps_element->appendChild( $sc_class_attribute );

				/**
				 * Create markup for dropcap.
				 * Result: <span class="dropcap">$first_letter</span> where
				 * $first_letter is the first letter
				 */
				$dc_class_attribute        = $dom->createAttribute( 'class' );
				$dropcap_element           = $dom->createElement( 'span', $first_letter );
				$dc_class_attribute->value = 'dropcap';
				$dropcap_element->appendChild( $dc_class_attribute );

				/**
				 * append the dropcap span to the small caps span
				 */
				$small_caps_element->appendChild( $dropcap_element );

				/**
				 * get first word without first letter
				 */
				$first_word_without_first_letter = mb_substr( $first_word, 1 );

				/**
				 * create text node of the result (so it can be used
				 * as an argument for appendChild) and append it to the small caps
				 * element
				 */
				$first_word_text_node = $dom->createTextNode( $first_word_without_first_letter );
				$small_caps_element->appendChild( $first_word_text_node );

				/**
				 * Overwrite value of first paragraph with empty string so the
				 * small caps element with drop cap child can be inserted at beginning
				 */
				$paragraphs->item( 0 )->nodeValue = '';
				$paragraphs->item( 0 )->appendChild( $small_caps_element );

				/**
				 * Way with createDocumentFragment() from http://stackoverflow.com/a/4401512
				 */
				$temp = $dom->createDocumentFragment();
				$temp->appendXML( $first_paragraph_text_without_first_word );
				$paragraphs->item( 0 )->appendChild( $temp );

				$content = $dom->saveHTMLExact();
			}
		} else {

		}

		return $content;
	}
}

add_filter( 'the_content', 'schlicht_add_dropcap_markup' );

require_once 'inc/customizer.php';
require_once 'inc/theme-updates.php';
