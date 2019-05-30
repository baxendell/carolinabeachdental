<?php
/* Booked Appointments support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prodent_booked_theme_setup9')) {
	add_action( 'after_setup_theme', 'prodent_booked_theme_setup9', 9 );
	function prodent_booked_theme_setup9() {
		if (prodent_exists_booked()) {
			add_action( 'wp_enqueue_scripts', 							'prodent_booked_frontend_scripts', 1100 );
			add_filter( 'prodent_filter_merge_styles',					'prodent_booked_merge_styles' );
		}
		if (is_admin()) {
			add_filter( 'prodent_filter_tgmpa_required_plugins',		'prodent_booked_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prodent_booked_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prodent_filter_tgmpa_required_plugins',	'prodent_booked_tgmpa_required_plugins');
	function prodent_booked_tgmpa_required_plugins($list=array()) {
		if (prodent_storage_isset('required_plugins', 'booked')) {
			$path = prodent_get_file_dir('plugins/booked/booked.zip');
			if (!empty($path) || prodent_get_theme_setting('tgmpa_upload')) {
				$list[] = array(
					'name' 		=> prodent_storage_get_array('required_plugins', 'booked'),
					'slug' 		=> 'booked',
					'source' 	=> !empty($path) ? $path : 'upload://booked.zip',
					'required' 	=> false
				);
			}
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'prodent_exists_booked' ) ) {
	function prodent_exists_booked() {
		return class_exists('booked_plugin');
	}
}
	
// Enqueue plugin's custom styles
if ( !function_exists( 'prodent_booked_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'prodent_booked_frontend_scripts', 1100 );
	function prodent_booked_frontend_scripts() {
		if (prodent_is_on(prodent_get_theme_option('debug_mode')) && prodent_get_file_dir('plugins/booked/booked.css')!='')
			wp_enqueue_style( 'prodent-booked',  prodent_get_file_url('plugins/booked/booked.css'), array(), null );
	}
}
	
// Merge custom styles
if ( !function_exists( 'prodent_booked_merge_styles' ) ) {
	//Handler of the add_filter('prodent_filter_merge_styles', 'prodent_booked_merge_styles');
	function prodent_booked_merge_styles($list) {
		$list[] = 'plugins/booked/booked.css';
		return $list;
	}
}


// Add plugin-specific colors and fonts to the custom CSS
if (prodent_exists_booked()) { require_once PRODENT_THEME_DIR . 'plugins/booked/booked.styles.php'; }
?>