<?php
/**
 * The template to display default site footer
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.10
 */

$prodent_footer_scheme =  prodent_is_inherit(prodent_get_theme_option('footer_scheme')) ? prodent_get_theme_option('color_scheme') : prodent_get_theme_option('footer_scheme');
$prodent_footer_id = str_replace('footer-custom-', '', prodent_get_theme_option("footer_style"));
if ((int) $prodent_footer_id == 0) {
	$prodent_footer_id = prodent_get_post_id(array(
												'name' => $prodent_footer_id,
												'post_type' => defined('TRX_ADDONS_CPT_LAYOUT_PT') ? TRX_ADDONS_CPT_LAYOUT_PT : 'cpt_layouts'
												)
											);
} else {
	$prodent_footer_id = apply_filters('prodent_filter_get_translated_layout', $prodent_footer_id);
}
$prodent_footer_meta = get_post_meta($prodent_footer_id, 'trx_addons_options', true);
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr($prodent_footer_id); 
						?> footer_custom_<?php echo esc_attr(sanitize_title(get_the_title($prodent_footer_id))); 
						if (!empty($prodent_footer_meta['margin']) != '') 
							echo ' '.esc_attr(prodent_add_inline_css_class('margin-top: '.esc_attr(prodent_prepare_css_value($prodent_footer_meta['margin'])).';'));
						?> scheme_<?php echo esc_attr($prodent_footer_scheme); 
						?>">
	<?php
    // Custom footer's layout
    do_action('prodent_action_show_layout', $prodent_footer_id);
	?>
</footer><!-- /.footer_wrap -->
