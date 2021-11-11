<?php
if ( ! defined( 'ABSPATH' ) ) { exit; }
/**
* Foodmood Woocommerce
*
*
* @class        Foodmood_Woocoommerce
* @version      1.0
* @category Class
* @author       WebGeniusLab
*/

if (!class_exists('Foodmood_Woocoommerce')) {
	class Foodmood_Woocoommerce{
	    /**
		* Generate lauout template
		*
		*
		* @since 1.0
		* @access private
		*/
		private $row_class;
		private $container_class;
		private $column;
		private $content;

		public function __construct ( ){
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'woocommerce_init', array( $this, 'init' ) );
			add_filter( 'woocommerce_show_page_title', '__return_false' );

			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
			add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'woocommerce_template_loop_product_thumbnail' ), 10);
		}
 
		public function setup() {
			// Declare WooCommerce support.
			add_theme_support( 'woocommerce', apply_filters( 'foodmood_woocommerce_args', array(
				'single_image_width'    => 1080,
				'thumbnail_image_width' => 540,
				'gallery_thumbnail_image_width' => 240,
				'product_grid'          => array(
					'default_columns' => (int) Foodmood_Theme_Helper::get_option('shop_column'),
					'default_rows'    => 4,
					'min_columns'     => 1,
					'max_columns'     => 6,
					'min_rows'        => 1,),
			) ) );

			add_theme_support( 'wc-product-gallery-zoom' );
			add_theme_support( 'wc-product-gallery-lightbox' );
			add_theme_support( 'wc-product-gallery-slider' );			
			// Declare support for title theme feature.
			add_theme_support( 'title-tag' );

			// Declare support for selective refreshing of widgets.
			add_theme_support( 'customize-selective-refresh-widgets' );	
		}

		public function init (){
			
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper',       10 );
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			remove_action( 'woocommerce_after_main_content',  'woocommerce_output_content_wrapper_end',   10 );
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10, 0 ); 
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5, 0 ); 
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10, 0 );
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10, 0 );
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

			add_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 10 );
			add_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 20 );
			
			/* WGL Page Template*/
			add_action( 'woocommerce_before_main_content', array( $this, 'wgl_page_template_open' ), 10 );
			add_action( 'woocommerce_after_main_content',  array( $this, 'wgl_page_template_close' ), 10 );		
			/* \WGL Page Template*/

			/* WGL Wrapper Sorting*/
			add_action( 'woocommerce_before_shop_loop', array( $this, 'wgl_sorting_wrapper_open' ), 9 );
			add_action( 'woocommerce_before_shop_loop', array( $this, 'wgl_sorting_wrapper_close' ), 31 );

			/* \WGL Wrapper Sorting*/

			/* loop */

			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_product_open' ), 5 );
			add_action( 'woocommerce_after_shop_loop_item', array( $this, 'template_loop_product_close' ), 15 );



			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_product_title' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'template_loop_price' ), 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'template_short_description' ), 7 );
			add_action( 'woocommerce_after_shop_loop_item_title', array( $this, 'template_loop_rating' ), 5 );

			add_action( 'woocommerce_before_subcategory', array( $this, 'loop_products_item_wrapper' ), 5 );
			add_action( 'woocommerce_after_subcategory', array( $this, 'loop_products_item_wrapper_close' ), 20 );


			add_filter( 'loop_shop_per_page', array( $this, 'loop_products_per_page' ), 20 );		

			add_filter( 'woocommerce_before_shop_loop_item', array( $this, 'loop_products_item_wrapper' ), 20 );				
			add_filter( 'woocommerce_after_shop_loop_item', array( $this, 'loop_products_item_wrapper_close' ), 20 );				
			/* \loop */

			/* widgets */
			add_action( 'woocommerce_before_mini_cart', array( $this, 'minicart_wrapper_open' ) );
			add_action( 'woocommerce_after_mini_cart', array( $this, 'minicart_wrapper_close' ) );
			add_action( 'wp_ajax_woocommerce_remove_from_cart', array( $this, 'ajax_remove_from_cart' ), 1000 );
			add_action( 'wp_ajax_nopriv_woocommerce_remove_from_cart', array( $this, 'ajax_remove_from_cart' ), 1000 );
			
			if(defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.0', '<' )){
				add_filter( 'add_to_cart_fragments', array( $this, 'header_add_to_cart_fragment' ) );
			}else{
				add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'header_add_to_cart_fragment' ) );
			}
			/* \widgets */
			
			add_filter( 'woocommerce_product_thumbnails_columns',   array( $this, 'thumbnail_columns' ) );
			add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
			// Legacy WooCommerce columns filter.
			if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '<' ) ) {
				add_filter( 'loop_shop_columns',  array( $this, 'loop_columns' ));
			}

			//tabs remove heading filter
			add_filter( 'woocommerce_product_description_heading', '__return_false' ); 

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 20 );

			add_action( 'woocommerce_before_shop_loop', array( $this, 'wgl_product_columns_wrapper_open' ), 40 );
			add_action( 'woocommerce_after_shop_loop', array( $this, 'wgl_product_columns_wrapper_close' ), 40 );

			add_filter( 'comment_form_fields',  array( $this, 'wgl_comments_fiels' ) );
			add_filter( 'woocommerce_product_review_comment_form_args',array( $this, 'wgl_filter_comments' ), 10, 1 ); 
			add_filter( 'woocommerce_product_review_list_args',array( $this, 'wgl_filter_reviews' ), 10, 1 ); 
			add_filter( 'woocommerce_review_gravatar_size',array( $this, 'wgl_review_gravatar_size' ), 10, 1 ); 
			
			add_filter( 'woocommerce_cart_item_thumbnail',array( $this, 'wgl_image_thumbnails' ), 10, 3); 

			//Filter pagination 
			add_filter('woocommerce_pagination_args', array( $this, 'wgl_filter_pagination' ) );
		}
		
		/**/
		/* WGL Reviews filter */
		/**/
		function wgl_filter_reviews($array){
			return array( 'callback' => array( $this, 'wgl_templates_reviews' ) );
		}

		public function wgl_templates_reviews($comment, $args, $depth){
			$GLOBALS['comment'] = $comment;
			?>
			<li <?php comment_class('comment'); ?> id="li-comment-<?php comment_ID() ?>">

				<div id="comment-<?php comment_ID(); ?>" class="stand_comment">
					<div class="thiscommentbody">
	                    <div class="commentava">
							<?php
							/**
							 * The woocommerce_review_before hook
							 *
							 * @hooked woocommerce_review_display_gravatar - 10
							 */
							do_action( 'woocommerce_review_before', $comment );
							?>
						</div>
						<div class="comment_info">
							<div class="comment_author_says">
							<?php
								/**
								 * The woocommerce_review_meta hook.
								 *
								 * @hooked woocommerce_review_display_meta - 20
								 * @hooked WC_Structured_Data::generate_review_data() - 20
								 */
								$this->review_comments_meta_info($comment);

							?> 
							</div>	
						</div>	
						<div class="comment_content">
							<?php

							do_action( 'woocommerce_review_before_comment_text', $comment );

							/**
							 * The woocommerce_review_comment_text hook
							 *
							 * @hooked woocommerce_review_display_comment_text - 10
							 */
							do_action( 'woocommerce_review_comment_text', $comment );

							do_action( 'woocommerce_review_after_comment_text', $comment ); ?>
						
						</div>
					</div>
				</div>
			<?php
		}

		public function wgl_review_gravatar_size(){
			return 120;
		}

		function review_comments_meta_info($comment){
			global $comment;
			$verified = function_exists('wc_review_is_from_verified_owner') ? wc_review_is_from_verified_owner( $comment->comment_ID ) : '';

			if ( '0' === $comment->comment_approved ) { ?>
				<em class="woocommerce-review__awaiting-approval">
					<?php esc_html_e( 'Your review is awaiting approval', 'foodmood' ); ?>
				</em>

			<?php } else { ?>
				<span class="comments_author">
					<?php comment_author(); ?>	

					<span class="raiting-meta-wrapper">			
						<?php
						/**
						* The woocommerce_review_before_comment_meta hook.
						*
						* @hooked woocommerce_review_display_rating - 10
						*/
						do_action( 'woocommerce_review_before_comment_meta', $comment );
						?>
					</span>
				</span>
				
				<?php
				if ( 'yes' === get_option( 'woocommerce_review_rating_verification_label' ) && $verified ) {
					echo '<em class="woocommerce-review__verified verified">(' . esc_attr__( 'verified owner', 'foodmood' ) . ')</em> ';
				}
				?>
				<div class="meta-wrapper">       
					<time class="woocommerce-review__published-date" datetime="<?php echo esc_attr( get_comment_date( 'c' ) ); ?>"><?php echo esc_html( get_comment_date( wc_date_format() ) ); ?></time> 
				</div>

			<?php
			}
		}

		/**/
		/* WGL Comments Form Filter */
		/**/
		function wgl_filter_comments($comment_form){
			$commenter = wp_get_current_commenter();

			$comment_form = array(
				'title_reply'          => have_comments() ? esc_html__( 'Add a review', 'foodmood' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'foodmood' ), get_the_title() ),
				'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'foodmood' ),
				'title_reply_before'   => '<span id="reply-title" class="comment-reply-title">',
				'title_reply_after'    => '</span>',
				'comment_notes_after'  => '',
				'fields'               => array(
					'author' => '<p class="comment-form-author">' . '<label for="author"></label> ' .
					'<input id="author" name="author" placeholder="'.esc_attr__( 'Name', 'foodmood' ).'" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
					'email'  => '<p class="comment-form-email"><label for="email"></label> ' .
					'<input id="email" name="email" placeholder="'. esc_attr__( 'Email', 'foodmood' ).'" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
				),
				'label_submit'  => esc_html__( 'Submit', 'foodmood' ),
				'logged_in_as'  => '',
				'comment_field' => '',
			);

			if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
				$allowed_html = array(
                    'a' => array(
                    	'href' => true,
                    ),
                );
				$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( wp_kses( __( 'You must be <a href="%s">logged in</a> to post a review.', 'foodmood' ), $allowed_html), esc_url( $account_page_url ) ) . '</p>';
			}

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' ) {
				$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Your rating', 'foodmood' ) . '</label><select name="rating" id="rating" aria-required="true" required>
				<option value="">' . esc_html__( 'Rate&hellip;', 'foodmood' ) . '</option>
				<option value="5">' . esc_html__( 'Perfect', 'foodmood' ) . '</option>
				<option value="4">' . esc_html__( 'Good', 'foodmood' ) . '</option>
				<option value="3">' . esc_html__( 'Average', 'foodmood' ) . '</option>
				<option value="2">' . esc_html__( 'Not that bad', 'foodmood' ) . '</option>
				<option value="1">' . esc_html__( 'Very poor', 'foodmood' ) . '</option>
				</select></div>';
			}

			$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" placeholder="'.esc_attr__( 'Your review', 'foodmood' ).'" required></textarea></p>';
			return $comment_form;
		}

		/**/
		/* Comments Field Reorder */
		/**/
		function wgl_comments_fiels( $fields ){
			if( is_product() ) {
				$comment_field = $fields['comment'];
				unset( $fields['comment'] );
				$fields['comment'] = $comment_field;				
			}
			return $fields;
		}

		/**/
		/* LOOP */
		/**/
		public function loop_products_per_page() {
			return (int) Foodmood_Theme_Helper::get_option('shop_products_per_page');
		}
		/**/
		/* \LOOP */
		/**/

		/**/
		/* WIDGETS */
		/**/
		public function ajax_remove_from_cart() {
			global $woocommerce;
			$woocommerce->cart->set_quantity( $_POST['remove_item'], 0 );

			$ver = explode( '.', WC_VERSION );

			if ( $ver[1] == 1 && $ver[2] >= 2 ) :
				$wc_ajax = new WC_AJAX();
				$wc_ajax->get_refreshed_fragments();
			else :
				woocommerce_get_refreshed_fragments();
			endif;

			die();
		}

		public function header_add_to_cart_fragment( $fragments ) {
			global $woocommerce;
			ob_start();
				?>
					<span class='woo_mini-count flaticon-shopcart-icon'><?php echo ((WC()->cart->cart_contents_count > 0) ?  '<span>' . esc_html( WC()->cart->cart_contents_count ) .'</span>' : '') ?></span>
				<?php
				$fragments['.woo_mini-count'] = ob_get_clean();

				ob_start();
				woocommerce_mini_cart();
				$fragments['div.woo_mini_cart'] = ob_get_clean();

				return $fragments;
		}
		public function minicart_wrapper_open (){
			echo "<div class='woo_mini_cart'>";
		}
		public function minicart_wrapper_close (){
			echo "</div>";
		}		
		/**/
		/* \WIDGETS */
		/**/
		public function get_svg_sale(){

			$svg = '<svg
				 xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" viewBox="0 0 25.7 26.9" preserveAspectRatio="none">
			<g>
				<g>
					<path d="M3,6.5C3.1,6.4,3,6.4,3,6.3C2.7,6.7,2.5,7.1,2.2,7.5c0.1,0,0.3-0.3,0.2-0.1C2.6,7.4,2.7,7,2.7,7l0,0.1
						C2.8,6.7,3.1,6.7,3,6.9l0,0l0.2-1C3,6.2,3.2,6.2,3,6.5z"/>
					<path d="M25.3,11.5c0,0.1,0.1,0.1,0.1,0.2C25.4,11.5,25.4,11.5,25.3,11.5z"/>
					<path d="M3.3,5.7c0-0.1,0.1-0.2,0.1-0.3C3.4,5.5,3.3,5.6,3.3,5.7z"/>
					<path d="M3.3,5.7L3.3,5.9c0,0,0-0.1,0.1-0.1C3.3,5.8,3.3,5.7,3.3,5.7z"/>
					<path d="M3,6.9l0,0.2c0.1-0.2,0.2-0.4,0.3-0.7L3,6.9z"/>
					<path d="M3.7,5.4c0.2-0.3,0-0.3,0.3-0.6c-0.1,0.2,0,0.3,0.3,0C5.1,3.9,5.4,3,6.3,2.3c0.1,0.1,0.8-0.4,1.2-0.5
						C7.5,1.9,7.2,2.1,6.9,2.2C7.1,2.1,7.4,2,7.6,1.9l0-0.3C8.7,1.1,7.5,1.9,8,1.7c0.3-0.2,0.4-0.3,0.5-0.4C7.7,1.8,8.5,1,7.6,1.4
						c0-0.2,0.6-0.5,0.9-0.5C9,1,8.3,1.2,8.3,1.3C8.6,1.2,8.5,1.2,8.7,1c0.6-0.2,1.2-0.6,1.6-0.4c0.4-0.1,0.4-0.2,0.6-0.3
						c0-0.2-0.7,0-0.9-0.1c0,0,0.1,0,0.1,0L9.7,0.3c0.4,0,0,0.2-0.2,0.2c-0.1,0-0.4,0.1-0.4,0.1c0.1,0,0.1-0.1,0.2-0.1
						C9,0.6,8.8,0.9,8.5,0.9c0,0,0.1-0.1,0.1-0.1C8.3,1,8,1.1,7.6,1.4l0.2-0.3C7.5,1.4,6.7,1.7,6.1,2c0.1,0,0.2-0.1,0.1,0
						C5.9,2.2,5.7,2.3,5.7,2.1C5.5,2.4,4.6,2.8,4.3,3.2L3.8,4.3C3.7,4.6,3.5,5,3.4,5.4c0-0.1,0.1-0.1,0.1-0.2C3.8,5.1,3.8,5,3.7,5.4z"
						/>
					<path d="M6.8,2.3L6.8,2.3C6.9,2.3,6.8,2.3,6.8,2.3C6.8,2.3,6.8,2.3,6.8,2.3z"/>
					<path d="M3.7,5.8c0,0.1,0,0.1-0.1,0.2C3.7,5.9,3.7,5.9,3.7,5.8C3.7,5.8,3.7,5.8,3.7,5.8z"/>
					<path d="M3.4,5.8C3.4,5.8,3.4,5.8,3.4,5.8C3.4,5.8,3.4,5.8,3.4,5.8L3.4,5.8z"/>
					<path d="M12.1,1.5l0.1,0C12.2,1.5,12.1,1.5,12.1,1.5z"/>
					<path d="M6.2,2.9C6,2.9,5.8,3.2,5.6,3.3c0.1,0-0.2,0.4,0.3,0c0,0,0,0,0,0.1C6.2,3.2,6.3,3,6.6,2.8C6.8,2.7,6.3,3.1,6.5,3
						C6.7,2.8,7,2.7,7.2,2.5c0.3-0.1,0.4-0.2,0.4-0.3C7.9,2,7.9,2.1,8,2.1c0.4-0.5,1.8-0.6,1.7-0.8C9.5,1.3,9.2,1.4,9,1.5L8.9,1.3
						c-0.4,0.2,0,0.2-0.5,0.4l0.2,0c-0.5,0.2-1,0.5-1.4,0.7c0-0.1-0.3,0.1-0.3,0C6.6,2.5,6.3,2.7,6.2,2.9z"/>
					<path d="M0.8,8.7c0,0.1,0.1,0.1,0.1-0.1c0.3-0.4,0.2-0.7,0.4-1l0,0.1C1.5,7.4,1.7,7,1.7,6.8C2,6.7,1.3,7.6,1.7,7.3
						c-0.2,0.3-0.3,0.8-0.4,1c0.2-0.4,0.6-0.7,0.6-0.5c0.4-0.9-0.4-0.2,0-1l0.3-0.5l0-0.3c0.2-0.3,0,0.3,0.3-0.2c0-0.2,0.3-0.4,0.3-0.5
						c0,0,0.1,0.1,0.2-0.1c0,0-0.1-0.1,0.1-0.2c0.2,0-0.3,0.5,0,0.4C3.5,4.9,3.2,5,3.2,4.8c0,0,0,0-0.1,0.1c0,0,0.2-0.2,0.1-0.2
						C3.1,4.7,3.1,4.8,3,4.9c0.1-0.2-0.3,0.1-0.4,0.3C2.4,5.6,1.8,6.4,1.5,6.9c0-0.1,0.1-0.2,0-0.1C1.3,7.2,1.2,7.5,1,7.7
						C0.9,8,0.7,8.3,0.6,8.8l0.1,0.2C0.7,9.1,0.8,8.9,0.8,8.7z M1,8.3C0.9,8.4,0.9,8.5,0.8,8.6C0.9,8.4,0.9,8.3,1,8.3z"/>
					<path d="M24.5,20.2c0,0,0-0.1,0-0.1C24.5,20.1,24.5,20.2,24.5,20.2z"/>
					<path d="M24.8,18.6L24.8,18.6C24.8,18.6,24.8,18.6,24.8,18.6L24.8,18.6z"/>
					<path d="M0.1,12.7L0.1,12.7C0.1,12.7,0.1,12.7,0.1,12.7z"/>
					<path d="M4,22.5C4,22.5,4,22.4,4,22.5C3.9,22.4,3.9,22.4,4,22.5z"/>
					<polygon points="6.3,23.7 6.3,23.6 6.3,23.7 		"/>
					<path d="M2.6,7.8l0.2-0.3l0-0.1C2.8,7.4,2.5,7.7,2.6,7.8z"/>
					<path d="M17.8,24.9c0.1,0,0.2,0,0.2,0c0.1-0.1,0.2-0.1,0.3-0.2C18.2,24.9,18,24.9,17.8,24.9z"/>
					<path d="M25.3,11.6C25.3,11.7,25.3,11.6,25.3,11.6c0-0.3-0.1-0.6-0.2-0.7L25,10.5c0.1,0,0.2,0.1,0.3,0.5c-0.3-1.4-1.1-2.3-1.7-3.6
						c0-0.1,0.1,0.1,0.1,0C23.6,7.3,23.4,7,23.4,7c0,0,0.1,0,0.2,0.1c-0.5-0.6-0.6-1-0.9-1.3c0-0.1,0.3,0.2,0.3,0.2
						c-0.4-0.6-0.9-0.7-1.4-1.2c0.3,0.1,0-0.2-0.2-0.4C21,4.2,20.6,4,20.2,3.7c-0.4-0.3-0.9-0.5-1.3-0.7c0.3-0.1-0.9-0.5-0.9-0.7
						c-0.2-0.1-0.5-0.1-0.6-0.1c0.1,0,0.4,0.2,0.3,0.2c-0.3-0.1-0.7-0.2-0.8-0.1c-0.1-0.1-0.2-0.1-0.3-0.2c0,0.1-0.1,0.1-0.3,0.1
						c-0.1,0-0.1,0-0.2,0C16,2,16,2.1,16,2.1c-0.1,0-0.2,0-0.3-0.1C15.9,2,16,2,16,1.9c-0.3-0.1-0.3,0-0.5-0.1
						c-0.1-0.1,0.3-0.2,0.5-0.1c-0.1-0.1-0.3-0.1-0.4-0.2c-0.4,0.1-1.1,0.1-1.7,0.1c0.1-0.1,0.3-0.1,0.2-0.2c-0.3,0-0.6,0.1-1,0.1
						c0,0,0,0,0.1,0c-0.6,0.2-0.5,0-1,0c0,0,0,0,0,0c-0.1,0-0.2,0.1-0.3,0.1c-0.7,0.3-0.8,0-1.3,0l0.1,0c-0.3-0.1-1.1,0.3-1.4,0.3
						c0.3,0,0.1,0,0.4,0.1c0.3-0.1,0.1-0.2,0.6-0.3c0,0.2-0.6,0.3-0.6,0.5C9.3,2.3,9.1,2.1,9,2.1c-0.6,0.2-1,0.3-1.6,0.7
						C7.2,3,7.1,3.4,6.5,3.5l0-0.1c0,0.1-0.3,0.2-0.3,0.3C6.4,3.8,6,4,6.3,4C6,4.2,5.8,4.1,5.7,4c-0.1,0.3-0.6,0.4-1,0.9
						c0-0.1,0.5-0.6,0.2-0.5L4.5,5.1l0.2-0.2C4.5,5.4,4.3,5.4,4,5.6C3.9,5.6,4,5.5,4,5.4C3.9,5.5,3.8,5.7,3.7,5.8
						C3.7,6,3.4,6.5,3.3,6.8L3.2,6.9c0,0,0,0,0,0c0,0,0,0.1-0.1,0.1C3.1,7,3.1,7.1,3,7.1l0-0.1l0,0.1L2.8,7.4l0,0.2l0-0.1
						c0.1,0.1,0.1,0.2,0,0.3c-0.2,0.3-0.3,0.6-0.5,1C2.1,9.2,2,9.8,1.8,9.9c0.1-0.7,0.3-1,0.6-1.7C2.7,8,2.2,8.7,2.3,8.8l0.2-0.4
						c-0.1,0,0.3-0.7,0-0.7C2.3,8.1,2.1,8.6,1.9,9c-0.2,0.4-0.3,0.8-0.5,1.2C1.2,9.8,0.9,9.5,0.7,9.1c0,0,0,0,0-0.1
						C0.4,9.8,0.9,9.5,0.9,9.7c-0.1,0.2,0,0.4-0.1,0.5l0-0.1c-0.1,0.5,0.1,0.2,0,0.6c0,0.4,0.1-0.3,0.1-0.1C0.7,11.2,1,11,0.8,11.8
						c0,0-0.2,0.1-0.1-0.4l-0.2,0.4c0-0.5,0-0.2,0.1-0.7c-0.1-0.3-0.2-0.2-0.3-0.5c0,0.2,0.1,0.2,0,0.5c-0.1,0.4-0.1-0.1-0.1-0.1
						c0.1,0.5-0.2,0.5-0.2,1c0.2-0.1,0.2,0,0.3-0.3c0,0.3-0.2,0.7-0.3,0.6l0.1,0.1c0,0.1-0.1,0.3-0.1,0.3l0.1,0.1
						c0.1-0.2,0.2-0.4,0.2-0.8c0.1,0.2,0.3-0.2,0.2,0.3c0,0.2-0.1,0-0.1,0c0,1.1-0.3,1.1-0.2,2c-0.1-0.2,0-0.8-0.1-1.2
						c-0.1,0.3,0,0.6,0,0.8C0.1,13.8,0,13.7,0,14l0.1,0.1c0,0.2,0,0.4,0,0.5c0,0,0-0.1,0.1-0.2c0.1,0.2,0.1,0.5,0.2,0.8
						c0.1,0.3,0.1,0.7,0.1,1c-0.2,0-0.3-1-0.3-0.5c0.1,0.3,0.3,0.5,0.3,1c-0.1-0.2,0,0.2-0.1,0.3l0.4,0.6c0.1,0.3,0.2,0.5,0.3,0.8
						c0-0.1,0-0.1-0.1-0.2c0.3,0.4,0.2,0.8,0.6,1.3l-0.2-0.2c0.2,0.4,0.4,0.7,0.6,1l-0.1,0.1c0.2,0,0.6,0.6,0.7,0.7
						c-0.7-0.9-0.4-0.8-1-1.7c0.3,0.3,0.5,0.5,0.8,0.8c0.1,0.1,0.1,0.2,0.1,0.2c0.1,0.1,0.2,0.1,0.4,0.2l0,0.1c0.4,0.6,0.6,0.3,1,0.9
						c0,0.2-0.5-0.3-0.8-0.6c0.1,0.3-0.5-0.5-0.4-0.1L2.8,21c0.1,0.2,0,0.2,0,0.1C3,21.4,2.9,21.3,3,21.4c0.7,0.9-0.3,0,0.4,0.9
						c-0.1-0.1-0.3-0.3-0.3-0.2l-0.3-0.5l-0.1,0.1c0.4,0.6,0.9,0.8,1.2,0.9c-0.5-0.4,0-0.1-0.1-0.4c0.1,0.1,0.2,0.2,0.2,0.2
						c0.1,0,0.3,0.2,0.3,0.2c-0.1,0.3,0.9,1.3,0.5,1.3c0.3,0.3,1.4,1,2.2,1.4l-0.3-0.1c0.7,0.7,0.8,0.2,1.3,0.4
						c-0.5-0.1,0.3,0.3,0.5,0.4C9,26,9.4,26,9.9,26.2c0.1,0.1,0.1,0.3,0.4,0.5c0.1,0,0.2,0,0.3,0c0.4,0.1,0.9,0.1,1.1,0.2l-0.1,0
						c0.4,0.1,0.5-0.1,0.1-0.1c0.1,0,0.3,0,0.4,0l0,0c0.5,0,1-0.2,1.9-0.3c-0.2,0.1,0.7,0.2-0.1,0.3c0.2-0.1-0.1-0.1-0.2-0.2
						c-0.3,0-0.5,0.1-0.6,0.1c0.1,0.1,0,0.2-0.1,0.3c0.3-0.1,0.8-0.1,1.3-0.2c0.5,0,0.9-0.2,0.9-0.3c0.3,0,0.7-0.1,1.1-0.2
						c0.4-0.1,0.8-0.2,1.2-0.3c0,0-0.1,0-0.1,0l0.7-0.1L18,25.8c0.1,0,0.3,0,0.5-0.1c0.1,0-0.1,0.2-0.2,0.2c-0.1,0.1-0.2,0-0.1,0
						c-0.4,0.3,0.4-0.1,0.1,0.1c-0.1,0-0.3,0.1-0.3,0.1c0.6-0.1,0.7-0.4,1.1-0.4c0.2-0.2,0.6-0.5,1.1-0.7c-0.1,0.2,0.5-0.3,0.3,0
						c0.1-0.2,0.6-0.3,0.6-0.5c0,0.1-0.2,0.2-0.4,0.3c0.2-0.1,0.1-0.2,0.3-0.4c0,0,0,0,0,0c0.2-0.3-0.1-0.3,0.4-0.7
						c1.1-1,0.1,0.4,0.2,0.3c0-0.1,0.5-0.6,0.7-0.7l0,0.1c0.1-0.1,0.2-0.3,0.4-0.4c0-0.2,0-0.4,0-0.5l0.4-0.5l0,0.1
						c0.1-0.1,0.2-0.2,0.2-0.3c0.1,0,0,0.2-0.1,0.3c0.1,0,0.2-0.1,0.2-0.3l-0.1,0.1c0.1-0.2,0.3-0.8,0-0.4c0.1-0.3,0.4-0.3,0.5-0.6
						c0.1,0,0,0.2,0.1,0.2c0.2-0.2,0.2-0.3,0.3-0.5c-0.1,0.2,0-0.1-0.2,0.2c0-0.1,0.2-0.4,0.1-0.4c0,0.1,0,0.2-0.2,0.3
						c0.1-0.3,0.3-0.6,0.5-0.9c0,0,0,0.1,0,0.1c0.1-0.5,0.4-1,0.4-1.4l-0.1,0.1c0,0.1-0.1,0.3-0.2,0.4c0.1-0.3-0.2,0.1-0.1-0.2
						c0.1-0.4,0.4-0.8,0.3-1.1c-0.2,0.4-0.5,0.9-0.5,1.1l0.1-0.3l-0.1,0.7c-0.1,0-0.2,0.6-0.3,0.5c0.1-0.2,0.2-0.4,0.2-0.6
						c-0.1,0-0.3,0.5-0.4,0.7l0.2-0.2c-0.2,0.5-0.6,1.1-0.8,1.5c0.2-0.4-0.4,0.4-0.3,0c0-0.1,0.2-0.3,0.2-0.2c-0.1-0.1-0.2,0.2-0.3,0.3
						c0,0.1-0.3,0.5,0,0.3c-0.1,0.1-0.3,0.4-0.5,0.6c0.1,0-0.2,0.4-0.3,0.5c-0.1,0.1-0.2,0.1-0.2,0.1c0.1-0.2,0.3-0.4,0.4-0.6l0,0
						c0.1-0.1,0.2-0.2,0.2-0.2l0,0c0.2-0.3,0.4-0.7,0.5-1c0,0,0.1-0.1,0.1-0.1l0,0c0,0,0,0,0-0.1c1.4-2,2.3-4.4,2.3-7
						c0-0.3,0-0.6,0-0.9l0.1-0.3l0.4,1.2c0-0.5-0.1-0.9-0.2-1.2C25.4,12.3,25.2,12,25.3,11.6z M2.9,19.8C2.9,19.8,2.9,19.8,2.9,19.8
						C2.9,19.8,2.9,19.8,2.9,19.8z M6.6,23.7c0.1,0.1,0.2,0.1,0.3,0.2C6.8,23.9,6.7,23.9,6.6,23.7C6.6,23.8,6.6,23.8,6.6,23.7z
						 M1.8,10.3l-0.1,0.2l-0.1-0.1C1.7,10.3,1.7,10.3,1.8,10.3z M1.3,14.7c0,0.1,0,0.2,0,0.3c-0.1-0.2-0.2-0.3-0.2-0.4
						c0-0.4-0.1-0.7,0-1l0,0.1C1.2,14.5,1.2,14.8,1.3,14.7z M1.4,16.1c-0.1,0-0.1,0-0.1-0.3c0,0,0.1,0,0.1-0.1L1.4,16.1z M0.8,12.5
						c0-0.1,0.1-0.7,0.1-0.5c-0.1,0.4,0.2,0.4,0,0.7c0.1,0.1,0.1,0,0.2-0.2c0,0,0,0.1,0.1,0.1c0,0.1,0,0.3,0,0.4c0,0.1,0,0.2-0.1,0.2
						C0.9,13.1,1,12.6,0.8,12.5z M2.4,19.8c-0.2-0.2-0.3-0.7-0.2-0.6c-0.2,0.1-0.4-0.6-0.6-0.9c-0.2-0.6,0.1-0.5-0.2-1l0,0.2
						C1.2,17,1.1,16.7,1,16.2c0.1-0.1,0,0.3,0.1,0.4l0.1-0.3c0,0.1,0.2,0.3,0.1,0.4c0.1,0,0.2,0.2,0.1-0.2l0.2,0.2c0,0,0,0,0-0.1
						l0.1,0.2c0,0.1,0,0.3,0,0.5c0,0-0.1-0.1-0.1-0.2c0,0.3,0.1,0.5,0.2,0.6c-0.1-0.4,0-0.2,0.1-0.3C1.8,17.6,2,17.9,2,18.1
						c0.1,0.3,0.1,0.6-0.1,0.5c0.1,0.2,0.2,0.4,0.4,0.5c-0.3-0.3,0.2-0.1-0.1-0.5c0,0,0,0,0.1,0c0.1,0.2,0.2,0.3,0.2,0.5
						c0,0.1,0,0.1,0,0.2c-0.1-0.1-0.1,0-0.1,0c0.2,0.2,0.2,0.2,0.2,0.1c0.1,0.2,0.2,0.4,0.3,0.6L2.9,20l-0.2-0.3c0,0.2,0.2,0.4,0.3,0.6
						C3.1,20.5,2.7,19.9,2.4,19.8z M10.2,25.6c-0.1,0-0.2,0.2-0.6,0c0,0,0,0,0.1,0c-0.2,0-0.2-0.1-0.4-0.2c0-0.2,0.3,0,0.5,0
						c-0.1,0-0.3,0-0.5-0.1l0.1,0l-0.5-0.1c-0.2,0,0.3,0.1,0.3,0.2l-0.3,0c-0.4-0.1-1.2-0.5-1.4-0.8c-0.3-0.3-0.2,0-0.4,0
						c-0.3,0-0.4-0.3-0.6-0.4c-0.1,0.1-0.3-0.1-0.4,0L5.7,24c-0.3,0,0.4,0.3,0.4,0.4c0.1,0.3-0.3-0.1-0.2,0c0.3,0.2,0.3,0.1,0.5,0.2
						c0.2,0.1,0.2,0.2,0.2,0.2c-0.4-0.3-0.3,0-0.6-0.3l0,0c-0.1,0.1-0.5-0.3-0.7-0.4c-0.3-0.4,0.4,0.1,0.4,0l-0.5-0.3
						c0.2,0.1,0.1-0.1,0.4,0c-0.3-0.2-0.3-0.3-0.5-0.4c0.4,0.1-0.2-0.4-0.2-0.5C5,23,5.2,23.2,5.3,23.4c0.1,0.2,0.2,0.3,0.2,0.3
						c0,0,0.4,0.2,0.5,0.4l0.3,0c-0.2-0.2-0.6-0.4-0.4-0.4l-0.4-0.2C6,23.5,6,23.5,6.3,23.6c-0.2-0.3-0.5-0.4-0.8-0.6
						c-0.3-0.2-0.5-0.3-0.7-0.6l0.1,0.1c-0.4-0.4-0.7-0.7-0.8-1c0.7,0.8,1.5,1.5,2.3,2.1l-0.1,0c0,0,0,0,0,0C7,24,6.3,23.9,7,24.2
						c0,0-0.1,0-0.1,0c0.3,0.1,0.8,0.4,0.9,0.3c-0.1,0-0.3-0.2-0.4-0.3c0.3,0.2,0.6,0.3,0.9,0.4c0,0,0.1,0.1,0.2,0.1l0,0l0,0
						c0.1,0,0.1,0.1,0.2,0.1c0,0,0,0,0,0c0.4,0.1,0.7,0.3,1.1,0.4C9.8,25.4,10.6,25.6,10.2,25.6z M11.4,25.8c-0.5-0.1-0.1-0.1-0.4-0.2
						c0,0,0,0,0-0.1c0.3,0.1,0.6,0.1,1,0.1C11.7,25.7,11.4,25.6,11.4,25.8z M12.7,25.8c-0.2,0-0.6,0-0.6-0.1c0.2,0,0.3,0,0.2,0
						c0.2,0,0.4,0,0.7,0c0,0,0,0,0.1,0C13,25.8,12.8,25.8,12.7,25.8z M18.5,25.2c-0.4,0.1,0-0.1-0.2-0.1c-0.2,0.3-0.4,0-0.6,0.3
						c-0.4,0.1-0.3,0-0.4,0c0.4-0.1-0.2-0.1,0.2-0.3c-0.4,0-0.2,0.2-0.5,0.3l-0.1-0.1c-0.3,0-0.9,0.1-1.3,0.3c0.4,0-0.2,0.1-0.1,0.2
						c0-0.1,0.5-0.1,0.5-0.1C15.6,25.9,15,26,14.8,26l0.5,0c-0.2,0.1-0.8,0.3-0.8,0.4c-0.2-0.1-0.5,0-0.6-0.1l0.4-0.1l0.1,0.1
						c0.1,0,0.1-0.1,0.2-0.1c-0.2,0-0.8-0.1-0.9-0.2c0.4,0,0.9-0.1,1.4-0.3c1.2-0.2,2.4-0.6,3.4-1.1c0,0,0,0,0,0
						c-0.1,0.1-0.2,0.2-0.3,0.2c0.1,0,0.2-0.1,0.3-0.1l-0.5,0.5c0.3-0.1,0.3-0.4,0.7-0.5C18.8,24.8,18.8,24.9,18.5,25.2z"/>
					<path d="M4,5.4c0,0,0.1-0.1,0.1-0.1C4.1,5.3,4.1,5.4,4,5.4z"/>
					<path d="M1,18.4c0,0.1,0.1,0.1,0.1,0.2C1.1,18.5,1,18.4,1,18.4z"/>
					<path d="M25,18.1c0-0.2,0-0.3,0.1-0.6c0.3,0-0.1,0.5,0.1,0.7c0.2-0.5,0.1-0.7,0.1-1.1C25.1,17.2,24.8,18,25,18.1z"/>
					<polygon points="25.1,18.4 25.2,18.4 25.2,18.1 25.2,18.1 		"/>
					<polygon points="17.4,26 17.3,26.1 17.4,26.1 		"/>
					<polygon points="17.6,26.3 17.7,26.2 17.3,26.4 		"/>
					<path d="M14.7,26.1l0.2-0.1C14.9,26.1,14.6,26.1,14.7,26.1z"/>
					<path d="M12.7,26.7c0.3,0,0.2-0.1,0.1-0.1C13,26.7,12.3,26.6,12.7,26.7z"/>
					<path d="M9.4,25.3c0.1,0,0.2,0.1,0.3,0.1C9.6,25.3,9.6,25.3,9.4,25.3z"/>
					<path d="M8.1,24.8L8.1,24.8c0,0.1,0,0.1,0.1,0.1c0.1,0,0.1,0,0.1,0c0,0,0.1,0,0.1,0c0,0-0.1,0-0.1,0C8.2,24.7,8.1,24.7,8.1,24.8z"
						/>
					<polygon points="9.2,26.3 9.4,26.3 9.1,26.3 		"/>
					<path d="M4.3,23c-0.5-0.6-0.1,0.2-0.4-0.3C4.1,23,4.1,23.2,4,23.2C4.4,23.4,3.8,22.6,4.3,23z"/>
					<path d="M2.6,21.4l0.4,0.3c-0.3-0.2-0.8-0.9-0.9-0.8c0.1,0.3,0.4,0.5,0.5,0.6L2.6,21.4z"/>
					<path d="M2.3,19.2c0.1,0.1,0.1,0.3,0.2,0.4C2.5,19.5,2.4,19.2,2.3,19.2z"/>
					<path d="M0.2,15.3c0-0.2,0-0.3,0-0.5C0.1,14.9,0.2,14.9,0.2,15.3C0.1,15.1,0.1,15,0,14.9C0,15.1,0.2,15.3,0.2,15.3z"/>
					<path d="M5.3,3.8C5.2,3.9,5.1,3.9,5.1,4l0.1-0.1L5.3,3.8z"/>
					<path d="M6.9,3c-0.2,0-0.4,0.2-0.5,0.3C6.7,3.1,6.6,3.2,6.9,3z"/>
					<polygon points="6.3,2.4 6.1,2.6 6.4,2.4 		"/>
					<polygon points="8.4,1.6 8.6,1.4 8.6,1.4 8.3,1.6 		"/>
					<path d="M10.8,0.6c-0.3,0.1-0.4,0.2-0.6,0.4c0.4-0.2,1.3-0.2,1.8-0.4c0.3-0.2,0.1-0.4,0.1-0.6c-0.1-0.1-0.9,0-0.9,0.2
						c0.4,0-0.5,0.2,0.2,0.1c0.1,0.1-0.2,0.2-0.6,0.3c0-0.1,0.3-0.1,0.1-0.2C10.8,0.6,10.7,0.5,10.8,0.6z"/>
					<path d="M10.7,0.1c-0.2,0-0.2,0-0.3,0.1C10.4,0.2,10.5,0.1,10.7,0.1z"/>
					<path d="M14.6,1.6c0,0,0.3,0,0.3-0.1c-0.1,0-0.3,0-0.4,0C14.5,1.5,14.5,1.6,14.6,1.6z"/>
					<path d="M25.7,12.9c0-0.2-0.1-0.7-0.2-0.8c0.1,0.1,0,0.5,0.1,0.6l0,0L25.7,12.9z"/>
				</g>
			</g>
			</svg>';

			return $svg;
		}

		public function woocommerce_template_loop_product_thumbnail (){
			$permalink = esc_url( get_the_permalink() );

			// Sale Product
			ob_start();
			woocommerce_show_product_loop_sale_flash();
			$sale = ob_get_clean();

			global $product;
			$secondary_image = '';
			
			if(method_exists($product, 'get_gallery_image_ids')){
				$attachment_ids = $product->get_gallery_image_ids();
				
				if ($attachment_ids) {
					if(isset($attachment_ids['0'])){
						$secondary_image_id = $attachment_ids['0'];
						$secondary_image = wp_get_attachment_image($secondary_image_id, apply_filters('shop_catalog', 'shop_catalog'));							    		
					}
				}
			}
			$sale_banner = $outofstock_banner = '';
			if(!empty($sale)){
				$sale_banner =  "<div class='woo_banner_wrapper'>";
					$sale_banner .= "<div class='woo_banner sale_banner'>";
						$sale_banner .= "<div class='woo_banner_text'>";
							$sale_banner .= $sale;
							$sale_banner .= $this->get_svg_sale();
						$sale_banner .= "</div>";
					$sale_banner .= "</div>";
				$sale_banner .= "</div>";
			}

			if ( !$product->is_in_stock() ) {
				$outofstock_banner =  "<div class='woo_banner_wrapper'>";
					$outofstock_banner .= "<div class='woo_banner outofstock_banner'>";
						$outofstock_banner .= "<div class='woo_banner_text'>";
							$outofstock_banner .= '<span class="woo_banner_outofstock">' . esc_html__( 'Out of Stock', 'foodmood' ) . '</span>';
							$outofstock_banner .= $this->get_svg_sale();
						$outofstock_banner .= "</div>";
					$outofstock_banner .= "</div>";
				$outofstock_banner .= "</div>";
			}
			
			echo "<div class='woo_product_image shop_media'>";		
				echo "<div class='picture".(empty($secondary_image) ? ' no_effects' : '')."'>";
					echo !empty( $sale_banner ) ? $sale_banner : "";
					echo !empty( $outofstock_banner ) ? $outofstock_banner : "";
					if(function_exists('woocommerce_get_product_thumbnail')){
						echo "<a class='woo_post-link' href='$permalink'>";
							echo woocommerce_get_product_thumbnail();

							if (!empty($secondary_image)) {
						        echo wp_kses_post($secondary_image);
						    }
										
						echo "</a>";						
					}				
				echo "</div>";
			echo '</div>';
		}
		public function loop_products_item_wrapper(){
			echo '<div class="products-post">';
				echo '<div class="products-post_wrapper">';
		}		

		public function loop_products_item_wrapper_close(){
			
			// Add To cart product
			ob_start();	
			echo '<div class="woo_product_btn group_button-woo">';

			echo '<div class="add_to_cart-btn">';
			woocommerce_template_loop_add_to_cart();

			$svg = Foodmood_Theme_Helper::render_svg_flag();
            echo '<div class="add_to_cart-svg">'.$svg.'</div>';

			echo '</div>';

			echo '</div>';

			$add_to_cart = ob_get_clean();
				
				echo !empty($add_to_cart) ? $add_to_cart : "";
				echo '</div>';
			echo '</div>';
		}

		/**
		 * Product gallery thumbnail columns
		 *
		 * @return integer number of columns
		 * @since  1.0.0
		 */
		public function thumbnail_columns() {
			$columns = 4;
			return intval( $columns );
		}

		/**
		 * Related Products Args
		 *
		 * @param  array $args related products args.
		 * @since 1.0.0
		 * @return  array $args related products args
		 */
		public function related_products_args( $args ) {
			$args = array(
				'posts_per_page' => (int) Foodmood_Theme_Helper::get_option('shop_r_products_per_page'),
				'columns'        => (int) Foodmood_Theme_Helper::get_option('shop_related_columns'),
			);

			return $args;
		}		

		/**
		 * Columns Products
		 *
		 * @param  array $args columns products args.
		 * @since 1.0.0
		 * @return  array $args columns products args
		 */
		public function loop_columns( $args ) {
			$columns = (int) Foodmood_Theme_Helper::get_option('shop_column'); // 3 products per row
			return $columns;
		}

		public function wgl_product_columns_wrapper() {
			$columns = (int) Foodmood_Theme_Helper::get_option('shop_column');
			echo '<div class="wgl-products-catalog wgl-products-wrapper columns-' . absint( $columns ) . '">';
		}		

		public function template_loop_product_title(){
			global $product;
			$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
			echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url( $link ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">' . get_the_title() . '</a></h2>';
		}

		public function wgl_sorting_wrapper_open(){
			echo '<div class="wgl-woocommerce-sorting">';
		}		

		public function wgl_sorting_wrapper_close(){
			echo '</div>';
		}

		public function wgl_product_columns_wrapper_open() {
			$columns = (int) Foodmood_Theme_Helper::get_option('shop_column');
			echo '<div class="wgl-products-catalog wgl-products-wrapper columns-' . absint( $columns ) . '">';
		}		
		
		public function wgl_product_columns_wrapper_close() {
			echo '</div>';
		}

		public function template_loop_product_open(){
			echo "<div class='woo_product_content'>";
		}		

		public function template_loop_product_close(){
			echo "</div>";
		}

		public function init_template(){
			$shop_template = is_single() ? 'single' : 'catalog';
			$sb = Foodmood_Theme_Helper::render_sidebars('shop_'.$shop_template);
			$this->row_class = $sb['row_class'];
			$this->column = $sb['column'];
			$this->container_class = $sb['container_class'];
 			$this->content = (isset($sb['content']) && !empty($sb['content']) ) ? $sb['content'] : '';
		}

		public function wgl_page_template_open(){	    
			$this->init_template();
			?>
			<div class="wgl-container single_product<?php echo esc_attr($this->container_class); ?>">
    			<div class="row<?php echo esc_attr($this->row_class); ?>">
					<div id='main-content' class="wgl_col-<?php echo (int)esc_attr($this->column); ?>">
		    <?php
		}

		public function wgl_page_template_close(){
			$this->init_template();
			echo '</div>';
				echo !empty($this->content) ? $this->content : '';
				echo "</div>";
			echo "</div>";
		}

		public function wgl_filter_pagination(){
			$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
			$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
			$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
			$format  = isset( $format ) ? $format : '';

			if ( $total <= 1 ) {
				return;
			}
			return array( // WPCS: XSS ok.
				'base'         => $base,
				'format'       => $format,
				'add_args'     => false,
				'current'      => max( 1, $current ),
				'total'        => $total,
                'prev_text' => '<i class="flaticon-left-arrow"></i>',
                'next_text' => '<i class="flaticon-right-arrow-1"></i>',
				'type'         => 'list',
				'end_size'     => 3,
				'mid_size'     => 3,
			);
		}

		public function wgl_image_thumbnails( $image, $cart_item, $cart_item_key ){
		    $class = 'attachment-woocommerce_thumbnail size-woocommerce_thumbnail wgl-woocommerce_thumbnail'; // Default cart thumbnail class.
		    if(function_exists('aq_resize')){
		    	$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

		    	$image_data = wp_get_attachment_metadata($_product->get_image_id());
		    	$image_meta = isset($image_data['image_meta']) ? $image_data['image_meta'] : array();
		    	$width = '80';
		    	$height = '80';
		    	$image_url = wp_get_attachment_image_src( $_product->get_image_id(), 'full', false );
		    	$image_url[0] = aq_resize($image_url[0], $width, $height, true, true, true);

		    	$image_meta['title'] = isset($image_meta['title']) ? $image_meta['title'] : "";

		    	$image = "<img class='". esc_attr($class) ."' src='" . esc_url( $image_url[0] ) . "' alt='" . esc_attr($image_meta['title']) . "' />";
		    }

		    // Output.
		    return $image;	
		}

		public function template_loop_price( $price = false, $shortcode = false ){

			if( !(bool)$shortcode ){
				$price = Foodmood_Theme_Helper::get_option('shop_catalog_hide_price');
			}
			
			if(!(bool) $price){
				wc_get_template( 'loop/price.php' );
			}
			
		}				

	    public function template_short_description ($hide_content, $symbol_count = false, $shortcode = false) {


			if( !(bool)$shortcode ){
				$hide_content = Foodmood_Theme_Helper::get_option('shop_catalog_hide_content');
				$symbol_count = Foodmood_Theme_Helper::get_option('shop_catalog_letter_count');
				$shortcode = Foodmood_Theme_Helper::get_option('shop_catalog_listing_content');
			}

			if(!(bool) $hide_content){
		    	if(!has_excerpt()){
		    		return;
		    	}

		    	ob_start();
					the_excerpt();
				$post_content = ob_get_clean();

				if(!(bool)$symbol_count) {
					$symbol_count = '400';
				}

				if ( (bool) $shortcode ) {
					$post_content = preg_replace( '~\[[^\]]+\]~', '', $post_content);
					$post_content_stripe_tags = strip_tags($post_content);
					$output = Foodmood_Theme_Helper::modifier_character($post_content_stripe_tags, $symbol_count, "...");
				} else {
					$output = $post_content;
				}
		
				echo '<div class="woocommerce-loop-product__desc"><p>'.$output.'</p></div>';
			}
	    }


		public function template_loop_rating( $rating = false, $shortcode = false ){

			if( !(bool)$shortcode ){
				$rating = Foodmood_Theme_Helper::get_option('shop_catalog_hide_raiting');
			}
			
			if(!(bool) $rating){
				wc_get_template( 'loop/rating.php' );
			}

		}

	}
}

