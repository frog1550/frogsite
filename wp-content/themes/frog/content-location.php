<?php
/**
 * The template used for displaying locations
 *
 * @package Frog
 * @since Frog 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><span class="frog">Frog</span> <?php the_title(); ?></h1>
			
			<div class="entry-meta">
				<div class="address"><?php the_field('address'); ?></div>
				<div class="phone"><?php the_field('phone'); ?></div>
				<?php if ($hours = get_location_hours()) : ?>
					<ul class="hours">
						<?php if ($hours['open']) : ?>
							<li class="open">Open Now</li>
						<?php else : ?>
							<li class="closed">Currently Closed</li>
						<?php endif; ?>
						<?php foreach ($hours['hours'] as $hour) : ?>
							<li>
								<span class="days"><?php echo $hour['days']; ?></span>
								<span class="hours"><?php echo $hour['open']; ?>-<?php echo $hour['close']; ?></span>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			
			<div class="map">
				<?php
					$address = strip_tags(get_field('address'));
					$address = trim(preg_replace('/\s+/', ' ', $address));
					$address = urlencode($address);
				?>
				<a href="https://maps.google.com/maps?daddr=<?php echo $address; ?>" target="_blank">
					<img src="<?php echo get_post_thumbnail_url(null, 'map'); ?>" alt="Get Directions">
					<span>Get Directions</span>
				</a>
			</div>
			
			<div class="social cf">
				<a class="icon facebook ir" href="<?php echo get_theme_mod('facebook'); ?>" target="_blank">Facebook</a>
				<a class="icon twitter ir" href="<?php echo get_theme_mod('twitter'); ?>" target="_blank">Twitter</a>
				<a class="icon instagram ir" href="<?php echo get_theme_mod('instagram'); ?>" target="_blank">Instagram</a>
			</div>
		</header>
		
		<section class="flavors cf">
			<h2>Current Flavors</h2>
			
			<div class="product-type">
				<?php $flavors = get_field('flavors'); ?>
				<div class="wrapper with-<?php echo count($flavors); ?>">
					<?php foreach($flavors as $post) : setup_postdata($post); ?>

						<?php get_template_part('content', 'product'); ?>

					<?php endforeach; ?>
				</div>
			</div>
			
			<nav class="product-nav">
				<span data-page="prev" class="prev arrow"></span>
				<?php for ($i = 0; $i < ceil(count($flavors) / 3); $i++) : ?>
					<span data-page="<?php echo $i + 1; ?>"<?php if ($i == 0) : ?> class="current"<?php endif; ?>></span>
				<?php endfor; ?>
				<span data-page="next" class="next arrow"></span>
			</nav>
			
			<?php wp_reset_postdata(); ?>
		</section>
		
		<?php if ($members = get_field('staff')) : ?>
			<section class="staff-members">
				<h2><?php the_title(); ?> Staff</h2>
			
				<?php foreach ($members as $i => $staff) : ?>
					<article class="staff  <?php echo cycle('one', 'two', 'three', ':staff'); ?>-of-three">
						<?php $image = wp_get_attachment_image_src($staff['image'], 'staff'); ?>
						<img src="<?php echo $image[0]; ?>" alt="<?php echo $staff['name']; ?>" />
						<hgroup class="staff-title">
							<h3><?php echo $staff['name']; ?></h3>
							<h4><?php echo $staff['title']; ?></h3>
						</hgroup>
						<?php if (!empty($staff['twitter'])) : ?>
							<a href="https://twitter.com/<?php echo $staff['twitter']; ?>" target="_blank" class="staff-twitter">@<?php echo $staff['twitter']; ?></a>
						<?php endif; ?>
						<?php if (!empty($staff['flavor'])) : ?>
							<a href="<?php echo get_permalink($staff['flavor'][0]->ID); ?>" class="staff-flavor"><?php echo $staff['flavor'][0]->post_title; ?></a>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>
			</section>
		<?php endif; ?>

	</article><!-- #post -->	