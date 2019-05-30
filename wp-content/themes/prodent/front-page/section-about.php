<div class="front_page_section front_page_section_about<?php
			$prodent_scheme = prodent_get_theme_option('front_page_about_scheme');
			if (!prodent_is_inherit($prodent_scheme)) echo ' scheme_'.esc_attr($prodent_scheme);
			echo ' front_page_section_paddings_'.esc_attr(prodent_get_theme_option('front_page_about_paddings'));
		?>"<?php
		$prodent_css = '';
		$prodent_bg_image = prodent_get_theme_option('front_page_about_bg_image');
		if (!empty($prodent_bg_image)) 
			$prodent_css .= 'background-image: url('.esc_url(prodent_get_attachment_url($prodent_bg_image)).');';
		if (!empty($prodent_css))
			echo " style=\"{$prodent_css}\"";
?>><?php
	// Add anchor
	$prodent_anchor_icon = prodent_get_theme_option('front_page_about_anchor_icon');	
	$prodent_anchor_text = prodent_get_theme_option('front_page_about_anchor_text');	
	if ((!empty($prodent_anchor_icon) || !empty($prodent_anchor_text)) && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="front_page_section_about"'
										. (!empty($prodent_anchor_icon) ? ' icon="'.esc_attr($prodent_anchor_icon).'"' : '')
										. (!empty($prodent_anchor_text) ? ' title="'.esc_attr($prodent_anchor_text).'"' : '')
										. ']');
	}
	?>
	<div class="front_page_section_inner front_page_section_about_inner<?php
			if (prodent_get_theme_option('front_page_about_fullheight'))
				echo ' prodent-full-height sc_layouts_flex sc_layouts_columns_middle';
			?>"<?php
			$prodent_css = '';
			$prodent_bg_mask = prodent_get_theme_option('front_page_about_bg_mask');
			$prodent_bg_color = prodent_get_theme_option('front_page_about_bg_color');
			if (!empty($prodent_bg_color) && $prodent_bg_mask > 0)
				$prodent_css .= 'background-color: '.esc_attr($prodent_bg_mask==1
																	? $prodent_bg_color
																	: prodent_hex2rgba($prodent_bg_color, $prodent_bg_mask)
																).';';
			if (!empty($prodent_css))
				echo " style=\"{$prodent_css}\"";
	?>>
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$prodent_caption = prodent_get_theme_option('front_page_about_caption');
			if (!empty($prodent_caption) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo !empty($prodent_caption) ? 'filled' : 'empty'; ?>"><?php echo wp_kses_post($prodent_caption); ?></h2><?php
			}
		
			// Description (text)
			$prodent_description = prodent_get_theme_option('front_page_about_description');
			if (!empty($prodent_description) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo !empty($prodent_description) ? 'filled' : 'empty'; ?>"><?php echo wpautop(wp_kses_post($prodent_description)); ?></div><?php
			}
			
			// Content
			$prodent_content = prodent_get_theme_option('front_page_about_content');
			if (!empty($prodent_content) || (current_user_can('edit_theme_options') && is_customize_preview())) {
				?><div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo !empty($prodent_content) ? 'filled' : 'empty'; ?>"><?php
					$prodent_page_content_mask = '%%CONTENT%%';
					if (strpos($prodent_content, $prodent_page_content_mask) !== false) {
						$prodent_content = preg_replace(
									'/(\<p\>\s*)?'.$prodent_page_content_mask.'(\s*\<\/p\>)/i',
									sprintf('<div class="front_page_section_about_source">%s</div>',
												apply_filters('the_content', get_the_content())),
									$prodent_content
									);
					}
					prodent_show_layout($prodent_content);
				?></div><?php
			}
			?>
		</div>
	</div>
</div>