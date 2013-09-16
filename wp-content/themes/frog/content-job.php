<?php
/**
 * The default template for displaying a job.
 *
 * @package Frog
 * @since Frog 1.0
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
		<header class="entry-header">
			<?php if (is_single()) : ?>
				
				<aside class="entry-images">
					<span class="image"><?php the_post_thumbnail('side'); ?></span>
					<?php
						if ($image = get_field('additional_image')) :
							$image = wp_get_attachment_image_src($image, 'side');
					?>
						<span class="image"><img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" /></span>
					<?php endif; ?>
				</aside>
				
				<h1 class="entry-title"><?php the_title(); ?></h1>
				
				<?php if (empty($_POST)) : ?>
					<a href="<?php echo home_url('/about/jobs/'); ?>" class="cancel button">Cancel</a>
				<?php else : ?>
					<a href="<?php echo home_url('/about/jobs/'); ?>" class="cancel button">Back</a>
				<?php endif; ?>
				
			<?php else : ?>
			
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<div class="job-id"><span>job ID:</span> <?php the_slug(); ?><div>
				<?php edit_post_link( __( 'Edit', 'frog' )); ?>
				
			<?php endif; ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
		
		<?php if (is_single()) : ?>
			
			<?php get_template_part('form', 'job'); ?>
		
		<?php else : ?>
		
			<footer class="entry-meta">
				<a href="<?php the_permalink(); ?>" class="apply-now button">Apply</a>
			</footer>
		
		<?php endif; ?>
	</article><!-- #post -->
