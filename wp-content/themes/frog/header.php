<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package Frog
 * @since Frog 1.0
 */
?><!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if IE 9]> <html class="ie9 no-js"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js"> <!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<link rel="icon" href="/favicon.ico" type="image/x-icon">
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php if ($appid = get_theme_mod('fb_appid')) : ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $appid; ?>";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php endif; ?>

<div id="page" class="hfeed site">
	<header id="header" class="site-header" role="banner">
		<div class="content cf">
			<hgroup>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" class="ir" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
			</hgroup>

			<nav id="site-nav" class="main-nav frog-nav" role="navigation">
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
			</nav><!-- #site-navigation -->
		</div>
	</header><!-- #header -->

	<div id="main" class="wrapper content cf">