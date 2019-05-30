<?php
/**
 * The Gallery template to display posts
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

$prodent_blog_style = explode('_', prodent_get_theme_option('blog_style'));
$prodent_columns = empty($prodent_blog_style[1]) ? 2 : max(2, $prodent_blog_style[1]);
$prodent_post_format = get_post_format();
$prodent_post_format = empty($prodent_post_format) ? 'standard' : str_replace('post-format-', '', $prodent_post_format);
$prodent_animation = prodent_get_theme_option('blog_animation');
$prodent_image = wp_get_attachment_image_src( get_post_thumbnail_id(get_the_ID()), 'full' );

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_gallery post_layout_gallery_'.esc_attr($prodent_columns).' post_format_'.esc_attr($prodent_post_format) ); ?>
	<?php echo (!prodent_is_off($prodent_animation) ? ' data-animation="'.esc_attr(prodent_get_animation_classes($prodent_animation)).'"' : ''); ?>
	data-size="<?php if (!empty($prodent_image[1]) && !empty($prodent_image[2])) echo intval($prodent_image[1]) .'x' . intval($prodent_image[2]); ?>"
	data-src="<?php if (!empty($prodent_image[0])) echo esc_url($prodent_image[0]); ?>"
	>

	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	$prodent_image_hover = 'icon';	//prodent_get_theme_option('image_hover');
	if (in_array($prodent_image_hover, array('icons', 'zoom'))) $prodent_image_hover = 'dots';
	$prodent_components = prodent_is_inherit(prodent_get_theme_option_from_meta('meta_parts')) 
								? 'categories,date,counters,share'
								: prodent_array_get_keys_by_value(prodent_get_theme_option('meta_parts'));
	$prodent_counters = prodent_is_inherit(prodent_get_theme_option_from_meta('counters')) 
								? 'comments'
								: prodent_array_get_keys_by_value(prodent_get_theme_option('counters'));
	prodent_show_post_featured(array(
		'hover' => $prodent_image_hover,
		'thumb_size' => prodent_get_thumb_size( strpos(prodent_get_theme_option('body_style'), 'full')!==false || $prodent_columns < 3 ? 'masonry-big' : 'masonry' ),
		'thumb_only' => true,
		'show_no_image' => true,
		'post_info' => '<div class="post_details">'
							. '<h2 class="post_title"><a href="'.esc_url(get_permalink()).'">'. esc_html(get_the_title()) . '</a></h2>'
							. '<div class="post_description">'
								. (!empty($prodent_components)
										? prodent_show_post_meta(apply_filters('prodent_filter_post_meta_args', array(
											'components' => $prodent_components,
											'counters' => $prodent_counters,
											'seo' => false,
											'echo' => false
											), $prodent_blog_style[0], $prodent_columns))
										: '')
								. '<div class="post_description_content">'
									. apply_filters('the_excerpt', get_the_excerpt())
								. '</div>'
								. '<a href="'.esc_url(get_permalink()).'" class="theme_button post_readmore"><span class="post_readmore_label">' . esc_html__('Learn more', 'prodent') . '</span></a>'
							. '</div>'
						. '</div>'
	));
	?>
</article>