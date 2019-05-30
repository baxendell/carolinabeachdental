<?php
/**
 * The template to display blog archive
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

/*
Template Name: Blog archive
*/

/**
 * Make page with this template and put it into menu
 * to display posts as blog archive
 * You can setup output parameters (blog style, posts per page, parent category, etc.)
 * in the Theme Options section (under the page content)
 * You can build this page in the Visual Composer to make custom page layout:
 * just insert %%CONTENT%% in the desired place of content
 */

// Get template page's content
$prodent_content = '';
$prodent_blog_archive_mask = '%%CONTENT%%';
$prodent_blog_archive_subst = sprintf('<div class="blog_archive">%s</div>', $prodent_blog_archive_mask);
if ( have_posts() ) {
	the_post(); 
	if (($prodent_content = apply_filters('the_content', get_the_content())) != '') {
		if (($prodent_pos = strpos($prodent_content, $prodent_blog_archive_mask)) !== false) {
			$prodent_content = preg_replace('/(\<p\>\s*)?'.$prodent_blog_archive_mask.'(\s*\<\/p\>)/i', $prodent_blog_archive_subst, $prodent_content);
		} else
			$prodent_content .= $prodent_blog_archive_subst;
		$prodent_content = explode($prodent_blog_archive_mask, $prodent_content);
		// Add VC custom styles to the inline CSS
		$vc_custom_css = get_post_meta( get_the_ID(), '_wpb_shortcodes_custom_css', true );
		if ( !empty( $vc_custom_css ) ) prodent_add_inline_css(strip_tags($vc_custom_css));
	}
}

// Prepare args for a new query
$prodent_args = array(
	'post_status' => current_user_can('read_private_pages') && current_user_can('read_private_posts') ? array('publish', 'private') : 'publish'
);
$prodent_args = prodent_query_add_posts_and_cats($prodent_args, '', prodent_get_theme_option('post_type'), prodent_get_theme_option('parent_cat'));
$prodent_page_number = get_query_var('paged') ? get_query_var('paged') : (get_query_var('page') ? get_query_var('page') : 1);
if ($prodent_page_number > 1) {
	$prodent_args['paged'] = $prodent_page_number;
	$prodent_args['ignore_sticky_posts'] = true;
}
$prodent_ppp = prodent_get_theme_option('posts_per_page');
if ((int) $prodent_ppp != 0)
	$prodent_args['posts_per_page'] = (int) $prodent_ppp;
// Make a new query
query_posts( $prodent_args );
// Set a new query as main WP Query
$GLOBALS['wp_the_query'] = $GLOBALS['wp_query'];

// Set query vars in the new query!
if (is_array($prodent_content) && count($prodent_content) == 2) {
	set_query_var('blog_archive_start', $prodent_content[0]);
	set_query_var('blog_archive_end', $prodent_content[1]);
}

get_template_part('index');
?>