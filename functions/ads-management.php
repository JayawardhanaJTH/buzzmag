<?php
/**
 * Ad Spaces Management Engine
 *
 * Implements:
 * - 11 Homepage Ad Slots (2 top of lead 728x90, 2 bottom of lead 728x90, 1 top col3 300x300, 2 vertical mid col3 155x600, 4 col3 300x300)
 * - 11 Inner Post Ad Slots (2 top of post image 728x90, 2 bottom of post image 728x90, 1 top side panel 300x300, 2 vertical mid side panel 155x600, 4 side panel 300x300)
 * - Global sticky bottom banner ad with dismiss toggle & height-compensation
 * - Zero empty whitespace when an ad slot is unused
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Check if an Ad Slot has Content
 *
 * @param string $slot_id Theme mod slot ID.
 * @return bool
 */
function buzzmag_has_ad( $slot_id ) {
    $code = get_theme_mod( $slot_id, '' );
    return ( ! empty( $code ) && is_string( $code ) && '' !== trim( $code ) );
}

/**
 * Get Rendered Ad HTML Content
 *
 * @param string $slot_id Theme mod slot ID.
 * @return string
 */
function buzzmag_get_ad_html( $slot_id ) {
    $code = get_theme_mod( $slot_id, '' );
    if ( empty( $code ) || ! is_string( $code ) || '' === trim( $code ) ) {
        return '';
    }
    return do_shortcode( $code );
}

/**
 * Render a Single Ad Space Slot (e.g. 300x300, custom banner)
 *
 * @param string $slot_id       Theme mod slot identifier.
 * @param string $extra_classes Optional extra CSS classes for the wrapper.
 * @return bool True if ad was rendered, false if empty.
 */
function buzzmag_render_ad_space( $slot_id, $extra_classes = '' ) {
    $html = buzzmag_get_ad_html( $slot_id );
    if ( '' === $html ) {
        return false;
    }
    ?>
    <div class="fl-ad-space fl-ad-<?php echo esc_attr( $slot_id ); ?> <?php echo esc_attr( $extra_classes ); ?>">
        <div class="fl-ad-content">
            <?php echo $html; ?>
        </div>
    </div>
    <?php
    return true;
}

/**
 * Render Ad Script / Banner at End of Article Content (Single Post)
 * Outputs at the very end of the article, directly before </article>.
 *
 * @return bool True if content rendered, false if empty.
 */
function buzzmag_render_article_end_ad() {
    $code = get_theme_mod( 'single_article_end_ad', '' );
    if ( empty( $code ) || ! is_string( $code ) || '' === trim( $code ) ) {
        // Fallback to legacy post_ad if set
        $code = get_theme_mod( 'post_ad', '' );
    }

    if ( empty( $code ) || ! is_string( $code ) || '' === trim( $code ) ) {
        return false;
    }
    ?>
    <div class="fl-ad-space fl-article-end-ad alignwide">
        <div class="fl-ad-content">
            <?php echo do_shortcode( $code ); ?>
        </div>
    </div>
    <?php
    return true;
}

/**
 * Render Two Different (728x90) Ads Centered Stack
 * Used for:
 * - Top of Lead Post (Home)
 * - Bottom of Lead Post (Home)
 * - Top of Post Image (Inner Post)
 * - Bottom of Post Image (Inner Post)
 *
 * @param string $slot_1        First 728x90 ad slot ID.
 * @param string $slot_2        Second 728x90 ad slot ID.
 * @param string $extra_classes Optional extra CSS classes.
 * @return bool True if at least one ad was rendered.
 */
function buzzmag_render_stacked_centered_ads( $slot_1, $slot_2, $extra_classes = '' ) {
    $html_1 = buzzmag_get_ad_html( $slot_1 );
    $html_2 = buzzmag_get_ad_html( $slot_2 );

    if ( '' === $html_1 && '' === $html_2 ) {
        return false;
    }
    ?>
    <div class="fl-ad-stack-center <?php echo esc_attr( $extra_classes ); ?>">
        <?php if ( '' !== $html_1 ) : ?>
            <div class="fl-ad-slot fl-ad-728x90 fl-ad-<?php echo esc_attr( $slot_1 ); ?>">
                <div class="fl-ad-content">
                    <?php echo $html_1; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( '' !== $html_2 ) : ?>
            <div class="fl-ad-slot fl-ad-728x90 fl-ad-<?php echo esc_attr( $slot_2 ); ?>">
                <div class="fl-ad-content">
                    <?php echo $html_2; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return true;
}

/**
 * Render Two Vertical Ads (155x600) Side-by-Side in Column 3 or Side Panel
 *
 * @param string $slot_1        First 155x600 vertical ad slot ID.
 * @param string $slot_2        Second 155x600 vertical ad slot ID.
 * @param string $extra_classes Optional extra CSS classes.
 * @return bool True if at least one ad was rendered.
 */
function buzzmag_render_twin_vertical_ads( $slot_1, $slot_2, $extra_classes = '' ) {
    $html_1 = buzzmag_get_ad_html( $slot_1 );
    $html_2 = buzzmag_get_ad_html( $slot_2 );

    if ( '' === $html_1 && '' === $html_2 ) {
        return false;
    }
    ?>
    <div class="fl-ad-twin-vertical <?php echo esc_attr( $extra_classes ); ?>">
        <?php if ( '' !== $html_1 ) : ?>
            <div class="fl-ad-half fl-ad-155x600 fl-ad-<?php echo esc_attr( $slot_1 ); ?>">
                <div class="fl-ad-content">
                    <?php echo $html_1; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( '' !== $html_2 ) : ?>
            <div class="fl-ad-half fl-ad-155x600 fl-ad-<?php echo esc_attr( $slot_2 ); ?>">
                <div class="fl-ad-content">
                    <?php echo $html_2; ?>
                </div>
            </div>
        <?php endif; ?>
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
 * Output Custom Ad Scripts right at the top of <body> (wp_body_open)
 * Hooked to wp_body_open at priority 1 so it outputs immediately after the opened <body> tag.
 */
function buzzmag_output_body_open_ad_scripts() {
    $scripts = get_theme_mod( 'ad_header_scripts', '' );
    if ( ! empty( $scripts ) && is_string( $scripts ) && '' !== trim( $scripts ) ) {
        echo "\n<!-- BuzzMag Top of Body Ad Scripts -->\n";
        echo $scripts . "\n";
        echo "<!-- /BuzzMag Top of Body Ad Scripts -->\n\n";
    }
}
add_action( 'wp_body_open', 'buzzmag_output_body_open_ad_scripts', 1 );

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
