<?php
/**
 * The template used for displaying page content in the Catering page template.
 *
 * @package Frog
 * @since Frog 1.0
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header hero">
			<?php the_post_thumbnail(); ?>
		
			<h1 class="entry-title"><?php echo get_field('custom_title') ? get_field('custom_title') : get_the_title();; ?></h1>
		</header>

		<aside class="entry-images">
			<?php
				if ($image = get_field('additional_image')) :
					$image = wp_get_attachment_image_src($image, 'side');
			?>
				<span class="image"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></span>
			<?php endif; ?>
		</aside>
		
		<div class="entry-content">
			<?php if ($subtitle = get_field('subtitle')) : ?>
				<h2 class="content-title"><?php echo $subtitle; ?></h2>
			<?php endif; ?>
			
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'frog' ), 'after' => '</div>' ) ); ?>
		</div><!-- .entry-content -->
		
		<?php
			if ($form = get_field('form')) {
				get_template_part('form', $form);
			}
		?>
		
		<footer class="entry-meta">
			<?php edit_post_link( __( 'Edit', 'frog' ), '<span class="edit-link">', '</span>' ); ?>
		</footer><!-- .entry-meta -->
	</article><!-- #post -->
