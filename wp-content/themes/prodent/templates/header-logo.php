<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

$prodent_args = get_query_var('prodent_logo_args');

// Site logo
$prodent_logo_image  = prodent_get_logo_image(isset($prodent_args['type']) ? $prodent_args['type'] : '');
$prodent_logo_text   = prodent_is_on(prodent_get_theme_option('logo_text')) ? get_bloginfo( 'name' ) : '';
$prodent_logo_slogan = get_bloginfo( 'description', 'display' );
if (!empty($prodent_logo_image) || !empty($prodent_logo_text)) {
	?><a class="sc_layouts_logo" href="<?php echo is_front_page() ? '#' : esc_url(home_url('/')); ?>"><?php
		if (!empty($prodent_logo_image)) {
			$prodent_attr = prodent_getimagesize($prodent_logo_image);
			echo '<img src="'.esc_url($prodent_logo_image).'" alt="'.esc_html($prodent_logo_image).'"'.(!empty($prodent_attr[3]) ? sprintf(' %s', $prodent_attr[3]) : '').'>';
		} else {
			prodent_show_layout(prodent_prepare_macros($prodent_logo_text), '<span class="logo_text">', '</span>');
			prodent_show_layout(prodent_prepare_macros($prodent_logo_slogan), '<span class="logo_slogan">', '</span>');
		}
	?></a><?php
}
?>