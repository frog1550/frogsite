<?php
/**
 * Setup custom post types for Frog
 *
 * @package Frog
 * @since Frog 1.0
 */

/**
 * Create custom post types:
 * Products, Locations, Slides, Jobs, FAQs
 *
 * @since Frog 1.0
 */
function frog_post_types() {
	// Products & Product Types
	register_post_type('product',
		array(
			'labels' => array(
				'name' => __( 'Products' ),
				'singular_name' => __( 'Product' ),
				'add_new' => _x('Add New', 'product'),
				'add_new_item' => __('Add New Product'),
				'edit_item' => __('Edit Product'),
				'new_item' => __('New Product'),
				'all_items' => __('All Products'),
				'view_item' => __('View Product'),
				'search_items' => __('Search Products'),
				'not_found' =>	__('No products found'),
				'not_found_in_trash' => __('No products found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Products'
			),
			'menu_position' => 5,
			'public' => true,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array('slug' => 'products'),
			'supports' => array('title', 'editor', 'thumbnail', 'revisions')
		)
	);

	register_taxonomy('product_type', 'product', array(
		'hierarchical' => true,
		'labels' => array(
			'name' => _x( 'Product Types', 'taxonomy general name' ),
			'singular_name' => _x( 'Product Type', 'taxonomy singular name' ),
			'search_items' =>  __( 'Search Product Types' ),
			'all_items' => __( 'All Product Types' ),
			'parent_item' => __( 'Parent Product Type' ),
			'parent_item_colon' => __( 'Parent Product Types:' ),
			'edit_item' => __( 'Edit Product Type' ), 
			'update_item' => __( 'Update Product Type' ),
			'add_new_item' => __( 'Add New Product Type' ),
			'new_item_name' => __( 'New Product Type Name' ),
			'menu_name' => __( 'Product Types' )
		),
		'show_ui' => true,
		'show_admin_column' => true,
		'query_var' => true,
		'rewrite' => array('slug' => 'menu')
	));

	// Locations
	register_post_type('location',
		array(
			'labels' => array(
				'name' => __( 'Locations' ),
				'singular_name' => __( 'Location' ),
				'add_new' => _x('Add New', 'location'),
				'add_new_item' => __('Add New Location'),
				'edit_item' => __('Edit Location'),
				'new_item' => __('New Location'),
				'all_items' => __('All Locations'),
				'view_item' => __('View Location'),
				'search_items' => __('Search Locations'),
				'not_found' =>	__('No locations found'),
				'not_found_in_trash' => __('No locations found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Locations'
			),
			'menu_position' => 5,
			'public' => true,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array('slug' => 'locations'),
			'supports' => array('title', 'thumbnail', 'revisions')
		)
	);

	// Slides
	register_post_type('slide',
		array(
			'labels' => array(
				'name' => __( 'Slides' ),
				'singular_name' => __( 'Slide' ),
				'add_new' => _x('Add New', 'slide'),
				'add_new_item' => __('Add New Slide'),
				'edit_item' => __('Edit Slide'),
				'new_item' => __('New Slide'),
				'all_items' => __('All Slides'),
				'view_item' => __('View Slide'),
				'search_items' => __('Search Slides'),
				'not_found' =>	__('No slides found'),
				'not_found_in_trash' => __('No slides found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Slides'
			),
			'menu_position' => 5,
			'public' => true,
			'has_archive' => true,
			'exclude_from_search' => false,
			'rewrite' => array('slug' => 'slides'),
			'supports' => array('title', 'thumbnail', 'revisions')
		)
	);
	
	// Jobs
	register_post_type('job',
		array(
			'labels' => array(
				'name' => __( 'Jobs' ),
				'singular_name' => __( 'Job' ),
				'add_new' => _x('Add New', 'job'),
				'add_new_item' => __('Add New Job'),
				'edit_item' => __('Edit Job'),
				'new_item' => __('New Job'),
				'all_items' => __('All Jobs'),
				'view_item' => __('View Job'),
				'search_items' => __('Search Jobs'),
				'not_found' =>	__('No jobs found'),
				'not_found_in_trash' => __('No jobs found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'Jobs'
			),
			'menu_position' => 5,
			'public' => true,
			'exclude_from_search' => false,
			'rewrite' => array('slug' => 'apply'),
			'supports' => array('title', 'editor', 'thumbnail', 'revisions')
		)
	);
	
	// FAQs
	register_post_type('faq',
		array(
			'labels' => array(
				'name' => __( 'FAQs' ),
				'singular_name' => __( 'FAQ' ),
				'add_new' => _x('Add New', 'faq'),
				'add_new_item' => __('Add New FAQ'),
				'edit_item' => __('Edit FAQ'),
				'new_item' => __('New FAQ'),
				'all_items' => __('All FAQs'),
				'view_item' => __('View FAQ'),
				'search_items' => __('Search FAQs'),
				'not_found' =>	__('No FAQs found'),
				'not_found_in_trash' => __('No FAQs found in Trash'), 
				'parent_item_colon' => '',
				'menu_name' => 'FAQs'
			),
			'menu_position' => 5,
			'public' => true,
			'exclude_from_search' => false,
			'supports' => array('title', 'editor', 'revisions')
		)
	);
}
add_action('init', 'frog_post_types');

/**
 * Sort products by title
 *
 * @since Frog 1.0
 */
function frog_products_orderby($query) {
	if (isset($query['product_type']) || isset($query['post_type']) && $query['post_type'] == 'product') { 
		$query['orderby'] = 'title';
		$query['order'] = 'ASC';
	}
	return $query;
}

add_filter( 'request', 'frog_products_orderby' );

/**
 * Setup icons for custom post types
 *
 * @since Frog 1.0
 */
function frog_post_type_icons() {
	?>
	<style type="text/css" media="screen">
		#menu-posts-product .wp-menu-image {
			background:url(<?php echo get_template_directory_uri(); ?>/img/admin/icon-product.png) no-repeat 6px -18px !important;
		}
		#menu-posts-product:hover .wp-menu-image,
		#menu-posts-product.wp-has-current-submenu .wp-menu-image {
			background-position:6px 6px!important;
		}

		#menu-posts-location .wp-menu-image {
			background:url(<?php echo get_template_directory_uri(); ?>/img/admin/icon-location.png) no-repeat 6px -17px !important;
		}
		#menu-posts-location:hover .wp-menu-image,
		#menu-posts-location.wp-has-current-submenu .wp-menu-image {
			background-position:6px 7px!important;
		}

		#menu-posts-slide .wp-menu-image {
			background:url(<?php echo get_template_directory_uri(); ?>/img/admin/icon-slide.png) no-repeat 6px -17px !important;
		}
		#menu-posts-slide:hover .wp-menu-image,
		#menu-posts-slide.wp-has-current-submenu .wp-menu-image {
			background-position:6px 7px!important;
		}
	</style>
	<?php
}
add_action( 'admin_head', 'frog_post_type_icons' );

