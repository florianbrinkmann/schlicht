<?php
/**
 * Template for 404 error
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<article class="clearfix">
			<header class="entry-header">
				<h1 class="entry-title"><?php _e( 'Nothing Found', 'schlicht' ); ?></h1>
			</header>
			<div class="entry-content">
				<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'schlicht' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		</article>
	</main>
<?php get_sidebar();
get_footer();