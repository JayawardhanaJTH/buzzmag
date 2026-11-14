<?php
/**
 * BuzzMag Theme Functions and Definitions
 *
 * Modern 3D News & Magazine WordPress Theme with Sri Lankan News Portal Architecture.
 * Rebranded by Tiran Jayawardhana.
 *
 * @package BuzzMag
 * @author FlatLayers
 * @version 3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Constants
	define('fl_theme_name','BuzzMag');
	define('fl_theme_path', get_template_directory_uri());
    define('fl_theme_version', '3.1.0');

// Content Width
if ( ! isset( $content_width ) ) {
    $content_width = 800;
}

// Setup Theme
function buzzmag_theme_setup() {

	// Register Main menu
	register_nav_menus ( array(
        'main-menu' => esc_html__( 'Main Menu', 'buzzmag' ),
        'footer-menu' => esc_html__( 'Footer Menu', 'buzzmag' )
	) );
			
	// Feed Links
	add_theme_support( 'automatic-feed-links' );
	
	// Post Formats
	add_theme_support('post-formats', array( 'video', 'audio', 'gallery' ) );

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
    add_image_size( 'buzzmag_small', 200, 165, true );
    add_image_size( 'buzzmag_medium', 554, 346, true );
    add_image_size( 'buzzmag_masonry', 554, 0, true );
    add_image_size( 'buzzmag_large', 1140, 640, true );

    // Theme localization
    load_theme_textdomain( 'buzzmag', get_template_directory() . '/languages' );

    // Title Tag
    add_theme_support( 'title-tag' );
    // Widgets
    add_theme_support( 'widgets' );

    // Add support for editor styles.
    add_theme_support( 'editor-styles' );
    add_editor_style( 'css/editor-style.css' );
    //Google Fonts
    add_editor_style( buzzmag_google_fonts() );
    //Font Awesome
    add_editor_style( 'css/font-awesome.min.css' );

    //RTL Style editor
    if ( is_rtl() ) {
        add_editor_style( 'css/editor-style-rtl.css' );
    }

    add_theme_support( 'widgets-block-editor' );
    add_theme_support( 'customize-selective-refresh-widgets' );

    // Responsive Embeds
    add_theme_support( 'responsive-embeds' );
    // Align Wide & Full
    add_theme_support( 'align-wide' );

    // Woocommerce Support
    add_theme_support('woocommerce');

}
add_action( 'after_setup_theme', 'buzzmag_theme_setup' );

/**
 * Automatically set default timezone to Sri Lanka (Asia/Colombo / UTC+05:30)
 * if WordPress timezone setting is unconfigured on default UTC.
 */
function buzzmag_ensure_default_timezone() {
    $tz_string  = (string) get_option( 'timezone_string' );
    $gmt_offset = get_option( 'gmt_offset' );

    // If WordPress has never configured a timezone (empty string and 0 offset)
    if ( empty( $tz_string ) && ( '0' === (string) $gmt_offset || 0 === $gmt_offset || '' === (string) $gmt_offset ) ) {
        update_option( 'timezone_string', 'Asia/Colombo' );
        update_option( 'gmt_offset', '5.5' );
    }
}
add_action( 'after_setup_theme', 'buzzmag_ensure_default_timezone', 5 );

// Block Dynamic Style
function buzzmag_block_style() {
    wp_add_inline_style( 'wp-block-editor', buzzmag_customizer_output() );
}
add_action( 'enqueue_block_editor_assets', 'buzzmag_block_style' );

