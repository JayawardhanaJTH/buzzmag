<?php
/**
 * Sri Lankan Utility Widgets & Helpers
 *
 * Provides Customizable Calendar, Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa,
 * Cartoon of the Day, WhatsApp Community Banner, and 4 Channels with 5 Videos each.
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Get the active timezone for BuzzMag.
 *
 * Checks:
 * 1. Customizer setting 'site_timezone' (if set and not 'auto').
 * 2. WordPress site timezone from Settings > General via wp_timezone().
 * 3. Default fallback to 'Asia/Colombo' (Sri Lanka Standard Time UTC+05:30)
 *    if WordPress is still at default unconfigured UTC/0.
 *
 * @return DateTimeZone
 */
function buzzmag_get_timezone() {
    $custom_tz = get_theme_mod( 'site_timezone', 'auto' );

    if ( 'wp_default' === $custom_tz ) {
        return wp_timezone();
    }

    if ( ! empty( $custom_tz ) && 'auto' !== $custom_tz ) {
        try {
            return new DateTimeZone( $custom_tz );
        } catch ( Exception $e ) {
            // fallback
        }
    }

    // When 'auto' (default):
    // If WordPress has a configured timezone other than bare UTC, respect it
    $wp_tz = wp_timezone();
    $name  = $wp_tz->getName();
    if ( 'UTC' !== $name && '+00:00' !== $name && 'Z' !== $name && '-00:00' !== $name ) {
        return $wp_tz;
    }

    // Default to Sri Lanka / Asia/Colombo (UTC+05:30)
    return new DateTimeZone( 'Asia/Colombo' );
}

/**
 * Get current DateTime in the active timezone.
 *
 * @return DateTimeImmutable
 */
function buzzmag_current_datetime() {
    return new DateTimeImmutable( 'now', buzzmag_get_timezone() );
}

/**
 * Format a timestamp or 'now' in the active timezone.
 *
 * @param string $format Date format string (e.g. 'Y-m-d', 'U', 'w').
 * @param int|DateTimeInterface|null $timestamp Optional timestamp or DateTime. Defaults to now.
 * @return string Formatted date string.
 */
function buzzmag_date( $format, $timestamp = null ) {
    $tz = buzzmag_get_timezone();

    if ( null === $timestamp ) {
        $dt = new DateTimeImmutable( 'now', $tz );
        return $dt->format( $format );
    }

    if ( $timestamp instanceof DateTimeInterface ) {
        return $timestamp->setTimezone( $tz )->format( $format );
    }

    $dt = new DateTimeImmutable( '@' . (int) $timestamp );
    return $dt->setTimezone( $tz )->format( $format );
}

/**
 * Extract YouTube / Video metadata and thumbnail from URL.
 *
 * @param string $url Video URL.
 * @return array Array with 'type', 'id', 'thumb', 'embed'.
 */
