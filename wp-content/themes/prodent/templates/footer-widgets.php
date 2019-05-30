<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.10
 */

// Footer sidebar
$prodent_footer_name = prodent_get_theme_option('footer_widgets');
$prodent_footer_present = !prodent_is_off($prodent_footer_name) && is_active_sidebar($prodent_footer_name);
if ($prodent_footer_present) { 
	prodent_storage_set('current_sidebar', 'footer');
	$prodent_footer_wide = prodent_get_theme_option('footer_wide');
	ob_start();
	if ( is_active_sidebar($prodent_footer_name) ) {
		dynamic_sidebar($prodent_footer_name);
	}
	$prodent_out = trim(ob_get_contents());
	ob_end_clean();
	if (!empty($prodent_out)) {
		$prodent_out = preg_replace("/<\\/aside>[\r\n\s]*<aside/", "</aside><aside", $prodent_out);
		$prodent_need_columns = true;	//or check: strpos($prodent_out, 'columns_wrap')===false;
		if ($prodent_need_columns) {
			$prodent_columns = max(0, (int) prodent_get_theme_option('footer_columns'));
			if ($prodent_columns == 0) $prodent_columns = min(4, max(1, substr_count($prodent_out, '<aside ')));
			if ($prodent_columns > 1)
				$prodent_out = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($prodent_columns).' widget ', $prodent_out);
			else
				$prodent_need_columns = false;
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo !empty($prodent_footer_wide) ? ' footer_fullwidth' : ''; ?> sc_layouts_row  sc_layouts_row_type_normal">
			<div class="footer_widgets_inner widget_area_inner">
				<?php 
				if (!$prodent_footer_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($prodent_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'prodent_action_before_sidebar' );
				prodent_show_layout($prodent_out);
				do_action( 'prodent_action_after_sidebar' );
				if ($prodent_need_columns) {
					?></div><!-- /.columns_wrap --><?php
				}
				if (!$prodent_footer_wide) {
					?></div><!-- /.content_wrap --><?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
?>