<div class="front_page_section front_page_section_googlemap<?php
			$prodent_scheme = prodent_get_theme_option('front_page_googlemap_scheme');
			if (!prodent_is_inherit($prodent_scheme)) echo ' scheme_'.esc_attr($prodent_scheme);
			echo ' front_page_section_paddings_'.esc_attr(prodent_get_theme_option('front_page_googlemap_paddings'));
		?>"<?php
		$prodent_css = '';
		$prodent_bg_image = prodent_get_theme_option('front_page_googlemap_bg_image');
		if (!empty($prodent_bg_image)) 
			$prodent_css .= 'background-image: url('.esc_url(prodent_get_attachment_url($prodent_bg_image)).');';
		if (!empty($prodent_css))
			echo " style=\"{$prodent_css}\"";
?>><?php
	// Add anchor
	$prodent_anchor_icon = prodent_get_theme_option('front_page_googlemap_anchor_icon');	
	$prodent_anchor_text = prodent_get_theme_option('front_page_googlemap_anchor_text');	
	if ((!empty($prodent_anchor_icon) || !empty($prodent_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_googlemap"'
										. (!empty($prodent_anchor_icon) ? ' icon="'.esc_attr($prodent_anchor_icon).'"' : '')
										. (!empty($prodent_anchor_text) ? ' title="'.esc_attr($prodent_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_googlemap_inner<?php
			if (prodent_get_theme_option('front_page_googlemap_fullheight'))
				echo ' prodent-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$prodent_css = '';
			$prodent_bg_mask = prodent_get_theme_option('front_page_googlemap_bg_mask');
			$prodent_bg_color = prodent_get_theme_option('front_page_googlemap_bg_color');
			if (!empty($prodent_bg_color) && $prodent_bg_mask > 0)
				$prodent_css .= 'background-color: '.esc_attr($prodent_bg_mask==1
																	? $prodent_bg_color
																	: prodent_hex2rgba($prodent_bg_color, $prodent_bg_mask)
																).';';
			if (!empty($prodent_css))
				echo " style=\"{$prodent_css}\"";
	?>>
		<div class="front_page_section_content_wrap front_page_section_googlemap_content_wrap<?php
			$prodent_layout = prodent_get_theme_option('front_page_googlemap_layout');
			if ($prodent_layout != 'fullwidth')
				echo ' content_wrap';
		?>">
			<?php
			// Content wrap with title and description
			$prodent_caption = prodent_get_theme_option('front_page_googlemap_caption');
			$prodent_description = prodent_get_theme_option('front_page_googlemap_description');
			if (!empty($prodent_caption) || !empty($prodent_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($prodent_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
					// Caption
					if (!empty($prodent_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><h2 class="front_page_section_caption front_page_section_googlemap_caption front_page_block_<?php echo !empty($prodent_caption) ? 'filled' : 'empty'; ?>"><?php
							echo wp_kses_post($prodent_caption);
						?></h2><?php
					}
				
					// Description (text)
					if (!empty($prodent_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
						?><div class="front_page_section_description front_page_section_googlemap_description front_page_block_<?php echo !empty($prodent_description) ? 'filled' : 'empty'; ?>"><?php
							echo wpautop(wp_kses_post($prodent_description));
						?></div><?php
					}
				if ($prodent_layout == 'fullwidth') {
					?></div><?php
				}
			}

			// Content (text)
			$prodent_content = prodent_get_theme_option('front_page_googlemap_content');
			if (!empty($prodent_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				if ($prodent_layout == 'columns') {
					?><div class="front_page_section_columns front_page_section_googlemap_columns columns_wrap">
						<div class="column-1_3">
					<?php
				} else if ($prodent_layout == 'fullwidth') {
					?><div class="content_wrap"><?php
				}
	
				?><div class="front_page_section_content front_page_section_googlemap_content front_page_block_<?php echo !empty($prodent_content) ? 'filled' : 'empty'; ?>"><?php
					echo wp_kses_post($prodent_content);
				?></div><?php
	
				if ($prodent_layout == 'columns') {
					?></div><div class="column-2_3"><?php
				} else if ($prodent_layout == 'fullwidth') {
					?></div><?php
				}
			}
			
			// Widgets output
			?><div class="front_page_section_output front_page_section_googlemap_output"><?php 
				if (is_active_sidebar('front_page_googlemap_widgets')) {
					dynamic_sidebar( 'front_page_googlemap_widgets' );
				} else if (current_user_can( 'edit_theme_options' )) {
					if (!prodent_exists_trx_addons())
						prodent_customizer_need_trx_addons_message();
					else
						prodent_customizer_need_widgets_message('front_page_googlemap_caption', 'ThemeREX Addons - Google map');
				}
			?></div><?php

			if ($prodent_layout == 'columns' && (!empty($prodent_content) || (current_user_can('edit_theme_options') && is_customize_preview()))) {
				?></div></div><?php
			}
			?>			
		</div>
	</div>
</div>