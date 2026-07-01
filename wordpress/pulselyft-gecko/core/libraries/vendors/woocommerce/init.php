<?php
/**
 * Initialize woocommerce.
 *
 * @since   1.0.0
 * @package Gecko
 */

if ( ! class_exists( 'WooCommerce' ) ) return;

// Add this theme support woocommerce
add_theme_support( 'woocommerce' );

// Add wc support lightbox
add_theme_support( 'wc-product-gallery-lightbox' );

// Remove WooCommerce default styles.
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

/**
 * Locate a template and return the path for inclusion.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_locate_template( $template, $template_name, $template_path ) {
	global $woocommerce;

	$_template = $template;

	if ( ! $template_path ) $template_path = $woocommerce->template_url;

	$theme_path = JAS_GECKO_PATH . '/core/libraries/vendors/woocommerce/templates/';

	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Modification: Get the template from this folder, if it exists
	if ( ! $template && file_exists( $theme_path . $template_name ) )
	$template = $theme_path . $template_name;

	// Use default template
	if ( ! $template )
	$template = $_template;

	// Return what we found
	return $template;
}
function jas_gecko_wc_template_parts( $template, $slug, $name ) {
	$theme_path  = JAS_GECKO_PATH . '/core/libraries/vendors/woocommerce/templates/';
	if ( $name ) {
		$newpath = $theme_path . "{$slug}-{$name}.php";
	} else {
		$newpath = $theme_path . "{$slug}.php";
	}
	return file_exists( $newpath ) ? $newpath : $template;
}
add_filter( 'woocommerce_locate_template', 'jas_gecko_wc_locate_template', 10, 3 );
add_filter( 'wc_get_template_part', 'jas_gecko_wc_template_parts', 10, 3 );

/**
 * Change the breadcrumb separator.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = '<i class="fa fa-angle-right"></i>';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'jas_gecko_wc_change_breadcrumb_delimiter' );

/**
 * Ordering and result count.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_result_count() {
	echo '<div class="result-count-order"><div class="jas-container flex between-xs middle-xs">';
}
function jas_gecko_wc_catalog_ordering() {
	echo '</div></div>';
}
function jas_gecko_wc_catalog_filter() {
	if ( is_active_sidebar( 'wc-top' ) ) {
		echo '<span><a href="javascript:void(0);" id="jas-filter"><i class="fa fa-sliders"></i> '. esc_html__( 'Filter', 'gecko' ) .'</a></span>';
	}
}
add_action( 'woocommerce_before_shop_loop', 'jas_gecko_wc_result_count', 10 );
add_action( 'woocommerce_before_shop_loop', 'jas_gecko_wc_catalog_filter', 20 );
add_action( 'woocommerce_before_shop_loop', 'jas_gecko_wc_catalog_ordering', 30);

function jas_gecko_wc_product_title() {
	echo '<h3 class="product-title tu pr fs__13 mg__0"><a class="cd chp" href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
}
add_action( 'woocommerce_shop_loop_item_title', 'jas_gecko_wc_product_title', 15 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

/**
 * Remove e-commerce function when enable catalog mode.
 *
 * @since 1.1
 */
$catalog_mode = cs_get_option( 'wc-catalog' );
if ( $catalog_mode ) {
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
}

/**
 * Register widget area for wc.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_wc_register_sidebars' ) ) {
	function jas_gecko_wc_register_sidebars() {
		register_sidebar(
			array(
				'name'          => esc_html__( 'WooCommerce Top Sidebar', 'gecko' ),
				'id'            => 'wc-top',
				'description'   => esc_html__( 'The sidebar area for woocommerce, It will display on top of archive product page', 'gecko' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
		register_sidebar(
			array(
				'name'          => esc_html__( 'WooCommerce Sidebar', 'gecko' ),
				'id'            => 'wc-primary',
				'description'   => esc_html__( 'The woocommerce sidebar, It will display in archive product page on left or right', 'gecko' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			)
		);
	}
}
add_action( 'widgets_init', 'jas_gecko_wc_register_sidebars' );
   
/**
 * Disable page title on archive product.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_disable_page_title() {
	return false;
}
add_filter( 'woocommerce_show_page_title', 'jas_gecko_wc_disable_page_title' );

/**
 * Custom add to wishlist button in single product.
 *
 * @since 1.0.0
 */
function jas_gecko_before_single_add_to_cart() {
	$ajax_btn        = get_option( 'woocommerce_enable_ajax_add_to_cart_single' );
	$stripe_settings = get_option( 'woocommerce_stripe_settings', '' );
	$atc_behavior    = cs_get_option( 'wc-atc-behavior' ) ? cs_get_option( 'wc-atc-behavior' ) : 'slide';

	$classes = array();

	if ( $ajax_btn == 'no' ) {
		$classes[] = 'no-ajax';
	}

	if ( isset( $stripe_settings['enabled'] ) && $stripe_settings['enabled'] == 'yes' ) {
		$classes[] = 'stripe-enabled';
	}

	if ( $atc_behavior ) {
		$classes[] = 'atc-' . $atc_behavior;
	}
	echo '<div class="btn-atc ' . esc_attr( implode( ' ', $classes ) ) . '">';
}
function jas_gecko_after_single_add_to_cart() {
	echo '</div>';
}
function jas_gecko_after_add_to_cart_button() {
	if ( class_exists( 'YITH_WCWL' ) ) {
		echo jas_gecko_wc_wishlist_button();
	}
}
add_action( 'woocommerce_single_product_summary', 'jas_gecko_before_single_add_to_cart', 25 );
add_action( 'woocommerce_single_product_summary', 'jas_gecko_after_single_add_to_cart', 35 );
add_action( 'woocommerce_after_add_to_cart_button', 'jas_gecko_after_add_to_cart_button' );
function jas_gecko_return() {
	return;
}
add_filter( 'yith_wcwl_positions', 'jas_gecko_return' );

