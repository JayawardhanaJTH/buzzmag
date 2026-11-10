<?php
/**
 * Modern Footer Template (Unusuma.lk Inspired)
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

    <!-- Modern News Portal Footer (Unusuma.lk inspired) -->
    <footer id="fl-footer" class="fl-modern-footer">
        <div class="fl-container">
            <!-- Footer Top Brand & Socials -->
            <div class="fl-footer-top-brand clearfix">
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

                <div class="fl-footer-social-connect">
                    <span class="social-title"><?php esc_html_e( 'අප හා එක්වන්න (Connect With Us)', 'buzzmag' ); ?></span>
                    <div class="fl-footer-social-icons">
                        <?php if ( get_theme_mod( 'facebook' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'facebook' ) ); ?>" target="_blank" rel="noopener" class="social-fb" title="Facebook"><i class="fa fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if ( get_theme_mod( 'youtube' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'youtube' ) ); ?>" target="_blank" rel="noopener" class="social-yt" title="YouTube"><i class="fa fa-youtube-play"></i></a>
                        <?php endif; ?>
                        <?php if ( get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' ) ); ?>" target="_blank" rel="noopener" class="social-wa" title="WhatsApp"><i class="fa fa-whatsapp"></i></a>
                        <?php endif; ?>
                        <?php if ( get_theme_mod( 'twitter' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'twitter' ) ); ?>" target="_blank" rel="noopener" class="social-tw" title="Twitter"><i class="fa fa-twitter"></i></a>
                        <?php endif; ?>
                        <?php if ( get_theme_mod( 'instagram' ) ) : ?>
                            <a href="<?php echo esc_url( get_theme_mod( 'instagram' ) ); ?>" target="_blank" rel="noopener" class="social-ig" title="Instagram"><i class="fa fa-instagram"></i></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Optional Dynamic Footer Widgets -->
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
            <?php else : ?>
                <!-- Default News Portal Quick Links -->
                <div class="fl-footer-nav-columns clearfix">
                    <div class="fl-fcol">
                        <h4><?php esc_html_e( 'ප්‍රධාන පුවත්', 'buzzmag' ); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'මුල් පිටුව (Home)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'local' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'දේශීය පුවත් (Local)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'foreign' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'විදේශීය පුවත් (Foreign)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'politics' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'දේශපාලන (Politics)', 'buzzmag' ); ?></a></li>
                        </ul>
                    </div>

                    <div class="fl-fcol">
                        <h4><?php esc_html_e( 'අංශ සහ විශේෂාංග', 'buzzmag' ); ?></h4>
                        <ul>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'business' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'ව්‍යාපාරික (Business)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'sports' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'ක්‍රීඩා පුවත් (Sports)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'featured' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'විශේෂාංග (Featured)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_category_link( get_cat_ID( 'off-road' ) ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'පිටරට / Off Road', 'buzzmag' ); ?></a></li>
                        </ul>
                    </div>

                    <div class="fl-fcol">
                        <h4><?php esc_html_e( 'සේවා සහ නැකැත්', 'buzzmag' ); ?></h4>
                        <ul>
                            <li><a href="#rahu-kalaya"><i class="fa fa-clock-o"></i> <?php esc_html_e( 'රාහු කාලය (Rahu Kalaya)', 'buzzmag' ); ?></a></li>
                            <li><a href="#subha-dishawa"><i class="fa fa-compass"></i> <?php esc_html_e( 'සුබ සහ මරු සිටින දිශාව', 'buzzmag' ); ?></a></li>
                            <li><a href="#cartoon-section"><i class="fa fa-paint-brush"></i> <?php esc_html_e( 'දවසේ කාටූනය (Cartoon)', 'buzzmag' ); ?></a></li>
                            <li><a href="<?php echo esc_url( get_theme_mod( 'whatsapp_link', 'https://chat.whatsapp.com/' ) ); ?>" target="_blank" rel="noopener"><i class="fa fa-whatsapp"></i> <?php esc_html_e( 'WhatsApp Alerts', 'buzzmag' ); ?></a></li>
                        </ul>
                    </div>

                    <div class="fl-fcol">
                        <h4><?php esc_html_e( 'තොරතුරු සහ සහාය', 'buzzmag' ); ?></h4>
                        <?php if ( has_nav_menu( 'footer-menu' ) ) : ?>
                            <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'depth' => 1 ) ); ?>
                        <?php else : ?>
                            <ul>
                                <li><a href="<?php echo esc_url( home_url( '/about/' ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'අප ගැන (About Us)', 'buzzmag' ); ?></a></li>
                                <li><a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'සම්බන්ධ වන්න (Contact Us)', 'buzzmag' ); ?></a></li>
                                <li><a href="<?php echo esc_url( home_url( '/privacy-policy/' ) ); ?>"><i class="fa fa-angle-right"></i> <?php esc_html_e( 'රහස්‍යතා ප්‍රතිපත්තිය', 'buzzmag' ); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Footer Bottom Copyright Bar -->
            <div id="fl-copyright" class="clearfix">
                <div class="copyright">
                    <?php
                    $default_copy = '© ' . date( 'Y' ) . ' ' . esc_html( get_bloginfo( 'name', 'display' ) ) . '. ' . esc_html__( 'සියලුම හිමිකම් ඇවිරිණි (All Rights Reserved).', 'buzzmag' );
                    echo wp_kses_post( get_theme_mod( 'copyrights', $default_copy ) );
                    ?>
                </div>
                <div class="footer-powered">
                    <a href="#fl-header" class="fl-back-to-top" title="<?php esc_attr_e( 'Back to Top', 'buzzmag' ); ?>">
                        <span><?php esc_html_e( 'ඉහළට', 'buzzmag' ); ?></span>
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
