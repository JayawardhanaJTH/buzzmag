<?php
/**
 * News Loops & Query Helpers for Rebranded 3D Layout
 *
 * Implements query helpers for Lead, Latest 10, Most Viewed (4 days / 36 hrs / week),
 * Category 3D cards, and below sections.
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Resolve a category term by slug or name, with Customizer override support.
 *
 * @param string $setting_key Customizer setting key or slug.
 * @param string $default_slug Default category slug.
 * @return WP_Term|null
 */
function buzzmag_resolve_category( $setting_key, $default_slug ) {
    $slug = get_theme_mod( $setting_key, $default_slug );
    if ( empty( $slug ) ) {
        $slug = $default_slug;
    }

    $term = get_term_by( 'slug', $slug, 'category' );
    if ( ! $term ) {
        // Try finding by name
        $term = get_term_by( 'name', $slug, 'category' );
    }
    return $term ? $term : null;
}

/**
 * Query Latest Posts excluding the Lead post.
 *
 * @param int $lead_id Post ID of the lead post to exclude.
 * @param int $count Number of posts to return (default 10).
 * @return WP_Query
 */
function buzzmag_query_latest_posts_ex_lead( $lead_id = 0, $count = 10 ) {
    $exclude = array();
    if ( ! empty( $lead_id ) ) {
        $exclude[] = (int) $lead_id;
    }

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'ignore_sticky_posts' => 1,
    );

    if ( ! empty( $exclude ) ) {
        $args['post__not_in'] = $exclude;
    }

    return new WP_Query( $args );
}

/**
 * Query Top Viewed Posts within a given number of days.
 *
 * @param int $days Number of days (default 4).
 * @param int $count Number of posts (default 1).
 * @return WP_Query
 */
function buzzmag_query_most_viewed_days( $days = 4, $count = 1 ) {
    $date_after = $days . ' days ago';

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'meta_key'            => 'post_views_count',
        'orderby'             => 'meta_value_num',
        'order'               => 'DESC',
        'ignore_sticky_posts' => 1,
        'date_query'          => array(
            array(
                'after' => $date_after,
            ),
        ),
    );

    $query = new WP_Query( $args );

    // If no posts found with views in the date window, fall back to most viewed overall
    if ( ! $query->have_posts() ) {
        unset( $args['date_query'] );
        $query = new WP_Query( $args );
    }

    // If still no posts with views, fall back to latest posts
    if ( ! $query->have_posts() ) {
        $query = new WP_Query( array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $count,
            'ignore_sticky_posts' => 1,
        ) );
    }

    return $query;
}

/**
 * Query Top Viewed Posts within a given number of hours (e.g. 36 hours for single view).
 *
 * @param int $hours Number of hours (default 36).
 * @param int $count Number of posts (default 6).
 * @param array $exclude_ids Array of post IDs to exclude.
 * @return WP_Query
 */
function buzzmag_query_most_viewed_hours( $hours = 36, $count = 6, $exclude_ids = array() ) {
    $date_after = $hours . ' hours ago';

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'meta_key'            => 'post_views_count',
        'orderby'             => 'meta_value_num',
        'order'               => 'DESC',
        'ignore_sticky_posts' => 1,
        'date_query'          => array(
            array(
                'after' => $date_after,
            ),
        ),
    );

    if ( ! empty( $exclude_ids ) ) {
        $args['post__not_in'] = $exclude_ids;
    }

    $query = new WP_Query( $args );

    // Fallback if not enough views in 36 hours
    if ( $query->post_count < $count ) {
        unset( $args['date_query'] );
        $query = new WP_Query( $args );
    }

    if ( ! $query->have_posts() ) {
        $query = new WP_Query( array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $count,
            'post__not_in'        => $exclude_ids,
            'ignore_sticky_posts' => 1,
        ) );
    }

    return $query;
}

/**
 * Query Top Stories within the past week (7 days) for mobile view.
 *
 * @param int $count Number of posts (default 6).
 * @param array $exclude_ids Post IDs to exclude.
 * @return WP_Query
 */
