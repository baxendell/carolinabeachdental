<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0
 */

						// Widgets area inside page content
						prodent_create_widgets_area('widgets_below_content');
						?>				
					</div><!-- </.content> -->

					<?php
					// Show main sidebar
					get_sidebar();

					// Widgets area below page content
					prodent_create_widgets_area('widgets_below_page');

					$prodent_body_style = prodent_get_theme_option('body_style');
					if ($prodent_body_style != 'fullscreen') {
						?></div><!-- </.content_wrap> --><?php
					}
					?>
			</div><!-- </.page_content_wrap> -->

			<?php
			// Footer
			$prodent_footer_type = prodent_get_theme_option("footer_type");
			if ($prodent_footer_type == 'custom' && !prodent_is_layouts_available())
				$prodent_footer_type = 'default';
			get_template_part( "templates/footer-{$prodent_footer_type}");
			?>

		</div><!-- /.page_wrap -->

	</div><!-- /.body_wrap -->

	<?php if (prodent_is_on(prodent_get_theme_option('debug_mode')) && prodent_get_file_dir('images/makeup.jpg')!='') { ?>
		<img src="<?php echo esc_url(prodent_get_file_url('images/makeup.jpg')); ?>" id="makeup">
	<?php } ?>

	<?php wp_footer(); ?>

</body>
</html>