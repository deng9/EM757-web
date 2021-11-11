<?php
global $wgl_products_atts;

extract($wgl_products_atts);

$shortcode = true;

$image_size = 'wgl-540-660'; 

switch ($products_columns) {
    case '12':
        $image_size = 'full';
        break;    
    case '6':
        $image_size = 'wgl-740-740';
        break;
    
    default:
        $image_size = 'wgl-540-660';
        break;
} 

if($products_layout === 'masonry'){
    $image_size = 'full';
}

global $wgl_query_vars;
if(!empty($wgl_query_vars)){
    $query = $wgl_query_vars;
}

while ($query->have_posts()) : $query->the_post();          
    global $product;
    
    ob_start();
        wc_product_class('wgl_col-'.esc_attr($products_columns).' item', $product);
    $product_class = ob_get_clean();
    
    echo '<div '.$product_class.'>';

    $single = new Foodmood_Woocoommerce();

        $single->loop_products_item_wrapper();             

            $single->woocommerce_template_loop_product_thumbnail($image_size, $aq_image = true );            
            
            /**
            * Hook: woocommerce_products_loop_item_title.
            *
            * @hooked woocommerce_template_loop_product_title - 10
            */
            
            $single->template_loop_product_open();
                
                $single->template_loop_product_title($image_size, $aq_image = true);
                /**
                * Hook: woocommerce_after_products_loop_item_title.
                *
                * @hooked woocommerce_template_loop_rating - 5
                * @hooked woocommerce_template_loop_price - 10
                * @hooked template_short_description
                */
               
               
                $single->template_loop_rating($hide_raiting, $shortcode );

                $single->template_short_description($hide_content, $content_letter_count, $shortcode );   

                $single->template_loop_price($hide_price,  $shortcode );


            $single->template_loop_product_close();

        $single->loop_products_item_wrapper_close();       

    echo '</div>';

endwhile;
wp_reset_postdata();
