<?php
/**
 * Frog functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * @package Frog
 * @since Frog 1.0
 */

/**
 * Sets up the content width value based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 960;

/**
 * Sets up theme defaults and registers the various WordPress features that
 * Frog supports.
 *
 * @since Frog 1.0
 */
function frog_setup() {
	date_default_timezone_set(get_option('timezone_string'));
	
	/*
	 * Makes Frog available for translation.
	 */
	load_theme_textdomain( 'frog', get_template_directory() . '/languages' );

	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();

	// Register menu locations
	register_nav_menu( 'primary', __( 'Primary Menu', 'frog' ) );
	register_nav_menu( 'footer', __( 'Footer Menu', 'frog' ) );

	// This theme uses a custom image size for featured images, displayed on "standard" posts.
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size(926, 550, true);
	
	// Image sizes
	add_image_size('large', 940, 568, true);
	add_image_size('medium', 290, 188, true);
	add_image_size('side', 300);
	
	add_image_size('product', 490, 390, true);
	add_image_size('flavor', 450, 180, true);
	add_image_size('topping', 212, 156, true);
	
	add_image_size('map', 568, 244, true);
	add_image_size('staff', 120, 96, true);
	
	add_image_size('large-promo', 455, 180, true);
	add_image_size('small-promo', 226, 126, true);
	
	add_image_size('icon', 50, 50, true);
}
add_action( 'after_setup_theme', 'frog_setup' );

/**
 * Setup custom post types
 */
require( get_template_directory() . '/inc/custom-post-types.php' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since Frog 1.0
 */
function frog_scripts_styles() {
	global $wp_styles;

	// Main stylesheet
	wp_enqueue_style( 'normalize', get_template_directory_uri() . '/css/normalize.css');
	wp_enqueue_style( 'frog-style', get_stylesheet_uri() );

	// Internet Explorer stylesheet
	wp_enqueue_style( 'frog-ie7', get_template_directory_uri() . '/css/ie7.css', array( 'frog-style' ));
	$wp_styles->add_data( 'frog-ie7', 'conditional', 'IE 7' );
	
	// Use Google API jQuery
	wp_deregister_script('jquery');
	wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js');
	wp_register_script('jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', array('jquery'));
	
	// Main scripts
	wp_enqueue_script('modernizr', get_template_directory_uri() . '/js/modernizr.js');
	wp_enqueue_script('frog-script', get_template_directory_uri() . '/js/frog.js', array('jquery-ui'));
	wp_localize_script('frog-script', 'wpAjax', array('url' => admin_url( 'admin-ajax.php' )));
	
	// Dequeue Easy Instagram scripts and stylesheets
	wp_dequeue_style('Easy_Instagram');
	wp_dequeue_style('thickbox');
	wp_dequeue_script('thickbox');
	
	if (is_tax('product_type')) {
		wp_enqueue_script('frog-products', get_template_directory_uri() . '/js/products.js', array('jquery-ui'));
	}
}
add_action( 'wp_enqueue_scripts', 'frog_scripts_styles', 999 );

/**
 * Auto-version scripts and styles
 *
 * @since 1.0
 * @param bool $echo Optional, default to true. Whether to display or return.
 * @return null|string Null on no title. String if $echo parameter is false.
 */
function frog_asset_timestamps($src) {
	if (strpos($src, get_template_directory_uri()) !== 0) {
		return $src;
	}
	
	$parts = explode('?', $src);
	$path = str_replace(get_template_directory_uri(), get_template_directory(), $parts[0]);
	$ver = filemtime($path);
	
	$src = remove_query_arg('ver', $src);
	$src = add_query_arg('ver', $ver, $src);
	return $src;
}
add_filter( 'style_loader_src', 'frog_asset_timestamps', 10, 2 );
add_filter( 'script_loader_src', 'frog_asset_timestamps', 10, 2 );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since Frog 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function frog_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() )
		return $title;

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title = "$title $sep $site_description";

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 )
		$title = "$title $sep " . sprintf( __( 'Page %s', 'frog' ), max( $paged, $page ) );

	return $title;
}
add_filter( 'wp_title', 'frog_wp_title', 10, 2 );

