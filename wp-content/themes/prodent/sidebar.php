<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

if (prodent_sidebar_present()) {
	ob_start();
	$prodent_sidebar_name = prodent_get_theme_option('sidebar_widgets');
	prodent_storage_set('current_sidebar', 'sidebar');
	if ( is_active_sidebar($prodent_sidebar_name) ) {
		dynamic_sidebar($prodent_sidebar_name);
	}
	$prodent_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($prodent_out)) {
		$prodent_sidebar_position = prodent_get_theme_option('sidebar_position');
		?>
		<div class="sidebar <?php echo esc_attr($prodent_sidebar_position); ?> widget_area<?php if (!prodent_is_inherit(prodent_get_theme_option('sidebar_scheme'))) echo ' scheme_'.esc_attr(prodent_get_theme_option('sidebar_scheme')); ?>" role="complementary">
			<div class="sidebar_inner">
				<?php
				do_action( 'prodent_action_before_sidebar' );
				prodent_show_layout(preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $prodent_out));
				do_action( 'prodent_action_after_sidebar' );
				?>
			</div><!-- /.sidebar_inner -->
		</div><!-- /.sidebar -->
		<?php
	}
}
?>