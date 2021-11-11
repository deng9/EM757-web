<?php

update_option( 'wgl_licence_validated', '*********' );

//Class Theme Helper
require_once ( get_theme_file_path( '/core/class/theme-helper.php' ) );

//Class Theme Cache
require_once ( get_theme_file_path( '/core/class/theme-cache.php' ) );

//Class Walker comments
require_once ( get_theme_file_path( '/core/class/walker-comment.php' ) );

//Class Walker Mega Menu
require_once ( get_theme_file_path( '/core/class/walker-mega-menu.php' ) );

//Class Theme Likes
require_once ( get_theme_file_path( '/core/class/theme-likes.php' ) );

//Class Theme Cats Meta
require_once ( get_theme_file_path( '/core/class/theme-cat-meta.php' ) );

//Class Single Post
require_once ( get_theme_file_path( '/core/class/single-post.php' ) );

//Class Tinymce
require_once ( get_theme_file_path( '/core/class/tinymce-icon.php' ) );

//Class Theme Autoload
require_once ( get_theme_file_path( '/core/class/theme-autoload.php' ) );

// Class Theme Elementor Pro Support
if (class_exists('\ElementorPro\Modules\ThemeBuilder\Module')) {
    require_once(get_theme_file_path('/core/class/theme-elementor-pro-support.php'));
}

//Class Theme Dashboard
require_once ( get_theme_file_path( '/core/class/theme-panel.php' ) );

//Class Theme Verify
require_once ( get_theme_file_path( '/core/class/theme-verify.php' ) );

function foodmood_content_width() {
    if ( ! isset( $content_width ) ) {
        $content_width = 940;
    }
}
add_action( 'after_setup_theme', 'foodmood_content_width', 0 );

function foodmood_theme_slug_setup() {
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'foodmood_theme_slug_setup');

add_action('init', 'foodmood_page_init');
if (!function_exists('foodmood_page_init')) {
    function foodmood_page_init()
    {
        add_post_type_support('page', 'excerpt');
    }
}

if (!function_exists('foodmood_main_menu')) {
    function foodmood_main_menu ($location = ''){
        wp_nav_menu( array(
            'theme_location'  => 'main_menu',
            'menu'  => $location,
            'container' => '',
            'container_class' => '',
            'after' => '',
            'link_before'     => '<span>',
            'link_after'      => '</span>',
            'walker' => new Foodmood_Mega_Menu_Waker()
        ) );
    }
}

// return all sidebars
if (!function_exists('foodmood_get_all_sidebar')) {
    function foodmood_get_all_sidebar() {
        global $wp_registered_sidebars;
        $out = array();
        if ( empty( $wp_registered_sidebars ) )
            return;
         foreach ( $wp_registered_sidebars as $sidebar_id => $sidebar) :
            $out[$sidebar_id] = $sidebar['name'];
         endforeach;
         return $out;
    }
}

if (!function_exists('foodmood_get_custom_preset')) {
    function foodmood_get_custom_preset() {
        $custom_preset = get_option('foodmood_set_preset');
        $presets =  foodmood_default_preset();

        $out = array();
        $out['default'] = esc_html__( 'Default', 'foodmood' );
        $i = 1;
        if(is_array($presets)){
            foreach ($presets as $key => $value) {
                $out[$key] = $key;
                $i++;
            }
        }
        if(is_array($custom_preset)){
            foreach ( $custom_preset as $preset_id => $preset) :
                $out[$preset_id] = $preset_id;
            endforeach;
        }
        return $out;
    }
}

if (!function_exists('foodmood_get_custom_menu')) {
    function foodmood_get_custom_menu() {
        $taxonomies = array();

        $menus = get_terms('nav_menu');
        foreach ($menus as $key => $value) {
            $taxonomies[$value->name] = $value->name;
        }
        return $taxonomies;
    }
}

function foodmood_get_attachment( $attachment_id ) {
    $attachment = get_post( $attachment_id );
    return array(
        'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
        'caption' => $attachment->post_excerpt,
        'description' => $attachment->post_content,
        'href' => get_permalink( $attachment->ID ),
        'src' => $attachment->guid,
        'title' => $attachment->post_title
    );
}

if (!function_exists('foodmood_reorder_comment_fields')) {
    function foodmood_reorder_comment_fields($fields ) {
        $new_fields = array();

        $myorder = array('author', 'email', 'url', 'comment');

        foreach( $myorder as $key ){
            $new_fields[ $key ] = isset($fields[ $key ]) ? $fields[ $key ] : '';
            unset( $fields[ $key ] );
        }

        if( $fields ) {
            foreach( $fields as $key => $val ) {
                $new_fields[ $key ] = $val;
            }
        }

        return $new_fields;
    }
}
add_filter('comment_form_fields', 'foodmood_reorder_comment_fields');

