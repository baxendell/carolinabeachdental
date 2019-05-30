<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.1
 */
 
$prodent_theme_obj = wp_get_theme();
?>
<div class="update-nag" id="prodent_admin_notice">
	<h3 class="prodent_notice_title"><?php echo sprintf(esc_html__('Welcome to %s v.%s', 'prodent'), $prodent_theme_obj->name.(PRODENT_THEME_FREE ? ' '.esc_html__('Free', 'prodent') : ''), $prodent_theme_obj->version); ?></h3>
	<?php
	if (!prodent_exists_trx_addons()) {
		?><p><?php echo wp_kses_data(__('<b>Attention!</b> Plugin "ThemeREX Addons is required! Please, install and activate it!', 'prodent')); ?></p><?php
	}
	?><p>
		<a href="<?php echo esc_url(admin_url().'themes.php?page=prodent_about'); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> <?php echo sprintf(esc_html__('About %s', 'prodent'), $prodent_theme_obj->name); ?></a>
		<?php
		if (prodent_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'prodent'); ?></a>
			<?php
		}
		if (function_exists('prodent_exists_trx_addons') && prodent_exists_trx_addons() && class_exists('trx_addons_demo_data_importer')) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'prodent'); ?></a>
			<?php
		}
		?>
        <a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'prodent'); ?></a>
		<span> <?php esc_html_e('or', 'prodent'); ?> </span>
        <a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>" class="button button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Options', 'prodent'); ?></a>
        <a href="#" class="button prodent_hide_notice"><i class="dashicons dashicons-dismiss"></i> <?php esc_html_e('Hide Notice', 'prodent'); ?></a>
	</p>
</div>