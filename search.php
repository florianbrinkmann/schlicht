<?php
/**
 * Template file for search result page
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
			 * Check if we have posts.
			 */
			if ( have_posts() ) { ?>
				<header>
					<h1 class="archive-title">
						<?php
						/**
						 * Display headline with search string.
						 */
						printf( /* translators: s=search query. */
							__( 'Search Results for: %s', 'schlicht' ),
							esc_html( get_search_query() )
						); ?>
					</h1>
				</header>
				<?php
				/**
				 * Loop through the posts.
				 */
				while ( have_posts() ) {
					/**
					 * Setup post.
					 */
					the_post();

					/**
					 * Include template file for displaying the content. Default: template-parts/content.php.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				}
			} else { ?>
				<header>
					<h1 class="archive-title">
						<?php
						/**
						 * Display headline with search string.
						 */
						printf( /* translators: s=search query. */
							__( 'Nothing found for: %s', 'schlicht' ),
							esc_html( get_search_query() )
						); ?>
					</h1>
				</header>
				<div class="no-search-results">
					<?php
					/**
					 * Display the search form.
					 */
					get_search_form(); ?>
				</div>
			<?php }

			/**
			 * Display the posts pagination.
			 */
			the_posts_pagination( [
				'type'      => 'list',
				'prev_text' => __( 'Previous', 'schlicht' ),
				'next_text' => __( 'Next', 'schlicht' ),
			] ); ?>
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
