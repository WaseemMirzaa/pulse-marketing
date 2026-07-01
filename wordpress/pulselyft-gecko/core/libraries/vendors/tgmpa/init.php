<?php
/**
 * Register the required plugins for this theme.
 *
 * @since   1.0.0
 * @package Gecko
 */
// Include the TGM_Plugin_Activation class.
include JAS_GECKO_PATH . '/core/libraries/vendors/tgmpa/class-tgm-plugin-activation.php';

/**
 * Register the required plugins for this theme.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function jas_gecko_register_required_plugins() {
	$plugins = array(
		array(
			'name'     => 'JAS Addons',
			'slug'     => 'jas-addons',
			'source'   => 'https://janstudio.net/plugins/janstudio/gecko/jas-addons.zip',
			'version'  => '1.3.3',
			'required' => true,
		),
		array(
			'name'     => 'WP BakeryPageBuilder',
			'slug'     => 'js_composer',
			'source'   => 'https://janstudio.net/plugins/vendors/js_composer.zip',
			'version'  => '8.6.1',
			'required' => true,
		),
		array(
			'name'     => 'Gecko Sample Data',
			'slug'     => 'gecko-sample',
			'source'   => 'https://janstudio.net/plugins/janstudio/gecko/gecko-sample.zip',
			'required' => true,
		),
		array(
			'name'     => esc_html__( 'Envato Market', 'gecko' ),
			'slug'     => 'envato-market',
			'source'   => 'https://goo.gl/pkJS33',
		),
		array(
			'name'     => 'Meta Slider',
			'slug'     => 'ml-slider',
			'required' => false,
		),
		array(
			'name'      => 'YITH WooCommerce Wishlist',
			'slug'      => 'yith-woocommerce-wishlist',
			'required'  => false,
		),
		array(
			'name'      => 'Contact Form 7',
			'slug'      => 'contact-form-7',
			'required'  => false,
			),
		array(
			'name'      => 'MailChimp',
			'slug'      => 'mailchimp-for-wp',
			'required'  => false,
			),
		array(
			'name'      => 'YITH WooCommerce Newsletter Popup',
			'slug'      => 'yith-woocommerce-popup',
			'required'  => false,
			),
		array(
			'name'      => 'YITH WooCommerce Ajax Product Filter',
			'slug'      => 'yith-woocommerce-ajax-navigation',
			'required'  => false,
			),
		array(
			'name'      => 'YIKES Custom Product Tabs',
			'slug'      => 'yikes-inc-easy-custom-woocommerce-product-tabs',
			'required'  => false,
		),
		array(
			'name'      => 'WooCommerce',
			'slug'      => 'woocommerce',
			'required'  => true,
		),
	);

	if ( ! class_exists( 'ColorSwatch' ) ) {
		$plugins[] = array(
			'name'    => esc_html__( 'WooCommerce Variation Swatch', 'gecko' ),
			'slug'    => 'wpa-woocommerce-variation-swatch',
			'source'  => 'https://janstudio.net/plugins/vendors/wpa-woocommerce-variation-swatch.zip',
			'version' => '1.1.8'
		);
	}

	if ( ! defined( 'WPCF7_VERSION' ) ) { 
		$plugins[] = array(
			'name'      => esc_html__( 'Contact Form by WPForms', 'gecko' ),
			'slug'      => 'wpforms-lite',
			'required'  => false,
		);
	}
	if ( ! defined( 'WPFORMS_VERSION' ) ) { 
		$plugins[] = array(
			'name'      => esc_html__( 'Contact Form 7', 'gecko' ),
			'slug'      => 'contact-form-7',
			'required'  => false,
		);
	}

	$config = array(
		'id'           => 'tgmpa',
		'menu'         => 'jas-install-plugins',
		'parent_slug'  => 'jas',
		'capability'   => 'edit_theme_options',
		'is_automatic' => true,
	);
	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'jas_gecko_register_required_plugins' );