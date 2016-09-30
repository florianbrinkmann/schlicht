<?php
/**
 * Template for displaying single view of posts
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<?php if ( have_posts() ) {
			while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content-single', get_post_format() );
			}
		} else {
			get_template_part( 'template-parts/content', 'none' );
		} ?>
	</main>
<?php get_sidebar();
get_footer();