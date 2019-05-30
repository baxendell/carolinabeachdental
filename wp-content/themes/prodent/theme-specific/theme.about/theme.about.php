<?php
/**
 * Information about this theme
 *
 * @package WordPress
 * @subpackage PRODENT
 * @since PRODENT 1.0.30
 */


// Redirect to the 'About Theme' page after switch theme
if (!function_exists('prodent_about_after_switch_theme')) {
	add_action('after_switch_theme', 'prodent_about_after_switch_theme', 1000);
	function prodent_about_after_switch_theme() {
		update_option('prodent_about_page', 1);
	}
}
if ( !function_exists('prodent_about_after_setup_theme') ) {
	add_action( 'init', 'prodent_about_after_setup_theme', 1000 );
	function prodent_about_after_setup_theme() {
		if (get_option('prodent_about_page') == 1) {
			update_option('prodent_about_page', 0);
			wp_safe_redirect(admin_url().'themes.php?page=prodent_about');
			exit();
		}
	}
}


// Add 'About Theme' item in the Appearance menu
if (!function_exists('prodent_about_add_menu_items')) {
	add_action( 'admin_menu', 'prodent_about_add_menu_items' );
	function prodent_about_add_menu_items() {
		$theme = wp_get_theme();
		$theme_name = $theme->name . (PRODENT_THEME_FREE ? ' ' . esc_html__('Free', 'prodent') : '');
		add_theme_page(
			sprintf(esc_html__('About %s', 'prodent'), $theme_name),	//page_title
			sprintf(esc_html__('About %s', 'prodent'), $theme_name),	//menu_title
			'manage_options',											//capability
			'prodent_about',											//menu_slug
			'prodent_about_page_builder',								//callback
			'dashicons-format-status',									//icon
			''															//menu position
		);
	}
}


// Load page-specific scripts and styles
if (!function_exists('prodent_about_enqueue_scripts')) {
	add_action( 'admin_enqueue_scripts', 'prodent_about_enqueue_scripts' );
	function prodent_about_enqueue_scripts() {
		$screen = function_exists('get_current_screen') ? get_current_screen() : false;
		if (is_object($screen) && $screen->id == 'appearance_page_prodent_about') {
			// Scripts
			wp_enqueue_script( 'jquery-ui-tabs', false, array('jquery', 'jquery-ui-core'), null, true );
			if ( ($fdir = prodent_get_file_url('theme-specific/theme.about/theme.about.js')) != '' )
				wp_enqueue_script( 'prodent-about', $fdir, array('jquery'), null, true );
			
			if (function_exists('prodent_plugins_installer_enqueue_scripts'))
				prodent_plugins_installer_enqueue_scripts();
			
			// Styles
			wp_enqueue_style( 'fontello-icons',  prodent_get_file_url('css/font-icons/css/fontello-embedded.css') );
			if ( ($fdir = prodent_get_file_url('theme-specific/theme.about/theme.about.css')) != '' )
				wp_enqueue_style( 'prodent-about',  $fdir, array(), null );
		}
	}
}