/**/
/* Config and enable extension */
new Foodmood_Woocoommerce ( );

// Foodmood Woocoommerce Helpers

if ( ! function_exists( 'foodmood_woocommerce_breadcrumb' ) ) {
	/**
	 * Output the WooCommerce Breadcrumb.
	 *
	 * @param array $args Arguments.
	 */
	function foodmood_woocommerce_breadcrumb( $args = array() ) {
		$args = wp_parse_args( $args, apply_filters( 'woocommerce_breadcrumb_defaults', array(
			'delimiter'   => '&nbsp;&#47;&nbsp;',
			'wrap_before' => '',
			'wrap_after'  => '',
			'before'      => '',
			'after'       => '',
			'home'        => esc_html_x( 'Home', 'breadcrumb', 'foodmood' ),
		) ) );

		$breadcrumbs = new WC_Breadcrumb();

		$args['breadcrumb'] = $breadcrumbs->generate();

		/**
		 * WooCommerce Breadcrumb hook
		 *
		 * @hooked WC_Structured_Data::generate_breadcrumblist_data() - 10
		 */
		do_action( 'woocommerce_breadcrumb', $breadcrumbs, $args );

		extract($args);

		$out = '';
		if ( ! empty( $breadcrumb ) ) {

			$out .= Foodmood_Theme_Helper::render_html($wrap_before);

			foreach ( $breadcrumb as $key => $crumb ) {

				$out .=  Foodmood_Theme_Helper::render_html($before);

				if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
					$out .=  '<a href="' . esc_url( $crumb[1] ) . '">' . esc_html( $crumb[0] ) . '</a>';
				} else {
					$out .=  '<span class="current">' .( $crumb[0] ). '</span>';
				}

				$out .=  Foodmood_Theme_Helper::render_html($after);

				if ( sizeof( $breadcrumb ) !== $key + 1 ) {
					$out .=  Foodmood_Theme_Helper::render_html($delimiter);
				}
			}
			$out .=  Foodmood_Theme_Helper::render_html($wrap_after);
		}

		return $out;

	}
}


?>