// Addons
function buzzmag_addons_scripts() {
    // Font Awesome
    wp_enqueue_style('font-awesome', fl_theme_path . '/css/font-awesome.min.css', array(), '4.7.0', 'all' );

    // Owl Carousel
    wp_enqueue_style('owl-carousel', fl_theme_path . '/css/owl.carousel.min.css', array(), '2.3.4', 'all' );
    
    // Fonts    
    wp_enqueue_style( 'buzzmag-google-fonts', buzzmag_google_fonts(), array(), null );
    // BuzzMag Style
	wp_enqueue_style( 'buzzmag-style', get_stylesheet_uri() );
    // 3D Components & Rebranded Layout Style
    wp_enqueue_style( 'buzzmag-3d-style', fl_theme_path . '/css/3d-components.css', array( 'buzzmag-style' ), fl_theme_version );
    // JS
    wp_enqueue_script( 'jquery-fitvids', fl_theme_path . '/js/fitvids.js', array('jquery'), '1.1', true );
    // Masonry
    wp_enqueue_script( 'masonry-script', fl_theme_path . '/js/masonry.pkgd.min.js', array('jquery'), '4.2.2', true );
    // Sticky Sidebar
    wp_enqueue_script( 'jquery-theia-sticky-sidebar', fl_theme_path . '/js/theia-sticky-sidebar.js', array('jquery'), '1.4.0', true );
    wp_enqueue_script( 'owl-carousel', fl_theme_path . '/js/owl.carousel.min.js', array('jquery'), '2.3.4', true );

    // BuzzMag Script
    $js_script_path = get_template_directory() . '/js/buzzmag.js';
    $js_script_ver  = file_exists( $js_script_path ) ? filemtime( $js_script_path ) : fl_theme_version;
    wp_enqueue_script( 'buzzmag-script', fl_theme_path . '/js/buzzmag.js', array('jquery'), $js_script_ver, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

    //Customizer output
    wp_add_inline_style( 'buzzmag-style', buzzmag_customizer_output() );

    // Register BuzzMag Script For Ajax
    global $wp_query;
    wp_localize_script( 'buzzmag-script', 'buzzmag', array(
        'ajaxurl'    => admin_url( 'admin-ajax.php' ),
        'nonce'      => wp_create_nonce( 'buzzmag_ajax_nonce' ),
        'query_vars' => json_encode( $wp_query->query ),
        'thumb_size' => buzzmag_layout_settings()['thumb_size'],
        'ajax_end'   => '<div class="fl-ajax-end">'. esc_html__('Sorry, No More Posts to Load!', 'buzzmag') .'</div>',
    ) );
}
add_action( 'wp_enqueue_scripts', 'buzzmag_addons_scripts' );

// Sidebars
function buzzmag_sidebars() {
    // Sidebar
    register_sidebar( array(
        'name'         => esc_html__( 'Sidebar', 'buzzmag' ),
        'id'           => 'buzzmag_sidebar',
        'description'  => esc_html__( 'Sidebar', 'buzzmag' ),
        'before_widget'=> '<div id="%1$s" class="fl-widget clearfix %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="fl-widget-title">',
        'after_title'  => '</h3>',
    ) );

    // Drawer
    register_sidebar( array(
        'name'         => esc_html__( 'Drawer', 'buzzmag' ),
        'id'           => 'buzzmag_drawer',
        'description'  => esc_html__( 'Drawer', 'buzzmag' ),
        'before_widget'=> '<div id="%1$s" class="fl-widget clearfix %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="fl-widget-title">',
        'after_title'  => '</h3>',
    ) );

    // Footer Widgets
    register_sidebar( array(
        'name'         => esc_html__( 'Footer Widget 1', 'buzzmag' ),
        'id'           => 'buzzmag_footer1',
        'description'  => esc_html__( 'Footer Widget 1', 'buzzmag' ),
        'before_widget'=> '<div id="%1$s" class="fl-widget clearfix %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="fl-widget-title">',
        'after_title'  => '</h3>',
    ) );

    register_sidebar( array(
        'name'         => esc_html__( 'Footer Widget 2', 'buzzmag' ),
        'id'           => 'buzzmag_footer2',
        'description'  => esc_html__( 'Footer Widget 2', 'buzzmag' ),
        'before_widget'=> '<div id="%1$s" class="fl-widget clearfix %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="fl-widget-title">',
        'after_title'  => '</h3>',
    ) );

    register_sidebar( array(
        'name'         => esc_html__( 'Footer Widget 3', 'buzzmag' ),
        'id'           => 'buzzmag_footer3',
        'description'  => esc_html__( 'Footer Widget 3', 'buzzmag' ),
        'before_widget'=> '<div id="%1$s" class="fl-widget clearfix %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="fl-widget-title">',
        'after_title'  => '</h3>',
    ) );

    // WooCommerce Sidebar
    register_sidebar( array(
        'name'         => esc_html__( 'WooCommerce Sidebar', 'buzzmag' ),
        'id'           => 'buzzmag_woocommerce_sidebar',
        'description'  => esc_html__( 'WooCommerce Sidebar', 'buzzmag' ),
        'before_widget'=> '<div id="%1$s" class="fl-widget clearfix %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="fl-widget-title">',
        'after_title'  => '</h3>',
    ) );
}
add_action( 'widgets_init', 'buzzmag_sidebars' );

// Pages support excerpt
add_action( 'init', 'buzzmag_excerpts_to_pages' );
function buzzmag_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
}


