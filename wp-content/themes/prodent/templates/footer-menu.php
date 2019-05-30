<?php
/**
 * The template to display menu in the footer
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.10
 */

// Footer menu
$prodent_menu_footer = prodent_get_nav_menu(array(
											'location' => 'menu_footer',
											'class' => 'sc_layouts_menu sc_layouts_menu_default'
											));
if (!empty($prodent_menu_footer)) {
	?>
	<div class="footer_menu_wrap">
		<div class="footer_menu_inner">
			<?php prodent_show_layout($prodent_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>