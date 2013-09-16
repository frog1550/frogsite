<?php if ($gallery = get_field('gallery')) : ?>
<footer class="entry-gallery cf">
	<?php foreach ($gallery as $i => $image) : ?>
		<span class="image image-<?php echo $i; ?>">
			<?php $image = wp_get_attachment_image_src($image['image'], 'medium'); ?>
			<img src="<?php echo $image[0]; ?>" alt="<?php the_title(); ?>" />
		</span>
	<?php endforeach; ?>
</footer><!-- .entry-gallery -->
<?php endif; ?>