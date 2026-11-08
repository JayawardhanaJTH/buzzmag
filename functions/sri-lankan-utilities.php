<?php
/**
 * Sri Lankan Utility Widgets & Helpers
 *
 * Provides Calendar, Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa,
 * Cartoon of the Day, and WhatsApp Community Banner.
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
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

    return isset( $days_data[ $day ] ) ? $days_data[ $day ] : $days_data[0];
}

/**
 * Render Calendar Widget
 */
function buzzmag_render_calendar_card() {
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

    $day_abbr = array( 'ඉ', 'ස', 'අ', 'බ', 'බ්‍ර', 'සි', 'සෙ' );
    ?>
    <div class="fl-3d-card fl-utility-card fl-calendar-widget">
        <div class="fl-card-header">
            <span class="fl-header-icon"><i class="fa fa-calendar"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $month_name_si . ' ' . $year ); ?></h4>
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
 * Render Astrological Card (Rahu Kalaya, Subha Dishawa, Maru Sitina Dishawa)
 */
function buzzmag_render_astrology_card() {
    $info = buzzmag_get_rahu_kalaya();
    ?>
    <div class="fl-3d-card fl-utility-card fl-astro-card">
        <div class="fl-card-header">
            <span class="fl-header-icon"><i class="fa fa-clock-o"></i></span>
            <div class="fl-header-title">
                <h4><?php esc_html_e( 'අද දිනයේ ලග්න සහ නැකැත්', 'buzzmag' ); ?></h4>
                <small><?php echo esc_html( $info['day_name'] ); ?></small>
            </div>
        </div>
        <div class="fl-astro-body">
            <!-- Rahu Kalaya -->
            <div class="fl-astro-item fl-rahu-box">
                <div class="fl-astro-label">
                    <i class="fa fa-hourglass-half"></i>
                    <strong><?php esc_html_e( 'රාහු කාලය (Rahu Kalaya)', 'buzzmag' ); ?></strong>
                </div>
                <div class="fl-astro-value">
                    <span class="badge day"><i class="fa fa-sun-o"></i> <?php echo esc_html( $info['day_time_sin'] ); ?></span>
                </div>
            </div>

            <!-- Subha Dishawa & Maru Sitina Dishawa -->
            <div class="fl-astro-columns">
                <div class="fl-astro-sub-box subha">
                    <span class="icon"><i class="fa fa-compass"></i></span>
                    <div class="txt">
                        <small><?php esc_html_e( 'සුබ දිශාව (Subha Dishawa)', 'buzzmag' ); ?></small>
                        <strong><?php echo esc_html( $info['subha_dishawa'] ); ?></strong>
                    </div>
                </div>

                <div class="fl-astro-sub-box maru">
                    <span class="icon"><i class="fa fa-exclamation-triangle"></i></span>
                    <div class="txt">
                        <small><?php esc_html_e( 'මරු සිටින දිශාව (Maru Sitina)', 'buzzmag' ); ?></small>
                        <strong><?php echo esc_html( $info['maru_dishawa'] ); ?></strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
}

/**
 * Render Cartoon of the Day Card
 */
