<?php
/* Mail Chimp support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if (!function_exists('prodent_gdpr_theme_setup9')) {
	add_action( 'after_setup_theme', 'prodent_gdpr_theme_setup9', 9 );
	function prodent_gdpr_theme_setup9() {
		if (prodent_exists_gdpr()) {
			add_filter( 'prodent_filter_merge_styles',					'prodent_gdpr_merge_styles');
		}
		if (is_admin()) {
			add_filter( 'prodent_filter_tgmpa_required_plugins',		'prodent_gdpr_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( !function_exists( 'prodent_gdpr_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('prodent_filter_tgmpa_required_plugins',	'prodent_gdpr_tgmpa_required_plugins');
	function prodent_gdpr_tgmpa_required_plugins($list=array()) {
		if (prodent_storage_isset('required_plugins', 'gdpr-framework')) {
			$list[] = array(
				'name' 		=> prodent_storage_get_array('required_plugins', 'gdpr-framework'),
				'slug' 		=> 'gdpr-framework',
				'required' 	=> false
			);
		}
		return $list;
	}
}

// Check if plugin installed and activated
if ( !function_exists( 'prodent_exists_gdpr' ) ) {
	function prodent_exists_gdpr() {
		return function_exists('__gdpr_load_plugin') || defined('GDPR_VERSION');
	}
}


