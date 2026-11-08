<?php

// FlatLayers Buzzmag WooCommerce Functions
function buzzmag_enqueue_woocommerce_style() {
    wp_enqueue_style( 'buzzmag-woocommerce-style', fl_theme_path . '/css/woocommerce.css', array('woocommerce-general', 'buzzmag-style'), fl_theme_version );

    if ( is_rtl() ) {
        wp_enqueue_style( 'buzzmag-woocommerce-rtl-style', fl_theme_path . '/css/woocommerce-rtl.css', array('woocommerce-general', 'buzzmag-style', 'buzzmag-woocommerce-style'), fl_theme_version );
    }
}
add_action( 'wp_enqueue_scripts', 'buzzmag_enqueue_woocommerce_style' );


/* ====== Remove Content Wrappers ====== */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper');
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end');

// Woocommerce Layout
function buzzmag_woocommerce_layout() {
    $sidebar = true;
    $class = '';
    if ( is_product() ) {
        if ( get_theme_mod('hide_sidebar_product') ) {
            $sidebar = false;
            $class = 'fl-full-width';            
        }

    } else {
        if ( get_theme_mod('shop_layout') === 'grid' ) {
            $sidebar = false;
            $class = 'fl-full-width';
        }
    }

    return array(
        'class'   => $class,
        'sidebar' => $sidebar,
    );
}


/* ====== Change Main Content Wrapper Start ====== */
function buzzmag_woocommerce_before_wrapper() {

    // Remove Breadcrumbs brfore main content in Home and single product
    if ( is_home() || is_product() ) {    
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
    }

    echo '<div class="fl-container clearfix">';

    // Open Archive Shop Wrap
    if ( !is_product() ) {
            echo '<div class="fl-box">';
                if ( is_product_category() ) {
                    $cat = get_queried_object();
                    $thumbnail_id = get_term_meta( $cat->term_id, 'thumbnail_id', true );
                    $image = wp_get_attachment_image_src( $thumbnail_id, 'thumbnail' );
                    if ( !empty($image) ) {
                        echo '<div class="avatar">';
                            echo '<img loading="lazy" src="'. esc_url( $image[0] ) .'" alt="' . esc_attr( $cat->name ) . '">';
                        echo'</div>';
                    }
                }
                echo'<div class="info">';
    } else {
        echo '<div id="fl-post-container" class="'. buzzmag_woocommerce_layout()['class'] .'">';
    }


}
add_action('woocommerce_before_main_content', 'buzzmag_woocommerce_before_wrapper');


/* ====== Change Main Content Wrapper End ====== */
function buzzmag_woocommerce_after_wrapper() {
        
        echo '</div>'; // Close fl-post-container
        if ( buzzmag_woocommerce_layout()['sidebar'] === true ) {
            get_sidebar();
        }
    echo '</div>'; // Close fl-container
}
add_action('woocommerce_after_main_content', 'buzzmag_woocommerce_after_wrapper');



/* ====== Close Archive Shop Wrap ====== */
function buzzmag_woocommerce_after_archive() {
    // Close Archive Shop Wrap
    if ( !is_product() ) {
                echo '</div>'; // Close info
            echo '</div>'; // Close fl-box
        echo '</div>'; // Close fl-container
        echo '<div class="fl-container clearfix">';       
            echo '<div id="fl-post-container" class="'. buzzmag_woocommerce_layout()['class'] .'">';
    }
}
add_action('woocommerce_archive_description', 'buzzmag_woocommerce_after_archive');


/* ====== Change Products Columns ====== */
function buzzmag_woocommerce_loop_columns() {  
    if ( buzzmag_woocommerce_layout()['sidebar'] === true ) {
        return 3; // 3 products per row with sidebar
    } else {
        return 4; // 4 products per row without sidebar
    }
}
add_filter('loop_shop_columns', 'buzzmag_woocommerce_loop_columns');

/* ====== Ajax update cart icon ====== */
function buzzmag_woocommerce_header_add_to_cart_fragment( $fragments ) {
    ob_start();
    ?>
    <a class="cart-contents" href="<?php echo wc_get_cart_url(); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'buzzmag' ); ?>">
        <i class="fa fa-shopping-bag"></i>                             
        <?php if ( WC()->cart->get_cart_contents_count() != 0 ) { ?>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php } ?>
    </a>
    <?php
    
    $fragments['a.cart-contents'] = ob_get_clean();
    
    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'buzzmag_woocommerce_header_add_to_cart_fragment' );


/* ====== Add Breadcurmb to Single Product Page ====== */
add_action('woocommerce_single_product_summary', 'woocommerce_breadcrumb', 0, 0);

/* ====== Remove Default Sidebar ====== */
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );