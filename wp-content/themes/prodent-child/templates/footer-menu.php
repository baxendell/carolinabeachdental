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
		<a href="https://www.carecredit.com/apply?sitecode=bb3bupc06182018" style="position:relative; display:inline-block;"><div class="blocker" style="position:absolute; height:100%; width:100%; z-index:1;"></div><iframe width="200" height="200" class="assetIframe" style="border:0" src="//www.carecredit.com/providercenter/assets/views/resourcescenter/promote/assetlistings/getAsset.php?asset=513&mtype="></iframe></a>
		
		<div class="footer_menu_inner">
			<?php prodent_show_layout($prodent_menu_footer); ?>
		</div>
	</div>
	<?php
}
?>