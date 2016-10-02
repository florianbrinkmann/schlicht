<?php
/**
 * Template for 404 error
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<div class="main-content">
			<article class="clearfix">
				<header>
					<h1 class="archive-title"><?php _e( 'Nothing Found', 'schlicht' ); ?></h1>
				</header>
				<div class="content-404">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'schlicht' ); ?></p>
					<?php get_search_form(); ?>
				</div>
			</article>
		</div>
	</main>
<?php get_sidebar();
get_footer();