/**
 * Add button product quick view after add to cart.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_add_buton() {
	global $post, $jassc;

	// Get product hover style
	$hover_style = $jassc ? $jassc['hover-style'] : cs_get_option( 'wc-hover-style' );

	if ( $hover_style == 1 ) {
		// Quick view
		echo '<a class="btn-quickview cp pr br-36 mb__10" href="javascript:void(0);" data-prod="' . esc_attr( $post->ID ) . '"><i class="fa fa-eye mr__10"></i>' . esc_html__( 'Quick View', 'gecko' ) . '</a>';

		// Wishlist
		echo jas_gecko_wc_wishlist_button();
	} elseif ( $hover_style == 2 ) {
		// Quick view
		echo '<a class="btn-quickview cp pr bs-36" href="javascript:void(0);" data-prod="' . esc_attr( $post->ID ) . '"><i class="fa fa-eye"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html__( 'Quick View', 'gecko' ) . '</span></a>';

		// Wishlist
		echo jas_gecko_wc_wishlist_button();
	}
}
add_action( 'woocommerce_after_shop_loop_item', 'jas_gecko_wc_add_buton' );

/**
 * Custom add to wishlist button on product listing.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_wishlist_button() {
	global $product, $yith_wcwl, $jassc, $quickview;

	// Get product hover style
	$hover_style = $jassc ? $jassc['hover-style'] : cs_get_option( 'wc-hover-style' );
	if ( ! class_exists( 'YITH_WCWL' ) ) return;

	$url          = YITH_WCWL()->get_wishlist_url();
	$product_type = $product->get_type();
	$exists       = $yith_wcwl->is_product_in_wishlist( $product->get_id() );
	$classes      = 'class="add_to_wishlist cp"';
	$add          = get_option( 'yith_wcwl_add_to_wishlist_text' );
	$browse       = get_option( 'yith_wcwl_browse_wishlist_text' );
	$added        = get_option( 'yith_wcwl_product_added_text' );

	$output = '';

	if ( $quickview ) {
		$output  .= '<div class="yith-wcwl-add-to-wishlist ts__03 bs-36 mg__0 pr add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
			$output .= '<div class="yith-wcwl-add-button';
				$output .= $exists ? ' hide" style="display:none;"' : ' show"';
				$output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' ><i class="fa fa-heart-o"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html( $add ) . '</span></a>';
				$output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
			$output .= '</div>';

			$output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="cp" href="' . esc_url( $url ) . '"><i class="fa fa-check mr__10 ml__30"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html( $added ) . '</span></a></div>';
			$output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="cp"><i class="fa fa-heart"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html( $browse ) . '</span></a></div>';
		$output .= '</div>';
	} else {
		if ( $hover_style == 2 || is_singular( 'product' ) ) {
			$output  .= '<div class="yith-wcwl-add-to-wishlist ts__03 bs-36 mg__0 pr add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
				$output .= '<div class="yith-wcwl-add-button';
					$output .= $exists ? ' hide" style="display:none;"' : ' show"';
					$output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' ><i class="fa fa-heart-o"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html( $add ) . '</span></a>';
					$output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
				$output .= '</div>';

				$output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="cp" href="' . esc_url( $url ) . '"><i class="fa fa-check mr__10 ml__30"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html( $added ) . '</span></a></div>';
				$output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="cp"><i class="fa fa-heart"></i><span class="tooltip pa cw fs__12 ts__03">' . esc_html( $browse ) . '</span></a></div>';
			$output .= '</div>';
		} elseif ( $hover_style == 1 ) {
			$output  .= '<div class="yith-wcwl-add-to-wishlist ts__03 br-36 mg__0 pr add-to-wishlist-' . esc_attr( $product->get_id() ) . '">';
				$output .= '<div class="yith-wcwl-add-button';
					$output .= $exists ? ' hide" style="display:none;"' : ' show"';
					$output .= '><a href="' . esc_url( htmlspecialchars( YITH_WCWL()->get_wishlist_url() ) ) . '" data-product-id="' . esc_attr( $product->get_id() ) . '" data-product-type="' . esc_attr( $product_type ) . '" ' . $classes . ' ><i class="fa fa-heart-o mr__10"></i>' . esc_html( $add ) . '</a>';
					$output .= '<i class="fa fa-spinner fa-pulse ajax-loading" style="visibility:hidden"></i>';
				$output .= '</div>';

				$output .= '<div class="yith-wcwl-wishlistaddedbrowse hide" style="display:none;"><a class="cp" href="' . esc_url( $url ) . '"><i class="fa fa-check mr__10"></i>' . esc_html( $added ) . '</a></div>';
				$output .= '<div class="yith-wcwl-wishlistexistsbrowse ' . ( $exists ? 'show' : 'hide' ) . '" style="display:' . ( $exists ? 'block' : 'none' ) . '"><a href="' . esc_url( $url ) . '" class="cp"><i class="fa fa-heart mr__10"></i>' . esc_html( $browse ) . '</a></div>';
			$output .= '</div>';
		}
	}

	return $output;
}

/**
 * Shopping cart.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_wc_my_account' ) ) {
	function jas_gecko_wc_my_account() {
		$output = '';

		if ( cs_get_option( 'header-my-account-icon' ) ) {
			$output .= '<div class="jas-my-account hidden-xs ts__05 pr">';
				$output .= '<a class="cb chp db" href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '"><i class="pe-7s-user"></i></a>';
				$output .= '<ul class="pa tc">';
					if ( is_user_logged_in() ) {
						$output .= '<li><a class="db cg chp" href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_html__( 'My Account', 'gecko' ) . '</a></li>';
						$output .= '<li><a class="db cg chp" href="' . esc_url( wp_logout_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' )  ) ) ) . '">' . esc_html__( 'Logout', 'gecko' ) . '</a></li>';

					} else {
						$output .= '<li><a class="db cg chp" href="' . esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ) . '">' . esc_html__( 'Login / Register', 'gecko' ) . '</a></li>';
					}
				$output .= '</ul>';
			$output .= '</div>';
		}

		return apply_filters( 'jas_gecko_wc_my_account', $output );
	}
}

/**
 * Ensure cart contents update when products are added to the cart via AJAX.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_add_to_cart_fragment( $fragments ) {
	ob_start();
	?>
	<a class="cart-contents pr cb chp db" href="#" title="<?php esc_html_e( 'View your shopping cart', 'gecko' ); ?>">
		<i class="pe-7s-shopbag"></i>
		<span class="pa count bgb br__50 cw tc"><?php echo sprintf ( wp_kses_post( '%d', '%d', WC()->cart->get_cart_contents_count() ), WC()->cart->get_cart_contents_count() ); ?></span>
	</a>
	<?php
	
	$fragments['a.cart-contents'] = ob_get_clean();
	
	return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'jas_gecko_wc_add_to_cart_fragment' );

/**
 * Custom ajax add to cart
 *
 * @since  1.0.0
 *
 * @return  json
 */