function buzzmag_query_top_stories_week( $count = 6, $exclude_ids = array() ) {
    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'meta_key'            => 'post_views_count',
        'orderby'             => 'meta_value_num',
        'order'               => 'DESC',
        'ignore_sticky_posts' => 1,
        'date_query'          => array(
            array(
                'after' => '7 days ago',
            ),
        ),
    );

    if ( ! empty( $exclude_ids ) ) {
        $args['post__not_in'] = $exclude_ids;
    }

    $query = new WP_Query( $args );

    // Fallback if date query returns empty
    if ( ! $query->have_posts() ) {
        unset( $args['date_query'] );
        $query = new WP_Query( $args );
    }

    if ( ! $query->have_posts() ) {
        $query = new WP_Query( array(
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'posts_per_page'      => $count,
            'post__not_in'        => $exclude_ids,
            'ignore_sticky_posts' => 1,
        ) );
    }

    return $query;
}

/**
 * Resolve a WordPress Category Term from slug, ID, or name with multi-stage fuzzy fallback.
 *
 * @param string|int|WP_Term $slug_or_id_or_name Category identifier.
 * @param string $fallback_title Optional display title to attempt matching.
 * @return WP_Term|null
 */
function buzzmag_resolve_category_term( $slug_or_id_or_name, $fallback_title = '' ) {
    if ( empty( $slug_or_id_or_name ) && empty( $fallback_title ) ) {
        return null;
    }

    if ( is_a( $slug_or_id_or_name, 'WP_Term' ) ) {
        return $slug_or_id_or_name;
    }

    // 1. Numeric ID check
    if ( is_numeric( $slug_or_id_or_name ) && (int) $slug_or_id_or_name > 0 ) {
        $term = get_term( (int) $slug_or_id_or_name, 'category' );
        if ( $term && ! is_wp_error( $term ) ) {
            return $term;
        }
    }

    $input = trim( (string) $slug_or_id_or_name );

    // 2. Exact slug match
    if ( ! empty( $input ) ) {
        $term = get_term_by( 'slug', $input, 'category' );
        if ( $term && ! is_wp_error( $term ) ) {
            return $term;
        }

        // 3. Sanitized slug match
        $sanitized = sanitize_title( $input );
        if ( ! empty( $sanitized ) && $sanitized !== $input ) {
            $term = get_term_by( 'slug', $sanitized, 'category' );
            if ( $term && ! is_wp_error( $term ) ) {
                return $term;
            }
        }

        // 4. Exact name match
        $term = get_term_by( 'name', $input, 'category' );
        if ( $term && ! is_wp_error( $term ) ) {
            return $term;
        }
    }

    // 5. Check with fallback title (if provided)
    if ( ! empty( $fallback_title ) ) {
        $clean_title = trim( $fallback_title );

        $term = get_term_by( 'name', $clean_title, 'category' );
        if ( $term && ! is_wp_error( $term ) ) {
            return $term;
        }

        $term = get_term_by( 'slug', sanitize_title( $clean_title ), 'category' );
        if ( $term && ! is_wp_error( $term ) ) {
            return $term;
        }

        // Extract inside parentheses, e.g. "Local" from "දේශීය පුවත් (Local News)"
        if ( preg_match( '/\((.*?)\)/u', $clean_title, $m ) ) {
            $inner = trim( $m[1] );
            if ( ! empty( $inner ) ) {
                $term = get_term_by( 'slug', sanitize_title( $inner ), 'category' );
                if ( $term && ! is_wp_error( $term ) ) {
                    return $term;
                }
                $term = get_term_by( 'name', $inner, 'category' );
                if ( $term && ! is_wp_error( $term ) ) {
                    return $term;
                }
            }
        }

        // Extract before parentheses
        $before = trim( preg_replace( '/\(.*?\)/u', '', $clean_title ) );
        if ( ! empty( $before ) ) {
            $term = get_term_by( 'name', $before, 'category' );
            if ( $term && ! is_wp_error( $term ) ) {
                return $term;
            }
            $term = get_term_by( 'slug', sanitize_title( $before ), 'category' );
            if ( $term && ! is_wp_error( $term ) ) {
                return $term;
            }
        }
    }

    // 6. Fuzzy keyword search across all existing categories
    if ( function_exists( 'get_categories' ) ) {
        $all_cats = get_categories( array( 'hide_empty' => false ) );
        if ( ! empty( $all_cats ) && ! is_wp_error( $all_cats ) ) {
            $needle = strtolower( $input );
            $keywords_map = array(
                'local'    => array( 'local', 'deshiya', 'lanka', 'sri-lanka', 'colombo' ),
                'offroad'  => array( 'off-road', 'offroad', 'foreign', 'world', 'pitarata', 'international' ),
                'off-road' => array( 'off-road', 'offroad', 'foreign', 'world', 'pitarata', 'international' ),
                'business' => array( 'business', 'biz', 'vyaparika', 'economy', 'finance', 'market' ),
                'sports'   => array( 'sports', 'sport', 'krida', 'cricket' ),
                'foreign'  => array( 'foreign', 'world', 'pitarata', 'international', 'global' ),
                'politics' => array( 'politics', 'politic', 'deshapalana' ),
                'featured' => array( 'featured', 'feature', 'visheshanga', 'special' ),
            );

            $search_keywords = array();
            if ( ! empty( $needle ) ) {
                $search_keywords[] = $needle;
                if ( isset( $keywords_map[ $needle ] ) ) {
                    $search_keywords = array_merge( $search_keywords, $keywords_map[ $needle ] );
                }
            }

            foreach ( $all_cats as $cat ) {
                $cat_slug_lower = strtolower( $cat->slug );
                $cat_name_lower = strtolower( $cat->name );

                // Direct case-insensitive match
                if ( ! empty( $needle ) && ( $cat_slug_lower === $needle || $cat_name_lower === $needle ) ) {
                    return $cat;
                }

                // Keyword match
                foreach ( $search_keywords as $kw ) {
                    if ( ! empty( $kw ) && ( strpos( $cat_slug_lower, $kw ) !== false || strpos( $cat_name_lower, $kw ) !== false ) ) {
                        return $cat;
                    }
                }
            }
        }
    }

    return null;
}

