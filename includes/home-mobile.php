<?php
/**
 * Mobile Homepage Layout
 *
 * Structure:
 * - Lead Post as Main Post (3D)
 * - Latest 10 Posts (3D each post)
 * - Top Story: 6 posts (within week / 7 days) (3D each post)
 * - Category Cards (3 posts from each): Local, Off road, Business, Sports, Foreign, Featured (3D overall card)
 * - End of Page: Video / YouTube column (as desktop 3rd column)
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$lead_post = buzzmag_get_lead_post();
$lead_id   = $lead_post ? $lead_post->ID : 0;

// Category slugs with Customizer overrides
$local_slug    = get_theme_mod( 'cat_slug_local', 'local' );
$offroad_slug  = get_theme_mod( 'cat_slug_offroad', 'off-road' );
$biz_slug      = get_theme_mod( 'cat_slug_business', 'business' );
$sports_slug   = get_theme_mod( 'cat_slug_sports', 'sports' );
$foreign_slug  = get_theme_mod( 'cat_slug_foreign', 'foreign' );
$featured_slug = get_theme_mod( 'cat_slug_featured', 'featured' );
?>

<div class="fl-home-mobile-wrapper fl-mobile-only">
    <!-- 1. Lead Post as Main Post (3D) -->
    <?php if ( $lead_post ) : ?>
        <section class="fl-mobile-section fl-mobile-lead">
            <?php buzzmag_render_3d_post_card( $lead_post, 'lead' ); ?>
        </section>
    <?php endif; ?>

    <!-- 2. Latest 10 Posts (3D each post) -->
    <section class="fl-mobile-section fl-mobile-latest">
        <div class="fl-mobile-section-header">
            <span class="fl-badge" style="background:#ed0e28;"><i class="fa fa-bolt"></i></span>
            <h3><?php esc_html_e( 'නවතම පුවත් (Latest News)', 'buzzmag' ); ?></h3>
        </div>
        <div class="fl-mobile-posts-list">
            <?php
            $mobile_latest = buzzmag_query_latest_posts_ex_lead( $lead_id, 10 );
            if ( $mobile_latest->have_posts() ) :
                while ( $mobile_latest->have_posts() ) :
                    $mobile_latest->the_post();
                    buzzmag_render_3d_post_card( get_the_ID(), 'compact-row' );
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- 3. Top Story: 6 Posts (Within Week) (3D each post) -->
    <section class="fl-mobile-section fl-mobile-top-stories">
        <div class="fl-mobile-section-header">
            <span class="fl-badge" style="background:#e67e22;"><i class="fa fa-star"></i></span>
            <h3><?php esc_html_e( 'ප්‍රමුඛ පුවත් (Top Stories)', 'buzzmag' ); ?></h3>
        </div>
        <div class="fl-mobile-grid-cards">
            <?php
            $top_stories = buzzmag_query_top_stories_week( 6, array( $lead_id ) );
            if ( $top_stories->have_posts() ) :
                while ( $top_stories->have_posts() ) :
                    $top_stories->the_post();
                    buzzmag_render_3d_post_card( get_the_ID(), 'horizontal-card' );
                endwhile;
                wp_reset_postdata();
            endif;
            ?>
        </div>
    </section>

    <!-- 4. Category Blocks (3 Posts from each): Local, Off road, Business, Sports, Foreign, Featured -->
    <section class="fl-mobile-section fl-mobile-categories">
        <!-- 1. Local News -->
        <?php
        buzzmag_render_category_3d_card(
            get_theme_mod( 'cat_title_local', 'Local News' ),
            $local_slug,
            3,
            'fa-map-marker',
            '#2980b9'
        );
        ?>

        <!-- 2. Off Road -->
        <?php
        buzzmag_render_category_3d_card(
            get_theme_mod( 'cat_title_offroad', 'Off Road' ),
            $offroad_slug,
            3,
            'fa-road',
            '#e67e22'
        );
        ?>

        <!-- 3. Business -->
        <?php
        buzzmag_render_category_3d_card(
            get_theme_mod( 'cat_title_business', 'Business' ),
            $biz_slug,
            3,
            'fa-line-chart',
            '#27ae60'
        );
        ?>

        <!-- 4. Sports -->
        <?php
        buzzmag_render_category_3d_card(
            get_theme_mod( 'cat_title_sports', 'Sports' ),
            $sports_slug,
            3,
            'fa-trophy',
            '#ed0e28'
        );
        ?>

        <!-- 5. Foreign -->
        <?php
        buzzmag_render_category_3d_card(
            get_theme_mod( 'cat_title_foreign', 'Foreign' ),
            $foreign_slug,
            3,
            'fa-globe',
            '#16a085'
        );
        ?>

        <!-- 6. Featured -->
        <?php
        buzzmag_render_category_3d_card(
            get_theme_mod( 'cat_title_featured', 'Featured' ),
            $featured_slug,
            3,
            'fa-bookmark',
            '#8e44ad'
        );
        ?>
    </section>

    <!-- 5. End of Page: Video / YouTube column (as desktop 3rd column) & Utilities -->
    <section class="fl-mobile-section fl-mobile-videos-utilities">
        <?php buzzmag_render_column_3_utilities(); ?>
    </section>
</div>

