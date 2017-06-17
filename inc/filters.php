<?php
/**
 * All add_filter() calls.
 *
 * @version 1.3.0
 *
 * @package Schlicht
 */

/**
 * Remove #more jump from read more link.
 */
add_filter( 'the_content_more_link', 'schlicht_remove_more_link_scroll' );

/**
 * Filters the body classes.
 */
add_filter( 'body_class', 'schlicht_body_classes' );

/**
 * Check for Schlicht updates.
 */
add_filter( 'pre_set_site_transient_update_themes', 'schlicht_theme_update' );
