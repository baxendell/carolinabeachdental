<?php
/**
 * The template to display the site logo in the footer
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.10
 */

// Logo
if (prodent_is_on(prodent_get_theme_option('logo_in_footer'))) {
	$prodent_logo_image = '';
	if (prodent_is_on(prodent_get_theme_option('logo_retina_enabled')) && prodent_get_retina_multiplier(2) > 1)
		$prodent_logo_image = prodent_get_theme_option( 'logo_footer_retina' );
	if (empty($prodent_logo_image)) 
		$prodent_logo_image = prodent_get_theme_option( 'logo_footer' );
	$prodent_logo_text   = get_bloginfo( 'name' );
	if (!empty($prodent_logo_image) || !empty($prodent_logo_text)) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if (!empty($prodent_logo_image)) {
					$prodent_attr = prodent_getimagesize($prodent_logo_image);
					echo '<a href="'.esc_url(home_url('/')).'"><img src="'.esc_url($prodent_logo_image).'" class="logo_footer_image" alt="'.esc_html($prodent_logo_text).'"'.(!empty($prodent_attr[3]) ? sprintf(' %s', $prodent_attr[3]) : '').'></a>' ;
				} else if (!empty($prodent_logo_text)) {
					echo '<h1 class="logo_footer_text"><a href="'.esc_url(home_url('/')).'">' . esc_html($prodent_logo_text) . '</a></h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
?>