/**
 * Open Graph Tags
 *
 * @since Frog 1.0
 */
function open_graph_tags() {
	global $post;
	
	$defaults = array(
		'type' => 'website',
		'title' => wp_title('|', false, 'right'),
		'image' => get_template_directory_uri() . '/img/logo-frog-fb.jpg',
		'url' => 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'],
		'description' => get_bloginfo('description'),
		'site_name' => get_bloginfo('name')
	);
	
	$og = array();
	if (is_single()) {
		$og = array(
			'type' => 'article',
			'title' => get_the_title(),
			'url' => get_permalink(),
			'description' => $post->post_content
		);
		
		if (get_post_type($post->ID) == 'product') {
			$og['type'] = 'product';
			
		} elseif (get_post_type($post->ID) == 'location') {
			$og['type'] = 'place';
		}

		if (get_the_post_thumbnail($post->ID, 'thumbnail')) {
			$thumbnail_id = get_post_thumbnail_id();
			$thumbnail_object = get_post($thumbnail_id);
			$og['image'] = $thumbnail_object->guid;
		}
	} elseif (is_page() && !is_front_page()) {
		$og = array(
			'url' => get_permalink(),
			'description' => $post->post_content
		);
			
	} elseif (is_category() || is_tax()) {
		$og = array(
			'description' => category_description()
		);
	}
	
	if ($facebook = get_theme_mod('fb_appid')) {
		$og['fb:app_id'] = $facebook;
	}
	if ($twitter = get_theme_mod('twitter')) {
		$og['twitter:site'] = '@' . substr(strrchr($twitter, '/'), 1);
	}
	
	if (empty($og['description'])) {
		unset($og['description']);
	}
	
	$og = array_merge($defaults, $og);
	$og['description'] = wp_trim_words(strip_tags($og['description']), 55, '...');
	
	foreach ($og as $key => $value) :
		if (strpos($key, ':') === false) {
			$key = 'og:' . $key;
		}
?>
	<meta property="<?php echo $key; ?>" content="<?php echo $value; ?>" />
<?php
	endforeach;
}
add_action('wp_head', 'open_graph_tags');

if ( ! function_exists( 'frog_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since Frog 1.0
 */
function frog_content_nav( $html_id ) {
	global $wp_query;

	$html_id = esc_attr( $html_id );

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
			<h3 class="assistive-text"><?php _e( 'Post navigation', 'frog' ); ?></h3>
			<div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'frog' ) ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'frog' ) ); ?></div>
		</nav><!-- #<?php echo $html_id; ?> .navigation -->
	<?php endif;
}
endif;

if ( ! function_exists( 'frog_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own frog_entry_meta() to override in a child theme.
 *
 * @since Frog 1.0
 */
function frog_entry_meta() {
	// Translators: used between list items, there is a space after the comma.
	$categories_list = get_the_category_list( __( ', ', 'frog' ) );

	// Translators: used between list items, there is a space after the comma.
	$tag_list = get_the_tag_list( '', __( ', ', 'frog' ) );

	$date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() )
	);

	$author = sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s" title="%2$s" rel="author">%3$s</a></span>',
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( __( 'View all posts by %s', 'frog' ), get_the_author() ) ),
		get_the_author()
	);

	// Translators: 1 is category, 2 is tag, 3 is the date and 4 is the author's name.
	if ( $tag_list ) {
		$utility_text = __( 'This entry was posted in %1$s and tagged %2$s on %3$s<span class="by-author"> by %4$s</span>.', 'frog' );
	} elseif ( $categories_list ) {
		$utility_text = __( 'This entry was posted in %1$s on %3$s<span class="by-author"> by %4$s</span>.', 'frog' );
	} else {
		$utility_text = __( 'This entry was posted on %3$s<span class="by-author"> by %4$s</span>.', 'frog' );
	}

	printf(
		$utility_text,
		$categories_list,
		$tag_list,
		$date,
		$author
	);
}
endif;

