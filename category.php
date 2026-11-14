<?php
/**
 * Modern 3D Category Template
 *
 * Implements:
 * - 70/30 split layout with top baseline alignment matching single.php
 * - 3D Category Hero / Header card with icon badge, title, count pill, subcategories, and description
 * - 3D Post Grid (2-column responsive layout using buzzmag_render_3d_post_card)
 * - 3D Pagination with elevation and smooth hover states
 * - Below Sections: Latest News (6) & Most Read (staged 96h, 6) via buzzmag_render_single_under_post()
 * - Side Panel: Sticky 6-Category 3D Sidebar via buzzmag_render_single_sidebar_categories()
 *
 * @package BuzzMag
 */

$sidebar = true;
$layoutClass = '';

if ( get_theme_mod( 'hide_sidebar_category', false ) ) {
    $sidebar = false;
    $layoutClass = 'no-sidebar';
}

$term = get_queried_object();
$badge_meta = function_exists( 'buzzmag_get_category_badge_meta' )
    ? buzzmag_get_category_badge_meta( $term )
    : array( 'icon' => 'fa-folder-open', 'color' => '#ed0e28' );

$cat_color = ! empty( $badge_meta['color'] ) ? $badge_meta['color'] : '#ed0e28';
$cat_icon  = ! empty( $badge_meta['icon'] ) ? $badge_meta['icon'] : 'fa-folder-open';
$cat_count = isset( $term->count ) ? (int) $term->count : 0;

get_header();
?>

<div id="fl-content" class="fl-single fl-3d-single-page fl-3d-category-page">
    <div class="fl-container clearfix">
        <div class="clearfix fl-single-columns-wrap">
            <!-- ================= Left Main Column: Category Header, Posts & Below Sections ================= -->
            <div id="fl-post-container" class="<?php echo esc_attr( $layoutClass ); ?>">

                <!-- 1. 3D Category Header Card -->
                <div class="fl-3d-card fl-category-header-card" style="--cat-accent: <?php echo esc_attr( $cat_color ); ?>;">
                    <div class="fl-cat-header-top">
                        <span class="fl-cat-header-badge" style="background: <?php echo esc_attr( $cat_color ); ?>;">
                            <i class="fa <?php echo esc_attr( $cat_icon ); ?>"></i>
                        </span>
                        <div class="fl-cat-header-info">
                            <span class="fl-cat-sub-label"><?php esc_html_e( 'Category Archive', 'buzzmag' ); ?></span>
                            <h1 class="fl-cat-header-title"><?php single_cat_title( '', true ); ?></h1>
                        </div>
                        <span class="fl-cat-count-pill">
                            <i class="fa fa-newspaper-o"></i> <?php echo esc_html( sprintf( _n( '%s Article', '%s Articles', $cat_count, 'buzzmag' ), number_format_i18n( $cat_count ) ) ); ?>
                        </span>
                    </div>

                    <?php
                    if ( isset( $term->taxonomy ) && isset( $term->term_id ) ) {
                        $subCats = get_terms( $term->taxonomy, array(
                            'parent'     => $term->term_id,
                            'hide_empty' => false,
                        ) );
                        if ( ! empty( $subCats ) && ! is_wp_error( $subCats ) ) : ?>
                            <div class="fl-cat-subcategories">
                                <span class="fl-subcat-label"><i class="fa fa-sitemap"></i> <?php esc_html_e( 'Subcategories:', 'buzzmag' ); ?></span>
                                <div class="fl-subcat-links">
                                    <?php foreach ( $subCats as $sub ) : ?>
                                        <a class="fl-subcat-pill" href="<?php echo esc_url( get_category_link( $sub->term_id ) ); ?>">
                                            <?php echo esc_html( $sub->name ); ?>
                                        </a>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endif;
                    }

                    if ( category_description() ) : ?>
                        <div class="fl-cat-header-desc">
                            <?php echo category_description(); ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- 2. Category Posts Grid (3D Cards) -->
                <?php if ( have_posts() ) : ?>
                    <div class="fl-category-3d-grid">
                        <?php while ( have_posts() ) : the_post(); ?>
                            <?php buzzmag_render_3d_post_card( get_the_ID(), 'card' ); ?>
                        <?php endwhile; ?>
                    </div>

                    <!-- 3. Modern 3D Pagination -->
                    <div class="fl-category-pagination">
                        <?php
                        the_posts_pagination( array(
                            'prev_text'          => '<i class="fa fa-angle-left"></i> ' . esc_html__( 'Previous', 'buzzmag' ),
                            'next_text'          => esc_html__( 'Next', 'buzzmag' ) . ' <i class="fa fa-angle-right"></i>',
                            'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'buzzmag' ) . ' </span>',
                            'mid_size'           => 2,
                        ) );
                        ?>
                    </div>
                <?php else : ?>
                    <div class="fl-3d-card fl-no-posts-card">
                        <i class="fa fa-info-circle"></i>
                        <p><?php esc_html_e( 'No posts published in this category yet.', 'buzzmag' ); ?></p>
                    </div>
                <?php endif; ?>

                <!-- 4. Below Sections (Under Category: Latest News & Most Read in 96h) -->
                <?php buzzmag_render_single_under_post( 0 ); ?>

            </div>

            <!-- ================= Right Side Panel: 6 Main Category Cards ================= -->
            <?php if ( $sidebar == true ) : ?>
                <aside id="fl-sidebar" class="fl-sticky-sidebar fl-single-sidebar">
                    <?php
                    // Render the 6 Main Categories (3 posts each in 3D category cards)
                    buzzmag_render_single_sidebar_categories( 0 );

                    // Default sidebar widgets (if any exist)
                    if ( is_active_sidebar( 'buzzmag_sidebar' ) ) {
                        dynamic_sidebar( 'buzzmag_sidebar' );
                    }
                    ?>
                </aside>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php get_footer(); ?>
