<?php
/**
 * All add_filter() calls.
 *
 * @version 1.3.0
 *
 * @package Schlicht
 */

add_filter( 'the_content_more_link', 'schlicht_remove_more_link_scroll' );

add_filter( 'body_class', 'schlicht_body_classes' );
