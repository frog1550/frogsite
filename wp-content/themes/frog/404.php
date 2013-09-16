<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package Frog
 * @since Frog 1.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<article id="post-0" class="post error404 no-results not-found">
				<header class="entry-header">
					<hgroup class="entry-title">
						<h1><?php _e( 'Oops!', 'frog' ); ?></h1>
						<h2>We cant seem to find the page you were looking for.</h2>
					</hgroup>
				</header>
			</article><!-- #post-0 -->

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>