function is_template() {
	$templates = func_get_args();
	if (empty($templates)) {
		return is_page_template();
	}
	
	foreach((array)$templates as $template) {
		if (strpos($template, '.php') === false) {
			$template .= '.php';
		}
		if (is_page_template($template) || is_page_template('templates/' . $template)) {
			return true;
		}
	}
	
	return false;
}


/**
 * Extends the default WordPress body class
 *
 * @since Frog 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function frog_body_class( $classes ) {
	foreach ($classes as &$class) {
		$class = str_replace('page-template-templates', 'template-', $class);
		$class = str_replace('-php', '', $class);
		
		$class = str_replace('tax-product_type', 'product-type', $class);
	}
	
	// Pages
	if (is_page()) {
		$classes[] = 'page-' . get_slug();
	}
	
	if (is_page() && has_post_thumbnail()) {
		$classes[] = 'has-post-thumbnail';
	}
	
	if (is_template('product', 'nutrition', 'takeout')) {
		$classes[] = 'has-hero';
	}
	if (is_page('franchise')) {
		$classes[] = 'template-project';
	}
	
	// Flavors
	$terms = get_term_children(3, 'product_type');
	$terms[] = 3;
	if (is_tax('product_type', $terms)) {
		$classes[] = 'flavors';
	}
	
	// Toppings
	$terms = get_term_children(9, 'product_type');
	$terms[] = 9;
	if (is_tax('product_type', $terms)) {
		$classes[] = 'toppings';
	}

	// Jobs
	if (in_array('single-job', $classes)) {
		$classes[] = 'template-project';
	}

	return $classes;
}
add_filter( 'body_class', 'frog_body_class' );

/**
 * Extends the default WordPress post class
 *
 * @since Frog 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function frog_post_class($classes) {
	global $post;
	
	global $odd_even_class;
	$odd_even_class = ($odd_even_class == 'odd') ? 'even' : 'odd';
	$classes[] = $odd_even_class;
	
	global $index_class;
	$index_class = is_null($index_class) ? 0 : $index_class + 1;
	$classes[] = 'post-' . $index_class;
	
	if ($post->post_type == 'product') {
		$classes[] = 'product';
		$classes[] = has_term_or_child(9, 'product_type') ? 'topping' : 'flavor' ;
	}

	return $classes;
}
add_filter('post_class', 'frog_post_class');

/**
 * Add custom settings to the Theme Customizer.
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @since Frog 1.0
 */
function frog_customize_register( $wp_customize ) {
	// Add social settings
	$wp_customize->add_section('frog_social' , array(
		'title' => 'Social Options',
		'priority' => 30
	));
	
	$wp_customize->add_setting('fb_appid');
	$wp_customize->add_control('fb_appid', array(
		'label' => 'Facebook App ID',
		'section' => 'frog_social',
		'settings' => 'fb_appid'
	));
	
	$wp_customize->add_setting('facebook', array('default' => 'https://facebook.com/'));
	$wp_customize->add_control('facebook', array(
		'label' => 'Facebook URL',
		'section' => 'frog_social',
		'settings' => 'facebook'
	));
	
	$wp_customize->add_setting('twitter', array('default' => 'https://twitter.com/'));
	$wp_customize->add_control('twitter', array(
		'label' => 'Twitter URL',
		'section' => 'frog_social',
		'settings' => 'twitter'
	));
	
	$wp_customize->add_setting('instagram', array('default' => 'http://instagram.com/'));
	$wp_customize->add_control('instagram', array(
		'label' => 'Instagram URL',
		'section' => 'frog_social',
		'settings' => 'instagram'
	));
	
	// Copyright
	$wp_customize->add_setting('copyright');
	$wp_customize->add_control('copyright', array(
		'label' => 'Copyright',
		'section' => 'title_tagline',
		'settings' => 'copyright'
	));
	
	// Add postMessage Support
	$wp_customize->get_setting('blogname')->transport = 'postMessage';
	$wp_customize->get_setting('blogdescription')->transport = 'postMessage';
}
add_action( 'customize_register', 'frog_customize_register' );

