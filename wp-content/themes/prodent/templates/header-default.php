<?php
/**
 * The template to display default site header
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */


$prodent_header_css = $prodent_header_image = '';
$prodent_header_video = prodent_get_header_video();
if (true || empty($prodent_header_video)) {
	$prodent_header_image = get_header_image();
	if (prodent_trx_addons_featured_image_override()) $prodent_header_image = prodent_get_current_mode_image($prodent_header_image);
}

?><header class="top_panel top_panel_default<?php
					echo !empty($prodent_header_image) || !empty($prodent_header_video) ? ' with_bg_image' : ' without_bg_image';
					if ($prodent_header_video!='') echo ' with_bg_video';
					if ($prodent_header_image!='') echo ' '.esc_attr(prodent_add_inline_css_class('background-image: url('.esc_url($prodent_header_image).');'));
					if (is_single() && has_post_thumbnail()) echo ' with_featured_image';
					if (prodent_is_on(prodent_get_theme_option('header_fullheight'))) echo ' header_fullheight prodent-full-height';
					?> scheme_<?php echo esc_attr(prodent_is_inherit(prodent_get_theme_option('header_scheme')) 
													? prodent_get_theme_option('color_scheme') 
													: prodent_get_theme_option('header_scheme'));
					?>"><?php

	// Background video
	if (!empty($prodent_header_video)) {
		get_template_part( 'templates/header-video' );
	}
	
	// Main menu
	if (prodent_get_theme_option("menu_style") == 'top') {
		get_template_part( 'templates/header-navi' );
	}

	// Page title and breadcrumbs area
	get_template_part( 'templates/header-title');

	// Header widgets area
	get_template_part( 'templates/header-widgets' );

?></header>