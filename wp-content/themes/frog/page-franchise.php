<?php
/**
 *
 * @package Frog
 * @since Frog 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'project' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php if ($faqs = get_posts(array('post_type' => 'faq'))) : ?>
				<section id="faqs">
					<h1 class="section-title">Frequently Asked Questions</h1>
					
					<?php foreach($faqs as $post) : setup_postdata($post); ?>
						
						<?php get_template_part( 'content', 'faq' ); ?>
						
					<?php endforeach; ?>
				</section>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>