<?php
/**
 * Main Homepage Template (Rebranded 3D News Layout)
 *
 * Renders:
 * - Desktop View (Ada Derana Sinhala 3-column & below sections format)
 * - Mobile View (Unusuma.lk responsive format)
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

// Optional Home Ad
$home_ad = get_theme_mod( 'home_ad', '' );
if ( ! empty( $home_ad ) ) { ?>
    <div class="fl-ad fl-container clearfix">
        <span class="adtitle"><?php esc_html_e( '&ndash; Advertisement &ndash;', 'buzzmag' ); ?></span>
        <?php echo wp_kses_post( $home_ad ); ?>
    </div>
<?php } ?>

<div id="fl-content" class="fl-home-rebranded-content">
    <div class="fl-container clearfix">
        <?php
        // 1. Desktop View (Ada Derana 3-Column + Below sections)
        get_template_part( 'includes/home-desktop' );

        // 2. Mobile View (Unusuma.lk style)
        get_template_part( 'includes/home-mobile' );
        ?>
    </div>
</div>

<?php get_footer(); ?>
