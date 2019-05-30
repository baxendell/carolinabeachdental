<?php
/**
 * The template for homepage posts with "Excerpt" style
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

prodent_storage_set('blog_archive', true);

get_header(); 

if (have_posts()) {

	echo get_query_var('blog_archive_start');

	?><div class="posts_container"><?php
	
	$prodent_stickies = is_home() ? get_option( 'sticky_posts' ) : false;
	$prodent_sticky_out = prodent_get_theme_option('sticky_style')=='columns' 
							&& is_array($prodent_stickies) && count($prodent_stickies) > 0 && get_query_var( 'paged' ) < 1;
	if ($prodent_sticky_out) {
		?><div class="sticky_wrap columns_wrap"><?php	
	}
	while ( have_posts() ) { the_post(); 
		if ($prodent_sticky_out && !is_sticky()) {
			$prodent_sticky_out = false;
			?></div><?php
		}
		get_template_part( 'content', $prodent_sticky_out && is_sticky() ? 'sticky' : 'excerpt' );
	}
	if ($prodent_sticky_out) {
		$prodent_sticky_out = false;
		?></div><?php
	}
	
	?></div><?php

	prodent_show_pagination();

	echo get_query_var('blog_archive_end');

} else {

	if ( is_search() )
		get_template_part( 'content', 'none-search' );
	else
		get_template_part( 'content', 'none-archive' );

}

get_footer();
?>