<?php
/**
 * Desktop Homepage Layout (Ada Derana Sinhala style)
 *
 * Structure:
 * - Lead Post Section (3D Hero card)
 * - 3-Column Grid:
 *   - Col 1: Latest 10 posts (excluding lead) + Top Viewed post from last 4 days
 *   - Col 2: Category blocks (5 posts each) - Local, Off road, Business, Sports
 *   - Col 3: Video channels, Calendar, Rahu Kalaya, Subha Dishawa, Maru Sitina, Cartoon, WhatsApp Banner
 * - Below Sections: Politics (6 posts) + Featured (6 posts)
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$lead_post = buzzmag_get_lead_post();
$lead_id   = $lead_post ? $lead_post->ID : 0;

// Category slugs with Customizer overrides
$local_slug   = get_theme_mod( 'cat_slug_local', 'local' );
$offroad_slug = get_theme_mod( 'cat_slug_offroad', 'off-road' );
$biz_slug     = get_theme_mod( 'cat_slug_business', 'business' );
$sports_slug  = get_theme_mod( 'cat_slug_sports', 'sports' );
?>

<div class="fl-home-desktop-wrapper fl-desktop-only">
    <!-- 1. Lead Post Section -->
    <?php if ( $lead_post ) : ?>
        <section class="fl-lead-section">
            <?php buzzmag_render_3d_post_card( $lead_post, 'lead' ); ?>
        </section>
    <?php endif; ?>

    <!-- 2. Main 3-Column Grid -->
    <div class="fl-home-3col-grid">
        <!-- ================= Column 1: Latest 10 & 4-Day Most Viewed ================= -->
        <div class="fl-home-col fl-col-latest">
            <div class="fl-col-header">
                <span class="fl-col-badge red"><i class="fa fa-newspaper-o"></i></span>
                <h3><?php esc_html_e( 'නවතම පුවත් (Latest News)', 'buzzmag' ); ?></h3>
            </div>

            <!-- Latest 10 Posts (Excluding Lead) -->
            <div class="fl-latest-10-stack">
                <?php
                $latest_10 = buzzmag_query_latest_posts_ex_lead( $lead_id, 10 );
                if ( $latest_10->have_posts() ) :
                    while ( $latest_10->have_posts() ) :
                        $latest_10->the_post();
                        buzzmag_render_3d_post_card( get_the_ID(), 'compact-row' );
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="fl-no-posts"><?php esc_html_e( 'පුවත් නොමැත', 'buzzmag' ); ?></p>
                <?php endif; ?>
            </div>

            <!-- Under Latest 10: Top Most Viewed Post from last 4 days -->
            <div class="fl-most-viewed-4days-wrap">
                <div class="fl-col-header sub-header">
                    <span class="fl-col-badge orange"><i class="fa fa-fire"></i></span>
                    <h4><?php esc_html_e( 'වැඩිම පිරිසක් නැරඹූ (Top Viewed)', 'buzzmag' ); ?></h4>
                </div>
                <?php
                $top_4days = buzzmag_query_most_viewed_days( 4, 10 );
                if ( $top_4days->have_posts() ) :
                    while ( $top_4days->have_posts() ) :
                        $top_4days->the_post();
                        buzzmag_render_3d_post_card( get_the_ID(), 'horizontal-card' );
                    endwhile;
                    wp_reset_postdata();
                endif;
                ?>
            </div>
        </div>

        <!-- ================= Column 2: Category Blocks (5 Posts each) ================= -->
        <div class="fl-home-col fl-col-categories">
            <!-- 1. Local (දේශීය) -->
            <?php
            buzzmag_render_category_3d_card(
                get_theme_mod( 'cat_title_local', 'දේශීය පුවත් (Local News)' ),
                $local_slug,
                5,
                'fa-map-marker',
                '#2980b9'
            );
            ?>

            <!-- 2. Off Road / Foreign (පිටරට / Off Road) -->
            <?php
            buzzmag_render_category_3d_card(
                get_theme_mod( 'cat_title_offroad', 'පිටරට / Off Road (Foreign)' ),
                $offroad_slug,
                5,
                'fa-globe',
                '#e67e22'
            );
            ?>

            <!-- 3. Business (ව්‍යාපාරික) -->
            <?php
            buzzmag_render_category_3d_card(
                get_theme_mod( 'cat_title_business', 'ව්‍යාපාරික පුවත් (Business)' ),
                $biz_slug,
                5,
                'fa-line-chart',
                '#27ae60'
            );
            ?>

            <!-- 4. Sports (ක්‍රීඩා) -->
            <?php
            buzzmag_render_category_3d_card(
                get_theme_mod( 'cat_title_sports', 'ක්‍රීඩා පුවත් (Sports)' ),
                $sports_slug,
                5,
                'fa-trophy',
                '#ed0e28'
            );
            ?>
        </div>

        <!-- ================= Column 3: Videos & Sri Lankan Utility Cards ================= -->
        <div class="fl-home-col fl-col-utilities">
            <!-- Biz Today & 4 Video Channels -->
            <?php buzzmag_render_video_channels_card(); ?>

            <!-- Calendar Widget -->
            <?php buzzmag_render_calendar_card(); ?>

            <!-- Astrological Info: Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa -->
            <?php buzzmag_render_astrology_card(); ?>

            <!-- Cartoon of the Day -->
            <?php buzzmag_render_cartoon_card(); ?>

            <!-- WhatsApp Community Banner -->
            <?php buzzmag_render_whatsapp_banner(); ?>
        </div>
    </div>

    <!-- 3. Below Sections: Politics (6 posts) & Featured (6 posts) -->
    <?php buzzmag_render_below_sections(); ?>
</div>