// Category Options
include_once( get_template_directory() . '/functions/category-options.php' );

// FlatLayers Customizer
include_once( get_template_directory() . '/functions/customizer.php' );

// Lead Post Meta Box & Helpers
require_once( get_template_directory() . '/functions/lead-post.php' );

// Sri Lankan Utilities (Calendar, Rahu Kalaya, Subha/Maru Dishawa, Cartoon, WhatsApp)
require_once( get_template_directory() . '/functions/sri-lankan-utilities.php' );

// Rebranded 3D News Loops & Category Cards
require_once( get_template_directory() . '/functions/news-loops.php' );

// Single Post Under-Post & Sidebar Modules
require_once( get_template_directory() . '/includes/single-post-widgets.php' );


// WooCommerce
if ( class_exists( 'WooCommerce' ) ) {
    include_once ( get_template_directory() . '/functions/woocommerce.php' );
}


// Fonts Function
function buzzmag_google_fonts() {
    $body_font = get_theme_mod('body_font', 'Roboto');
    $headings_font = get_theme_mod('headings_font', 'Montserrat');
     
    $font_families = array(
        'family='. str_replace(' ', '+', $body_font) .':ital,wght@0,400;0,700;1,400;1,700',
        'family='. str_replace(' ', '+', $headings_font) .':ital,wght@0,400;0,700;1,400;1,700'
    );

    $fonts_url = 'https://fonts.googleapis.com/css2?'. implode('&', $font_families). '&display=swap';

    return esc_url_raw($fonts_url);
}


// Post Views Counter Ajax
function buzzmag_setpostviews() {
    $postID = isset( $_POST['postID'] ) ? absint( $_POST['postID'] ) : 0;
    if ( ! $postID ) {
        wp_die();
    }

    // Check if user is not administrator, if so execute code block within
    if ( ! current_user_can( 'administrator' ) ) {
        $user_ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '127.0.0.1';
        $key     = 'pv_' . md5( $user_ip . 'x' . $postID );
        $visited = get_transient( $key );

        if ( false === $visited ) {
            // Store unique key for 60 seconds
            set_transient( $key, 1, 60 );

            $count_key = 'post_views_count';
            $count     = get_post_meta( $postID, $count_key, true );
            if ( '' === $count ) {
                $count = 1;
                add_post_meta( $postID, $count_key, '1' );
            } else {
                $count = (int) $count + 1;
                update_post_meta( $postID, $count_key, $count );
            }
        }
    }
    wp_die();
}
add_action( 'wp_ajax_buzzmag_setpostviews', 'buzzmag_setpostviews' );
add_action( 'wp_ajax_nopriv_buzzmag_setpostviews', 'buzzmag_setpostviews' );

function buzzmag_getpostviews( $postID ) {
    $postID = absint( $postID );
    if ( ! $postID ) {
        return '';
    }

    $count_key = 'post_views_count';
    $count     = get_post_meta( $postID, $count_key, true );
    if ( '' === $count || empty( $count ) ) {
        return '';
    }

    $count = (int) $count;
    if ( $count >= 1000000 ) {
        return round( ( $count / 1000000 ), 1 ) . esc_html__( ' M', 'buzzmag' );
    } elseif ( $count >= 1000 ) {
        return round( ( $count / 1000 ), 1 ) . esc_html__( ' K', 'buzzmag' );
    } else {
        return number_format_i18n( $count );
    }
}

// Menus
require_once ( get_template_directory() . '/functions/mega-menu.php');

// Loops & Pagination & Ajax
require_once ( get_template_directory() . '/functions/loops.php');

