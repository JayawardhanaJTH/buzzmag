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
        $day = (int) current_time( 'w' );
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

    $now       = current_time( 'timestamp' );
    $year      = (int) date( 'Y', $now );
    $month     = (int) date( 'm', $now );
    $today     = (int) date( 'j', $now );
    $days_in_m = (int) date( 't', $now );
    $first_day = (int) date( 'w', mktime( 0, 0, 0, $month, 1, $year ) );

    $month_name_en = date( 'F Y', $now );
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
            <span class="fl-header-badge"><?php echo esc_html( date( 'l', $now ) ); ?></span>
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
    $astro_title = get_theme_mod( 'astrology_title', esc_html__( 'අද දිනයේ ලග්න සහ නැකැත්', 'buzzmag' ) );
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
        $cartoon_img = get_template_directory_uri() . '/img/cartoon-placeholder.jpg';
    }

    $target_link = ! empty( $cartoon_link ) ? $cartoon_link : $cartoon_img;
    ?>
    <div class="fl-3d-card fl-utility-card fl-cartoon-card" id="cartoon-section">
        <div class="fl-card-header">
            <span class="fl-header-icon" style="background:#e67e22;"><i class="fa fa-paint-brush"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $cartoon_title ); ?></h4>
                <small><?php echo esc_html( current_time( 'Y-m-d' ) ); ?></small>
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
 * Render WhatsApp Community Banner (Customizable)
 */
function buzzmag_render_whatsapp_banner() {
    if ( get_theme_mod( 'hide_whatsapp_banner', false ) ) {
        return;
    }

    $wa_link     = get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' );
    $wa_title    = get_theme_mod( 'whatsapp_title', esc_html__( 'අපගේ WhatsApp සමූහයට එක්වන්න', 'buzzmag' ) );
    $wa_desc     = get_theme_mod( 'whatsapp_desc', esc_html__( 'නවතම උණුසුම් පුවත් එසැනින් ඔබගේ දුරකථනයටම ලබාගන්න', 'buzzmag' ) );
    $wa_btn_text = get_theme_mod( 'whatsapp_btn_text', esc_html__( 'Join Channel (සම්බන්ධ වන්න)', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-whatsapp-banner" id="whatsapp-banner">
        <div class="fl-wa-content">
            <div class="fl-wa-icon-wrap">
                <i class="fa fa-whatsapp"></i>
            </div>
            <div class="fl-wa-text">
                <h4><?php echo esc_html( $wa_title ); ?></h4>
                <p><?php echo esc_html( $wa_desc ); ?></p>
            </div>
        </div>
        <a href="<?php echo esc_url( $wa_link ); ?>" target="_blank" rel="noopener noreferrer" class="fl-wa-btn">
            <i class="fa fa-whatsapp"></i>
            <span><?php echo esc_html( $wa_btn_text ); ?></span>
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
 * Render Video Channels Section: 4 Channels with 5 Videos Each (Channel-Wise Separated)
 */
function buzzmag_render_video_channels_card() {
    if ( get_theme_mod( 'hide_video_channels', false ) ) {
        return;
    }

    $section_title = get_theme_mod( 'video_section_title', esc_html__( 'වීඩියෝ නාලිකා (Video Channels)', 'buzzmag' ) );

    $channels = array(
        1 => buzzmag_get_channel_data( 1 ),
        2 => buzzmag_get_channel_data( 2 ),
        3 => buzzmag_get_channel_data( 3 ),
        4 => buzzmag_get_channel_data( 4 ),
    );
    ?>
    <div class="fl-3d-card fl-utility-card fl-video-channels-container" id="video-channels-section">
        <div class="fl-card-header">
            <span class="fl-header-icon" style="background:#ed0e28; color:#fff;"><i class="fa fa-youtube-play"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $section_title ); ?></h4>
                <small><?php esc_html_e( '4 Channels &bull; 5 Videos Each', 'buzzmag' ); ?></small>
            </div>
            <span class="fl-header-live"><span class="dot"></span> LIVE</span>
        </div>

        <!-- Channel Filter Tabs for Smooth Navigation -->
        <div class="fl-channel-filter-tabs">
            <button type="button" class="fl-ch-tab active" data-channel="all">
                <i class="fa fa-th-large"></i> <?php esc_html_e( 'සියල්ල (All Channels)', 'buzzmag' ); ?>
            </button>
            <?php foreach ( $channels as $c_num => $ch ) : ?>
                <button type="button" class="fl-ch-tab" data-channel="ch-<?php echo esc_attr( $c_num ); ?>" style="--ch-color: <?php echo esc_attr( $ch['color'] ); ?>;">
                    <i class="fa <?php echo esc_attr( $ch['icon'] ); ?>"></i>
                    <span><?php echo esc_html( $ch['badge'] ); ?></span>
                </button>
            <?php endforeach; ?>
        </div>

        <!-- Channel-Wise Separated Blocks -->
        <div class="fl-channel-blocks-wrap">
            <?php foreach ( $channels as $c_num => $ch ) : ?>
                <div class="fl-channel-section-block ch-<?php echo esc_attr( $c_num ); ?>" style="--ch-color: <?php echo esc_attr( $ch['color'] ); ?>;">
                    <!-- Channel Header -->
                    <div class="fl-channel-block-header">
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

                    <!-- 5 Videos List for this Channel -->
                    <div class="fl-channel-videos-grid">
                        <?php
                        $first_video = true;
                        foreach ( $ch['videos'] as $v_item ) :
                            $meta = $v_item['meta'];
                            $has_url = ! empty( $v_item['url'] );
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
                                            <span class="fl-v-badge"><i class="fa fa-film"></i> <?php esc_html_e( 'Video 1', 'buzzmag' ); ?></span>
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
                                        <span class="fl-v-num">Video <?php echo esc_html( $v_item['index'] ); ?></span>
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
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}
