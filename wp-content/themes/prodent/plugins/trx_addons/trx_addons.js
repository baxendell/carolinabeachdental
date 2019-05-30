/* global jQuery:false */
/* global PRODENT_STORAGE:false */
/* global TRX_ADDONS_STORAGE:false */

(function() {
	"use strict";
	
	jQuery(document).on('action.add_googlemap_styles', prodent_trx_addons_add_googlemap_styles);
	jQuery(document).on('action.init_shortcodes', prodent_trx_addons_init);
	jQuery(document).on('action.init_hidden_elements', prodent_trx_addons_init);
	
	// Add theme specific styles to the Google map
	function prodent_trx_addons_add_googlemap_styles(e) {
		if (typeof TRX_ADDONS_STORAGE == 'undefined') return;
		TRX_ADDONS_STORAGE['googlemap_styles']['dark'] = [{"featureType":"all","elementType":"geometry.fill","stylers":[{"weight":"2.00"}]},{"featureType":"all","elementType":"geometry.stroke","stylers":[{"color":"#9c9c9c"}]},{"featureType":"all","elementType":"labels.text","stylers":[{"visibility":"on"}]},{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#404040"},{"lightness":"-3"}]},{"featureType":"landscape","elementType":"all","stylers":[{"color":"#f2f2f2"}]},{"featureType":"landscape","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"poi","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"all","stylers":[{"saturation":-100},{"lightness":45}]},{"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#f4f7f7"},{"lightness":"-3"}]},{"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#9da6ae"},{"gamma":"1.57"},{"lightness":"-18"}]},{"featureType":"road","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"all","stylers":[{"visibility":"simplified"}]},{"featureType":"road.arterial","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"transit","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"all","stylers":[{"color":"#bac0c6"},{"visibility":"on"},{"gamma":"5.09"},{"saturation":"1"}]},{"featureType":"water","elementType":"geometry.fill","stylers":[{"color":"#bac0c6"},{"saturation":"5"},{"lightness":"33"}]},{"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#070707"}]},{"featureType":"water","elementType":"labels.text.stroke","stylers":[{"color":"#ffffff"}]}];
	}
	
	
	function prodent_trx_addons_init(e, container) {
		if (arguments.length < 2) var container = jQuery('body');
		if (container===undefined || container.length === undefined || container.length == 0) return;
		container.find('.sc_countdown_item canvas:not(.inited)').addClass('inited').attr('data-color', PRODENT_STORAGE['alter_link_color']);
	}

})();