function jas_gecko_wc_custom_add_to_cart_ajax() {

	if ( ! ( isset( $_REQUEST['product_id'] ) && (int) $_REQUEST['product_id'] > 0 ) )
		return;

	$titles     = array();
	$product_id = (int) $_REQUEST['product_id'];

	if ( is_array( $product_id ) ) {
		foreach ( $product_id as $id ) {
			$titles[] = get_the_title( $id );
		}
	} else {
		$titles[] = get_the_title( $product_id );
	}

	$titles     = array_filter( $titles );
	$added_text = sprintf( _n( '%s has been added to your cart.', '%s have been added to your cart.', sizeof( $titles ), 'gecko' ), wc_format_list_of_items( $titles ) );

	// Output success messages
	if ( 'yes' === get_option( 'woocommerce_cart_redirect_after_add' ) ) {
		$return_to = apply_filters( 'woocommerce_continue_shopping_redirect', wp_get_referer() ? wp_get_referer() : home_url() );
		$message   = sprintf( '<a href="%s" class="button wc-forward">%s</a> %s', esc_url( $return_to ), esc_html__( 'Continue Shopping', 'gecko' ), esc_html( $added_text ) );
	} else {
		$message   = sprintf( '<a href="%s" class="button wc-forward">%s</a> %s', esc_url( wc_get_page_permalink( 'cart' ) ), esc_html__( 'View Cart', 'gecko' ), esc_html( $added_text ) );
	}

	$data = array( 'message' => apply_filters( 'wc_add_to_cart_message', $message, $product_id ) );

	wp_send_json( $data );

	exit();
}
add_action( 'wp_ajax_jas_open_cart_side', 'jas_gecko_wc_custom_add_to_cart_ajax' );
add_action( 'wp_ajax_nopriv_jas_open_cart_side', 'jas_gecko_wc_custom_add_to_cart_ajax' );

/**
 * Shopping cart in header.
 *
 * @since 1.0.0
 */
if ( ! function_exists( 'jas_gecko_wc_shopping_cart' ) ) {
	function jas_gecko_wc_shopping_cart() {
		global $woocommerce;
		
		// Catalog mode
		$catalog_mode = cs_get_option( 'wc-catalog' );

		if ( $catalog_mode ) return;

		$output = '';
		$output .= '<div class="jas-icon-cart pr">';
			$output .= '<a class="cart-contents pr cb chp db" href="#" title="' . esc_html( 'View your shopping cart', 'gecko' ) . '">';
				$output .= '<i class="pe-7s-shopbag"></i>';
				$output .= '<span class="pa count bgb br__50 cw tc">' . wp_kses_post( $woocommerce->cart->get_cart_contents_count() ) . '</span>';
			$output .= '</a>';
		$output .= '</div>';
		return apply_filters( 'jas_gecko_wc_shopping_cart', $output );
	}
}

/**
 * Load mini cart on header.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_render_mini_cart() {
	$output = '';
	wc_clear_notices();

	ob_start();
		$args['list_class'] = '';
		wc_get_template( 'cart/mini-cart.php', $args );
	$output = ob_get_clean();

	$result = array(
		'cart_total'    => WC()->cart->cart_contents_count,
		'cart_html'     => $output,
		'cart_subtotal' => WC()->cart->get_cart_total()
	);

	echo json_encode( $result );
	exit;
}
add_action( 'wp_ajax_load_mini_cart', 'jas_gecko_wc_render_mini_cart' );
add_action( 'wp_ajax_nopriv_load_mini_cart', 'jas_gecko_wc_render_mini_cart' );

/**
 * Customize product quick view.
 *
 * @since  1.0
 */
function jas_gecko_wc_quickview() {
	wc_clear_notices();
	
	// Get product from request.
	if ( isset( $_POST['product'] ) && (int) $_POST['product'] ) {
		global $post, $product, $woocommerce;

		$id      = ( int ) $_POST['product'];
		$post    = get_post( $id );
		$product = wc_get_product( $id );

		if ( $product ) {
			// Get quickview template.
			include JAS_GECKO_PATH . '/core/libraries/vendors/woocommerce/templates/content-quickview-product.php';
		}
	}

	exit;
}
add_action( 'wp_ajax_jas_quickview', 'jas_gecko_wc_quickview' );
add_action( 'wp_ajax_nopriv_jas_quickview', 'jas_gecko_wc_quickview' );


