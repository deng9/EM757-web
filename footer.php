<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #main div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Foodmood
 * @since 1.0
 * @version 1.0
 */
global $foodmood_dynamic_css;

$scroll_up = Foodmood_Theme_Helper::get_option('scroll_up');
?>

	</main>
    <?php

    /**
    * Elementor Pro Footer Render
    */
    do_action('foodmood_elementor_pro_footer');

    /**
    * Check WGL footer active option
    */
    $footer = apply_filters( 'foodmood_footer_enable', true);
    $footer_switch = $footer['footer_switch'] ?? '';
    $copyright_switch = $footer['copyright_switch'] ?? '';
    if( $footer_switch || $copyright_switch ){
        get_template_part('templates/section', 'footer');
    }

    /**
    * Runs after main
    */
    do_action( 'foodmood_after_main_content' );

    wp_footer();
    ?>
</body>
</html>