// Build 'About Theme' page
if (!function_exists('prodent_about_page_builder')) {
	function prodent_about_page_builder() {
		$theme = wp_get_theme();
		?>
		<div class="prodent_about">
			<div class="prodent_about_header">
				
				<?php if (PRODENT_THEME_FREE) { ?>
					<a href="<?php echo esc_url(prodent_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="prodent_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'prodent');
										?></a>
				<?php } ?>
                <div class="prodent_about_logo"><?php
                    $logo = prodent_get_file_url('theme-specific/theme.about/logo.jpg');
                    if (empty($logo)) $logo = prodent_get_file_url('screenshot.jpg');
                    if (!empty($logo)) {
                        ?><img src="<?php echo esc_url($logo); ?>"><?php
                    }
                    ?></div>

				<h1 class="prodent_about_title"><?php
					echo sprintf(esc_html__('Welcome to %s %s v.%s', 'prodent'),
								$theme->name,
								PRODENT_THEME_FREE ? __('Free', 'prodent') : '',
								$theme->version
								);
				?></h1>
				<div class="prodent_about_description">
					<?php
					if (PRODENT_THEME_FREE) {
						?><p><?php
							echo wp_kses_data(sprintf(__('Now you are using Free version of <a href="%s">%s Pro Theme</a>.', 'prodent'),
														esc_url(prodent_storage_get('theme_download_url')),
														$theme->name
														)
												);
							echo '<br>' . wp_kses_data(sprintf(__('This version is SEO- and Retina-ready. It also has a built-in support for parallax and slider with swipe gestures. %s Free is compatible with many popular plugins, such as %s', 'prodent'),
														$theme->name,
														prodent_about_get_supported_plugins()
														)
												);
						?></p>
						<p><?php
							echo wp_kses_data(sprintf(__('We hope you have a great acquaintance with our themes. If you are looking for a fully functional website, you can get the <a href="%s">Pro Version here</a>', 'prodent'),
														esc_url(prodent_storage_get('theme_download_url'))
														)
												);
						?></p><?php
					} else {
						?><p><?php
							echo wp_kses_data(sprintf(__('%s is a Premium WordPress theme. It has a built-in support for parallax, slider with swipe gestures, and is SEO- and Retina-ready', 'prodent'),
														$theme->name
														)
												);
						?></p>
						<p><?php
							echo wp_kses_data(sprintf(__('The Premium Theme is compatible with many popular plugins, such as %s', 'prodent'),
														prodent_about_get_supported_plugins()
														)
												);
						?></p><?php
					}
					?>
				</div>
			</div>
			<div id="prodent_about_tabs" class="prodent_tabs prodent_about_tabs">
				<ul>
					<li><a href="#prodent_about_section_start"><?php esc_html_e('Getting started', 'prodent'); ?></a></li>
					<li><a href="#prodent_about_section_actions"><?php esc_html_e('Recommended actions', 'prodent'); ?></a></li>
					<?php if (PRODENT_THEME_FREE) { ?>
						<li><a href="#prodent_about_section_pro"><?php esc_html_e('Free vs PRO', 'prodent'); ?></a></li>
					<?php } ?>
				</ul>
				<div id="prodent_about_section_start" class="prodent_tabs_section prodent_about_section"><?php
				
					// Install required plugins
					if (!prodent_exists_trx_addons()) {
						?><div class="prodent_about_block"><div class="prodent_about_block_inner">
							<h2 class="prodent_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'prodent'); ?>
							</h2>
							<div class="prodent_about_block_description"><?php
								echo esc_html(sprintf(__('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'prodent'), $theme->name));
							?></div>
							<?php prodent_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="prodent_about_block"><div class="prodent_about_block_inner">
						<h2 class="prodent_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'prodent'); ?>
						</h2>
						<div class="prodent_about_block_description"><?php
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'prodent'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="prodent_about_block_link button button-primary"><?php
							esc_html_e('Install plugins', 'prodent');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="prodent_about_block"><div class="prodent_about_block_inner">
						<h2 class="prodent_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'prodent'); ?>
						</h2>
						<div class="prodent_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'prodent');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   class="prodent_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'prodent');
						?></a>
						<?php esc_html_e('or', 'prodent'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="prodent_about_block_link button"><?php
							esc_html_e('Theme Options', 'prodent');
						?></a>
					</div></div><?php
					
					// Documentation
					?><div class="prodent_about_block"><div class="prodent_about_block_inner">
						<h2 class="prodent_about_block_title">
							<i class="dashicons dashicons-book"></i>
							<?php esc_html_e('Read full documentation', 'prodent');	?>
						</h2>
						<div class="prodent_about_block_description"><?php
							echo esc_html(sprintf(__('Need more details? Please check our full online documentation for detailed information on how to use %s.', 'prodent'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(prodent_storage_get('theme_doc_url')); ?>"
						   target="_blank"
						   class="prodent_about_block_link button button-primary"><?php
							esc_html_e('Documentation', 'prodent');
						?></a>
					</div></div><?php
					
					// Support
					if (!PRODENT_THEME_FREE) {
						?><div class="prodent_about_block"><div class="prodent_about_block_inner">
							<h2 class="prodent_about_block_title">
								<i class="dashicons dashicons-sos"></i>
								<?php esc_html_e('Support', 'prodent'); ?>
							</h2>
							<div class="prodent_about_block_description"><?php
								echo esc_html(sprintf(__('We want to make sure you have the best experience using %s and that is why we gathered here all the necessary informations for you.', 'prodent'), $theme->name));
							?></div>
							<a href="<?php echo esc_url(prodent_storage_get('theme_support_url')); ?>"
							   target="_blank"
							   class="prodent_about_block_link button button-primary"><?php
								esc_html_e('Support', 'prodent');
							?></a>
						</div></div><?php
					}
					
					// Online Demo
					?><div class="prodent_about_block"><div class="prodent_about_block_inner">
						<h2 class="prodent_about_block_title">
							<i class="dashicons dashicons-images-alt2"></i>
							<?php esc_html_e('On-line demo', 'prodent'); ?>
						</h2>
						<div class="prodent_about_block_description"><?php
							echo esc_html(sprintf(__('Visit the Demo Version of %s to check out all the features it has', 'prodent'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(prodent_storage_get('theme_demo_url')); ?>"
						   target="_blank"
						   class="prodent_about_block_link button button-primary"><?php
							esc_html_e('View demo', 'prodent');
						?></a>
					</div></div>
					
				</div>



				<div id="prodent_about_section_actions" class="prodent_tabs_section prodent_about_section"><?php
				
					// Install required plugins
					if (!prodent_exists_trx_addons()) {
						?><div class="prodent_about_block"><div class="prodent_about_block_inner">
							<h2 class="prodent_about_block_title">
								<i class="dashicons dashicons-admin-plugins"></i>
								<?php esc_html_e('ThemeREX Addons', 'prodent'); ?>
							</h2>
							<div class="prodent_about_block_description"><?php
								echo esc_html(sprintf(__('It is highly recommended that you install the companion plugin "ThemeREX Addons" to have access to the layouts builder, awesome shortcodes, team and testimonials, services and slider, and many other features ...', 'prodent'), $theme->name));
							?></div>
							<?php prodent_plugins_installer_get_button_html('trx_addons'); ?>
						</div></div><?php
					}
					
					// Install recommended plugins
					?><div class="prodent_about_block"><div class="prodent_about_block_inner">
						<h2 class="prodent_about_block_title">
							<i class="dashicons dashicons-admin-plugins"></i>
							<?php esc_html_e('Recommended plugins', 'prodent'); ?>
						</h2>
						<div class="prodent_about_block_description"><?php
							echo esc_html(sprintf(__('Theme %s is compatible with a large number of popular plugins. You can install only those that are going to use in the near future.', 'prodent'), $theme->name));
						?></div>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>"
						   class="prodent_about_block_link button button button-primary"><?php
							esc_html_e('Install plugins', 'prodent');
						?></a>
					</div></div><?php
					
					// Customizer or Theme Options
					?><div class="prodent_about_block"><div class="prodent_about_block_inner">
						<h2 class="prodent_about_block_title">
							<i class="dashicons dashicons-admin-appearance"></i>
							<?php esc_html_e('Setup Theme options', 'prodent'); ?>
						</h2>
						<div class="prodent_about_block_description"><?php
							esc_html_e('Using the WordPress Customizer you can easily customize every aspect of the theme. If you want to use the standard theme settings page - open Theme Options and follow the same steps there.', 'prodent');
						?></div>
						<a href="<?php echo esc_url(admin_url().'customize.php'); ?>"
						   target="_blank"
						   class="prodent_about_block_link button button-primary"><?php
							esc_html_e('Customizer', 'prodent');
						?></a>
						<?php esc_html_e('or', 'prodent'); ?>
						<a href="<?php echo esc_url(admin_url().'themes.php?page=theme_options'); ?>"
						   class="prodent_about_block_link button"><?php
							esc_html_e('Theme Options', 'prodent');
						?></a>
					</div></div>
					
				</div>



				<?php if (PRODENT_THEME_FREE) { ?>
					<div id="prodent_about_section_pro" class="prodent_tabs_section prodent_about_section">
						<table class="prodent_about_table" cellpadding="0" cellspacing="0" border="0">
							<thead>
								<tr>
									<td class="prodent_about_table_info">&nbsp;</td>
									<td class="prodent_about_table_check"><?php echo esc_html(sprintf(__('%s Free', 'prodent'), $theme->name)); ?></td>
									<td class="prodent_about_table_check"><?php echo esc_html(sprintf(__('%s PRO', 'prodent'), $theme->name)); ?></td>
								</tr>
							</thead>
							<tbody>
	
	
								<?php
								// Responsive layouts
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Mobile friendly', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Responsive layout. Looks great on any device.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Built-in slider
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Built-in posts slider', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Allows you to add beautiful slides using the built-in shortcode/widget "Slider" with swipe gestures support.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Revolution slider
								if (prodent_storage_isset('required_plugins', 'revslider')) {
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Revolution Slider Compatibility', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Our built-in shortcode/widget "Slider" is able to work not only with posts, but also with slides created  in "Revolution Slider".', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// SiteOrigin Panels
								if (prodent_storage_isset('required_plugins', 'siteorigin-panels')) {
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Free PageBuilder', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Full integration with a nice free page builder "SiteOrigin Panels".', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Additional widgets pack', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('A number of useful widgets to create beautiful homepages and other sections of your website with SiteOrigin Panels.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Visual Composer
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Visual Composer', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Full integration with a very popular page builder "Visual Composer". A number of useful shortcodes and widgets to create beautiful homepages and other sections of your website.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Additional shortcodes pack', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('A number of useful shortcodes to create beautiful homepages and other sections of your website with Visual Composer.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Layouts builder
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Headers and Footers builder', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Powerful visual builder of headers and footers! No manual code editing - use all the advantages of drag-and-drop technology.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// WooCommerce
								if (prodent_storage_isset('required_plugins', 'woocommerce')) {
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('WooCommerce Compatibility', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Ready for e-commerce. You can build an online store with this theme.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Easy Digital Downloads
								if (prodent_storage_isset('required_plugins', 'easy-digital-downloads')) {
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Easy Digital Downloads Compatibility', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Ready for digital e-commerce. You can build an online digital store with this theme.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
								<?php } ?>
	
								<?php
								// Other plugins
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Many other popular plugins compatibility', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('PRO version is compatible (was tested and has built-in support) with many popular plugins.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Support
								?>
								<tr>
									<td class="prodent_about_table_info">
										<h2 class="prodent_about_table_info_title">
											<?php esc_html_e('Support', 'prodent'); ?>
										</h2>
										<div class="prodent_about_table_info_description"><?php
											esc_html_e('Our premium support is going to take care of any problems, in case there will be any of course.', 'prodent');
										?></div>
									</td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-no"></i></td>
									<td class="prodent_about_table_check"><i class="dashicons dashicons-yes"></i></td>
								</tr>
	
								<?php
								// Get PRO version
								?>
								<tr>
									<td class="prodent_about_table_info">&nbsp;</td>
									<td class="prodent_about_table_check" colspan="2">
										<a href="<?php echo esc_url(prodent_storage_get('theme_download_url')); ?>"
										   target="_blank"
										   class="prodent_about_block_link prodent_about_pro_link button button-primary"><?php
											esc_html_e('Get PRO version', 'prodent');
										?></a>
									</td>
								</tr>
	
							</tbody>
						</table>
					</div>
				<?php } ?>
				
			</div>
		</div>
		<?php
	}
}


// Utils
//------------------------------------

// Return supported plugin's names
if (!function_exists('prodent_about_get_supported_plugins')) {
	function prodent_about_get_supported_plugins() {
		return '"' . join('", "', array_values(prodent_storage_get('required_plugins'))) . '"';
	}
}

require_once PRODENT_THEME_DIR . 'includes/plugins.installer/plugins.installer.php';
?>