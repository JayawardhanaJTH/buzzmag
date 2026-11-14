<?php
/**
 * Lead Post Meta Box and Helper Functions
 *
 * Allows marking a post as "Lead Post" on the post edit screen
 * and retrieving the current active lead post.
 *
 * @package BuzzMag
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Lead Post Meta Box
 */
function buzzmag_add_lead_post_meta_box() {
    add_meta_box(
        'buzzmag_lead_post_box',
        esc_html__( 'Lead Post Option', 'buzzmag' ),
        'buzzmag_render_lead_post_meta_box',
        'post',
        'side',
        'high'
    );
}
add_action( 'add_meta_boxes', 'buzzmag_add_lead_post_meta_box' );

/**
 * Render Lead Post Meta Box Content
 *
 * @param WP_Post $post Current post object.
 */
function buzzmag_render_lead_post_meta_box( $post ) {
    wp_nonce_field( 'buzzmag_save_lead_post_nonce', 'buzzmag_lead_post_nonce' );
    $is_lead = get_post_meta( $post->ID, '_buzzmag_is_lead_post', true );
    ?>
    <p>
        <label for="buzzmag_is_lead_post" style="display:flex; align-items:center; gap:8px; font-weight:600; cursor:pointer;">
            <input type="checkbox" name="buzzmag_is_lead_post" id="buzzmag_is_lead_post" value="1" <?php checked( $is_lead, '1' ); ?> />
            <span><?php esc_html_e( 'Mark as Lead Post', 'buzzmag' ); ?></span>
        </label>
    </p>
    <p class="description" style="font-size:12px; color:#666; margin-top:4px;">
        <?php esc_html_e( 'When checked, this post becomes the main hero lead story on Desktop and Mobile homepages.', 'buzzmag' ); ?>
    </p>
    <?php
}

/**
 * Save Lead Post Meta Box Value
 *
 * @param int $post_id Post ID.
 */
function buzzmag_save_lead_post_meta_box( $post_id ) {
    if ( ! isset( $_POST['buzzmag_lead_post_nonce'] ) ) {
        return;
    }
    if ( ! wp_verify_nonce( $_POST['buzzmag_lead_post_nonce'], 'buzzmag_save_lead_post_nonce' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( isset( $_POST['buzzmag_is_lead_post'] ) && '1' === $_POST['buzzmag_is_lead_post'] ) {
        update_post_meta( $post_id, '_buzzmag_is_lead_post', '1' );
    } else {
        delete_post_meta( $post_id, '_buzzmag_is_lead_post' );
    }
}
add_action( 'save_post', 'buzzmag_save_lead_post_meta_box' );

/**
 * Get the current Lead Post.
 *
 * Searches for the newest post with `_buzzmag_is_lead_post = '1'`.
 * If none found, gracefully falls back to the most recent published post.
 *
 * @return WP_Post|null Post object or null if no posts exist.
 */
function buzzmag_get_lead_post() {
    $lead_query = new WP_Query( array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 1,
        'ignore_sticky_posts' => 1,
        'meta_query'          => array(
            array(
                'key'     => '_buzzmag_is_lead_post',
                'value'   => '1',
                'compare' => '=',
            ),
        ),
    ) );

    if ( $lead_query->have_posts() ) {
        $post = $lead_query->posts[0];
        wp_reset_postdata();
        return $post;
    }

    // Fallback: most recent published post
    $fallback_query = new WP_Query( array(
        'post_type'           => 'post',
        'post_status'         => 'publish',
        'posts_per_page'      => 1,
        'ignore_sticky_posts' => 1,
    ) );

    if ( $fallback_query->have_posts() ) {
        $post = $fallback_query->posts[0];
        wp_reset_postdata();
        return $post;
    }

    return null;
}

