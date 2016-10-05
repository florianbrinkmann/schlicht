<?php
/**
 * Template name: No sidebar
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<div class="main-content">
			<?php if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', 'page' );
				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			} ?>
		</div>
	</main>
<?php get_footer();