<?php
/**
 * Template for displaying the sidebar
 *
 * @version 1.0
 */
if ( is_active_sidebar( 'sidebar-1' ) ) {
	$display_sidebar_option = get_theme_mod( 'schlicht_sidebar_visibility' );
	if ( ( $display_sidebar_option == 'blog_view' && ! is_single() )
	     || ( $display_sidebar_option == 'single_view' && is_single() )
	     || $display_sidebar_option == 'everywhere'
	     || is_page()
	) { ?>
		<aside class="sidebar" role="complementary">
			<h2 class="screen-reader-text">
				<?php /* translators: screen reader text for the sidebar */
				_e( 'Sidebar', 'schlicht' ) ?></h2>
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</aside>
	<?php }
}