function foodmood_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
add_filter( 'mce_buttons_2', 'foodmood_mce_buttons_2' );


if (!function_exists('foodmood_header_enable')) {
    function foodmood_header_enable() {

        $header_switch = Foodmood_Theme_Helper::get_option('header_switch');
        $header_switch = is_null($header_switch) ? true : $header_switch;

        if(empty($header_switch)) return false;

        $id = !is_archive() ? get_queried_object_id() : 0;
        // Don't render header if in metabox set to hide it.
        if (
            class_exists('RWMB_Loader')
            && $id !== 0
            && rwmb_meta('mb_customize_header_layout') == 'hide'
        ) {
            return false;
        }

        //hide if 404 page
        $page_not_found = Foodmood_Theme_Helper::get_option('404_show_header');
        if (is_404() && !(bool) $page_not_found) return;

        return true;
    }
}

add_filter('foodmood_header_enable', 'foodmood_header_enable');

if (!function_exists('foodmood_page_title_enable')) {
    function foodmood_page_title_enable()
    {
        $id = !is_archive() ? get_queried_object_id() : 0;

        $output['mb_page_title_switch'] = '';
        if (is_404()) {
            $output['page_title_switch'] = Foodmood_Theme_Helper::get_option('404_page_title_switcher') ? 'on' : 'off';
        } else {
            $output['page_title_switch'] = Foodmood_Theme_Helper::get_option('page_title_switch') ? 'on' : 'off';
            if (class_exists('RWMB_Loader') && $id !== 0) {
                $output['mb_page_title_switch'] = rwmb_meta('mb_page_title_switch');
            }
        }

        $output['single'] = ['type' => '', 'layout' => ''];

        /**
         * Check the Post Type
         *
         * Aimed to prevent Page Title rendering for the following pages:
         *	- blog single type 3;
         *
         * @since 1.0.0
         */
        if (
            get_post_type($id) == 'post'
            && is_single()
        ) {
            $output['single']['type'] = 'post';
            $output['single']['layout'] = Foodmood_Theme_Helper::options_compare('single_type_layout', 'mb_post_layout_conditional', 'custom');
            if ($output['single']['layout'] === '3') {
                $output['page_title_switch'] = 'off';
            }
        }

        if (isset($output['mb_page_title_switch']) && $output['mb_page_title_switch'] == 'on') {
            $output['page_title_switch'] = 'on';
        }

        if (
            is_home()
            || is_front_page()
            || isset($output['mb_page_title_switch']) && $output['mb_page_title_switch'] == 'off'
        ) {
            $output['page_title_switch'] = 'off';
        }

        return $output;
    }
}

add_filter('foodmood_page_title_enable', 'foodmood_page_title_enable');

if (!function_exists('foodmood_footer_enable')) {
    function foodmood_footer_enable()
    {
        $output = [];
        $output['footer_switch'] = Foodmood_Theme_Helper::get_option('footer_switch');
        $output['copyright_switch'] = Foodmood_Theme_Helper::get_option('copyright_switch');

        if (class_exists('RWMB_Loader') && get_queried_object_id() !== 0) {
            $output['mb_footer_switch'] = rwmb_meta('mb_footer_switch');
            $output['mb_copyright_switch'] = rwmb_meta('mb_copyright_switch');

            if ($output['mb_footer_switch'] == 'on') {
                $output['footer_switch'] = true;
            } elseif ($output['mb_footer_switch'] == 'off') {
                $output['footer_switch'] = false;
            }

            if ($output['mb_copyright_switch'] == 'on') {
                $output['copyright_switch'] = true;
            } elseif ($output['mb_copyright_switch'] == 'off') {
                $output['copyright_switch'] = false;
            }
        }

        // Hide on 404 page
        $page_not_found = Foodmood_Theme_Helper::get_option('404_show_footer');
        if (is_404() && !$page_not_found) $output['footer_switch'] = $output['copyright_switch'] = false;

        return $output;
    }
}

add_filter('foodmood_footer_enable', 'foodmood_footer_enable');

add_action('foodmood_preloader', 'Foodmood_Theme_Helper::preloader');

