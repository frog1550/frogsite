<?php
/**
 * The template used for displaying slides in front-page.php
 *
 * @package Frog
 * @since Frog 1.0
 */
	global $first_slide;
	$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' );
	$thumb_url = $thumb['0'];
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php if (!$first_slide) : ?> style="display:none;"<?php endif; ?>>
		<header class="entry-header">
			<hgroup>
				<h1 class="entry-title"><?php the_title(); ?></h1>
				<?php if ($subtitle = get_field('subtitle')) : ?>
				<h2 class="entry-subtitle"><?php echo $subtitle; ?></h2>
				<?php endif; ?>
			</hgroup>
			<a href="<?php the_field('link'); ?>" class="slide-link"></a>
		</header>
		
		<style type="text/css">
			#post-<?php the_ID(); ?> {
				background-image:url(<?php echo $thumb_url; ?>);
				background-size:<?php echo $thumb[1]; ?>px <?php echo $thumb[2]; ?>px;
			}
		
			#post-<?php the_ID(); ?> .entry-header hgroup {
				left: <?php the_field('caption_x'); ?>px;
				top: <?php the_field('caption_y'); ?>px;
			}
			
			#post-<?php the_ID(); ?> .entry-header hgroup,
			<?php if ($first_slide) : ?>
			nav a, nav .order a, #footer
			<?php else : ?>
			.slide-post-<?php the_ID(); ?> nav a, .slide-post-<?php the_ID(); ?> nav .order a, .slide-post-<?php the_ID(); ?> #footer
			<?php endif; ?> {
				color: <?php the_field('text_color'); ?>;
			}
		</style>
	</article><!-- #post -->