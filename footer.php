<?php
/**
 * Modern Footer Template
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

    <!-- Close Main Content div -->
    </div>

    <?php
    // Footer Ad (if configured)
    $footer_ad = get_theme_mod( 'footer_ad', '' );
    if ( ! empty( $footer_ad ) ) { ?>
        <div class="fl-ad fl-container clearfix">
            <span class="adtitle"><?php esc_html_e( '&ndash; Advertisement &ndash;', 'buzzmag' ); ?></span>
            <?php echo wp_kses_post( $footer_ad ); ?>
        </div>
    <?php } ?>

    <!-- Modern News Portal Footer -->
    <footer id="fl-footer" class="fl-modern-footer">
        <div class="fl-container">
            <!-- Footer Main Top: Brand & Quick Support Links -->
            <div class="fl-footer-main-row clearfix">
                <div class="fl-footer-brand-left">
                    <div class="fl-footer-logo">
                        <?php if ( get_theme_mod( 'logo' ) ) : ?>
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                <img src="<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
                            </a>
                        <?php else : ?>
                            <h2><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></a></h2>
                        <?php endif; ?>
                    </div>
                    <p class="fl-footer-desc">
                        <?php
                        $footer_about = get_theme_mod(
                            'footer_about_text',
                            esc_html__( 'ශ්‍රී ලංකාවේ සහ ලෝකයේ නවතම පුවත්, දේශපාලන, ව්‍යාපාරික, ක්‍රීඩා සහ විශේෂාංග පුවත් එසැනින් විශ්වාසදායී ලෙස ඔබ වෙත ගෙන එන ප්‍රමුඛතම ඩිජිටල් පුවත් සේවාව.', 'buzzmag' )
                        );
                        echo esc_html( $footer_about );
                        ?>
                    </p>
                </div>

                <!-- Footer Quick Nav -->
                <div class="fl-footer-quick-nav">
                    <span class="nav-title"><?php esc_html_e( 'Information & Support', 'buzzmag' ); ?></span>
                    <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                        <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => 1 ) ); ?>
                    <?php else : ?>
                        <ul>
                            <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'About Us', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'Privacy Policy', 'buzzmag' ); ?></a></li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Optional Dynamic Footer Widgets (If Active) -->
            <?php if ( ! get_theme_mod( 'hide_footer_widgets' ) && ( is_active_sidebar( 'buzzmag_footer1' ) || is_active_sidebar( 'buzzmag_footer2' ) || is_active_sidebar( 'buzzmag_footer3' ) ) ) : ?>
                <div id="fl-footer-widgets" class="clearfix">
                    <div class="widget-column">
                        <?php if ( is_active_sidebar( 'buzzmag_footer1' ) ) { dynamic_sidebar( 'buzzmag_footer1' ); } ?>
                    </div>
                    <div class="widget-column">
                        <?php if ( is_active_sidebar( 'buzzmag_footer2' ) ) { dynamic_sidebar( 'buzzmag_footer2' ); } ?>
                    </div>
                    <div class="widget-column">
                        <?php if ( is_active_sidebar( 'buzzmag_footer3' ) ) { dynamic_sidebar( 'buzzmag_footer3' ); } ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Footer Bottom Copyright Bar -->
            <div id="fl-copyright" class="clearfix">
                <div class="fl-copyright-left copyright">
                    <span class="fl-copyright-line">
                        <?php
                        $year_str     = function_exists( 'buzzmag_date' ) ? buzzmag_date( 'Y' ) : date( 'Y' );
                        $default_copy = '© ' . $year_str . ' ' . esc_html( get_bloginfo( 'name', 'display' ) ) . '. ' . esc_html__( 'All Rights Reserved.', 'buzzmag' );
                        echo wp_kses_post( get_theme_mod( 'copyrights', $default_copy ) );
                        ?>
                    </span>
                </div>
                <div class="fl-copyright-center">
                    <span class="fl-rebrand-tag">
                        <span class="fl-rebrand-badge"><i class="fa fa-code"></i> <?php esc_html_e( 'Rebranded by', 'buzzmag' ); ?></span>
                        <a href="mailto:jayawardhana.tiran@gmail.com" rel="author" class="fl-rebrand-author">
                            <strong>Tiran Jayawardhana</strong>
                        </a>
                    </span>
                </div>
                <div class="fl-copyright-right footer-powered">
                    <a href="#fl-header" class="fl-back-to-top" title="<?php esc_attr_e( 'Back to Top', 'buzzmag' ); ?>">
                        <span><?php esc_html_e( 'Back to Top', 'buzzmag' ); ?></span>
                        <i class="fa fa-arrow-up"></i>
                    </a>
                </div>
            </div>
        </div>
    </footer>

<!-- End Document -->
<?php wp_footer(); ?>
</body>
</html>
