<?php
/**
 * Template Name: Front Page Template
 *
 * @package Frog
 * @since Frog 1.0
 */

global $first_slide;
$first_slide = true;
$slides = get_posts(array(
	'numberposts' => -1,
	'post_type' => 'slide'
));

$large_promos = get_field('large_promos');
$small_promos = get_field('small_promos');

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>
				
				<section id="slides">
					<?php foreach ($slides as $post) : setup_postdata($post); ?> 

						<?php get_template_part( 'content', 'slide' ); ?>
						<?php $first_slide = false; ?>
						
					<?php endforeach; ?>
					
					<nav id="slide-nav">
						<ul>
						<?php for ($i = 0; $i < count($slides); $i++) : ?>
							<li data-slide="<?php echo $i; ?>"<?php if ($i == 0) : ?> class="current"<?php endif; ?>></li>
						<?php endfor; ?>
						</ul>
					</nav>
				</section>
				
				<section id="promos">
					<div class="content">
						<ul id="large-promos" class="cf">
							<?php foreach ($large_promos as $i => $promo) : ?>
								<?php
									$class = 'large-promo';
									if ($i == 0) {
										$class .= ' first';
									} elseif ($i == count($small_promos) - 1) {
										$class .= ' last';
									}
								?>
								<li class="<?php echo $class; ?>">
									<a href="<?php echo $promo['link']; ?>">
										<?php
											$image = wp_get_attachment_image_src($promo['image'], 'large-promo');
										?>
										<img src="<?php echo $image[0]; ?>" alt="<?php echo $promo['title']; ?>" />
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
						<ul id="small-promos" class="cf">
							<li class="small-promo first gift-cards">
								<a href="<?php echo esc_url(home_url('card/')); ?>"><span class="overlay ir">Gift Cards</span></a>
							</li>
							<?php foreach ($small_promos as $i => $promo) : ?>
								<li class="small-promo">
									<a href="<?php echo $promo['link']; ?>">
										<?php
											$image = wp_get_attachment_image_src($promo['image'], 'small-promo');
										?>
										<img src="<?php echo $image[0]; ?>" alt="<?php echo $promo['title']; ?>" />
									</a>
								</li>
							<?php endforeach; ?>
							<li class="small-promo last social">
								<a class="icon twitter ir" href="<?php echo get_theme_mod('twitter'); ?>" target="_blank">Twitter</a>
								<a class="icon facebook ir" href="<?php echo get_theme_mod('facebook'); ?>" target="_blank">Facebook</a>
								<a class="icon instagram ir" href="<?php echo get_theme_mod('instagram'); ?>" target="_blank">Instagram</a>
							</li>
						</ul>
					</div>
				</section>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar( 'front' ); ?>
<?php get_footer(); ?>