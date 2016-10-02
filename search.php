<?php
/**
 * Template file for search result page
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<?php if ( have_posts() ) { ?>
			<header>
				<h1 class="archive-title">
					<?php printf( __( 'Search Results for: %s', 'schlicht' ), esc_html( get_search_query() ) ); ?>
				</h1>
			</header>
			<?php while ( have_posts() ) {
				the_post();
				get_template_part( 'template-parts/content', get_post_format() );
			}
		} else { ?>
			<header>
				<h1 class="archive-title">
					<?php printf( __( 'Nothing found for: %s', 'schlicht' ), esc_html( get_search_query() ) ); ?>
				</h1>
			</header>
			<div class="no-search-results">
				<?php get_search_form(); ?>
			</div>
		<?php }
		the_posts_pagination( array( 'type' => 'list' ) ); ?>
	</main>
<?php get_sidebar();
get_footer();