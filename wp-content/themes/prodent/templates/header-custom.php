<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.06
 */

$prodent_header_css = $prodent_header_image = '';
$prodent_header_video = prodent_get_header_video();
if (true || empty($prodent_header_video)) {
	$prodent_header_image = get_header_image();
	if (prodent_trx_addons_featured_image_override()) $prodent_header_image = prodent_get_current_mode_image($prodent_header_image);
}

$prodent_header_id = str_replace('header-custom-', '', prodent_get_theme_option("header_style"));
if ((int) $prodent_header_id == 0) {
	$prodent_header_id = prodent_get_post_id(array(
												'name' => $prodent_header_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUT_PT') ? TRX_ADDONS_CPT_LAYOUT_PT : 'cpt_layouts'
												)
											);
} else {
	$prodent_header_id = apply_filters('prodent_filter_get_translated_layout', $prodent_header_id);
}
$prodent_header_meta = get_post_meta($prodent_header_id, 'trx_addons_options', true);

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr($prodent_header_id); 
				?> top_panel_custom_<?php echo esc_attr(sanitize_title(get_the_title($prodent_header_id)));
				echo !empty($prodent_header_image) || !empty($prodent_header_video) 
					? ' with_bg_image' 
					: ' without_bg_image';
				if ($prodent_header_video!='') 
					echo ' with_bg_video';
				if ($prodent_header_image!='') 
					echo ' '.esc_attr(prodent_add_inline_css_class('background-image: url('.esc_url($prodent_header_image).');'));
				if (!empty($prodent_header_meta['margin']) != '') 
					echo ' '.esc_attr(prodent_add_inline_css_class('margin-bottom: '.esc_attr(prodent_prepare_css_value($prodent_header_meta['margin'])).';'));
				if (is_single() && has_post_thumbnail()) 
					echo ' with_featured_image';
				if (prodent_is_on(prodent_get_theme_option('header_fullheight'))) 
					echo ' header_fullheight prodent-full-height';
				?> scheme_<?php echo esc_attr(prodent_is_inherit(prodent_get_theme_option('header_scheme')) 
												? prodent_get_theme_option('color_scheme') 
												: prodent_get_theme_option('header_scheme'));
				?>"><?php

	// Background video
	if (!empty($prodent_header_video)) {
		get_template_part( 'templates/header-video' );
	}
		
	// Custom header's layout
	do_action('prodent_action_show_layout', $prodent_header_id);

	// Header widgets area
	get_template_part( 'templates/header-widgets' );
		
?></header>