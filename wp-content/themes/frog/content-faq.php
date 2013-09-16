<?php
/**
 * The default template for displaying FAQs.
 *
 * @package Frog
 * @since Frog 1.0
 */

?>

	<article id="post-<?php the_ID(); ?>" <?php post_class('cf'); ?>>
		<header class="entry-header">
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<span class="arrow"></span>
			<?php edit_post_link( __( 'Edit', 'frog' )); ?>
		</header><!-- .entry-header -->
		<div class="entry-content">
			<?php the_content(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post -->
