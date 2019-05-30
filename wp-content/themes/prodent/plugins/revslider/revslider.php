<?php
/* Revolution Slider support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prodent_revslider_theme_setup9')) {
	add_action( 'after_setup_theme', 'prodent_revslider_theme_setup9', 9 );
	function prodent_revslider_theme_setup9() {
		if (prodent_exists_revslider()) {
			add_action( 'wp_enqueue_scripts', 					'prodent_revslider_frontend_scripts', 1100 );
			add_filter( 'prodent_filter_merge_styles',			'prodent_revslider_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'prodent_filter_tgmpa_required_plugins','prodent_revslider_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prodent_revslider_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prodent_filter_tgmpa_required_plugins',	'prodent_revslider_tgmpa_required_plugins');
	function prodent_revslider_tgmpa_required_plugins($list=array()) {
		if (prodent_storage_isset('required_plugins', 'revslider')) {
			$path = prodent_get_file_dir('plugins/revslider/revslider.zip');
			if (!empty($path) || prodent_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> prodent_storage_get_array('required_plugins', 'revslider'),
					'slug' 		=> 'revslider',
					'source'	=> !empty($path) ? $path : 'upload://revslider.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if RevSlider installed and activated
if ( !function_exists( 'prodent_exists_revslider' ) ) {
	function prodent_exists_revslider() {
		return function_exists('rev_slider_shortcode');
	}
}
	
// Enqueue custom styles
if ( !function_exists( 'prodent_revslider_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'prodent_revslider_frontend_scripts', 1100 );
	function prodent_revslider_frontend_scripts() {
		if (prodent_is_on(prodent_get_theme_option('debug_mode')) && prodent_get_file_dir('plugins/revslider/revslider.css')!='')
			wp_enqueue_style( 'prodent-revslider',  prodent_get_file_url('plugins/revslider/revslider.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'prodent_revslider_merge_styles' ) ) {
	//Handler of the add_filter('prodent_filter_merge_styles', 'prodent_revslider_merge_styles');
	function prodent_revslider_merge_styles($list) {
		$list[] = 'plugins/revslider/revslider.css';
		return $list;
	}
}
?>