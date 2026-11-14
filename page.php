<?php
/**
 * Modern 3D Page Template
 *
 * Implements:
 * - 70/30 split layout with top baseline alignment matching category.php and single.php
 * - 3D Page Content Card with optional large featured image
 * - Below Sections: Latest News (6) & Most Read (staged 96h, 6) via buzzmag_render_single_under_post()
 * - Side Panel: Sticky 6-Category 3D Sidebar & Mobile Utilities via buzzmag_render_single_sidebar_categories()
 * - WooCommerce Cart/Checkout/Account full-width support
 *
 * @package BuzzMag
 */

$header = true;
$sidebar = true;
$layoutClass = '';

if ( get_theme_mod( 'hide_sidebar_page', false ) ) {
    $sidebar = false;
    $layoutClass = 'no-sidebar';
}

if ( class_exists( 'WooCommerce' ) ) {
    if ( is_cart() || is_checkout() ) {
        $header = true;
        $sidebar = false;
        $layoutClass = 'no-sidebar';
    } elseif ( is_account_page() ) {
        $header = false;
        $sidebar = false;
        $layoutClass = 'no-sidebar';
    }
}

get_header();
?>

<div id="fl-content" class="fl-single fl-3d-single-page fl-3d-page">
    <div class="fl-container clearfix">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="clearfix fl-single-columns-wrap">
                <!-- ================= Left Main Column: Page Content & Below Sections ================= -->
                <div id="fl-post-container" class="<?php echo esc_attr( $layoutClass ); ?>">
                    <div id="post-<?php the_ID(); ?>" <?php post_class( 'fl-3d-card fl-single-article-card' ); ?>>
                        <!-- 1. Page Media aligned with sidebar start -->
                        <?php if ( has_post_thumbnail() ) : ?>
                            <div class="fl-media-wrap">
                                <div class="fl-picture single">
                                    <?php the_post_thumbnail( 'buzzmag_large' ); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- 2. Page Body Wrap -->
                        <div class="fl-single-body-wrap">
                            <article class="fl-article" post-id="<?php the_ID(); ?>">
                                <?php if ( $header === true ) : ?>
                                    <div class="fl-post-header">
                                        <h1 class="title"><?php the_title(); ?></h1>

                                        <?php if ( has_excerpt() ) : ?>
                                            <div class="fl-excerpt">
                                                <?php the_excerpt(); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>

                                <div class="fl-post-content clearfix">
                                    <?php
                                    the_content();
                                    $link_pages_args = array(
                                        'before'           => '<div class="fl-page-links">',
                                        'after'            => '</div>',
                                        'separator'        => '<span class="page-link-sep"><span>' . esc_html__( 'Page', 'buzzmag' ) . '</span>' . $page . esc_html__( ' / ', 'buzzmag' ) . count( $pages ) . '</span>',
                                        'next_or_number'   => 'next',
                                        'nextpagelink'     => '<span class="page-link">' . esc_html__( 'Next', 'buzzmag' ) . '</span><i class="fa fa-long-arrow-right"></i>',
                                        'previouspagelink' => '<i class="fa fa-long-arrow-left"></i><span class="page-link">' . esc_html__( 'Previous', 'buzzmag' ) . '</span>',
                                    );
                                    wp_link_pages( $link_pages_args );
                                    ?>
                                </div>
                            </article>
                        </div>
                    </div>

                    <!-- 3. Below Sections (Latest News 6 & Most Read 6) -->
                    <?php buzzmag_render_single_under_post( 0 ); ?>
                </div>

                <!-- ================= Right Side Panel: 6 Main Category Cards & Mobile Utilities ================= -->
                <?php if ( $sidebar == true ) : ?>
                    <aside id="fl-sidebar" class="fl-sticky-sidebar fl-single-sidebar">
                        <?php
                        // Render the 6 Main Categories (3 posts each) + Mobile Utilities at bottom
                        buzzmag_render_single_sidebar_categories( 0 );

                        // Default sidebar widgets (if any exist)
                        if ( is_active_sidebar( 'buzzmag_sidebar' ) ) {
                            dynamic_sidebar( 'buzzmag_sidebar' );
                        }
                        ?>
                    </aside>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
