<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

$prodent_blog_style = explode('_', prodent_get_theme_option('blog_style'));
$prodent_columns = empty($prodent_blog_style[1]) ? 1 : max(1, $prodent_blog_style[1]);
$prodent_expanded = !prodent_sidebar_present() && prodent_is_on(prodent_get_theme_option('expand_content'));
$prodent_post_format = get_post_format();
$prodent_post_format = empty($prodent_post_format) ? 'standard' : str_replace('post-format-', '', $prodent_post_format);
$prodent_animation = prodent_get_theme_option('blog_animation');

?><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_chess post_layout_chess_'.esc_attr($prodent_columns).' post_format_'.esc_attr($prodent_post_format) ); ?>
	<?php echo (!prodent_is_off($prodent_animation) ? ' data-animation="'.esc_attr(prodent_get_animation_classes($prodent_animation)).'"' : ''); ?>>

	<?php
	// Add anchor
	if ($prodent_columns == 1 && shortcode_exists('trx_sc_anchor')) {
		echo do_shortcode('[trx_sc_anchor id="post_'.esc_attr(get_the_ID()).'" title="'.esc_attr(get_the_title()).'"]');
	}

	// Sticky label
	if ( is_sticky() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	prodent_show_post_featured( array(
											'class' => $prodent_columns == 1 ? 'prodent-full-height' : '',
											'show_no_image' => true,
											'thumb_bg' => true,
											'thumb_size' => prodent_get_thumb_size(
																	strpos(prodent_get_theme_option('body_style'), 'full')!==false
																		? ( $prodent_columns > 1 ? 'huge' : 'original' )
																		: (	$prodent_columns > 2 ? 'big' : 'huge')
																	)
											) 
										);

	?><div class="post_inner"><div class="post_inner_content"><?php 

		?><div class="post_header entry-header"><?php 
			do_action('prodent_action_before_post_title'); 

			// Post title
			the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
			
			do_action('prodent_action_before_post_meta'); 

			// Post meta
			$prodent_components = prodent_is_inherit(prodent_get_theme_option_from_meta('meta_parts')) 
										? 'categories,date'.($prodent_columns < 3 ? ',counters' : '').($prodent_columns == 1 ? ',edit' : '')
										: prodent_array_get_keys_by_value(prodent_get_theme_option('meta_parts'));
			$prodent_counters = prodent_is_inherit(prodent_get_theme_option_from_meta('counters')) 
										? 'comments'
										: prodent_array_get_keys_by_value(prodent_get_theme_option('counters'));
			$prodent_post_meta = empty($prodent_components) 
										? '' 
										: prodent_show_post_meta(apply_filters('prodent_filter_post_meta_args', array(
												'components' => $prodent_components,
												'counters' => $prodent_counters,
												'seo' => false,
												'echo' => false
												), $prodent_blog_style[0], $prodent_columns)
											);
			prodent_show_layout($prodent_post_meta);
		?></div><!-- .entry-header -->
	
		<div class="post_content entry-content">
			<div class="post_content_inner">
				<?php
				$prodent_show_learn_more = !in_array($prodent_post_format, array('link', 'aside', 'status', 'quote'));
				if (has_excerpt()) {
					the_excerpt();
				} else if (strpos(get_the_content('!--more'), '!--more')!==false) {
					the_content( '' );
				} else if (in_array($prodent_post_format, array('link', 'aside', 'status'))) {
					the_content();
				} else if ($prodent_post_format == 'quote') {
					if (($quote = prodent_get_tag(get_the_content(), '<blockquote>', '</blockquote>'))!='')
						prodent_show_layout(wpautop($quote));
					else
						the_excerpt();
				} else if (substr(get_the_content(), 0, 1)!='[') {
					the_excerpt();
				}
				?>
			</div>
			<?php
			// Post meta
			if (in_array($prodent_post_format, array('link', 'aside', 'status', 'quote'))) {
				prodent_show_layout($prodent_post_meta);
			}
			// More button
			if ( $prodent_show_learn_more ) {
				?><p><a class="more-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read more', 'prodent'); ?></a></p><?php
			}
			?>
		</div><!-- .entry-content -->

	</div></div><!-- .post_inner -->

</article>