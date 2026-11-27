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
 * @param int  $current_post_id Current post ID to exclude.
 * @param bool $show_middle_ad Whether to render bottom ads between Latest and Most Read (e.g. Category page).
 */
function buzzmag_render_single_under_post( $current_post_id = 0, $show_middle_ad = false ) {
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

    $most_read_6 = buzzmag_query_most_viewed_hours( 96, 6, $exclude );
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

        <?php
        // Ad Space: Bottom Ads in between categories (Latest News and Most Read on Category page)
        if ( $show_middle_ad && function_exists( 'buzzmag_render_stacked_centered_ads' ) ) {
            buzzmag_render_stacked_centered_ads( 'post_img_bottom_1', 'post_img_bottom_2', 'fl-cat-between-ads' );
        }
        ?>

        <!-- Mobile: Two (300x300) ads between Latest News and Most Read -->
        <?php if ( function_exists( 'buzzmag_is_mobile' ) ? buzzmag_is_mobile() : wp_is_mobile() ) : ?>
            <div class="fl-mobile-only fl-under-between-ads-mobile">
                <?php
                if ( function_exists( 'buzzmag_render_stacked_300_ads' ) ) {
                    buzzmag_render_stacked_300_ads( 'mobile_post_between_latest_1', 'mobile_post_between_latest_2', 'fl-post-between-latest-mostread', 'mobile_home_between_latest_1', 'mobile_home_between_latest_2' );
                }
                ?>
            </div>
        <?php endif; ?>

        <!-- 2. Most Read Posts (Most Viewed in 96h, 6 posts) -->
        <div class="fl-under-block fl-under-most-read">
            <div class="fl-block-header">
                <span class="fl-badge" style="background:#e67e22;"><i class="fa fa-fire"></i></span>
                <h3><?php esc_html_e( 'වැඩිම පිරිසක් කියවූ (Most Read)', 'buzzmag' ); ?></h3>
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
 * Categories: Local, Off road, Business, Sports, Foreign, Political
 *
 * @param int $current_post_id Current post ID.
 */
function buzzmag_render_single_sidebar_categories( $current_post_id = 0 ) {
    $local_slug    = get_theme_mod( 'cat_slug_local', 'local' );
    $offroad_slug  = get_theme_mod( 'cat_slug_offroad', 'off-road' );
    $biz_slug      = get_theme_mod( 'cat_slug_business', 'business' );
    $sports_slug   = get_theme_mod( 'cat_slug_sports', 'sports' );
    $foreign_slug  = get_theme_mod( 'cat_slug_foreign', 'foreign' );
    $political_slug = get_theme_mod( 'cat_slug_political', get_theme_mod( 'cat_slug_politics', 'political' ) );

    $categories = array(
        array(
            'title' => get_theme_mod( 'cat_title_local', 'Local News' ),
            'slug'  => $local_slug,
            'icon'  => 'fa-map-marker',
            'color' => '#2980b9',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_political', get_theme_mod( 'cat_title_politics', 'Political' ) ),
            'slug'  => $political_slug,
            'icon'  => 'fa-balance-scale',
            'color' => '#8e44ad',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_offroad', 'Off Road' ),
            'slug'  => $offroad_slug,
            'icon'  => 'fa-road',
            'color' => '#e67e22',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_business', 'Business' ),
            'slug'  => $biz_slug,
            'icon'  => 'fa-line-chart',
            'color' => '#27ae60',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_sports', 'Sports' ),
            'slug'  => $sports_slug,
            'icon'  => 'fa-trophy',
            'color' => '#ed0e28',
        ),
        array(
            'title' => get_theme_mod( 'cat_title_foreign', 'Foreign' ),
            'slug'  => $foreign_slug,
            'icon'  => 'fa-globe',
            'color' => '#16a085',
        ),
    );
    ?>
    <div class="fl-single-sidebar-categories">
        <?php
        // 1. Beginning of Side Panel (300x300 Ad)
        if ( function_exists( 'buzzmag_render_ad_space' ) ) {
            buzzmag_render_ad_space( 'post_sidebar_top', 'fl-ad-300x300' );
        }
        ?>

        <?php foreach ( $categories as $idx => $cat ) : ?>
            <div class="fl-sidebar-cat-widget">
                <?php buzzmag_render_category_3d_card( $cat['title'], $cat['slug'], 3, $cat['icon'], $cat['color'] ); ?>
            </div>

            <?php
            // Side Panel Ad 1: After Category 2 (Political, idx 1)
            if ( 1 === $idx && function_exists( 'buzzmag_render_ad_space' ) ) {
                buzzmag_render_ad_space( 'post_sidebar_ad_1', 'fl-ad-300x300' );
            }

            // Side Panel Middle: Two Vertical Ads (155x600 side-by-side, after Category 3 Off Road, idx 2)
            if ( 2 === $idx && function_exists( 'buzzmag_render_twin_vertical_ads' ) ) {
                buzzmag_render_twin_vertical_ads( 'post_sidebar_vert_1', 'post_sidebar_vert_2' );
            }

            // Side Panel Ad 2: After Category 4 (Business, idx 3)
            if ( 3 === $idx && function_exists( 'buzzmag_render_ad_space' ) ) {
                buzzmag_render_ad_space( 'post_sidebar_ad_2', 'fl-ad-300x300' );
            }

            // Side Panel Ad 3: After Category 5 (Sports, idx 4)
            if ( 4 === $idx && function_exists( 'buzzmag_render_ad_space' ) ) {
                buzzmag_render_ad_space( 'post_sidebar_ad_3', 'fl-ad-300x300' );
            }

            // Side Panel Ad 4: After Category 6 (Foreign, idx 5)
            if ( 5 === $idx && function_exists( 'buzzmag_render_ad_space' ) ) {
                buzzmag_render_ad_space( 'post_sidebar_ad_4', 'fl-ad-300x300' );
            }
            ?>
        <?php endforeach; ?>
    </div>

    <!-- Mobile-Only: Homepage 3rd Column Utilities (Videos & Sri Lankan Utilities) at bottom of single post view -->
    <?php if ( function_exists( 'buzzmag_is_mobile' ) ? buzzmag_is_mobile() : wp_is_mobile() ) : ?>
        <div class="fl-mobile-only fl-single-mobile-utilities-wrap">
            <div class="fl-mobile-videos-utilities">
                <?php buzzmag_render_mobile_column_3_utilities(); ?>
            </div>
        </div>
    <?php endif; ?>
    <?php
}

