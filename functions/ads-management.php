<?php
/**
 * Ad Spaces Management Engine
 *
 * Implements:
 * - Dynamic rendering for ~15 custom ad slots across Desktop & Mobile
 * - Global sticky bottom banner ad with dismiss toggle & height-compensation
 * - Safe shortcode, AdSense, script & HTML banner rendering
 * - Zero empty space when an ad slot is unused
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Render an Ad Space Slot
 *
 * @param string $slot_id       Theme mod slot identifier (e.g. 'home_ad_top', 'sidebar_ad_1').
 * @param string $extra_classes Optional extra CSS classes for the wrapper.
 * @return bool True if ad was rendered, false if empty.
 */
function buzzmag_render_ad_space( $slot_id, $extra_classes = '' ) {
    $ad_code = get_theme_mod( $slot_id, '' );

    // Fallback for home_ad_top -> legacy home_ad
    if ( empty( $ad_code ) && 'home_ad_top' === $slot_id ) {
        $ad_code = get_theme_mod( 'home_ad', '' );
    }

    if ( empty( $ad_code ) || ! is_string( $ad_code ) || '' === trim( $ad_code ) ) {
        return false;
    }
    ?>
    <div class="fl-ad-space fl-ad-<?php echo esc_attr( $slot_id ); ?> <?php echo esc_attr( $extra_classes ); ?>">
        <div class="fl-ad-content">
            <?php echo do_shortcode( $ad_code ); ?>
        </div>
    </div>
    <?php
    return true;
}

/**
 * Render Global Sticky Bottom Banner Ad (Desktop & Mobile)
 * Hooked to wp_footer.
 */
function buzzmag_render_sticky_bottom_ad() {
    if ( get_theme_mod( 'hide_sticky_bottom_ad', false ) ) {
        return;
    }

    $sticky_ad = get_theme_mod( 'sticky_bottom_ad', '' );
    if ( empty( $sticky_ad ) || ! is_string( $sticky_ad ) || '' === trim( $sticky_ad ) ) {
        return;
    }

    $hide_mobile    = get_theme_mod( 'hide_sticky_bottom_mobile', false );
    $hide_close_btn = get_theme_mod( 'hide_sticky_bottom_close_btn', false );
    $wrap_class     = 'fl-sticky-bottom-ad-wrap';

    if ( $hide_mobile ) {
        $wrap_class .= ' fl-desktop-only';
    }
    ?>
    <div id="fl-sticky-bottom-ad" class="<?php echo esc_attr( $wrap_class ); ?>">
        <div class="fl-sticky-ad-container">
            <?php if ( ! $hide_close_btn ) : ?>
                <button type="button" class="fl-sticky-ad-close" id="fl-sticky-ad-close-btn" aria-label="<?php esc_attr_e( 'Close advertisement', 'buzzmag' ); ?>" title="<?php esc_attr_e( 'Close', 'buzzmag' ); ?>">&times;</button>
            <?php endif; ?>
            <div class="fl-sticky-ad-inner">
                <?php echo do_shortcode( $sticky_ad ); ?>
            </div>
        </div>
    </div>
    <script>
    (function() {
        var stickyAd = document.getElementById('fl-sticky-bottom-ad');
        if (!stickyAd) return;

        document.body.classList.add('has-sticky-ad');

        function syncStickyAdPadding() {
            if (!stickyAd) return;
            var isHidden = window.getComputedStyle(stickyAd).display === 'none';
            var spacer = document.getElementById('fl-sticky-ad-footer-spacer');
            var footer = document.getElementById('fl-footer');
            if (!isHidden && stickyAd.offsetHeight > 0) {
                var adH = stickyAd.offsetHeight;
                if (spacer) {
                    spacer.style.height = (adH + 15) + 'px';
                    spacer.style.display = 'block';
                }
                if (footer) {
                    footer.style.setProperty('padding-bottom', (adH + 15) + 'px', 'important');
                }
            } else {
                if (spacer) {
                    spacer.style.height = '0px';
                    spacer.style.display = 'none';
                }
                if (footer) {
                    footer.style.removeProperty('padding-bottom');
                }
            }
        }

        // Measure immediately and after resources load
        syncStickyAdPadding();
        window.addEventListener('load', syncStickyAdPadding);
        window.addEventListener('resize', syncStickyAdPadding);

        var closeBtn = document.getElementById('fl-sticky-ad-close-btn');
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                stickyAd.style.transition = 'transform 0.3s ease, opacity 0.3s ease';
                stickyAd.style.transform = 'translateY(120%)';
                stickyAd.style.opacity = '0';
                document.body.classList.remove('has-sticky-ad');
                var spacer = document.getElementById('fl-sticky-ad-footer-spacer');
                var footer = document.getElementById('fl-footer');
                if (spacer) {
                    spacer.style.height = '0px';
                    spacer.style.display = 'none';
                }
                if (footer) {
                    footer.style.removeProperty('padding-bottom');
                }
                setTimeout(function() {
                    stickyAd.style.display = 'none';
                }, 300);
            });
        }
    })();
    </script>
    <?php
}
add_action( 'wp_footer', 'buzzmag_render_sticky_bottom_ad', 99 );

/**
 * Add body class when sticky bottom ad is enabled
 */
function buzzmag_sticky_ad_body_class( $classes ) {
    $sticky_ad = get_theme_mod( 'sticky_bottom_ad', '' );
    $hide_ad   = get_theme_mod( 'hide_sticky_bottom_ad', false );
    if ( ! empty( $sticky_ad ) && ! $hide_ad && '' !== trim( $sticky_ad ) ) {
        $classes[] = 'has-sticky-ad';
    }
    return $classes;
}
add_filter( 'body_class', 'buzzmag_sticky_ad_body_class' );