// Layout Settings -> used in all Archive pages
function buzzmag_layout_settings() {

    $templates = array (
        'templates/loop-latest.php',
        'templates/loop-trending.php',
        'templates/loop-audio.php',
        'templates/loop-video.php',
        'templates/loop-gallery.php',
    );

    if ( is_home() || is_page_template($templates) ) {
        $layout = get_theme_mod('home_layout', 'grid_sidebar'); 
    } elseif ( is_category() ) {
        $term = get_queried_object();
        $layout = get_term_meta($term->term_id, 'buzzmag_cat_layout', true);
        if ( $layout == 'default' || empty($layout) ) {
            $layout = get_theme_mod('category_layout', 'grid_sidebar');
        }
    } elseif ( is_author() ) {
        $layout = get_theme_mod('author_layout', 'grid_sidebar');
    } elseif ( is_search() ) {
        $layout = get_theme_mod('search_layout', 'grid_sidebar');
    } else {
        $layout = get_theme_mod('archive_layout', 'grid_sidebar');
    }

    switch ($layout) {
        case 'grid':
            $sidebar = false;
            $width_class = 'fl-full-width';
            $loop_class = 'fl-grid';
            $thumb_size = 'buzzmag_medium';
            break;

        case 'grid_sidebar':
            $sidebar = true;
            $width_class = '';
            $loop_class = 'fl-grid';
            $thumb_size = 'buzzmag_medium';
            break;

         case 'grid_col_3':
            $sidebar = false;
            $width_class = 'fl-full-width';
            $loop_class = 'fl-grid col-3';
            $thumb_size = 'buzzmag_medium';
            break;

        case 'list':
            $sidebar = false;
            $width_class = 'fl-full-width';
            $loop_class = 'fl-list';
            $thumb_size = 'buzzmag_medium';
            break;

        case 'list_sidebar':
            $sidebar = true;
            $width_class = '';
            $loop_class = 'fl-list';
            $thumb_size = 'buzzmag_medium';
            break;

        case 'masonry':
            $sidebar = false;
            $width_class = 'fl-full-width';
            $loop_class = 'fl-grid fl-masonry';
            $thumb_size = 'buzzmag_masonry';
            break;

        case 'masonry_sidebar':
            $sidebar = true;
            $width_class = '';
            $loop_class = 'fl-grid fl-masonry';
            $thumb_size = 'buzzmag_masonry';
            break;

        case 'masonry_col_3':
            $sidebar = false;
            $width_class = 'fl-full-width';
            $loop_class = 'fl-grid col-3 fl-masonry';
            $thumb_size = 'buzzmag_masonry';
            break;

        case 'standard':
            $sidebar = false;
            $width_class = 'fl-full-width';
            $loop_class = 'fl-standard';
            $thumb_size = 'buzzmag_large';
            break;

        case 'standard_sidebar':
            $sidebar = true;
            $width_class = '';
            $loop_class = 'fl-standard';
            $thumb_size = 'buzzmag_large';
            break;
    }

    return array(
        'sidebar'     => $sidebar,
        'width_class' => $width_class,
        'loop_class'  => $loop_class,
        'thumb_size'  => $thumb_size,
    );
}

// Color Mode
function buzzmag_color_mode() {
    // Theme Mode in Javascript
    if ( !get_theme_mod( 'dark_mode' ) ) {
        if ( get_theme_mod( 'dark_mode_default' ) ) { ?>
            <script type="text/javascript">
                if ( document.cookie.indexOf('buzzmag_color_theme=light') === -1 ) {
                    document.cookie = 'buzzmag_color_theme=dark; path=/; SameSite=None; Secure';
                }
            </script>
        <?php } ?>
        <script type="text/javascript">
            if ( document.cookie.indexOf('buzzmag_color_theme=dark') > -1 ) {
                document.documentElement.setAttribute('data-theme', 'dark');
                document.addEventListener("DOMContentLoaded", function() {
                    document.getElementById('fl-darkmode').checked = true;
                });
            }
        </script>
        <?php
    }
}
add_action('wp_head', 'buzzmag_color_mode');

// TGM Class
require_once ( get_template_directory() . '/functions/class-tgm-plugin-activation.php');

// Required Plugins
function buzzmag_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        array(
            'name'                  => esc_html__( 'BuzzMag Theme Addons', 'buzzmag' ), // The plugin name
            'slug'                  => 'flatlayers-buzzmag-addons', // The plugin slug (typically the folder name)
            'source'                => get_template_directory() . '/functions/flatlayers-buzzmag-addons.zip', // The plugin source
            'required'              => true, // If false, the plugin is only 'recommended' instead of required
            'version'               => '1.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
            'force_activation'      => true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
            'force_deactivation'    => true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
            'external_url'          => '', // If set, overrides default API URL and points to an external URL
        ),

    );

    /*
     * Array of configuration settings. Amend each line as needed.
     *
     * TGMPA will start providing localized text strings soon. If you already have translations of our standard
     * strings available, please help us make TGMPA even better by giving us access to these translations or by
     * sending in a pull-request with .po file(s) with the translations.
     *
     * Only uncomment the strings in the config array if you want to customize the strings.
     */
    $config = array(
        'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to bundled plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'parent_slug'  => 'themes.php',            // Parent menu slug.
        'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
    );

    tgmpa( $plugins, $config );
}

add_action( 'tgmpa_register', 'buzzmag_required_plugins' );