<?php
/* Woocommerce support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 1 - register filters, that add/remove lists items for the Theme Options
if (!function_exists('prodent_woocommerce_theme_setup1')) {
	add_action( 'after_setup_theme', 'prodent_woocommerce_theme_setup1', 1 );
	function prodent_woocommerce_theme_setup1() {

		add_theme_support( 'woocommerce' );

		// Next setting from the WooCommerce 3.0+ enable built-in image zoom on the single product page
		add_theme_support( 'wc-product-gallery-zoom' );

		// Next setting from the WooCommerce 3.0+ enable built-in image slider on the single product page
		add_theme_support( 'wc-product-gallery-slider' ); 

		// Next setting from the WooCommerce 3.0+ enable built-in image lightbox on the single product page
		add_theme_support( 'wc-product-gallery-lightbox' );

		add_filter( 'prodent_filter_list_sidebars', 	'prodent_woocommerce_list_sidebars' );
		add_filter( 'prodent_filter_list_posts_types',	'prodent_woocommerce_list_post_types');
	}
}

// Theme init priorities:
// 3 - add/remove Theme Options elements
if (!function_exists('prodent_woocommerce_theme_setup3')) {
	add_action( 'after_setup_theme', 'prodent_woocommerce_theme_setup3', 3 );
	function prodent_woocommerce_theme_setup3() {
		if (prodent_exists_woocommerce()) {
		
			// Section 'WooCommerce'
			prodent_storage_set_array_before('options', 'fonts', array_merge(
				array(
					'shop' => array(
						"title" => esc_html__('Shop', 'prodent'),
						"desc" => wp_kses_data( __('Select parameters to display the shop pages', 'prodent') ),
						"priority" => 80,
						"type" => "section"
						),

					'products_info_shop' => array(
						"title" => esc_html__('Products list', 'prodent'),
						"desc" => '',
						"type" => "info",
						),
					'posts_per_page_shop' => array(
						"title" => esc_html__('Products per page', 'prodent'),
						"desc" => wp_kses_data( __('How many products should be displayed on the shop page. If empty - use global value from the menu Settings - Reading', 'prodent') ),
						"std" => '',
						"type" => "text"
						),
					'blog_columns_shop' => array(
						"title" => esc_html__('Shop loop columns', 'prodent'),
						"desc" => wp_kses_data( __('How many columns should be used in the shop loop (from 2 to 4)?', 'prodent') ),
						"std" => 2,
						"options" => prodent_get_list_range(2,4),
						"type" => "select"
						),
					'shop_mode' => array(
						"title" => esc_html__('Shop mode', 'prodent'),
						"desc" => wp_kses_data( __('Select style for the products list', 'prodent') ),
						"std" => 'thumbs',
						"options" => array(
							'thumbs'=> esc_html__('Thumbnails', 'prodent'),
							'list'	=> esc_html__('List', 'prodent'),
						),
						"type" => "select"
						),
					'shop_hover' => array(
						"title" => esc_html__('Hover style', 'prodent'),
						"desc" => wp_kses_data( __('Hover style on the products in the shop archive', 'prodent') ),
						"std" => 'none',
						"options" => apply_filters('prodent_filter_shop_hover', array(
							'none' => esc_html__('None', 'prodent'),
							'shop' => esc_html__('Icons', 'prodent'),
							'shop_buttons' => esc_html__('Buttons', 'prodent')
						)),
						"type" => "select"
						),

					'single_info_shop' => array(
						"title" => esc_html__('Single product', 'prodent'),
						"desc" => '',
						"type" => "info",
						),
					'stretch_tabs_area' => array(
						"title" => esc_html__('Stretch tabs area', 'prodent'),
						"desc" => wp_kses_data( __('Stretch area with tabs on the single product to the screen width if the sidebar is hidden', 'prodent') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'show_related_posts_shop' => array(
						"title" => esc_html__('Show related products', 'prodent'),
						"desc" => wp_kses_data( __("Show section 'Related products' on the single product page", 'prodent') ),
						"std" => 1,
						"type" => "checkbox"
						),
					'related_posts_shop' => array(
						"title" => esc_html__('Related products', 'prodent'),
						"desc" => wp_kses_data( __('How many related products should be displayed on the single product page?', 'prodent') ),
						"dependency" => array(
							'show_related_posts_shop' => array(1)
						),
						"std" => 4,
						"options" => prodent_get_list_range(1,9),
						"type" => "select"
						),
					'related_columns_shop' => array(
						"title" => esc_html__('Related columns', 'prodent'),
						"desc" => wp_kses_data( __('How many columns should be used to output related products on the single product page?', 'prodent') ),
						"dependency" => array(
							'show_related_posts_shop' => array(1)
						),
						"std" => 4,
						"options" => prodent_get_list_range(1,4),
						"type" => "select"
						)
				),
				prodent_options_get_list_cpt_options('shop')
			));
		}
	}
}


// Add section 'Products' to the Front Page option
if (!function_exists('prodent_woocommerce_front_page_options')) {
	if (!PRODENT_THEME_FREE) add_filter( 'prodent_filter_front_page_options', 'prodent_woocommerce_front_page_options' );
	function prodent_woocommerce_front_page_options($options) {
		if (prodent_exists_woocommerce()) {

			$options['front_page_sections']['std'] .= (!empty($options['front_page_sections']['std']) ? '|' : '') . 'woocommerce=1';
			$options['front_page_sections']['options'] = array_merge($options['front_page_sections']['options'], 
																	array(
																		'woocommerce' => esc_html__('Products', 'prodent')
																		)
																	);
			$options = array_merge($options, array(
			
				// Front Page Sections - WooCommerce
				'front_page_woocommerce' => array(
					"title" => esc_html__('Products', 'prodent'),
					"desc" => '',
					"priority" => 200,
					"type" => "section",
					),
				'front_page_woocommerce_layout_info' => array(
					"title" => esc_html__('Layout', 'prodent'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_fullheight' => array(
					"title" => esc_html__('Full height', 'prodent'),
					"desc" => wp_kses_data( __('Stretch this section to the window height', 'prodent') ),
					"std" => 0,
					"refresh" => false,
					"type" => "checkbox"
					),
				'front_page_woocommerce_paddings' => array(
					"title" => esc_html__('Paddings', 'prodent'),
					"desc" => wp_kses_data( __('Select paddings inside this section', 'prodent') ),
					"std" => 'medium',
					"options" => prodent_get_list_paddings(),
					"refresh" => false,
					"type" => "switch"
					),
				'front_page_woocommerce_heading_info' => array(
					"title" => esc_html__('Title', 'prodent'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_caption' => array(
					"title" => esc_html__('Section title', 'prodent'),
					"desc" => '',
					"refresh" => false, //'.front_page_section_woocommerce .front_page_section_woocommerce_caption',
					"std" => wp_kses_data(__('This text can be changed in the section "Products"', 'prodent')),
					"type" => "text"
					),
				'front_page_woocommerce_description' => array(
					"title" => esc_html__('Description', 'prodent'),
					"desc" => wp_kses_data( __("Short description after the section's title", 'prodent') ),
					"refresh" => false, //'.front_page_section_woocommerce .front_page_section_woocommerce_description',
					"std" => wp_kses_data(__('This text can be changed in the section "Products"', 'prodent')),
					"type" => "textarea"
					),
				'front_page_woocommerce_products_info' => array(
					"title" => esc_html__('Products parameters', 'prodent'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_products' => array(
					"title" => esc_html__('Type of the products', 'prodent'),
					"desc" => '',
					"std" => 'products',
					"options" => array(
									'recent_products' => esc_html__('Recent products', 'prodent'),
									'featured_products' => esc_html__('Featured products', 'prodent'),
									'top_rated_products' => esc_html__('Top rated products', 'prodent'),
									'sale_products' => esc_html__('Sale products', 'prodent'),
									'best_selling_products' => esc_html__('Best selling products', 'prodent'),
									'product_category' => esc_html__('Products from categories', 'prodent'),
									'products' => esc_html__('Products by IDs', 'prodent')
									),
					"type" => "select"
					),
				'front_page_woocommerce_products_categories' => array(
					"title" => esc_html__('Categories', 'prodent'),
					"desc" => esc_html__('Comma separated category slugs. Used only with "Products from categories"', 'prodent'),
					"dependency" => array(
						'front_page_woocommerce_products' => array('product_category')
					),
					"std" => '',
					"type" => "text"
					),
				'front_page_woocommerce_products_per_page' => array(
					"title" => esc_html__('Per page', 'prodent'),
					"desc" => wp_kses_data( __('How many products will be displayed on the page. Attention! For "Products by IDs" specify comma separated list of the IDs', 'prodent') ),
					"std" => 3,
					"type" => "text"
					),
				'front_page_woocommerce_products_columns' => array(
					"title" => esc_html__('Columns', 'prodent'),
					"desc" => wp_kses_data( __("How many columns will be used", 'prodent') ),
					"std" => 3,
					"type" => "text"
					),
				'front_page_woocommerce_products_orderby' => array(
					"title" => esc_html__('Order by', 'prodent'),
					"desc" => wp_kses_data( __("Not used with Best selling products", 'prodent') ),
					"std" => 'date',
					"options" => array(
									'date' => esc_html__('Date', 'prodent'),
									'title' => esc_html__('Title', 'prodent')
									),
					"type" => "switch"
					),
				'front_page_woocommerce_products_order' => array(
					"title" => esc_html__('Order', 'prodent'),
					"desc" => wp_kses_data( __("Not used with Best selling products", 'prodent') ),
					"std" => 'desc',
					"options" => array(
									'asc' => esc_html__('Ascending', 'prodent'),
									'desc' => esc_html__('Descending', 'prodent')
									),
					"type" => "switch"
					),
				'front_page_woocommerce_color_info' => array(
					"title" => esc_html__('Colors and images', 'prodent'),
					"desc" => '',
					"type" => "info",
					),
				'front_page_woocommerce_scheme' => array(
					"title" => esc_html__('Color scheme', 'prodent'),
					"desc" => wp_kses_data( __('Color scheme for this section', 'prodent') ),
					"std" => 'inherit',
					"options" => array(),
					"refresh" => false,
					"type" => "switch"
					),
				'front_page_woocommerce_bg_image' => array(
					"title" => esc_html__('Background image', 'prodent'),
					"desc" => wp_kses_data( __('Select or upload background image for this section', 'prodent') ),
					"refresh" => '.front_page_section_woocommerce',
					"refresh_wrapper" => true,
					"std" => '',
					"type" => "image"
					),
				'front_page_woocommerce_bg_color' => array(
					"title" => esc_html__('Background color', 'prodent'),
					"desc" => wp_kses_data( __('Background color for this section', 'prodent') ),
					"std" => '',
					"refresh" => false,
					"type" => "color"
					),
				'front_page_woocommerce_bg_mask' => array(
					"title" => esc_html__('Background mask', 'prodent'),
					"desc" => wp_kses_data( __('Use Background color as section mask with specified opacity. If 0 - mask is not used', 'prodent') ),
					"std" => 1,
					"max" => 1,
					"step" => 0.1,
					"refresh" => false,
					"type" => "slider"
					),
				'front_page_woocommerce_anchor_info' => array(
					"title" => esc_html__('Anchor', 'prodent'),
					"desc" => wp_kses_data( __('You can select icon and/or specify a text to create anchor for this section and show it in the side menu (if selected in the section "Header - Menu".', 'prodent'))
								. '<br>'
								. wp_kses_data(__('Attention! Anchors available only if plugin "ThemeREX Addons is installed and activated!', 'prodent')),
					"type" => "info",
					),
				'front_page_woocommerce_anchor_icon' => array(
					"title" => esc_html__('Anchor icon', 'prodent'),
					"desc" => '',
					"std" => '',
					"type" => "icon"
					),
				'front_page_woocommerce_anchor_text' => array(
					"title" => esc_html__('Anchor text', 'prodent'),
					"desc" => '',
					"std" => '',
					"type" => "text"
					)
			));
		}
		return $options;
	}
}

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prodent_woocommerce_theme_setup9')) {
	add_action( 'after_setup_theme', 'prodent_woocommerce_theme_setup9', 9 );
	function prodent_woocommerce_theme_setup9() {
		
		if (prodent_exists_woocommerce()) {
			add_action( 'wp_enqueue_scripts', 								'prodent_woocommerce_frontend_scripts', 1100 );
			add_filter( 'prodent_filter_merge_styles',						'prodent_woocommerce_merge_styles' );
			add_filter( 'prodent_filter_merge_scripts',						'prodent_woocommerce_merge_scripts');
			add_filter( 'prodent_filter_get_post_info',		 				'prodent_woocommerce_get_post_info');
			add_filter( 'prodent_filter_post_type_taxonomy',				'prodent_woocommerce_post_type_taxonomy', 10, 2 );
			add_action( 'prodent_action_override_theme_options',			'prodent_woocommerce_override_theme_options');
			if (!is_admin()) {
				add_filter( 'prodent_filter_detect_blog_mode',				'prodent_woocommerce_detect_blog_mode');
				add_filter( 'prodent_filter_get_post_categories', 			'prodent_woocommerce_get_post_categories');
				add_filter( 'prodent_filter_allow_override_header_image',	'prodent_woocommerce_allow_override_header_image');
				add_filter( 'prodent_filter_get_blog_title',				'prodent_woocommerce_get_blog_title');
				add_action( 'prodent_action_before_post_meta',				'prodent_woocommerce_action_before_post_meta');
				add_action( 'pre_get_posts',								'prodent_woocommerce_pre_get_posts');
				add_filter( 'prodent_filter_localize_script',				'prodent_woocommerce_localize_script');
			}
		}
		if (is_admin()) {
			add_filter( 'prodent_filter_tgmpa_required_plugins',			'prodent_woocommerce_tgmpa_required_plugins' );
		}

		// Add wrappers and classes to the standard WooCommerce output
		if (prodent_exists_woocommerce()) {

			// Remove WOOC sidebar
			remove_action( 'woocommerce_sidebar', 						'woocommerce_get_sidebar', 10 );

			// Remove link around product item
			remove_action('woocommerce_before_shop_loop_item',			'woocommerce_template_loop_product_link_open', 10);
			remove_action('woocommerce_after_shop_loop_item',			'woocommerce_template_loop_product_link_close', 5);

			// Remove add_to_cart button
			//remove_action('woocommerce_after_shop_loop_item',			'woocommerce_template_loop_add_to_cart', 10);
			
			// Remove link around product category
			remove_action('woocommerce_before_subcategory',				'woocommerce_template_loop_category_link_open', 10);
			remove_action('woocommerce_after_subcategory',				'woocommerce_template_loop_category_link_close', 10);
			
			// Open main content wrapper - <article>
			remove_action( 'woocommerce_before_main_content',			'woocommerce_output_content_wrapper', 10);
			add_action(    'woocommerce_before_main_content',			'prodent_woocommerce_wrapper_start', 10);
			// Close main content wrapper - </article>
			remove_action( 'woocommerce_after_main_content',			'woocommerce_output_content_wrapper_end', 10);		
			add_action(    'woocommerce_after_main_content',			'prodent_woocommerce_wrapper_end', 10);

			// Close header section
			add_action(    'woocommerce_before_shop_loop',				'prodent_woocommerce_archive_description', 5 );
			add_action(    'woocommerce_no_products_found',				'prodent_woocommerce_archive_description', 5 );

			// Add theme specific search form
			add_filter(    'get_product_search_form',					'prodent_woocommerce_get_product_search_form' );

			// Add list mode buttons
			add_action(    'woocommerce_before_shop_loop', 				'prodent_woocommerce_before_shop_loop', 10 );

			// Set columns number for the products loop
			add_filter(    'loop_shop_columns',							'prodent_woocommerce_loop_shop_columns' );
			add_filter(    'post_class',								'prodent_woocommerce_loop_shop_columns_class' );
			add_filter(    'product_cat_class',							'prodent_woocommerce_loop_shop_columns_class', 10, 3 );
			// Open product/category item wrapper
			add_action(    'woocommerce_before_subcategory_title',		'prodent_woocommerce_item_wrapper_start', 9 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'prodent_woocommerce_item_wrapper_start', 9 );
			// Close featured image wrapper and open title wrapper
			add_action(    'woocommerce_before_subcategory_title',		'prodent_woocommerce_title_wrapper_start', 20 );
			add_action(    'woocommerce_before_shop_loop_item_title',	'prodent_woocommerce_title_wrapper_start', 20 );

			// Add tags before title
			add_action(    'woocommerce_before_shop_loop_item_title',	'prodent_woocommerce_title_tags', 30 );

			// Wrap product title into link
			add_action(    'the_title',									'prodent_woocommerce_the_title');
			// Wrap category title into link
            remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
			add_action(		'woocommerce_shop_loop_subcategory_title',  'prodent_woocommerce_shop_loop_subcategory_title', 9, 1);

			// Close title wrapper and add description in the list mode
			add_action(    'woocommerce_after_shop_loop_item_title',	'prodent_woocommerce_title_wrapper_end', 7);
			add_action(    'woocommerce_after_subcategory_title',		'prodent_woocommerce_title_wrapper_end2', 10 );
			// Close product/category item wrapper
			add_action(    'woocommerce_after_subcategory',				'prodent_woocommerce_item_wrapper_end', 20 );
			add_action(    'woocommerce_after_shop_loop_item',			'prodent_woocommerce_item_wrapper_end', 20 );

			// Add product ID into product meta section (after categories and tags)
			add_action(    'woocommerce_product_meta_end',				'prodent_woocommerce_show_product_id', 10);
			
			// Set columns number for the product's thumbnails
			add_filter(    'woocommerce_product_thumbnails_columns',	'prodent_woocommerce_product_thumbnails_columns' );


			// Detect current shop mode
			if (!is_admin()) {
				$shop_mode = prodent_get_value_gpc('prodent_shop_mode');
				if (empty($shop_mode) && prodent_check_theme_option('shop_mode'))
					$shop_mode = prodent_get_theme_option('shop_mode');
				if (empty($shop_mode))
					$shop_mode = 'thumbs';
				prodent_storage_set('shop_mode', $shop_mode);
			}
		}
	}
}

// Theme init priorities:
// Action 'wp'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)
if (!function_exists('prodent_woocommerce_theme_setup_wp')) {
	add_action( 'wp', 'prodent_woocommerce_theme_setup_wp' );
	function prodent_woocommerce_theme_setup_wp() {
		if (prodent_exists_woocommerce()) {
			// Set columns number for the related products
			if ((int) prodent_get_theme_option('show_related_posts') == 0 || (int) prodent_get_theme_option('related_posts') == 0) {
				remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
			} else {
				add_filter(    'woocommerce_output_related_products_args',	'prodent_woocommerce_output_related_products_args' );
				add_filter(    'woocommerce_related_products_columns',		'prodent_woocommerce_related_products_columns' );
			}
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prodent_woocommerce_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prodent_filter_tgmpa_required_plugins',	'prodent_woocommerce_tgmpa_required_plugins');
	function prodent_woocommerce_tgmpa_required_plugins($list=array()) {
		if (prodent_storage_isset('required_plugins', 'woocommerce')) {
			$list[] = array(
					'name' 		=> prodent_storage_get_array('required_plugins', 'woocommerce'),
					'slug' 		=> 'woocommerce',
					'required' 	=> false
				);
		}
		return $list;
	}
}


// Check if WooCommerce installed and activated
if ( !function_exists( 'prodent_exists_woocommerce' ) ) {
	function prodent_exists_woocommerce() {
		return class_exists('Woocommerce');
		//return function_exists('is_woocommerce');
	}
}

// Return true, if current page is any woocommerce page
if ( !function_exists( 'prodent_is_woocommerce_page' ) ) {
	function prodent_is_woocommerce_page() {
		$rez = false;
		if (prodent_exists_woocommerce())
			$rez = is_woocommerce() || is_shop() || is_product() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_cart() || is_checkout() || is_account_page();
		return $rez;
	}
}

// Detect current blog mode
if ( !function_exists( 'prodent_woocommerce_detect_blog_mode' ) ) {
	//Handler of the add_filter( 'prodent_filter_detect_blog_mode', 'prodent_woocommerce_detect_blog_mode' );
	function prodent_woocommerce_detect_blog_mode($mode='') {
		if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy())
			$mode = 'shop';
		else if (is_product() || is_cart() || is_checkout() || is_account_page())
			$mode = 'shop';	//'shop_single';
		return $mode;
	}
}

// Override options with stored page meta on 'Shop' pages
if ( !function_exists('prodent_woocommerce_override_theme_options') ) {
	//Handler of the add_action( 'prodent_action_override_theme_options', 'prodent_woocommerce_override_theme_options');
	function prodent_woocommerce_override_theme_options() {
		// Remove ' || is_product()' from the condition in the next row
		// if you don't need to override theme options from the page 'Shop' on single products
		if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() || is_product()) {
			if (($id = prodent_woocommerce_get_shop_page_id()) > 0)
				prodent_storage_set('options_meta', get_post_meta($id, 'prodent_options', true));
		}
	}
}

// Return current page title
if ( !function_exists( 'prodent_woocommerce_get_blog_title' ) ) {
	//Handler of the add_filter( 'prodent_filter_get_blog_title', 'prodent_woocommerce_get_blog_title');
	function prodent_woocommerce_get_blog_title($title='') {
		if (!prodent_exists_trx_addons() && prodent_exists_woocommerce() && prodent_is_woocommerce_page() && is_shop()) {
			$id = prodent_woocommerce_get_shop_page_id();
			$title = $id ? get_the_title($id) : esc_html__('Shop', 'prodent');
		}
		return $title;
	}
}


// Return taxonomy for current post type
if ( !function_exists( 'prodent_woocommerce_post_type_taxonomy' ) ) {
	//Handler of the add_filter( 'prodent_filter_post_type_taxonomy',	'prodent_woocommerce_post_type_taxonomy', 10, 2 );
	function prodent_woocommerce_post_type_taxonomy($tax='', $post_type='') {
		if ($post_type == 'product')
			$tax = 'product_cat';
		return $tax;
	}
}

// Return true if page title section is allowed
if ( !function_exists( 'prodent_woocommerce_allow_override_header_image' ) ) {
	//Handler of the add_filter( 'prodent_filter_allow_override_header_image', 'prodent_woocommerce_allow_override_header_image' );
	function prodent_woocommerce_allow_override_header_image($allow=true) {
		return is_product() ? false : $allow;
	}
}

// Return shop page ID
if ( !function_exists( 'prodent_woocommerce_get_shop_page_id' ) ) {
	function prodent_woocommerce_get_shop_page_id() {
		return get_option('woocommerce_shop_page_id');
	}
}

// Return shop page link
if ( !function_exists( 'prodent_woocommerce_get_shop_page_link' ) ) {
	function prodent_woocommerce_get_shop_page_link() {
		$url = '';
		$id = prodent_woocommerce_get_shop_page_id();
		if ($id) $url = get_permalink($id);
		return $url;
	}
}

// Show categories of the current product
if ( !function_exists( 'prodent_woocommerce_get_post_categories' ) ) {
	//Handler of the add_filter( 'prodent_filter_get_post_categories', 		'prodent_woocommerce_get_post_categories');
	function prodent_woocommerce_get_post_categories($cats='') {
		if (get_post_type()=='product') {
			$cats = prodent_get_post_terms(', ', get_the_ID(), 'product_cat');
		}
		return $cats;
	}
}

// Add 'product' to the list of the supported post-types
if ( !function_exists( 'prodent_woocommerce_list_post_types' ) ) {
	//Handler of the add_filter( 'prodent_filter_list_posts_types', 'prodent_woocommerce_list_post_types');
	function prodent_woocommerce_list_post_types($list=array()) {
		$list['product'] = esc_html__('Products', 'prodent');
		return $list;
	}
}

// Show price of the current product in the widgets and search results
if ( !function_exists( 'prodent_woocommerce_get_post_info' ) ) {
	//Handler of the add_filter( 'prodent_filter_get_post_info', 'prodent_woocommerce_get_post_info');
	function prodent_woocommerce_get_post_info($post_info='') {
		if (get_post_type()=='product') {
			global $product;
			if ( $price_html = $product->get_price_html() ) {
				$post_info = '<div class="post_price product_price price">' . trim($price_html) . '</div>' . $post_info;
			}
		}
		return $post_info;
	}
}

// Show price of the current product in the search results streampage
if ( !function_exists( 'prodent_woocommerce_action_before_post_meta' ) ) {
	//Handler of the add_action( 'prodent_action_before_post_meta', 'prodent_woocommerce_action_before_post_meta');
	function prodent_woocommerce_action_before_post_meta() {
		if (!is_single() && get_post_type()=='product') {
			global $product;
			if ( $price_html = $product->get_price_html() ) {
				?><div class="post_price product_price price"><?php prodent_show_layout($price_html); ?></div><?php
			}
		}
	}
}
	
// Enqueue WooCommerce custom styles
if ( !function_exists( 'prodent_woocommerce_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'prodent_woocommerce_frontend_scripts', 1100 );
	function prodent_woocommerce_frontend_scripts() {
		//if (prodent_is_woocommerce_page())
			if (prodent_is_on(prodent_get_theme_option('debug_mode')) && prodent_get_file_dir('plugins/woocommerce/woocommerce.css')!='')
				wp_enqueue_style( 'prodent-woocommerce',  prodent_get_file_url('plugins/woocommerce/woocommerce.css'), array(), null );
			if (prodent_is_on(prodent_get_theme_option('debug_mode')) && prodent_get_file_dir('plugins/woocommerce/woocommerce.js')!='')
				wp_enqueue_script( 'prodent-woocommerce', prodent_get_file_url('plugins/woocommerce/woocommerce.js'), array('jquery'), null, true );
	}
}
	
// Merge custom styles
if ( !function_exists( 'prodent_woocommerce_merge_styles' ) ) {
	//Handler of the add_filter('prodent_filter_merge_styles', 'prodent_woocommerce_merge_styles');
	function prodent_woocommerce_merge_styles($list) {
		$list[] = 'plugins/woocommerce/woocommerce.css';
		return $list;
	}
}
	
// Merge custom scripts
if ( !function_exists( 'prodent_woocommerce_merge_scripts' ) ) {
	//Handler of the add_filter('prodent_filter_merge_scripts', 'prodent_woocommerce_merge_scripts');
	function prodent_woocommerce_merge_scripts($list) {
		$list[] = 'plugins/woocommerce/woocommerce.js';
		return $list;
	}
}



// Add WooCommerce specific items into lists
//------------------------------------------------------------------------

// Add sidebar
if ( !function_exists( 'prodent_woocommerce_list_sidebars' ) ) {
	//Handler of the add_filter( 'prodent_filter_list_sidebars', 'prodent_woocommerce_list_sidebars' );
	function prodent_woocommerce_list_sidebars($list=array()) {
		$list['woocommerce_widgets'] = array(
											'name' => esc_html__('WooCommerce Widgets', 'prodent'),
											'description' => esc_html__('Widgets to be shown on the WooCommerce pages', 'prodent')
											);
		return $list;
	}
}




// Decorate WooCommerce output: Loop
//------------------------------------------------------------------------

// Add query vars to set products per page
if (!function_exists('prodent_woocommerce_pre_get_posts')) {
	//Handler of the add_action( 'pre_get_posts', 'prodent_woocommerce_pre_get_posts' );
	function prodent_woocommerce_pre_get_posts($query) {
		if (!$query->is_main_query()) return;
		if ($query->get('post_type') == 'product') {
			$ppp = get_theme_mod('posts_per_page_shop', 0);
			if ($ppp > 0)
				$query->set('posts_per_page', $ppp);
		}
	}
}


// Before main content
if ( !function_exists( 'prodent_woocommerce_wrapper_start' ) ) {
	//remove_action( 'woocommerce_before_main_content', 'prodent_woocommerce_wrapper_start', 10);
	//Handler of the add_action('woocommerce_before_main_content', 'prodent_woocommerce_wrapper_start', 10);
	function prodent_woocommerce_wrapper_start() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			<article class="post_item_single post_type_product">
			<?php
		} else {
			?>
			<div class="list_products shop_mode_<?php echo !prodent_storage_empty('shop_mode') ? prodent_storage_get('shop_mode') : 'thumbs'; ?>">
				<div class="list_products_header">
			<?php
		}
	}
}

// After main content
if ( !function_exists( 'prodent_woocommerce_wrapper_end' ) ) {
	//remove_action( 'woocommerce_after_main_content', 'prodent_woocommerce_wrapper_end', 10);		
	//Handler of the add_action('woocommerce_after_main_content', 'prodent_woocommerce_wrapper_end', 10);
	function prodent_woocommerce_wrapper_end() {
		if (is_product() || is_cart() || is_checkout() || is_account_page()) {
			?>
			</article><!-- /.post_item_single -->
			<?php
		} else {
			?>
			</div><!-- /.list_products -->
			<?php
		}
	}
}

// Close header section
if ( !function_exists( 'prodent_woocommerce_archive_description' ) ) {
	//Handler of the add_action( 'woocommerce_before_shop_loop',	'prodent_woocommerce_archive_description', 5 );
	//Handler of the add_action( 'woocommerce_no_products_found',	'prodent_woocommerce_archive_description', 5 );
	function prodent_woocommerce_archive_description() {
		?>
		</div><!-- /.list_products_header -->
		<?php
	}
}

// Add list mode buttons
if ( !function_exists( 'prodent_woocommerce_before_shop_loop' ) ) {
	//Handler of the add_action( 'woocommerce_before_shop_loop', 'prodent_woocommerce_before_shop_loop', 10 );
	function prodent_woocommerce_before_shop_loop() {
		?>
		<div class="prodent_shop_mode_buttons"><form action="<?php echo esc_url(prodent_get_current_url()); ?>" method="post"><input type="hidden" name="prodent_shop_mode" value="<?php echo esc_attr(prodent_storage_get('shop_mode')); ?>" /><a href="#" class="woocommerce_thumbs icon-th" title="<?php esc_attr_e('Show products as thumbs', 'prodent'); ?>"></a><a href="#" class="woocommerce_list icon-th-list" title="<?php esc_attr_e('Show products as list', 'prodent'); ?>"></a></form></div><!-- /.prodent_shop_mode_buttons -->
		<?php
	}
}

// Number of columns for the shop streampage
if ( !function_exists( 'prodent_woocommerce_loop_shop_columns' ) ) {
	//Handler of the add_filter( 'loop_shop_columns', 'prodent_woocommerce_loop_shop_columns' );
	function prodent_woocommerce_loop_shop_columns($cols) {
		return max(2, min(4, prodent_get_theme_option('blog_columns')));
	}
}

// Add column class into product item in shop streampage
if ( !function_exists( 'prodent_woocommerce_loop_shop_columns_class' ) ) {
	//Handler of the add_filter( 'post_class', 'prodent_woocommerce_loop_shop_columns_class' );
	//Handler of the add_filter( 'product_cat_class', 'prodent_woocommerce_loop_shop_columns_class', 10, 3 );
	function prodent_woocommerce_loop_shop_columns_class($classes, $class='', $cat='') {
		global $woocommerce_loop;
		if (is_product()) {
			if (!empty($woocommerce_loop['columns'])) {
				$classes[] = ' column-1_'.esc_attr($woocommerce_loop['columns']);
			}
		} else if (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) {
			$classes[] = ' column-1_'.esc_attr(max(2, min(4, prodent_get_theme_option('blog_columns'))));
		}
		return $classes;
	}
}


// Open item wrapper for categories and products
if ( !function_exists( 'prodent_woocommerce_item_wrapper_start' ) ) {
	//Handler of the add_action( 'woocommerce_before_subcategory_title', 'prodent_woocommerce_item_wrapper_start', 9 );
	//Handler of the add_action( 'woocommerce_before_shop_loop_item_title', 'prodent_woocommerce_item_wrapper_start', 9 );
	function prodent_woocommerce_item_wrapper_start($cat='') {
		prodent_storage_set('in_product_item', true);
		$hover = prodent_get_theme_option('shop_hover');
		?>
		<div class="post_item post_layout_<?php echo esc_attr(prodent_storage_get('shop_mode')); ?>">
			<div class="post_featured hover_<?php echo esc_attr($hover); ?>">
				<?php do_action('prodent_action_woocommerce_item_featured_start'); ?>
				<a href="<?php echo esc_url(is_object($cat) ? get_term_link($cat->slug, 'product_cat') : get_permalink()); ?>">
				<?php
	}
}

// Open item wrapper for categories and products
if ( !function_exists( 'prodent_woocommerce_open_item_wrapper' ) ) {
	//Handler of the add_action( 'woocommerce_before_subcategory_title', 'prodent_woocommerce_title_wrapper_start', 20 );
	//Handler of the add_action( 'woocommerce_before_shop_loop_item_title', 'prodent_woocommerce_title_wrapper_start', 20 );
	function prodent_woocommerce_title_wrapper_start($cat='') {
				?></a><?php
				if (($hover = prodent_get_theme_option('shop_hover')) != 'none') {
					?><div class="mask"></div><?php
					prodent_hovers_add_icons($hover, array('cat'=>$cat));
				}
				do_action('prodent_action_woocommerce_item_featured_end');
				?>
			</div><!-- /.post_featured -->
			<div class="post_data">
				<div class="post_data_inner">
					<div class="post_header entry-header">
					<?php
	}
}


// Display product's tags before the title
if ( !function_exists( 'prodent_woocommerce_title_tags' ) ) {
	//Handler of the add_action( 'woocommerce_before_shop_loop_item_title', 'prodent_woocommerce_title_tags', 30 );
	function prodent_woocommerce_title_tags() {
		global $product;
		prodent_show_layout(wc_get_product_tag_list( $product->get_id(), ', ', '<div class="post_tags product_tags">', '</div>' ));
	}
}

// Wrap product title into link
if ( !function_exists( 'prodent_woocommerce_the_title' ) ) {
	//Handler of the add_filter( 'the_title', 'prodent_woocommerce_the_title' );
	function prodent_woocommerce_the_title($title) {
		if (prodent_storage_get('in_product_item') && get_post_type()=='product') {
			$title = '<a href="'.esc_url(get_permalink()).'">'.esc_html($title).'</a>';
		}
		return $title;
	}
}

//// Wrap category title into link
//if ( !function_exists( 'prodent_woocommerce_shop_loop_subcategory_title' ) ) {
//	//Handler of the add_filter( 'woocommerce_shop_loop_subcategory_title', 'prodent_woocommerce_shop_loop_subcategory_title' );
//	function prodent_woocommerce_shop_loop_subcategory_title($cat) {
//		if (prodent_storage_get('in_product_item') && is_object($cat)) {
//			$cat->name = sprintf('<a href="%s">%s</a>', esc_url(get_term_link($cat->slug, 'product_cat')), $cat->name);
//		}
//		return $cat;
//	}
//}

// Wrap category title into link
if ( !function_exists( 'prodent_woocommerce_shop_loop_subcategory_title' ) ) {
    //Handler of the add_filter( 'woocommerce_shop_loop_subcategory_title', 'prodent_woocommerce_shop_loop_subcategory_title' );
    function prodent_woocommerce_shop_loop_subcategory_title($cat) {

        $cat->name = sprintf('<a href="%s">%s</a>', esc_url(get_term_link($cat->slug, 'product_cat')), $cat->name);
        ?>
        <h2 class="woocommerce-loop-category__title">
        <?php
        echo wp_kses_post($cat->name);

        if ( $cat->count > 0 ) {
            echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . esc_html( $cat->count ) . ')</mark>', $cat ); // WPCS: XSS ok.
        }
        ?>
        </h2><?php
        //if (prodent_storage_get('in_product_item') && is_object($cat)) {
        //	$cat->name = sprintf('<a href="%s">%s</a>', esc_url(get_term_link($cat->slug, 'product_cat')), $cat->name);
        //}
        //return $cat;
    }
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'prodent_woocommerce_title_wrapper_end' ) ) {
	//Handler of the add_action( 'woocommerce_after_shop_loop_item_title', 'prodent_woocommerce_title_wrapper_end', 7);
	function prodent_woocommerce_title_wrapper_end() {
			?>
			</div><!-- /.post_header -->
		<?php
		if (prodent_storage_get('shop_mode') == 'list' && (is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy()) && !is_product()) {
		    $excerpt = apply_filters('the_excerpt', get_the_excerpt());
			?>
			<div class="post_content entry-content"><?php prodent_show_layout($excerpt); ?></div>
			<?php
		}
	}
}

// Add excerpt in output for the product in the list mode
if ( !function_exists( 'prodent_woocommerce_title_wrapper_end2' ) ) {
	//Handler of the add_action( 'woocommerce_after_subcategory_title', 'prodent_woocommerce_title_wrapper_end2', 10 );
	function prodent_woocommerce_title_wrapper_end2($category) {
			?>
			</div><!-- /.post_header -->
		<?php
		if (prodent_storage_get('shop_mode') == 'list' && is_shop() && !is_product()) {
			?>
			<div class="post_content entry-content"><?php prodent_show_layout($category->description); ?></div><!-- /.post_content -->
			<?php
		}
	}
}

// Close item wrapper for categories and products
if ( !function_exists( 'prodent_woocommerce_close_item_wrapper' ) ) {
	//Handler of the add_action( 'woocommerce_after_subcategory', 'prodent_woocommerce_item_wrapper_end', 20 );
	//Handler of the add_action( 'woocommerce_after_shop_loop_item', 'prodent_woocommerce_item_wrapper_end', 20 );
	function prodent_woocommerce_item_wrapper_end($cat='') {
				?>
				</div><!-- /.post_data_inner -->
			</div><!-- /.post_data -->
		</div><!-- /.post_item -->
		<?php
		prodent_storage_set('in_product_item', false);
	}
}

// Change text on 'Add to cart' button
if ( !function_exists( 'prodent_woocommerce_add_to_cart_text' ) ) {
	//Handler of the add_filter( 'woocommerce_product_add_to_cart_text',		'prodent_woocommerce_add_to_cart_text' );
	//Handler of the add_filter( 'woocommerce_product_single_add_to_cart_text','prodent_woocommerce_add_to_cart_text' );
	function prodent_woocommerce_add_to_cart_text($text='') {
		return esc_html__('Buy now', 'prodent');
	}
}

// Decorate price
if ( !function_exists( 'prodent_woocommerce_get_price_html' ) ) {
	//Handler of the add_filter(    'woocommerce_get_price_html',	'prodent_woocommerce_get_price_html' );
	function prodent_woocommerce_get_price_html($price='') {
		if (!is_admin() && !empty($price)) {
			$sep = get_option('woocommerce_price_decimal_sep');
			if (empty($sep)) $sep = '.';
			$price = preg_replace('/([0-9,]+)(\\'.trim($sep).')([0-9]{2})/', '\\1<span class="decimals">\\3</span>', $price);
		}
		return $price;
	}
}



// Decorate WooCommerce output: Single product
//------------------------------------------------------------------------

// Add WooCommerce specific vars into localize array
if (!function_exists('prodent_woocommerce_localize_script')) {
	//Handler of the add_filter( 'prodent_filter_localize_script','prodent_woocommerce_localize_script' );
	function prodent_woocommerce_localize_script($arr) {
		$arr['stretch_tabs_area'] = !prodent_sidebar_present() ? prodent_get_theme_option('stretch_tabs_area') : 0;
		return $arr;
	}
}

// Add Product ID for the single product
if ( !function_exists( 'prodent_woocommerce_show_product_id' ) ) {
	//Handler of the add_action( 'woocommerce_product_meta_end', 'prodent_woocommerce_show_product_id', 10);
	function prodent_woocommerce_show_product_id() {
		$authors = wp_get_post_terms(get_the_ID(), 'pa_product_author');
		if (is_array($authors) && count($authors)>0) {
			echo '<span class="product_author">'.esc_html__('Author: ', 'prodent');
			$delim = '';
			foreach ($authors as $author) {
				echo  esc_html($delim) . '<span>' . esc_html($author->name) . '</span>';
				$delim = ', ';
			}
			echo '</span>';
		}
		echo '<span class="product_id">'.esc_html__('Product ID: ', 'prodent') . '<span>' . get_the_ID() . '</span></span>';
	}
}

// Number columns for the product's thumbnails
if ( !function_exists( 'prodent_woocommerce_product_thumbnails_columns' ) ) {
	//Handler of the add_filter( 'woocommerce_product_thumbnails_columns', 'prodent_woocommerce_product_thumbnails_columns' );
	function prodent_woocommerce_product_thumbnails_columns($cols) {
		return 4;
	}
}

// Set products number for the related products
if ( !function_exists( 'prodent_woocommerce_output_related_products_args' ) ) {
	//Handler of the add_filter( 'woocommerce_output_related_products_args', 'prodent_woocommerce_output_related_products_args' );
	function prodent_woocommerce_output_related_products_args($args) {
		$args['posts_per_page'] = (int) prodent_get_theme_option('show_related_posts') 
										? max(0, min(9, prodent_get_theme_option('related_posts'))) 
										: 0;
		$args['columns'] = max(1, min(4, prodent_get_theme_option('related_columns')));
		return $args;
	}
}

// Set columns number for the related products
if ( !function_exists( 'prodent_woocommerce_related_products_columns' ) ) {
	//Handler of the add_filter('woocommerce_related_products_columns', 'prodent_woocommerce_related_products_columns' );
	function prodent_woocommerce_related_products_columns($columns) {
		$columns = max(1, min(4, prodent_get_theme_option('related_columns')));
		return $columns;
	}
}



// Decorate WooCommerce output: Widgets
//------------------------------------------------------------------------

// Search form
if ( !function_exists( 'prodent_woocommerce_get_product_search_form' ) ) {
	//Handler of the add_filter( 'get_product_search_form', 'prodent_woocommerce_get_product_search_form' );
	function prodent_woocommerce_get_product_search_form($form) {
		return '
		<form role="search" method="get" class="search_form" action="' . esc_url(home_url('/')) . '">
			<input type="text" class="search_field" placeholder="' . esc_attr__('Search for products &hellip;', 'prodent') . '" value="' . get_search_query() . '" name="s" /><button class="search_button" type="submit">' . esc_html__('Search', 'prodent') . '</button>
			<input type="hidden" name="post_type" value="product" />
		</form>
		';
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (prodent_exists_woocommerce()) { require_once PRODENT_THEME_DIR . 'plugins/woocommerce/woocommerce.styles.php'; }
?>