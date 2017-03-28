<?php
/**
 * Template for displaying content of pages
 *
 * @version 1.0
 */
?>
<article <?php post_class( 'clearfix' ); ?>>
	<header class="entry-header">
		<?php schlicht_the_title( 'h1', false ) ?>
	</header>
	<div class="entry-content">
		<?php the_post_thumbnail( 'large' );
		schlicht_the_content();
		schlicht_wp_link_pages(); ?>
	</div>
</article>
