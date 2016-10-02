<?php
/**
 * Template file for archives
 *
 * @version 1.0
 */
get_header(); ?>
	<main>
		<div class="main-content">
			<?php if ( have_posts() ) { ?>
				<header>
					<h1 class="archive-title"><?php the_archive_title(); ?></h1>
					<?php $archive_description = get_the_archive_description();
					if ( $archive_description != '' ) {
						echo $archive_description;
					} ?>
				</header>
				<?php while ( have_posts() ) {
					the_post();
					get_template_part( 'template-parts/content', get_post_format() );
				}
			} else {
				get_template_part( 'template-parts/content', 'none' );
			}
			the_posts_pagination( array( 'type' => 'list' ) ); ?>
		</div>
	</main>
<?php get_sidebar();
get_footer();