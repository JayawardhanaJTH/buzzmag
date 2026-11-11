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
        // 1. Desktop View
        get_template_part( 'includes/home-desktop' );

        // 2. Mobile View
        get_template_part( 'includes/home-mobile' );
        ?>
    </div>
</div>

<?php get_footer(); ?>
