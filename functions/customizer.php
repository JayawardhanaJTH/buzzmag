<?php

/*	
*	BuzzMag Customizer
*	---------------------
*/


function buzzmag_customizer( $wp_customize ) {
// Settings, Sections, and Controls are defined here

	$layouts = array(
    	'grid'             => esc_html__('Grid 2 Columns', 'buzzmag'),
    	'grid_sidebar'     => esc_html__('Grid 2 Columns & Sidebar', 'buzzmag'),
    	'grid_col_3'       => esc_html__('Grid 3 Columns', 'buzzmag'),
    	'list'             => esc_html__('List Full Width', 'buzzmag'), 
    	'list_sidebar'     => esc_html__('List & Sidebar', 'buzzmag'),  
    	'masonry'          => esc_html__('Masonry 2 Columns', 'buzzmag'),  	
    	'masonry_sidebar'  => esc_html__('Masonry 2 Columns & Sidebar', 'buzzmag'),
    	'masonry_col_3'    => esc_html__('Masonry 3 Columns', 'buzzmag'),
    	'standard'         => esc_html__('Standard', 'buzzmag'),
    	'standard_sidebar' => esc_html__('Standard & Sidebar', 'buzzmag')
    );

    $featured = array(
    	'none'   => esc_html__( 'No Featured Posts', 'buzzmag' ),
    	'1post'  => esc_html__( '1 Post', 'buzzmag' ),
    	'4posts' => esc_html__( '4 Posts', 'buzzmag' ),
    	'5posts' => esc_html__( '5 Posts', 'buzzmag' ),
    	'6posts' => esc_html__( '6 Posts', 'buzzmag' ),
    );

	// General Settings Section
	$wp_customize->add_section( 'general_settings' , array(
	    'title'       => esc_html__( 'General Settings', 'buzzmag' ),
	    'priority'    => 30,
	) );

		// Sidebar Position
		$wp_customize->add_setting( 'sidebar_position', array(
	        'default'  => 'right',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'sidebar_position', array(
	    	'type'     => 'select',
	        'label'    => esc_html__( 'Sidebar Position', 'buzzmag' ),
	        'section'  => 'general_settings',
	        'priority' => 1,
	        'choices'  => array(
	        	'right' => 'Right',
	        	'left' => 'Left',
		        ),
        ) );

        // Disable Sticky Sidebar
		$wp_customize->add_setting( 'disable_sticky_sidebar', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'disable_sticky_sidebar', array(
			'label'    => esc_html__( 'Disable Smart Sticky Sidebar Option', 'buzzmag' ),
			'section'  => 'general_settings',
			'type'     => 'checkbox',
			'priority' => 2,
		) );

        // Hide Sidebar in Posts
		$wp_customize->add_setting( 'hide_sidebar_post', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_sidebar_post', array(
			'label'    => esc_html__( 'Hide Sidebar in Posts', 'buzzmag' ),
			'section'  => 'general_settings',
			'type'     => 'checkbox',
			'priority' => 3,
		) );

		// Hide Sidebar in Pages
		$wp_customize->add_setting( 'hide_sidebar_page', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_sidebar_page', array(
			'label'    => esc_html__( 'Hide Sidebar in Pages', 'buzzmag' ),
			'section'  => 'general_settings',
			'type'     => 'checkbox',
			'priority' => 4,
		) );

		// Activate Infinite Scroll
		$wp_customize->add_setting( 'infinite_scroll', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'infinite_scroll', array(
			'label'    => esc_html__( 'Activate Infinite Scroll', 'buzzmag' ),
			'section'  => 'general_settings',
			'type'     => 'checkbox',
			'priority' => 5,
		) );

		// Tranding Posts Date
        $wp_customize->add_setting( 'trending_date', array(
	        'default'  => '30',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'trending_date', array(
	    	'type'     => 'number',
	        'label'    => esc_html__( 'Display trending posts for last:', 'buzzmag' ),
	        'description' => esc_html__( 'Value must be in days. Ex: Most viewed posts published in last 30 days.', 'buzzmag' ),
	        'section'  => 'general_settings',
	        'priority' => 6,
	        'input_attrs' => array(
	            'min' => '1', 'step' => '1', 'max' => '10000',
			),
        ) );

        // Category Archive layout
		$wp_customize->add_setting( 'category_layout', array(
			'default'           => 'grid_sidebar',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'category_layout', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Categories Archive Layout', 'buzzmag' ),
			'section'  => 'general_settings',			
			'priority' => 7,
			'choices'  => $layouts,
        ) );


        // Author layout
		$wp_customize->add_setting( 'author_layout', array(
			'default'           => 'grid_sidebar',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'author_layout', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Author Archive Layout', 'buzzmag' ),
			'section'  => 'general_settings',
			'priority' => 8,
			'choices'  => $layouts,
        ) );


        // Search layout
		$wp_customize->add_setting( 'search_layout', array(
			'default'           => 'grid_sidebar',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'search_layout', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Search Results Layout', 'buzzmag' ),
			'section'  => 'general_settings',
			'priority' => 9,
			'choices'  => $layouts,
        ) );

        // Other Archive layout
		$wp_customize->add_setting( 'archive_layout', array(
			'default'           => 'grid_sidebar',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'archive_layout', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Tags & Other Archives Layout', 'buzzmag' ),
			'section'  => 'general_settings',
			'priority' => 10,
			'choices'  => $layouts,
        ) );


		// WooCommerce
        if ( class_exists( 'WooCommerce' ) ) {

	        // WooCommerce Shop Layout
			$wp_customize->add_setting( 'shop_layout', array(
				'default'           => 'grid_sidebar',
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'shop_layout', array(
				'type'     => 'select',
				'label'    => esc_html__( 'WooCommerce Shop & Archives Layout', 'buzzmag' ),
				'section'  => 'general_settings',
				'priority' => 11,
				'choices'  => array(
					'grid_sidebar' => esc_html__( 'Grid 3 Columns & Sidebar', 'buzzmag' ),
					'grid' => esc_html__( 'Grid 4 Columns', 'buzzmag' ),
				),
	        ) );

	        // Hide Sidebar in Product
			$wp_customize->add_setting( 'hide_sidebar_product', array(
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'hide_sidebar_product', array(
				'label'    => esc_html__( 'Hide Sidebar in Product Page', 'buzzmag' ),
				'section'  => 'general_settings',
				'type'     => 'checkbox',
				'priority' => 12,
			) );

		}

//.............................. End General Settings Section

// Header Settings Section
	$wp_customize->add_section( 'header_settings' , array(
	    'title'       => esc_html__( 'Header Settings', 'buzzmag' ),
	    'priority'    => 35,
	) );

		// Logo
		$wp_customize->add_setting( 'logo', array(
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
		    'label'    => esc_html__( 'Logo', 'buzzmag' ),
		    'description' => esc_html__( 'Add logo to display logo and dark mode logo.', 'buzzmag' ),
		    'section'  => 'header_settings',
		    'priority' => 1,
		) ) );

		// Logo Dark Mode
		$wp_customize->add_setting( 'logo_dark', array(
			'sanitize_callback' => 'esc_url_raw',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo_dark', array(
		    'label'    => esc_html__( 'Dark Mode Logo', 'buzzmag' ),
		    'section'  => 'header_settings',
		    'priority' => 2,
		) ) );

		// Disable Dark Mode
		$wp_customize->add_setting( 'dark_mode', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'dark_mode', array(
			'label'    => esc_html__( 'Disable Dark Mode', 'buzzmag' ),
			'section'  => 'header_settings',
			'type'     => 'checkbox',
			'priority' => 3,
		) );

		// Set Dark Mode As default Mode
		$wp_customize->add_setting( 'dark_mode_default', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'dark_mode_default', array(
			'label'    => esc_html__( 'Set Dark Mode As Default Mode', 'buzzmag' ),
			'section'  => 'header_settings',
			'type'     => 'checkbox',
			'priority' => 4,
		) );

		// Disable Fixed header
		$wp_customize->add_setting( 'fixed_header', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'fixed_header', array(
			'label'    => esc_html__( 'Disable Fixed Header', 'buzzmag' ),
			'section'  => 'header_settings',
			'type'     => 'checkbox',
			'priority' => 5,
		) );

		// Hide Social Icons
		$wp_customize->add_setting( 'header_drawer', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'header_drawer', array(
			'label'    => esc_html__( 'Hide Drawer on Desktop', 'buzzmag' ),
			'section'  => 'header_settings',
			'type'     => 'checkbox',
			'priority' => 6,
		) );

		// Hide Social Icons
		$wp_customize->add_setting( 'header_social', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'header_social', array(
			'label'    => esc_html__( 'Hide Social Icons', 'buzzmag' ),
			'section'  => 'header_settings',
			'type'     => 'checkbox',
			'priority' => 7,
		) );

		// Hide Search
		$wp_customize->add_setting( 'header_search', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'header_search', array(
			'label'    => esc_html__( 'Hide Search', 'buzzmag' ),
			'section'  => 'header_settings',
			'type'     => 'checkbox',
			'priority' => 8,
		) );

		// WooCommerce
        if ( class_exists( 'WooCommerce' ) ) {
        	// Hide Cart Icon
			$wp_customize->add_setting( 'header_cart', array(
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'header_cart', array(
				'label'    => esc_html__( 'Hide WooCommerce Cart Icon', 'buzzmag' ),
				'section'  => 'header_settings',
				'type'     => 'checkbox',
				'priority' => 9,
			) );

			// Hide Account Icon
			$wp_customize->add_setting( 'header_account', array(
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'header_account', array(
				'label'    => esc_html__( 'Hide WooCommerce Account Icon', 'buzzmag' ),
				'section'  => 'header_settings',
				'type'     => 'checkbox',
				'priority' => 10,
			) );
        }


//.............................. End Header Settings Section


// Home Settings Section
	$wp_customize->add_section( 'home_settings' , array(
	    'title'       => esc_html__( 'Home Settings', 'buzzmag' ),
	    'priority'    => 40,
	) );

		// Home layout
		$wp_customize->add_setting( 'home_layout', array(
			'default'           => 'grid_sidebar',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'home_layout', array(
			'type'     => 'select',
			'label'    => esc_html__( 'Home Layout', 'buzzmag' ),
			'section'  => 'home_settings',			
			'priority' => 1,
			'choices'  => $layouts,
        ) );

		// Featured Posts Layout
		$wp_customize->add_setting( 'featured_style', array(
			'default'           => '6posts',
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'featured_style', array(			
			'type'     => 'select',
			'label'    => esc_html__( 'Featured Posts Layout', 'buzzmag' ),
			'section'  => 'home_settings',
			'priority' => 2,
			'choices'  => $featured,
		) );

		// Featured Categories Slugs
		$wp_customize->add_setting( 'featured_cats', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'featured_cats', array(
			'label'       => esc_html__( 'Featured Categories Slugs', 'buzzmag' ),
			'description' => esc_html__( 'Split category slugs by ",". Example: cats,dogs,horses...etc.', 'buzzmag' ),
			'section'     => 'home_settings',
			'type'        => 'text',
			'priority'    => 4,
		) );

		// Hide Trending Posts
		$wp_customize->add_setting( 'hide_trending', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_trending', array(
			'label'    => esc_html__( 'Hide Trending Posts', 'buzzmag' ),
			'description' => esc_html__( 'Hide trending tab and posts from home.', 'buzzmag' ),
			'section'  => 'home_settings',
			'type'     => 'checkbox',
			'priority' => 5,
		) );

		// Hide Audio Posts
		$wp_customize->add_setting( 'hide_audio', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_audio', array(
			'label'    => esc_html__( 'Hide Audios Posts', 'buzzmag' ),
			'description' => esc_html__( 'Hide Audios tab and posts from homepage.', 'buzzmag' ),
			'section'  => 'home_settings',
			'type'     => 'checkbox',
			'priority' => 6,
		) );

		// Hide Video Posts
		$wp_customize->add_setting( 'hide_video', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_video', array(
			'label'    => esc_html__( 'Hide Videos Posts', 'buzzmag' ),
			'description' => esc_html__( 'Hide Videos tab and posts from homepage.', 'buzzmag' ),
			'section'  => 'home_settings',
			'type'     => 'checkbox',
			'priority' => 7,
		) );

		// Hide Gallery Posts
		$wp_customize->add_setting( 'hide_gallery', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_gallery', array(
			'label'    => esc_html__( 'Hide Galleries Posts', 'buzzmag' ),
			'description' => esc_html__( 'Hide Galleries tab and posts from homepage.', 'buzzmag' ),
			'section'  => 'home_settings',
			'type'     => 'checkbox',
			'priority' => 8,
		) );

		// Disable Smart sticky tabs
		$wp_customize->add_setting( 'sticky_tabs', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'sticky_tabs', array(
			'label'    => esc_html__( 'Disable Smart Sticky Tabs', 'buzzmag' ),
			'section'  => 'home_settings',
			'type'     => 'checkbox',
			'priority' => 9,
		) );

		// Home Ad
		$wp_customize->add_setting( 'home_ad', array(
			'default'   => '<a href="#" target="_blank"><img src="' . fl_theme_path . '/img/ad.jpg"></a>',
			'sanitize_callback' => 'buzzmag_textarea_sanitize',
		) );

		$wp_customize->add_control( 'home_ad', array(
			'label'     => esc_html__( 'Homepage Ad', 'buzzmag' ),
			'description' => esc_html__( 'Ad display after featured posts in homepage. Keep it empty if you want to hide it.', 'buzzmag' ),
			'section'   => 'home_settings',
			'type'      => 'textarea',
			'priority'  => 10,
		) );

// .............................. End Home Section


// Post Settings Section
	$wp_customize->add_section( 'post_settings' , array(
	    'title'       => esc_html__( 'Post Settings', 'buzzmag' ),
	    'priority'    => 45,
	) );

		// Related Posts Type
		$wp_customize->add_setting( 'related_type', array(
	        'default'  => 'tags',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

		$wp_customize->add_control( 'related_type', array(
	    	'type'     => 'select',
	        'label'    => esc_html__( 'Related Posts Type', 'buzzmag' ),
	        'section'  => 'post_settings',
	        'priority' => 1,
	        'choices'  => array(
	        	'tags' => esc_html__( 'Based On Tags', 'buzzmag' ),
	        	'category' => esc_html__( 'From Same Category', 'buzzmag' ),
	        ),
        ) );

        // Editor Picks Categories Slugs
		$wp_customize->add_setting( 'editor_cats', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'editor_cats', array(
			'label'       => esc_html__( 'Editor Picks Categories Slugs', 'buzzmag' ),
			'description' => esc_html__( 'Split category slugs by ",". Example: cats,dogs,horses...etc.', 'buzzmag' ),
			'section'     => 'post_settings',
			'type'        => 'text',
			'priority'    => 2,
		) );

		// Hide Author Section
		$wp_customize->add_setting( 'hide_author_box', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_author_box', array(
			'label'    => 'Hide Author Section',
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 3,
		));

		// Hide Related Posts
		$wp_customize->add_setting( 'hide_related_box', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_related_box', array(
			'label'    => esc_html__( 'Hide Related Posts', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 4,
		));

		// Hide Editor Picks
		$wp_customize->add_setting( 'hide_editorpicks_box', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_editorpicks_box', array(
			'label'    => esc_html__( 'Hide Editor Picks Section', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 5,
		) );

		// Hide Author
		$wp_customize->add_setting( 'hide_meta_author', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_meta_author', array(
			'label'    => esc_html__( 'Hide Author Meta', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 6,
		));

		// Hide Date
		$wp_customize->add_setting( 'hide_meta_date', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_meta_date', array(
			'label'    => esc_html__( 'Hide Date Meta', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 7,
		));

		// Hide Meta Views
		$wp_customize->add_setting( 'hide_meta_views', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_meta_views', array(
			'label'    => esc_html__( 'Hide Views Meta', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 8,
		) );

		// Hide Tags
		$wp_customize->add_setting( 'hide_meta_tags', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_meta_tags', array(
			'label'    => esc_html__( 'Hide Tags Meta', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 9,
		));

		// Hide Comments
		$wp_customize->add_setting( 'hide_meta_comments', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_meta_comments', array(
			'label'    => esc_html__( 'Hide Comments Meta', 'buzzmag' ),
			'section'  => 'post_settings',
			'type'     => 'checkbox',
			'priority' => 10,
		));

		// Post Ad
		$wp_customize->add_setting( 'post_ad', array(
			'default'   => '<a href="#" target="_blank"><img src="' . fl_theme_path . '/img/ad.jpg"></a>',
			'sanitize_callback' => 'buzzmag_textarea_sanitize',
		) );

		$wp_customize->add_control( 'post_ad', array(
			'label'     => esc_html__( 'Post Ad', 'buzzmag' ),
			'description' => esc_html__( 'Ad display after article in all posts. Keep it empty if you want to hide it.', 'buzzmag' ),
			'section'   => 'post_settings',
			'type'      => 'textarea',
			'priority'  => 11,
		) );
		
//.............................. End Post Settings Section

// Footer Settings Section
	$wp_customize->add_section( 'footer_settings' , array(
    'title'       => esc_html__( 'Footer Settings', 'buzzmag' ),
    'priority'    => 50,
	) );

		// Hide Footer Widgets
		$wp_customize->add_setting( 'hide_footer_widgets', array(
			'sanitize_callback' => 'sanitize_text_field',
		) );

		$wp_customize->add_control( 'hide_footer_widgets', array(
			'label'    => esc_html__( 'Hide Footer Widgets', 'buzzmag' ),
			'section'  => 'footer_settings',
			'type'     => 'checkbox',
			'priority' => 1,
		));

		// Copyrights
		$wp_customize->add_setting( 'copyrights', array(
			'default'   => esc_html('© ') . esc_html( date('Y') ) . ' ' . esc_html( get_bloginfo( 'name', 'display' ) ) . '. ' . esc_html__( 'සියලුම හිමිකම් ඇවිරිණි (All Rights Reserved).', 'buzzmag' ),
			'sanitize_callback' => 'buzzmag_textarea_sanitize',
		) );

		$wp_customize->add_control( 'copyrights', array(
			'label'     => esc_html__( 'Copyrights', 'buzzmag' ),
			'section'   => 'footer_settings',
			'type'      => 'textarea',
			'priority'  => 2,
		) );

		// Footer Ad
		$wp_customize->add_setting( 'footer_ad', array(
			'default'   => '<a href="#" target="_blank"><img src="' . fl_theme_path . '/img/ad.jpg"></a>',
			'sanitize_callback' => 'buzzmag_textarea_sanitize',
		) );

		$wp_customize->add_control( 'footer_ad', array(
			'label'     => esc_html__( 'Footer Ad', 'buzzmag' ),
			'description' => esc_html__( 'Ad display before footer in all pages. Keep it empty if you want to hide it.', 'buzzmag' ),
			'section'   => 'footer_settings',
			'type'      => 'textarea',
			'priority'  => 3,
		) );

//.............................. End Footer Settings Section


	// Colors: General
	$wp_customize->add_section( 'colors_general' , array(
	    'title'       => esc_html__( 'Colors: General', 'buzzmag' ),
	    'priority'    => 55,
	) );

		// Accent Color
		$wp_customize->add_setting( 'accent_color', array(
			'default'  => '#ed0e28',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'accent_color', array(
			'label'    => esc_html__( 'Accent Color', 'buzzmag' ),
			'section'  => 'colors_general',
			'priority' => 1,
		) ) );

		// Body Background Color
		$wp_customize->add_setting( 'body_bg', array(
			'default'  => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'body_bg', array(
			'label'    => esc_html__( 'Body Background Color', 'buzzmag' ),
			'section'  => 'colors_general',
			'priority' => 2,
		) ) );

		// Content Text Color
		$wp_customize->add_setting( 'content_color', array(
			'default' => '#444444',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'content_color', array(
			'label'    => esc_html__( 'Content Text Color', 'buzzmag' ),
			'section'  => 'colors_general',
			'priority' => 3,
		) ) );


		// Headings Text Color
		$wp_customize->add_setting( 'headings_color', array(
			'default' => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'headings_color', array(
			'label'    => esc_html__( 'Headings Text Color', 'buzzmag' ),
			'section'  => 'colors_general',
			'priority' => 4,
		) ) );


		// Meta Text Color
		$wp_customize->add_setting( 'meta_color', array(
			'default' => '#777777',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'meta_color', array(
			'label'    => esc_html__( 'Meta Text Color', 'buzzmag' ),
			'section'  => 'colors_general',
			'priority' => 5,
		) ) );


		// Buttons Background Color
		$wp_customize->add_setting( 'buttons_bg', array(
			'default' => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'buttons_bg', array(
			'label'    => esc_html__( 'Buttons Background Color', 'buzzmag' ),
			'section'  => 'colors_general',
			'priority' => 6,
		) ) );

//.............................. End Colors: General Section


	// Colors: Header
	$wp_customize->add_section( 'colors_header' , array(
	    'title'       => esc_html__( 'Colors: Header', 'buzzmag' ),
	    'priority'    => 60,
	) );

		// Header Background Color
		$wp_customize->add_setting( 'header_bg', array(
			'default'   => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_bg', array(
			'label'    => esc_html__( 'Header Background Color', 'buzzmag' ),
			'section'  => 'colors_header',
			'priority' => 1,
		) ) );

		// Header Text Color
		$wp_customize->add_setting( 'header_color', array(
			'default'   => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'header_color', array(
			'label'    => esc_html__( 'Header Text Color', 'buzzmag' ),
			'section'  => 'colors_header',
			'priority' => 2,
		) ) );

		// Submenu & Drawer Background Color
		$wp_customize->add_setting( 'submenu_bg', array(
			'default'   => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_bg', array(
			'label'    => esc_html__( 'Submenu & Drawer Background', 'buzzmag' ),
			'section'  => 'colors_header',
			'priority' => 3,
		) ) );

		// Submenu & Drawer Text Color
		$wp_customize->add_setting( 'submenu_color', array(
			'default'   => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'submenu_color', array(
			'label'    => esc_html__( 'Submenu & Drawer Text Color', 'buzzmag' ),
			'section'  => 'colors_header',
			'priority' => 4,
		) ) );

