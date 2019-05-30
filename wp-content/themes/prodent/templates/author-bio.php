<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */
?>

<div class="author_info author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php 
		$prodent_mult = prodent_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120*$prodent_mult ); 
		?>
	</div><!-- .author_avatar -->

	<div class="author_description">
        <div class="about_title_label"><?php esc_html_e('About author', 'prodent'); ?></div>
		<h6 class="author_title" itemprop="name"><?php echo wp_kses_data(sprintf(__('%s', 'prodent'), '<span class="fn">'.get_the_author().'</span>')); ?></h6>

		<div class="author_bio" itemprop="description">
			<?php echo wp_kses_post(wpautop(get_the_author_meta( 'description' ))); ?>
			<?php do_action('prodent_action_user_meta'); ?>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
