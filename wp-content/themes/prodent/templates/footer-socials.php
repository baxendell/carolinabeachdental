<?php
/**
 * The template to display the socials in the footer
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.10
 */


// Socials
if ( prodent_is_on(prodent_get_theme_option('socials_in_footer')) && ($prodent_output = prodent_get_socials_links()) != '') {
	?>
	<div class="footer_socials_wrap socials_wrap">
		<div class="footer_socials_inner">
			<?php prodent_show_layout($prodent_output); ?>
		</div>
	</div>
	<?php
}
?>