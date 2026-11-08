<?php 
// Mega Menu By FlatLayers

// Add MegaMenu Option
function buzzmag_megamenu_option($item_id, $item, $depth) {
    if ( $depth == 0 && $item->object == 'category' && $item->menu_item_parent == '0' ) {
        $megamenu = get_post_meta($item_id, '_menu_item_megamenu', true);
        ?>
        <p class="description description-wide">
            <label for="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>" >
                <input type="checkbox" 
                    id="edit-menu-item-megamenu-<?php echo esc_attr($item_id); ?>" 
                    name="menu-item-megamenu[<?php echo esc_attr($item_id); ?>]" 
                    <?php checked($megamenu, true); ?> 
                />
                <?php esc_html_e('Enable Mega Menu for this category.', 'buzzmag'); ?>
            </label>
            <br><?php esc_html_e('Mega Menu will only display when menu item is ( Category, First level, Main Menu Location, Does not have submenu items.', 'buzzmag' ); ?>
        </p>
        <?php
    }
}
add_action('wp_nav_menu_item_custom_fields', 'buzzmag_megamenu_option', 10, 3);

// Update MegaMenu
function buzzmag_update_megamenu_option($menu_id, $menu_item_db_id) {
    $megamenu = (isset($_POST['menu-item-megamenu'][$menu_item_db_id]) && $_POST['menu-item-megamenu'][$menu_item_db_id] == 'on') ? true : false;
    update_post_meta($menu_item_db_id, '_menu_item_megamenu', $megamenu);
}
add_action('wp_update_nav_menu_item', 'buzzmag_update_megamenu_option', 10, 2);

// Add MegaMenu Class to FrontEnd
function buzzmag_megamenu_class( $classes, $item, $args ){
    if ( 'main-menu' == $args->theme_location ) {
        $megamenu = get_post_meta($item->ID, '_menu_item_megamenu', true);
        if ( !empty( $megamenu ) && $item->object == 'category' && $item->menu_item_parent == '0' && !in_array( 'menu-item-has-children', $item->classes ) ) {
            $classes[] = 'fl-megamenu';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class' , 'buzzmag_megamenu_class' , 10 , 3);


// Category MegaMenu FrontEnd
function buzzmag_walker_nav_menu_start_el( $item_output, $item, $depth, $args ) {

    if ( 'main-menu' !== $args->theme_location && 'footer-menu' !== $args->theme_location ) {
        // Add arrow to menu has child
        if ( in_array('menu-item-has-children', $item->classes) ) {
            $item_output .='<span class="line"></span><span class="arrow"><i class="fa fa-angle-right"></i></span>';
        }
        return $item_output;
    }

    $megamenu = get_post_meta($item->ID, '_menu_item_megamenu', true);

    // Check if element as a category, submenu, option, depth
    if ( !empty( $megamenu ) && $item->object == 'category' && $item->menu_item_parent == '0' && !in_array( 'menu-item-has-children', $item->classes ) && $depth == 0 ) {

        //Check for subcategories
        $subcats = get_categories( array(
            'child_of' => $item->object_id,
            'number' => 5,
        ));

        $item_output .= '<div class="megamenu">';

            if ( !empty($subcats) ) {        
                $item_output .= '<div class="cats-list">';
                    $item_output .=  '<a class="cat-link active" href="#megamenu-cat-'. $item->object_id. '">'. esc_html__( 'All', 'buzzmag' ) .'</a>';
                    foreach ($subcats as $cat) {
                        $item_output .=  '<a class="cat-link" href="#megamenu-cat-'. $cat->term_id .'" cat-id="'. $cat->term_id .'">'. $cat->name .'</a>';
                    }
                $item_output .= '</div>';
            }

            // Parent Cat
            $item_output .= '<ul id="megamenu-cat-'. $item->object_id. '" class="megamenu-list ajax-loaded">';
                $item_output .= buzzmag_megamenu_posts($item->object_id);
            $item_output .='</ul>';

            // Child Cats
            if ( !empty($subcats) ) {
                foreach ($subcats as $cat) {
                    $item_output .= '<ul id="megamenu-cat-'. $cat->term_id .'" class="megamenu-list"></ul>';
                }
            }

        $item_output .= '</div>';
    }
    return $item_output;
}
add_filter( 'walker_nav_menu_start_el', 'buzzmag_walker_nav_menu_start_el', 10, 4 );




// Get MegaMenu Posts With Ajax
function buzzmag_megamenu_posts($term_id) {

    global $post;
    $loop = new WP_Query(
        array(
            'post_type'      => 'post',  
            'post_status'    => 'publish',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $term_id,
                ),
            ),
            'posts_per_page' => 5,
        )
    );
    ob_start();
    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post(); ?>
            <li>
                <div class="fl-post">
                    <div class="fl-picture">
                        <a href="<?php the_permalink(); ?>"><?php the_post_thumbnail( 'buzzmag_small' ); ?></a> 
                        <?php
                        if ( has_post_format( 'audio' ) ) {
                            echo '<div class="format-overlay"><i class="fa fa-music"></i></div>';
                        } elseif ( has_post_format( 'video' ) ) {
                            echo '<div class="format-overlay"><i class="fa fa-play"></i></div>';
                        } elseif ( has_post_format( 'gallery' ) ) {
                            echo '<div class="format-overlay"><i class="fa fa-camera"></i></div>';
                        }
                        ?>
                    </div>
                    <a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </div>
            </li>
        <?php }
        wp_reset_postdata();
    }

    return ob_get_clean();

}

// Mega Menu Ajax Posts
function buzzmag_megamenu_posts_ajax() {
    $term_id = $_POST['term_id'];
    wp_die( buzzmag_megamenu_posts($term_id) );
}
add_action( 'wp_ajax_buzzmag_megamenu_posts_ajax', 'buzzmag_megamenu_posts_ajax' );
add_action( 'wp_ajax_nopriv_buzzmag_megamenu_posts_ajax', 'buzzmag_megamenu_posts_ajax' );


