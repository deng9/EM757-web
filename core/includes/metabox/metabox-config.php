<?php 


if (!class_exists( 'RWMB_Loader' )) {
	return;
}
class Foodmood_Metaboxes{
	public function __construct(){
		// Team Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'team_meta_boxes' ) );

		// Portfolio Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'portfolio_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'portfolio_post_settings_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'portfolio_related_meta_boxes' ) );

		// Blog Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'blog_settings_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'blog_meta_boxes' ) );
		add_filter( 'rwmb_meta_boxes', array( $this, 'blog_related_meta_boxes' ));
		
		// Page Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_layout_meta_boxes' ) );
		// Colors Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_color_meta_boxes' ) );		
		// Logo Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_logo_meta_boxes' ) );		
		// Header Builder Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_header_meta_boxes' ) );
		// Title Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_title_meta_boxes' ) );
		// Side Panel Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_side_panel_meta_boxes' ) );		

		// Social Shares Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_soc_icons_meta_boxes' ) );	
		// Page Markers Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_markers_meta_boxes' ) );	
		// Footer Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_footer_meta_boxes' ) );				
		// Copyright Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'page_copyright_meta_boxes' ) );		

		// Shop Single Fields Metaboxes
		add_filter( 'rwmb_meta_boxes', array( $this, 'shop_catalog_meta_boxes' ) );		
		add_filter( 'rwmb_meta_boxes', array( $this, 'shop_single_meta_boxes' ) );		
	}