if (!function_exists('foodmood_after_main_content')) {
    function foodmood_after_main_content()
    {
        global $foodmood_dynamic_css;

        if(is_page()){
			$social_shares = Foodmood_Theme_Helper::get_option('show_soc_icon_page');

			if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
			    $mb_social_shares = rwmb_meta('mb_customize_soc_shares');

			    if ($mb_social_shares == 'on') {
			        $social_shares = '1';
			    }elseif($mb_social_shares == 'off'){
			        $social_shares = '';
				}
			}

			if( !empty($social_shares) && function_exists('wgl_theme_helper') ){
			    echo wgl_theme_helper()->render_social_shares();
			}
		}
		$markers = Foodmood_Theme_Helper::get_option('show_page_marker');
		if (class_exists( 'RWMB_Loader' ) && get_queried_object_id() !== 0) {
			$mb_markers = rwmb_meta('mb_customize_markers');

			if ($mb_markers == 'on') {
				$markers = '1';
			}elseif($mb_markers == 'off'){
				$markers = '';
			}
		}

		if( !empty($markers) &&  function_exists('wgl_theme_helper') ){
			echo wgl_theme_helper()->render_page_marker();
		}

        $scroll_up = Foodmood_Theme_Helper::get_option('scroll_up');

        // Scroll Up Button
        if ($scroll_up) {
            echo '<a href="#" id="scroll_up"></a>';
        }

        // Dynamic Styles
        if (!empty($foodmood_dynamic_css['style'])) {
            echo '<span',
                ' id="foodmood-footer-inline-css"',
                ' class="dynamic_styles-footer"',
                ' style="display: none;"',
                '>',
                $foodmood_dynamic_css['style'],
            '</span>';
        }
    }
}

add_action('foodmood_after_main_content', 'foodmood_after_main_content');


