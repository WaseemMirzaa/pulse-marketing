<?php
/**
 * Custom heading for visual composer.
 *
 * @since   1.0.0
 * @package Gecko
 */

function jas_gecko_vc_add_params_to_custom_heading() {
	vc_add_params(
		'vc_custom_heading',
		array(
			array(
				'param_name'  => 'sub_title',
				'heading'     => esc_html__( 'Small text', 'gecko' ),
				'description' => esc_html__( 'It shows below the Text', 'gecko' ),
				'type'        => 'textarea',
				'weight'      => 1,
			),
		)
	);
}
add_action( 'vc_after_init', 'jas_gecko_vc_add_params_to_custom_heading' );