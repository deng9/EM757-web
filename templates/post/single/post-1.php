<?php
    $single = Foodmood_SinglePost::getInstance();
    $single->set_data();

    $title = get_the_title();

	$show_likes = Foodmood_Theme_Helper::get_option('single_likes');
	$show_share = Foodmood_Theme_Helper::get_option('single_share');
	$show_views = Foodmood_Theme_Helper::get_option('single_views');
	$single_author_info = Foodmood_Theme_Helper::get_option('single_author_info');
	$single_meta = Foodmood_Theme_Helper::get_option('single_meta');
	$single_cats = Foodmood_Theme_Helper::get_option('single_meta_categories');
	$show_tags = Foodmood_Theme_Helper::get_option('single_meta_tags');
	$single->set_post_views(get_the_ID());

	$meta_args = $meta_args_date = array();
 
	if ( !(bool)$single_meta ) {
		$meta_args['author'] = !(bool)Foodmood_Theme_Helper::get_option('single_meta_author');
		$meta_args_date['date'] = !(bool)Foodmood_Theme_Helper::get_option('single_meta_date');
		$meta_args['comments'] = !(bool)Foodmood_Theme_Helper::get_option('single_meta_comments');
		$meta_args['category'] = !(bool)Foodmood_Theme_Helper::get_option('single_meta_categories');	
	} 

?>

<div class="blog-post blog-post-single-item format-<?php echo esc_attr($single->get_pf()); ?>">
	<div <?php post_class("single_meta"); ?>>
		<div class="item_wrapper">
			<div class="blog-post_content">
				<?php				
					//Post Meta render date, author
					if ( !(bool)$single_meta ) {
						$single->render_post_meta($meta_args);
					}					
				?>
				<h1 class="blog-post_title"><?php echo get_the_title(); ?></h1>	
 
				<?php
					
					$single->render_featured(false, 'full', false, !(bool)$single_meta, $meta_args_date);	
			
					the_content();

					wp_link_pages(array('before' => '<div class="page-link"><span class="pagger_info_text">' . esc_html__('Pages', 'foodmood') . ': </span>', 'after' => '</div>'));

					if (has_tag() || (bool)$show_share || (bool)$show_likes || (bool)$show_views) {
						echo '<div class="post_info single_post_info">';

						if ( (bool)$show_likes || (bool)$show_views ) echo '<div class="blog-post_meta-wrap">';

						if(has_tag() && !(bool) $show_tags){
							echo "<div class='tagcloud-wrapper'>";
								the_tags('<div class="tagcloud">', ' ', '</div>');
							echo "</div>";						
						}

						if ( (bool)$show_likes || (bool)$show_views )  echo '<div class="blog-post_info-wrap">';

							// Views in blog
							if ( (bool)$show_views ) : ?>              
								<div class="blog-post_views-wrap">
									<?php
									$single->get_post_views(get_the_ID());
									?>
								</div>
								<?php
							endif;

							if ( (bool)$show_likes ) : ?>
							<?php
							echo '<div class="blog-post_likes-wrap">';
								if ( (bool)$show_likes && function_exists('wgl_simple_likes')) {
									echo wgl_simple_likes()->likes_button( get_the_ID(), 0 );
								} 
							echo '</div>';
							endif;	
						
						if ( (bool)$show_likes || (bool)$show_views ): ?> 
	                        </div>   
	                        </div>   
	                    	<?php
						endif;

						// Share in blog
						if ( (bool)$show_share && function_exists('wgl_theme_helper') ) : ?>
							<div class='divider_post_info'></div>
							<div class="blog-post_meta_share">       
								<div class="single_info-share_social-wpapper">
						  			<?php echo wgl_theme_helper()->render_post_share('yes'); ?>
								</div>   
							</div>
						<?php
						endif; 

						echo "</div>";
					}else{
						echo "<div class='divider_post_info'></div>";
					}

				if ( (bool)$single_author_info ) {
					$single->render_author_info();
				} 
				?>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>