//.............................. End Colors: Header

	// Colors: Footer
	$wp_customize->add_section( 'colors_footer' , array(
	    'title'       => esc_html__( 'Colors: Footer', 'buzzmag' ),
	    'priority'    => 65,
	) );

		// Footer Background Color
		$wp_customize->add_setting( 'footer_bg', array(
			'default'   => '#111111',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bg', array(
			'label'    => esc_html__( 'Footer Background Color', 'buzzmag' ),
			'section'  => 'colors_footer',
			'priority' => 1,
		) ) );


		// Footer Text Color
		$wp_customize->add_setting( 'footer_color', array(
			'default'   => '#777777',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_color', array(
			'label'    => esc_html__( 'Footer Text Color', 'buzzmag' ),
			'section'  => 'colors_footer',
			'priority' => 2,
		) ) );


		// Footer Headings Text Color
		$wp_customize->add_setting( 'footer_headings_color', array(
			'default'   => '#ffffff',
			'sanitize_callback' => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_headings_color', array(
			'label'    => esc_html__( 'Footer Headings Text Color', 'buzzmag' ),
			'section'  => 'colors_footer',
			'priority' => 3,
		) ) );

//.............................. End Colors: Footer

	// Typography Section
	$wp_customize->add_section( 'typography' , array(
	    'title'       => esc_html__( 'Typography', 'buzzmag' ),
	    'priority'    => 70,
	) );

        // Headings Font Family
        $wp_customize->add_setting( 'headings_font', array(
	        'default'  => 'Montserrat',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'headings_font', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Headings Font Family', 'buzzmag' ),
	        'description' => esc_html__( 'Got to Google Fonts (https://fonts.google.com). Copy selected font name and paste it here.', 'buzzmag' ),
	        'section'  => 'typography',
	        'priority' => 1,
        ) );


        // Headings Font Weight
        $wp_customize->add_setting( 'headings_font_weight', array(
	        'default'  => '700',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'headings_font_weight', array(
	    	'type'     => 'select',
	        'label'    => esc_html__( 'Headings Font Weight', 'buzzmag' ),
	        'section'  => 'typography',
	        'priority' => 2,
	        'choices'  => array(
	        	'400' => 'Normal',
	        	'700' => 'Bold',
	        ),
        ) );

    
		// Content Font Family
        $wp_customize->add_setting( 'body_font', array(
	        'default'  => 'Roboto',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'body_font', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Body Font Family', 'buzzmag' ),
	        'description' => esc_html__( 'Got to Google Fonts (https://fonts.google.com). Copy selected font name and paste it here.', 'buzzmag' ),
	        'section'  => 'typography',
	        'priority' => 3,
        ) );
        

        // Body Text Font Size
        $wp_customize->add_setting( 'body_font_size', array(
	        'default'  => '16',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'body_font_size', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Body Text Font Size', 'buzzmag' ),
	        'description' => esc_html__( 'Headings and all other typography elements are based on body font. When you increase body font all other typography elements increase with the same ratio.', 'buzzmag' ),
	        'section'  => 'typography',
	        'priority' => 4,
        ) );
//.............................. End Typography Section

    // Social Media
	$wp_customize->add_section( 'social' , array(
	    'title'       => esc_html__( 'Social Media (Header)', 'buzzmag' ),
	    'priority'    => 75,
		'description' => esc_html__( 'Add social media URLs. Icon will not display if left blank.', 'buzzmag' ),
	) );

		// Twitter
        $wp_customize->add_setting( 'twitter', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'twitter', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Twitter', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 1,
        ) );

        // Facebook
        $wp_customize->add_setting( 'facebook', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'facebook', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Facebook', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 2,
        ) );

        // Instagram
        $wp_customize->add_setting( 'instagram', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'instagram', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Instagram', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 3,
        ) );

        // Vimeo
        $wp_customize->add_setting( 'vimeo', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'vimeo', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Vimeo', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 4,
        ) );

        // Youtube
        $wp_customize->add_setting( 'youtube', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'youtube', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Youtube', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 5,
        ) );

        // Soundcloud
        $wp_customize->add_setting( 'soundcloud', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'soundcloud', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Soundcloud', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 6,
        ) );

        // Dribbble
        $wp_customize->add_setting( 'dribbble', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'dribbble', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Dribbble', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 7,
        ) );

        // Pinterest
        $wp_customize->add_setting( 'pinterest', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'pinterest', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Pinterest', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 8,
        ) );

        // Linkedin
        $wp_customize->add_setting( 'linkedin', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'linkedin', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Linkedin', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 9,
        ) );

        // VK
        $wp_customize->add_setting( 'vk', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'vk', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'VK', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 10,
        ) );

        // Behance
        $wp_customize->add_setting( 'behance', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'behance', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Behance', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 11,
        ) );

        // Flickr
        $wp_customize->add_setting( 'flickr', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'flickr', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'Flickr', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 12,
        ) );

        // Mail
        $wp_customize->add_setting( 'mail', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'mail', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'E-mail', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 13,
        ) );

        // RSS
        $wp_customize->add_setting( 'rss', array(
	        'default'  => '',
	        'sanitize_callback' => 'sanitize_text_field',
        ) );

        $wp_customize->add_control( 'rss', array(
	    	'type'     => 'text',
	        'label'    => esc_html__( 'RSS', 'buzzmag' ),
	        'section'  => 'social',
	        'priority' => 14,
        ) );