/**
 * WPML fix: multicurrency in quickshop Gecko theme feature
 */

if ( class_exists( 'woocommerce_wpml' ) ) {
	add_filter( 'wcml_multi_currency_ajax_actions', 'add_action_to_multi_currency_ajax', 10, 1 );
	function add_action_to_multi_currency_ajax( $ajax_actions ) {
	    $ajax_actions[] = 'jas_quickview';
	    return $ajax_actions;
	}	
}

/**
 * Customize shipping & return content.
 *
 * @since  1.0
 */
function jas_gecko_wc_shipping_return() {
	// Get help content
	$message = cs_get_option( 'wc-single-shipping-return' );

	error_log( 'jas_gecko_wc_shipping_return $message: ' . print_r($message, 1));

	if ( ! $message ) return;

	$output = '<div class="wc-content-help pr">' . do_shortcode( $message ) . '</div>';

	echo wp_kses_post($output);
	exit;
}
add_action( 'wp_ajax_jas_shipping_return', 'jas_gecko_wc_shipping_return' );
add_action( 'wp_ajax_nopriv_jas_shipping_return', 'jas_gecko_wc_shipping_return' );

/**
 * Add some script to header.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_header_script() {
	?>
	<script>
		var JASAjaxURL = '<?php echo esc_js( admin_url( 'admin-ajax.php' ) ); ?>';
		var JASSiteURL = '<?php echo home_url( '/index.php' ); ?>';
	</script>
	<?php
}
add_action( 'wp_head', 'jas_gecko_wc_header_script' );

/**
 * Customize WooCommerce image dimensions.
 *
 * @since  1.0
 */
function jas_gecko_wc_customize_image_dimensions() {
	global $pagenow;

	if ( $pagenow != 'themes.php' || ! isset( $_GET['activated'] ) ) {
		return;
	}

	// Update WooCommerce image dimensions.
	update_option(
		'shop_catalog_image_size',
		array( 'width' => '570', 'height' => '760', 'crop' => 1 )
	);

	update_option(
		'shop_single_image_size',
		array( 'width' => '750', 'height' => '1100', 'crop' => 1 )
	);

	update_option(
		'shop_thumbnail_image_size',
		array( 'width' => '160', 'height' => '215', 'crop' => 1 )
	);
}
add_action( 'admin_init', 'jas_gecko_wc_customize_image_dimensions', 1 );

/**
 * Add social sharing to single product.
 *
 * @since  1.0
 */
function jas_gecko_wc_single_social_share() {
	if ( cs_get_option( 'wc-social-share' ) ) {
		jas_gecko_social_share();
	}
}
add_action( 'woocommerce_share', 'jas_gecko_wc_single_social_share' );

/**
 * Add page title to archive product.
 *
 * @since  1.0
 */
if ( ! function_exists( 'jas_gecko_wc_page_head' ) ) {
	function jas_gecko_wc_page_head() {
		// Remove old position of breadcrumb
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
		if ( ! cs_get_option( 'wc-enable-page-title' ) || ( class_exists( 'WCV_Vendors' ) && WCV_Vendors::is_vendor_page() ) ) return;

		$title = cs_get_option( 'wc-page-title' );

		$output = '<div class="page-head pr tc"><div class="jas-container pr">';
			if ( is_search() ) {
			$output .= '<h1 class="mb__5 cw">' . sprintf(__( 'Search Results for: %s', 'gecko' ), '<span>' . get_search_query() . '</span>' ) . '</h1>';
			} elseif ( is_shop() ) {
				$output .= '<h1 class="tu mb__10 cw">' . esc_html( cs_get_option( 'wc-page-title' ) ) . '</h1>';
				$output .= '<p>' . do_shortcode( cs_get_option( 'wc-page-desc' ) ) . '</p>';
			} elseif ( is_product_category() ) {
				// Remove old position of category description
				remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

				$output .= '<h1 class="tu mb__10 cw">' . single_cat_title( '', false ) . '</h1>';
				$output .= do_shortcode( category_description() );
			} else {
				$output .= '';
			}
			ob_start();
				woocommerce_breadcrumb();
			$output .= ob_get_clean();
		$output .= '</div></div>';

		echo wp_kses_post( $output );
	}
	add_action( 'woocommerce_before_main_content', 'jas_gecko_wc_page_head', 15 );
	add_action( 'woocommerce_before_single_product', 'jas_gecko_wc_page_head', 5 );
}

/**
 * Woocommerce currency switch.
 *
 * @since 1.0.0
 */
