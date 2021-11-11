<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Foodmood Theme Support
*
*
* @class        Foodmood_Theme_Support
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

if (!class_exists('Foodmood_Theme_Support')) {
    class Foodmood_Theme_Support{

        private static $instance = null;
        public static function get_instance( ) {
            if ( null == self::$instance ) {
                self::$instance = new self( );
            }

            return self::$instance;
        }

        public function __construct () {
            if (function_exists('add_theme_support')) {
                add_theme_support('post-thumbnails', array('post', 'page', 'port', 'team', 'testimonials', 'product', 'gallery'));
                add_theme_support('automatic-feed-links');
                add_theme_support('revisions');
                add_theme_support('post-formats', array('gallery', 'video', 'quote', 'audio', 'link'));
            }

            //Register Nav Menu
            add_action('init', array($this, 'register_my_menus') );
            //Add translation file
            add_action('init', array($this, 'enqueue_translation_files') );
            //Add widget support
            add_action('widgets_init', array($this, 'sidebar_register') );
        }

        public function register_my_menus(){
            register_nav_menus(
                array(
                    'main_menu' => esc_html__('Main menu', 'foodmood')
                )
            );
        }        

        public function enqueue_translation_files(){
            load_theme_textdomain('foodmood', get_template_directory() . '/languages/');
        }

        public function sidebar_register(){
            // Get List of registered sidebar
            $custom_sidebars = Foodmood_Theme_Helper::get_option('sidebars');
            $pimpa = '<div class="widget-title_pimp"><svg viewBox="0 0 8 7.9" style="enable-background:new 0 0 8 7.9;" xml:space="preserve"><path d="M7.9,2.8C6.9-0.7,1.3-1,0.1,2.5c-0.4,1.1,1.2,1.7,1.8,0.8C2.5,2.2,5,2.1,5.5,3.4C6.2,5.2,3.2,6,2,5.4C1.4,5,0.5,5.8,1,6.4 C3.3,9.9,8.9,6.6,7.9,2.8z"/></svg></div>';


            // Default wrapper for widget and title
            $wrapper_before = '<div id="%1$s" class="widget foodmood_widget %2$s">';
            $wrapper_after = '</div>';
            $title_before = '<div class="widget-title"><span class="widget-title_wrapper"><span class="widget-title_inner">'.$pimpa;
            $title_after = $pimpa.'</span></span></div>';

            // Register custom sidebars
            if (!empty($custom_sidebars)) {
                foreach($custom_sidebars as $single){  
                    register_sidebar( array(  
                        'name' => esc_attr($single),
                        'id' => "sidebar_".esc_attr(strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $single)))),
                        'description' => esc_html__('Add widget here to appear it in custom sidebar.', 'foodmood'),
                        'before_widget' => $wrapper_before,  
                        'after_widget' => $wrapper_after,
                        'before_title' => $title_before,
                        'after_title' => $title_after,
                    ));  
                }
            }

            // Register Footer Sidebar
            $footer_columns = array(
                array(
                    'name' => esc_html__( 'Footer Column 1', 'foodmood' ),
                    'id' => 'footer_column_1'
                ),
                array(
                    'name' => esc_html__( 'Footer Column 2', 'foodmood' ),
                    'id' => 'footer_column_2'
                ),
                array(
                    'name' => esc_html__( 'Footer Column 3', 'foodmood' ),
                    'id' => 'footer_column_3'
                ),
                array(
                    'name' => esc_html__( 'Footer Column 4', 'foodmood' ),
                    'id' => 'footer_column_4'
                ),
            );
            
            foreach ($footer_columns as $key => $footer_column) {
                register_sidebar( array(
                    'name'          => $footer_column['name'],
                    'id'            => $footer_column['id'],
                    'description' => esc_html__('This area will display in footer like a column. Add widget here to appear it in footer column.', 'foodmood'),
                    'before_widget' => $wrapper_before,  
                    'after_widget' => $wrapper_after,
                    'before_title' => $title_before,
                    'after_title' => $title_after,
                ));
            }
            if (class_exists( 'WooCommerce' )){
                $shop_sidebars = array(
                    array(
                        'name' => esc_html__( 'Shop Products', 'foodmood' ),
                        'id' => 'shop_products'
                    ),
                    array(
                        'name' => esc_html__( 'Shop Single', 'foodmood' ),
                        'id' => 'shop_single'
                    ),                    
                    array(
                        'name' => esc_html__( 'Shop Filter', 'foodmood' ),
                        'id' => 'shop_filter'
                    )
                );
                foreach ($shop_sidebars as $key => $shop_sidebar) {
                    register_sidebar( array(
                        'name'          => $shop_sidebar['name'],
                        'id'            => $shop_sidebar['id'],
                        'description' => esc_html__('This sidebar will display in WooCommerce Pages.', 'foodmood'),
                        'before_widget' => $wrapper_before,  
                        'after_widget' => $wrapper_after,
                        'before_title' => $title_before,
                        'after_title' => $title_after,
                    ));
                }
            }

            register_sidebar( array(
                'name'          => esc_html__( 'Side Panel', 'foodmood' ),
                'id'            => 'side_panel',
                'before_widget' => $wrapper_before,  
                'after_widget' => $wrapper_after,
                'before_title' => $title_before,
                'after_title' => $title_after,
            ));
        }
    }
    new Foodmood_Theme_Support();
}

?>