	public function team_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Team Options', 'foodmood' ),
	        'post_types' => array( 'team' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
		            'name' => esc_html__( 'Info Name Department', 'foodmood' ),
		            'id'   => 'department_name',
		            'type' => 'text',
		            'class' => 'name-field'
		        ),       
	        	array(
		            'name' => esc_html__( 'Member Department', 'foodmood' ),
		            'id'   => 'department',
		            'type' => 'text',
		            'class' => 'field-inputs'
				),
				array(
					'name' => esc_html__( 'Member Info', 'foodmood' ),
		            'id'   => 'info_items',
		            'type' => 'social',
		            'clone' => true,
		            'sort_clone'     => true,
		            'options' => array(
						'name'    => array(
							'name' => esc_html__( 'Name', 'foodmood' ),
							'type_input' => 'text'
						),
						'description' => array(
							'name' => esc_html__( 'Description', 'foodmood' ),
							'type_input' => 'text'
						),
						'link' => array(
							'name' => esc_html__( 'Link', 'foodmood' ),
							'type_input' => 'text'
						),
					),
		        ),		
		        array(
					'name'     => esc_html__( 'Social Icons', 'foodmood' ),
					'id'          => "soc_icon",
					'type'        => 'select_icon',
					'options'     => WglAdminIcon()->get_icons_name(),
					'clone' => true,
					'sort_clone'     => true,
					'placeholder' => esc_html__( 'Select an icon', 'foodmood' ),
					'multiple'    => false,
					'std'         => 'default',
				),
		        array(
					'name'             => esc_html__( 'Info Background Image', 'foodmood' ),
					'id'               => "mb_info_bg",
					'type'             => 'file_advanced',
					'max_file_uploads' => 1,
					'mime_type'        => 'image',
				), 
	        ),
	    );
	    return $meta_boxes;
	}
	
	public function portfolio_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Portfolio Options', 'foodmood' ),
	        'post_types' => array( 'portfolio' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
					'id'   => 'mb_portfolio_featured_img',
					'name' => esc_html__( 'Show Featured image on single', 'foodmood' ),
					'type' => 'switch',
					'std'  => 'true',
				),        	
				array(
					'id'   => 'mb_portfolio_title',
					'name' => esc_html__( 'Show Title on single', 'foodmood' ),
					'type' => 'switch',
					'std'  => 'true',
				),	
				array(
					'id'   => 'mb_portfolio_link',
					'name' => esc_html__( 'Add Custom Link for Portfolio Grid', 'foodmood' ),
					'type' => 'switch',
				),
				array(
                    'name' => esc_html__( 'Custom Url for Portfolio Grid', 'foodmood' ),
                    'id'   => 'portfolio_custom_url',
                    'type' => 'text',
					'class' => 'field-inputs',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_portfolio_link','=','1')
						), ),
					),
                ),
                array(
                    'id'   => 'portfolio_custom_url_target',
                    'name' => esc_html__( 'Open Custom Url in New Window', 'foodmood' ),
                    'type' => 'switch',
                    'std' => 'true',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_portfolio_link','=','1')
						), ),
					),
                ),
				array(
					'name' => esc_html__( 'Info', 'foodmood' ),
					'id'   => 'mb_portfolio_info_items',
					'type' => 'social',
					'clone' => true,
					'sort_clone' => true,
					'desc' => esc_html__( 'Description', 'foodmood' ),
					'options' => array(
						'name'    => array(
							'name' => esc_html__( 'Name', 'foodmood' ),
							'type_input' => 'text'
							),
						'description' => array(
							'name' => esc_html__( 'Description', 'foodmood' ),
							'type_input' => 'text'
							),
						'link' => array(
							'name' => esc_html__( 'Url', 'foodmood' ),
							'type_input' => 'text'
							),
					),
		        ),		
		        array(
					'name'     => esc_html__( 'Info Description', 'foodmood' ),
					'id'       => "mb_portfolio_editor",
					'type'     => 'wysiwyg',
					'multiple' => false,
					'desc' => esc_html__( 'Info description is shown in one row with a main info', 'foodmood' ),
				),			
		        array(
					'name'     => esc_html__( 'Categories On/Off', 'foodmood' ),
					'id'       => "mb_portfolio_single_meta_categories",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'yes'     => esc_html__( 'On', 'foodmood' ),
						'no'      => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),			
		        array(
					'name'     => esc_html__( 'Date On/Off', 'foodmood' ),
					'id'       => "mb_portfolio_single_meta_date",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'yes'     => esc_html__( 'On', 'foodmood' ),
						'no'      => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),			
		        array(
					'name'     => esc_html__( 'Tags On/Off', 'foodmood' ),
					'id'       => "mb_portfolio_above_content_cats",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'yes'     => esc_html__( 'On', 'foodmood' ),
						'no'      => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),		
		        array(
					'name'     => esc_html__( 'Share Links On/Off', 'foodmood' ),
					'id'       => "mb_portfolio_above_content_share",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'yes'     => esc_html__( 'On', 'foodmood' ),
						'no'      => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),	
	        ),
	    );
	    return $meta_boxes;
	}

	public function portfolio_post_settings_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Portfolio Post Settings', 'foodmood' ),
	        'post_types' => array( 'portfolio' ),
	        'context'    => 'advanced',
	        'fields'     => array(
				array(
					'name'     => esc_html__( 'Post Layout', 'foodmood' ),
					'id'       => "mb_portfolio_post_conditional",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom'  => esc_html__( 'Custom', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),        
				array(
					'name'     => esc_html__( 'Post Layout Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_post_conditional','=','custom')
						)),
					),
				),
				array(
					'name'    => esc_html__( 'Post Content Layout', 'foodmood' ),
					'id'      => "mb_portfolio_single_type_layout",
					'type'    => 'button_group',
					'options' => array(
						'1' => esc_html__( 'Title First', 'foodmood' ),
						'2' => esc_html__( 'Image First', 'foodmood' ),
						'3' => esc_html__( 'Overlay Image', 'foodmood' ),
						'4' => esc_html__( 'Overlay Image with Info', 'foodmood' ),
					),
					'multiple'   => false,
					'std'        => '1',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_portfolio_post_conditional','=','custom')
						), ),
					),
				), 
				array(
					'name'     => esc_html__( 'Alignment', 'foodmood' ),
					'id'       => "mb_portfolio_single_align",
					'type'     => 'button_group',
					'options'  => array(
						'left' => esc_html__( 'Left', 'foodmood' ),
						'center' => esc_html__( 'Center', 'foodmood' ),
						'right' => esc_html__( 'Right', 'foodmood' ),
					),
					'multiple'   => false,
					'std'        => 'left',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_portfolio_post_conditional','=','custom')
						), ),
					),
				), 
				array(
					'name' => esc_html__( 'Spacing', 'foodmood' ),
					'id'   => 'mb_portfolio_single_padding',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_post_conditional','=','custom'),
							array('mb_portfolio_single_type_layout','!=','1'),
							array('mb_portfolio_single_type_layout','!=','2'),
						)),
					),
					'std' => array(
						'padding-top' => '165',
						'padding-bottom' => '165'
					)
				),
				array(
					'id'   => 'mb_portfolio_parallax',
					'name' => esc_html__( 'Add Portfolio Parallax', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_post_conditional','=','custom'),
							array('mb_portfolio_single_type_layout','!=','1'),
							array('mb_portfolio_single_type_layout','!=','2'),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Prallax Speed', 'foodmood' ),
					'id'   => "mb_portfolio_parallax_speed",
					'type' => 'number',
					'std'  => 0.3,
					'step' => 0.1,
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_post_conditional','=','custom'),
							array('mb_portfolio_single_type_layout','!=','1'),
							array('mb_portfolio_single_type_layout','!=','2'),
							array('mb_portfolio_parallax','=',true),
						)),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function portfolio_related_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Related Portfolio', 'foodmood' ),
	        'post_types' => array( 'portfolio' ),
	        'context'    => 'advanced',
	        'fields'     => array(
				array(
					'id'      => 'mb_portfolio_related_switch',
					'name'    => esc_html__( 'Portfolio Related', 'foodmood' ),
					'type'    => 'button_group',
					'options' => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'on' => esc_html__( 'On', 'foodmood' ),
						'off' => esc_html__( 'Off', 'foodmood' ),
					),
					'inline'   => true,
					'multiple' => false,
					'std'      => 'default'
				),
				array(
					'name'     => esc_html__( 'Portfolio Related Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_related_switch','=','on')
						)),
					),
				),
	        	array(
					'id'   => 'mb_pf_carousel_r',
					'name' => esc_html__( 'Display items carousel for this portfolio post', 'foodmood' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_related_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Title', 'foodmood' ),
					'id'   => "mb_pf_title_r",
					'type' => 'text',
					'std'  => esc_html__( 'Related Portfolio', 'foodmood' ),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_related_switch','=','on')
						)),
					),
				), 			
				array(
					'name' => esc_html__( 'Categories', 'foodmood' ),
					'id'   => "mb_pf_cat_r",
					'multiple'    => true,
					'type' => 'taxonomy_advanced',
					'taxonomy' => 'portfolio-category',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_related_switch','=','on')
						)),
					),
				),     
				array(
					'name'    => esc_html__( 'Columns', 'foodmood' ),
					'id'      => "mb_pf_column_r",
					'type'    => 'button_group',
					'options' => array(
						'2' => esc_html__( '2', 'foodmood' ),
						'3' => esc_html__( '3', 'foodmood' ),
						'4' => esc_html__( '4', 'foodmood' ),
					),
					'multiple'   => false,
					'std'        => '3',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_related_switch','=','on')
						)),
					),
				),  
				array(
					'name' => esc_html__( 'Number of Related Items', 'foodmood' ),
					'id'   => "mb_pf_number_r",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 3,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_portfolio_related_switch','=','on')
						)),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function blog_settings_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Post Settings', 'foodmood' ),
	        'post_types' => array( 'post' ),
	        'context'    => 'advanced',
	        'fields'     => array(       
				array(
					'name'     => esc_html__( 'Post Layout Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
				),
				array(
					'name'    => esc_html__( 'Post Layout', 'foodmood' ),
					'id'      => "mb_post_layout_conditional",
					'type'    => 'button_group',
					'options' => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom'  => esc_html__( 'Custom', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),   	    
				array(
					'name'    => esc_html__( 'Post Layout Type', 'foodmood' ),
					'id'      => "mb_single_type_layout",
					'type'    => 'button_group',
					'options' => array(
						'1' => esc_html__( 'Title First', 'foodmood' ),
						'2' => esc_html__( 'Image First', 'foodmood' ),
						'3' => esc_html__( 'Overlay Image', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => '1',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_post_layout_conditional','=','custom')
							),
						),
					),
				), 
				array(
					'name' => esc_html__( 'Spacing', 'foodmood' ),
					'id'   => 'mb_single_padding_layout_3',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_post_layout_conditional','=','custom'),
							array('mb_single_type_layout','=','3'),
						)),
					),
					'std' => array(
						'padding-top' => '120',
						'padding-bottom' => '0'
					)
				),
				array(
					'id'   => 'mb_single_apply_animation',
					'name' => esc_html__( 'Apply Animation', 'foodmood' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_post_layout_conditional','=','custom'),
							array('mb_single_type_layout','=','3'),
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Featured Image Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
				),  
				array(
					'name'    => esc_html__( 'Featured Image', 'foodmood' ),
					'id'      => "mb_featured_image_conditional",
					'type'    => 'button_group',
					'options' => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom'  => esc_html__( 'Custom', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				), 
				array(
					'name'    => esc_html__( 'Featured Image Settings', 'foodmood' ),
					'id'      => "mb_featured_image_type",
					'type'    => 'button_group',
					'options' => array(
						'off'  => esc_html__( 'Off', 'foodmood' ),
						'replace'  => esc_html__( 'Replace', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'off',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_featured_image_conditional','=','custom')
							),
						),
					),
				),
				array(
					'name' => esc_html__( 'Featured Image Replace', 'foodmood' ),
					'id'   => "mb_featured_image_replace",
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_featured_image_conditional','=','custom'),
							array( 'mb_featured_image_type', '=', 'replace' ),
						)),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function blog_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'title'      => esc_html__( 'Post Format Layout', 'foodmood' ),
			'post_types' => array( 'post' ),
			'context'    => 'advanced',
			'fields'     => array(
				// Standard Post Format
				array(
					'name'  => esc_html__( 'Standard Post( Enabled only Featured Image for this post format)', 'foodmood' ),
					'id'    => "post_format_standard",
					'type'  => 'static-text',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('formatdiv','=','0')
						), ),
					),
				),
				// Gallery Post Format  
				array(
					'name'  => esc_html__( 'Gallery Settings', 'foodmood' ),
					'type'  => 'wgl_heading',
				),  
				array(
					'name'  => esc_html__( 'Add Images', 'foodmood' ),
					'id'    => "post_format_gallery",
					'type'  => 'image_advanced',
					'max_file_uploads' => '',
				),
				// Video Post Format
				array(
					'name' => esc_html__( 'Video Settings', 'foodmood' ),
					'type' => 'wgl_heading',
				), 
				array(
					'name' => esc_html__( 'Video Style', 'foodmood' ),
					'id'   => "post_format_video_style",
					'type' => 'select',
					'options' => array(
						'bg_video' => esc_html__( 'Background Video', 'foodmood' ),
						'popup' => esc_html__( 'Popup', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'bg_video',
				),	
				array(
					'name' => esc_html__( 'Start Video', 'foodmood' ),
					'id'   => "start_video",
					'type' => 'number',
					'std'  => '0',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('post_format_video_style','=','bg_video'),
						), ),
					),
				),				
				array(
					'name' => esc_html__( 'End Video', 'foodmood' ),
					'id'   => "end_video",
					'type' => 'number',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('post_format_video_style','=','bg_video'),
						), ),
					),
				),	
				array(
					'name' => esc_html__( 'oEmbed URL', 'foodmood' ),
					'id'   => "post_format_video_url",
					'type' => 'oembed',
				),
				// Quote Post Format
				array(
					'name' => esc_html__( 'Quote Settings', 'foodmood' ),
					'type' => 'wgl_heading',
				), 
				array(
					'name' => esc_html__( 'Quote Text', 'foodmood' ),
					'id'   => "post_format_qoute_text",
					'type' => 'textarea',
				),
				array(
					'name' => esc_html__( 'Author Name', 'foodmood' ),
					'id'   => "post_format_qoute_name",
					'type' => 'text',
				),			
				array(
					'name' => esc_html__( 'Author Position', 'foodmood' ),
					'id'   => "post_format_qoute_position",
					'type' => 'text',
				),
				array(
					'name' => esc_html__( 'Author Avatar', 'foodmood' ),
					'id'   => "post_format_qoute_avatar",
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
				),
				// Audio Post Format
				array(
					'name' => esc_html__( 'Audio Settings', 'foodmood' ),
					'type' => 'wgl_heading',
				), 
				array(
					'name' => esc_html__( 'oEmbed URL', 'foodmood' ),
					'id'   => "post_format_audio_url",
					'type' => 'oembed',
				),
				// Link Post Format
				array(
					'name' => esc_html__( 'Link Settings', 'foodmood' ),
					'type' => 'wgl_heading',
				), 
				array(
					'name' => esc_html__( 'URL', 'foodmood' ),
					'id'   => "post_format_link_url",
					'type' => 'url',
				),
				array(
					'name' => esc_html__( 'Text', 'foodmood' ),
					'id'   => "post_format_link_text",
					'type' => 'text',
				),
			)
		);
		return $meta_boxes;
	}

	public function blog_related_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Related Blog Post', 'foodmood' ),
	        'post_types' => array( 'post' ),
	        'context'    => 'advanced',
	        'fields'     => array(   

	        	array(
					'name'    => esc_html__( 'Related Options', 'foodmood' ),
					'id'      => "mb_blog_show_r",
					'type'    => 'button_group',
					'options' => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom'  => esc_html__( 'Custom', 'foodmood' ),
						'off'  	  => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),        	
				array(
					'name' => esc_html__( 'Related Settings', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_blog_show_r','=','custom')
						)),
					),
				), 
				array(
					'name' => esc_html__( 'Title', 'foodmood' ),
					'id'   => "mb_blog_title_r",
					'type' => 'text',
					'std'  => esc_html__( 'Related Posts', 'foodmood' ),
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_blog_show_r','=','custom')
						), ),
					),
				), 			
				array(
					'name' => esc_html__( 'Categories', 'foodmood' ),
					'id'   => "mb_blog_cat_r",
					'multiple'    => true,
					'type' => 'taxonomy_advanced',
					'taxonomy' => 'category',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_blog_show_r','=','custom')
						), ),
					),
				),     
				array(
					'name' => esc_html__( 'Columns', 'foodmood' ),
					'id'   => "mb_blog_column_r",
					'type' => 'button_group',
					'options' => array(
						'12' => esc_html__( '1', 'foodmood' ),
						'6'  => esc_html__( '2', 'foodmood' ),
						'4'  => esc_html__( '3', 'foodmood' ),
						'3'  => esc_html__( '4', 'foodmood' ),
					),
					'multiple'   => false,
					'std'        => '6',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_blog_show_r','=','custom')
						), ),
					),
				),  
				array(
					'name' => esc_html__( 'Number of Related Items', 'foodmood' ),
					'id'   => "mb_blog_number_r",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 2,
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','custom')
							),
						),
					),
				),
	        	array(
					'id'   => 'mb_blog_carousel_r',
					'name' => esc_html__( 'Display items carousel for this blog post', 'foodmood' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_blog_show_r','=','custom')
							),
						),
					),
				),  
	        ),
	    );
	    return $meta_boxes;
	}

	public function page_layout_meta_boxes( $meta_boxes ) {

	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Page Layout', 'foodmood' ),
	        'post_types' => array( 'page' , 'post', 'team', 'practice','portfolio', 'product' ),
	        'context'    => 'advanced',
	        'fields'     => array(
				array(
					'name'    => esc_html__( 'Page Sidebar Layout', 'foodmood' ),
					'id'      => "mb_page_sidebar_layout",
					'type'    => 'wgl_image_select',
					'options' => array(
						'default' => get_template_directory_uri() . '/core/admin/img/options/1c.png',
						'none'    => get_template_directory_uri() . '/core/admin/img/options/none.png',
						'left'    => get_template_directory_uri() . '/core/admin/img/options/2cl.png',
						'right'   => get_template_directory_uri() . '/core/admin/img/options/2cr.png',
					),
					'std'     => 'default',
				),
				array(
					'name'     => esc_html__( 'Sidebar Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
				array(
					'name'        => esc_html__( 'Page Sidebar', 'foodmood' ),
					'id'          => "mb_page_sidebar_def",
					'type'        => 'select',
					'placeholder' => 'Select a Sidebar',
					'options'     => foodmood_get_all_sidebar(),
					'multiple'    => false,
					'attributes'  => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),			
				array(
					'name'    => esc_html__( 'Page Sidebar Width', 'foodmood' ),
					'id'      => "mb_page_sidebar_def_width",
					'type'    => 'button_group',
					'options' => array(	
						'9' => esc_html( '25%' ),
						'8' => esc_html( '33%' ),
					),
					'std'  => '9',
					'multiple'   => false,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
				array(
					'id'   => 'mb_sticky_sidebar',
					'name' => esc_html__( 'Sticky Sidebar On?', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
				array(
					'name'  => esc_html__( 'Sidebar Side Gap', 'foodmood' ),
					'id'    => "mb_sidebar_gap",
					'type'  => 'select',
					'options' => array(	
						'def' => 'Default',
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
					'std'        => 'def',
					'multiple'   => false,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_sidebar_layout','!=','default'),
							array('mb_page_sidebar_layout','!=','none'),
						)),
					),
				),
	        )
	    );
	    return $meta_boxes;
	}

	public function page_color_meta_boxes( $meta_boxes ) {

	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Page Colors', 'foodmood' ),
	        'post_types' => array( 'page' , 'post', 'team', 'practice','portfolio' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Page Colors', 'foodmood' ),
					'id'       => "mb_page_colors_switch",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom'  => esc_html__( 'Custom', 'foodmood' ),
					),
					'inline'   => true,
					'multiple' => false,
					'std'      => 'default',
				),
				array(
					'name' => esc_html__( 'Colors Settings', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch', '=', 'custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'General Theme Color', 'foodmood' ),
	                'id'   => 'mb_page_theme_color',
	                'type' => 'color',
	                'std'  => '#f7b035',
					'js_options' => array( 'defaultColor' => '#f7b035' ),
	                'validate' => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch', '=', 'custom'),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Body Background Color', 'foodmood' ),
	                'id'   => 'mb_body_background_color',
	                'type' => 'color',
	                'std'  => '#ffffff',
					'js_options' => array( 'defaultColor' => '#ffffff' ),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch', '=', 'custom'),
						)),
					),
	            ),
				array(
					'name' => esc_html__( 'Scroll Up Settings', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch', '=', 'custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Button Background Color', 'foodmood' ),
	                'id'   => 'mb_scroll_up_bg_color',
	                'type' => 'color',
	                'std'  => '#f7b035',
					'js_options' => array( 'defaultColor' => '#f7b035' ),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch', '=', 'custom'),
						)),
					),
	            ),				
	            array(
					'name' => esc_html__( 'Button Arrow Color', 'foodmood' ),
	                'id'   => 'mb_scroll_up_arrow_color',
	                'type' => 'color',
	                'std'  => '#ffffff',
					'js_options' => array( 'defaultColor' => '#ffffff' ),
	                'validate'  => 'color',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_colors_switch', '=', 'custom'),
						)),
					),
	            ),
	        )
	    );
	    return $meta_boxes;
	}

	public function page_logo_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Logo', 'foodmood' ),
	        'post_types' => array( 'page', 'post' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Logo', 'foodmood' ),
					'id'       => "mb_customize_logo",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom'  => esc_html__( 'Custom', 'foodmood' ),
					),
					'multiple' => false,
					'inline'   => true,
					'std'      => 'default',
				),
				array(
					'name' => esc_html__( 'Logo Settings', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Header Logo', 'foodmood' ),
					'id'   => "mb_header_logo",
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_logo_height_custom',
					'name' => esc_html__( 'Enable Logo Height', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic' => array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Logo Height', 'foodmood' ),
					'id'   => "mb_logo_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 50,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_logo_height_custom','=',true)
						)),
					),
				),
				array(
					'name' => esc_html__( 'Sticky Logo', 'foodmood' ),
					'id'   => "mb_logo_sticky",
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_sticky_logo_height_custom',
					'name' => esc_html__( 'Enable Sticky Logo Height', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Sticky Logo Height', 'foodmood' ),
					'id'   => "mb_sticky_logo_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_sticky_logo_height_custom','=',true),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Mobile Logo', 'foodmood' ),
					'id'   => "mb_logo_mobile",
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_mobile_logo_height_custom',
					'name' => esc_html__( 'Enable Mobile Logo Height', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Mobile Logo Height', 'foodmood' ),
					'id'   => "mb_mobile_logo_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_mobile_logo_height_custom','=',true),
						)),
					),
				),				
				array(
					'name' => esc_html__( 'Mobile Menu Logo', 'foodmood' ),
					'id'   => "mb_logo_mobile_menu",
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_mobile_logo_menu_height_custom',
					'name' => esc_html__( 'Enable Mobile Logo Height', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_customize_logo','=','custom')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Mobile Logo Height', 'foodmood' ),
					'id'   => "mb_mobile_logo_menu_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_logo','=','custom'),
							array('mb_mobile_logo_menu_height_custom','=',true),
						)),
					),
				),
	        )
	    );
	    return $meta_boxes;
	}	

	public function page_header_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Header', 'foodmood' ),
	        'post_types' => array( 'page', 'post', 'portfolio', 'product' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Header Settings', 'foodmood' ),
					'id'       => "mb_customize_header_layout",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'default', 'foodmood' ),
						'custom'  => esc_html__( 'custom', 'foodmood' ),
						'hide'    => esc_html__( 'hide', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),
	        	array(
					'name'     => esc_html__( 'Header Builder', 'foodmood' ),
					'id'       => "mb_customize_header",
					'type'     => 'select',
					'options'  => foodmood_get_custom_preset(),
					'multiple' => false,
					'std'      => 'default',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_header_layout','!=','hide')
						)),
					),
				),
				// It is works 
				array(
					'id'   => 'mb_menu_header',
					'name' => esc_html__( 'Menu ', 'foodmood' ),
					'type' => 'select',
					'options'     => foodmood_get_custom_menu(),
					'multiple'    => false,
					'std'         => 'default',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_header_layout','=','custom')
						)),
					),
				),
				array(
					'id'   => 'mb_header_sticky',
					'name' => esc_html__( 'Sticky Header', 'foodmood' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_customize_header_layout', '=', 'custom')
						)),
					),
				),
	        )
		);
		return $meta_boxes;
	}

	public function page_title_meta_boxes( $meta_boxes ) {
		$meta_boxes[] = array(
			'title'      => esc_html__( 'Page Title', 'foodmood' ),
			'post_types' => array( 'page', 'post', 'team', 'practice', 'portfolio', 'product' ),
			'context'    => 'advanced',
			'fields'     => array(
				array(
					'id'      => 'mb_page_title_switch',
					'name'    => esc_html__( 'Page Title', 'foodmood' ),
					'type'    => 'button_group',
					'options' => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'on'      => esc_html__( 'On', 'foodmood' ),
						'off'     => esc_html__( 'Off', 'foodmood' ),
					),
					'std'      => 'default',
					'inline'   => true,
					'multiple' => false
				),
				array(
					'name' => esc_html__( 'Page Title Settings', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array( 
					'id'   => 'mb_page_title_bg_switch',
					'name' => esc_html__( 'Use Background?', 'foodmood' ),
					'type' => 'switch',
					'std'  => true,
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=' ,'on' )
						)),
					),
				),
				array(
					'id'         => 'mb_page_title_bg',
					'name'       => esc_html__( 'Background', 'foodmood' ),
					'type'       => 'wgl_background',
				    'image'      => '',
				    'position'   => 'center bottom',
				    'attachment' => 'scroll',
				    'size'       => 'cover',
				    'repeat'     => 'no-repeat',
					'color'      => '#f6f7f8',
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' ),
							array( 'mb_page_title_bg_switch', '=', true ),
						)),
					),
				),			
				array( 
					'name' => esc_html__( 'Height', 'foodmood' ),
					'id'   => 'mb_page_title_height',
					'type' => 'number',
					'std'  => 340,
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' ),
							array( 'mb_page_title_bg_switch', '=', true ),
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Title Alignment', 'foodmood' ),
					'id'       => 'mb_page_title_align',
					'type'     => 'button_group',
					'options'  => array(
						'left'   => esc_html__( 'left', 'foodmood' ),
						'center' => esc_html__( 'center', 'foodmood' ),
						'right'  => esc_html__( 'right', 'foodmood' ),
					),
					'std'      => 'center',
					'multiple' => false,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=' ,'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Paddings Top/Bottom', 'foodmood' ),
					'id'   => 'mb_page_title_padding',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array(
						'padding-top'    => '116',
						'padding-bottom' => '126',
					),
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=' ,'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Margin Bottom', 'foodmood' ),
					'id'   => "mb_page_title_margin",
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'margin',
						'top'    => false,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array( 'margin-bottom' => '40' ),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_border_switch',
					'name' => esc_html__( 'Border Top Switch', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Border Top Color', 'foodmood' ),
					'id'   => 'mb_page_title_border_color',
					'type' => 'color',
					'std'  => '#e5e5e5',
					'js_options' => array(
						'defaultColor' => '#e5e5e5',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(						
							array('mb_page_title_border_switch','=',true)
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_parallax',
					'name' => esc_html__( 'Parallax Scroll', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Parallax Speed', 'foodmood' ),
					'id'   => 'mb_page_title_parallax_speed',
					'type' => 'number',
					'std'  => 0.3,
					'step' => 0.1,
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_page_title_parallax','=',true ),
							array( 'mb_page_title_switch', '=', 'on' ),
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_parallax_mouse',
					'name' => esc_html__( 'Parallax Mouse', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),

				array(
					'id'         => 'mb_page_title_mouse_bg',
					'name'       => esc_html__( 'Background', 'foodmood' ),
					'type'       => 'wgl_background',
				    'image'      => '',
				    'position'   => 'center bottom',
				    'attachment' => 'scroll',
				    'size'       => 'cover',
				    'repeat'     => 'no-repeat',
					'color'      => 'rgba(255,255,255,0)',
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_parallax_mouse','=',true ),
							array( 'mb_page_title_switch', '=', 'on' ),
						)),
					),
				),	
				array(
					'name' => esc_html__( 'Prallax Speed', 'foodmood' ),
					'id'   => 'mb_page_title_parallax_speed_mouse',
					'type' => 'number',
					'std'  => 0.03,
					'step' => 0.01,
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_page_title_parallax_mouse','=',true ),
							array( 'mb_page_title_switch', '=', 'on' ),
						)),
					),
				),

				array(
					'id'   => 'mb_page_change_tile_switch',
					'name' => esc_html__( 'Custom Page Title', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title', 'foodmood' ),
					'id'   => 'mb_page_change_tile',
					'type' => 'text',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_page_change_tile_switch','=','1' ),
							array( 'mb_page_title_switch', '=', 'on' ),
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_breadcrumbs_switch',
					'name' => esc_html__( 'Show Breadcrumbs', 'foodmood' ),
					'type' => 'switch',
					'std'  => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Breadcrumbs Alignment', 'foodmood' ),
					'id'       => 'mb_page_title_breadcrumbs_align',
					'type'     => 'button_group',
					'options'  => array(
						'left' => esc_html__( 'left', 'foodmood' ),
						'center' => esc_html__( 'center', 'foodmood' ),
						'right' => esc_html__( 'right', 'foodmood' ),
					),
					'std'      => 'center',
					'multiple' => false,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch','=','on' ),
							array( 'mb_page_title_breadcrumbs_switch', '=', '1' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Typography', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Font', 'foodmood' ),
					'id'   => 'mb_page_title_font',
					'type' => 'wgl_font',
					'options' => array(
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					),
					'std' => array(
						'font-size' => '42',
						'line-height' => '60',
						'color' => '#232323',
					),
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch', '=', 'on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Breadcrumbs Font', 'foodmood' ),
					'id'   => 'mb_page_title_breadcrumbs_font',
					'type' => 'wgl_font',
					'options' => array(
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					),
					'std' => array(
						'font-size' => '16',
						'line-height' => '24',
						'color' => '#232323',
					),
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array( 'mb_page_title_switch','=','on' )
						)),
					),
				),
				array(
					'name' => esc_html__( 'Responsive Layout', 'foodmood' ),
					'type' => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_resp_switch',
					'name' => esc_html__( 'Responsive Layout On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Screen breakpoint', 'foodmood' ),
					'id'   => 'mb_page_title_resp_resolution',
					'type' => 'number',
					'std'  => 768,
					'min'  => 1,
					'step' => 1,
				    'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on'),
							array('mb_page_title_resp_switch','=','1'),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Height', 'foodmood' ),
					'id'   => 'mb_page_title_resp_height',
					'type' => 'number',
					'std'  => 230,
					'min'  => 0,
					'step' => 1,
				    'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on'),
							array('mb_page_title_resp_switch','=','1'),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Padding Top/Bottom', 'foodmood' ),
					'id'   => 'mb_page_title_resp_padding',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array(
						'padding-top'    => '15',
						'padding-bottom' => '40',
					),
				    'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on'),
							array('mb_page_title_resp_switch','=','1'),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Font', 'foodmood' ),
					'id'   => 'mb_page_title_resp_font',
					'type' => 'wgl_font',
					'options' => array(
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					),
					'std' => array(
						'font-size' => '42',
						'line-height' => '60',
						'color' => '#232323',
					),
				    'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on'),
							array('mb_page_title_resp_switch','=','1'),
						)),
					),
				),
				array(
					'id'   => 'mb_page_title_resp_breadcrumbs_switch',
					'name' => esc_html__( 'Show Breadcrumbs', 'foodmood' ),
					'type' => 'switch',
					'std'  => 1,
				    'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on'),
							array('mb_page_title_resp_switch','=','1'),
						)),
					),
				),
				array(
					'name' => esc_html__( 'Page Title Breadcrumbs Font', 'foodmood' ),
					'id'   => 'mb_page_title_resp_breadcrumbs_font',
					'type' => 'wgl_font',
					'options' => array(
						'font-size' => true,
						'line-height' => true,
						'font-weight' => false,
						'color' => true,
					),
					'std' => array(
						'font-size' => '16',
						'line-height' => '24',
						'color' => '#232323',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_page_title_switch','=','on'),
							array('mb_page_title_resp_switch','=','1'),
							array('mb_page_title_resp_breadcrumbs_switch','=','1'),
						)),
					),
				),
	        ),
	    );
	    return $meta_boxes;
	}

	public function page_side_panel_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Side Panel', 'foodmood' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Side Panel', 'foodmood' ),
					'id'       => "mb_customize_side_panel",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom' => esc_html__( 'Custom', 'foodmood' ),
					),
					'multiple' => false,
					'inline'   => true,
					'std'      => 'default',
				),
				array(
					'name'     => esc_html__( 'Side Panel Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Content Type', 'foodmood' ),
					'id'       => 'mb_side_panel_content_type',
					'type'     => 'button_group',
					'options'  => array(
						'widgets' => esc_html__( 'Widgets', 'foodmood' ),
						'pages'   => esc_html__( 'Page', 'foodmood' )		
					),
					'multiple' => false,
					'std'      => 'widgets',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),
				array(
	        		'name'        => 'Select a page',
					'id'          => 'mb_side_panel_page_select',
					'type'        => 'post',
					'post_type'   => 'side_panel',
					'field_type'  => 'select_advanced',
					'placeholder' => 'Select a page',
					'query_args'  => array(
					    'post_status'    => 'publish',
					    'posts_per_page' => - 1,
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_side_panel','=','custom'),
							array('mb_side_panel_content_type','=','pages')
						)),
					),
	        	),
				array(
					'name' => esc_html__( 'Paddings', 'foodmood' ),
					'id'   => 'mb_side_panel_spacing',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => true,
						'bottom' => true,
						'left'   => true,
					),
					'std' => array(
						'padding-top'    => '105',
						'padding-right'  => '90',
						'padding-bottom' => '105',
						'padding-left'   => '90'
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),	

				array(
					'name' => esc_html__( 'Title Color', 'foodmood' ),
					'id'   => "mb_side_panel_title_color",
					'type' => 'color',
					'std'  => '#ffffff',
					'js_options' => array(
						'defaultColor' => '#ffffff',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(						
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),						
				array(
					'name' => esc_html__( 'Text Color', 'foodmood' ),
					'id'   => "mb_side_panel_text_color",
					'type' => 'color',
					'std'  => '#313538',
					'js_options' => array(
						'defaultColor' => '#313538',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(						
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),				
				array(
					'name' => esc_html__( 'Background Color', 'foodmood' ),
					'id'   => "mb_side_panel_bg",
					'type' => 'color',
					'std'  => '#ffffff',
					'alpha_channel' => true,
					'js_options' => array(
						'defaultColor' => '#ffffff',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(						
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Text Align', 'foodmood' ),
					'id'       => "mb_side_panel_text_alignment",
					'type'     => 'button_group',
					'options'  => array(
						'left' => esc_html__( 'Left', 'foodmood' ),
						'center' => esc_html__( 'Center', 'foodmood' ),
						'right' => esc_html__( 'Right', 'foodmood' ),
					),
					'multiple'   => false,
					'std'        => 'center',
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array('mb_customize_side_panel','=','custom')
						), ),
					),
				),
				array(
					'name' => esc_html__( 'Width', 'foodmood' ),
					'id'   => "mb_side_panel_width",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 480,
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(						
							array('mb_customize_side_panel','=','custom')
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Position', 'foodmood' ),
					'id'          => "mb_side_panel_position",
					'type'        => 'button_group',
					'options'     => array(
						'left' => esc_html__( 'Left', 'foodmood' ),
						'right' => esc_html__( 'Right', 'foodmood' ),
					),
					'multiple'    => false,
					'std'         => 'right',
					'attributes' => array(
						'data-conditional-logic' => array(
							array(
								array('mb_customize_side_panel','=','custom')
							),
						),
					),
				),
	        )
	    );
	    return $meta_boxes;
	}	

	public function page_soc_icons_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Social Shares', 'foodmood' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Social Shares', 'foodmood' ),
					'id'          => "mb_customize_soc_shares",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'on' => esc_html__( 'On', 'foodmood' ),
						'off' => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple'    => false,
					'inline'    => true,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Choose your share style.', 'foodmood' ),
					'id'          => "mb_soc_icon_style",
					'type'        => 'button_group',
					'options'     => array(
						'standard' => esc_html__( 'Standard', 'foodmood' ),
						'hovered' => esc_html__( 'Hovered', 'foodmood' ),
					),
					'multiple'    => false,
					'std'         => 'standard',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),				
				array(
					'id'   => 'mb_soc_icon_position',
					'name' => esc_html__( 'Fixed Position On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),
				array( 
					'name' => esc_html__( 'Offset Top(in percentage)', 'foodmood' ),
					'id'   => 'mb_soc_icon_offset',
					'type' => 'number',
					'std'  => 50,
					'min'  => 0,
					'step' => 1,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
					'desc' => esc_html__( 'Measurement units defined as "percents" while position fixed is enabled, and as "pixels" while position is off.', 'foodmood' ),
				),
				array(
					'id'   => 'mb_soc_icon_facebook',
					'name' => esc_html__( 'Facebook Share On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),				
				array(
					'id'   => 'mb_soc_icon_twitter',
					'name' => esc_html__( 'Twitter Share On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),				
				array(
					'id'   => 'mb_soc_icon_linkedin',
					'name' => esc_html__( 'Linkedin Share On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),						
				array(
					'id'   => 'mb_soc_icon_pinterest',
					'name' => esc_html__( 'Pinterest Share On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),				
				array(
					'id'   => 'mb_soc_icon_tumblr',
					'name' => esc_html__( 'Tumblr Share On/Off', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_soc_shares','=','on')
						)),
					),
				),
				
	        )
	    );
	    return $meta_boxes;
	}

	public function page_markers_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Page Markers', 'foodmood' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Page Markers', 'foodmood' ),
					'id'          => "mb_customize_markers",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'on' => esc_html__( 'On', 'foodmood' ),
						'off' => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple'    => false,
					'inline'    => true,
					'std'         => 'default',
				),
				array(
					'name' => esc_html__( 'Offset Top(in percentage)', 'foodmood' ),
					'id'   => 'mb_page_marker_offset',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'margin',
						'top'    => true,
						'right'  => false,
						'bottom' => false,
						'left'   => false,
					),
					'std' => array(
						'margin-top'    => '40',
					),
					'attributes' => array(
						'data-conditional-logic' => array( array(
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),					
				array(
					'id'   => 'mb_add_marker_1',
					'name' => esc_html__( 'Add Marker 1', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_markers','=','on')
						)),
					),
				),
				array(
					'id'   => "mb_marker_image_1",
					'name' => esc_html__( 'Marker Image 1', 'foodmood' ),
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_add_marker_1','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),
				array(
					'id'   => "mb_marker_color_1",
					'name' => esc_html__( 'Marker Color 1', 'foodmood' ),
					'type' => 'color',
					'std'  => '#232323',
					'js_options' => array(
						'defaultColor' => '#232323',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_add_marker_1','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),	
				array(
		            'id'   => 'mb_marker_link_1',
		            'name' => esc_html__( 'Marker Link 1', 'foodmood' ),
		            'type' => 'text',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_add_marker_1','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
		        ),  				
				array(
					'id'   => 'mb_add_marker_2',
					'name' => esc_html__( 'Add Marker 2', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_markers','=','on')
						)),
					),
				),
				array(
					'id'   => "mb_marker_image_2",
					'name' => esc_html__( 'Marker Image 2', 'foodmood' ),
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_add_marker_2','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),
				array(
					'id'   => "mb_marker_color_2",
					'name' => esc_html__( 'Marker Color 2', 'foodmood' ),
					'type' => 'color',
					'std'  => '#232323',
					'js_options' => array(
						'defaultColor' => '#232323',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_add_marker_2','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),	
				array(
		            'id'   => 'mb_marker_link_2',
		            'name' => esc_html__( 'Marker Link 2', 'foodmood' ),
		            'type' => 'text',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_add_marker_2','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
		        ), 			
				array(
					'id'   => 'mb_add_marker_3',
					'name' => esc_html__( 'Add Marker 3', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_markers','=','on')
						)),
					),
				),
				array(
					'id'   => "mb_marker_image_3",
					'name' => esc_html__( 'Marker Image 3', 'foodmood' ),
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_add_marker_3','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),
				array(
					'id'   => "mb_marker_color_3",
					'name' => esc_html__( 'Marker Color 3', 'foodmood' ),
					'type' => 'color',
					'std'  => '#232323',
					'js_options' => array(
						'defaultColor' => '#232323',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_add_marker_3','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),	
				array(
		            'id'   => 'mb_marker_link_3',
		            'name' => esc_html__( 'Marker Link 3', 'foodmood' ),
		            'type' => 'text',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_add_marker_3','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
		        ), 
				array(
					'id'   => 'mb_add_marker_4',
					'name' => esc_html__( 'Add Marker 4', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_markers','=','on')
						)),
					),
				),
				array(
					'id'   => "mb_marker_image_4",
					'name' => esc_html__( 'Marker Image 4', 'foodmood' ),
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_add_marker_4','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),
				array(
					'id'   => "mb_marker_color_4",
					'name' => esc_html__( 'Marker Color 4', 'foodmood' ),
					'type' => 'color',
					'std'  => '#232323',
					'js_options' => array(
						'defaultColor' => '#232323',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_add_marker_4','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),	
				array(
		            'id'   => 'mb_marker_link_4',
		            'name' => esc_html__( 'Marker Link 4', 'foodmood' ),
		            'type' => 'text',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_add_marker_4','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
		        ), 
				array(
					'id'   => 'mb_add_marker_5',
					'name' => esc_html__( 'Add Marker 5', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_markers','=','on')
						)),
					),
				),
				array(
					'id'   => "mb_marker_image_5",
					'name' => esc_html__( 'Marker Image 5', 'foodmood' ),
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_add_marker_5','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),
				array(
					'id'   => "mb_marker_color_5",
					'name' => esc_html__( 'Marker Color 5', 'foodmood' ),
					'type' => 'color',
					'std'  => '#232323',
					'js_options' => array(
						'defaultColor' => '#232323',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_add_marker_5','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),	
				array(
		            'id'   => 'mb_marker_link_5',
		            'name' => esc_html__( 'Marker Link 5', 'foodmood' ),
		            'type' => 'text',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_add_marker_5','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
		        ), 
				array(
					'id'   => 'mb_add_marker_6',
					'name' => esc_html__( 'Add Marker 6', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_customize_markers','=','on')
						)),
					),
				),
				array(
					'id'   => "mb_marker_image_6",
					'name' => esc_html__( 'Marker Image 6', 'foodmood' ),
					'type' => 'image_advanced',
					'max_file_uploads' => 1,
					'attributes' => array(
					    'data-conditional-logic' => array( array(
							array('mb_add_marker_6','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),
				array(
					'id'   => "mb_marker_color_6",
					'name' => esc_html__( 'Marker Color 6', 'foodmood' ),
					'type' => 'color',
					'std'  => '#232323',
					'js_options' => array(
						'defaultColor' => '#232323',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_add_marker_6','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
				),	
				array(
		            'id'   => 'mb_marker_link_6',
		            'name' => esc_html__( 'Marker Link 6', 'foodmood' ),
		            'type' => 'text',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_add_marker_6','=','1'),
							array( 'mb_customize_markers', '=' ,'on' )
						)),
					),
		        ), 
	        )
	    );
	    return $meta_boxes;
	}

	public function page_footer_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Footer', 'foodmood' ),
	        'post_types' => array( 'page' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
					'name'     => esc_html__( 'Footer', 'foodmood' ),
					'id'       => "mb_footer_switch",
					'type'     => 'button_group',
					'options'  => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'on'      => esc_html__( 'On', 'foodmood' ),
						'off'     => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple' => false,
					'std'      => 'default',
				),
				array(
					'name'     => esc_html__( 'Footer Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				), 
				array(
					'id'   => 'mb_footer_add_wave',
					'name' => esc_html__( 'Add Wave', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Set Wave Height', 'foodmood' ),
					'id'   => "mb_footer_wave_height",
					'type' => 'number',
					'min'  => 0,
					'step' => 1,
					'std'  => 158,
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
					    	array('mb_footer_switch','=','on'),
							array('mb_footer_add_wave','=','1')
						)),
					),
				),
				array(
					'name'     => esc_html__( 'Content Type', 'foodmood' ),
					'id'       => 'mb_footer_content_type',
					'type'     => 'button_group',
					'options'  => array(
						'widgets' => esc_html__( 'Default', 'foodmood' ),
						'pages'   => esc_html__( 'Page', 'foodmood' )		
					),
					'multiple' => false,
					'std'      => 'widgets',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),
				array(
	        		'name'        => 'Select a page',
					'id'          => 'mb_footer_page_select',
					'type'        => 'post',
					'post_type'   => 'footer',
					'field_type'  => 'select_advanced',
					'placeholder' => 'Select a page',
					'query_args'  => array(
					    'post_status'    => 'publish',
					    'posts_per_page' => - 1,
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on'),
							array('mb_footer_content_type','=','pages')
						)),
					),
	        	),
				array(
					'name' => esc_html__( 'Paddings', 'foodmood' ),
					'id'   => 'mb_footer_spacing',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => true,
						'bottom' => true,
						'left'   => true,
					),
					'std' => array(
						'padding-top'    => '130',
						'padding-right'  => '0',
						'padding-bottom' => '60',
						'padding-left'   => '0'
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),	
				array(
					'name'       => esc_html__( 'Background', 'foodmood' ),
					'id'         => "mb_footer_bg",
					'type'       => 'wgl_background',
				    'image'      => '',
				    'position'   => 'center center',
				    'attachment' => 'scroll',
				    'size'       => 'cover',
				    'repeat'     => 'no-repeat',			
					'color'      => '#ffffff',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),
				array(
					'id'   => 'mb_footer_add_border',
					'name' => esc_html__( 'Add Border Top', 'foodmood' ),
					'type' => 'switch',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_footer_switch','=','on')
						)),
					),
				),	
				array(
					'name' => esc_html__( 'Border Color', 'foodmood' ),
					'id'   => "mb_footer_border_color",
					'type' => 'color',
					'std'  => 'rgba(255,255,255,0.2)',
					'alpha_channel' => true,
					'js_options' => array(
						'defaultColor' => 'rgba(255,255,255,0.2)',
					),
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(		
							array('mb_footer_switch','=','on'),
							array('mb_footer_add_border','=','1'),
						)),
					),
				),			
	        ),
	     );
	    return $meta_boxes;
	}	

	public function page_copyright_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Copyright', 'foodmood' ),
	        'post_types' => array( 'page' ),
	        'context' => 'advanced',
	        'fields'     => array(
				array(
					'name'     => esc_html__( 'Copyright', 'foodmood' ),
					'id'          => "mb_copyright_switch",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'on' => esc_html__( 'On', 'foodmood' ),
						'off' => esc_html__( 'Off', 'foodmood' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Copyright Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Editor', 'foodmood' ),
					'id'   => "mb_copyright_editor",
					'type' => 'textarea',
					'cols' => 20,
					'rows' => 3,
					'std'  => 'Copyright © 2019 Foodmood by WebGeniusLab. All Rights Reserved',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(						
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Text Color', 'foodmood' ),
					'id'   => "mb_copyright_text_color",
					'type' => 'color',
					'std'  => '#838383',
					'js_options' => array(
						'defaultColor' => '#838383',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(						
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Background Color', 'foodmood' ),
					'id'   => "mb_copyright_bg_color",
					'type' => 'color',
					'std'  => '#171a1e',
					'js_options' => array(
						'defaultColor' => '#171a1e',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(						
							array('mb_copyright_switch','=','on')
						)),
					),
				),
				array(
					'name' => esc_html__( 'Paddings', 'foodmood' ),
					'id'   => 'mb_copyright_spacing',
					'type' => 'wgl_offset',
					'options' => array(
						'mode'   => 'padding',
						'top'    => true,
						'right'  => false,
						'bottom' => true,
						'left'   => false,
					),
					'std' => array(
						'padding-top'    => '10',
						'padding-bottom' => '10',
					),
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_copyright_switch','=','on')
						)),
					),
				),
	        ),
	     );
	    return $meta_boxes;

	}

	public function shop_catalog_meta_boxes( $meta_boxes ) {
	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Catalog Options', 'foodmood' ),
	        'post_types' => array( 'product' ),
	        'context'    => 'advanced',
	        'fields'     => array(
	        	array(
					'id'   => 'mb_product_carousel',
					'name' => esc_html__( 'Product Carousel', 'foodmood' ),
					'type' => 'switch',
					'std'  => '',
				),       
	        ),
	    );
	    return $meta_boxes;
	}

	public function shop_single_meta_boxes( $meta_boxes ) {

	    $meta_boxes[] = array(
	        'title'      => esc_html__( 'Post Settings', 'foodmood' ),
	        'post_types' => array( 'product' ),
	        'context' => 'advanced',
	        'fields'     => array(
				array(
					'name'     => esc_html__( 'Post Layout', 'foodmood' ),
					'id'          => "mb_product_layout",
					'type'        => 'button_group',
					'options'     => array(
						'default' => esc_html__( 'Default', 'foodmood' ),
						'custom' => esc_html__( 'Custom', 'foodmood' ),
					),
					'multiple'    => false,
					'std'         => 'default',
				),
				array(
					'name'     => esc_html__( 'Product Layout Settings', 'foodmood' ),
					'type'     => 'wgl_heading',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_product_layout','=','custom')
						)),
					),
				),  
				
				array(		
					'name'     => esc_html__( 'Single Image Layout', 'foodmood' ),
					'id'          => "mb_shop_single_image_layout",
					'type'        => 'wgl_image_select',
					'placeholder' => 'Select a Single Layout',
					'options'     => array(
						'default' => get_template_directory_uri() . '/core/admin/img/options/1c.png',
						'sticky_layout'    => get_template_directory_uri() . '/core/admin/img/options/none.png',
						'image_gallery'    => get_template_directory_uri() . '/core/admin/img/options/2cl.png',
						'full_width_image_gallery' => get_template_directory_uri() . '/core/admin/img/options/2cr.png',
						'with_background'   => get_template_directory_uri() . '/core/admin/img/options/2cr.png',
					),
					'std'         => 'default',
					'attributes' => array(
					    'data-conditional-logic'  =>  array( array(
							array('mb_product_layout','=','custom')
						)),
					),				
				),       
				array(
					'id'   => 'mb_shop_layout_with_background',
					'name' => esc_html__( 'Background', 'foodmood' ),
					'type' => 'color',
					'attributes' => array(
						'data-conditional-logic'  =>  array( array(
							array('mb_product_layout','=','custom'),
							array('mb_shop_single_image_layout','=','with_background'),
						)),
					),
					'js_options' => array(
						'defaultColor' => '#f3f3f3',
					),
					'std'         => '#f3f3f3',
					'validate'  => 'color',
				),
	        ),
	    );
	    return $meta_boxes;
	}

}
new Foodmood_Metaboxes();

?>