<?php
/**
 * The template to display the background video in the header
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.14
 */
$prodent_header_video = prodent_get_header_video();
$prodent_embed_video = '';
if (!empty($prodent_header_video) && !prodent_is_from_uploads($prodent_header_video)) {
	if (prodent_is_youtube_url($prodent_header_video) && preg_match('/[=\/]([^=\/]*)$/', $prodent_header_video, $matches) && !empty($matches[1])) {
		?><div id="background_video" data-youtube-code="<?php echo esc_attr($matches[1]); ?>"></div><?php
	} else {
		global $wp_embed;
		if (false && is_object($wp_embed)) {
			$prodent_embed_video = do_shortcode($wp_embed->run_shortcode( '[embed]' . trim($prodent_header_video) . '[/embed]' ));
			$prodent_embed_video = prodent_make_video_autoplay($prodent_embed_video);
		} else {
			$prodent_header_video = str_replace('/watch?v=', '/embed/', $prodent_header_video);
			$prodent_header_video = prodent_add_to_url($prodent_header_video, array(
				'feature' => 'oembed',
				'controls' => 0,
				'autoplay' => 1,
				'showinfo' => 0,
				'modestbranding' => 1,
				'wmode' => 'transparent',
				'enablejsapi' => 1,
				'origin' => home_url(),
				'widgetid' => 1
			));
			$prodent_embed_video = '<iframe src="' . esc_url($prodent_header_video) . '" width="1170" height="658" allowfullscreen="0" frameborder="0"></iframe>';
		}
		?><div id="background_video"><?php prodent_show_layout($prodent_embed_video); ?></div><?php
	}
}
?>