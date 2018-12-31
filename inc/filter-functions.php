<?php
/**
 * Filter functions.
 *
 * @version 1.3.2
 *
 * @package Schlicht
 */

if ( ! function_exists( 'schlicht_remove_more_link_scroll' ) ) {
	/**
	 * Removes the page jump after clicking on a read more link.
	 *
	 * @param string $link Post URL.
	 *
	 * @return string Link without more hash.
	 */
	function schlicht_remove_more_link_scroll( $link ) {
		// Remove more hash from URL.
		$link = preg_replace( '/#more-[0-9]+/', '', $link );

		return $link;
	}
}

if ( ! function_exists( 'schlicht_body_classes' ) ) {
	/**
	 * Adds class to body if sidebar is used and other class if alternate
	 * post layout is enabled.
	 *
	 * @param array $classes Array of body classes.
	 *
	 * @return array Array of body classes.
	 */
	function schlicht_body_classes( $classes ) {
		// Check if we have an active sidebar and we are not on a page with the »No sidebar« template.
		if ( is_active_sidebar( 'sidebar-1' ) && get_page_template_slug() !== 'page-templates/no-sidebar.php' ) {
			// Add sidebar-template class to the classes array.
			$classes[] = 'sidebar-template';
		}

		// Get the customizer option value for alternative layout.
		$alternate_post_layout_option = get_theme_mod( 'schlicht_alternate_post_layout', false );

		// Check if the alternative layout is active and no widget is in the sidebar.
		if ( true === $alternate_post_layout_option && ! is_active_sidebar( 'sidebar-1' ) ) {
			// Add alternate-layout class to the classes array.
			$classes[] = 'alternate-layout';
		}

		return $classes;
	}
}
