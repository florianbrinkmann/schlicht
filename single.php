<?php
/**
 * Template for displaying single view of posts
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<div class="main-content">
			<?php if ( have_posts() ) {
				while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content-single', get_post_format() );
				}
				if ( comments_open() || get_comments_number() ) {
					comments_template( '', true );
				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			} ?>
		</div>
	</main>
<?php get_sidebar();
get_footer();
