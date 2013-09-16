<?php
/**
 * The template used for displaying page content in page.php
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
					<?php if ($subtitle) : ?>
						<h2><?php echo $subtitle; ?></h2>
					<?php endif; ?>
				</hgroup>

				<div class="entry-content">
					<?php the_content(); ?>
					<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'frog' ), 'after' => '</div>' ) ); ?>
				</div><!-- .entry-content -->
			</div>
		</header>
		
		<?php get_template_part('gallery'); ?>
	</article><!-- #post -->
