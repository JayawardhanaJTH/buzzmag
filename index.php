<?php
/**
 * Main Homepage Template (Rebranded 3D News Layout)
 *
 * Renders:
 * - Desktop View (3-column & below sections format)
 * - Mobile View
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
        // Render strictly ONE view (Desktop OR Mobile) to prevent duplicate ad container IDs in the DOM
        $is_mobile = function_exists( 'buzzmag_is_mobile' ) ? buzzmag_is_mobile() : wp_is_mobile();

        if ( $is_mobile ) {
            // 1. Mobile View only
            get_template_part( 'includes/home-mobile' );
        } else {
            // 2. Desktop View only
            get_template_part( 'includes/home-desktop' );
        }
        ?>
    </div>
</div>

<?php get_footer(); ?>
