<?php
/**
 * The template used for displaying page content in the Nutrition page template.
 *
 * @package Frog
 * @since Frog 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header hero">
			<?php the_post_thumbnail(); ?>
			
			<div class="hero-content">
				<hgroup class="entry-title">
					<?php
						$title = get_field('custom_title') ? get_field('custom_title') : get_the_title();
						$subtitle = get_field('subtitle');
					?>
					<h1><?php echo $title; ?></h1>
				</hgroup>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'frog' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
			</div>
		</header>
		
		<?php if ($footer = get_field('footer')) : ?>
			<footer class="entry-meta with-<?php echo count($footer); ?>-sections cf">
				<header class="cf">
					<span class="info-icon"><span class="arrow"></span></span>
					<h2><?php echo $subtitle ? $subtitle : 'Frozen Yogurt'; ?></h2>
					<?php get_template_part('social', 'nutrition'); ?>
				</header>
				
				<?php foreach ($footer as $i => $section) : ?>
					<section class="footer-section-<?php echo $i; ?>">
						<h3><?php echo $section['title']; ?></h3>
						<div class="footer-content">
							<?php echo $section['text']; ?>
						</div>
					</section>
				<?php endforeach; ?>
			</footer><!-- .entry-meta -->
		<?php endif; ?>
	</article><!-- #post -->