/**
 * Add "has-sub-menu" CSS class to navigation menu items that have a submenu.
 *
 * @since Frog 1.0
 */
function add_menu_parent_class($items) {
	$parents = array();
	foreach ($items as $item) {
		if ($item->menu_item_parent && $item->menu_item_parent > 0) {
			$parents[] = $item->menu_item_parent;
		}
	}

	foreach ($items as $item) {
		$levels = get_menu_levels($item, $items);
		if ($levels == 1) {
			$item->classes[] = 'has-1-level';
		} else {
			$item->classes[] = "has-{$levels}-levels";
		}
		
		$levels = get_current_menu_levels($item, $items);
		if ($levels == 1) {
			$item->classes[] = 'has-1-current-level';
		} else {
			$item->classes[] = "has-{$levels}-current-levels";
		}
		
		if (in_array($item->ID, $parents)) {
			$item->classes[] = 'has-sub-menu'; 
		}
	}

	return $items;	  
}
function get_menu_levels(&$parent, &$items) {
	$level = 1;
	$id = $parent->ID;
	foreach ($items as $item) {
		if ($item->menu_item_parent == $id) {
			$level = max($level, get_menu_levels($item, $items) + 1, 2);
		}
	}
	
	return $level;
}
function get_current_menu_levels(&$parent, &$items) {
	$level = 0;
	foreach ($parent->classes as $class) {
		if (strpos($class, 'current') !== false) {
			$level = 1;
			break;
		}
	}
	
	if ($level) {
		$id = $parent->ID;
		foreach ($items as $item) {
			if ($item->menu_item_parent == $id) {
				foreach ($item->classes as $class) {
					if (strpos($class, 'current') !== false) {
						$level = max($level, get_current_menu_levels($item, $items) + 1, 2);
						break;
					}
				}
			}
		}
	}
	
	return $level;
}
add_filter('wp_nav_menu_objects', 'add_menu_parent_class');


/**
 * Display section-specific menus
 *
 * @since Frog 1.0
 */