function jas_gecko_wc_currency() {
	if ( ! class_exists( 'JAS_Addons_Currency' ) || ! cs_get_option( 'header-currency' ) ) return;

	// Auto update currency
	$update_every_hours = get_option( 'jas_currency_auto_update_hours' );
	if ( isset( $update_every_hours ) && $update_every_hours > 0 ) {
		$last_time_update_cr = strtotime(get_option( 'jas_currency_auto_update_last_time' ) );
		if ( ( time() - $last_time_update_cr ) / 60 / 60 > $update_every_hours ) {
			// Update currency rate
			JAS_Addons_Currency::autoUpdateCurrencyRate();
			$time_format = get_option( 'time_format' );
			update_option( 'jas_currency_auto_update_last_time', date( $time_format, time() ) );
		}
	}

	$currencies = JAS_Addons_Currency::getCurrencies();
	$default    = JAS_Addons_Currency::woo_currency();

	$update_by_location = get_option( 'jas_currency_update_by_location', 0 );
	
	if ($update_by_location) {
		$result  = array( 'currency' => '' );
		$client  = WC_Geolocation::get_external_ip_address();
		$ip_data = @json_decode(wp_remote_get( 'http://www.geoplugin.net/json.gp?ip=' . $client ) );
		if ( $ip_data && $ip_data->geoplugin_currencyCode != null ) {
			$result['currency'] = $ip_data->geoplugin_currencyCode;
			if ( isset( $currencies[$result['currency']] ) ) {
				$default = $result;
			}
		}	
	}

	$current = isset($_COOKIE['jas_currency']) ? $_COOKIE['jas_currency'] : $default['currency'];
	$_COOKIE['jas_currency']  = $current;
	$output = '';
	if ( is_array( $currencies ) && count( $currencies ) > 0 ) :
		$woocurrency = JAS_Addons_Currency::woo_currency();
		$woocode = $woocurrency['currency'];
		if ( ! isset( $currencies[$woocode] ) ) {
			$currencies[$woocode] = $woocurrency;
		}
		$output .= '<div class="jas-currency dib pr">';
			$output .= '<span class="current">' . esc_html( $current ) . '<i class="fa fa-angle-down ml__5"></i></span>';
			$output .= '<ul class="pa tr ts__03">';
				foreach ( $currencies as $code => $val ) :
					$output .= '<li>';
						$output .= '<a class="currency-item cw chp" href="javascript:void(0);" data-currency="' . esc_attr( $code ) . '">' . esc_html( $code ) . '</a>';
					$output .= '</li>';
				endforeach;
			$output .= '</ul>';
		$output .= '</div>';
	endif;

	return apply_filters( 'jas_gecko_wc_currency', $output );
}

/**
 * Change number of products displayed per page.
 *
 * @since  1.0
 *
 * @return  number
 *
 */
function jas_gecko_wc_change_product_per_page() {
	$number = cs_get_option( 'wc-number-per-page' );

	return $number;
}
add_filter( 'loop_shop_per_page', 'jas_gecko_wc_change_product_per_page' );

/**
 * Preview Email Transaction.
 *
 * @since  1.0
 */
$preview = JAS_GECKO_PATH . '/core/libraries/vendors/woocommerce/templates/emails/woo-preview-emails.php';
if ( file_exists( $preview ) ) {
	include $preview;
}

/**
 * Change pagination position.
 *
 * @since  1.0
 */
remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination' );
add_action( 'jas_pagination', 'woocommerce_pagination' );

/**
 * Ajax search.
 *
 * @since  1.0
 */
function jas_gecko_wc_live_search() {
	$result = array();
	$args = array(
		's'              => urldecode( $_REQUEST['key'] ),
		'post_type'      => 'product',
		'posts_per_page' => 10
	);
	$query = new WP_Query( $args );
	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			$thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), array( 60,60 ) );
			if ( ! empty( $thumb ) ) {
				$thumb = $thumb[0];
			} else {
				$thumb = '';
			}
			$result[] = array(
				'id'     => get_the_ID(),
				'label'  => get_the_title(),
				'value'  => get_the_title(),
				'thumb'  => $thumb,
				'url'    => get_the_permalink(),
				'except' => preg_replace( '/[\x00-\x1F\x7F-\xFF]/u', '' , mb_substr( strip_tags( get_the_excerpt() ), 0, 60 , 'UTF-8' ) ) . '...'
			);
		}
	}
	echo json_encode( $result );
	exit;
}
add_action( 'wp_ajax_jas_gecko_live_search', 'jas_gecko_wc_live_search' );
add_action( 'wp_ajax_nopriv_jas_gecko_live_search', 'jas_gecko_wc_live_search' );

/**
 * Add setting enable AJAX add to cart buttons on product detail
 *
 * @since  1.3.4
 */
function jas_gecko_setting_ajax_btn( $settings ) {
	$data = array();

	if ( $settings ) {
		foreach( $settings as $val ) {
			if ( isset( $val['id'] ) && $val['id'] == 'woocommerce_enable_ajax_add_to_cart' ) {

				$val['checkboxgroup'] = '';

				$data[] = $val;

				$data[] = array(
					'desc'          => esc_html__( 'Enable AJAX add to cart buttons on product detail', 'gecko' ),
					'id'            => 'woocommerce_enable_ajax_add_to_cart_single',
					'default'       => 'yes',
					'type'          => 'checkbox',
					'checkboxgroup' => 'end'
				);
			} else {
				$data[] = $val;
			}
		}

	}

	return $data;
}
add_filter( 'woocommerce_product_settings' , 'jas_gecko_setting_ajax_btn' );

/**
 * Change number of related products output
 *
 * @since  1.1.3
 */
if ( ! function_exists( 'jas_gecko_related_products_limit' ) ) {
	function jas_gecko_related_products_limit( $args ) {
		$limit = cs_get_option( 'wc-other-product-limit' ) ? cs_get_option( 'wc-other-product-limit' ) : 4;

		$args['posts_per_page'] = $limit;
		return $args;
	}
	add_filter( 'woocommerce_output_related_products_args', 'jas_gecko_related_products_limit' );
}

/**
 * Extra HTML content below add to cart button.
 *
 * @since  1.6.0
 */
