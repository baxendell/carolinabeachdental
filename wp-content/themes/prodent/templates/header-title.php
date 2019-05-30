<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

// Page (category, tag, archive, author) title

if ( prodent_need_page_title() ) {
	prodent_sc_layouts_showed('title', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal scheme_dark">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_left">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_left">
						<?php
						
						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$prodent_blog_title = prodent_get_blog_title();
							$prodent_blog_title_text = $prodent_blog_title_class = $prodent_blog_title_link = $prodent_blog_title_link_text = '';
							if (is_array($prodent_blog_title)) {
								$prodent_blog_title_text = $prodent_blog_title['text'];
								$prodent_blog_title_class = !empty($prodent_blog_title['class']) ? ' '.$prodent_blog_title['class'] : '';
								$prodent_blog_title_link = !empty($prodent_blog_title['link']) ? $prodent_blog_title['link'] : '';
								$prodent_blog_title_link_text = !empty($prodent_blog_title['link_text']) ? $prodent_blog_title['link_text'] : '';
							} else
								$prodent_blog_title_text = $prodent_blog_title;
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr($prodent_blog_title_class); ?>"><?php
								$prodent_top_icon = prodent_get_category_icon();
								if (!empty($prodent_top_icon)) {
									$prodent_attr = prodent_getimagesize($prodent_top_icon);
                                    $alt = basename($prodent_top_icon);
                                    $alt = substr($alt,0,strlen($alt) - 4);
									?><img src="<?php echo esc_url($prodent_top_icon); ?>" alt="<?php echo esc_html($alt); ?>" <?php if (!empty($prodent_attr[3])) prodent_show_layout($prodent_attr[3]);?>><?php
								}
								echo wp_kses_data($prodent_blog_title_text);
							?></h1>
							<?php
							if (!empty($prodent_blog_title_link) && !empty($prodent_blog_title_link_text)) {
								?><a href="<?php echo esc_url($prodent_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($prodent_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'prodent_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>