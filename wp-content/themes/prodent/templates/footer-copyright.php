<?php
/**
 * The template to display the copyright info in the footer
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.10
 */

// Copyright area
$prodent_footer_scheme =  prodent_is_inherit(prodent_get_theme_option('footer_scheme')) ? prodent_get_theme_option('color_scheme') : prodent_get_theme_option('footer_scheme');
$prodent_copyright_scheme = prodent_is_inherit(prodent_get_theme_option('copyright_scheme')) ? $prodent_footer_scheme : prodent_get_theme_option('copyright_scheme');
?> 
<div class="footer_copyright_wrap scheme_<?php echo esc_attr($prodent_copyright_scheme); ?>">
	<div class="footer_copyright_inner">
		<div class="content_wrap">
			
			<div class="copyright_text"><?php
				// Replace {{...}} and ((...)) on the <i>...</i> and <b>...</b>
				$prodent_copyright = prodent_prepare_macros(prodent_get_theme_option('copyright'));
				if (!empty($prodent_copyright)) {
					// Replace {date_format} on the current date in the specified format
					if (preg_match("/(\\{[\\w\\d\\\\\\-\\:]*\\})/", $prodent_copyright, $prodent_matches)) {
						$prodent_copyright = str_replace($prodent_matches[1], date(str_replace(array('{', '}'), '', $prodent_matches[1])), $prodent_copyright);
					}
					// Display copyright
					echo wp_kses_data(nl2br($prodent_copyright));
				}
			?></div>
		</div>
	</div>
</div>