function jas_gecko_wc_extra_content() {
	// Get extra content
	$extra_content = cs_get_option( 'wc-extra-content' );

	if ( $extra_content ) {
		$output = '<div class="wc-extra-content dib w__100 mt__30">' . do_shortcode( $extra_content ) . '</div>';

		echo apply_filters( 'jas_gecko_wc_extra_content', $output );
	}
}
add_action( 'woocommerce_single_product_summary', 'jas_gecko_wc_extra_content', 35 );

/**
 * Extra HTML content below cart total.
 *
 * @since  1.6.0
 */
function jas_gecko_cart_extra_content() {
	// Get extra cart content
	$cart_content = cs_get_option( 'wc-cart-content' );

	if ( $cart_content ) {
		$output = '<div class="wc-cart-extra-content dib w__100  mt__30">' . do_shortcode( $cart_content ) . '</div>';

		echo apply_filters( 'jas_gecko_cart_extra_content', $output );
	}
}
add_action( 'woocommerce_after_cart_totals', 'jas_gecko_cart_extra_content' );

/**
 * Extra HTML content below checkout button.
 *
 * @since  1.6.0
 */
function jas_gecko_checkout_extra_content() {
	// Get extra checkout content
	$checkout_content = cs_get_option( 'wc-checkout-content' );

	if ( $checkout_content ) {
		$output = '<div class="wc-extra-content dib w__100 mt__30">' . do_shortcode( $checkout_content ) . '</div>';

		echo apply_filters( 'jas_gecko_checkout_extra_content', $output );
	}
}
add_action( 'woocommerce_review_order_after_submit', 'jas_gecko_checkout_extra_content', 35 );

/**
 * Extra HTML content below checkout button minicart.
 *
 * @since  1.6.0
 */
function jas_gecko_minicart_extra_content() {
	// Get extra checkout content
	$minicart_content = cs_get_option( 'wc-minicart-content' );

	if ( $minicart_content ) {
		$output = '<div class="wc-extra-content dib w__100">' . do_shortcode( $minicart_content ) . '</div>';

		echo apply_filters( 'jas_gecko_minicart_extra_content', $output );
	}
}
add_action( 'woocommerce_after_mini_cart', 'jas_gecko_minicart_extra_content', 10 );

/**
 * Sticky add to cart
 *
 * @since  1.6.0
 */
if ( ! function_exists( 'jas_gecko_sticky_add_to_cart' ) ) {
	function jas_gecko_sticky_add_to_cart() {
		if ( cs_get_option( 'wc-sticky-atc' ) && ! cs_get_option('wc-catalog') ) {
			$atc_behavior = cs_get_option( 'wc-atc-behavior' );
			if ( $atc_behavior == 'popup' ) {
				$atc_behavior = ' atc-popup';
			} else {
				$atc_behavior = ' atc-slide';
			}
			echo '<div class="jas-sticky-atc pf bgb' . $atc_behavior . '">';
				echo woocommerce_template_single_add_to_cart();
			echo '</div>';
		}
	}
}

/**
 * Get Ajax refreshed fragments
 *
 * @since  1.6.0
 */
function jas_gecko_popup_ajax_fragments(){
	ob_start();

	woocommerce_mini_cart();

	$mini_cart = ob_get_clean();

	// Fragments and mini cart are returned
	$data = array(
		'fragments' => apply_filters( 'woocommerce_add_to_cart_fragments', array(
				'div.widget_shopping_cart_content' => '<div class="widget_shopping_cart_content">' . $mini_cart . '</div>'
			)
		),
		'cart_hash' => apply_filters( 'woocommerce_add_to_cart_hash', WC()->cart->get_cart_for_session() ? md5( json_encode( WC()->cart->get_cart_for_session() ) ) : '', WC()->cart->get_cart_for_session() )
	);
	return $data;
}

/**
 * Allow multicurrency on ajax
 */
add_filter( 'wcml_load_multi_currency_in_ajax', 'gecko_load_multi_currency_in_ajax', 10, 1 );
if (!function_exists('gecko_load_multi_currency_in_ajax')){
    function gecko_load_multi_currency_in_ajax( $load ) {
        if (!is_admin()){
            $load = true;
        }
        return $load;
    }
}


/**
 * Get popup cart content
 *
 * @since  1.6.0
 */
