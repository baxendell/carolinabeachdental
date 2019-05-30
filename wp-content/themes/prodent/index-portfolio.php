<?php
/**
 * The template for homepage posts with "Portfolio" style
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

prodent_storage_set('blog_archive', true);

// Load scripts for both 'Gallery' and 'Portfolio' layouts!
wp_enqueue_script( 'imagesloaded' );
wp_enqueue_script( 'masonry' );
wp_enqueue_script( 'classie', prodent_get_file_url('js/theme.gallery/classie.min.js'), array(), null, true );
wp_enqueue_script( 'prodent-gallery-script', prodent_get_file_url('js/theme.gallery/theme.gallery.js'), array(), null, true );

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	$prodent_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$prodent_sticky_out = prodent_get_theme_option('sticky_style')=='columns' 
							&& is_array($prodent_stickies) && count($prodent_stickies) > 0 && get_query_var( 'paged' ) < 1;
	
	// Show filters
	$prodent_cat = prodent_get_theme_option('parent_cat');
	$prodent_post_type = prodent_get_theme_option('post_type');
	$prodent_taxonomy = prodent_get_post_type_taxonomy($prodent_post_type);
	$prodent_show_filters = prodent_get_theme_option('show_filters');
	$prodent_tabs = array();
	if (!prodent_is_off($prodent_show_filters)) {
		$prodent_args = array(
			'type'			=> $prodent_post_type,
			'child_of'		=> $prodent_cat,
			'orderby'		=> 'name',
			'order'			=> 'ASC',
			'hide_empty'	=> 1,
			'hierarchical'	=> 0,
			'exclude'		=> '',
			'include'		=> '',
			'number'		=> '',
			'taxonomy'		=> $prodent_taxonomy,
			'pad_counts'	=> false
		);
		$prodent_portfolio_list = get_terms($prodent_args);
		if (is_array($prodent_portfolio_list) && count($prodent_portfolio_list) > 0) {
			$prodent_tabs[$prodent_cat] = esc_html__('All', 'prodent');
			foreach ($prodent_portfolio_list as $prodent_term) {
				if (isset($prodent_term->term_id)) $prodent_tabs[$prodent_term->term_id] = $prodent_term->name;
			}
		}
	}
	if (count($prodent_tabs) > 0) {
		$prodent_portfolio_filters_ajax = true;
		$prodent_portfolio_filters_active = $prodent_cat;
		$prodent_portfolio_filters_id = 'portfolio_filters';
		if (!is_customize_preview())
			wp_enqueue_script('jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true);
		?>
		<div class="portfolio_filters prodent_tabs prodent_tabs_ajax">
			<ul class="portfolio_titles prodent_tabs_titles">
				<?php
				foreach ($prodent_tabs as $prodent_id=>$prodent_title) {
					?><li><a href="<?php echo esc_url(prodent_get_hash_link(sprintf('#%s_%s_content', $prodent_portfolio_filters_id, $prodent_id))); ?>" data-tab="<?php echo esc_attr($prodent_id); ?>"><?php echo esc_html($prodent_title); ?></a></li><?php
				}
				?>
			</ul>
			<?php
			$prodent_ppp = prodent_get_theme_option('posts_per_page');
			if (prodent_is_inherit($prodent_ppp)) $prodent_ppp = '';
			foreach ($prodent_tabs as $prodent_id=>$prodent_title) {
				$prodent_portfolio_need_content = $prodent_id==$prodent_portfolio_filters_active || !$prodent_portfolio_filters_ajax;
				?>
				<div id="<?php echo esc_attr(sprintf('%s_%s_content', $prodent_portfolio_filters_id, $prodent_id)); ?>"
					class="portfolio_content prodent_tabs_content"
					data-blog-template="<?php echo esc_attr(prodent_storage_get('blog_template')); ?>"
					data-blog-style="<?php echo esc_attr(prodent_get_theme_option('blog_style')); ?>"
					data-posts-per-page="<?php echo esc_attr($prodent_ppp); ?>"
					data-post-type="<?php echo esc_attr($prodent_post_type); ?>"
					data-taxonomy="<?php echo esc_attr($prodent_taxonomy); ?>"
					data-cat="<?php echo esc_attr($prodent_id); ?>"
					data-parent-cat="<?php echo esc_attr($prodent_cat); ?>"
					data-need-content="<?php echo (false===$prodent_portfolio_need_content ? 'true' : 'false'); ?>"
				>
					<?php
					if ($prodent_portfolio_need_content) 
						prodent_show_portfolio_posts(array(
							'cat' => $prodent_id,
							'parent_cat' => $prodent_cat,
							'taxonomy' => $prodent_taxonomy,
							'post_type' => $prodent_post_type,
							'page' => 1,
							'sticky' => $prodent_sticky_out
							)
						);
					?>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} else {
		prodent_show_portfolio_posts(array(
			'cat' => $prodent_cat,
			'parent_cat' => $prodent_cat,
			'taxonomy' => $prodent_taxonomy,
			'post_type' => $prodent_post_type,
			'page' => 1,
			'sticky' => $prodent_sticky_out
			)
		);
	}

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>