//.............................. End Social Media Section

	// =========================================================================
	// 3D News & Sri Lankan Portal Settings
	// =========================================================================
	$wp_customize->add_section( 'rebrand_3d_settings' , array(
	    'title'       => esc_html__( '3D News Portal Settings', 'buzzmag' ),
	    'priority'    => 42,
		'description' => esc_html__( 'Configure Category mappings, Video channels, Cartoon of the day, and WhatsApp community.', 'buzzmag' ),
	) );

		// Category Slugs Mapping
		$categories_map = array(
			'cat_slug_local'    => array( 'label' => 'Local Category Slug', 'default' => 'local' ),
			'cat_slug_offroad'  => array( 'label' => 'Off Road / Foreign Slug', 'default' => 'off-road' ),
			'cat_slug_business' => array( 'label' => 'Business Category Slug', 'default' => 'business' ),
			'cat_slug_sports'   => array( 'label' => 'Sports Category Slug', 'default' => 'sports' ),
			'cat_slug_foreign'  => array( 'label' => 'Foreign Category Slug', 'default' => 'foreign' ),
			'cat_slug_featured' => array( 'label' => 'Featured Category Slug', 'default' => 'featured' ),
			'cat_slug_politics' => array( 'label' => 'Politics Category Slug', 'default' => 'politics' ),
		);

		$p_idx = 1;
		foreach ( $categories_map as $c_key => $c_val ) {
			$wp_customize->add_setting( $c_key, array(
				'default'           => $c_val['default'],
				'sanitize_callback' => 'sanitize_text_field',
			) );

			$wp_customize->add_control( $c_key, array(
				'label'       => esc_html__( $c_val['label'], 'buzzmag' ),
				'description' => esc_html__( 'Enter category slug, category name, or category ID (e.g. local, 5). The "More" button dynamically links to its archive.', 'buzzmag' ),
				'section'     => 'rebrand_3d_settings',
				'type'        => 'text',
				'priority'    => $p_idx++,
			) );
		}

		// ==========================================
		// Portal Timezone Settings
		// ==========================================
		$wp_customize->add_setting( 'site_timezone', array(
			'default'           => 'auto',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'site_timezone', array(
			'label'       => esc_html__( 'Portal Timezone (වේලා කලාපය)', 'buzzmag' ),
			'description' => esc_html__( 'Controls timezone for Sri Lankan Calendar, Rahu Kalaya, Astrology, and News timestamps.', 'buzzmag' ),
			'section'     => 'rebrand_3d_settings',
			'type'        => 'select',
			'choices'     => array(
				'auto'         => esc_html__( 'Automatic / Sri Lanka (Asia/Colombo UTC+05:30)', 'buzzmag' ),
				'Asia/Colombo' => esc_html__( 'Asia/Colombo (Sri Lanka Time UTC+05:30)', 'buzzmag' ),
				'wp_default'   => esc_html__( 'Use WordPress Timezone (Settings > General)', 'buzzmag' ),
				'UTC'          => esc_html__( 'UTC (Coordinated Universal Time)', 'buzzmag' ),
			),
			'priority'    => 5,
		) );

		// ==========================================
		// Calendar Settings
		// ==========================================
		$wp_customize->add_setting( 'hide_calendar', array(
			'default'           => false,
			'sanitize_callback' => 'buzzmag_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'hide_calendar', array(
			'label'    => esc_html__( 'Hide Calendar Widget', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'checkbox',
			'priority' => 10,
		) );

		$wp_customize->add_setting( 'calendar_title', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'calendar_title', array(
			'label'       => esc_html__( 'Calendar Custom Title (Leave blank for default Month/Year)', 'buzzmag' ),
			'section'     => 'rebrand_3d_settings',
			'type'        => 'text',
			'priority'    => 11,
		) );

		// ==========================================
		// Astrological Settings (Rahu Kalaya, Subha, Maru)
		// ==========================================
		$wp_customize->add_setting( 'hide_rahu_kalaya', array(
			'default'           => false,
			'sanitize_callback' => 'buzzmag_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'hide_rahu_kalaya', array(
			'label'    => esc_html__( 'Hide Rahu Kalaya (රාහු කාලය සඟවන්න)', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'checkbox',
			'priority' => 12,
		) );

		$wp_customize->add_setting( 'rahu_kalaya_label', array(
			'default'           => 'රාහු කාලය (Rahu Kalaya)',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'rahu_kalaya_label', array(
			'label'    => esc_html__( 'Rahu Kalaya Label', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 13,
		) );

		$wp_customize->add_setting( 'rahu_kalaya_override', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'rahu_kalaya_override', array(
			'label'       => esc_html__( 'Rahu Kalaya Manual Time Override (e.g. "දහවල් 12:00 - 01:30")', 'buzzmag' ),
			'description' => esc_html__( 'Leave blank to use automatic traditional calculation.', 'buzzmag' ),
			'section'     => 'rebrand_3d_settings',
			'type'        => 'text',
			'priority'    => 14,
		) );

		$wp_customize->add_setting( 'hide_astrology_directions', array(
			'default'           => false,
			'sanitize_callback' => 'buzzmag_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'hide_astrology_directions', array(
			'label'    => esc_html__( 'Hide Subha & Maru Sitina Directions', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'checkbox',
			'priority' => 15,
		) );

		$wp_customize->add_setting( 'subha_dishawa_override', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'subha_dishawa_override', array(
			'label'    => esc_html__( 'Subha Dishawa Override (සුබ දිශාව)', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 16,
		) );

		$wp_customize->add_setting( 'maru_dishawa_override', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'maru_dishawa_override', array(
			'label'    => esc_html__( 'Maru Sitina Dishawa Override (මරු සිටින දිශාව)', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 17,
		) );

		// ==========================================
		// Cartoon of the Day
		// ==========================================
		$wp_customize->add_setting( 'hide_cartoon', array(
			'default'           => false,
			'sanitize_callback' => 'buzzmag_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'hide_cartoon', array(
			'label'    => esc_html__( 'Hide Cartoon of the Day', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'checkbox',
			'priority' => 20,
		) );

		$wp_customize->add_setting( 'cartoon_image', array(
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'cartoon_image', array(
		    'label'    => esc_html__( 'Cartoon of the Day Image (දවසේ කාටූනය)', 'buzzmag' ),
		    'section'  => 'rebrand_3d_settings',
		    'priority' => 21,
		) ) );

		$wp_customize->add_setting( 'cartoon_title', array(
			'default'           => 'දවසේ කාටූනය (Cartoon of the Day)',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'cartoon_title', array(
			'label'    => esc_html__( 'Cartoon Title', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 22,
		) );

		$wp_customize->add_setting( 'cartoon_desc', array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'cartoon_desc', array(
			'label'    => esc_html__( 'Cartoon Caption / Description', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 23,
		) );

		$wp_customize->add_setting( 'cartoon_link', array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'cartoon_link', array(
			'label'    => esc_html__( 'Cartoon Link (Optional external or page URL)', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 24,
		) );

		// ==========================================
		// WhatsApp Community Banner
		// ==========================================
		$wp_customize->add_setting( 'hide_whatsapp_banner', array(
			'default'           => false,
			'sanitize_callback' => 'buzzmag_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'hide_whatsapp_banner', array(
			'label'    => esc_html__( 'Hide WhatsApp Community Banner', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'checkbox',
			'priority' => 30,
		) );

		$wp_customize->add_setting( 'whatsapp_link', array(
			'default'           => 'https://chat.whatsapp.com/',
			'sanitize_callback' => 'esc_url_raw',
		) );
		$wp_customize->add_control( 'whatsapp_link', array(
			'label'    => esc_html__( 'WhatsApp Channel / Group Link', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 31,
		) );

		$wp_customize->add_setting( 'whatsapp_title', array(
			'default'           => 'අපගේ WhatsApp සමූහයට එක්වන්න',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'whatsapp_title', array(
			'label'    => esc_html__( 'WhatsApp Banner Title', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 32,
		) );

		$wp_customize->add_setting( 'whatsapp_desc', array(
			'default'           => 'නවතම උණුසුම් පුවත් එසැනින් ඔබගේ දුරකථනයටම ලබාගන්න',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'whatsapp_desc', array(
			'label'    => esc_html__( 'WhatsApp Banner Description', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 33,
		) );

		$wp_customize->add_setting( 'whatsapp_btn_text', array(
			'default'           => 'Join Channel (සම්බන්ධ වන්න)',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'whatsapp_btn_text', array(
			'label'    => esc_html__( 'WhatsApp Button Label', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 34,
		) );

		// ==========================================
		// 4 Video Channels with 5 Videos Each
		// ==========================================
		$wp_customize->add_setting( 'hide_video_channels', array(
			'default'           => false,
			'sanitize_callback' => 'buzzmag_sanitize_checkbox',
		) );
		$wp_customize->add_control( 'hide_video_channels', array(
			'label'    => esc_html__( 'Hide Video Channels Section', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'checkbox',
			'priority' => 40,
		) );

		$wp_customize->add_setting( 'video_section_title', array(
			'default'           => 'වීඩියෝ නාලිකා (Video Channels)',
			'sanitize_callback' => 'sanitize_text_field',
		) );
		$wp_customize->add_control( 'video_section_title', array(
			'label'    => esc_html__( 'Main Video Section Title', 'buzzmag' ),
			'section'  => 'rebrand_3d_settings',
			'type'     => 'text',
			'priority' => 41,
		) );

		// Channel Defaults configuration
		$ch_defaults = array(
			1 => array( 'name' => 'Channel 1 - Biz Today (ව්‍යාපාරික පුවත්)', 'badge' => 'Biz Today', 'color' => '#e67e22' ),
			2 => array( 'name' => 'Channel 2 - Prime Bulletin (ප්‍රධාන පුවත්)', 'badge' => 'Prime News', 'color' => '#ed0e28' ),
			3 => array( 'name' => 'Channel 3 - Special Talk (විශේෂ සාකච්ඡා)', 'badge' => 'Exclusive', 'color' => '#2980b9' ),
			4 => array( 'name' => 'Channel 4 - Entertainment & Sports', 'badge' => 'Channel 4', 'color' => '#27ae60' ),
		);

		$c_priority = 50;
		for ( $ch_i = 1; $ch_i <= 4; $ch_i++ ) {
			$ch_d = $ch_defaults[ $ch_i ];

			// Channel Title
			$wp_customize->add_setting( "video_ch_{$ch_i}_title", array(
				'default'           => $ch_d['name'],
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( "video_ch_{$ch_i}_title", array(
				'label'       => sprintf( esc_html__( 'Channel %d Title / Name', 'buzzmag' ), $ch_i ),
				'section'     => 'rebrand_3d_settings',
				'type'        => 'text',
				'priority'    => $c_priority++,
			) );

			// Channel Badge
			$wp_customize->add_setting( "video_ch_{$ch_i}_badge", array(
				'default'           => $ch_d['badge'],
				'sanitize_callback' => 'sanitize_text_field',
			) );
			$wp_customize->add_control( "video_ch_{$ch_i}_badge", array(
				'label'       => sprintf( esc_html__( 'Channel %d Badge Tag', 'buzzmag' ), $ch_i ),
				'section'     => 'rebrand_3d_settings',
				'type'        => 'text',
				'priority'    => $c_priority++,
			) );

			// Channel Color
			$wp_customize->add_setting( "video_ch_{$ch_i}_color", array(
				'default'           => $ch_d['color'],
				'sanitize_callback' => 'sanitize_hex_color',
			) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, "video_ch_{$ch_i}_color", array(
				'label'    => sprintf( esc_html__( 'Channel %d Accent Color', 'buzzmag' ), $ch_i ),
				'section'  => 'rebrand_3d_settings',
				'priority' => $c_priority++,
			) ) );

			// 5 Videos for this Channel
			for ( $v_j = 1; $v_j <= 5; $v_j++ ) {
				$wp_customize->add_setting( "video_ch_{$ch_i}_v_{$v_j}_title", array(
					'default'           => sprintf( '%s Video 0%d', $ch_d['badge'], $v_j ),
					'sanitize_callback' => 'sanitize_text_field',
				) );
				$wp_customize->add_control( "video_ch_{$ch_i}_v_{$v_j}_title", array(
					'label'       => sprintf( esc_html__( 'Ch %d - Video %d Title', 'buzzmag' ), $ch_i, $v_j ),
					'section'     => 'rebrand_3d_settings',
					'type'        => 'text',
					'priority'    => $c_priority++,
				) );

				$wp_customize->add_setting( "video_ch_{$ch_i}_v_{$v_j}_url", array(
					'default'           => '',
					'sanitize_callback' => 'esc_url_raw',
				) );
				$wp_customize->add_control( "video_ch_{$ch_i}_v_{$v_j}_url", array(
					'label'       => sprintf( esc_html__( 'Ch %d - Video %d URL (YouTube/Vimeo)', 'buzzmag' ), $ch_i, $v_j ),
					'section'     => 'rebrand_3d_settings',
					'type'        => 'text',
					'priority'    => $c_priority++,
				) );
			}
		}

		// Footer About Text
		$wp_customize->add_setting( 'footer_about_text', array(
			'default'           => 'ශ්‍රී ලංකාවේ සහ ලෝකයේ නවතම පුවත්, දේශපාලන, ව්‍යාපාරික, ක්‍රීඩා සහ විශේෂාංග පුවත් එසැනින් විශ්වාසදායී ලෙස ඔබ වෙත ගෙන එන ප්‍රමුඛතම ඩිජිටල් පුවත් සේවාව.',
			'sanitize_callback' => 'sanitize_textarea_field',
		) );
		$wp_customize->add_control( 'footer_about_text', array(
			'label'       => esc_html__( 'Footer About Description (Sinhala/English)', 'buzzmag' ),
			'section'     => 'footer_settings',
			'type'        => 'textarea',
			'priority'    => 1,
		) );

}
add_action( 'customize_register', 'buzzmag_customizer' );

// Textarea Escape
function buzzmag_textarea_sanitize( $input ) {
    return wp_kses_post( $input );
}

// Checkbox Sanitization
function buzzmag_sanitize_checkbox( $checked ) {
    return ( ( isset( $checked ) && true == $checked ) ? true : false );
}

// Add Changes To Head
function buzzmag_customizer_output(){ 
	$sidebar_position = get_theme_mod('sidebar_position', 'right');

	// Colors: General
	$accent_color = get_theme_mod('accent_color', '#ed0e28');
	$body_bg = get_theme_mod('body_bg', '#ffffff');
	$content_color = get_theme_mod('content_color', '#444444');
	$headings_color = get_theme_mod('headings_color', '#111111');
	$meta_color = get_theme_mod('meta_color', '#777777');
	$buttons_bg = get_theme_mod('buttons_bg', '#111111');

	// Colors: Header
	$header_bg = get_theme_mod('header_bg', '#ffffff');
	$header_color = get_theme_mod('header_color', '#111111');
	$submenu_bg = get_theme_mod('submenu_bg', '#ffffff');
	$submenu_color = get_theme_mod('submenu_color', '#111111');

	// Colors: Footer
	$footer_bg = get_theme_mod('footer_bg', '#111111');
	$footer_color = get_theme_mod('footer_color', '#777777');
	$footer_headings_color = get_theme_mod('footer_headings_color', '#ffffff');


	// Typography
	$headings_font = get_theme_mod('headings_font', 'Montserrat');
	$headings_font_weight = get_theme_mod('headings_font_weight', '700');
	$body_font = get_theme_mod('body_font', 'Roboto');
	$body_font_size = get_theme_mod('body_font_size', '16');



	//Output
	ob_start();

	if ( $sidebar_position == 'left' ) {
		echo '#fl-sidebar { float: left; }';
		echo '#fl-post-container { float: right; }';
		echo '.owl-carousel .owl-nav { left: 0; right: auto; }';
	}

	if ( get_theme_mod('fixed_header') ) {
		echo '#fl-header { position: absolute; }';
	}

	if ( get_theme_mod('sticky_tabs') ) {
		echo '.fl-loop-tabs { position: relative; }';
	}

	if ( get_theme_mod('header_drawer') ) {
		echo '#fl-drawer-icon { display: none; }';
	}


	?>

	:root {
		--fl-body-font-size: <?php echo esc_attr($body_font_size).'px'; ?>;
		--fl-body-font: <?php echo '"'.esc_attr($body_font) .'", "Helvetica Neue",Helvetica,sans-serif'; ?>;
		--fl-headings-font: <?php echo '"'.esc_attr($headings_font) .'", "Helvetica Neue",Helvetica,sans-serif;'; ?>;
		--fl-headings-font-weight: <?php echo esc_attr($headings_font_weight); ?>;

	    --fl-accent-color: <?php echo esc_attr($accent_color); ?>;

	    --fl-body-background: <?php echo esc_attr($body_bg); ?>;
	    --fl-body-color: <?php echo esc_attr($content_color); ?>;
	    --fl-headings-color: <?php echo esc_attr($headings_color); ?>;
	    --fl-meta-color: <?php echo esc_attr($meta_color); ?>;

	    --fl-button-background: <?php echo esc_attr($buttons_bg); ?>;

	    --fl-header-background: <?php echo esc_attr($header_bg); ?>;
	    --fl-header-color: <?php echo esc_attr($header_color); ?>;
	    --fl-submenu-background: <?php echo esc_attr($submenu_bg); ?>;
	    --fl-submenu-color: <?php echo esc_attr($submenu_color); ?>;

		--fl-footer-background: <?php echo esc_attr($footer_bg); ?>;
		--fl-footer-color: <?php echo esc_attr($footer_color); ?>;
		--fl-footer-headings-color: <?php echo esc_attr($footer_headings_color); ?>;

	    --fl-input-background: #ffffff;
	}

	<?php if ( !get_theme_mod('dark_mode') ) { ?>

		[data-theme="dark"] {
			--fl-headings-font-weight: 400;

		    --fl-body-background: #181818;
		    --fl-body-color: #bbbbbb;
		    --fl-headings-color: #ffffff;
		    --fl-meta-color: #888888;

		    --fl-button-background: #373737;

		    --fl-header-background: #212121;
		    --fl-header-color: #ffffff;
		    --fl-submenu-background: #212121;
		    --fl-submenu-color: #ffffff;

		    --fl-footer-background: #212121;
			--fl-footer-color: #aaaaaa;
			--fl-footer-headings-color: #ffffff;

		    --fl-input-background: #000000;
		}
	<?php }
	 
	$style = ob_get_clean();
    return $style;
}