<?php
/**
 * Template for displaying the sidebar
 *
 * @version 1.1.1
 *
 * @package Schlicht
 */

if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
	<aside class="sidebar" role="complementary">
		<h2 class="screen-reader-text">
			<?php /* translators: screen reader text for the sidebar */
			_e( 'Sidebar', 'schlicht' ) ?></h2>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</aside>
<?php }