/**
 * Get category archive URL safely without ever returning '#'
 *
 * @param WP_Term|null $term Category term object or null.
 * @param string $fallback_slug Fallback slug to construct URL if term not yet in database.
 * @return string Valid navigable URL.
 */
function buzzmag_get_category_link( $term = null, $fallback_slug = '' ) {
    if ( $term && ! is_wp_error( $term ) && ! empty( $term->term_id ) ) {
        $link = get_category_link( $term->term_id );
        if ( ! empty( $link ) && ! is_wp_error( $link ) && '#' !== $link ) {
            return $link;
        }
    }

    $slug = ! empty( $fallback_slug ) ? sanitize_title( $fallback_slug ) : 'category';
    $permalink_structure = get_option( 'permalink_structure' );

    if ( ! empty( $permalink_structure ) ) {
        return home_url( '/category/' . urlencode( $slug ) . '/' );
    }

    return add_query_arg( 'category_name', urlencode( $slug ), home_url( '/' ) );
}

/**
 * Query posts for a specific category.
 *
 * @param string $cat_slug Category slug or name.
 * @param int $count Number of posts.
 * @param array $exclude_ids IDs to exclude.
 * @param string $title Optional title for fallback matching.
 * @return WP_Query
 */
function buzzmag_query_category_posts( $cat_slug, $count = 5, $exclude_ids = array(), $title = '' ) {
    $term = buzzmag_resolve_category_term( $cat_slug, $title );

    $args = array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => $count,
        'ignore_sticky_posts' => 1,
    );

    if ( $term && ! is_wp_error( $term ) ) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $term->term_id,
            ),
        );
    }

    if ( ! empty( $exclude_ids ) ) {
        $args['post__not_in'] = $exclude_ids;
    }

    $query = new WP_Query( $args );

    // If specific category has no posts, fallback to published posts so layout never breaks
    if ( ! $query->have_posts() && $term ) {
        unset( $args['tax_query'] );
        $query = new WP_Query( $args );
    }

    return $query;
}

/**
 * Render a single 3D Post Card
 *
 * @param int|WP_Post $post Post ID or WP_Post.
 * @param string $style 'lead' | 'card' | 'compact-row' | 'list-item'.
 * @param array $options Additional render options.
 */
