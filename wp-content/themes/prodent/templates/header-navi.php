<?php
/**
 * The template to display the main menu
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */
?>
<div class="top_panel_navi sc_layouts_row sc_layouts_row_type_compact sc_layouts_row_fixed <?php
			if (false) {
			echo ' scheme_'. esc_attr(prodent_is_inherit(prodent_get_theme_option('menu_scheme')) 
												? (prodent_is_inherit(prodent_get_theme_option('header_scheme')) 
													? prodent_get_theme_option('color_scheme') 
													: prodent_get_theme_option('header_scheme')) 
												: prodent_get_theme_option('menu_scheme'));
			}
			?>">
		<div class="columns_wrap sc_layouts_flex sc_layouts_columns_stretch sc_layouts_content_middle">
			<div class="sc_layouts_column sc_layouts_column_align_left sc_layouts_column_icons_position_left column-1_4">
				<?php
				// Logo
				?><div class="sc_layouts_item"><?php
					get_template_part( 'templates/header-logo' );
				?></div>
			</div><?php
			
			// Attention! Don't place any spaces between columns!
			?><div class="sc_layouts_column sc_layouts_column_align_right sc_layouts_column_icons_position_left column-3_4">
				<div class="sc_layouts_item">
					<?php
					// Main menu
					$prodent_menu_main = prodent_get_nav_menu(array(
						'location' => 'menu_main', 
						'class' => 'sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile'
						)
					);
					if (empty($prodent_menu_main)) {
						$prodent_menu_main = prodent_get_nav_menu(array(
							'class' => 'sc_layouts_menu sc_layouts_menu_default sc_layouts_hide_on_mobile'
							)
						);
					}
					prodent_show_layout($prodent_menu_main);
					// Mobile menu button
					?>
					<div class="sc_layouts_iconed_text sc_layouts_menu_mobile_button">
						<a class="sc_layouts_item_link sc_layouts_iconed_text_link" href="#">
							<span class="sc_layouts_item_icon sc_layouts_iconed_text_icon trx_addons_icon-menu"></span>
						</a>
					</div>
				</div>
			</div>
		</div><!-- /.sc_layouts_row -->
</div><!-- /.top_panel_navi -->