/**
 * Setup custom post type columns
 *
 * @since Frog 1.0
 */
function frog_thumbnail_column_content($column_name, $post_ID) {
	if ($column_name == 'featured_image') {	 
		$image = get_post_thumbnail_id($post_ID);  
		if ($image) {  
			$image = wp_get_attachment_image_src($image);	
			echo '<img src="' . $image[0] . '" />';	
		}

	} elseif (substr($column_name, 0, 4)) {
		the_field(substr($column_name, 5));
	}
}
add_action('manage_posts_custom_column', 'frog_thumbnail_column_content', 10, 2);

function frog_thumbnail_column_head($defaults) {	
	global $post;

	$columns = array();
	foreach ($defaults as $key => $value) {
		$columns[$key] = $value;

		if ($key == 'cb') {
			$columns['featured_image'] = 'Featured Image';	
		}
	}

	return $columns;  
}
add_filter('manage_edit-product_columns', 'frog_thumbnail_column_head');
add_filter('manage_edit-slide_columns', 'frog_thumbnail_column_head');

function frog_slide_columns($defaults) {	
	global $post;

	$columns = array();
	foreach ($defaults as $key => $value) {
		$columns[$key] = $value;

		if ($key == 'title') {
			$columns['frog_subtitle'] = 'Subtitle';	
		}
	}

	return $columns;  
}
add_filter('manage_edit-slide_columns', 'frog_slide_columns');

function frog_location_columns($defaults) {	
	global $post;

	$columns = array();
	foreach ($defaults as $key => $value) {
		$columns[$key] = $value;

		if ($key == 'title') {
			$columns['frog_address'] = 'Address';
			$columns['frog_phone'] = 'Phone';	
		}
	}

	return $columns;  
}
add_filter('manage_edit-location_columns', 'frog_location_columns');

/**
 * Removes default post type
 *
 * @since Frog 1.0
 */
function frog_remove_default_post_type() {
		global $wp_post_types;
		//unset($wp_post_types['post']);
}
add_action('init', 'frog_remove_default_post_type');

/**
 * Removes unused admin menu items
 *
 * @since Frog 1.0
 */
function frog_remove_admin_menus () {
	global $menu;
	$restricted = array(__('Posts'), __('Comments'));
	end ($menu);
	while (prev($menu)){
		$value = explode(' ',$menu[key($menu)][0]);
		if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
	}
}
add_action('admin_menu', 'frog_remove_admin_menus');



function in_product_type($term) {
	global $post;
	return is_object_in_term($post->ID, 'product-type', $term);
}

/**
 * Tests if any of a product's assigned product types are descendants of target product types
 *
 * @since Frog 1.0
 */
function in_child_product_type($terms, $_post = null) {
	foreach ((array)$terms as $term) {
		$children = get_term_children((int)$cat, 'product_type');
		if ($children && in_category($children, $_post)) {
			return true;
		}
	}
	return false;
}

/**
 * Automatically sets the featured image of a location to a Google map.
 *
 * @since Frog 1.0
 */
function save_location_map($post_id) {
	$map_url = 'http://maps.googleapis.com/maps/api/staticmap?markers=%s&zoom=16&size=568x244&sensor=false';
	
	if ($parent_id = wp_is_post_revision($post_id)) {
		$post_id = $parent_id;
	}
	
	if (get_post_type($post_id) == 'location' && !has_post_thumbnail($post_id)) {
		// Generate map URL
		$address = strip_tags(get_field('address', $post_id));
		$address = trim(preg_replace('/\s+/', ' ', $address));
		$address = urlencode($address);
		$image_url = sprintf($map_url, $address);
		
		// Upload image
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename = "location-map-{$post_id}.png";
		
		if (wp_mkdir_p($upload_dir['path'])) {
			$file = $upload_dir['path'] . '/' . $filename;
		} else {
			$file = $upload_dir['basedir'] . '/' . $filename;
		}
		file_put_contents($file, $image_data);
		
		// Attach to post
		$wp_filetype = wp_check_filetype($filename, null);
		$attachment = array(
		    'post_mime_type' => $wp_filetype['type'],
		    'post_title' => sanitize_file_name($filename),
		    'post_content' => '',
		    'post_status' => 'inherit'
		);
		$attach_id = wp_insert_attachment($attachment, $file, $post_id);
		require_once(ABSPATH . 'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		wp_update_attachment_metadata($attach_id, $attach_data);
		
		// Set featured image
		set_post_thumbnail($post_id, $attach_id);
	}
}
add_action('save_post', 'save_location_map');