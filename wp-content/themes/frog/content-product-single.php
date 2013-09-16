<?php
/**
 * The default template for displaying products
 *
 * @package Frog
 * @since Frog 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('single'); ?>>
		<header class="entry-header">
			<?php the_post_thumbnail('product'); ?>
			<h1 class="entry-title expand"><?php the_title(); ?></h1>
		</header><!-- .entry-header -->
		
		<div class="toggle-container">
			<span class="info-switch"></span>
			<section class="toggle product-description">
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<div class="product-icons cf">
					<?php frog_flavor_icons(); ?>
				</div>
			</section>

			<section class="toggle product-info" style="display:none;">
				<section class="nutrition">
					<h2>Nutrition Facts<span class="show-hide on">-</span></h2>
					<dl class="cf">
						<?php foreach (get_field('nutrition') as $fact) : ?>
							<dt><?php echo $fact['name']; ?>:</dt>
							<dd><?php echo $fact['value'] . str_replace('kcal', '', $fact['unit']); ?></dd>
						<?php endforeach; ?>
					</dl>
				</section>
				<section class="ingredients">
					<h2>Ingredients<span class="show-hide off">+</span></h2>
					<p style="display:none;"><?php the_field('ingredients'); ?></p>
				</section>
			</section>
		</div>
		
		<?php get_template_part('social', 'product'); ?>
		
		<span class="close"></span>
		<?php edit_post_link( __( 'Edit', 'frog' )); ?>
	</article><!-- #post -->