function frog_post_template() {
	if (!in_array(get_post_type(), get_post_types(array('_builtin' => true)))) {
		if (get_post_type() == 'product' && is_single()) {
			return 'product-single';
		}
		
		return get_post_type();
	}
	
	return get_post_format();
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Frog 1.0
 */
function frog_customize_preview_js() {
	wp_enqueue_script( 'frog-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20120827', true );
}
add_action( 'customize_preview_init', 'frog_customize_preview_js' );

/**
 * Tests if any of a post's is assigned to a term or any of its children.
 *
 * @since Frog 1.0
 */
function has_term_or_child($terms, $taxonomy, $post = null) {
	if (has_term($terms, $taxonomy, $post)) {
		return true;
	}
	
	foreach ((array)$terms as $term) {
		$children = get_term_children($term, $taxonomy);
		if (has_term($children, $taxonomy, $post)) {
			return true;
		}
	}
	
	return false;
}

/**
 * Handle product AJAX
 *
 * @since Frog 1.0
 */
function frog_ajax_get_product() {
	global $post;
	$post = get_page_by_path($_POST['slug'], OBJECT, 'product');
	setup_postdata($post);
	get_template_part('content', 'product-single');
	die();
}
add_action('wp_ajax_get_product', 'frog_ajax_get_product');
add_action('wp_ajax_nopriv_get_product', 'frog_ajax_get_product');

/**
 * Order Now Shortcode
 *
 * @since Frog 1.0
 */
function frog_sc_ordernow($atts){
	return '<a href="' . home_url('/order-online/') . '" class="order-now">Order Now</a>';
}
add_shortcode('ordernow', 'frog_sc_ordernow');

/**
 * TinyMCE Custom Options
 *
 * @since Frog 1.0
 */
function frog_tiny_mce_init($init) {
	$init['theme_advanced_blockformats'] = 'p,h2,h3,h4,h5,h6';
	return $init;
}
add_filter('tiny_mce_before_init', 'frog_tiny_mce_init' );

/**
 * Slug functions
 *
 * @since Frog 1.0
 */
if (!function_exists('get_slug')) {
	function get_slug($post = null){
		$post = get_post($post);
		return basename(get_permalink($post->ID));
	}
}
if (!function_exists('the_slug')) {
	function the_slug($echo = true){
		$slug = get_slug();
	
		if ($echo) 
			echo $slug;
		else
			return $slug;
	}
}

/**
 * Disable search
 *
 * @since Frog 1.0
 */
function frog_request($query_vars) {
	if (!is_admin()) {
		unset($query_vars['s']);
	}
	
	return $query_vars;
}
add_filter('request', 'frog_request');

/**
 * Display flavor icons
 *
 * @since Frog 1.0
 */
function frog_flavor_icons() {
	$icons = get_field('flavor_icons');
	if (!$icons) return;
	
	foreach ($icons as $icon)  {
		echo wp_get_attachment_image($icon['image'], 'icon', false, array(
			'class' => 'icon'
		));
	}
}

/**
 * Get and prepare location hours
 *
 * @since Frog 1.0
 */
function get_location_hours() {
	$data = get_field('hours');
	if (!$data) {
		return false;
	}

	$open = false;
	$hours = array();
	$dow = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');	
	
	$now_day = date('w');
	$now_time = date('H:i');
	
	foreach ($data as $i => $row) {
		$last = false;
		$range = $j = 0;
		$count = count($row['days']);
		
		$hours[$i] = array(
			'days' => '',
			'open' => strtotime($row['open']),
			'close' => strtotime($row['close'])
		);
		$hours[$i]['open'] = date((date('i', $hours[$i]['open']) == '00') ? 'ga' : 'g:ia', $hours[$i]['open']);
		$hours[$i]['close'] = date((date('i', $hours[$i]['close']) == '00') ? 'ga' : 'g:ia', $hours[$i]['close']);
		
		$today_open = $row['open'];
		if ($row['close'] < $row['open']) {
			$today_close = '23:59';
			$tomorrow_open = '00:00';
			$tomorrow_close = $row['close'];
		} else {
			$today_close = $row['close'];
			$tomorrow_open = false;
			$tomorrow_close = false;
		}
		
		foreach ($row['days'] as $day) {
			if (
				($day == $now_day && $now_time >= $today_open && $now_time <= $today_close) ||
				($day == $now_day + 1 && $tomorrow_open !== false && $now_time >= $tomorrow_open && $now_time <= $tomorrow_close)
			) {
				$open = true;
			}			
			
			if ($last === false) {
				$hours[$i]['days'] .= $dow[$day];
				
			} else {
				if ($day != $last + 1) {
					if ($range > 1) {
						$hours[$i]['days'] .= '-' . $dow[$last];
					}
					$range = 0;
				}
				
				if ($range == 0) {
					$hours[$i]['days'] .= ', ' . $dow[$day];
					
				} elseif ($j == $count - 1) {
					$hours[$i]['days'] .= $range ? '-' : ', ';
					$hours[$i]['days'] .= $dow[$day];
				}
			}

			$j++;
			$range++;
			$last = $day;
		}
	}
	
	return array('hours' => $hours, 'open' => $open);
}

/**
 * Get Product Filters
 *
 * @since Frog 1.0
 */
function frog_product_filters() {
	global $post;
	
	$terms = get_the_terms($post->ID, 'product_type');
	$filters = array();
	foreach ($terms as $term) {
		$filters[] = $term->slug;
	}
	
	return implode(' ', $filters);
}

/**
 * Email form results
 *
 * @since Frog 1.0
 */
function email_form_data($subject, $fields) {
	$to = 'info@ilovefrog.com';
	
	$body = '';
	$data = array_intersect_key($_POST, array_flip($fields));
	foreach ($data as $label => $value) {
		if ($label == 'resume') {
			
			continue;
		}
		$label = ucwords(str_replace('_', ' ', $label));
		$body .= "{$label}: {$value}\r\n\r\n";
	}
	
	$attachments = array();
	$files = array_intersect_key($_FILES, array_flip($fields));
	foreach ($files as $label => $file) {
		if($file['name'] != '') {
			$path = WP_CONTENT_DIR . '/uploads/forms/' . $file['name'];
			if (move_uploaded_file($file['tmp_name'], $path)) {
				$attachments = array($path);
			}
		}  
	}
	
	$headers = array(
		'From: Frog <no-reply@ilovefrog.com>',
		'Reply-To: ' . $data['email']
	);
	$headers = implode("\r\n", $headers);
	
	wp_mail($to, $subject, $body, $headers, $attachments);

}

/**
 * Frog logo at login
 *
 * @since Frog 1.0
 */
function my_login_head() {
?>
	<style>
		body.login #login h1 a {
			background-image:url(<?php echo get_bloginfo('template_url'); ?>/img/logo-frog.png);
			background-size:auto;
			margin-left:8px;
			width:124px;
			height:63px;
		}
	</style>
<?php
}
add_action("login_head", "my_login_head");

