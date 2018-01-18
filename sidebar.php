<?php
/**
 * Template for displaying the sidebar
 *
 * @version 1.3.2
 *
 * @package Schlicht
 */

// Check if the sidebar-1 has widgets.
if ( is_active_sidebar( 'sidebar-1' ) ) { ?>
	<aside class="sidebar" role="complementary">
		<h2 class="screen-reader-text">
			<?php /* translators: screen reader text for the sidebar */
			_e( 'Sidebar', 'schlicht' ) ?></h2>
		<?php
		// Display the widgets.
		dynamic_sidebar( 'sidebar-1' ); ?>
	</aside>
<?php }
