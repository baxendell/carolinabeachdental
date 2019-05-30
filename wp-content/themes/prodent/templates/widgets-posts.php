<?php
/**
 * The template to display posts in widgets and/or in the search results
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

$prodent_post_id    = get_the_ID();
$prodent_post_date  = prodent_get_date();
$prodent_post_title = get_the_title();
$prodent_post_link  = get_permalink();
$prodent_post_author_id   = get_the_author_meta('ID');
$prodent_post_author_name = get_the_author_meta('display_name');
$prodent_post_author_url  = get_author_posts_url($prodent_post_author_id, '');

$prodent_args = get_query_var('prodent_args_widgets_posts');
$prodent_show_date = isset($prodent_args['show_date']) ? (int) $prodent_args['show_date'] : 1;
$prodent_show_image = isset($prodent_args['show_image']) ? (int) $prodent_args['show_image'] : 1;
$prodent_show_author = isset($prodent_args['show_author']) ? (int) $prodent_args['show_author'] : 1;
$prodent_show_counters = isset($prodent_args['show_counters']) ? (int) $prodent_args['show_counters'] : 1;
$prodent_show_categories = isset($prodent_args['show_categories']) ? (int) $prodent_args['show_categories'] : 1;

$prodent_output = prodent_storage_get('prodent_output_widgets_posts');

$prodent_post_counters_output = '';
if ( $prodent_show_counters ) {
	$prodent_post_counters_output = '<span class="post_info_item post_info_counters">'
								. prodent_get_post_counters('comments')
							. '</span>';
}


$prodent_output .= '<article class="post_item with_thumb">';

if ($prodent_show_image) {
	$prodent_post_thumb = get_the_post_thumbnail($prodent_post_id, prodent_get_thumb_size('tiny'), array(
		'alt' => get_the_title()
	));
	if ($prodent_post_thumb) $prodent_output .= '<div class="post_thumb">' . ($prodent_post_link ? '<a href="' . esc_url($prodent_post_link) . '">' : '') . ($prodent_post_thumb) . ($prodent_post_link ? '</a>' : '') . '</div>';
}

$prodent_output .= '<div class="post_content">'
			. ($prodent_show_categories 
					? '<div class="post_categories">'
						. prodent_get_post_categories()
						. $prodent_post_counters_output
						. '</div>' 
					: '')
			. '<h6 class="post_title">' . ($prodent_post_link ? '<a href="' . esc_url($prodent_post_link) . '">' : '') . ($prodent_post_title) . ($prodent_post_link ? '</a>' : '') . '</h6>'
			. apply_filters('prodent_filter_get_post_info', 
								'<div class="post_info">'
									. ($prodent_show_date 
										? '<span class="post_info_item post_info_posted">'
											. ($prodent_post_link ? '<a href="' . esc_url($prodent_post_link) . '" class="post_info_date">' : '') 
											. esc_html($prodent_post_date) 
											. ($prodent_post_link ? '</a>' : '')
											. '</span>'
										: '')
									. ($prodent_show_author 
										? '<span class="post_info_item post_info_posted_by">' 
											. esc_html__('by', 'prodent') . ' ' 
											. ($prodent_post_link ? '<a href="' . esc_url($prodent_post_author_url) . '" class="post_info_author">' : '') 
											. esc_html($prodent_post_author_name) 
											. ($prodent_post_link ? '</a>' : '') 
											. '</span>'
										: '')
									. (!$prodent_show_categories && $prodent_post_counters_output
										? $prodent_post_counters_output
										: '')
								. '</div>')
		. '</div>'
	. '</article>';
prodent_storage_set('prodent_output_widgets_posts', $prodent_output);
?>