function buzzmag_render_cartoon_card() {
    $cartoon_img = get_theme_mod( 'cartoon_image' );
    $cartoon_title = get_theme_mod( 'cartoon_title', esc_html__( 'දවසේ කාටූනය (Cartoon of the Day)', 'buzzmag' ) );
    $cartoon_desc  = get_theme_mod( 'cartoon_desc', '' );

    if ( empty( $cartoon_img ) ) {
        $cartoon_img = get_template_directory_uri() . '/img/cartoon-placeholder.jpg';
    }
    ?>
    <div class="fl-3d-card fl-utility-card fl-cartoon-card">
        <div class="fl-card-header">
            <span class="fl-header-icon"><i class="fa fa-paint-brush"></i></span>
            <div class="fl-header-title">
                <h4><?php echo esc_html( $cartoon_title ); ?></h4>
                <small><?php echo esc_html( current_time( 'Y-m-d' ) ); ?></small>
            </div>
        </div>
        <div class="fl-cartoon-body">
            <a href="<?php echo esc_url( $cartoon_img ); ?>" target="_blank" rel="noopener noreferrer" class="fl-cartoon-lightbox" title="<?php echo esc_attr( $cartoon_title ); ?>">
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
 * Render WhatsApp Community Banner
 */
function buzzmag_render_whatsapp_banner() {
    $wa_link  = get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' );
    $wa_title = get_theme_mod( 'whatsapp_title', esc_html__( 'අපගේ WhatsApp සමූහයට එක්වන්න', 'buzzmag' ) );
    $wa_desc  = get_theme_mod( 'whatsapp_desc', esc_html__( 'නවතම උණුසුම් පුවත් එසැනින් ඔබගේ දුරකථනයටම ලබාගන්න', 'buzzmag' ) );
    ?>
    <div class="fl-3d-card fl-whatsapp-banner">
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
            <span><?php esc_html_e( 'Join Channel (සම්බන්ධ වන්න)', 'buzzmag' ); ?></span>
        </a>
    </div>
    <?php
}

/**
 * Render Video Channels Section (Biz Today & 4 channels)
 */
function buzzmag_render_video_channels_card() {
    $channels = array(
        array(
            'id'    => 'biz_today',
            'title' => get_theme_mod( 'video_channel_1_title', 'Biz Today (ව්‍යාපාරික පුවත්)' ),
            'url'   => get_theme_mod( 'video_channel_1_url', '' ),
            'badge' => 'Biz Today',
            'color' => '#e67e22',
        ),
        array(
            'id'    => 'channel_2',
            'title' => get_theme_mod( 'video_channel_2_title', 'News Bulletin (ප්‍රධාන පුවත්)' ),
            'url'   => get_theme_mod( 'video_channel_2_url', '' ),
            'badge' => 'Prime News',
            'color' => '#ed0e28',
        ),
        array(
            'id'    => 'channel_3',
            'title' => get_theme_mod( 'video_channel_3_title', 'Special Talk (විශේෂ සාකච්ඡා)' ),
            'url'   => get_theme_mod( 'video_channel_3_url', '' ),
            'badge' => 'Exclusive',
            'color' => '#2980b9',
        ),
        array(
            'id'    => 'channel_4',
            'title' => get_theme_mod( 'video_channel_4_title', 'Entertainment & Sports' ),
            'url'   => get_theme_mod( 'video_channel_4_url', '' ),
            'badge' => 'Channel 4',
            'color' => '#27ae60',
        ),
    );
    ?>
    <div class="fl-3d-card fl-utility-card fl-video-channels-card">
        <div class="fl-card-header">
            <span class="fl-header-icon" style="background:#ed0e28; color:#fff;"><i class="fa fa-play-circle"></i></span>
            <div class="fl-header-title">
                <h4><?php esc_html_e( 'වීඩියෝ පුවත් (Video Channels)', 'buzzmag' ); ?></h4>
                <small><?php esc_html_e( 'Watch Latest Broadcasts', 'buzzmag' ); ?></small>
            </div>
            <span class="fl-header-live"><span class="dot"></span> LIVE</span>
        </div>
        <div class="fl-channels-list">
            <?php foreach ( $channels as $ch ) : ?>
                <div class="fl-channel-item">
                    <div class="fl-channel-thumb">
                        <?php if ( ! empty( $ch['url'] ) ) : ?>
                            <?php echo wp_oembed_get( esc_url( $ch['url'] ) ); ?>
                        <?php else : ?>
                            <div class="fl-channel-placeholder" style="border-top-color: <?php echo esc_attr( $ch['color'] ); ?>;">
                                <div class="fl-play-btn"><i class="fa fa-play"></i></div>
                                <span class="badge" style="background: <?php echo esc_attr( $ch['color'] ); ?>;"><?php echo esc_html( $ch['badge'] ); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="fl-channel-info">
                        <h5><?php echo esc_html( $ch['title'] ); ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

