    <!-- Close Main Content div -->
    </div>

    <?php
    // Footer Ad
    $footer_ad = get_theme_mod( 'footer_ad', '<a href="https://themeforest.net/item/buzzmag-viral-news-wordpress-magazineblog-theme/19207752?ref=FlatLayers" target="_blank"><img src="'.fl_theme_path.'/img/ad.jpg" alt="BuzzMag Ad"></a>' );
    if ( $footer_ad ) { ?>
        <div class="fl-ad fl-container clearfix">
            <span class="adtitle"><?php esc_html_e( '&ndash; Advertisement &ndash;', 'buzzmag' ); ?></span>
            <?php echo wp_kses_post($footer_ad); ?>
        </div>
    <?php } ?>

    <!-- Footer -->
    <footer id="fl-footer">
        <div class="fl-container clearfix">
            <?php if ( !get_theme_mod( 'hide_footer_widgets' ) ) { ?>        
                <div id="fl-footer-widgets" class="clearfix">
                    <div class="widget-column">
                        <?php if ( is_active_sidebar( 'buzzmag_footer1' ) ) { dynamic_sidebar('buzzmag_footer1'); } ?>
                    </div>
                    <div class="widget-column">
                        <?php if ( is_active_sidebar( 'buzzmag_footer2' ) ) { dynamic_sidebar('buzzmag_footer2'); } ?>
                    </div>
                    <div class="widget-column">
                        <?php if ( is_active_sidebar( 'buzzmag_footer3' ) ) { dynamic_sidebar('buzzmag_footer3'); } ?>
                    </div>
                </div>
            <?php } ?>
            <div id="fl-copyright" class="clearfix">
                <?php if ( has_nav_menu( 'footer-menu' ) ) { ?>
                    <div class="footer-menu">
                        <?php
                            wp_nav_menu( array(
                                'theme_location' => 'footer-menu',
                                'depth'          => 1
                            ) );
                        ?>
                    </div>
                <?php } ?>
                <div class="copyright">
                    <?php echo wp_kses_post( get_theme_mod( 'copyrights', esc_html('© ') .esc_html( date('Y') ). ' ' .esc_html( get_bloginfo( 'name', 'display' ) ) .'. Designed & Developed by <a href="http://flatlayers.com" target="_blank">FlatLayers</a>' ) ); ?>
                </div>
            </div>
        </div>
    </footer>
    
<!-- End Document -->

<?php wp_footer(); ?>
</body>
</html>