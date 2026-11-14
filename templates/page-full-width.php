<?php
/*
Template Name: Full Width Page
Template Post Type: page
*/

get_header();
?>

<div id="fl-content" class="fl-single fl-3d-single-page fl-3d-page">
    <div class="fl-container clearfix">
        <?php while ( have_posts() ) : the_post(); ?>
            <div class="clearfix fl-single-columns-wrap">
                <div id="fl-post-container" class="no-sidebar" style="width: 100%; max-width: 100%;">
                    <div id="post-<?php the_ID(); ?>" <?php post_class( 'fl-3d-card fl-single-article-card' ); ?>>
                        <!-- 1. Page Media -->
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
                                <div class="fl-post-header">
                                    <h1 class="title"><?php the_title(); ?></h1>

                                    <?php if ( has_excerpt() ) : ?>
                                        <div class="fl-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

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
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php get_footer(); ?>