function jas_gecko_get_popup_cart() {
	$cart_data = WC()->cart->get_cart();

	$output = '';

	if ( $cart_data ) {
		$output .= '<h3 class="cart__popup-title center-xs">' . esc_html__( 'Your order', 'gecko' ) . '</h3>';

		foreach ( $cart_data as $cart_item_key => $cart_item ) {
			$_product          = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id        = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
			$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );             
			$thumbnail         = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );
			$product_price     = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
			$product_subtotal  = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );

			if ( ! $product_permalink ) {
				$product_name = apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
			} else {
				$product_name = apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
			}


			$output .= '<div class="cart__popup-item flex middle-xs" data-cart-item="' . htmlentities( json_encode( array( 'key' => $cart_item_key, 'pid' => $product_id , 'pname' => $product_name ) ) ) . '">';
				$output .= '<div class="cart__popup-thumb">' . $thumbnail . ' </div>';
				$output .= '<div class="cart__popup-title grow">';

					if ( ! $product_permalink ) {
						$output .= apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;';
					} else {
						$output .= apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key );
					}

					// Meta data
					if ( version_compare( WC_VERSION, '3.3.0', '<' ) ) {
						$output .= WC()->cart->get_item_data( $cart_item );
					} else {
						$output .= wc_get_formatted_cart_item_data( $cart_item );
					}

					// Backorder notification
					if ( $_product->backorders_require_notification() && $_product->is_on_backorder( $cart_item['quantity'] ) ) {
						$output .= '<p class="backorder_notification">' . esc_html__( 'Available on backorder', 'gecko' ) . '</p>';
					}

				$output .= '</div>';
				$output .= '<div class="cart__popup-price">' . $product_price . '</div>';
				$output .= '<div class="cart__popup-quantity">';

				if ( $_product->is_sold_individually() ) {
					$output .= sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
				} else {
					$max_value = apply_filters( 'woocommerce_quantity_input_max', $_product->get_max_purchase_quantity(), $_product );
					$min_value = apply_filters( 'woocommerce_quantity_input_min', $_product->get_min_purchase_quantity(), $_product );
					$step      = apply_filters( 'woocommerce_quantity_input_step', 1, $_product );

					$output .= '<div class="quantity pr fl">';
						$output .= '<a class="cart__popup-qty cart__popup-qty--minus tc" href="javascript:void(0);">-</a>';
						$output .= '<input type="number" class="cart__popup-qty--input tc" max="'. esc_attr( 0 < $max_value ? $max_value : '' ).'" min="' . esc_attr( $min_value ) .'" step="' . esc_attr( $step ) . '" value="' . $cart_item['quantity'] . '">';
						$output .= '<a class="xcp-plus cart__popup-qty cart__popup-qty--plus tc" href="javascript:void(0);">+</a>';
					$output .= '</div>';
				}

				$output .= '</div>';
				$output .= '<div class="cart__popup-total fwb cb">' . $product_subtotal . '</div>';
				$output .= '<div class="cart__popup-remove"><i class="fa fa-trash"></i></div>';
			$output .= '</div>';
		}
		$output .= '<div class="flex end-md end-sm center-xs middle-xs cb fs__16 mt__10 pb__10 cart__popup-subtotal"><span class="mr__10">' . esc_html__( 'Subtotal', 'gecko' ) . ': </span><span class="cart__popup-stotal fwb ml__10">' . WC()->cart->get_cart_subtotal() . '</span></div>';

		$output .= '<div class="flex between-xs mt__20">';
			$output .= '<a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '" class="button continue-button">';
				$output .= esc_html__( 'Continue shopping', 'gecko' );
			$output .= '</a>';
			$output .= '<a href="' . esc_url( wc_get_page_permalink( 'checkout' ) ) . '" class="checkout-button button alt wc-forward">';
				$output .= esc_html__( 'Proceed to checkout', 'gecko' );
			$output .= '</a>';
		$output .= '</div>';

		

		$upsells = $cart_product_ids = $args2 = array();

		foreach ( $cart_data as $item ) {
			$cart_product_ids[] = $item['product_id'];
		}

		foreach ( $cart_product_ids as $product_id ) {
			$product = new WC_product( $product_id );
			$upsells = array_merge( $upsells, $product->get_upsell_ids() );
		}

		if ( $upsells ) {
			$upsells = array_diff( $upsells, $cart_product_ids );
			$args2 = array(
				'ignore_sticky_posts' => 1,
				'no_found_rows'       => 1,
				'post__in'            => $upsells,
				'meta_query'          => WC()->query->get_meta_query()
			);
		}
		$args = array(
			'orderby'        => 'post__in',
			'posts_per_page' => 4,
			'post_type'      => 'product',
			'post_status'	 => 'publish',	
			'post__not_in'   => $cart_product_ids,
		);

		$args = array_merge( $args, $args2 );

		$p_related = new WP_Query( $args );

		if ( $p_related->have_posts() ) :
			$output .= '<h3 class="cart__popup-related-title center-xs">' . esc_html__( 'You might also like', 'gecko' ) . '</h3>';
			$output .= '<div class="cart__popup-related jas-row">';
				while ( $p_related->have_posts() ) : $p_related->the_post();
					global $product;
					
					if ( $product->is_in_stock() ) {
						$output .= '<div class="jas-col-xs-6 jas-col-md-3">';
							$output .= '<div class="popup__cart-product center-xs">';
								if ( has_post_thumbnail() ) {
									$props = wc_get_product_attachment_props( get_post_thumbnail_id(), get_the_ID() );
									$output .= get_the_post_thumbnail( get_the_ID(), array( 150, 150 ), array(
										'title'	 => $props['title'],
										'alt'    => $props['alt'],
									) );
								} elseif ( wc_placeholder_img_src() ) {
									$output .= wc_placeholder_img( array( 150, 150 ) );
								}

								$output .= '<h4 class="ls__0"><a href="' . get_the_permalink() . '">';
									$output .= get_the_title();
								$output .= '</a></h4>';

								ob_start();
									wc_get_template( 'loop/price.php' );
								$output .= ob_get_clean();
								
								if ( $product->get_type() == 'variable' ) {
									$output .= apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</a>',
											esc_url( $product->add_to_cart_url() ),
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $class ) ? $class : 'button' ),
											esc_html( $product->add_to_cart_text() )
										),
									$product );
								} else {
									$output .= apply_filters( 'woocommerce_loop_add_to_cart_link',
										sprintf( '<button data-quantity="%s" data-product_id="%s" data-product_sku="%s" class="%s">%s</button>',
											esc_attr( isset( $quantity ) ? $quantity : 1 ),
											esc_attr( $product->get_id() ),
											esc_attr( $product->get_sku() ),
											esc_attr( isset( $class ) ? $class : 'modal_btn_add_to_cart ls__0' ),
											esc_html( $product->add_to_cart_text() )
										),
									$product );
								}
							$output .= '</div>';
						$output .= '</div>';
					}
				endwhile;
			$output .= '</div>';
		endif;
		wp_reset_postdata();

		return apply_filters( 'jas_gecko_get_popup_cart', $output );
	}
}

