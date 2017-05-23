<?php
/**
 * Main Template file
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
			if ( have_posts() ) {
				/**
				 * Check if we are on the latest posts page but not on the front page.
				 * This means, a static site was chosen to display the latest posts.
				 */
				if ( is_home() && ! is_front_page() ) { ?>
					<header>
						<h1 class="screen-reader-text"><?php single_post_title(); ?></h1>
					</header>
				<?php }

				/**
				 * Loop through the posts.
				 */
				while ( have_posts() ) {
					/**
					 * Setup post data.
					 */
					the_post();

					/**
					 * Include template file to display the post content. Default is template-parts/content.php.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				}
			} else {
				/**
				 * Include template-parts/content-none.php.
				 */
				get_template_part( 'template-parts/content', 'none' );
			}

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
