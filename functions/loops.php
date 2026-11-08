<?php

// $loop
// Used in all other loops
function buzzmag_loop($loop, $thumb_size) {
    if ( $loop->query['paged'] == 1 ) {
        echo '<div class="fl-loop-posts">';
    }

    if ( $loop->have_posts() ) {
        while ( $loop->have_posts() ) {
            $loop->the_post();
            get_template_part( 'includes/loop-post', null, array( 'thumb_size' => $thumb_size ) );
        }
    } else {
        echo '<div class="fl-ajax-end">'. esc_html__('Sorry, No Posts Found!', 'buzzmag') .'</div>';
    }

    if ( $loop->query['paged'] == 1 ) {
        echo '</div>';
    }
}



// Pagination
// Load More & Infinite Scroll
function buzzmag_pagination($loop_name, $current, $max) {
    $class = '';
    if ( get_theme_mod('infinite_scroll') ) {
        $class = 'infinite';
    }

    get_next_posts_link();

    if ( $current == 1 && $max > 1 ) {
        echo '<a href="#" class="fl-load-more '. esc_attr($class) .'" data-loop="'. esc_attr($loop_name) .'" current-page="'. esc_attr($current) .'" max-pages="'. esc_attr($max) .'"><i class="fa fa-refresh"></i>'. esc_html__('Load More Posts', 'buzzmag') .'</a>';
    }
}



// Default Posts Loop
// Used in all Archives and index.php
function buzzmag_default_loop($query_vars, $page, $thumb_size) {
    
    if ( $query_vars == false ) {
        global $wp_query;
        $query_vars = $wp_query->query;
    }

    $query_vars['paged'] = $page;
    $query_vars['post_status'] = 'publish';

    $loop = new WP_Query( $query_vars );

    ob_start();

    buzzmag_loop($loop, $thumb_size);

    buzzmag_pagination('default', $page, $loop->max_num_pages);
    
    return ob_get_clean();
}

// Latest Posts -> Used only in
// templates/loop-latest.php page template
function buzzmag_latest_loop($page, $thumb_size) {
    $loop = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $page,
        )
    );

    ob_start();

    buzzmag_loop($loop, $thumb_size);

    buzzmag_pagination('latest', $page, $loop->max_num_pages);
            
    return ob_get_clean();
}


// Trending Posts
function buzzmag_trending_loop($page, $thumb_size) {
    $date = get_theme_mod('trending_date', '30') . ' days ago';
    $loop = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'meta_key' => 'post_views_count',
            'orderby' => 'meta_value_num',
            'ignore_sticky_posts' => 1,
            'paged' => $page,
            'order' => 'DESC',
            // Using the date_query to filter posts from last date
            'date_query' => array(
                array(
                    'after' => $date
                )
            )
        )
    );

    ob_start();

    buzzmag_loop($loop, $thumb_size);

    buzzmag_pagination('trending', $page, $loop->max_num_pages);
            
    return ob_get_clean();
}


// Audio Posts
function buzzmag_audio_loop($page, $thumb_size) {
    $loop = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array( 'post-format-audio' ),
                )
            )
        )
    );

    ob_start();

    buzzmag_loop($loop, $thumb_size);

    buzzmag_pagination('audio', $page, $loop->max_num_pages);

    return ob_get_clean();
}


// Video Posts
function buzzmag_video_loop($page, $thumb_size) {
    $loop = new WP_Query(
        array(            
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array( 'post-format-video' ),
                )
            )
        )
    );

    ob_start();

    buzzmag_loop($loop, $thumb_size);

    buzzmag_pagination('video', $page, $loop->max_num_pages);

    return ob_get_clean();
}

// Gallery Posts
function buzzmag_gallery_loop($page, $thumb_size) {
    $loop = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'paged' => $page,
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field' => 'slug',
                    'terms' => array( 'post-format-gallery' ),
                )
            )
        )
    );

    ob_start();

    buzzmag_loop($loop, $thumb_size);

    buzzmag_pagination('gallery', $page, $loop->max_num_pages);

    return ob_get_clean();
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////

// Tabs Call Ajax
function buzzmag_loops_ajax() {
    $loop = $_POST['loop'];
    $next = $_POST['next'];
    $thumb_size = $_POST['thumb_size'];

    switch ($loop) {
        case 'trending':
            $loopSet = buzzmag_trending_loop($next, $thumb_size);
            break;

        case 'audio':
            $loopSet = buzzmag_audio_loop($next, $thumb_size);
            break;

        case 'video':
            $loopSet = buzzmag_video_loop($next, $thumb_size);
            break;

        case 'gallery':
            $loopSet = buzzmag_gallery_loop($next, $thumb_size);
            break;

        case 'latest':
            $loopSet = buzzmag_latest_loop($next, $thumb_size);
            break;

        case 'default':
            // Query vars -> only used in default loop 
            $query_vars = json_decode( stripslashes( $_POST['query_vars'] ), true );
            $loopSet = buzzmag_default_loop($query_vars, $next, $thumb_size);
            break;
        
    }

    wp_die( $loopSet );
}
add_action( 'wp_ajax_buzzmag_loops_ajax', 'buzzmag_loops_ajax' );
add_action( 'wp_ajax_nopriv_buzzmag_loops_ajax', 'buzzmag_loops_ajax' );
