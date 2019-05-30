<?php
/**
 * The Portfolio template to display the content
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

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_portfolio post_layout_portfolio_'.esc_attr($prodent_columns).' post_format_'.esc_attr($prodent_post_format).(is_sticky() && !is_paged() ? ' sticky' : '') ); ?>
	<?php echo (!prodent_is_off($prodent_animation) ? ' data-animation="'.esc_attr(prodent_get_animation_classes($prodent_animation)).'"' : ''); ?>>
	<?php

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	$prodent_image_hover = prodent_get_theme_option('image_hover');
	// Featured image
	prodent_show_post_featured(array(
		'thumb_size' => prodent_get_thumb_size(strpos(prodent_get_theme_option('body_style'), 'full')!==false || $prodent_columns < 3 ? 'masonry-big' : 'masonry'),
		'show_no_image' => true,
		'class' => $prodent_image_hover == 'dots' ? 'hover_with_info' : '',
		'post_info' => $prodent_image_hover == 'dots' ? '<div class="post_info">'.esc_html(get_the_title()).'</div>' : ''
	));
	?>
</article>