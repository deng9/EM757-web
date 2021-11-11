<?php

    if ( !class_exists( 'Foodmood_Core' ) ) { return; }

    if (!function_exists('wgl_get_redux_icons')) {
        function wgl_get_redux_icons(){
            return WglAdminIcon()->get_icons_name( true );
        }

        add_filter('redux/font-icons', 'wgl_get_redux_icons');
    }

    if (!function_exists('foodmood_get_preset')) {
        function foodmood_get_preset() {
            $custom_preset = get_option('foodmood_set_preset');
            $presets = function_exists('foodmood_default_preset') ? foodmood_default_preset() : '';

            $out = array();
            $i = 1;
            if(is_array($presets)){
                foreach ($presets as $key => $value) {
                    if($key != 'img'){
                        $out[$key] = $key;
                        $i++;
                    }
                }
            }
            if(is_array($custom_preset)){
                foreach ( $custom_preset as $preset_id => $preset) :
                    if($preset_id != 'default' && $preset_id != 'img'){
                        $out[$preset_id] = $preset_id;
                    }
                endforeach;
            }
            return $out;
        }
    }

    // This is theme option name where all the Redux data is stored.
    $theme_slug = 'foodmood_set';

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */
    $theme = wp_get_theme();

    $args = array(
        'opt_name'             => $theme_slug,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => esc_html__( 'Theme Options', 'foodmood' ),
        'page_title'           => esc_html__( 'Theme Options', 'foodmood' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => true,
         // Show the panel pages on the admin bar
        'admin_bar'            => true,
        'admin_bar_icon'       => 'dashicons-admin-generic',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
        // Show the time the page took to load, etc
        'update_notice'        => true,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_priority'        => 3,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'wgl-dashboard-panel',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => 'dashicons-admin-generic',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => 'wgl-theme-options-panel',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true,
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false,
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
        'show_import_export'   => true,
         // Shows the Import/Export panel when not used as a field.
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
    );


    Redux::setArgs( $theme_slug, $args );

    // -> START Basic Fields
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'General', 'foodmood' ),
        'id'               => 'general',
        'icon'             => 'el el-cog',
        'fields'           => array(
            array(
                'id'       => 'use_minify',
                'type'     => 'switch',
                'title'    => esc_html__( 'Use minify css/js files', 'foodmood' ),
                'desc'     => esc_html__( 'Recommended for site load speed.', 'foodmood' ),
            ),
            array(
                'id'       => 'preloder_settings',
                'type'     => 'section',
                'title'    => esc_html__( 'Preloader Settings', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'preloader',
                'type'     => 'switch',
                'title'    => esc_html__( 'Preloader On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'preloader_background',
                'type'     => 'color',
                'title'    => esc_html__( 'Preloader Background', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Preloader Background', 'foodmood' ),
                'default'  => '#ffffff',
                'transparent' => false,
                'required' => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader_color_1',
                'type'     => 'color',
                'title'    => esc_html__( 'Preloader Color', 'foodmood' ),
                'default'  => '#f57479',
                'transparent' => false,
                'required' => array( 'preloader', '=', '1' ),
            ),
            array(
                'id'       => 'preloader_settings-end',
                'type'     => 'section',
                'indent'   => false,
            ),
            array(
                'id'       => 'search_settings',
                'type'     => 'section',
                'title'    => esc_html__( 'Search Settings', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'search_style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Choose your search style.', 'foodmood' ),
                'options'  => array(
                    'standard' => esc_html__( 'Standard', 'foodmood' ),
                    'alt' => esc_html__( 'Alternative', 'foodmood' ),
                ),
                'default'  => 'standard'
            ),
             array(
                'id'       => 'search_settings-end',
                'type'     => 'section',
                'indent'   => false,
            ),
            array(
                'id'       => 'scroll_up_settings',
                'type'     => 'section',
                'title'    => esc_html__( 'Scroll Up Button Settings', 'foodmood' ),
                'indent'   => true,
            ),
			array(
				'id'       => 'scroll_up',
				'type'     => 'switch',
				'title'    => esc_html__( 'Button On/Off', 'foodmood' ),
				'default'  => true,
			),
			array(
				'id'       => 'scroll_up_arrow_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Button Arrow Color', 'foodmood' ),
				'default'  => '#ffffff',
				'transparent' => false,
				'required' => array( 'scroll_up', '=', '1' ),
			),
			array(
				'id'       => 'scroll_up_bg_color',
				'type'     => 'color',
				'title'    => esc_html__( 'Button Background Color', 'foodmood' ),
				'default'  => '#f7b035',
				'transparent' => false,
				'required' => array( 'scroll_up', '=', '1' ),
			),
			array(
				'id'       => 'scroll_up_settings-end',
				'type'     => 'section',
				'indent'   => false,
			),
		),
	));

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Custom JS', 'foodmood' ),
        'id'               => 'editors-option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'custom_js',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom JS', 'foodmood' ),
                'subtitle' => esc_html__( 'Paste your JS code here.', 'foodmood' ),
                'mode'     => 'javascript',
                'theme'    => 'chrome',
                'default'  => ''
            ),
            array(
                'id'       => 'header_custom_js',
                'type'     => 'ace_editor',
                'title'    => esc_html__( 'Custom JS', 'foodmood' ),
                'subtitle' => esc_html__( 'Code to be added inside HEAD tag', 'foodmood' ),
                'mode'     => 'html',
                'theme'    => 'chrome',
                'default'  => ''
            ),
        ),
    ) );

    // -> START Basic Fields
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Header', 'foodmood' ),
        'id'               => 'header_section',
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Logo', 'foodmood' ),
        'id'               => 'logo',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'header_logo',
                'type'     => 'media',
                'title'    => esc_html__( 'Header Logo', 'foodmood' ),
            ),
            array(
                'id'       => 'logo_height_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Logo Height', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'logo_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Set Logo Height' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array( 'logo_height_custom', '=', '1' ),
            ),
            array(
                'id'       => 'logo_sticky',
                'type'     => 'media',
                'title'    => esc_html__( 'Sticky Logo', 'foodmood' ),
            ),
            array(
                'id'       => 'sticky_logo_height_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Sticky Logo Height', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'sticky_logo_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Set Sticky Logo Height' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => '' ),
                'required' => array(
                    array( 'sticky_logo_height_custom', '=', '1' ),
                ),
            ),
            array(
                'id'      => 'logo_mobile',
                'type'    => 'media',
                'title'   => esc_html__( 'Mobile Logo', 'foodmood' ),
            ),
            array(
                'id'      => 'mobile_logo_height_custom',
                'type'    => 'switch',
                'title'   => esc_html__( 'Enable Mobile Logo Height', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'             => 'mobile_logo_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Set Mobile Logo Height' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => '' ),
                'required' => array(
                    array( 'mobile_logo_height_custom', '=', '1' ),
                ),
            ),
            array(
                'id'      => 'logo_mobile_menu',
                'type'    => 'media',
                'title'   => esc_html__( 'Mobile Menu Logo', 'foodmood' ),
            ),
            array(
                'id'      => 'mobile_logo_menu_height_custom',
                'type'    => 'switch',
                'title'   => esc_html__( 'Enable Mobile Menu Logo Height', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'             => 'mobile_logo_menu_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Set Mobile Menu Logo Height' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => '' ),
                'required' => array(
                    array( 'mobile_logo_menu_height_custom', '=', '1' ),
                ),
            ),
        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Header Builder', 'foodmood' ),
        'id'               => 'header-customize',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id' => 'header_switch',
                'title' => esc_html__('Header', 'foodmood'),
                'type' => 'switch',
                'on' => esc_html__('Use', 'foodmood'),
                'off' => esc_html__('Disable', 'foodmood'),
                'default' => true,
            ),
            array(
                'id'       => 'header_def_js_preset',
                'type'     => 'select',
                'title'    => esc_html__( 'Header default preset', 'foodmood' ),
                'default'  => '',
                'select2'  => array('allowClear' => false),
                'options'  => foodmood_get_preset(),
                'desc'     => esc_html__( 'Please choose preset to use this in all Pages.
                    You also can choose for every page your custom header present in page\'s option select(page metabox).', 'foodmood' ),
            ),
            array(
                'id'       => 'opt-js-preset',
                'type'     => 'custom_preset',
                'title'    => esc_html__( 'Custom Preset', 'foodmood' ),
            ),
            array(
                'id'       => 'bottom_header_layout',
                'type'     => 'custom_header_builder',
                'title'    => esc_html__( 'Header Builder', 'foodmood' ),
                'compiler' => 'true',
                'full_width' => true,
                'options'  => array(
                    'items' => array(
                        'html1' => array( 'title' => esc_html__( 'HTML 1', 'foodmood' ), 'settings' => true) ,
                        'html2' => array( 'title' => esc_html__( 'HTML 2', 'foodmood' ), 'settings' => true) ,
                        'html3' => array( 'title' => esc_html__( 'HTML 3', 'foodmood' ), 'settings' => true) ,
                        'html4' => array( 'title' => esc_html__( 'HTML 4', 'foodmood' ), 'settings' => true) ,
                        'html5' => array( 'title' => esc_html__( 'HTML 5', 'foodmood' ), 'settings' => true) ,
                        'html6' => array( 'title' => esc_html__( 'HTML 6', 'foodmood' ), 'settings' => true) ,
                        'html7' => array( 'title' => esc_html__( 'HTML 7', 'foodmood' ), 'settings' => true) ,
                        'html8' => array( 'title' => esc_html__( 'HTML 8', 'foodmood' ), 'settings' => true) ,
                        'wpml'  => array( 'title' => esc_html__( 'WPML', 'foodmood' ), 'settings' => false) ,
                        'delimiter1'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter2'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter3'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter4'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter5'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter6'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'spacer3'  =>  array( 'title' => esc_html__( 'Spacer 3', 'foodmood' ), 'settings' => true) ,
                        'spacer4'  =>  array( 'title' => esc_html__( 'Spacer 4', 'foodmood' ), 'settings' => true) ,
                        'spacer5'  =>  array( 'title' => esc_html__( 'Spacer 5', 'foodmood' ), 'settings' => true) ,
                        'spacer6'  =>  array( 'title' => esc_html__( 'Spacer 6', 'foodmood' ), 'settings' => true) ,
                        'spacer7'  =>  array( 'title' => esc_html__( 'Spacer 7', 'foodmood' ), 'settings' => true) ,
                        'spacer8'  =>  array( 'title' => esc_html__( 'Spacer 8', 'foodmood' ), 'settings' => true) ,
                        'button1'  =>  array( 'title' => esc_html__( 'Button', 'foodmood' ), 'settings' => true) ,
                        'button2'  =>  array( 'title' => esc_html__( 'Button', 'foodmood' ), 'settings' => true) ,
                        'cart'     =>  array( 'title' => esc_html__( 'Cart', 'foodmood' ), 'settings' => false) ,
                        'login'     =>  array( 'title' => esc_html__( 'Login', 'foodmood' ), 'settings' => false) ,
                        'wishlist'     =>  array( 'title' => esc_html__( 'Wishlist', 'foodmood' ), 'settings' => false) ,
                        'spacer2'  =>  array( 'title' => esc_html__( 'Spacer 2', 'foodmood' ), 'settings' => true) ,
                        'spacer1'  =>  array( 'title' => esc_html__( 'Spacer 1', 'foodmood' ), 'settings' => true) ,
                        'side_panel' => array( 'title' => esc_html__( 'Side Panel', 'foodmood' ), 'settings' => true) ,
                    ),
                    'Top Left area'   => array(),
                    'Top Center area' => array(),
                    'Top Right area'  => array(),
                    'Middle Left area' => array(
                        'logo' => array( 'title' => esc_html__( 'Logo', 'foodmood' ), 'settings' => false),
                    ),
                    'Middle Center area' => array(
                        'menu' => array( 'title' => esc_html__( 'Menu', 'foodmood' ), 'settings' => false),
                    ),
                    'Middle Right area'  => array(
                        'item_search'  =>  array( 'title' => esc_html__( 'Search', 'foodmood' ), 'settings' => false) ,

                    ),
                    'Bottom Left  area'  => array(),
                    'Bottom Center area' => array(),
                    'Bottom Right area'  => array(),
                ),
                'default' => array(
                    'items' => array(
                        'html1' => array( 'title' => esc_html__( 'HTML 1', 'foodmood' ), 'settings' => true) ,
                        'html2' => array( 'title' => esc_html__( 'HTML 2', 'foodmood' ), 'settings' => true) ,
                        'html3' => array( 'title' => esc_html__( 'HTML 3', 'foodmood' ), 'settings' => true) ,
                        'html4' => array( 'title' => esc_html__( 'HTML 4', 'foodmood' ), 'settings' => true) ,
                        'html5' => array( 'title' => esc_html__( 'HTML 5', 'foodmood' ), 'settings' => true) ,
                        'html6' => array( 'title' => esc_html__( 'HTML 6', 'foodmood' ), 'settings' => true) ,
                        'html7' => array( 'title' => esc_html__( 'HTML 7', 'foodmood' ), 'settings' => true) ,
                        'html8' => array( 'title' => esc_html__( 'HTML 8', 'foodmood' ), 'settings' => true) ,
                        'wpml'  => array( 'title' => esc_html__( 'WPML', 'foodmood' ), 'settings' => false) ,
                        'delimiter1'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter2'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter3'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter4'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter5'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'delimiter6'  =>  array( 'title' => esc_html__( '|', 'foodmood' ), 'settings' => true) ,
                        'spacer3'  =>  array( 'title' => esc_html__( 'Spacer 3', 'foodmood' ), 'settings' => true) ,
                        'spacer4'  =>  array( 'title' => esc_html__( 'Spacer 4', 'foodmood' ), 'settings' => true) ,
                        'spacer5'  =>  array( 'title' => esc_html__( 'Spacer 5', 'foodmood' ), 'settings' => true) ,
                        'spacer6'  =>  array( 'title' => esc_html__( 'Spacer 6', 'foodmood' ), 'settings' => true) ,
                        'spacer7'  =>  array( 'title' => esc_html__( 'Spacer 7', 'foodmood' ), 'settings' => true) ,
                        'spacer8'  =>  array( 'title' => esc_html__( 'Spacer 8', 'foodmood' ), 'settings' => true) ,
                        'button1'  =>  array( 'title' => esc_html__( 'Button', 'foodmood' ), 'settings' => true) ,
                        'button2'  =>  array( 'title' => esc_html__( 'Button', 'foodmood' ), 'settings' => true) ,
                        'cart'     =>  array( 'title' => esc_html__( 'Cart', 'foodmood' ), 'settings' => false) ,
                        'login'     =>  array( 'title' => esc_html__( 'Login', 'foodmood' ), 'settings' => false) ,
                        'wishlist'     =>  array( 'title' => esc_html__( 'Wishlist', 'foodmood' ), 'settings' => false) ,
                        'spacer2'  =>  array( 'title' => esc_html__( 'Spacer 2', 'foodmood' ), 'settings' => true) ,
                        'spacer1'  =>  array( 'title' => esc_html__( 'Spacer 1', 'foodmood' ), 'settings' => true) ,
                        'side_panel' => array( 'title' => esc_html__( 'Side Panel', 'foodmood' ), 'settings' => true) ,
                    ),
                    'Top Left area' => array(),
                    'Top Center area' => array(),
                    'Top Right  area' => array(),
                    'Middle Left  area' => array(
                        'logo' => array( 'title' => esc_html__( 'Logo', 'foodmood' ), 'settings' => false),
                    ),
                    'Middle Center  area' => array(
                        'menu' => array( 'title' => esc_html__( 'Menu', 'foodmood' ), 'settings' => false),
                    ),
                    'Middle Right  area' => array(
                        'item_search'  =>  array( 'title' => esc_html__( 'Search', 'foodmood' ), 'settings' => false) ,
                    ),
                    'Bottom Left area' => array(),
                    'Bottom Center area' => array(),
                    'Bottom Right area' => array(),
                ),
            ),
            array(
                'id'             => 'bottom_header_spacer1',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 1 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 50 )
            ),
            array(
                'id'             => 'bottom_header_spacer2',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 2 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 50 )
            ),
            array(
                'id'             => 'bottom_header_spacer3',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 3 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 )
            ),
            array(
                'id'             => 'bottom_header_spacer4',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 4 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 )
            ),
            array(
                'id'             => 'bottom_header_spacer5',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 5 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 )
            ),
            array(
                'id'             => 'bottom_header_spacer6',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 6 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 )
            ),
            array(
                'id'             => 'bottom_header_spacer7',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 7 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 )
            ),
            array(
                'id'             => 'bottom_header_spacer8',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Spacer 8 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 )
            ),
            array(
                'id'             => 'bottom_header_delimiter1_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 )
            ),
            array(
                'id'             => 'bottom_header_delimiter1_width',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 1 )
            ),
            array(
                'id'       => 'bottom_header_delimiter1_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_delimiter1_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => false,
                'left'     => true,
                'right'    => true,
                'title'    => esc_html__( 'Delimiter Spacing', 'foodmood' ),
                'default'  => array(
                    'margin-left' => '30',
                    'margin-right' => '30',
                )
            ),
            array(
                'id'      => 'bottom_header_delimiter1_sticky_custom',
                'type'    => 'switch',
                'title'   => esc_html__( 'Customize Sticky Delimiter', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'       => 'bottom_header_delimiter1_sticky_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_delimiter1_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter1_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array(
                    array( 'bottom_header_delimiter1_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter2_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 )
            ),
            array(
                'id'             => 'bottom_header_delimiter2_width',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 1 )
            ),
            array(
                'id'       => 'bottom_header_delimiter2_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_delimiter2_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => false,
                'left'     => true,
                'right'    => true,
                'title'    => esc_html__( 'Delimiter Spacing', 'foodmood' ),
                'default'  => array(
                    'margin-left' => '30',
                    'margin-right' => '30',
                )
            ),
            array(
                'id'       => 'bottom_header_delimiter2_sticky_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Delimiter', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_delimiter2_sticky_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_delimiter2_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter2_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array(
                    array( 'bottom_header_delimiter2_sticky_custom', '=', '1' ),
                ),
            ),

            array(
                'id'             => 'bottom_header_delimiter3_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 )
            ),
            array(
                'id'             => 'bottom_header_delimiter3_width',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 1 )
            ),
            array(
                'id'       => 'bottom_header_delimiter3_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_delimiter3_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => false,
                'left'     => true,
                'right'    => true,
                'title'    => esc_html__( 'Delimiter Spacing', 'foodmood' ),
                'default'  => array(
                    'margin-left' => '30',
                    'margin-right' => '30',
                )
            ),
            array(
                'id'       => 'bottom_header_delimiter3_sticky_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Delimiter', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_delimiter3_sticky_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_delimiter3_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter3_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array(
                    array( 'bottom_header_delimiter3_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter4_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 )
            ),
            array(
                'id'             => 'bottom_header_delimiter4_width',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 1 )
            ),
            array(
                'id'       => 'bottom_header_delimiter4_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_delimiter4_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => false,
                'left'     => true,
                'right'    => true,
                'title'    => esc_html__( 'Delimiter Spacing', 'foodmood' ),
                'default'  => array(
                    'margin-left' => '30',
                    'margin-right' => '30',
                )
            ),
            array(
                'id'       => 'bottom_header_delimiter4_sticky_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Delimiter', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_delimiter4_sticky_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_delimiter4_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter4_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array(
                    array( 'bottom_header_delimiter4_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter5_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 )
            ),
            array(
                'id'             => 'bottom_header_delimiter5_width',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 1 )
            ),
            array(
                'id'       => 'bottom_header_delimiter5_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_delimiter5_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => false,
                'left'     => true,
                'right'    => true,
                'title'    => esc_html__( 'Delimiter Spacing', 'foodmood' ),
                'default'  => array(
                    'margin-left' => '30',
                    'margin-right' => '30',
                )
            ),
            array(
                'id'       => 'bottom_header_delimiter5_sticky_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Delimiter', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_delimiter5_sticky_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_delimiter5_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter5_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array(
                    array( 'bottom_header_delimiter5_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'             => 'bottom_header_delimiter6_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 )
            ),
            array(
                'id'             => 'bottom_header_delimiter6_width',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 1 )
            ),
            array(
                'id'       => 'bottom_header_delimiter6_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_delimiter6_margin',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => false,
                'left'     => true,
                'right'    => true,
                'title'    => esc_html__( 'Delimiter Spacing', 'foodmood' ),
                'default'  => array(
                    'margin-left' => '30',
                    'margin-right' => '30',
                )
            ),
            array(
                'id'       => 'bottom_header_delimiter6_sticky_custom',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Delimiter', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_delimiter6_sticky_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Delimiter Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_delimiter6_sticky_custom', '=', '1' ),
            ),
            array(
                'id'             => 'bottom_header_delimiter6_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Delimiter Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 100 ),
                'required' => array(
                    array( 'bottom_header_delimiter6_sticky_custom', '=', '1' ),
                ),
            ),
            array(
                'id'      => 'bottom_header_button1_title',
                'type'    => 'text',
                'title'   => esc_html__( 'Button Text', 'foodmood' ),
                'default' => esc_html__( 'Get Ticket', 'foodmood' ),
            ),
            array(
                'id'      => 'bottom_header_button1_link',
                'type'    => 'text',
                'title'   => esc_html__( 'Link', 'foodmood' )
            ),
            array(
                'id'      => 'bottom_header_button1_target',
                'type'    => 'switch',
                'title'   => esc_html__( 'Open link in a new tab', 'foodmood' ),
                'default' => true,
            ),
            array(
                'id'      => 'bottom_header_button1_size',
                'type'    => 'select',
                'title'   => esc_html__( 'Button Size', 'foodmood' ),
                'options' => array(
                    's' => esc_html__( 'Small', 'foodmood' ),
                    'm' => esc_html__( 'Medium', 'foodmood' ),
                    'l' => esc_html__( 'Large', 'foodmood' ),
                    'xl' => esc_html__( 'Extra Large', 'foodmood' ),

                ),
                'default' => 's'
            ),
            array(
                'id'      => 'bottom_header_button1_radius',
                'type'    => 'text',
                'title'   => esc_html__( 'Button Border Radius', 'foodmood' ),
                'default' => '20',
                'desc'     => esc_html__( 'Value in pixels.', 'foodmood' ),
            ),
            array(
                'id'      => 'bottom_header_button1_custom',
                'type'    => 'switch',
                'title'   => esc_html__( 'Customize Button', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'      => 'bottom_header_button1_color_txt',
                'type'    => 'color_rgba',
                'title'   => esc_html__( 'Text Color', 'foodmood' ),
                'default' => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_hover_color_txt',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Hover Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_hover_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Hover Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_border',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_hover_border',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Hover Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_custom_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Button', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_button1_color_txt_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_hover_color_txt_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Hover Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_bg_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_hover_bg_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Hover Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_border_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button1_hover_border_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Hover Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button1_custom_sticky', '=', '1' ),
            ),
            array(
                'id'      => 'bottom_header_button2_title',
                'type'    => 'text',
                'title'   => esc_html__( 'Button Text', 'foodmood' ),
                'default' => esc_html__( 'Get Ticket', 'foodmood' ),
            ),
            array(
                'id'      => 'bottom_header_button2_link',
                'type'    => 'text',
                'title'   => esc_html__( 'Link', 'foodmood' )
            ),
            array(
                'id'      => 'bottom_header_button2_target',
                'type'    => 'switch',
                'title'   => esc_html__( 'Open link in a new tab', 'foodmood' ),
                'default' => true,
            ),
            array(
                'id'      => 'bottom_header_button2_size',
                'type'    => 'select',
                'title'   => esc_html__( 'Button Size', 'foodmood' ),
                'options' => array(
                    's' => esc_html__( 'Small', 'foodmood' ),
                    'm' => esc_html__( 'Medium', 'foodmood' ),
                    'l' => esc_html__( 'Large', 'foodmood' ),
                    'xl' => esc_html__( 'Extra Large', 'foodmood' ),
                ),
                'default'  => 'm'
            ),
            array(
                'id'      => 'bottom_header_button2_radius',
                'type'    => 'text',
                'title'   => esc_html__( 'Button Border Radius', 'foodmood' ),
                'default' => '20',
                'desc'     => esc_html__( 'Value in pixels.', 'foodmood' ),
            ),
            array(
                'id'      => 'bottom_header_button2_custom',
                'type'    => 'switch',
                'title'   => esc_html__( 'Customize Button', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'      => 'bottom_header_button2_color_txt',
                'type'    => 'color_rgba',
                'title'   => esc_html__( 'Text Color', 'foodmood' ),
                'default' => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_hover_color_txt',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Hover Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_hover_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Hover Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_border',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_hover_border',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Hover Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_custom_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Customize Sticky Button', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'bottom_header_button2_color_txt_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_hover_color_txt_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Hover Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_bg_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_hover_bg_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Hover Background Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_border_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'bottom_header_button2_hover_border_sticky',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Hover Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'bottom_header_button2_custom_sticky', '=', '1' ),
            ),
            array(
                'id'      => 'bottom_header_bar_html1_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 1 Editor', 'foodmood' ),
                'default' => '',
            ),
            array(
                'id'      => 'bottom_header_bar_html2_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 2 Editor', 'foodmood' ),
                'default' => '',
            ),
            array(
                'id'      => 'bottom_header_bar_html3_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 3 Editor', 'foodmood' ),
                'default' => '',
            ),
            array(
                'id'      => 'bottom_header_bar_html4_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 4 Editor', 'foodmood' ),
                'default' => '',
            ),            array(
                'id'      => 'bottom_header_bar_html5_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 5 Editor', 'foodmood' ),
                'default' => '',
            ),
            array(
                'id'      => 'bottom_header_bar_html6_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 6 Editor', 'foodmood' ),
                'default' => '',
            ),
            array(
                'id'      => 'bottom_header_bar_html7_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 7 Editor', 'foodmood' ),
                'default' => '',
            ),
            array(
                'id'      => 'bottom_header_bar_html8_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 8 Editor', 'foodmood' ),
                'default' => '',
            ),

            array(
                'id'      => 'bottom_header_side_panel_color',
                'type'    => 'color_rgba',
                'title'   => esc_html__( 'Icon Color', 'foodmood' ),
                'default' => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'bottom_header_side_panel_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background Icon', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'      => 'bottom_header_side_panel_sticky_custom',
                'type'    => 'switch',
                'title'   => esc_html__( 'Customize Sticky Icon', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'      => 'bottom_header_side_panel_sticky_color',
                'type'    => 'color_rgba',
                'title'   => esc_html__( 'Icon Color', 'foodmood' ),
                'default' => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_side_panel_sticky_custom', '=', '1' )
                ),
            ),
            array(
                'id'       => 'bottom_header_side_panel_sticky_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background Icon', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'bottom_header_side_panel_sticky_custom', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_top-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header Top Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_top_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width Top Header', 'foodmood' ),
                'subtitle' => esc_html__( 'Set header content in full width top layout', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'header_top_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Top Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 40 )
            ),
            array(
                'id'       => 'header_top_background_image',
                'type'     => 'media',
                'title'    => esc_html__( 'Header Top Background Image', 'foodmood' ),
            ),
            array(
                'id'       => 'header_top_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Top Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_top_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Top Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Top header text color', 'foodmood' ),
                'default'  => array(
                    'color' => '#fefefe',
                    'alpha' => '.5',
                    'rgba'  => 'rgba(254,254,254,0.5)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_top_secondary_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Top Secondary Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Top header secondary color', 'foodmood' ),
                'default'  => array(
                    'color' => '#f7b035',
                    'alpha' => '1',
                    'rgba'  => 'rgba(247,176,53,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_top_bottom_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Set Header Top Bottom Border', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'             => 'header_top_border_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Top Border Width' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => '1',
                ),
                'required' => array(
                    array( 'header_top_bottom_border', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_top_bottom_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Top Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,0.2)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'header_top_bottom_border', '=', '1' ),
                ),
            ),
            array(
                'id'     => 'header_top-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_middle-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header Middle Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_middle_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width Middle Header', 'foodmood' ),
                'subtitle' => esc_html__( 'Set header content in full width middle layout', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'             => 'header_middle_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Middle Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => 123,
                )
            ),
            array(
                'id'       => 'header_middle_background_image',
                'type'     => 'media',
                'title'    => esc_html__( 'Header Middle Background Image', 'foodmood' ),
            ),
            array(
                'id'       => 'header_middle_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Middle Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_middle_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Middle Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Middle header text color', 'foodmood' ),
                'default'  => array(
                    'color' => '#232323',
                    'alpha' => '1',
                    'rgba'  => 'rgba(35,35,35,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_middle_secondary_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Middle Secondary Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Middle header secondary color', 'foodmood' ),
                'default'  => array(
                    'color' => '#f7b035',
                    'alpha' => '1',
                    'rgba'  => 'rgba(247,176,53,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_middle_bottom_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Set Header Middle Bottom Border', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'header_middle_border_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Middle Border Width' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => '1',
                ),
                'required' => array(
                    array( 'header_middle_bottom_border', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_middle_bottom_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Middle Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#f6f7f8',
                    'alpha' => '1',
                    'rgba'  => 'rgba(246,247,248,1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'header_middle_bottom_border', '=', '1' ),
                ),
            ),
            array(
                'id'     => 'header_middle-end',
                'type'   => 'section',
                'indent' => false,
            ),

            array(
                'id'       => 'header_bottom-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header Bottom Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_bottom_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width Bottom Header', 'foodmood' ),
                'subtitle' => esc_html__( 'Set header content in full width bottom layout', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'header_bottom_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Bottom Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => 100,
                )
            ),
            array(
                'id'       => 'header_bottom_background_image',
                'type'     => 'media',
                'title'    => esc_html__( 'Header Bottom Background Image', 'foodmood' ),
            ),
            array(
                'id'       => 'header_bottom_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Bottom Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '.9',
                    'rgba'  => 'rgba(255,255,255,0.9)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_bottom_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Bottom Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Bottom header text color', 'foodmood' ),
                'default'  => array(
                    'color' => '#fefefe',
                    'alpha' => '.5',
                    'rgba'  => 'rgba(254,254,254,0.5)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_bottom_secondary_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Bottom Secondary Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Bottom header secondary color', 'foodmood' ),
                'default'  => array(
                    'color' => '#f7b035',
                    'alpha' => '1',
                    'rgba'  => 'rgba(247,176,53,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'header_bottom_bottom_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Set Header Bottom Border', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'             => 'header_bottom_border_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Header Bottom Border Width' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => '1',
                ),
                'required' => array(
                    array( 'header_bottom_bottom_border', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_bottom_bottom_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Header Bottom Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,0.2)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'header_bottom_bottom_border', '=', '1' ),
                ),
            ),
            array(
                'id'     => 'header_bottom-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-top-left-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top Left Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_top_left_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_top_left_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_top_left_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-top-left-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-top-center-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top Center Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_top_center_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_top_center_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_top_center_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-top-center-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-top-center-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top Center Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_top_center_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_top_center_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_top_center_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-top-center-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-top-right-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Top Right Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_top_right_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'header_column_top_right_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_top_right_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-top-right-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-middle-left-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Middle Left Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_middle_left_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_middle_left_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_middle_left_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-middle-left-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-middle-center-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Middle Center Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_middle_center_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_middle_center_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_middle_center_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-middle-center-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-middle-center-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Middle Center Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_middle_center_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_middle_center_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_middle_center_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-middle-center-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-middle-right-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Middle Right Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_middle_right_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'header_column_middle_right_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_middle_right_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-middle-right-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-bottom-left-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Bottom Left Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_bottom_left_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_bottom_left_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_bottom_left_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-bottom-left-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-bottom-center-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Middle Center Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_bottom_center_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_bottom_center_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_bottom_center_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-bottom-center-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-bottom-center-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Bottom Center Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_bottom_center_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'header_column_bottom_center_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_bottom_center_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-bottom-center-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_column-bottom-right-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Bottom Right Column Options', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_column_bottom_right_horz',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Horizontal Align', 'foodmood' ),
                'options'  => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'header_column_bottom_right_vert',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Vertical Align', 'foodmood' ),
                'options'  => array(
                    'top' => esc_html__( 'Top', 'foodmood' ),
                    'middle' => esc_html__( 'Middle', 'foodmood' ),
                    'bottom' => esc_html__( 'Bottom', 'foodmood' ),
                ),
                'default'  => 'middle'
            ),
            array(
                'id'       => 'header_column_bottom_right_display',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Display', 'foodmood' ),
                'options'  => array(
                    'normal' => esc_html__( 'Normal', 'foodmood' ),
                    'grow' => esc_html__( 'Grow', 'foodmood' ),
                ),
                'default'  => 'normal'
            ),
            array(
                'id'     => 'header_column-bottom-right-end',
                'type'   => 'section',
                'indent' => false,
            ),
            array(
                'id'       => 'header_row_settings-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Header Settings', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'header_shadow',
                'type'     => 'switch',
                'title'    => esc_html__( 'Header Bottom Shadow', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'header_on_bg',
                'type'     => 'switch',
                'title'    => esc_html__( 'Over content', 'foodmood' ),
                'subtitle' => esc_html__( 'Set Header preset to display over content.', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'lavalamp_active',
                'type'     => 'switch',
                'title'    => esc_html__( 'Enable Lavalamp Marker', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'sub_menu_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sub Menu Background', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sub menu background color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'sub_menu_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Sub Menu Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sub menu header text color', 'foodmood' ),
                'default'  => '#232323',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_sub_menu_bottom_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sub Menu Bottom Border', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'header_sub_menu_border_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Sub Menu Border Width' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => '1',
                ),
                'required' => array(
                    array( 'header_sub_menu_bottom_border', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_sub_menu_bottom_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sub Menu Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(0, 0, 0, 0.08)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'header_sub_menu_bottom_border', '=', '1' ),
                ),
            ),
            array(
                'id'        => 'header_mobile_queris',
                'type'      => 'slider',
                'title'     => esc_html__( 'Mobile Header resolution breakpoint', 'foodmood'),
                "default"   => 1420,
                "min"       => 1,
                "step"      => 1,
                "max"       => 1700,
                'display_value' => 'text',
            ),
            array(
                'id'     => 'header_row_settings-end',
                'type'   => 'section',
                'indent' => false,
            ),
        )

    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Header Sticky', 'foodmood' ),
        'id'               => 'header_builder_sticky',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'header_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Header', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'header_sticky-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Sticky Settings', 'foodmood' ),
                'indent'   => true,
                'required' => array( 'header_sticky', '=', '1' ),
            ),
            array(
                'id'       => 'header_sticky_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Sticky Header Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sticky header text color', 'foodmood' ),
                'default'  => '#313131',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_sticky_secondary_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Sticky Header Secondary Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sticky header secondary color', 'foodmood' ),
                'default'  => '#f7b035',
                'transparent' => false,
            ),
            array(
                'id'       => 'header_sticky_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Sticky Header Background', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sticky header background color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1.0',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'             => 'header_sticky_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Sticky Header Height', 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => 100,
                )
            ),
            array(
                'id'       => 'header_sticky_style',
                'type'     => 'select',
                'title'    => esc_html__( 'Choose your sticky style.', 'foodmood' ),
                'options'  => array(
                    'standard' => esc_html__( 'Show when scroll', 'foodmood' ),
                    'scroll_up' => esc_html__( 'Show when scroll up', 'foodmood' ),
                ),
                'default'  => 'standard'
            ),
            array(
                'id'       => 'header_sticky_border',
                'type'     => 'switch',
                'title'    => esc_html__( 'Bottom Border On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'             => 'header_sticky_border_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Bottom Border Width' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => '1',
                ),
                'required' => array(
                    array( 'header_sticky_border', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_sticky_border_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Bottom Border Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#525252',
                    'alpha' => '1',
                    'rgba'  => 'rgba(82, 82, 82, 1)'
                ),
                'mode'     => 'background',
                'required' => array(
                    array( 'header_sticky_border', '=', '1' )
                ),
            ),
            array(
                'id'       => 'header_sticky_shadow',
                'type'     => 'switch',
                'title'    => esc_html__( 'Bottom Shadow On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'sticky_header',
                'type'     => 'switch',
                'title'    => esc_html__( 'Custom Sticky Header ', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'sticky_header_layout',
                'type'     => 'sorter',
                'title'    => esc_html__( 'Sticky Header Order', 'foodmood' ),
                'desc'     => esc_html__( 'Organize the layout of the sticky header', 'foodmood' ),
                'compiler' => 'true',
                'full_width'    => true,
                'options'  => array(
                    'items'  => array(
                        'html1' => esc_html__( 'HTML 1', 'foodmood' ),
                        'html2' => esc_html__( 'HTML 2', 'foodmood' ),
                        'html3' => esc_html__( 'HTML 3', 'foodmood' ),
                        'html4' => esc_html__( 'HTML 4', 'foodmood' ),
                        'html5' => esc_html__( 'HTML 5', 'foodmood' ),
                        'html6' => esc_html__( 'HTML 6', 'foodmood' ),
                        'item_search' => esc_html__( 'Search', 'foodmood' ),
                        'wpml'        => esc_html__( 'WPML', 'foodmood' ),
                        'delimiter1'  => esc_html__( '|', 'foodmood' ),
                        'delimiter2'  => esc_html__( '|', 'foodmood' ),
                        'delimiter3'  => esc_html__( '|', 'foodmood' ),
                        'delimiter4'  => esc_html__( '|', 'foodmood' ),
                        'delimiter5'  => esc_html__( '|', 'foodmood' ),
                        'delimiter6'  => esc_html__( '|', 'foodmood' ),
                        'side_panel'  => esc_html__( 'Side Panel', 'foodmood' ),
                        'cart'        => esc_html__( 'Cart', 'foodmood' ),
                        'login'       => esc_html__( 'Login', 'foodmood' ),
                        'wishlist'    => esc_html__( 'Wishlist', 'foodmood' ),
                        'spacer1' => esc_html__( 'Spacer 1', 'foodmood' ),
                        'spacer2' => esc_html__( 'Spacer 2', 'foodmood' ),
                        'spacer3' => esc_html__( 'Spacer 3', 'foodmood' ),
                        'spacer4' => esc_html__( 'Spacer 4', 'foodmood' ),
                        'spacer5' => esc_html__( 'Spacer 5', 'foodmood' ),
                        'spacer6' => esc_html__( 'Spacer 6', 'foodmood' ),
                    ),
                    'Left align side' => array(
                        'logo' => esc_html__( 'Logo', 'foodmood' ),
                    ),
                    'Center align side' => array(),
                    'Right align side' => array(
                        'menu' => esc_html__( 'Menu', 'foodmood' ),
                    ),
                ),
                'default'  => array(
                    'items'  => array(
                        'html1' => esc_html__( 'HTML 1', 'foodmood' ),
                        'html2' => esc_html__( 'HTML 2', 'foodmood' ),
                        'html3' => esc_html__( 'HTML 3', 'foodmood' ),
                        'html4' => esc_html__( 'HTML 4', 'foodmood' ),
                        'html5' => esc_html__( 'HTML 5', 'foodmood' ),
                        'html6' => esc_html__( 'HTML 6', 'foodmood' ),
                        'item_search' => esc_html__( 'Search', 'foodmood' ),
                        'wpml'        => esc_html__( 'WPML', 'foodmood' ),
                        'delimiter1'  => esc_html__( '|', 'foodmood' ),
                        'delimiter2'  => esc_html__( '|', 'foodmood' ),
                        'delimiter3'  => esc_html__( '|', 'foodmood' ),
                        'delimiter4'  => esc_html__( '|', 'foodmood' ),
                        'delimiter5'  => esc_html__( '|', 'foodmood' ),
                        'delimiter6'  => esc_html__( '|', 'foodmood' ),
                        'spacer1' => esc_html__( 'Spacer 1', 'foodmood' ),
                        'spacer2' => esc_html__( 'Spacer 2', 'foodmood' ),
                        'spacer3' => esc_html__( 'Spacer 3', 'foodmood' ),
                        'spacer4' => esc_html__( 'Spacer 4', 'foodmood' ),
                        'spacer5' => esc_html__( 'Spacer 5', 'foodmood' ),
                        'spacer6' => esc_html__( 'Spacer 6', 'foodmood' ),
                        'side_panel' => esc_html__( 'Side Panel', 'foodmood' ),
                        'cart' => esc_html__( 'Cart', 'foodmood' ),
                        'login' => esc_html__( 'Login', 'foodmood' ),
                        'wishlist' => esc_html__( 'Wishlist', 'foodmood' ),
                    ),
                    'Left align side' => array(
                        'logo' => esc_html__( 'Logo', 'foodmood' ),
                    ),
                    'Center align side' => array(),
                    'Right align side' => array(
                        'menu' => esc_html__( 'Menu', 'foodmood' ),
                    ),
                ),
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'       => 'header_custom_sticky_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width Sticky Header', 'foodmood' ),
                'default'  => false,
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'      => 'sticky_header_bar_html1_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 1 Editor', 'foodmood' ),
                'default' => '',
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'      => 'sticky_header_bar_html2_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 2 Editor', 'foodmood' ),
                'default' => '',
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'      => 'sticky_header_bar_html3_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 3 Editor', 'foodmood' ),
                'default' => '',
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'      => 'sticky_header_bar_html4_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 4 Editor', 'foodmood' ),
                'default' => '',
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'      => 'sticky_header_bar_html5_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 5 Editor', 'foodmood' ),
                'default' => '',
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'      => 'sticky_header_bar_html6_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 6 Editor', 'foodmood' ),
                'default' => '',
                'required' => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'             => 'sticky_header_spacer1',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 1 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 ),
                'required'       => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'             => 'sticky_header_spacer2',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 2 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 ),
                'required'       => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'             => 'sticky_header_spacer3',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 3 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 ),
                'required'       => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'             => 'sticky_header_spacer4',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 4 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 ),
                'required'       => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'             => 'sticky_header_spacer5',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 5 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 ),
                'required'       => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'             => 'sticky_header_spacer6',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 6 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array( 'width' => 25 ),
                'required'       => array( 'sticky_header', '=', '1' ),
            ),
            array(
                'id'     => 'header_sticky-end',
                'type'   => 'section',
                'indent' => false,
                'required' => array( 'header_sticky', '=', '1' ),
            ),
        )
    ) );
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Header Mobile', 'foodmood' ),
        'id'               => 'header_builder_mobile',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'mobile_header',
                'type'     => 'switch',
                'title'    => esc_html__( 'Custom Mobile Header ', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'mobile_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Mobile Header Background', 'foodmood' ),
                'subtitle' => esc_html__( 'Set mobile header background color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49,49,49, 1)'
                ),
                'mode'     => 'background',
                'required' => array( 'mobile_header', '=', '1' ),
            ),
            array(
                'id'       => 'mobile_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Mobile Header Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set mobile header text color', 'foodmood' ),
                'default'  => '#ffffff',
                'transparent' => false,
                'required' => array( 'mobile_header', '=', '1' ),
            ),
            array(
                'id'       => 'mobile_sub_menu_background',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Mobile Sub Menu Background', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sub menu background color', 'foodmood' ),
                'default'  => array(
                    'color' => '#2d2d2d',
                    'alpha' => '1',
                    'rgba'  => 'rgba(45,45,45,1)'
                ),
                'mode'     => 'background',
                'required' => array( 'mobile_header', '=', '1' ),
            ),
            array(
                'id'       => 'mobile_sub_menu_overlay',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Mobile Sub Menu Overlay', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sub menu overlay color', 'foodmood' ),
                'default'  => array(
                    'color' => '#313131',
                    'alpha' => '1',
                    'rgba'  => 'rgba(49, 49, 49, 0.8)'
                ),
                'mode'     => 'background',
                'required' => array( 'mobile_header', '=', '1' ),
            ),
            array(
                'id'       => 'mobile_sub_menu_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Mobile Sub Menu Text Color', 'foodmood' ),
                'subtitle' => esc_html__( 'Set sub menu header text color', 'foodmood' ),
                'default'  => '#ffffff',
                'transparent' => false,
                'required' => array( 'mobile_header', '=', '1' ),
            ),
            array(
                'id'             => 'header_mobile_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Mobile Height' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array(
                    'height' => '100',
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'       => 'mobile_over_content',
                'type'     => 'switch',
                'title'    => esc_html__( 'Mobile Over Content', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'mobile_position',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Mobile Sub Menu Position', 'foodmood' ),
                'options'  => array(
                    'left'  => esc_html__( 'Left', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'mobile_header_layout',
                'type'     => 'sorter',
                'title'    => esc_html__( 'Mobile Header Order', 'foodmood' ),
                'desc'     => esc_html__( 'Organize the layout of the mobile header', 'foodmood' ),
                'compiler' => 'true',
                'full_width' => true,
                'options'  => array(
                    'items'  => array(
                        'html1' => esc_html__( 'HTML 1', 'foodmood' ),
                        'html2' => esc_html__( 'HTML 2', 'foodmood' ),
                        'html3' => esc_html__( 'HTML 3', 'foodmood' ),
                        'html4' => esc_html__( 'HTML 4', 'foodmood' ),
                        'html5' => esc_html__( 'HTML 5', 'foodmood' ),
                        'html6' => esc_html__( 'HTML 6', 'foodmood' ),
                        'wpml'  => esc_html__( 'WPML', 'foodmood' ),
                        'spacer1' => esc_html__( 'Spacer 1', 'foodmood' ),
                        'spacer2' => esc_html__( 'Spacer 2', 'foodmood' ),
                        'spacer3' => esc_html__( 'Spacer 3', 'foodmood' ),
                        'spacer4' => esc_html__( 'Spacer 4', 'foodmood' ),
                        'spacer5' => esc_html__( 'Spacer 5', 'foodmood' ),
                        'spacer6' => esc_html__( 'Spacer 6', 'foodmood' ),
                        'side_panel' =>  esc_html__( 'Side Panel', 'foodmood' ),
                        'cart'        =>  esc_html__( 'Cart', 'foodmood' ),
                        'login'        =>  esc_html__( 'Login', 'foodmood' ),
                        'wishlist'        =>  esc_html__( 'Wishlist', 'foodmood' ),
                    ),
                    'Left align side' => array(
                        'menu' => esc_html__( 'Menu', 'foodmood' ),
                    ),
                    'Center align side' => array(
                        'logo' => esc_html__( 'Logo', 'foodmood' ),
                    ),
                    'Right align side' => array(
                        'item_search'  =>  esc_html__( 'Search', 'foodmood' ),
                    ),
                ),
                'default'  => array(
                    'items'  => array(
                        'html1' => esc_html__( 'HTML 1', 'foodmood' ),
                        'html2' => esc_html__( 'HTML 2', 'foodmood' ),
                        'html3' => esc_html__( 'HTML 3', 'foodmood' ),
                        'html4' => esc_html__( 'HTML 4', 'foodmood' ),
                        'html5' => esc_html__( 'HTML 5', 'foodmood' ),
                        'html6' => esc_html__( 'HTML 6', 'foodmood' ),
                        'wpml'  => esc_html__( 'WPML', 'foodmood' ),
                        'spacer1'  =>  esc_html__( 'Spacer 1', 'foodmood' ),
                        'spacer2'  =>  esc_html__( 'Spacer 2', 'foodmood' ),
                        'spacer3'  =>  esc_html__( 'Spacer 3', 'foodmood' ),
                        'spacer4'  =>  esc_html__( 'Spacer 4', 'foodmood' ),
                        'spacer5'  =>  esc_html__( 'Spacer 5', 'foodmood' ),
                        'spacer6'  =>  esc_html__( 'Spacer 6', 'foodmood' ),
                        'side_panel' =>  esc_html__( 'Side Panel', 'foodmood' ),
                        'cart'       =>  esc_html__( 'Cart', 'foodmood' ),
                        'login'       =>  esc_html__( 'Login', 'foodmood' ),
                        'wishlist'    =>  esc_html__( 'Wishlist', 'foodmood' ),
                    ),
                    'Left align side' => array(
                        'menu' => esc_html__( 'Menu', 'foodmood' ),
                    ),
                    'Center align side' => array(
                        'logo' => esc_html__( 'Logo', 'foodmood' ),
                    ),
                    'Right align side' => array(
                        'item_search'  =>  esc_html__( 'Search', 'foodmood' ),
                    ),
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'      => 'mobile_header_bar_html1_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 1 Editor', 'foodmood' ),
                'default' => '',
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'      => 'mobile_header_bar_html2_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 2 Editor', 'foodmood' ),
                'default' => '',
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'      => 'mobile_header_bar_html3_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 3 Editor', 'foodmood' ),
                'default' => '',
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'      => 'mobile_header_bar_html4_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 4 Editor', 'foodmood' ),
                'default' => '',
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'      => 'mobile_header_bar_html5_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 5 Editor', 'foodmood' ),
                'default' => '',
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'      => 'mobile_header_bar_html6_editor',
                'type'    => 'ace_editor',
                'mode'    => 'html',
                'title'   => esc_html__( 'HTML Element 6 Editor', 'foodmood' ),
                'default' => '',
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'             => 'mobile_header_spacer1',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 1 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array(
                    'width' => 25,
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'             => 'mobile_header_spacer2',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 2 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array(
                    'width' => 25,
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'             => 'mobile_header_spacer3',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 3 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array(
                    'width' => 25,
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'             => 'mobile_header_spacer4',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 4 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array(
                    'width' => 25,
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'             => 'mobile_header_spacer5',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 5 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array(
                    'width' => 25,
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
            array(
                'id'             => 'mobile_header_spacer6',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Spacer 6 Width', 'foodmood' ),
                'height'         => false,
                'width'          => true,
                'default'        => array(
                    'width' => 25,
                ),
                'required' => array(
                    array( 'mobile_header', '=', '1' )
                ),
            ),
        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Page Title', 'foodmood' ),
        'id'               => 'page_title',
    ));

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Settings', 'foodmood' ),
        'id'               => 'page_title_settings',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'page_title_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Page Title Switch', 'foodmood' ),
                'default'  => true,
            ),
			array(
				'id'       => 'page_title-start',
				'type'     => 'section',
				'title'    => esc_html__( 'Page Title Settings', 'foodmood' ),
				'indent'   => true,
				'required' => array( 'page_title_switch', '=', '1' ),
			),
            array(
                'id'       => 'page_title_bg_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Use Background?', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'            => 'page_title_bg_image',
                'type'          => 'background',
                'title'         => esc_html__( 'Background', 'foodmood' ),
                'preview'       => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent'   => false,
                'default'       => array(
                    'background-image'      => '',
                    'background-repeat'     => 'no-repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center bottom',
                    'background-color'      => '#f6f7f8',
                ),
				'required' => array( 'page_title_bg_switch', '=', true ),
            ),
            array(
                'id'      => 'page_title_height',
                'type'    => 'dimensions',
                'units'   => 'px',
                'units_extended' => false,
                'title'   => esc_html__( 'Height', 'foodmood' ),
                'height'  => true,
                'width'   => false,
                'default' => array( 'height' => 340 ),
                'required' => array( 'page_title_bg_switch', '=', true ),
            ),
			array(
				'id'      => 'page_title_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Paddings Top/Bottom', 'foodmood' ),
				'mode'    => 'padding',
				'all'     => false,
				'bottom'  => true,
				'top'     => true,
				'left'    => false,
				'right'   => false,
				'default' => array(
					'padding-top'    => '116',
					'padding-bottom' => '126',
				),
			),
			array(
				'id'      => 'page_title_margin',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Margin Bottom', 'foodmood' ),
				'mode'    => 'margin',
				'all'     => false,
				'bottom'  => true,
				'top'     => false,
				'left'    => false,
				'right'   => false,
				'default' => array( 'margin-bottom' => '40' ),
			),
			array(
				'id'      => 'page_title_align',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Title Alignment', 'foodmood' ),
				'options' => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right'
				 ),
				'default' => 'center',
			),
			array(
                'id'      => 'page_title_breadcrumbs_switch',
                'type'    => 'switch',
                'title'   => esc_html__( 'Breadcrumbs On/Off', 'foodmood' ),
                'default' => true,
            ),
            array(
                'id'      => 'page_title_breadcrumbs_block_switch',
                'type'    => 'switch',
                'title'   => esc_html__( 'Breadcrumbs Block On/Off', 'foodmood' ),
                'default' => true,
                'required' => array( 'page_title_breadcrumbs_switch', '=', true ),
            ),
            array(
				'id'      => 'page_title_breadcrumbs_align',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Breadcrumbs Alignment', 'foodmood' ),
				'options' => array(
					'left'   => 'Left',
					'center' => 'Center',
					'right'  => 'Right'
				 ),
				'default' => 'center',
				'required' => array( 'page_title_breadcrumbs_block_switch', '=', true ),
			),
            array(
                'id'      => 'page_title_parallax',
                'type'    => 'switch',
                'title'   => esc_html__( 'Parallax Scroll', 'foodmood' ),
                'default' => false,
            ),
            array(
                'id'       => 'page_title_parallax_speed',
                'type'     => 'spinner',
                'title'    => esc_html__( 'Parallax Speed', 'foodmood' ),
                'default'  => '0.3',
                'min'      => '-5',
                'step'     => '0.1',
                'max'      => '5',
                'required' => array( 'page_title_parallax', '=', '1' ),
            ),
            array(
                'id'      => 'page_title_parallax_mouse',
                'type'    => 'switch',
                'title'   => esc_html__( 'Parallax Mouse', 'foodmood' ),
                'default' => true,
            ),
            array(
                'id'            => 'page_title_mouse_bg_image',
                'type'          => 'background',
                'title'         => esc_html__( 'Background', 'foodmood' ),
                'preview'       => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent'   => false,
                'default'       => array(
                    'background-image'      => '',
                    'background-repeat'     => 'no-repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center bottom',
                    'background-color'      => 'transparent',
                ),
                'required' => array( 'page_title_parallax_mouse', '=', '1' ),
            ),
            array(
                'id'       => 'page_title_parallax_speed_mouse',
                'type'     => 'spinner',
                'title'    => esc_html__( 'Parallax Speed', 'foodmood' ),
                'default'  => '0.03',
                'min'      => '-5',
                'step'     => '0.01',
                'max'      => '5',
                'required' => array( 'page_title_parallax_mouse', '=', '1' ),
            ),

            array(
                'id'     => 'page_title-end',
                'type'   => 'section',
                'indent' => false,
                'required' => array( 'page_title_switch', '=', '1' ),
            ),

        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Typography', 'foodmood' ),
        'id'               => 'page_title_typography',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'          => 'page_title_font',
                'type'        => 'custom_typography',
                'title'       => esc_html__( 'Page Title Font', 'foodmood' ),
                'font-size'   => true,
                'google'      => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style'  => false,
                'color'       => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'  => false,
                'default'     => array(
                    'font-size'   => '42px',
                    'line-height' => '60px',
                    'color'       => '#232323',
                ),
            ),
            array(
                'id'          => 'page_title_breadcrumbs_font',
                'type'        => 'custom_typography',
                'title'       => esc_html__( 'Page Title Breadcrumbs Font', 'foodmood' ),
                'font-size'   => true,
                'google'      => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style'  => false,
                'color'       => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'  => false,
                'default'     => array(
                    'font-size'   => '14px',
                    'color'       => '#a0a0a0',
                    'line-height' => '24px',
                ),
            ),
        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Responsive', 'foodmood' ),
        'id'               => 'page_title_responsive',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'page_title_resp_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Responsive Layout On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'        => 'page_title_resp_resolution',
                'type'      => 'slider',
                'title'     => esc_html__('Screen breakpoint', 'foodmood'),
                "default"   => 768,
                "min"       => 1,
                "step"      => 1,
                "max"       => 1700,
                'display_value' => 'text',
                'required' => array( 'page_title_resp_switch', '=', '1' ),
            ),
            array(
                'id'        => 'page_title_resp_height',
                'type'      => 'dimensions',
                'units'     => 'px',
                'units_extended' => false,
                'title'     => esc_html__( 'Height', 'foodmood' ),
                'height'    => true,
                'width'     => false,
                'default'   => array(
                    'height' => 230,
                ),
                'required' => array( 'page_title_resp_switch', '=', '1' ),
            ),
            array(
                'id'       => 'page_title_resp_padding',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'all'      => false,
                'bottom'   => true,
                'top'      => true,
                'left'     => false,
                'right'    => false,
                'title'    => esc_html__( 'Paddings Top/Bottom', 'foodmood' ),
                'default'  => array(
                    'padding-top' => '15',
                    'padding-bottom' => '40',
                ),
                'required' => array( 'page_title_resp_switch', '=', '1' ),
            ),
            array(
                'id'          => 'page_title_resp_font',
                'type'        => 'custom_typography',
                'title'       => esc_html__( 'Page Title Font', 'foodmood' ),
                'font-size'   => true,
                'google'      => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style'  => false,
                'color'       => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'  => false,
                'default'     => array(
                    'font-size'   => '42px',
                    'line-height' => '60px',
                    'color'       => '#232323',
                ),
                'required' => array( 'page_title_resp_switch', '=', '1' ),
            ),
            array(
                'id'       => 'page_title_resp_breadcrumbs_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Breadcrumbs On/Off', 'foodmood' ),
                'default'  => true,
                'required' => array( 'page_title_resp_switch', '=', '1' ),
            ),
            array(
                'id'          => 'page_title_resp_breadcrumbs_font',
                'type'        => 'custom_typography',
                'title'       => esc_html__( 'Page Title Breadcrumbs Font', 'foodmood' ),
                'font-size'   => true,
                'google'      => false,
                'font-weight' => false,
                'font-family' => false,
                'font-style'  => false,
                'color'       => true,
                'line-height' => true,
                'font-backup' => false,
                'text-align'  => false,
                'all_styles'  => false,
                'default'     => array(
                    'font-size'   => '16px',
                    'color'       => '#232323',
                    'line-height' => '24px',
                ),
                'required' => array( 'page_title_resp_breadcrumbs_switch', '=', '1' ),
            ),

        )
    ) );

    // -> START Footer Options
    Redux::setSection( $theme_slug, array(
        'title' => esc_html__( 'Footer', 'foodmood' ),
        'id'    => 'footer',
    ) );

    Redux::setSection( $theme_slug, array(
        'title'      => esc_html__( 'Settings', 'foodmood' ),
        'id'         => 'footer_settings',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'footer_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Footer On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'footer-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Footer Settings', 'foodmood' ),
                'indent'   => true,
                'required' => array( 'footer_switch', '=', '1' ),
            ),
            array(
                'id'        => 'footer_add_wave',
                'type'      => 'switch',
                'title'     => esc_html__( 'Add Wave', 'foodmood' ),
                'default'   => false,
                 'required' => array( 'footer_switch', '=', '1' ),
            ),
            array(
                'id'             => 'footer_wave_height',
                'type'           => 'dimensions',
                'units'          => 'px',
                'units_extended' => false,
                'title'          => esc_html__( 'Set Wave Height' , 'foodmood' ),
                'height'         => true,
                'width'          => false,
                'default'        => array( 'height' => 158 ),
                'required'       => array( 'footer_add_wave', '=', '1' ),
            ),
            array(
                'id'       => 'footer_content_type',
                'type'     => 'select',
                'title'    => esc_html__( 'Content Type', 'foodmood' ),
                'options'  => array(
                    'widgets' => 'Get Widgets',
                    'pages' => 'Get Pages'
                ),
                'default'  => 'widgets'
            ),
            array(
                'id'       => 'footer_page_select',
                'type'     => 'select',
                'title'    => esc_html__( 'Page Select', 'foodmood' ),
                'data'  => 'posts',
                'args'  => array(
                    'post_type'      => 'footer',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
                'required' => array( 'footer_content_type', '=', 'pages' )
            ),
            array(
                'id'       => 'widget_columns',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Columns', 'foodmood' ),
                'options' => array(
                    '1' => '1',
                    '2' => '2',
                    '3' => '3',
                    '4' => '4',
                 ),
                'default' => '4',
                'required' => array( 'footer_content_type', '=', 'widgets' )
            ),
            array(
                'id'       => 'widget_columns_2',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Columns Layout', 'foodmood' ),
                'options'  => array(
                    '6-6' => array(
                        'alt' => '50-50',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/50-50.png'
                    ),
                    '3-9' => array(
                        'alt' => '25-75',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-75.png'
                    ),
                    '9-3' => array(
                        'alt' => '75-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/75-25.png'
                    ),
                    '4-8' => array(
                        'alt' => '33-66',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/33-66.png'
                    ),
                    '8-4' => array(
                        'alt' => '66-33',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/66-33.png'
                    )
                ),
                'default'  => '6-6',
                'required' => array( 'widget_columns', '=', '2' ),
            ),
            array(
                'id'       => 'widget_columns_3',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Columns Layout', 'foodmood' ),
                'options'  => array(
                    '4-4-4' => array(
                        'alt' => '33-33-33',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/33-33-33.png'
                    ),
                    '3-3-6' => array(
                        'alt' => '25-25-50',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-25-50.png'
                    ),
                    '3-6-3' => array(
                        'alt' => '25-50-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/25-50-25.png'
                    ),
                    '6-3-3' => array(
                        'alt' => '50-25-25',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/50-25-25.png'
                    ),
                ),
                'default'  => '4-4-4',
                'required' => array( 'widget_columns', '=', '3' ),
            ),
            array(
                'id'       => 'footer_spacing',
                'type'     => 'spacing',
                'output'   => array( '.wgl-footer' ),
                'mode'     => 'padding',
                'units'    => 'px',
                'all'      => false,
                'title'    => esc_html__( 'Paddings', 'foodmood' ),
                'default'  => array(
                    'padding-top'    => '130px',
                    'padding-right'  => '0px',
                    'padding-bottom' => '60px',
                    'padding-left'   => '0px'
                )
            ),
            array(
                'id'       => 'footer_full_width',
                'type'     => 'switch',
                'title'    => esc_html__( 'Full Width On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'footer_content_type', '=', 'widgets' )
            ),
            array(
                'id'     => 'footer-end',
                'type'   => 'section',
                'indent' => false,
                'required' => array( 'footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'footer-start-styles',
                'type'     => 'section',
                'title'    => esc_html__( 'Footer Styling', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'footer_bg_image',
                'type'     => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview'  => false,
                'title'    => esc_html__( 'Background Image', 'foodmood' ),
                'default'  => array(
                    'background-repeat'     => 'repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center center',
                )
            ),
            array(
                'id'       => 'footer_align',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Content Align', 'foodmood'),
                'options'  => array(
                    'left'   => 'Left',
                    'center' => 'Center',
                    'right'  => 'Right'
                 ),
                'default'  => 'center',
                'required' => array( 'footer_content_type', '=', 'widgets' )
            ),
            array(
                'id'       => 'footer_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Background Color', 'foodmood' ),
                'default'  => '#1a1a1a',
                'transparent' => false
            ),
            array(
                'id'       => 'footer_heading_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Headings color', 'foodmood' ),
                'default'  => '#ffffff',
                'transparent' => false
            ),
            array(
                'id'       => 'footer_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Content color', 'foodmood' ),
                'default'  => '#cccccc',
                'transparent' => false
            ),
            array(
                'id'        => 'footer_add_border',
                'type'      => 'switch',
                'title'     => esc_html__( 'Add Border Top', 'foodmood' ),
                'default'   => false,
                 'required' => array( 'footer_switch', '=', '1' ),
            ),
            array(
                'id'       => 'footer_border_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Border color', 'foodmood' ),
                'default'  => 'rgba(255,255,255,0.2)',
                'transparent' => false,
                'required' => array( 'footer_add_border', '=', '1' ),
            ),
            array(
                'id'     => 'footer-end-styles',
                'type'   => 'section',
                'indent' => false,
            ),
        )
    ) );

    // -> START Copyright Options
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Copyright', 'foodmood' ),
        'id'               => 'copyright',
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Settings', 'foodmood' ),
        'id'               => 'copyright-settings',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'copyright_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Copyright On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'copyright-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Copyright Settings', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'      => 'copyright_editor',
                'type'    => 'editor',
                'title'   => esc_html__( 'Editor', 'foodmood' ),
                'default' => '<p>Copyright © 2019 Foodmood by WebGeniusLab. All Rights Reserved</p>',
                'args'    => array(
                    'wpautop'       => false,
                    'media_buttons' => false,
                    'textarea_rows' => 2,
                    'teeny'         => false,
                    'quicktags'     => true,
                ),
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_text_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Text Color', 'foodmood' ),
                'default'  => '#cccccc',
                'transparent' => false,
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_bg_color',
                'type'     => 'color',
                'title'    => esc_html__( 'Background Color', 'foodmood' ),
                'default'  => '#1a1a1a',
                'transparent' => false,
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'       => 'copyright_spacing',
                'type'     => 'spacing',
                'mode'     => 'padding',
                'left'     => false,
                'right'     => false,
                'all'      => false,
                'title'    => esc_html__( 'Paddings', 'foodmood' ),
                'default'  => array(
                    'padding-top'    => '20',
                    'padding-bottom' => '20',
                ),
                'required' => array( 'copyright_switch', '=', '1' ),
            ),
            array(
                'id'     => 'copyright-end',
                'type'   => 'section',
                'indent' => false,
                'required' => array( 'footer_switch', '=', '1' ),
            ),
        )
    ));

    // -> START Blog Options
    Redux::setSection( $theme_slug, array(
        'title' => esc_html__( 'Blog', 'foodmood' ),
        'id'    => 'blog-option',
        'icon'  => 'el-icon-th',
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Archive', 'foodmood' ),
        'id'               => 'blog-list-option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'post_archive_page_title_bg_image',
                'type'     => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview'  => false,
                'title'    => esc_html__( 'Archive Page Title Background Image', 'foodmood' ),
                'default'  => array(
                    'background-repeat'     => 'repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center center',
                    'background-color'      => '#1e73be',
                )
            ),
            array(
                'id'       => 'blog_list_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Blog Archive Sidebar Layout', 'foodmood' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'blog_list_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Blog Archive Sidebar', 'foodmood' ),
                'data'     => 'sidebars',
                'required' => array( 'blog_list_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'blog_list_sidebar_def_width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Blog Archive Sidebar Width', 'foodmood' ),
                'options'  => array(
                    '9' => '25%',
                    '8' => '33%',
                ),
                'default'  => '9',
                'required' => array( 'blog_list_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'blog_list_sidebar_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Blog Archive Sticky Sidebar On?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'blog_list_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'blog_list_sidebar_gap',
                'type'     => 'select',
                'title'    => esc_html__( 'Blog Archive Sidebar Side Gap', 'foodmood' ),
                'options'  => array(
                    'def' => esc_html__( 'Default', 'foodmood' ),
                    '0' => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ),
                'default'  => 'def',
                'required' => array( 'blog_list_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'blog_list_columns',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Columns in Archive', 'foodmood'),
                'options' => array(
                    '12' => 'One',
                    '6' => 'Two',
                    '4' => 'Three',
                    '3' => 'Four'
                 ),
                'default' => '12'
            ),
            array(
                'id'       => 'blog_list_likes',
                'type'     => 'switch',
                'title'    => esc_html__( 'Likes On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Share On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_hide_media',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide Media?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_hide_title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide Title?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_hide_content',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide Content?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_post_listing_content',
                'type'     => 'switch',
                'title'    => esc_html__( 'Cut Off Text in Blog Listing', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_letter_count',
                'type'     => 'text',
                'title'    => esc_html__( 'Number of character to show after trim.', 'foodmood'),
                'default'  => '85',
                'required' => array( 'blog_post_listing_content', '=', true ),
            ),
            array(
                'id'       => 'blog_list_read_more',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide Read More Button?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_meta',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide all post-meta?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'blog_list_meta_author',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta author?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'blog_list_meta', '=', false ),
            ),
            array(
                'id'       => 'blog_list_meta_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta comments?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'blog_list_meta', '=', false ),
            ),
            array(
                'id'       => 'blog_list_meta_categories',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta categories?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'blog_list_meta', '=', false ),
            ),
            array(
                'id'       => 'blog_list_meta_date',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta date?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'blog_list_meta', '=', false ),
            ),
        )
    ));

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Single', 'foodmood' ),
        'id'               => 'blog-single-option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'blog_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Blog Post Title On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'post_single_page_title_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Single Page Title Text', 'foodmood' ),
                'default'  => esc_html__( 'Blog', 'foodmood' ),
                'required' => array( 'blog_title_conditional', '=', true ),
            ),
            array(
                'id'       => 'post_single_page_title_bg_image',
                'type'     => 'background',
                'preview'  => false,
                'preview_media' => true,
                'background-color' => false,
                'title'    => esc_html__( 'Single Page Title Background Image', 'foodmood' ),
                'default'  => array(
                    'background-repeat'     => 'repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center center',
                    'background-color'      => '#f6f7f8',
                )
            ),
            array(
                'id'       => 'single_type_layout',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Blog Single Type', 'foodmood' ),
                'options'  => array(
                    '1' => esc_html__( 'Title First', 'foodmood' ),
                    '2' => esc_html__( 'Image First', 'foodmood' ),
                    '3' => esc_html__( 'Overlay Image', 'foodmood' )
                ),
                'default'  => '3'
            ),
            array(
                'id'       => 'single_padding_layout_3',
                'type'     => 'spacing',
                // An array of CSS selectors to apply this font style to
                'mode'     => 'padding',
                'all'      => false,
                'bottom'   => true,
                'top'      => true,
                'left'     => false,
                'right'    => false,
                'title'    => esc_html__( 'Page Title Padding', 'foodmood' ),
                'default'  => array(
                    'padding-top' => '120px',
                    'padding-bottom' => '0',
                ),
                'required' => array( 'single_type_layout', '=', '3' ),
            ),
            array(
                'id'       => 'featured_image_type',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Featured Image', 'foodmood' ),
                'options'  => array(
                    'default' => esc_html__( 'Default', 'foodmood' ),
                    'off' => esc_html__( 'Off', 'foodmood' ),
                    'replace' => esc_html__( 'Replace', 'foodmood' )
                ),
                'default'  => 'default'
            ),
            array(
                'id'       => 'featured_image_replace',
                'type'     => 'media',
                'title'    => esc_html__( 'Featured Image Replace', 'foodmood' ),
                'required' => array( 'featured_image_type', '=', 'replace' ),
            ),
            array(
                'id'       => 'single_apply_animation',
                'type'     => 'switch',
                'title'    => esc_html__( 'Apply Animation?', 'foodmood' ),
                'default'  => true,
                'required' => array( 'single_type_layout', '=', '3' ),
            ),
            array(
                'id'       => 'single_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Blog Single Sidebar Layout', 'foodmood' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    )
                ),
                'default'  => 'right'
            ),
            array(
                'id'       => 'single_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Blog Single Sidebar', 'foodmood' ),
                'data'     => 'sidebars',
                'required' => array( 'single_sidebar_layout', '!=', 'none' ),
                'default'  =>  'sidebar_main-sidebar',
            ),
            array(
                'id'       => 'single_sidebar_def_width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Blog Single Sidebar Width', 'foodmood' ),
                'options'  => array(
                    '9' => '25%',
                    '8' => '33%',
                ),
                'default'  => '9',
                'required' => array( 'single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'single_sidebar_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Blog Single Sticky Sidebar On?', 'foodmood' ),
                'default'  => true,
                'required' => array( 'single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'single_sidebar_gap',
                'type'     => 'select',
                'title'    => esc_html__( 'Blog Single Sidebar Side Gap', 'foodmood' ),
                'options'  => array(
                    'def' => esc_html__( 'Default', 'foodmood' ),
                    '0'  => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ),
                'default'  => 'def',
                'required' => array( 'single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'single_likes',
                'type'     => 'switch',
                'title'    => esc_html__( 'Likes On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'single_views',
                'type'     => 'switch',
                'title'    => esc_html__( 'Views On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'single_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Share On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'single_author_info',
                'type'     => 'switch',
                'title'    => esc_html__( 'Author Info On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'single_meta',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide all post-meta?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'single_meta_author',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta author?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'single_meta', '=', false ),
            ),
            array(
                'id'       => 'single_meta_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta comments?', 'foodmood' ),
                'default'  => true,
                'required' => array( 'single_meta', '=', false ),
            ),
            array(
                'id'       => 'single_meta_categories',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta categories?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'single_meta', '=', false ),
            ),
            array(
                'id'       => 'single_meta_date',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide post-meta date?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'single_meta', '=', false ),
            ),
            array(
                'id'       => 'single_meta_tags',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide tags?', 'foodmood' ),
                'default'  => false,
            ),

        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Related', 'foodmood' ),
        'id'               => 'blog-single-related-option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'single_related_posts',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Posts', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'blog_title_r',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'foodmood' ),
                'default'  => esc_html__( 'Related Posts', 'foodmood' ),
                'required' => array( 'single_related_posts', '=', '1' ),
            ),
            array(
                'id'       => 'blog_cat_r',
                'type'     => 'select',
                'multi'    => true,
                'title'    => esc_html__( 'Select Categories', 'foodmood' ),
                'data'     => 'categories',
                'width'    => '20%',
                'required' => array( 'single_related_posts', '=', '1' ),
            ),
            array(
                'id'       => 'blog_column_r',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Columns', 'foodmood' ),
                'options'  => array(
                    '12' => '1',
                    '6' => '2',
                    '4' => '3',
                    '3' => '4'
                ),
                'default'  => '6',
                'required' => array( 'single_related_posts', '=', '1' ),
            ),
            array(
                'id'       => 'blog_number_r',
                'type'     => 'text',
                'title'    => esc_html__( 'Number of Related Items', 'foodmood' ),
                'default'  => '2',
                'required' => array( 'single_related_posts', '=', '1' ),
            ),

            array(
                'id'       => 'blog_carousel_r',
                'type'     => 'switch',
                'title'    => esc_html__( 'Display items in the carousel', 'foodmood' ),
                'default'  => true,
                'required' => array( 'single_related_posts', '=', '1' ),
            ),
        )

    ) );

    // -> START Portfolio Options
    Redux::setSection( $theme_slug, array(
        'title' => esc_html__( 'Portfolio', 'foodmood' ),
        'id'    => 'portfolio-option',
        'icon'  => 'el-icon-th',
    ) );

    Redux::setSection( $theme_slug, array(
        'title'      => esc_html__( 'Archive', 'foodmood' ),
        'id'         => 'portfolio-list-option',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'portfolio_archive_page_title_bg_image',
                'type'     => 'background',
                'background-color' => false,
                'preview_media' => true,
                'preview'  => false,
                'title'    => esc_html__( 'Archive Page Title Background Image', 'foodmood' ),
                'default'  => array(
                    'background-repeat'     => 'repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center center',
                    'background-color'      => '#f6f7f8',
                )
            ),
            array(
                'id'       => 'portfolio_list_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Portfolio Archive Sidebar Layout', 'foodmood' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'portfolio_list_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Portfolio Archive Sidebar', 'foodmood' ),
                'data'     => 'sidebars',
                'required' => array( 'portfolio_list_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id' => 'portfolio_list_sidebar_def_width',
                'title' => esc_html__('Sidebar Width', 'foodmood'),
                'type' => 'button_set',
                'required' => array( 'portfolio_list_sidebar_layout', '!=', 'none' ),
                'options' => array(
                    '9' => esc_html__('25%', 'foodmood'),
                    '8' => esc_html__('33%', 'foodmood'),
                ),
                'default' => '9',
            ),
            array(
                'id'       => 'portfolio_list_columns',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Columns in Archive', 'foodmood'),
                'options' => array(
                    '1' => 'One',
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four'
                 ),
                'default' => '3'
            ),
            array(
                'id'       => 'portfolio_slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Portfolio Slug', 'foodmood' ),
                'default'  => 'portfolio',
            ),
            array(
                'id'       => 'portfolio_list_show_title',
                'type'     => 'switch',
                'title'    => esc_html__( 'Title On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_list_show_content',
                'type'     => 'switch',
                'title'    => esc_html__( 'Content On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'portfolio_list_show_cat',
                'type'     => 'switch',
                'title'    => esc_html__( 'Categories On/Off', 'foodmood' ),
                'default'  => true,
            ),
        )
    ) );

	Redux::setSection( $theme_slug, array(
		'title'            => esc_html__( 'Single', 'foodmood' ),
		'id'               => 'portfolio-single-option',
		'subsection'       => true,
		'fields'           => array(
			array(
				'id'       => 'portfolio_single_post_title-start',
				'type'     => 'section',
				'title'    => esc_html__( 'Post Title Settings', 'foodmood' ),
				'indent'   => true,
			),
			array(
				'id'       => 'portfolio_title_conditional',
				'type'     => 'switch',
				'title'    => esc_html__( 'Use Custom Post Title?', 'foodmood' ),
				'default'  => false,
			),
			array(
			    'id'       => 'portfolio_single_page_title_text',
			    'type'     => 'text',
			    'title'    => esc_html__( 'Custom Post Title', 'foodmood' ),
			    'default'  => esc_html__( '', 'foodmood' ),
			    'required' => array( 'portfolio_title_conditional', '=', true ),
			),
			array(
				'id'      => 'portfolio_single_title_align',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Title Alignment', 'foodmood' ),
				'options' => array(
					'left'   => esc_html__( 'Left', 'foodmood' ),
					'center' => esc_html__( 'Center', 'foodmood' ),
					'right'  => esc_html__( 'Right', 'foodmood' ),
				),
				'default' => 'center',
			),
			array(
				'id'      => 'portfolio_single_breadcrumbs_align',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Title Breadcrumbs Alignment', 'foodmood' ),
				'options' => array(
					'left'   => esc_html__( 'Left', 'foodmood' ),
					'center' => esc_html__( 'Center', 'foodmood' ),
					'right'  => esc_html__( 'Right', 'foodmood' ),
				),
				'default' => 'center',
			),
            array(
                'id'      => 'portfolio_single_breadcrumbs_block_switch',
                'type'    => 'switch',
                'title'   => esc_html__( 'Breadcrumbs Block On/Off', 'foodmood' ),
                'default' => true,
            ),
			array(
				'id'      => 'portfolio_single_title_bg_switch',
				'type'    => 'switch',
				'title'   => esc_html__( 'Use Background?', 'foodmood' ),
				'default' => true,
			),
			array(
				'id'      => 'portfolio_single_page_title_bg_image',
				'type'    => 'background',
				'title'   => esc_html__( 'Background', 'foodmood' ),
				'preview' => false,
				'preview_media' => true,
				'background-color' => true,
				'transparent' => false,
				'default' => array(
					'background-repeat'     => 'repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'scroll',
					'background-position'   => 'center center',
					'background-color'      => '#f6f7f8',
				),
				'required' => array( 'portfolio_single_title_bg_switch', '=', true ),
			),
			array(
				'id'      => 'portfolio_single_page_title_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Paddings Top/Bottom', 'foodmood' ),
				'mode'    => 'padding',
				'all'     => false,
				'bottom'  => true,
				'top'     => true,
				'left'    => false,
				'right'   => false,
				'default' => array(
					'padding-top'    => '80',
					'padding-bottom' => '88',
				),
			),
			array(
				'id'      => 'portfolio_single_page_title_margin',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Margin Bottom', 'foodmood' ),
				'mode'    => 'margin',
				'all'     => false,
				'bottom'  => true,
				'top'     => false,
				'left'    => false,
				'right'   => false,
				'default' => array( 'margin-bottom' => '40' ),
			),
			array(
				'id'     => 'portfolio_single_post_title-end',
				'type'   => 'section',
				'indent' => false,
			),
            array(
                'id'      => 'portfolio_single_type_layout',
                'type'    => 'button_set',
                'title'   => esc_html__( 'Portfolio Single Type', 'foodmood' ),
                'options' => array(
                    '1' => esc_html__( 'Title First', 'foodmood' ),
                    '2' => esc_html__( 'Image First', 'foodmood' ),
                    '3' => esc_html__( 'Overlay Image', 'foodmood' ),
                    '4' => esc_html__( 'Overlay Image with Info', 'foodmood' ),
                ),
                'default' => '2',
            ),
            array(
                'id'      => 'portfolio_single_align',
                'type'    => 'button_set',
                'title'   => esc_html__( 'Content Alignment', 'foodmood' ),
                'options' => array(
                    'left' => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left',
            ),
            array(
                'id'      => 'portfolio_single_padding',
                'type'    => 'spacing',
                'mode'    => 'padding',
                'all'     => false,
                'bottom'  => true,
                'top'     => true,
                'left'    => false,
                'right'   => false,
                'title'   => esc_html__( 'Portfolio Single Padding', 'foodmood' ),
                'default' => array(
                    'padding-top'    => '165px',
                    'padding-bottom' => '165px',
                ),
                'required' => array(
                    array( 'portfolio_single_type_layout', '!=', '1' ),
                    array( 'portfolio_single_type_layout', '!=', '2' ),
                ),
            ),
            array(
                'id'       => 'portfolio_parallax',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Portfolio Parallax', 'foodmood' ),
                'default'  => false,
                'required' => array(
                    array( 'portfolio_single_type_layout', '!=', '1' ),
                    array( 'portfolio_single_type_layout', '!=', '2' ),
                ),
            ),
            array(
                'id'       => 'portfolio_parallax_speed',
                'type'     => 'spinner',
                'title'    => esc_html__( 'Parallax Speed', 'foodmood' ),
                'default'  => '0.3',
                'min'      => '-5',
                'step'     => '0.1',
                'max'      => '5',
                'required' => array( 'portfolio_parallax', '=', '1' ),
            ),
            array(
                'id'       => 'portfolio_single_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Portfolio Single Sidebar Layout', 'foodmood' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'portfolio_single_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Portfolio Single Sidebar', 'foodmood' ),
                'data'     => 'sidebars',
                'required' => array( 'portfolio_single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'portfolio_single_sidebar_def_width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Portfolio Single Sidebar Width', 'foodmood' ),
                'options'  => array(
                    '9' => '25%',
                    '8' => '33%',
                ),
                'default'  => '8',
                'required' => array( 'portfolio_single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'portfolio_single_sidebar_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Portfolio Single Sticky Sidebar On?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'portfolio_single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'portfolio_single_sidebar_gap',
                'type'     => 'select',
                'title'    => esc_html__( 'Portfolio Single Sidebar Side Gap', 'foodmood' ),
                'options'  => array(
                    'def' => esc_html__( 'Default', 'foodmood' ),
                    '0'  => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ),
                'default'  => 'def',
                'required' => array( 'portfolio_single_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'portfolio_above_content_cats',
                'type'     => 'switch',
                'title'    => esc_html__( 'Tags On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_above_content_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Share On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'portfolio_single_meta_likes',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post-meta likes On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id' => 'portfolio_single_meta',
                'type'     => 'switch',
                'title'    => esc_html__( 'Hide all post-meta?', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'portfolio_single_meta_author',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post-meta author On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'portfolio_single_meta', '=', false ),
            ),
            array(
                'id'       => 'portfolio_single_meta_comments',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post-meta comments On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'portfolio_single_meta', '=', false ),
            ),
            array(
                'id'       => 'portfolio_single_meta_categories',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post-meta categories On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'portfolio_single_meta', '=', false ),
            ),
            array(
                'id'       => 'portfolio_single_meta_date',
                'type'     => 'switch',
                'title'    => esc_html__( 'Post-meta date On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'portfolio_single_meta', '=', false ),
            ),
        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Related Posts', 'foodmood' ),
        'id'               => 'portfolio-related-option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'portfolio_related_switch',
                'type'     => 'switch',
                'title'    => esc_html__( 'Related Posts On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'pf_title_r',
                'type'     => 'text',
                'title'    => esc_html__( 'Title', 'foodmood' ),
                'default'  => esc_html__( 'Related Portfolio', 'foodmood' ),
                'required' => array( 'portfolio_related_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pf_carousel_r',
                'type'     => 'switch',
                'title'    => esc_html__( 'Display items carousel for this portfolio post', 'foodmood' ),
                'default'  => true,
                'required' => array( 'portfolio_related_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pf_column_r',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Related Columns', 'foodmood'),
                'options'  => array(
                    '2' => 'Two',
                    '3' => 'Three',
                    '4' => 'Four'
                ),
                'default'  => '3',
                'required' => array( 'portfolio_related_switch', '=', '1' ),
            ),
            array(
                'id'       => 'pf_number_r',
                'type'     => 'text',
                'title'    => esc_html__( 'Number of Related Items', 'foodmood' ),
                'default'  => '3',
                'required' => array( 'portfolio_related_switch', '=', '1' ),
            ),
        )
    ) );

    // -> START Team Options
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Team', 'foodmood' ),
        'id'               => 'team-option',
        'icon'             => 'el-icon-th',
        'fields'           => array(
            array(
                'id'       => 'team_slug',
                'type'     => 'text',
                'title'    => esc_html__( 'Team Slug', 'foodmood' ),
                'default'  => 'team',
            ),
            array(
                'id'       => 'team_single_page_title_bg_image',
                'type'     => 'background',
                'preview' => false,
                'preview_media' => true,
                'background-color' => false,
                'title'    => esc_html__( 'Single Page Title Background Image', 'foodmood' ),
                'default'  => array(
                    'background-repeat'     => 'repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'center center',
                    'background-color'      => '#f6f7f8',
                )
            ),
        )
    ) );

    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Single', 'foodmood' ),
        'id'               => 'team-single-option',
        'subsection'       => true,
        'fields'           => array(
            array(
                'id'       => 'team_title_conditional',
                'type'     => 'switch',
                'title'    => esc_html__( 'Team Post Title On/Off', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => 'team_single_page_title_text',
                'type'     => 'text',
                'title'    => esc_html__( 'Single Page Title Text', 'foodmood' ),
                'default'  => esc_html__( 'Team', 'foodmood' ),
                'required' => array( 'team_title_conditional', '=', true ),
            ),
        )
    ) );

	// -> START Page 404 Options
	Redux::setSection( $theme_slug, array(
		'title'            => esc_html__( 'Page 404', 'foodmood' ),
		'id'               => '404-option',
		'icon'             => 'el-icon-th',
		'fields'           => array(
			array(
				'id'       => '404_post_title-start',
				'type'     => 'section',
				'title'    => esc_html__( '404 Settings', 'foodmood' ),
				'indent'   => true,
			),
            array(
                'id'       => '404_page_main_bg_image',
                'type'     => 'background',
                'preview'  => false,
                'preview_media' => true,
                'background-color' => true,
                'transparent' => false,
                'title'    => esc_html__( 'Main Background', 'foodmood' ),
                'default'  => array(
                    'background-repeat'     => 'no-repeat',
                    'background-size'       => 'cover',
                    'background-attachment' => 'scroll',
                    'background-position'   => 'right top',
                    'background-color'      => '#ffffff',
                ),
            ),
            array(
                'id'       => '404_show_header',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Header?', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => '404_show_footer',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Footer?', 'foodmood' ),
                'default'  => true,
            ),
            array(
                'id'       => '404_page_title_switcher',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Page Title?', 'foodmood' ),
                'default'  => true,
            ),
			array(
				'id'       => '404_custom_title_switch',
				'type'     => 'switch',
				'title'    => esc_html__( 'Use Custom Page Title?', 'foodmood' ),
				'default'  => false,
                'required' => array( '404_page_title_switcher', '=', true ),
			),
			array(
				'id'       => '404_page_title_text',
				'type'     => 'text',
				'title'    => esc_html__( 'Custom Page Title', 'foodmood' ),
				'default'  => esc_html__( '', 'foodmood' ),
				'required' => array( '404_custom_title_switch', '=', true ),
			),
			array(
				'id'      => '404_title_bg_switch',
				'type'    => 'switch',
				'title'   => esc_html__( 'Use Background?', 'foodmood' ),
				'default' => true,
                'required' => array( '404_page_title_switcher', '=', true ),
			),
			array(
				'id'       => '404_page_title_bg_image',
				'type'     => 'background',
				'preview'  => false,
				'preview_media' => true,
				'background-color' => true,
				'transparent' => false,
				'title'    => esc_html__( 'Background', 'foodmood' ),
				'default'  => array(
					'background-repeat'     => 'repeat',
					'background-size'       => 'cover',
					'background-attachment' => 'scroll',
					'background-position'   => 'center center',
					'background-color'      => '#f6f7f8',
				),
				'required' => array( '404_title_bg_switch', '=', true ),
			),
			array(
				'id'      => '404_page_title_padding',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Paddings Top/Bottom', 'foodmood' ),
				'mode'    => 'padding',
				'all'     => false,
				'bottom'  => true,
				'top'     => true,
				'left'    => false,
				'right'   => false,
				'default' => array(
					'padding-top'    => '116',
					'padding-bottom' => '126',
				),
                'required' => array( '404_page_title_switcher', '=', true ),
			),
			array(
				'id'      => '404_page_title_margin',
				'type'    => 'spacing',
				'title'   => esc_html__( 'Margin Bottom', 'foodmood' ),
				'mode'    => 'margin',
				'all'     => false,
				'bottom'  => true,
				'top'     => false,
				'left'    => false,
				'right'   => false,
				'default' => array( 'margin-bottom' => '40' ),
                'required' => array( '404_page_title_switcher', '=', true ),
			),
			array(
				'id'     => '404_post_title-end',
				'type'   => 'section',
				'indent' => false,
			),
		)
	) );

	// -> START Side Panel Options
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Side Panel', 'foodmood' ),
        'id'               => 'side_panel',
        'icon'             => 'el-icon-th',
        'fields'           => array(
            array(
                'id'       => 'side_panel_content_type',
                'type'     => 'select',
                'title'    => esc_html__( 'Content Type', 'foodmood' ),
                'options'  => array(
                    'widgets' => 'Get Widgets',
                    'pages' => 'Get Pages'
                ),
                'default'  => 'pages'
            ),
            array(
                'id'       => 'side_panel_page_select',
                'type'     => 'select',
                'title'    => esc_html__( 'Page Select', 'foodmood' ),
                'data'  => 'posts',
                'args'  => array(
                    'post_type'      => 'side_panel',
                    'posts_per_page' => -1,
                    'orderby'        => 'title',
                    'order'          => 'ASC',
                ),
                'required' => array( 'side_panel_content_type', '=', 'pages' )
            ),
            array(
                'id'       => 'side_panel_spacing',
                'type'     => 'spacing',
                'output'   => array( '#side-panel .side-panel_sidebar' ),
                'mode'     => 'padding',
                'units'    => 'px',
                'all'      => false,
                'title'    => esc_html__( 'Paddings', 'foodmood' ),
                'default'  => array(
                    'padding-top'    => '105px',
                    'padding-right'  => '90px',
                    'padding-bottom' => '105px',
                    'padding-left'   => '90px'
                )
            ),

            array(
                'id'       => 'side_panel_title_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Title Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#ffffff',
                    'alpha' => '1',
                    'rgba'  => 'rgba(255,255,255,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'side_panel_text_color',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Text Color', 'foodmood' ),
                'default'  => array(
                    'color' => '#cccccc',
                    'alpha' => '1',
                    'rgba'  => 'rgba(204,204,204,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'side_panel_bg',
                'type'     => 'color_rgba',
                'title'    => esc_html__( 'Background', 'foodmood' ),
                'default'  => array(
                    'color' => '#232323',
                    'alpha' => '1',
                    'rgba'  => 'rgba(35,35,35,1)'
                ),
                'mode'     => 'background',
            ),
            array(
                'id'       => 'side_panel_text_alignment',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Text Align', 'foodmood' ),
                'options'  => array(
                    'left'   => esc_html__( 'Left', 'foodmood' ),
                    'center' => esc_html__( 'Center', 'foodmood' ),
                    'right'  => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'left'
            ),
            array(
                'id'       => 'side_panel_width',
                'type'     => 'dimensions',
                'units'    => 'px',
                'units_extended' => false,
                'title'    => esc_html__( 'Width', 'foodmood' ),
                'height'   => false,
                'width'    => true,
                'default'  => array(
                    'width' => 475,
                )
            ),
            array(
                'id'       => 'side_panel_position',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Position', 'foodmood' ),
                'options'  => array(
                    'left'  => esc_html__( 'Left', 'foodmood' ),
                    'right' => esc_html__( 'Right', 'foodmood' ),
                ),
                'default'  => 'right'
            ),
        )
    ) );

    // -> START Layout Options
    Redux::setSection( $theme_slug, array(
        'title'  => esc_html__( 'Sidebars', 'foodmood' ),
        'id'     => 'layout_options',
        'icon'   => 'el el-braille',
        'fields' => array(
            array(
                'id'       => 'sidebars',
                'type'     => 'multi_text',
                'validate' => 'no_html',
                'add_text' => esc_html__( 'Add Sidebar', 'foodmood' ),
                'title'    => esc_html__( 'Register Sidebars', 'foodmood' ),
                'default'  => array('Main Sidebar'),
            ),
            array(
                'id'       => 'sidebars-start',
                'type'     => 'section',
                'title'    => esc_html__( 'Sidebar Page Settings', 'foodmood' ),
                'indent'   => true,
            ),
            array(
                'id'       => 'page_sidebar_layout',
                'type'     => 'image_select',
                'title'    => esc_html__( 'Page Sidebar Layout', 'foodmood' ),
                'options'  => array(
                    'none' => array(
                        'alt' => 'None',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                    ),
                    'left' => array(
                        'alt' => 'Left',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                    ),
                    'right' => array(
                        'alt' => 'Right',
                        'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                    )
                ),
                'default'  => 'none'
            ),
            array(
                'id'       => 'page_sidebar_def',
                'type'     => 'select',
                'title'    => esc_html__( 'Page Sidebar', 'foodmood' ),
                'data'     => 'sidebars',
                'required' => array( 'page_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'page_sidebar_def_width',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Page Sidebar Width', 'foodmood' ),
                'options'  => array(
                    '9' => '25%',
                    '8' => '33%',
                ),
                'default'  => '9',
                'required' => array( 'page_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'page_sidebar_sticky',
                'type'     => 'switch',
                'title'    => esc_html__( 'Sticky Sidebar On?', 'foodmood' ),
                'default'  => false,
                'required' => array( 'page_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'       => 'page_sidebar_gap',
                'type'     => 'select',
                'title'    => esc_html__( 'Sidebar Side Gap', 'foodmood' ),
                'options'  => array(
                    'def' => esc_html__( 'Default', 'foodmood' ),
                    '0'  => '0',
                    '15' => '15',
                    '20' => '20',
                    '25' => '25',
                    '30' => '30',
                    '35' => '35',
                    '40' => '40',
                    '45' => '45',
                    '50' => '50',
                ),
                'default'  => 'def',
                'required' => array( 'page_sidebar_layout', '!=', 'none' ),
            ),
            array(
                'id'     => 'sidebars-end',
                'type'   => 'section',
                'indent' => false,
            ),
        )
    ) );

        // -> START Social Share Options
    Redux::setSection( $theme_slug, array(
        'title'  => esc_html__( 'Social Shares', 'foodmood' ),
        'id'     => 'soc_shares',
        'icon'   => 'el el-share-alt',
        'fields' => array(
            array(
                'id'       => 'show_soc_icon_page',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Social Share on Pages On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'soc_icon_style',
                'type'     => 'button_set',
                'title'    => esc_html__( 'Choose your share style.', 'foodmood' ),
                'options'  => array(
                    'standard' => esc_html__( 'Standard', 'foodmood' ),
                    'hovered' => esc_html__( 'Hovered', 'foodmood' ),
                ),
                'default'  => 'standard',
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_position',
                'type'     => 'switch',
                'title'    => esc_html__( 'Fixed Position On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_offset',
                'type'     => 'spacing',
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => true,
                'top'      => false,
                'left'     => false,
                'right'    => false,
                'title'    => esc_html__( 'Offset Top', 'foodmood' ),
                'desc'     => esc_html__( 'Measurement units defined as "percents" while position fixed is enabled, and as "pixels" while position is off.', 'foodmood' ),
                'default'  => array(
                    'margin-bottom' => '40%',
                ),
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_facebook',
                'type'     => 'switch',
                'title'    => esc_html__( 'Facebook Share On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_twitter',
                'type'     => 'switch',
                'title'    => esc_html__( 'Twitter Share On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_linkedin',
                'type'     => 'switch',
                'title'    => esc_html__( 'Linkedin Share On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_pinterest',
                'type'     => 'switch',
                'title'    => esc_html__( 'Pinterest Share On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'soc_icon_tumblr',
                'type'     => 'switch',
                'title'    => esc_html__( 'Tumblr Share On/Off', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'add_custom_share',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Custom Share?', 'foodmood' ),
                'default'  => true,
                'required' => array( 'show_soc_icon_page', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-1',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 1', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-1',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 1', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-2',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 2', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-2',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 2', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-3',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 3', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-3',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 3', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-4',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 4', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-4',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 4', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-5',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 5', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-5',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 5', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-6',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 6', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-6',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 6', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-7',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 7', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-7',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 7', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-8',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 8', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-8',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 8', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-9',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 9', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-9',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 9', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_icons-10',
                'type'     => 'select',
                'data'     => 'elusive-icons',
                'title'    => esc_html__( 'Custom Share Icon 10', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
            array(
                'id'       => 'select_custom_share_text-10',
                'type'     => 'text',
                'title'    => esc_html__( 'Custom Share Link 10', 'foodmood' ),
                'required' => array( 'add_custom_share', '=', '1' ),
            ),
        )
    ) );

    // -> START Page Marker Options
    Redux::setSection( $theme_slug, array(
        'title'  => esc_html__( 'Page Marker', 'foodmood' ),
        'id'     => 'page_marker',
        'icon'   => 'el el-share-alt',
        'fields' => array(
            array(
                'id'       => 'show_page_marker',
                'type'     => 'switch',
                'title'    => esc_html__( 'Show Page Marker on Pages On/Off', 'foodmood' ),
                'default'  => false,
            ),
            array(
                'id'       => 'page_marker_offset',
                'type'     => 'spacing',
                'mode'     => 'margin',
                'all'      => false,
                'bottom'   => false,
                'top'      => true,
                'left'     => false,
                'right'    => false,
                'title'    => esc_html__( 'Offset Top', 'foodmood' ),
                'desc'     => esc_html__( 'Measurement units defined as "percents" while position fixed is enabled, and as "pixels" while position is off.', 'foodmood' ),
                'default'  => array(
                    'margin-bottom' => '40%',
                ),
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'add_marker_1',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Marker 1', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'marker_image_1',
                'type'     => 'media',
                'title'    => esc_html__( 'Marker Image 1', 'foodmood' ),
                'required' => array( 'add_marker_1', '=', '1' ),
            ),
            array(
                'id'        => 'marker_color_1',
                'type'      => 'color',
                'title'     => esc_html__( 'Marker Color 1', 'foodmood' ),
                'required' => array( 'add_marker_1', '=', '1' ),
                'transparent' => false,
                'default'   => '#232323',
                'validate'  => 'color',
            ),
            array(
                'id'       => 'marker_link_1',
                'type'     => 'text',
                'title'    => esc_html__( 'Marker Link 1', 'foodmood' ),
                'required' => array( 'add_marker_1', '=', '1' ),
                'default'  => '#',
            ),
            array(
                'id'       => 'add_marker_2',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Marker 2', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'marker_image_2',
                'type'     => 'media',
                'title'    => esc_html__( 'Marker Image 2', 'foodmood' ),
                'required' => array( 'add_marker_2', '=', '1' ),
            ),
            array(
                'id'        => 'marker_color_2',
                'type'      => 'color',
                'title'     => esc_html__( 'Marker Color 2', 'foodmood' ),
                'required' => array( 'add_marker_2', '=', '1' ),
                'transparent' => false,
                'default'   => '#232323',
                'validate'  => 'color',
            ),
            array(
                'id'       => 'marker_link_2',
                'type'     => 'text',
                'title'    => esc_html__( 'Marker Link 2', 'foodmood' ),
                'required' => array( 'add_marker_2', '=', '1' ),
                'default'  => '#',
            ),
            array(
                'id'       => 'add_marker_3',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Marker 3', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'marker_image_3',
                'type'     => 'media',
                'title'    => esc_html__( 'Marker Image 3', 'foodmood' ),
                'required' => array( 'add_marker_3', '=', '1' ),
            ),
            array(
                'id'        => 'marker_color_3',
                'type'      => 'color',
                'title'     => esc_html__( 'Marker Color 3', 'foodmood' ),
                'required' => array( 'add_marker_3', '=', '1' ),
                'transparent' => false,
                'default'   => '#232323',
                'validate'  => 'color',
            ),
            array(
                'id'       => 'marker_link_3',
                'type'     => 'text',
                'title'    => esc_html__( 'Marker Link 3', 'foodmood' ),
                'required' => array( 'add_marker_3', '=', '1' ),
                'default'  => '#',
            ),
            array(
                'id'       => 'add_marker_4',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Marker 4', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'marker_image_4',
                'type'     => 'media',
                'title'    => esc_html__( 'Marker Image 4', 'foodmood' ),
                'required' => array( 'add_marker_4', '=', '1' ),
            ),
            array(
                'id'        => 'marker_color_4',
                'type'      => 'color',
                'title'     => esc_html__( 'Marker Color 4', 'foodmood' ),
                'required' => array( 'add_marker_4', '=', '1' ),
                'transparent' => false,
                'default'   => '#232323',
                'validate'  => 'color',
            ),
            array(
                'id'       => 'marker_link_4',
                'type'     => 'text',
                'title'    => esc_html__( 'Marker Link 4', 'foodmood' ),
                'required' => array( 'add_marker_4', '=', '1' ),
                'default'  => '#',
            ),
            array(
                'id'       => 'add_marker_5',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Marker 5', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'marker_image_5',
                'type'     => 'media',
                'title'    => esc_html__( 'Marker Image 5', 'foodmood' ),
                'required' => array( 'add_marker_5', '=', '1' ),
            ),
            array(
                'id'        => 'marker_color_5',
                'type'      => 'color',
                'title'     => esc_html__( 'Marker Color 5', 'foodmood' ),
                'required' => array( 'add_marker_5', '=', '1' ),
                'transparent' => false,
                'default'   => '#232323',
                'validate'  => 'color',
            ),
            array(
                'id'       => 'marker_link_5',
                'type'     => 'text',
                'title'    => esc_html__( 'Marker Link 5', 'foodmood' ),
                'required' => array( 'add_marker_5', '=', '1' ),
                'default'  => '#',
            ),
            array(
                'id'       => 'add_marker_6',
                'type'     => 'switch',
                'title'    => esc_html__( 'Add Marker 6', 'foodmood' ),
                'default'  => false,
                'required' => array( 'show_page_marker', '=', '1' ),
            ),
            array(
                'id'       => 'marker_image_6',
                'type'     => 'media',
                'title'    => esc_html__( 'Marker Image 6', 'foodmood' ),
                'required' => array( 'add_marker_6', '=', '1' ),
            ),
            array(
                'id'        => 'marker_color_6',
                'type'      => 'color',
                'title'     => esc_html__( 'Marker Color 6', 'foodmood' ),
                'required' => array( 'add_marker_6', '=', '1' ),
                'transparent' => false,
                'default'   => '#232323',
                'validate'  => 'color',
            ),
            array(
                'id'       => 'marker_link_6',
                'type'     => 'text',
                'title'    => esc_html__( 'Marker Link 6', 'foodmood' ),
                'required' => array( 'add_marker_6', '=', '1' ),
                'default'  => '#',
            ),
        )
    ) );

    // -> START Styling Options
    Redux::setSection( $theme_slug, array(
        'title'            => esc_html__( 'Color Options', 'foodmood' ),
        'id'               => 'color_options_color',
        'icon'             => 'el-icon-tint',
        'fields'           => array(
            array(
                'id'        => 'theme-custom-color',
                'type'      => 'color',
                'title'     => esc_html__( 'General Theme Color', 'foodmood' ),
                'transparent' => false,
                'default'   => '#f7b035',
                'validate'  => 'color',
            ),
            array(
                'id'        => 'body-background-color',
                'type'      => 'color',
                'title'     => esc_html__( 'Body Background Color', 'foodmood' ),
                'transparent' => false,
                'default'   => '#ffffff',
                'validate'  => 'color',
            ),
        )
    ));

    // Start Typography config
    Redux::setSection( $theme_slug, array(
        'title' => esc_html__( 'Typography', 'foodmood' ),
        'id'    => 'Typography',
        'icon'  => 'el-icon-font', // Icon for section
    ) );

    $typography = array();
    $main_typography = array(
        array(
            'id'          => 'main-font',
            'title'       => esc_html__( 'Content Font', 'foodmood' ),
            'color'       => true,
            'line-height' => true,
            'font-size'   => true,
            'subsets'     => false,
            'all_styles'  => true,
            'font-weight-multi' => true,
            'defs' => array(
                'font-size'   => '16px',
                'line-height' => '30px',
                'color'       => '#616161',
                'font-family' => 'Open Sans',
                'font-weight' => '400',
                'font-weight-multi' => '600,700',
            ),
        ),
        array(
            'id'          => 'additional-font',
            'title'       => esc_html__( 'Additional Font', 'foodmood' ),
            'color'       => true,
            'line-height' => true,
            'font-size'   => true,
            'subsets'     => false,
            'all_styles'  => true,
            'font-weight-multi' => true,
            'defs' => array(
                'font-size'   => '16px',
                'line-height' => '30px',
                'color'       => '#232323',
                'font-family' => 'Delius Unicase',
                'font-weight' => '700',
                'font-weight-multi' => '400,700',
            ),
        ),
        array(
            'id'          => 'header-font',
            'title'       => esc_html__( 'Headings Main Settings', 'foodmood' ),
            'font-size'   => false,
            'line-height' => false,
            'color'       => true,
            'subsets'     => false,
            'all_styles'  => true,
            'font-weight-multi' => true,
            'defs' => array(
                'color'       => '#232323',
                'google'      => true,
                'font-family' => 'Rubik',
                'font-weight' => '700',
                'font-weight-multi' => '300,400,500,600,900',
            ),
        ),


    );
    foreach ($main_typography as $key => $value) {
        array_push($typography , array(
            'id'          => $value['id'],
            'type'        => 'custom_typography',
            'title'       => $value['title'],
            'color'       => $value['color'],
            'line-height' => $value['line-height'],
            'font-size'   => $value['font-size'],
            'subsets'     => $value['subsets'],
            'all_styles'  => $value['all_styles'],
            'font-weight-multi' => isset($value['font-weight-multi']) ? $value['font-weight-multi'] : '',
            'subtitle'    => isset($value['subtitle']) ? $value['subtitle'] : '',
            'google'      => true,
            'font-style'  => true,
            'font-backup' => false,
            'text-align'  => false,
            'default'     => $value['defs'],
        ));
    }
    Redux::setSection( $theme_slug, array(
        'title'       => esc_html__( 'Main Content', 'foodmood' ),
        'id'          => 'main_typography',
        //'icon' => 'el-icon-font', // Icon for section
        'subsection'  => true,
        'fields'      => $typography
    ) );

    // Start menu typography
    $menu_typography = array(
        array(
            'id'          => 'menu-font',
            'title'       => esc_html__( 'Menu Font', 'foodmood' ),
            'color'       => false,
            'line-height' => true,
            'font-size'   => true,
            'subsets'     => true,
            'defs' => array(
                'font-family' => 'Rubik',
                'google'      => true,
                'font-size'   => '17px',
                'font-weight' => '500',
                'line-height' => '30px'
            ),
        ),
        array(
            'id'          => 'sub-menu-font',
            'title'       => esc_html__( 'Submenu Font', 'foodmood' ),
            'color'       => false,
            'line-height' => true,
            'font-size'   => true,
            'subsets'     => true,
            'defs' => array(
                'font-family' => 'Rubik',
                'google'      => true,
                'font-size'   => '16px',
                'font-weight' => '500',
                'line-height' => '30px'
            ),
        ),
    );
    $menu_typography_array = array();
    foreach ($menu_typography as $key => $value) {
        array_push($menu_typography_array , array(
            'id'          => $value['id'],
            'type'        => 'custom_typography',
            'title'       => $value['title'],
            'color'       => $value['color'],
            'line-height' => $value['line-height'],
            'font-size'   => $value['font-size'],
            'subsets'     => $value['subsets'],
            'google'      => true,
            'font-style'  => true,
            'font-backup' => false,
            'text-align'  => false,
            'all_styles'  => false,
            'default'     => $value['defs'],
        ));
    }
    Redux::setSection( $theme_slug, array(
        'title'      => esc_html__( 'Menu', 'foodmood' ),
        'id'         => 'main_menu_typography',
        //'icon' => 'el-icon-font', // Icon for section
        'subsection' => true,
        'fields'     => $menu_typography_array
    ) );
    // End menu Typography

    // Start headings typography
    $headings = array(
        array(
            'id'    => 'header-h1',
            'title' => esc_html__( 'H1', 'foodmood' ),
            'defs'  => array(
                'font-family' => 'Rubik',
                'font-size'   => '46px',
                'line-height' => '56px',
                'font-weight' => '700',
            ),
        ),
        array(
            'id' => 'header-h2',
            'title' => esc_html__( 'H2', 'foodmood' ),
            'defs' => array(
                'font-family' => 'Rubik',
                'font-size'   => '42px',
                'line-height' => '52px',
                'font-weight' => '700',
            ),
        ),
        array(
            'id' => 'header-h3',
            'title' => esc_html__( 'H3', 'foodmood' ),
            'defs' => array(
                'font-family' => 'Rubik',
                'font-weight' => '700',
                'font-size'   => '36px',
                'line-height' => '48px',
            ),
        ),
        array(
            'id' => 'header-h4',
            'title' => esc_html__( 'H4', 'foodmood' ),
            'defs' => array(
                'font-family' => 'Rubik',
                'font-size'   => '30px',
                'line-height' => '42px',
                'font-weight' => '700',
            ),
        ),
        array(
            'id' => 'header-h5',
            'title' => esc_html__( 'H5', 'foodmood' ),
            'defs' => array(
                'font-family' => 'Rubik',
                'font-size'   => '24px',
                'line-height' => '36px',
                'font-weight' => '700'
            ),
        ),
        array(
            'id' => 'header-h6',
            'title' => esc_html__( 'H6', 'foodmood' ),
            'defs' => array(
                'font-family' => 'Rubik',
                'font-size'   => '22px',
                'line-height' => '32px',
                'font-weight' => '700',
            ),
        ),
    );
    $headings_array = array();
    foreach ($headings as $key => $heading) {
        array_push($headings_array , array(
            'id' => $heading['id'],
            'type' => 'custom_typography',
            'title' => $heading['title'],
            'google' => true,
            'font-backup' => false,
            'font-size' => true,
            'line-height' => true,
            'color' => false,
            'word-spacing' => false,
            'letter-spacing' => true,
            'text-align' => false,
            'text-transform' => true,
            'default' => $heading['defs'],
        ));
    }

    // Typogrophy section
    Redux::setSection( $theme_slug, array(
        'title'      => esc_html__( 'Headings', 'foodmood' ),
        'id'         => 'main_headings_typography',
        //'icon' => 'el-icon-font', // Icon for section
        'subsection' => true,
        'fields'     => $headings_array
    ) );
    // End Typography config

	if ( class_exists( 'WooCommerce' ) )  {
        Redux::setSection( $theme_slug, array(
            'title'            => esc_html__('Shop', 'foodmood' ),
            'id'               => 'shop-option',
            'icon' => 'el-icon-shopping-cart',
            'fields'           => array(
            )
        ) );
        Redux::setSection( $theme_slug, array(
            'title'            => esc_html__( 'Catalog', 'foodmood' ),
            'id'               => 'shop-catalog-option',
            'subsection'       => true,
            'fields'           => array(
                array(
                    'id'       => 'shop_catalog_page_title_bg_image',
                    'type'     => 'background',
                    'preview'  => false,
                    'preview_media' => true,
                    'background-color' => false,
                    'title'    => esc_html__( 'Catalog Page Title Background Image', 'foodmood' ),
                    'default'  => array(
                        'background-repeat'     => 'repeat',
                        'background-size'       => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position'   => 'center center',
                        'background-color'      => '#1e73be',
                    )
                ),
                array(
                    'id'       => 'shop_catalog_sidebar_layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shop Catalog Sidebar Layout', 'foodmood' ),
                    'options'  => array(
                        'none' => array(
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ),
                        'left' => array(
                            'alt' => 'Left',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ),
                        'right' => array(
                            'alt' => 'Right',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        )
                    ),
                    'default'  => 'left'
                ),
                array(
                    'id'       => 'shop_catalog_sidebar_def',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Shop Catalog Sidebar', 'foodmood' ),
                    'data'     => 'sidebars',
                    'required' => array( 'shop_catalog_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'       => 'shop_catalog_sidebar_def_width',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Shop Sidebar Width', 'foodmood' ),
                    'options'  => array(
                        '9' => '25%',
                        '8' => '33%',
                    ),
                    'default'  => '9',
                    'required' => array( 'shop_catalog_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'       => 'shop_catalog_sidebar_sticky',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Sticky Sidebar On?', 'foodmood' ),
                    'default'  => false,
                    'required' => array( 'shop_catalog_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'       => 'shop_catalog_sidebar_gap',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Sidebar Side Gap', 'foodmood' ),
                    'options'  => array(
                        'def' => esc_html__( 'Default', 'foodmood' ),
                        '0'  => '0',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                        '30' => '30',
                        '35' => '35',
                        '40' => '40',
                        '45' => '45',
                        '50' => '50',
                    ),
                    'default'  => 'def',
                    'required' => array( 'shop_catalog_sidebar_layout', '!=', 'none' ),
                ),


                array(
                    'id'       => 'shop_catalog_display-start',
                    'type'     => 'section',
                    'title'    => esc_html__( 'Display Settings', 'foodmood' ),
                    'indent'   => true,
                ),

                array(
                    'id'       => 'shop_column',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Shop Column', 'foodmood' ),
                    'options'  => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4'
                    ),
                    'default'  => '3',
                ),

                array(
                    'id'       => 'shop_catalog_hide_price',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Hide Price?', 'foodmood' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'shop_catalog_hide_raiting',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Hide Raiting?', 'foodmood' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'shop_catalog_hide_content',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Hide Content?', 'foodmood' ),
                    'default'  => false,
                ),
                array(
                    'id'       => 'shop_catalog_listing_content',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Cut Off Text in Shop Products', 'foodmood' ),
                    'default'  => true,
                ),
                array(
                    'id'       => 'shop_catalog_letter_count',
                    'type'     => 'text',
                    'title'    => esc_html__( 'Number of character to show after trim.', 'foodmood'),
                    'default'  => '60',
                    'required' => array( 'shop_catalog_listing_content', '=', true ),
                ),

                array(
                    'id'       => 'shop_products_per_page',
                    'type'     => 'spinner',
                    'title'    => esc_html__('Products per page', 'foodmood'),
                    'default'  => '12',
                    'min'      => '1',
                    'step'     => '1',
                    'max'      => '100',
                ),
                array(
                    'id'       => 'use_animation_shop',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Use Animation Shop?', 'foodmood' ),
                    'default'  => true,
                ),
                array(
                    'id'      => 'shop_catalog_animation_style',
                    'type'    => 'select',
                    'select2' => array('allowClear' => false),
                    'title'   => esc_html__( 'Animation Style', 'foodmood' ),
                    'options' => array(
                        'fade-in'      => esc_html__( 'Fade In', 'foodmood'),
                        'slide-top'    => esc_html__( 'Slide Top', 'foodmood'),
                        'slide-bottom' => esc_html__( 'Slide Bottom', 'foodmood'),
                        'slide-left'   => esc_html__( 'Slide Left', 'foodmood'),
                        'slide-right'  => esc_html__( 'Slide Right', 'foodmood'),
                        'zoom'         => esc_html__( 'Zoom', 'foodmood'),
                    ),
                    'default'  => 'slide-left',
                    'required' => array( 'use_animation_shop', '=', true ),
                ),

                array(
                    'id'     => 'shop_catalog_display-end',
                    'type'   => 'section',
                    'indent' => false,
                ),
            )

        ) );
		Redux::setSection( $theme_slug, array(
			'title'      => esc_html__( 'Single', 'foodmood' ),
			'id'         => 'shop-single-option',
			'subsection' => true,
			'fields'     => array(
				array(
					'id'       => 'shop_single_post_title-start',
					'type'     => 'section',
					'title'    => esc_html__( 'Post Title Settings', 'foodmood' ),
					'indent'   => true,
				),
				array(
					'id'      => 'shop_title_conditional',
					'type'    => 'switch',
					'title'   => esc_html__( 'Use Custom Post Title?', 'foodmood' ),
					'default' => true,
				),
				array(
					'id'       => 'shop_single_page_title_text',
					'type'     => 'text',
					'title'    => esc_html__( 'Custom Post Title', 'foodmood' ),
					'default'  => esc_html__( '', 'foodmood' ),
					'required' => array( 'shop_title_conditional', '=', true ),
				),
				array(
					'id'      => 'shop_single_title_align',
					'type'    => 'button_set',
					'title'   => esc_html__( 'Title Alignment', 'foodmood' ),
					'options' => array(
						'left'   => esc_html__( 'Left', 'foodmood' ),
						'center' => esc_html__( 'Center', 'foodmood' ),
						'right'  => esc_html__( 'Right', 'foodmood' ),
					),
					'default' => 'center',
				),
                array(
                    'id'      => 'shop_single_breadcrumbs_block_switch',
                    'type'    => 'switch',
                    'title'   => esc_html__( 'Breadcrumbs Display', 'foodmood' ),
                    'on'      => 'Block',
                    'off'     => 'Inline',
                    'default' => true,
                    'required' => [ 'page_title_breadcrumbs_switch', '=', true ],
                ),
                array(
                    'id'      => 'shop_single_breadcrumbs_align',
                    'type'    => 'button_set',
                    'title'   => esc_html__( 'Title Breadcrumbs Alignment', 'foodmood' ),
                    'options' => array(
                        'left'   => esc_html__( 'Left', 'foodmood' ),
                        'center' => esc_html__( 'Center', 'foodmood' ),
                        'right'  => esc_html__( 'Right', 'foodmood' ),
                    ),
                    'default' => 'center',
                    'required' => [
                        [ 'page_title_breadcrumbs_switch', '=', true ],
                        [ 'shop_single_breadcrumbs_block_switch', '=', true ]
                    ],
                ),
				array(
					'id'      => 'shop_single_title_bg_switch',
					'type'    => 'switch',
					'title'   => esc_html__( 'Use Background?', 'foodmood' ),
					'default' => true,
				),
				array(
					'id'      => 'shop_single_page_title_bg_image',
					'type'    => 'background',
					'title'   => esc_html__( 'Background', 'foodmood' ),
					'preview' => false,
					'preview_media' => true,
					'background-color' => true,
					'transparent' => false,
					'default' => array(
						'background-repeat'     => 'repeat',
						'background-size'       => 'cover',
						'background-attachment' => 'scroll',
						'background-position'   => 'center center',
						'background-color'      => '#f6f7f8',
					),
					'required' => array( 'shop_single_title_bg_switch', '=', true ),
				),
				array(
					'id'      => 'shop_single_page_title_padding',
					'type'    => 'spacing',
					'title'   => esc_html__( 'Paddings Top/Bottom', 'foodmood' ),
					'mode'    => 'padding',
					'all'     => false,
					'bottom'  => true,
					'top'     => true,
					'left'    => false,
					'right'   => false,
					'default' => array(
						'padding-top'    => '116',
						'padding-bottom' => '126',
					),
				),
				array(
					'id'      => 'shop_single_page_title_margin',
					'type'    => 'spacing',
					'title'   => esc_html__( 'Margin Bottom', 'foodmood' ),
					'mode'    => 'margin',
					'all'     => false,
					'bottom'  => true,
					'top'     => false,
					'left'    => false,
					'right'   => false,
					'default' => array( 'margin-bottom' => '40' ),
				),
				array(
					'id'      => 'shop_single_page_title_border_switch',
					'type'    => 'switch',
					'title'   => esc_html__( 'Enable Border Top?', 'foodmood' ),
					'default' => false,
				),
				array(
					'id'       => 'shop_single_page_title_border_color',
					'type'     => 'color_rgba',
					'title'    => esc_html__( 'Border Top Color', 'foodmood' ),
					'default'  => array(
						'color' => '#e5e5e5',
						'alpha' => '1',
                        'rgba'  => 'rgba(229,229,229,1)'
					),
					'required' => array( 'shop_single_page_title_border_switch', '=', true),
				),
				array(
					'id'     => 'shop_single_post_title-end',
					'type'   => 'section',
					'indent' => false,
				),
                array(
                    'id'      => 'shop_single_image_layout',
                    'type'    => 'image_select',
                    'title'   => esc_html__( 'Select Single Product Layout', 'foodmood' ),
                    'options' => array(
                        'default' => array(
                            'title' => esc_html__('Default', 'foodmood'),
                            'alt' => 'Default',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ),
                        'sticky_layout' => array(
                            'title' => esc_html__('Sticky Image', 'foodmood'),
                            'alt'   => '1',
                            'img'   => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ),
                        'image_gallery' => array(
                            'title' => esc_html__('Image Gallery', 'foodmood'),
                            'alt'   => '2',
                            'img'   => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ),
                        'full_width_image_gallery' => array(
                            'title' => esc_html__('Full Width Image Gallery', 'foodmood'),
                            'alt'   => '3',
                            'img'   => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ),
                        'with_background' => array(
                            'title' => esc_html__('With Background', 'foodmood'),
                            'alt'   => '4',
                            'img'   => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        ),
                    ),
                    'default'  => 'default'
                ),
                array(
                    'id'       => 'shop_single_sidebar_layout',
                    'type'     => 'image_select',
                    'title'    => esc_html__( 'Shop Single Sidebar Layout', 'foodmood' ),
                    'options'  => array(
                        'none' => array(
                            'alt' => 'None',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/1col.png'
                        ),
                        'left' => array(
                            'alt' => 'Left',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cl.png'
                        ),
                        'right' => array(
                            'alt' => 'Right',
                            'img' => get_template_directory_uri() . '/core/admin/img/options/2cr.png'
                        )
                    ),
                    'default'  => 'none',
                    'required' => array( array('shop_single_image_layout','!=','with_background'), array('shop_single_image_layout','!=','full_width_image_gallery') )
                ),
                array(
                    'id'       => 'shop_single_sidebar_def',
                    'type'     => 'select',
                    'title'    => esc_html__( 'Shop Single Sidebar', 'foodmood' ),
                    'data'     => 'sidebars',
                    'required' => array( 'shop_single_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'       => 'shop_single_sidebar_def_width',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Shop Single Sidebar Width', 'foodmood' ),
                    'options'  => array(
                        '9' => '25%',
                        '8' => '33%',
                    ),
                    'default'  => '9',
                    'required' => array( 'shop_single_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'       => 'shop_single_sidebar_sticky',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Shop Single Sticky Sidebar On?', 'foodmood' ),
                    'default'  => false,
                    'required' => array( 'shop_single_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'      => 'shop_single_sidebar_gap',
                    'type'    => 'select',
                    'title'   => esc_html__( 'Shop Single Sidebar Side Gap', 'foodmood' ),
                    'options' => array(
                        'def' => esc_html__( 'Default', 'foodmood' ),
                        '0'  => '0',
                        '15' => '15',
                        '20' => '20',
                        '25' => '25',
                        '30' => '30',
                        '35' => '35',
                        '40' => '40',
                        '45' => '45',
                        '50' => '50',
                    ),
                    'default'  => 'def',
                    'required' => array( 'shop_single_sidebar_layout', '!=', 'none' ),
                ),
                array(
                    'id'       => 'shop_layout_with_background',
                    'type'     => 'color_rgba',
                    'title'    => esc_html__( 'Background', 'foodmood' ),
                    'default'  => array(
                        'color' => '#f3f3f3',
                        'alpha' => '1',
                        'rgba'  => 'rgba(243,243,243,1)'
                    ),
                    'mode'     => 'background',
                    'required' => array( 'shop_single_image_layout', '=', 'with_background' ),
                ),
                array(
                    'id'       => 'shop_single_share',
                    'type'     => 'switch',
                    'title'    => esc_html__( 'Share On/Off', 'foodmood' ),
                    'default'  => false,
                ),
            )

        ) );
        Redux::setSection( $theme_slug, array(
            'title'            => esc_html__( 'Related', 'foodmood' ),
            'id'               => 'shop-related-option',
            'subsection'       => true,
            'fields'           => array(
                array(
                    'id'       => 'shop_related_columns',
                    'type'     => 'button_set',
                    'title'    => esc_html__( 'Related products column', 'foodmood' ),
                    'options'  => array(
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4'
                    ),
                    'default'  => '4',
                ),
                array(
                    'id'       => 'shop_r_products_per_page',
                    'type'     => 'spinner',
                    'title'    => esc_html__('Related products per page', 'foodmood'),
                    'default'  => '4',
                    'min'      => '1',
                    'step'     => '1',
                    'max'      => '100',
                ),
            )

        ) );
        Redux::setSection( $theme_slug, array(
            'title'            => esc_html__( 'Cart', 'foodmood' ),
            'id'               => 'shop-cart-option',
            'subsection'       => true,
            'fields'           => array(
                array(
                    'id'       => 'shop_cart_page_title_bg_image',
                    'type'     => 'background',
                    'background-color' => false,
                    'preview_media' => true,
                    'preview' => false,
                    'title'    => esc_html__( 'Cart Page Title Background Image', 'foodmood' ),
                    'default'  => array(
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '#f6f7f8',
                    )
                ),
            )

        ) );
        Redux::setSection( $theme_slug, array(
            'title'            => esc_html__( 'Checkout', 'foodmood' ),
            'id'               => 'shop-checkout-option',
            'subsection'       => true,
            'fields'           => array(
                array(
                    'id'       => 'shop_checkout_page_title_bg_image',
                    'type'     => 'background',
                    'background-color' => false,
                    'preview_media' => true,
                    'preview' => false,
                    'title'    => esc_html__( 'Checkout Page Title Background Image', 'foodmood' ),
                    'default'  => array(
                        'background-repeat' => 'repeat',
                        'background-size' => 'cover',
                        'background-attachment' => 'scroll',
                        'background-position' => 'center center',
                        'background-color' => '#f6f7f8',
                    )
                ),
            )

        ) );
    }
