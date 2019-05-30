<?php
/**
 * The Front Page template file.
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.31
 */

get_header();

// If front-page is a static page
if (get_option('show_on_front') == 'page') {

	// If Front Page Builder is enabled - display sections
	if (prodent_is_on(prodent_get_theme_option('front_page_enabled'))) {

		if ( have_posts() ) the_post();

		$prodent_sections = prodent_array_get_keys_by_value(prodent_get_theme_option('front_page_sections'), 1, false);
		if (is_array($prodent_sections)) {
			foreach ($prodent_sections as $prodent_section) {
				get_template_part("front-page/section", $prodent_section);
			}
		}
	
	// Else - display native page content
	} else
		get_template_part('page');

// Else get index template to show posts
} else
	get_template_part('index');

get_footer();
?>