/**
 * Katana gift card API
 *
 * @since Frog 1.0
 */
require_once('card/katana.php');
function get_card_api() {
	static $api;
	
	if (empty($api)) {
		$api = new Katana(array(
	 		'key' => 'ch98ecuwa9af',
		 	'domain' => 'hps',
		 	'chain' => '111217050252'
		));
	}
	
	return $api;
}
function get_card_balance($username, $password) {
	$api = get_card_api();
	$response = $api->getAccount(array(
		'username' => $username,
		'password' => $password
	));
	
	$response['balance'] = $response['points'] = 0;
	
	if (!empty($response['balances'])) {
		foreach ($response['balances'] as $balance) {
			if ($balance['currency'] == 'USD') {
				$response['balance'] += $balance['amount'];
			} elseif ($balance['currency'] == 'Points') {
				$response['points'] += $balance['amount'];
			}
		}
	}
	
	setlocale(LC_MONETARY, 'en_US');
	$response['balance'] = money_format('%n', $response['balance'] / 100);
	
	return $response;
}
function register_card($id, $pin, $data = array()) {
	$api = get_card_api();
	
	$user_fields = array(
		'first-name',
		'last-name',
		'email',
		'voice-phone',
		'birth-date',
		'gender'
	);
	
	$account = array('id' => $id, 'pin' => $pin);
	$user = array_intersect_key($data, array_flip($user_fields));
	
	if (empty($user['id'])) {
		$user['id'] = $user['email'];
	}
	
	$response = $api->createUser($user, $account);
	
	return true;
}

/**
 * Cycle through values
 *
 */
function cycle($first_value, $values = '*') {
	static $count = array();

	$values = func_get_args();
	$name = implode('-', $values);

	$last_item = end($values);
	if (substr($last_item, 0, 1) === ':') {
		$name = substr($last_item, 1);
		array_pop($values);
	}

	if (!isset($count[$name])) {
		$count[$name] = 0;
	}

	$index = $count[$name] % count($values);
	$count[$name]++;
	
	return $values[$index];  
}

/**
 * Retrieve featured image url.
 *
 * @param mixed $post Optional. Post ID or object.
 * @return string
 */
if (!function_exists('get_post_thumbnail_url')) {
	function get_post_thumbnail_url($post_id = null, $size = 'post-thumbnail'){
		$post_id = (null === $post_id) ? get_the_ID() : $post_id;
		$post_thumbnail_id = get_post_thumbnail_id($post_id);
		
		if ($post_thumbnail_id) {
			$size = apply_filters('post_thumbnail_size', $size);
			$thumb = wp_get_attachment_image_src($post_thumbnail_id , $size);
			if (!empty($thumb[0])) {
				return $thumb[0];
			}
		}
		
		return false;
	}
}