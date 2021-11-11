"use strict";

is_visible_init ();
foodmood_slick_navigation_init();

jQuery(document).ready(function($) {
	foodmood_split_slider();
	foodmood_sticky_init();
	foodmood_search_init();
	foodmood_side_panel_init();
	foodmood_mobile_header();
	foodmood_woocommerce_helper();
	foodmood_woocommerce_tools();
	foodmood_woocommerce_filters();
	foodmood_woocommerce_tabs();
	foodmood_woocommerce_login_in();
	foodmood_init_timeline_appear();
	foodmood_accordion_init();
	foodmood_striped_services_init();
	foodmood_progress_bars_init();
	foodmood_carousel_slick();
	foodmood_image_comparison();
	foodmood_counter_init();
	foodmood_countdown_init ();
	foodmood_circuit_services();
	foodmood_circuit_services_resize();
	foodmood_img_layers();
	foodmood_page_title_parallax();
	foodmood_extended_parallax();
	foodmood_portfolio_parallax();
	foodmood_message_anim_init();
	foodmood_scroll_up();
	foodmood_link_scroll();
	foodmood_skrollr_init();
	foodmood_sticky_sidebar ();
	foodmood_videobox_init ();
	foodmood_parallax_video();
	foodmood_tabs_init();
	foodmood_select_wrap();
	jQuery( '.wgl_module_title .carousel_arrows' ).foodmood_slick_navigation();
	jQuery( '.wgl-products > .carousel_arrows' ).foodmood_slick_navigation();
	jQuery( '.foodmood_module_custom_image_cats > .carousel_arrows' ).foodmood_slick_navigation();
	foodmood_scroll_animation();
	foodmood_woocommerce_mini_cart();
	foodmood_woocommerce_notifications();
	foodmood_text_background();
	littledino_parallax_mouse();
	foodmood_dynamic_styles();
});

jQuery(window).load(function() {
	foodmood_isotope();
	foodmood_blog_masonry_init();
	setTimeout(function(){
		jQuery('#preloader-wrapper').fadeOut();
	},1100);
	particles_custom();

	foodmood_menu_lavalamp();
	jQuery(".wgl-currency-stripe_scrolling").each(function(){
    	jQuery(this).simplemarquee({
	        speed: 40,
	        space: 0,
	        handleHover: true,
	        handleResize: true
	    });
    })
});