function buzzmag_render_3d_post_card( $post = null, $style = 'card', $options = array() ) {
    $post = get_post( $post );
    if ( ! $post ) {
        return;
    }

    $post_id   = $post->ID;
    $permalink = get_permalink( $post_id );
    $title     = get_the_title( $post_id );
    $views     = buzzmag_getpostviews( $post_id );
    $time_ago  = human_time_diff( get_the_time( 'U', $post_id ), current_time( 'timestamp' ) ) . esc_html__( ' ago', 'buzzmag' );
    $categories = get_the_category( $post_id );
    $first_cat = ! empty( $categories ) ? $categories[0] : null;

    if ( 'lead' === $style ) : ?>
        <article class="fl-3d-card fl-lead-hero-card">
            <div class="fl-lead-media">
                <a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $title ); ?>">
                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'buzzmag_large' ); ?>
                    <?php else : ?>
                        <div class="fl-lead-placeholder"></div>
                    <?php endif; ?>
                </a>
                <span class="fl-lead-badge"><i class="fa fa-bolt"></i> <?php esc_html_e( 'ප්‍රධාන පුවත (Lead Story)', 'buzzmag' ); ?></span>
                <?php if ( $first_cat && strtolower( $first_cat->slug ) !== 'uncategorized' ) : ?>
                    <a href="<?php echo esc_url( get_category_link( $first_cat->term_id ) ); ?>" class="fl-cat-pill">
                        <?php echo esc_html( $first_cat->name ); ?>
                    </a>
                <?php endif; ?>
            </div>
            <div class="fl-lead-content">
                <div class="fl-lead-meta">
                    <span class="meta-item"><i class="fa fa-clock-o"></i> <?php echo esc_html( $time_ago ); ?></span>
                    <?php if ( ! empty( $views ) ) : ?>
                        <span class="meta-item views"><i class="fa fa-eye"></i> <?php echo esc_html( $views ); ?></span>
                    <?php endif; ?>
                </div>
                <h2 class="fl-lead-title">
                    <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
                </h2>
                <div class="fl-lead-excerpt">
                    <?php
                    $excerpt = get_the_excerpt( $post_id );
                    echo esc_html( wp_trim_words( $excerpt, 32, '...' ) );
                    ?>
                </div>
                <div class="fl-lead-action">
                    <a href="<?php echo esc_url( $permalink ); ?>" class="fl-3d-btn">
                        <span><?php esc_html_e( 'සම්පූර්ණ පුවත කියවන්න (Read Story)', 'buzzmag' ); ?></span>
                        <i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </article>

    <?php elseif ( 'compact-row' === $style || 'horizontal-card' === $style ) : ?>
        <article class="fl-3d-card fl-post-card-horizontal">
            <div class="fl-card-thumb">
                <a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $title ); ?>">
                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'buzzmag_small' ); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url( fl_theme_path . '/img/buzzmag_small.png' ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                    <?php endif; ?>
                </a>
            </div>
            <div class="fl-card-body">
                <h4 class="fl-card-title">
                    <a href="<?php echo esc_url( $permalink ); ?>" title="<?php echo esc_attr( $title ); ?>"><?php echo esc_html( $title ); ?></a>
                </h4>
                <div class="fl-card-meta">
                    <span class="fl-post-date"><i class="fa fa-calendar"></i> <?php echo esc_html( get_the_date( 'F j, Y', $post_id ) ); ?></span>
                </div>
            </div>
        </article>

    <?php elseif ( 'list-item' === $style ) : ?>
        <div class="fl-cat-list-item">
            <span class="fl-bullet"><i class="fa fa-angle-double-right"></i></span>
            <div class="fl-item-text">
                <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
                <small><i class="fa fa-clock-o"></i> <?php echo esc_html( $time_ago ); ?></small>
            </div>
        </div>

    <?php else : // standard card ?>
        <article class="fl-3d-card fl-post-card-standard">
            <div class="fl-card-media">
                <a href="<?php echo esc_url( $permalink ); ?>">
                    <?php if ( has_post_thumbnail( $post_id ) ) : ?>
                        <?php echo get_the_post_thumbnail( $post_id, 'buzzmag_medium' ); ?>
                    <?php else : ?>
                        <img src="<?php echo esc_url( fl_theme_path . '/img/buzzmag_medium.png' ); ?>" alt="<?php echo esc_attr( $title ); ?>">
                    <?php endif; ?>
                </a>
            </div>
            <div class="fl-card-details">
                <h3 class="fl-card-title">
                    <a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
                </h3>
                <div class="fl-card-meta">
                    <span><i class="fa fa-clock-o"></i> <?php echo esc_html( $time_ago ); ?></span>
                    <?php if ( ! empty( $views ) ) : ?>
                        <span><i class="fa fa-eye"></i> <?php echo esc_html( $views ); ?></span>
                    <?php endif; ?>
                </div>
            </div>
        </article>
    <?php endif;
}

