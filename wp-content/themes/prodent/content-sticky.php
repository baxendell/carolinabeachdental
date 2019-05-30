<?php
/**
 * The Sticky template to display the sticky posts
 *
 * Used for index/archive
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

$prodent_columns = max(1, min(3, count(get_option( 'sticky_posts' ))));
$prodent_post_format = get_post_format();
$prodent_post_format = empty($prodent_post_format) ? 'standard' : str_replace('post-format-', '', $prodent_post_format);
$prodent_animation = prodent_get_theme_option('blog_animation');

?><div class="column-1_<?php echo esc_attr($prodent_columns); ?>"><article id="post-<?php the_ID(); ?>" 
	<?php post_class( 'post_item post_layout_sticky post_format_'.esc_attr($prodent_post_format) ); ?>
	<?php echo (!prodent_is_off($prodent_animation) ? ' data-animation="'.esc_attr(prodent_get_animation_classes($prodent_animation)).'"' : ''); ?>
	>

	<?php
	if ( is_sticky() && is_home() && !is_paged() ) {
		?><span class="post_label label_sticky"></span><?php
	}

	// Featured image
	prodent_show_post_featured(array(
		'thumb_size' => prodent_get_thumb_size($prodent_columns==1 ? 'big' : ($prodent_columns==2 ? 'med' : 'avatar'))
	));

	if ( !in_array($prodent_post_format, array('link', 'aside', 'status', 'quote')) ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			the_title( sprintf( '<h6 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h6>' );
			// Post meta
			prodent_show_post_meta(apply_filters('prodent_filter_post_meta_args', array(), 'sticky', $prodent_columns));
			?>
		</div><!-- .entry-header -->
		<?php
	}
	?>
</article></div>