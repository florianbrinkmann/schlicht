<?php
/**
 * Template for displaying content of pages
 *
 * @version 1.2.1
 *
 * @package Schlicht
 */
?>
<article <?php post_class( 'clearfix' ); ?>>
	<header class="entry-header">
		<?php
		/**
		 * Display the post title as h1 and without linking it.
		 */
		schlicht_the_title( 'h1', false ) ?>
	</header>
	<div class="entry-content">
		<?php
		/**
		 * Display the post thubmail in large size.
		 */
		the_post_thumbnail( 'large' );

		/**
		 * Display the content.
		 */
		schlicht_the_content();

		/**
		 * Display pagination.
		 */
		schlicht_wp_link_pages(); ?>
	</div>
</article>