/**
 * Render a complete 3D Category Card
 *
 * @param string $title Category title (Sinhala / English).
 * @param string $slug Category slug.
 * @param int $count Number of posts (default 5).
 * @param string $icon FontAwesome icon class.
 * @param string $accent_color Accent color hex.
 */
function buzzmag_render_category_3d_card( $title, $slug, $count = 5, $icon = 'fa-newspaper-o', $accent_color = '#ed0e28' ) {
    $term  = buzzmag_resolve_category_term( $slug, $title );
    $query = buzzmag_query_category_posts( $slug, $count, array(), $title );

    // If term was not found directly, deduce category from the posts returned
    if ( ! $term && $query->have_posts() && ! empty( $query->posts[0] ) ) {
        $post_cats = get_the_category( $query->posts[0]->ID );
        if ( ! empty( $post_cats ) ) {
            foreach ( $post_cats as $pc ) {
                if ( 'uncategorized' !== strtolower( $pc->slug ) ) {
                    $term = $pc;
                    break;
                }
            }
            if ( ! $term && ! empty( $post_cats[0] ) ) {
                $term = $post_cats[0];
            }
        }
    }

    $term_link     = buzzmag_get_category_link( $term, $slug );
    $display_title = ! empty( $title ) ? $title : ( $term ? $term->name : ucfirst( $slug ) );
    ?>
    <div class="fl-3d-card fl-category-card-3d" style="--cat-accent: <?php echo esc_attr( $accent_color ); ?>;">
        <div class="fl-cat-card-header">
            <div class="fl-cat-header-left">
                <a href="<?php echo esc_url( $term_link ); ?>" class="fl-cat-icon-link" aria-label="<?php echo esc_attr( $display_title ); ?>">
                    <span class="fl-cat-icon" style="background: <?php echo esc_attr( $accent_color ); ?>;">
                        <i class="fa <?php echo esc_attr( $icon ); ?>"></i>
                    </span>
                </a>
                <h3 class="fl-cat-name">
                    <a href="<?php echo esc_url( $term_link ); ?>" title="<?php echo esc_attr( $display_title ); ?>">
                        <?php echo esc_html( $display_title ); ?>
                    </a>
                </h3>
            </div>
            <a href="<?php echo esc_url( $term_link ); ?>" class="fl-cat-more" title="<?php esc_attr_e( 'View All Posts', 'buzzmag' ); ?>">
                <span><?php esc_html_e( 'තවත් (More)', 'buzzmag' ); ?></span>
                <i class="fa fa-angle-right"></i>
            </a>
        </div>

        <div class="fl-cat-card-body">
            <?php if ( $query->have_posts() ) :
                while ( $query->have_posts() ) :
                    $query->the_post();
                    ?>
                    <div class="fl-cat-post-item">
                        <div class="fl-cat-item-thumb">
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php the_post_thumbnail( 'buzzmag_small' ); ?>
                                <?php else : ?>
                                    <img src="<?php echo esc_url( fl_theme_path . '/img/buzzmag_small.png' ); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="fl-cat-item-content">
                            <h4 class="fl-cat-item-title">
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
                            </h4>
                            <div class="fl-cat-item-meta">
                                <span class="fl-post-date"><i class="fa fa-calendar"></i> <?php echo esc_html( get_the_date( 'F j, Y' ) ); ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                endwhile;
                wp_reset_postdata();
            else : ?>
                <p class="fl-no-posts"><?php esc_html_e( 'පුවත් නොමැත (No posts found in this category)', 'buzzmag' ); ?></p>
            <?php endif; ?>
        </div>

        <div class="fl-cat-card-footer">
            <a href="<?php echo esc_url( $term_link ); ?>" class="fl-cat-footer-more" title="<?php esc_attr_e( 'View All Posts', 'buzzmag' ); ?>">
                <span><?php esc_html_e( 'සියලු පුවත් බලන්න (View All)', 'buzzmag' ); ?></span>
                <i class="fa fa-angle-double-right"></i>
            </a>
        </div>
    </div>
    <?php
}