function foodmood_tiny_mce_before_init( $settings ) {

    $settings['theme_advanced_blockformats'] = 'p,h1,h2,h3,h4';
    $header_font_color = esc_attr(\Foodmood_Theme_Helper::get_option('header-font')['color']);
    $second_color = esc_attr(\Foodmood_Theme_Helper::get_option('theme-secondary-color'));

    $style_formats = array(
        array(
            'title' => esc_html__( 'Dropcap', 'foodmood' ),
            'items' => array(
                array(
                    'title' => esc_html__( 'Dropcap', 'foodmood' ),
                    'inline' => 'span',
                    'classes' => 'dropcap',
                    'styles' => array( 'background-color' => esc_attr( Foodmood_Theme_Helper::get_option('theme-custom-color') )),
                ),
                array(
                    'title' => esc_html__( 'Dropcap with dark background', 'foodmood' ),
                    'inline' => 'span',
                    'classes' => 'dropcap-bg',
                    'styles' => array( 'background-color' => esc_attr( $second_color )),
                ),
            ),
        ),
        array(
            'title' => esc_html__( 'Highlighter', 'foodmood' ),
            'inline' => 'span',
            'classes' => 'highlighter',
            'styles' => array( 'color' => '#ffffff', 'background-color' => esc_attr( Foodmood_Theme_Helper::get_option('theme-custom-color') )),
        ),
        array(
            'title' => esc_html__( 'Additional Font', 'foodmood' ),
            'inline' => 'span',
            'classes' => 'additional_font',
        ),
        array(
            'title' => esc_html__( 'Font Weight', 'foodmood' ),
            'items' => array(
                array( 'title' => esc_html__( 'Default', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => 'inherit' ) ),
                array( 'title' => esc_html__( 'Lightest (100)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '100' ) ),
                array( 'title' => esc_html__( 'Lighter (200)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '200' ) ),
                array( 'title' => esc_html__( 'Light (300)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '300' ) ),
                array( 'title' => esc_html__( 'Normal (400)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '400' ) ),
                array( 'title' => esc_html__( 'Medium (500)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '500' ) ),
                array( 'title' => esc_html__( 'Semi-Bold (600)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '600' ) ),
                array( 'title' => esc_html__( 'Bold (700)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '700' ) ),
                array( 'title' => esc_html__( 'Bolder (800)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '800' ) ),
                array( 'title' => esc_html__( 'Extra Bold (900)', 'foodmood' ), 'inline' => 'span', 'classes' => '', 'styles' => array( 'font-weight' => '900' ) ),
            )
        ),
        array(
            'title' => esc_html__( 'List Style', 'foodmood' ),
            'items' => array(
                array( 'title' => esc_html__( 'Check', 'foodmood' ), 'selector' => 'ul', 'classes' => 'foodmood_check' ),
                array( 'title' => esc_html__( 'Plus', 'foodmood' ), 'selector' => 'ul', 'classes' => 'foodmood_plus' ),
                array( 'title' => esc_html__( 'Dash', 'foodmood' ), 'selector' => 'ul', 'classes' => 'foodmood_dash' ),
                array( 'title' => esc_html__( 'Slash', 'foodmood' ), 'selector' => 'ul', 'classes' => 'foodmood_slash' ),
                array( 'title' => esc_html__( 'Theme Style', 'foodmood' ), 'selector' => 'ul', 'classes' => 'foodmood_theme' ),
                array( 'title' => esc_html__( 'No List Style', 'foodmood' ), 'selector' => 'ul', 'classes' => 'no-list-style' ),
            )
        ),
    );

    $settings['style_formats'] = str_replace( '"', "'", json_encode( $style_formats ) );
    $settings['extended_valid_elements'] = 'span[*],a[*],i[*]';
    return $settings;
}
add_filter( 'tiny_mce_before_init', 'foodmood_tiny_mce_before_init' );

function foodmood_theme_add_editor_styles() {
    add_editor_style( 'css/font-awesome.min.css' );
}
add_action( 'current_screen', 'foodmood_theme_add_editor_styles' );

function foodmood_categories_postcount_filter ($variable) {

    if(strpos($variable,'</a> (')){
        $variable = str_replace('</a> (', '</a><span class="post_count">(', $variable);
        $variable = str_replace('</a>&nbsp;(', '</a>&nbsp;<span class="post_count">(', $variable);
        $variable = str_replace(')', ')</span>', $variable);
    }
    else{
        $variable = str_replace('</a> <span class="count">(', '</a><span class="post_count">(', $variable);
        $variable = str_replace(')', ')</span>', $variable);
    }

    $pattern1 = '/cat-item-\d+/';
    preg_match_all( $pattern1, $variable,$matches );
    if(isset($matches[0])){
        foreach ($matches[0] as $key => $value) {
            $int = (int) str_replace('cat-item-','', $value);
            $icon_image_id = get_term_meta ( $int, 'category-icon-image-id', true );
            if(!empty($icon_image_id)){
                $icon_image = wp_get_attachment_image_src ( $icon_image_id, 'full' );
                $icon_image_alt = get_post_meta($icon_image_id, '_wp_attachment_image_alt', true);
                $replacement = '$1<img class="cats_item-image" src="'. esc_url($icon_image[0]) .'" alt="'.(!empty($icon_image_alt) ? esc_attr($icon_image_alt) : '').'"/>';
                $pattern = '/(cat-item-'.$int.'+.*?><a.*?>)/';
                $variable = preg_replace( $pattern, $replacement, $variable );
            }
        }
    }

    return $variable;
}
add_filter('wp_list_categories', 'foodmood_categories_postcount_filter');

add_filter( 'get_archives_link', 'foodmood_render_archive_widgets', 10, 6 );
function foodmood_render_archive_widgets ( $link_html, $url, $text, $format, $before, $after ) {

    $text = wptexturize( $text );
    $url  = esc_url( $url );

    if ( 'link' == $format ) {
        $link_html = "\t<link rel='archives' title='" . esc_attr( $text ) . "' href='$url' />\n";
    } elseif ( 'option' == $format ) {
        $link_html = "\t<option value='$url'>$before $text $after</option>\n";
    } elseif ( 'html' == $format ) {
        $after = str_replace('(', '', $after);
        $after = str_replace(' ', '', $after);
        $after = str_replace('&nbsp;', '', $after);
        $after = str_replace(')', '', $after);

        $after = !empty($after) ? " <span class='post_count'>(".esc_html($after).")</span> " : "";

        $link_html = "<li>".esc_html($before)."<a href='".esc_url($url)."'>".esc_html($text)."</a>".$after."</li>";
    } else { // custom
        $link_html = "\t$before<a href='$url'>$text</a>$after\n";
    }

    return $link_html;
}

// Add image size
if ( function_exists( 'add_image_size' ) ) {
    add_image_size( 'foodmood-840-720',  840, 720, true  );
    add_image_size( 'foodmood-440-440',  440, 440, true  );
    add_image_size( 'foodmood-180-180',  180, 180, true  );
    add_image_size( 'foodmood-120-120',  120, 120, true  );
}

// Include Woocommerce init if plugin is active
if ( class_exists( 'WooCommerce' ) ) {
    require_once( get_theme_file_path ( '/woocommerce/woocommerce-init.php' ) );
}

add_filter('foodmood_enqueue_shortcode_css', 'foodmood_render_css');
function foodmood_render_css($styles){
    global $foodmood_dynamic_css;
    if(! isset($foodmood_dynamic_css['style'])){
        $foodmood_dynamic_css = array();
        $foodmood_dynamic_css['style'] = $styles;
    }else{
        $foodmood_dynamic_css['style'] .= $styles;
    }
}