<?php
/**
 * Add element slider for VC.
 *
 * @since   1.5.2
 * @package Gecko
 */

function jas_gecko_vc_map_slider() {
	vc_map(
		array(
			'name'     => esc_html__( 'Simple slider', 'gecko' ),
			'description' => esc_html__( 'Simple slider element', 'gecko' ),
			'base'     => 'jas_slider',
			'icon'     => 'pe-7s-look',
			'category' => esc_html__( 'Content', 'gecko' ),
			'params'   => array(
				array(
					'param_name' => 'autoplay',
					'heading'    => esc_html__( 'Enable auto play', 'gecko' ),
					'type'       => 'checkbox'
				),
				array(
					'param_name' => 'arrows',
					'heading'    => esc_html__( 'Enable navigation', 'gecko' ),
					'type'       => 'checkbox'
				),
				array(
					'param_name' => 'dots',
					'heading'    => esc_html__( 'Enable pagination', 'gecko' ),
					'type'       => 'checkbox'
				),
				array(
					'param_name' => 'fade',
					'heading'    => esc_html__( 'Enable fade', 'gecko' ),
					'type'       => 'checkbox'
				),
				array(
					'param_name' => 'slide',
					'heading'    => esc_html__( 'Slide', 'gecko' ),
					'type'       => 'param_group',
					'params'     => array(
						array(
							'param_name' => 'image',
							'heading'    => esc_html__( 'Image', 'gecko' ),
							'type'       => 'attach_image'
						),
						array(
							'param_name' => 'v_align',
							'heading'    => esc_html__( 'Content vertical align', 'gecko' ),
							'type'       => 'dropdown',
							'value'      => array(
								esc_html__( 'Top', 'gecko' )    => 'top',
								esc_html__( 'Middle', 'gecko' ) => 'middle',
								esc_html__( 'Bottom', 'gecko' ) => 'bottom'
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column-with-padding'
						),
						array(
							'param_name' => 'h_align',
							'heading'    => esc_html__( 'Content horizontal align', 'gecko' ),
							'type'       => 'dropdown',
							'value'      => array(
								esc_html__( 'Left', 'gecko' )   => 'left',
								esc_html__( 'Center', 'gecko' ) => 'center',
								esc_html__( 'Right', 'gecko' )  => 'right'
							),
							'edit_field_class' => 'vc_col-sm-6 vc_column'
						),
						array(
							'param_name' => 'big_text',
							'heading'    => esc_html__( 'The first text', 'gecko' ),
							'type'       => 'textfield',
						),
						array(
							'param_name'       => 'big_text_font_size',
							'heading'          => esc_html__( 'The first text font size', 'gecko' ),
							'type'             => 'textfield',
							'description'      => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'gecko' ),
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name'       => 'big_text_line_height',
							'heading'          => esc_html__( 'The first text line height', 'gecko' ),
							'type'             => 'textfield',
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name'       => 'big_text_margin',
							'heading'          => esc_html__( 'The first text margin bottom', 'gecko' ),
							'type'             => 'textfield',
							'description'      => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'gecko' ),
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name'       => 'big_text_color',
							'heading'          => esc_html__( 'The first text color', 'gecko' ),
							'type'             => 'colorpicker',
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name' => 'small_text',
							'heading'    => esc_html__( 'The second text', 'gecko' ),
							'type'       => 'textfield',
						),
						array(
							'param_name'       => 'small_text_font_size',
							'heading'          => esc_html__( 'The second text font size', 'gecko' ),
							'type'             => 'textfield',
							'description'      => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'gecko' ),
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name'       => 'small_text_line_height',
							'heading'          => esc_html__( 'The second text line height', 'gecko' ),
							'type'             => 'textfield',
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name'       => 'small_text_margin',
							'heading'          => esc_html__( 'The second text margin bottom', 'gecko' ),
							'type'             => 'textfield',
							'description'      => esc_html__( 'Defined in pixels. Do not add the \'px\' unit.', 'gecko' ),
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name'       => 'small_text_color',
							'heading'          => esc_html__( 'The second text color', 'gecko' ),
							'type'             => 'colorpicker',
							'edit_field_class' => 'vc_col-sm-3 vc_column',
						),
						array(
							'param_name' => 'cta_text',
							'heading'    => esc_html__( 'CTA', 'gecko' ),
							'type'       => 'textfield',
						),
						array(
							'param_name' => 'cta_link',
							'heading'    => esc_html__( 'Link to', 'gecko' ),
							'type'       => 'vc_link'
						),
					)
				),
				array(
					'param_name'  => 'class',
					'heading'     => esc_html__( 'Extra class name', 'gecko' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'gecko' ),
					'type' 	      => 'textfield',
				)
			)
		)
	);
}
add_action( 'vc_before_init', 'jas_gecko_vc_map_slider' );