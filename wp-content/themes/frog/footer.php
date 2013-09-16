<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package Frog
 * @since Frog 1.0
 */
?>
	</div><!-- #main .wrapper -->
	<footer id="footer" role="contentinfo">
		<nav id="footer-nav" class="main-nav frog-nav" role="navigation">
			<?php wp_nav_menu( array( 'theme_location' => 'footer', 'menu_class' => 'nav-menu' ) ); ?>
		</nav>
		<?php if ($copyright = get_theme_mod('copyright')) : ?>
			<div id="copyright"><?php echo $copyright; ?></div>
		<?php endif; ?>
	</footer><!-- #colophon -->
</div><!-- #page -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-42574114-1', 'ilovefrog.com');
  ga('send', 'pageview');
</script>

<?php wp_footer(); ?>
</body>
</html>