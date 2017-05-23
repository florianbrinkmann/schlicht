<?php
/**
 * Template name: No sidebar
 *
 * @version 1.2.1
 *
 * @package Schlicht
 */

/**
 * Include header.php.
 */
get_header(); ?>
	<main>
		<div class="main-content">
			<?php
			/**
			 * Check if we have a post.
			 */
			if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();

					/**
					 * Use the template template-parts/content-page.php to display the page content.
					 */
					get_template_part( 'template-parts/content', 'page' );
				}
			} else {
				/**
				 * Include template-parts/content-none.php if we do not have a post.
				 */
				get_template_part( 'template-parts/content', 'none' );
			} ?>
		</div>
	</main>
<?php get_footer();