/**
 * Render Below Sections (Politics & Featured) - Desktop only (6 posts each)
 */
function buzzmag_render_below_sections() {
    $pol_slug  = get_theme_mod( 'cat_slug_politics', get_theme_mod( 'politics_cat_slug', 'politics' ) );
    $feat_slug = get_theme_mod( 'cat_slug_featured', get_theme_mod( 'featured_cat_slug', 'featured' ) );

    $pol_title  = get_theme_mod( 'politics_cat_title', 'දේශපාලන (Politics)' );
    $feat_title = get_theme_mod( 'featured_cat_title', 'විශේෂාංග (Featured Stories)' );

    $pol_term  = buzzmag_resolve_category_term( $pol_slug, $pol_title );
    $feat_term = buzzmag_resolve_category_term( $feat_slug, $feat_title );

    $pol_link  = buzzmag_get_category_link( $pol_term, $pol_slug );
    $feat_link = buzzmag_get_category_link( $feat_term, $feat_slug );

    $pol_query  = buzzmag_query_category_posts( $pol_slug, 6, array(), $pol_title );
    $feat_query = buzzmag_query_category_posts( $feat_slug, 6, array(), $feat_title );
    ?>
    <section class="fl-below-sections fl-desktop-only">
        <!-- Politics Section -->
        <div class="fl-below-block fl-politics-block">
            <div class="fl-section-header">
                <div class="fl-header-title">
                    <a href="<?php echo esc_url( $pol_link ); ?>" class="fl-section-header-link">
                        <span class="fl-badge" style="background:#8e44ad;"><i class="fa fa-balance-scale"></i></span>
                        <h2><?php echo esc_html( $pol_title ); ?></h2>
                    </a>
                </div>
                <div class="fl-header-line"></div>
                <a href="<?php echo esc_url( $pol_link ); ?>" class="fl-section-more" title="<?php esc_attr_e( 'View All Posts', 'buzzmag' ); ?>">
                    <span><?php esc_html_e( 'තවත් (More)', 'buzzmag' ); ?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="fl-3d-grid-6">
                <?php if ( $pol_query->have_posts() ) :
                    while ( $pol_query->have_posts() ) :
                        $pol_query->the_post();
                        buzzmag_render_3d_post_card( get_the_ID(), 'card' );
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="fl-no-posts"><?php esc_html_e( 'දේශපාලන පුවත් නොමැත', 'buzzmag' ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Featured Section -->
        <div class="fl-below-block fl-featured-block">
            <div class="fl-section-header">
                <div class="fl-header-title">
                    <a href="<?php echo esc_url( $feat_link ); ?>" class="fl-section-header-link">
                        <span class="fl-badge" style="background:#d35400;"><i class="fa fa-star"></i></span>
                        <h2><?php echo esc_html( $feat_title ); ?></h2>
                    </a>
                </div>
                <div class="fl-header-line"></div>
                <a href="<?php echo esc_url( $feat_link ); ?>" class="fl-section-more" title="<?php esc_attr_e( 'View All Posts', 'buzzmag' ); ?>">
                    <span><?php esc_html_e( 'තවත් (More)', 'buzzmag' ); ?></span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div>
            <div class="fl-3d-grid-6">
                <?php if ( $feat_query->have_posts() ) :
                    while ( $feat_query->have_posts() ) :
                        $feat_query->the_post();
                        buzzmag_render_3d_post_card( get_the_ID(), 'card' );
                    endwhile;
                    wp_reset_postdata();
                else : ?>
                    <p class="fl-no-posts"><?php esc_html_e( 'විශේෂාංග පුවත් නොමැත', 'buzzmag' ); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

