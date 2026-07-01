<?php
/**
 * Action hooks.
 *
 * @since   1.0.0
 * @package Gecko
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_setup' ) ) {
	function jas_gecko_setup() {
		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * @since 1.0.0
		 */
		$GLOBALS['content_width'] = apply_filters( 'gecko_content_width', 820 );

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /language/ directory.
		 *
		 * @since 1.0.0
		 */
		load_theme_textdomain( 'gecko', JAS_GECKO_PATH . '/core/libraries/janstudio/language' );

		/**
		 * Add theme support.
		 *
		 * @since 1.0.0
		 */
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );
		add_theme_support( 'custom-header' );
		add_theme_support( 'custom-background' );

		/**
		 * Register theme location.
		 *
		 * @since 1.0.0
		 */
		register_nav_menus(
			array(
				'primary-menu' => esc_html__( 'Primary Menu', 'gecko' ),
				'left-menu'    => esc_html__( 'Left Menu', 'gecko' ),
				'right-menu'   => esc_html__( 'Right Menu', 'gecko' ),
				'footer-menu'  => esc_html__( 'Footer Menu', 'gecko' ),
			)
		);

		// Tell TinyMCE editor to use a custom stylesheet.
		add_editor_style( JAS_GECKO_URL . '/assets/css/editor-style.css' );
	}
}
add_action( 'after_setup_theme', 'jas_gecko_setup' );

/**
 * Register widget area.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_register_sidebars' ) ) {
	function jas_gecko_register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Primary Sidebar', 'gecko' ),
				'id'            => 'primary-sidebar',
				'description'   => esc_html__( 'The Primary Sidebar', 'gecko' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title tu">',
				'after_title'   => '</h4>',
			)
		);
		for ( $i = 1, $n = 4; $i <= $n; $i++ ) {
			register_sidebar(
				array(
					'name'          => esc_html__( 'Footer Area #', 'gecko' ) . $i,
					'id'            => 'footer-' . $i,
					'description'   => sprintf( esc_html__( 'The #%s column in footer area', 'gecko' ), $i ),
					'before_widget' => '<aside id="%1$s" class="widget %2$s">',
					'after_widget'  => '</aside>',
					'before_title'  => '<h3 class="widget-title tu">',
					'after_title'   => '</h3>',
				)
			);
		}
	}
}
add_action( 'widgets_init', 'jas_gecko_register_sidebars' );

/**
 * Add Menu Page Link.
 *
 * @return void
 * @since  1.0.0
 */
if ( ! function_exists( 'jas_gecko_add_framework_menu' ) ) {
	function jas_gecko_add_framework_menu() {
		$menu = 'add_menu_' . 'page';
		$menu(
			'jas_panel',
			esc_html__( 'JanStudio', 'gecko' ),
			'',
			'jas',
			NULL,
			JAS_GECKO_URL . '/core/admin/assets/images/admin-icon.svg',
			99
		);
	}
}
add_action( 'admin_menu', 'jas_gecko_add_framework_menu' );

/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_enqueue_scripts' ) ) {
	function jas_gecko_enqueue_scripts() {
		// Google font
		wp_enqueue_style( 'jas-font-google', jas_gecko_google_font_url() );

		// Font Awesome
		wp_dequeue_style( 'font-awesome' );
		wp_enqueue_style( 'fontawesome', JAS_GECKO_URL . '/assets/vendors/font-awesome/css/font-awesome.min.css', [], JAS_GECKO_VERSION );

		// Font Stroke
		wp_enqueue_style( 'font-stroke', JAS_GECKO_URL . '/assets/vendors/font-stroke/css/font-stroke.min.css', [], JAS_GECKO_VERSION );

		// Slick Carousel
		wp_enqueue_style( 'slick', JAS_GECKO_URL . '/assets/vendors/slick/slick.css', [], JAS_GECKO_VERSION );
		wp_enqueue_script( 'slick', JAS_GECKO_URL . '/assets/vendors/slick/slick.min.js', [], JAS_GECKO_VERSION, true );

		// Magnific Popup
		wp_enqueue_script( 'magnific-popup', JAS_GECKO_URL . '/assets/vendors/magnific-popup/jquery.magnific-popup.min.js', [], JAS_GECKO_VERSION, true );

		// Isotope
		wp_enqueue_script( 'isotope', JAS_GECKO_URL . '/assets/vendors/isotope/isotope.pkgd.min.js', [], JAS_GECKO_VERSION, true );

		// Scroll Reveal
		wp_enqueue_script( 'scrollreveal', JAS_GECKO_URL . '/assets/vendors/scrollreveal/scrollreveal.min.js', [], JAS_GECKO_VERSION, true );

		
		// jQuery Countdown
		if ( cs_get_option( 'maintenance' ) ) {
			wp_enqueue_script( 'countdown', JAS_GECKO_URL . '/assets/vendors/jquery-countdown/jquery.countdown.min.js', [], JAS_GECKO_VERSION, true );
		}

		if ( class_exists( 'WooCommerce' ) ) {
			wp_enqueue_script( 'wc-add-to-cart-variation' );
			wp_enqueue_script( 'jquery-ui-autocomplete' );

			// Zoom image
			if ( is_singular( 'product' ) && cs_get_option( 'wc-single-zoom' ) && !wp_is_mobile() ) {
				wp_enqueue_script( 'zoom' );
			}
		}

		// Remove lightbox
		$lightbox_en = 'yes' === get_option( 'woocommerce_enable_lightbox' );
		if ( ! $lightbox_en && is_singular( 'product' ) ) {
			wp_dequeue_script( 'prettyPhoto' );
			wp_dequeue_script( 'prettyPhoto-init' );
		}

		// Main scripts
		wp_enqueue_script( 'jas-gecko-script', JAS_GECKO_URL . '/assets/js/theme.js', array( 'jquery' ), JAS_GECKO_VERSION, true );

		// Custom localize script
		wp_localize_script( 'jas-gecko-script', 'JAS_Data_Js', jas_gecko_custom_data_js() );

		// Responsive stylesheet
		wp_enqueue_style( 'jas-gecko-animated', JAS_GECKO_URL . '/assets/css/animate.css', [], JAS_GECKO_VERSION);

		// Main stylesheet
		wp_enqueue_style( 'jas-gecko-style', get_stylesheet_uri(), [], JAS_GECKO_VERSION );

		// RTL stylesheet
		if ( is_rtl() ) {
            wp_enqueue_style('jas-gecko-rtl', JAS_GECKO_URL . '/assets/css/rtl.css', [], JAS_GECKO_VERSION);
        }

		// Inline stylesheet
		wp_add_inline_style( 'jas-gecko-style', jas_gecko_custom_css() );

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		do_action( 'gecko_scripts');
	}
}
add_action( 'wp_enqueue_scripts', 'jas_gecko_enqueue_scripts', 10 );