function buzzmag_get_video_meta( $url ) {
    $url = trim( (string) $url );
    $meta = array(
        'type'  => 'custom',
        'id'    => '',
        'thumb' => '',
        'embed' => '',
        'url'   => $url,
    );

    if ( empty( $url ) ) {
        return $meta;
    }

    // YouTube pattern
    if ( preg_match( '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?|shorts)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $url, $matches ) ) {
        $meta['type']  = 'youtube';
        $meta['id']    = $matches[1];
        $meta['thumb'] = 'https://img.youtube.com/vi/' . $matches[1] . '/mqdefault.jpg';
        $meta['embed'] = 'https://www.youtube.com/embed/' . $matches[1] . '?autoplay=1';
        return $meta;
    }

    // Vimeo pattern
    if ( preg_match( '/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|video\/|)(\d+)/i', $url, $matches ) ) {
        $meta['type']  = 'vimeo';
        $meta['id']    = $matches[3];
        $meta['embed'] = 'https://player.vimeo.com/video/' . $matches[3] . '?autoplay=1';
        return $meta;
    }

    return $meta;
}

/**
 * Get Rahu Kalaya info for a given day (0=Sunday ... 6=Saturday)
 *
 * @param int|null $day Day of the week (0-6). Defaults to current day.
 * @return array
 */
function buzzmag_get_rahu_kalaya( $day = null ) {
    if ( null === $day ) {
        $day = (int) buzzmag_date( 'w' );
    }

    $days_data = array(
        0 => array(
            'day_name'      => esc_html__( 'Sunday (ඉරිදා)', 'buzzmag' ),
            'day_time'      => '16:30 - 18:00',
            'day_time_sin'  => 'සවස 04:30 - 06:00',
            'night_time'    => '19:30 - 21:00',
            'subha_dishawa' => esc_html__( 'South (දකුණ)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'North (උතුර)', 'buzzmag' ),
        ),
        1 => array(
            'day_name'      => esc_html__( 'Monday (සඳුදා)', 'buzzmag' ),
            'day_time'      => '07:30 - 09:00',
            'day_time_sin'  => 'උදේ 07:30 - 09:00',
            'night_time'    => '01:30 - 03:00',
            'subha_dishawa' => esc_html__( 'South-East (ගිනිකොන)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'North-West (වයඹ)', 'buzzmag' ),
        ),
        2 => array(
            'day_name'      => esc_html__( 'Tuesday (අඟහරුවාදා)', 'buzzmag' ),
            'day_time'      => '15:00 - 16:30',
            'day_time_sin'  => 'සවස 03:00 - 04:30',
            'night_time'    => '22:30 - 24:00',
            'subha_dishawa' => esc_html__( 'East (නැගෙනහිර)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'West (බටහිර)', 'buzzmag' ),
        ),
        3 => array(
            'day_name'      => esc_html__( 'Wednesday (බදාදා)', 'buzzmag' ),
            'day_time'      => '12:00 - 13:30',
            'day_time_sin'  => 'දහවල් 12:00 - 01:30',
            'night_time'    => '03:00 - 04:30',
            'subha_dishawa' => esc_html__( 'North-East (ඊසාන)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'South-West (නිරිත)', 'buzzmag' ),
        ),
        4 => array(
            'day_name'      => esc_html__( 'Thursday (බ්‍රහස්පතින්දා)', 'buzzmag' ),
            'day_time'      => '13:30 - 15:00',
            'day_time_sin'  => 'දහවල් 01:30 - 03:00',
            'night_time'    => '04:30 - 06:00',
            'subha_dishawa' => esc_html__( 'North (උතුර)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'South (දකුණ)', 'buzzmag' ),
        ),
        5 => array(
            'day_name'      => esc_html__( 'Friday (සිකුරාදා)', 'buzzmag' ),
            'day_time'      => '10:30 - 12:00',
            'day_time_sin'  => 'උදේ 10:30 - 12:00',
            'night_time'    => '24:00 - 01:30',
            'subha_dishawa' => esc_html__( 'North-West (වයඹ)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'South-East (ගිනිකොන)', 'buzzmag' ),
        ),
        6 => array(
            'day_name'      => esc_html__( 'Saturday (සෙනසුරාදා)', 'buzzmag' ),
            'day_time'      => '09:00 - 10:30',
            'day_time_sin'  => 'උදේ 09:00 - 10:30',
            'night_time'    => '21:00 - 22:30',
            'subha_dishawa' => esc_html__( 'West (බටහිර)', 'buzzmag' ),
            'maru_dishawa'  => esc_html__( 'East (නැගෙනහිර)', 'buzzmag' ),
        ),
    );

    $info = isset( $days_data[ $day ] ) ? $days_data[ $day ] : $days_data[0];

    // Check for Customizer manual overrides
    $override_rahu  = get_theme_mod( 'rahu_kalaya_override', '' );
    $override_subha = get_theme_mod( 'subha_dishawa_override', '' );
    $override_maru  = get_theme_mod( 'maru_dishawa_override', '' );

    if ( ! empty( $override_rahu ) ) {
        $info['day_time_sin'] = $override_rahu;
    }
    if ( ! empty( $override_subha ) ) {
        $info['subha_dishawa'] = $override_subha;
    }
    if ( ! empty( $override_maru ) ) {
        $info['maru_dishawa'] = $override_maru;
    }

    return $info;
}

/**
 * Render Calendar Widget (Customizable)
 */
function buzzmag_render_calendar_card() {
    if ( get_theme_mod( 'hide_calendar', false ) ) {
        return;
    }

    $dt        = buzzmag_current_datetime();
    $year      = (int) $dt->format( 'Y' );
    $month     = (int) $dt->format( 'm' );
    $today     = (int) $dt->format( 'j' );
    $days_in_m = (int) $dt->format( 't' );

    // Calculate first day of this month in the active timezone (0=Sunday ... 6=Saturday)
    $first_dt  = $dt->setDate( $year, $month, 1 )->setTime( 0, 0, 0 );
    $first_day = (int) $first_dt->format( 'w' );

    $month_name_en = $dt->format( 'F Y' );
    $day_name_en   = $dt->format( 'l' );
    $month_names_si = array(
        1 => 'ජනවාරි', 2 => 'පෙබරවාරි', 3 => 'මාර්තු', 4 => 'අප්‍රේල්',
        5 => 'මැයි', 6 => 'ජූනි', 7 => 'ජූලි', 8 => 'අගෝස්තු',
        9 => 'සැප්තැම්බර්', 10 => 'ඔක්තෝබර්', 11 => 'නොවැම්බර්', 12 => 'දෙසැම්බර්'
    );
    $month_name_si = isset( $month_names_si[ $month ] ) ? $month_names_si[ $month ] : '';

    $custom_title = get_theme_mod( 'calendar_title', '' );
    $display_title = ! empty( $custom_title ) ? $custom_title : ( $month_name_si . ' ' . $year );

    $day_abbr = array( 'ඉ', 'ස', 'අ', 'බ', 'බ්‍ර', 'සි', 'සෙ' );
    ?>
    <div class="fl-3d-card fl-utility-card fl-calendar-widget" id="calender-section">
        <div class="fl-card-header">
            <span class="fl-header-icon"><i class="fa fa-calendar"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $display_title ); ?></h4>
                <small><?php echo esc_html( $month_name_en ); ?></small>
            </div>
            <span class="fl-header-badge"><?php echo esc_html( $day_name_en ); ?></span>
        </div>
        <div class="fl-calendar-grid">
            <div class="fl-cal-row fl-cal-head">
                <?php foreach ( $day_abbr as $abbr ) : ?>
                    <span class="fl-cal-cell"><?php echo esc_html( $abbr ); ?></span>
                <?php endforeach; ?>
            </div>
            <div class="fl-cal-row fl-cal-days">
                <?php
                for ( $i = 0; $i < $first_day; $i++ ) {
                    echo '<span class="fl-cal-cell empty"></span>';
                }
                for ( $d = 1; $d <= $days_in_m; $d++ ) {
                    $class = ( $d === $today ) ? 'fl-cal-cell today' : 'fl-cal-cell';
                    echo '<span class="' . esc_attr( $class ) . '">' . esc_html( $d ) . '</span>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render Astrological Card (Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa - Customizable)
 */
function buzzmag_render_astrology_card() {
    $hide_rahu  = get_theme_mod( 'hide_rahu_kalaya', false );
    $hide_astro = get_theme_mod( 'hide_astrology_directions', false );

    if ( $hide_rahu && $hide_astro ) {
        return;
    }

    $info = buzzmag_get_rahu_kalaya();
    $astro_title = get_theme_mod( 'astrology_title', esc_html__( 'අද දවසේ ජ්‍යොතිෂ්‍ය', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-utility-card fl-astro-card" id="rahu-kalaya">
        <div class="fl-card-header">
            <span class="fl-header-icon" style="background:#8e44ad;"><i class="fa fa-clock-o"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $astro_title ); ?></h4>
                <small><?php echo esc_html( $info['day_name'] ); ?></small>
            </div>
        </div>
        <div class="fl-astro-body">
            <!-- Rahu Kalaya -->
            <?php if ( ! $hide_rahu ) : ?>
                <div class="fl-astro-item fl-rahu-box">
                    <div class="fl-astro-label">
                        <i class="fa fa-hourglass-half"></i>
                        <strong><?php echo esc_html( get_theme_mod( 'rahu_kalaya_label', 'රාහු කාලය (Rahu Kalaya)' ) ); ?></strong>
                    </div>
                    <div class="fl-astro-value">
                        <span class="badge day"><i class="fa fa-sun-o"></i> <?php echo esc_html( $info['day_time_sin'] ); ?></span>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Subha Dishawa & Maru Sitina Dishawa -->
            <?php if ( ! $hide_astro ) : ?>
                <div class="fl-astro-columns" id="subha-dishawa">
                    <div class="fl-astro-sub-box subha">
                        <span class="icon"><i class="fa fa-compass"></i></span>
                        <div class="txt">
                            <small><?php echo esc_html( get_theme_mod( 'subha_dishawa_label', 'සුබ දිශාව (Subha Dishawa)' ) ); ?></small>
                            <strong><?php echo esc_html( $info['subha_dishawa'] ); ?></strong>
                        </div>
                    </div>

                    <div class="fl-astro-sub-box maru" id="maru-sitina">
                        <span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
                        <div class="txt">
                            <small><?php echo esc_html( get_theme_mod( 'maru_dishawa_label', 'මරු සිටින දිශාව (Maru Sitina)' ) ); ?></small>
                            <strong><?php echo esc_html( $info['maru_dishawa'] ); ?></strong>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render Cartoon of the Day Card (Customizable)
 */
function buzzmag_render_cartoon_card() {
    if ( get_theme_mod( 'hide_cartoon', false ) ) {
        return;
    }

    $cartoon_img   = get_theme_mod( 'cartoon_image' );
    $cartoon_title = get_theme_mod( 'cartoon_title', esc_html__( 'දවසේ කාටූනය (Cartoon of the Day)', 'buzzmag' ) );
    $cartoon_desc  = get_theme_mod( 'cartoon_desc', '' );
    $cartoon_link  = get_theme_mod( 'cartoon_link', '' );

    if ( empty( $cartoon_img ) ) {
        $cartoon_img = get_template_directory_uri() . '/img/cartoon-placeholder.svg';
    }

    $target_link = ! empty( $cartoon_link ) ? $cartoon_link : $cartoon_img;
    ?>
    <div class="fl-3d-card fl-utility-card fl-cartoon-card" id="cartoon-section">
        <div class="fl-card-header">
            <span class="fl-header-icon" style="background:#e67e22;"><i class="fa fa-paint-brush"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $cartoon_title ); ?></h4>
                <small><?php echo esc_html( buzzmag_date( 'Y-m-d' ) ); ?></small>
            </div>
        </div>
        <div class="fl-cartoon-body">
            <a href="<?php echo esc_url( $target_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-cartoon-lightbox" title="<?php echo esc_attr( $cartoon_title ); ?>">
                <img src="<?php echo esc_url( $cartoon_img ); ?>" alt="<?php echo esc_attr( $cartoon_title ); ?>" loading="lazy" />
                <span class="fl-zoom-icon"><i class="fa fa-search-plus"></i></span>
            </a>
            <?php if ( ! empty( $cartoon_desc ) ) : ?>
                <p class="fl-cartoon-caption"><?php echo esc_html( $cartoon_desc ); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render Top Stories of the Day Card (Customizable)
 */
function buzzmag_render_top_stories_card() {
    if ( get_theme_mod( 'hide_top_stories', false ) ) {
        return;
    }

    $top_stories_img   = get_theme_mod( 'top_stories_image' );
    $top_stories_title = get_theme_mod( 'top_stories_title', esc_html__( 'දවසේ ප්‍රධාන පුවත් (Top Stories of the Day)', 'buzzmag' ) );
    $top_stories_desc  = get_theme_mod( 'top_stories_desc', '' );
    $top_stories_link  = get_theme_mod( 'top_stories_link', '' );

    if ( empty( $top_stories_img ) ) {
        $top_stories_img = get_template_directory_uri() . '/img/top-stories-placeholder.svg';
    }

    $target_link = ! empty( $top_stories_link ) ? $top_stories_link : $top_stories_img;
    ?>
    <div class="fl-3d-card fl-utility-card fl-top-stories-card" id="top-stories-section">
        <div class="fl-card-header">
            <span class="fl-header-icon" style="background:#ed0e28;"><i class="fa fa-newspaper-o"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $top_stories_title ); ?></h4>
                <small><?php echo esc_html( buzzmag_date( 'Y-m-d' ) ); ?></small>
            </div>
        </div>
        <div class="fl-top-stories-body">
            <a href="<?php echo esc_url( $target_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-top-stories-lightbox" title="<?php echo esc_attr( $top_stories_title ); ?>">
                <img src="<?php echo esc_url( $top_stories_img ); ?>" alt="<?php echo esc_attr( $top_stories_title ); ?>" loading="lazy" />
                <span class="fl-zoom-icon"><i class="fa fa-search-plus"></i></span>
            </a>
            <?php if ( ! empty( $top_stories_desc ) ) : ?>
                <p class="fl-top-stories-caption"><?php echo esc_html( $top_stories_desc ); ?></p>
            <?php endif; ?>
        </div>
    </div>
    <?php
}

/**
 * Render WhatsApp Community Banner (Customizable)
 */
function buzzmag_render_whatsapp_banner() {
    if ( get_theme_mod( 'hide_whatsapp_banner', false ) ) {
        return;
    }

    $wa_link     = get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' );
    $wa_title    = get_theme_mod( 'whatsapp_title', esc_html__( 'Join Our WhatsApp Community', 'buzzmag' ) );
    $wa_desc     = get_theme_mod( 'whatsapp_desc', esc_html__( 'Get breaking news alerts and headlines delivered directly to your phone.', 'buzzmag' ) );
    $wa_btn_text = get_theme_mod( 'whatsapp_btn_text', esc_html__( 'Join Channel', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-whatsapp-banner fl-promo-banner" id="whatsapp-banner">
        <div class="fl-wa-content fl-promo-content">
            <div class="fl-wa-icon-wrap fl-promo-icon-wrap">
                <i class="fa fa-whatsapp"></i>
            </div>
            <div class="fl-wa-text fl-promo-text">
                <h4><?php echo esc_html( $wa_title ); ?></h4>
                <p><?php echo esc_html( $wa_desc ); ?></p>
            </div>
        </div>
        <a href="<?php echo esc_url( $wa_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-wa-btn fl-promo-btn">
            <i class="fa fa-whatsapp"></i>
            <span><?php echo esc_html( $wa_btn_text ); ?></span>
        </a>
    </div>
    <?php
}

/**
 * Render "Advertise With Us" Banner (Links to WhatsApp)
 */
function buzzmag_render_advertise_banner() {
    if ( get_theme_mod( 'hide_advertise_banner', false ) ) {
        return;
    }

    $ad_wa_link = get_theme_mod( 'advertise_wa_link', get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' ) );
    $ad_title   = get_theme_mod( 'advertise_title', esc_html__( 'Advertise With Us', 'buzzmag' ) );
    $ad_desc    = get_theme_mod( 'advertise_desc', esc_html__( 'Promote your brand or business to thousands of daily readers. Contact our advertising desk directly on WhatsApp.', 'buzzmag' ) );
    $ad_btn     = get_theme_mod( 'advertise_btn_text', esc_html__( 'Chat on WhatsApp', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-promo-banner fl-advertise-banner" id="advertise-banner">
        <div class="fl-promo-content">
            <div class="fl-promo-icon-wrap">
                <i class="fa fa-bullhorn"></i>
            </div>
            <div class="fl-promo-text">
                <h4><?php echo esc_html( $ad_title ); ?></h4>
                <p><?php echo esc_html( $ad_desc ); ?></p>
            </div>
        </div>
        <a href="<?php echo esc_url( $ad_wa_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-promo-btn">
            <i class="fa fa-whatsapp"></i>
            <span><?php echo esc_html( $ad_btn ); ?></span>
        </a>
    </div>
    <?php
}

/**
 * Render "Facebook Page" Banner
 */
function buzzmag_render_facebook_banner() {
    if ( get_theme_mod( 'hide_facebook_banner', false ) ) {
        return;
    }

    $fb_link  = get_theme_mod( 'facebook_page_link', get_theme_mod( 'facebook', 'https://www.facebook.com/' ) );
    $fb_title = get_theme_mod( 'facebook_card_title', esc_html__( 'Official Facebook Page', 'buzzmag' ) );
    $fb_desc  = get_theme_mod( 'facebook_card_desc', esc_html__( 'Follow our official Facebook page for breaking updates, live videos, and community discussions.', 'buzzmag' ) );
    $fb_btn   = get_theme_mod( 'facebook_btn_text', esc_html__( 'Follow on Facebook', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-promo-banner fl-facebook-banner" id="facebook-banner">
        <div class="fl-promo-content">
            <div class="fl-promo-icon-wrap">
                <i class="fa fa-facebook"></i>
            </div>
            <div class="fl-promo-text">
                <h4><?php echo esc_html( $fb_title ); ?></h4>
                <p><?php echo esc_html( $fb_desc ); ?></p>
            </div>
        </div>
        <a href="<?php echo esc_url( $fb_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-promo-btn">
            <i class="fa fa-facebook-official"></i>
            <span><?php echo esc_html( $fb_btn ); ?></span>
        </a>
    </div>
    <?php
}

/**
 * Render "TikTok" Banner
 */
function buzzmag_render_tiktok_banner() {
    if ( get_theme_mod( 'hide_tiktok_banner', false ) ) {
        return;
    }

    $tt_link  = get_theme_mod( 'tiktok_page_link', get_theme_mod( 'tiktok', 'https://www.tiktok.com/' ) );
    $tt_title = get_theme_mod( 'tiktok_card_title', esc_html__( 'Follow Us on TikTok', 'buzzmag' ) );
    $tt_desc  = get_theme_mod( 'tiktok_card_desc', esc_html__( 'Watch trending news shorts, exclusive highlights, and viral video updates.', 'buzzmag' ) );
    $tt_btn   = get_theme_mod( 'tiktok_btn_text', esc_html__( 'Follow on TikTok', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-promo-banner fl-tiktok-banner" id="tiktok-banner">
        <div class="fl-promo-content">
            <div class="fl-promo-icon-wrap fl-tiktok-icon-wrap">
                <svg class="fl-promo-svg-icon" viewBox="0 0 24 24" width="22" height="22" fill="currentColor" aria-hidden="true">
                    <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                </svg>
            </div>
            <div class="fl-promo-text">
                <h4><?php echo esc_html( $tt_title ); ?></h4>
                <p><?php echo esc_html( $tt_desc ); ?></p>
            </div>
        </div>
        <a href="<?php echo esc_url( $tt_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-promo-btn">
            <svg class="fl-btn-svg-icon" viewBox="0 0 24 24" width="15" height="15" fill="currentColor" aria-hidden="true" style="vertical-align: -2px; margin-right: 2px;">
                <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
            </svg>
            <span><?php echo esc_html( $tt_btn ); ?></span>
        </a>
    </div>
    <?php
}

/**
 * Get Channel and 5 Video settings
 *
 * @param int $channel_num 1 to 4.
 * @return array Channel details with 5 videos.
 */
function buzzmag_get_channel_data( $channel_num ) {
    $defaults = array(
        1 => array(
            'title' => 'Channel 1 - Biz Today (ව්‍යාපාරික පුවත්)',
            'badge' => 'Biz Today',
            'color' => '#e67e22',
            'icon'  => 'fa-line-chart',
            'video_prefix' => 'Biz Today Episode',
        ),
        2 => array(
            'title' => 'Channel 2 - Prime Bulletin (ප්‍රධාන පුවත් විකාශය)',
            'badge' => 'Prime News',
            'color' => '#ed0e28',
            'icon'  => 'fa-television',
            'video_prefix' => 'News Bulletin',
        ),
        3 => array(
            'title' => 'Channel 3 - Special Talk (විශේෂ සාකච්ඡා)',
            'badge' => 'Exclusive',
            'color' => '#2980b9',
            'icon'  => 'fa-microphone',
            'video_prefix' => 'Special Interview',
        ),
        4 => array(
            'title' => 'Channel 4 - Entertainment & Sports (විශේෂාංග)',
            'badge' => 'Channel 4',
            'color' => '#27ae60',
            'icon'  => 'fa-trophy',
            'video_prefix' => 'Highlight Episode',
        ),
    );

    $d = isset( $defaults[ $channel_num ] ) ? $defaults[ $channel_num ] : $defaults[1];

    $channel_title = get_theme_mod( "video_ch_{$channel_num}_title", $d['title'] );
    $channel_badge = get_theme_mod( "video_ch_{$channel_num}_badge", $d['badge'] );
    $channel_color = get_theme_mod( "video_ch_{$channel_num}_color", $d['color'] );

    $videos = array();
    for ( $v = 1; $v <= 5; $v++ ) {
        $v_title = get_theme_mod( "video_ch_{$channel_num}_v_{$v}_title", $d['video_prefix'] . ' 0' . $v );
        $v_url   = get_theme_mod( "video_ch_{$channel_num}_v_{$v}_url", '' );
        $meta    = buzzmag_get_video_meta( $v_url );

        $videos[] = array(
            'index' => $v,
            'title' => $v_title,
            'url'   => $v_url,
            'meta'  => $meta,
        );
    }

    return array(
        'id'     => 'channel_' . $channel_num,
        'num'    => $channel_num,
        'title'  => $channel_title,
        'badge'  => $channel_badge,
        'color'  => $channel_color,
        'icon'   => $d['icon'],
        'videos' => $videos,
    );
}

/**
 * Render a Single Video Channel as a Standalone 3D Card
 *
 * @param int $channel_num Channel number (1 to 4).
 */
function buzzmag_render_single_channel_card( $channel_num ) {
    $ch = buzzmag_get_channel_data( $channel_num );
    ?>
    <div class="fl-3d-card fl-channel-card ch-<?php echo esc_attr( $channel_num ); ?>" style="--ch-color: <?php echo esc_attr( $ch['color'] ); ?>;">
        <div class="fl-channel-card-header">
            <div class="fl-ch-head-left">
                <span class="fl-ch-icon" style="background: <?php echo esc_attr( $ch['color'] ); ?>;">
                    <i class="fa <?php echo esc_attr( $ch['icon'] ); ?>"></i>
                </span>
                <div>
                    <h4 class="fl-ch-name"><?php echo esc_html( $ch['title'] ); ?></h4>
                    <span class="fl-ch-count"><?php esc_html_e( '5 Videos Included', 'buzzmag' ); ?></span>
                </div>
            </div>
            <span class="fl-ch-pill" style="background: <?php echo esc_attr( $ch['color'] ); ?>;"><?php echo esc_html( $ch['badge'] ); ?></span>
        </div>

        <div class="fl-channel-videos-grid">
            <?php
            $first_video = true;
            foreach ( $ch['videos'] as $v_item ) :
                $meta      = $v_item['meta'];
                $has_url   = ! empty( $v_item['url'] );
                $thumb_url = ! empty( $meta['thumb'] ) ? $meta['thumb'] : ( fl_theme_path . '/img/buzzmag_small.png' );
                ?>
                <?php if ( $first_video ) : ?>
                    <!-- Video 1: Featured Main Video with Large Thumb & Play -->
                    <div class="fl-video-item fl-video-lead">
                        <div class="fl-v-thumb-wrap">
                            <a href="<?php echo esc_url( $has_url ? $v_item['url'] : '#' ); ?>" <?php echo $has_url ? 'target="_blank" rel="noopener"' : ''; ?> class="fl-v-link">
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $v_item['title'] ); ?>" loading="lazy">
                                <div class="fl-play-overlay">
                                    <i class="fa fa-play"></i>
                                </div>
                                <span class="fl-v-badge"><i class="fa fa-film"></i> <?php esc_html_e( 'Featured Video', 'buzzmag' ); ?></span>
                            </a>
                        </div>
                        <h5 class="fl-v-title">
                            <a href="<?php echo esc_url( $has_url ? $v_item['url'] : '#' ); ?>" <?php echo $has_url ? 'target="_blank" rel="noopener"' : ''; ?>>
                                <?php echo esc_html( $v_item['title'] ); ?>
                            </a>
                        </h5>
                    </div>
                    <?php
                    $first_video = false;
                else : ?>
                    <!-- Videos 2, 3, 4, 5: Compact video rows with thumb & title -->
                    <div class="fl-video-item fl-video-compact">
                        <div class="fl-v-mini-thumb">
                            <a href="<?php echo esc_url( $has_url ? $v_item['url'] : '#' ); ?>" <?php echo $has_url ? 'target="_blank" rel="noopener"' : ''; ?>>
                                <img src="<?php echo esc_url( $thumb_url ); ?>" alt="<?php echo esc_attr( $v_item['title'] ); ?>" loading="lazy">
                                <span class="fl-play-mini"><i class="fa fa-play"></i></span>
                            </a>
                        </div>
                        <div class="fl-v-info">
                            <span class="fl-v-num"><?php echo esc_html( $ch['badge'] ); ?> &bull; 0<?php echo esc_html( $v_item['index'] ); ?></span>
                            <h6 class="fl-v-title">
                                <a href="<?php echo esc_url( $has_url ? $v_item['url'] : '#' ); ?>" <?php echo $has_url ? 'target="_blank" rel="noopener"' : ''; ?>>
                                    <?php echo esc_html( $v_item['title'] ); ?>
                                </a>
                            </h6>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

/**
 * Render Video Channels Section: 4 Channels Separated as Standalone 3D Cards (No Tabs)
 */
function buzzmag_render_video_channels_card() {
    if ( get_theme_mod( 'hide_video_channels', false ) ) {
        return;
    }

    for ( $ch = 1; $ch <= 4; $ch++ ) {
        buzzmag_render_single_channel_card( $ch );
    }
}

/**
 * Render Homepage 3rd Column / Mobile Utilities Stack
 * Includes: 4 Video Channels, Top Stories, Cartoon, WhatsApp, Rahu Kalaya, Advertise, Facebook, TikTok
 */
function buzzmag_render_column_3_utilities() {
    // 1. Video Channels (4 Standalone Cards)
    buzzmag_render_video_channels_card();

    // 2. Top Stories of the Day (දවසේ ප්‍රධාන පුවත්)
    buzzmag_render_top_stories_card();

    // 3. Cartoon of the Day
    buzzmag_render_cartoon_card();

    // 4. WhatsApp Community Banner
    buzzmag_render_whatsapp_banner();

    // 5. Astrological Info: Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa
    buzzmag_render_astrology_card();

    // 6. Advertise With Us (Links to WhatsApp)
    buzzmag_render_advertise_banner();

    // 7. Facebook Page Card
    buzzmag_render_facebook_banner();

    // 8. TikTok Banner
    buzzmag_render_tiktok_banner();
}

