 <?php if ( !get_theme_mod('hide_trending') || !get_theme_mod('hide_audio') || !get_theme_mod('hide_video') || !get_theme_mod('hide_gallery') ) { ?>
    <div class="fl-loop-tabs clearfix">
        <a href="#fl-latest-posts" class="active">
            <i class="fa fa-clock-o"></i><?php echo esc_html_e( 'Latest', 'buzzmag' ); ?>
        </a>
        <?php if ( !get_theme_mod('hide_trending') ) { ?>
            <a href="#fl-trending-posts" tab-loop="trending">
                <i class="fa fa-bolt"></i><?php echo esc_html_e( 'Trending', 'buzzmag' ); ?>
            </a>
        <?php }
        if ( !get_theme_mod('hide_audio') ) { ?>        
            <a href="#fl-audio-posts" tab-loop="audio">
                <i class="fa fa-music"></i><?php echo esc_html_e( 'Audios', 'buzzmag' ); ?>
            </a>
        <?php } 
        if ( !get_theme_mod('hide_video') ) { ?>        
            <a href="#fl-video-posts" tab-loop="video">
                <i class="fa fa-play"></i><?php echo esc_html_e( 'Videos', 'buzzmag' ); ?>
            </a>
        <?php }
        if ( !get_theme_mod('hide_gallery') ) { ?>
            <a href="#fl-gallery-posts" tab-loop="gallery">
                <i class="fa fa-camera"></i><?php echo esc_html_e( 'Galleries', 'buzzmag' ); ?>
            </a>
        <?php } ?>
    </div>
<?php } ?>