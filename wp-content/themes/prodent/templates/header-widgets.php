<?php
/**
 * The template to display the widgets area in the header
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

// Header sidebar
$prodent_header_name = prodent_get_theme_option('header_widgets');
$prodent_header_present = !prodent_is_off($prodent_header_name) && is_active_sidebar($prodent_header_name);
if ($prodent_header_present) { 
	prodent_storage_set('current_sidebar', 'header');
	$prodent_header_wide = prodent_get_theme_option('header_wide');
	ob_start();
	if ( is_active_sidebar($prodent_header_name) ) {
		dynamic_sidebar($prodent_header_name);
	}
	$prodent_widgets_output = ob_get_contents();
	ob_end_clean();
	if (!empty($prodent_widgets_output)) {
		$prodent_widgets_output = preg_replace("/<\/aside>[\r\n\s]*<aside/", "</aside><aside", $prodent_widgets_output);
		$prodent_need_columns = strpos($prodent_widgets_output, 'columns_wrap')===false;
		if ($prodent_need_columns) {
			$prodent_columns = max(0, (int) prodent_get_theme_option('header_columns'));
			if ($prodent_columns == 0) $prodent_columns = min(6, max(1, substr_count($prodent_widgets_output, '<aside ')));
			if ($prodent_columns > 1)
				$prodent_widgets_output = preg_replace("/class=\"widget /", "class=\"column-1_".esc_attr($prodent_columns).' widget ', $prodent_widgets_output);
			else
				$prodent_need_columns = false;
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo !empty($prodent_header_wide) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<div class="header_widgets_inner widget_area_inner">
				<?php 
				if (!$prodent_header_wide) { 
					?><div class="content_wrap"><?php
				}
				if ($prodent_need_columns) {
					?><div class="columns_wrap"><?php
				}
				do_action( 'prodent_action_before_sidebar' );
				prodent_show_layout($prodent_widgets_output);
				do_action( 'prodent_action_after_sidebar' );
				if ($prodent_need_columns) {
					?></div>	<!-- /.columns_wrap --><?php
				}
				if (!$prodent_header_wide) {
					?></div>	<!-- /.content_wrap --><?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
?>