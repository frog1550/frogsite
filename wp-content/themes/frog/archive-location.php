<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * @package Frog
 * @since Frog 1.0
 */

if (have_posts()) {
	the_post();
	wp_redirect(get_permalink());
	exit();
}

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			
			<?php get_template_part( 'content', 'none' ); ?>
			
		</div><!-- #content -->
	</section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>