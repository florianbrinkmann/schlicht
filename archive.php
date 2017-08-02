<?php
/**
 * Template file for archives
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
					<h1 class="archive-title"><?php the_archive_title(); ?></h1>
					<?php
					/**
					 * Save the archive description.
					 */
					$archive_description = get_the_archive_description();

					/**
					 * Check if we have a description.
					 */
					if ( '' !== $archive_description ) {

						/**
						 * Display the archive description.
						 */
						echo $archive_description;
					} ?>
				</header>
				<?php
				/**
				 * Loop the posts.
				 */
				while ( have_posts() ) {
					/**
					 * Setup post.
					 */
					the_post();

					/**
					 * Include the template part for displaying the content. Default is template-parts/content.php.
					 */
					get_template_part( 'template-parts/content', get_post_format() );
				}
			} else {
				/**
				 * Include template-parts/content-none.php.
				 */
				get_template_part( 'template-parts/content', 'none' );
			} // End if().

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