/**
 * Dequeue style of some plugins that load same file with theme
 *
 * @since 1.7.5
 */
if ( ! function_exists( 'jas_dequeue_style' ) ) {
	function jas_dequeue_style() {
	    wp_dequeue_style( 'yith-wcwl-font-awesome' );
	    wp_deregister_style( 'yith-wcwl-font-awesome' );
	    wp_dequeue_style( 'dokan-fontawesome' );
	    wp_deregister_style( 'dokan-fontawesome' );
	}
	add_action( 'wp_print_styles', 'jas_dequeue_style' );
}


/**
 * Redirect to under construction page
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_offline' ) ) {
	function jas_gecko_offline() {
		// Check if under construction page is enabled
		if ( cs_get_option( 'maintenance' ) ) {
			if ( ! is_feed() ) {
				// Check if user is not logged in
				if ( ! is_user_logged_in() ) {
					// Load under construction page
					include JAS_GECKO_PATH . '/views/pages/offline.php';
					exit;
				}
			}

			// Check if user is logged in
			if ( is_user_logged_in() ) {
				global $current_user;

				// Get user role
				wp_get_current_user();

				$loggedInUserID = $current_user->ID;
				$userData = get_userdata( $loggedInUserID );

				// If user role is not 'administrator' then redirect to under construction page
				if ( 'administrator' != $userData->roles[0] ) {
					if ( ! is_feed() ) {
						include JAS_GECKO_PATH . '/views/pages/offline.php';
						exit;
					}
				}
			}
		}
	}
}
add_action( 'template_redirect', 'jas_gecko_offline' );

/**
 * Add meta data for social network
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_social_meta' ) && ! function_exists( 'wpseo_activate' ) && ! class_exists('RankMath') ) {
	function jas_gecko_social_meta() {
		global $post;
		global $allowedtags;
        $alltags = (array)$allowedtags + array(
            'meta' => array(
                'itemprop' => array(),
                'content' => array(),
                'name' => array(),
                'property' => array(),
            ),
        );

		if ( $post ) {
			$output = '';
			$image_src_array = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full', true );
			
			$output .= '<meta itemprop="name" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
			$output .= '<meta itemprop="description" content="' . esc_attr( strip_tags( $post->the_excerpt ) ) . '">';
			$output .= '<meta itemprop="image" content="' . esc_url( $image_src_array[0] ) . '">';

			$output .= '<meta name="twitter:card" content="summary_large_image">';
			$output .= '<meta name="twitter:site" content="@' . str_replace( ' ', '', get_bloginfo( 'name' ) ) . '">';
			$output .= '<meta name="twitter:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '">';
			$output .= '<meta name="twitter:description" content="' . esc_attr( strip_tags( $post->the_excerpt ) ) . '">';
			$output .= '<meta name="twitter:creator" content="@' . str_replace( ' ', '', get_bloginfo( 'name' ) ) . '">';
			$output .= '<meta name="twitter:image:src" content="' . esc_url( $image_src_array[0] ) . '">';

			$output .= '<meta property="og:title" content="' . esc_attr( strip_tags( get_the_title() ) ) . '" />';
			$output .= '<meta property="og:url" content="' . esc_url( get_permalink() ) . '" />';
			$output .= '<meta property="og:image" content="' . esc_url( $image_src_array[0] ) . '" />';
			$output .= '<meta property="og:image:url" content="' . $image_src_array[ 0 ] . '"/>'. "\n";
			$output .= '<meta property="og:description" content="' . esc_attr( strip_tags( $post->the_excerpt ) ) . '" />';
			$output .= '<meta property="og:site_name" content="' . get_bloginfo( 'name') . '" />';

			if ( function_exists( 'is_product' ) && is_product() ) {
				$output .= '<meta property="og:type" content="product"/>'. "\n";
			} else {
				$output .= '<meta property="og:type" content="article"/>'. "\n";
			}	 
			echo force_balance_tags( wp_kses($output, $alltags) );
		}
	}
	add_action( 'wp_head', 'jas_gecko_social_meta' );
}

/**
 * Add custom javascript code
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_custom_js' ) ) {
	function jas_gecko_custom_js() {
		$data = cs_get_option( 'custom-js' );
		if ( ! empty( $data ) ) :
			echo '<scr' . 'ipt>' . $data . '</scr' . 'ipt>';
		endif;
	}
	add_action( 'wp_footer', 'jas_gecko_custom_js' );
}