/**
 * Update cart
 *
 * @since  1.6.0
 */
function jas_gecko_popup_update_cart() {
	$product_data = json_decode( stripslashes( $_POST['product_data'] ),true );
	$product_id   = intval( $product_data['product_id'] );
	$variation_id = intval( $product_data['variation_id'] );
	$quantity     = empty( $product_data['quantity'] ) ? 1 : wc_stock_amount( $product_data['quantity'] );
	$product      = wc_get_product( $product_id );
	$variations   = array();
	$product_image = false;

	if ( $variation_id ) {
		$attributes        = $product->get_attributes();
		$variation_data    = wc_get_product_variation_attributes( $variation_id );
		$chosen_attributes = json_decode( stripslashes( $product_data['attributes'] ), true );
		
		foreach ( $attributes as $attribute ) {

			if ( ! $attribute['is_variation'] ) {
				continue;
			}

			$taxonomy = 'attribute_' . sanitize_title( $attribute['name'] );
			if ( isset( $chosen_attributes[ $taxonomy ] ) ) {
				// Get value from post data
				if ( $attribute['is_taxonomy'] ) {
					// Don't use wc_clean as it destroys sanitized characters
					$value = sanitize_title( stripslashes( $chosen_attributes[ $taxonomy ] ) );

				} else {
					$value = wc_clean( stripslashes( $chosen_attributes[ $taxonomy ] ) );
				}

				// Get valid value from variation
				$valid_value = isset( $variation_data[ $taxonomy ] ) ? $variation_data[ $taxonomy ] : '';

				// Allow if valid or show error.
				if ( '' === $valid_value || $valid_value === $value ) {
					$variations[ $taxonomy ] = $value;
				} 
			}

		}
		$cart_success  =  WC()->cart->add_to_cart( $product_id, $quantity, $variation_id, $variations );
		$variation     = new WC_product_variation($variation_id);
		$product_image = $variation->get_image();

	} elseif ( $variation_id === 0 ) {
		$cart_success = WC()->cart->add_to_cart( $product_id, $quantity );
	}

	if ( isset( $product_image ) && ! $product_image ) {
		$product_image = $product->get_image( $product_id );
	} else {
		$product_image = '';
	}

	if ( $cart_success ) {
		$cart_data       = WC()->cart->get_cart();
		$added_cart_key  = $cart_success;
		$added_item_data = $cart_data[$added_cart_key];
		$added_cart_qty  = $added_item_data['quantity'];
		$added_title     = $added_item_data['data']->get_title();
		$output          = jas_gecko_get_popup_cart();
		$ajax_fragm      = jas_gecko_popup_ajax_fragments();
		$items_count     = WC()->cart->get_cart_contents_count();

		wp_send_json(
			array(
				'pname'       => $added_title,
				'output'      => $output,
				'pimg'        => $product_image ,
				'ajax_fragm'  => $ajax_fragm ,
				'items_count' => $items_count
			)
		);
	} else {
		if ( wc_notice_count( 'error' ) > 0 ) {
			echo wc_print_notices();
		}
	}
	die();
}
add_action( 'wp_ajax_jas_gecko_popup_update_cart', 'jas_gecko_popup_update_cart' );
add_action( 'wp_ajax_nopriv_jas_gecko_popup_update_cart', 'jas_gecko_popup_update_cart' );

/**
 * Update cart in ajax
 *
 * @since  1.6.0
 */
function jas_gecko_popup_update_ajax() {
	$cart_item_key = sanitize_text_field( $_POST['cart_key'] );
	$new_qty       = (int) $_POST['new_qty'];
	$undo          = sanitize_text_field ($_POST['undo_item'] );
	$updated	   = '';

	if ( $new_qty === 0 ) {
		$removed = WC()->cart->remove_cart_item( $cart_item_key );
	} elseif ( $undo == 'true' ) {
		$updated = WC()->cart->restore_cart_item( $cart_item_key );
	} else {
		$updated = WC()->cart->set_quantity( $cart_item_key, $new_qty, true );  
	}

	$cart_data = WC()->cart->get_cart();

	if ( $removed ) {
		$ptotal = $quantity = 0;
	}

	if ( $updated ) {
		$cart_item = $cart_data[$cart_item_key];
		$_product  = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
		$ptotal    = apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
		$quantity  = $cart_item['quantity'];
		
	}
	
	if ( $updated || $removed ) {
		$items_count = count( $cart_data );
		$ajax_fragm  = jas_gecko_popup_ajax_fragments();
		$data = array(
			'ptotal'      => $ptotal ,
			'quantity'    => $quantity,
			'cart_total'  => WC()->cart->get_cart_subtotal(),
			'ajax_fragm'  => $ajax_fragm ,
			'items_count' => $items_count
		);
		wp_send_json( $data );
	} else {
		if ( wc_notice_count( 'error' ) > 0 ) {
			echo wc_print_notices();
		}
	}
	die();
}
add_action( 'wp_ajax_jas_gecko_popup_update_ajax', 'jas_gecko_popup_update_ajax' );
add_action( 'wp_ajax_nopriv_jas_gecko_popup_update_ajax', 'jas_gecko_popup_update_ajax' );

/**
 * detect add to cart behaviour by class on body tag. 
 *
 * @since  1.2.2
 */
function jas_gecko_popup_content_ajax() {
	echo jas_gecko_get_popup_cart();
	die();
}
add_action( 'wp_ajax_jas_gecko_popup_content_ajax', 'jas_gecko_popup_content_ajax' );
add_action( 'wp_ajax_nopriv_jas_gecko_popup_content_ajax', 'jas_gecko_popup_content_ajax' );