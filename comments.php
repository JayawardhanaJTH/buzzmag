<?php if ( !comments_open() ) {

    if ( have_comments() ) { ?>
        <a href="#" class="fl-comments-toggle">
            <i class="fa fa-comment"></i>
            <?php comments_number(esc_html__('No Comments', 'buzzmag'), esc_html__('1 Comment', 'buzzmag'), esc_html__( '% Comments', 'buzzmag') ); ?>                
        </a>

        <div id="comments" class="fl-comments">
            <h3 class="fl-widget-title">
                <?php comments_number(esc_html__('No Comments', 'buzzmag'), esc_html__('1 Comment', 'buzzmag'), esc_html__( '% Comments', 'buzzmag') ); ?>
            </h3>

            <ol class="fl-comment-list">
                <?php
                wp_list_comments(
                    array(
                        'avatar_size' => 60,
                        'style'       => 'ol',
                        'short_ping'  => true,
                    )
                );
                ?>
            </ol>

            <?php the_comments_pagination(); ?>

            <p class="fl-no-comments"><?php esc_html_e( 'Comments are closed.', 'buzzmag' ); ?></p>

        </div>
        
    <?php }

} else { ?>

    <a href="#" class="fl-comments-toggle">
        <i class="fa fa-comment"></i>
        <?php comments_number(esc_html__('Leave a Reply', 'buzzmag'), esc_html__('1 Comment', 'buzzmag'), esc_html__( '% Comments', 'buzzmag') ); ?>
    </a>

    <div id="comments" class="fl-comments">
        <?php if ( have_comments() ) { ?>
            <h3 class="fl-widget-title">
                <?php comments_number(esc_html__('No Comments', 'buzzmag'), esc_html__('1 Comment', 'buzzmag'), esc_html__( '% Comments', 'buzzmag') ); ?>
            </h3>
            <ol class="fl-comment-list">
                <?php
                wp_list_comments(
                    array(
                        'avatar_size' => 60,
                        'style'       => 'ol',
                        'short_ping'  => true,
                    )
                );
                ?>
            </ol>

        <?php }

        the_comments_pagination();

        comment_form(
            array(
                'logged_in_as'       => null,
                'title_reply'        => esc_html__( 'Leave a Reply', 'buzzmag' ),
                'title_reply_before' => '<h4 id="fl-reply-title">',
                'title_reply_after'  => '</h4>',
            )
        ); ?>

    </div>

<?php } ?>