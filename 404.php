<?php
/**
 * Template for 404 error
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
			<article class="clearfix">
				<header>
					<h1 class="archive-title"><?php _e( 'Nothing Found', 'schlicht' ); ?></h1>
				</header>
				<div class="content-404">
					<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', 'schlicht' ); ?></p>
					<?php
					/**
					 * Display the search form.
					 */
					get_search_form(); ?>
				</div>
			</article>
		</div>
	</main>
<?php
/**
 * Include the sidebar.php.
 */
get_sidebar();

/**
 * Include the footer.php.
 */
get_footer();
