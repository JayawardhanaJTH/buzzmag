<?php
/**
 * Single Post Under-Post Modules & 6-Category Sidebar
 *
 * Implements:
 * - Under post: Latest (6 posts) & Most Read (under 36hr most view 6)
 * - Sidebar: Main 6 categories with 3 posts each (3D for category)
 *   (Local, Off road, Business, Sports, Foreign, Featured)
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render Under-Post Blocks: Latest (6 posts) and Most Read (last 36 hours, 6 posts)
 *
 * @param int $current_post_id Current post ID to exclude.
 */
function buzzmag_render_single_under_post( $current_post_id = 0 ) {
    $exclude = array();
    if ( ! empty( $current_post_id ) ) {
        $exclude[] = (int) $current_post_id;
    }

    $latest_6 = new WP_Query( array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 6,
        'post__not_in'        => $exclude,
        'ignore_sticky_posts' => 1,
    ) );

    $most_read_6 = buzzmag_query_most_viewed_hours( 36, 6, $exclude );
    ?>
    <div class="fl-single-under-post-blocks">
        <!-- 1. Latest Posts (6 posts) -->
        <div class="fl-under-block fl-under-latest">
            <div class="fl-block-header">
                <span class="fl-badge" style="background:#ed0e28;"><i class="fa fa-bolt"></i></span>
                <h3><?php esc_html_e( 'නවතම පුවත් (Latest News)', 'buzzmag' ); ?></h3>
            </div>
            <div class="fl-3d-grid-3">
                <?php if ( $latest_6->have_posts() ) :
                    while ( $latest_6->have_posts() ) :
                        $latest_6->the_post();
                        buzzmag_render_3d_post_card( get_the_ID(), 'card' );
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>

        <!-- 2. Most Read Posts (Under 36 hours, 6 posts) -->
        <div class="fl-under-block fl-under-most-read">
            <div class="fl-block-header">
                <span class="fl-badge" style="background:#e67e22;"><i class="fa fa-fire"></i></span>
                <h3><?php esc_html_e( 'පැය 36 තුළ වැඩිම පිරිසක් කියවූ (Most Read - Last 36h)', 'buzzmag' ); ?></h3>
            </div>
            <div class="fl-3d-grid-3">
                <?php if ( $most_read_6->have_posts() ) :
                    while ( $most_read_6->have_posts() ) :
                        $most_read_6->the_post();
                        buzzmag_render_3d_post_card( get_the_ID(), 'card' );
                    endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render Single Post Sidebar 6 Main Categories (3 posts each in 3D category cards)
 *
 * Categories: Local, Off road, Business, Sports, Foreign, Featured
 *
 * @param int $current_post_id Current post ID.
 */
function buzzmag_render_single_sidebar_categories( $current_post_id = 0 ) {
    $local_slug    = get_theme_mod( 'cat_slug_local', 'local' );
    $offroad_slug  = get_theme_mod( 'cat_slug_offroad', 'off-road' );
    $biz_slug      = get_theme_mod( 'cat_slug_business', 'business' );
    $sports_slug   = get_theme_mod( 'cat_slug_sports', 'sports' );
    $foreign_slug  = get_theme_mod( 'cat_slug_foreign', 'foreign' );
    $featured_slug = get_theme_mod( 'cat_slug_featured', 'featured' );

    $categories = array(
        array(
            'title' => get_theme_mod( 'cat_title_local', 'දේශීය පුවත් (Local)' ),
            'slug'  => $local_slug,
            'icon'  => 'fa-map-marker',
            'color' => '#2980b9',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_offroad', 'පිටරට / Off Road' ),
            'slug'  => $offroad_slug,
            'icon'  => 'fa-road',
            'color' => '#e67e22',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_business', 'ව්‍යාපාරික (Business)' ),
            'slug'  => $biz_slug,
            'icon'  => 'fa-line-chart',
            'color' => '#27ae60',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_sports', 'ක්‍රීඩා (Sports)' ),
            'slug'  => $sports_slug,
            'icon'  => 'fa-trophy',
            'color' => '#ed0e28',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_foreign', 'විදේශීය පුවත් (Foreign)' ),
            'slug'  => $foreign_slug,
            'icon'  => 'fa-globe',
            'color' => '#16a085',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_featured', 'විශේෂාංග (Featured)' ),
            'slug'  => $featured_slug,
            'icon'  => 'fa-bookmark',
            'color' => '#8e44ad',
        ),
    );
    ?>
    <div class="fl-single-sidebar-categories fl-desktop-only">
        <?php foreach ( $categories as $cat ) : ?>
            <div class="fl-sidebar-cat-widget">
                <?php buzzmag_render_category_3d_card( $cat['title'], $cat['slug'], 3, $cat['icon'], $cat['color'] ); ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?php
}

