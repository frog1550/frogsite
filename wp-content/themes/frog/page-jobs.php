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

				<?php get_template_part( 'content', 'page' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php
				$jobs = get_posts(array(
					'post_type' => 'job',
					'order_by' => 'meta_key',
					'meta_key' => 'location'
				));
				$last_location = false;
			?>
			<?php if ($jobs) : ?>
				<section id="jobs">
					<?php foreach($jobs as $post) : setup_postdata($post); ?>
						
						<?php $location = get_field('location'); ?>
						<?php if ($last_location != $location->ID) : ?>
							<header class="location-header cf">
								<?php $last_location = $location->ID; ?>
								<hgroup class="location-title">
									<h1>
										<a href="<?php echo get_permalink($location->ID); ?>">
											<span class="frog ir">Frog</span> <?php echo get_the_title($location->ID); ?>
										</a>
									</h1>
									<h2>Available Positions</h3>
								</hgroup>
								
								<?php
									$address = strip_tags(get_field('address', $location->ID));
									$address = trim(preg_replace('/\s+/', ' ', $address));
									$address = urlencode($address);
								?>
								<a href="https://maps.google.com/maps?daddr=<?php echo $address; ?>" target="_blank" class="location-address">
									<?php the_field('address', $location->ID); ?>
								</a>
							</header>
						<?php endif; ?>
						
						<?php get_template_part( 'content', 'job' ); ?>
						
					<?php endforeach; ?>
				</section>
			<?php endif; ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>