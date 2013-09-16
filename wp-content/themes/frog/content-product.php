<?php
/**
 * The default template for displaying tiles in the product types category.
 *
 * @package Frog
 * @since Frog 1.0
 */

$type = has_term_or_child(9, 'product_type') ? 'topping' : 'flavor' ;
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(array('multiple', get_field('text_class'))); ?> data-filters="<?php echo frog_product_filters(); ?>">
		<header class="entry-header">
			<?php if ($type == 'flavor') : ?><a href="<?php the_permalink(); ?>"><?php endif; ?>
			<?php
				if ($image = get_field('additional_image')) {
					echo wp_get_attachment_image($image, $type, array(
						'class' => 'attachment-' . $type . 'wp-post-image'
					));
				} else {
					the_post_thumbnail($type);
				}
			
			?>
			<hgroup class="entry-title">
				<h1><?php the_title(); ?></h1>
			</hgroup>
			<?php if ($type == 'flavor') : ?></a><?php endif; ?>
			<?php edit_post_link( __( 'Edit', 'frog' )); ?>
		</header><!-- .entry-header -->
	</article><!-- #post -->
