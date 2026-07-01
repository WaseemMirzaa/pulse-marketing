<?php
/**
 * Initialize Color swatch.
 *
 * @since   1.0.0
 * @package Gecko
 */

if ( class_exists( 'WPA_WCVS' ) && class_exists( 'WooCommerce' ) && ! class_exists( 'ColorSwatch' ) ) {
	/**
	 * Change the HTML when click to color swatch.
	 *
	 * @since 1.0.0
	 */
	function jas_gecko_wcvs_modify_images() {
		global $post, $product;
		// Get image zoom
		$zoom = '';
		if ( cs_get_option( 'wc-single-zoom' ) ) {
			$zoom = ' jas-image-zoom';
		}
		?>
			<script>
				(function( $ ) {
					"use strict";
					
					jQuery('body').on('afterChange','.single-product-thumbnail .p-thumb', function(event, slick, currentSlide){
						var current = jQuery('.single-product-thumbnail .p-nav [data-slick-index="'+currentSlide+'"]');
						current.addClass('slick-current');
						current.siblings().removeClass('slick-current');
					});
					$( document.body ).off( 'wpa_wcvs_update_html' ).bind( 'wpa_wcvs_update_html', function( event, data ) {
						var productId     = data.pid,
							galleries     = $( '.variations_form' ).data( 'galleries' ),
							formData      = $( '.variations_form' ).data( 'product_variations' ),
							galleryKey    = '',
							selectedAttr  = {},
							usedImages    = [],
							output_gal    = [],
							output_thumb  = [],
							changeVariation = false,
							images;
						

						// Get selected size and color
						$( '#product-' + productId + ' .swatch select' ).each(function () {
							if ( $( this ).parent().parent().hasClass( 'is-color' ) ) {
								galleryKey = '_product_image_gallery_' + $( this ).data( 'attribute_name' ).replace( 'attribute_', '' ) + '-' + $( this ).val().toLowerCase();
								selectedAttr[$( this ).data( 'attribute_name' ).replace( 'attribute_', '' )] = $( this ).val();
							}
						});

						if ( typeof( galleries[galleryKey] ) !== 'undefined' && galleries[galleryKey] !== null ) {
							images = galleries[galleryKey];
						} else {
							images = galleries['default_gallery'];
							$.each( formData, function ( index, variation ) {
									$.each( selectedAttr, function ( attrName, attrValue ) {
									if ( variation['attributes']['attribute_' + attrName + ''] !== '' && variation['attributes']['attribute_' + attrName + ''] == attrValue && $.inArray( variation['image']['full_src'], usedImages ) === -1) {
										changeVariation = variation['image'];
										// image of variation
										output_gal += '<div class="p-item woocommerce-product-gallery__image <?php echo esc_attr($zoom); ?>">';
										output_gal += '<a href="' + changeVariation['full_src'] + '">';
										output_gal += '<img width="' + changeVariation['src_w'] + '" height="' + changeVariation['src_h'] + '" src="' + changeVariation['src'] + '" class="attachment-shop_single size-shop_single" data-src="' + changeVariation['src'] + '" data-large_image="' + changeVariation['full_src'] + '" data-large_image_width="' + changeVariation['full_src_w'] + '" data-large_image_height="' + changeVariation['full_src_h'] + '"/>';

										output_gal += '</a></div>';

										output_thumb += '<div>';
										output_thumb += '<img src="' + changeVariation['gallery_thumbnail_src'] + '" />';
										output_thumb += '</div>';
										
										usedImages.push( changeVariation['full_src'] );
									}
								});
							});
						}
						// Get image gallery
							$.each( images, function ( index, image ) {
								if ( image['single'] == undefined ) {
									var img_single = image['thumbnail'];
								} else {
									var img_single = image['single']; 
								}
	
							if ( $.inArray( img_single, usedImages ) === -1 ) {
								output_gal += '<div class="p-item woocommerce-product-gallery__image <?php echo esc_attr($zoom); ?>">';
								output_gal += '<a href="' + image['data-large_image'] + '">';
								output_gal += '<img width="' + image['single_w'] + '" height="' + image['single_h'] + '" src="' + img_single + '" class="attachment-shop_single size-shop_single" data-src="' + image['data-src'] + '" data-large_image="' + image['data-large_image'] + '" data-large_image_width="' + image['data-large_image_width'] + '" data-large_image_height="' + image['data-large_image_height'] + '"/>';
								output_gal += '</a></div>';

								output_thumb += '<div>';
								output_thumb += '<img src="' + image['thumbnail'] + '" />';
								output_thumb += '</div>';

								usedImages.push( img_single );

								if (changeVariation && changeVariation['gallery_thumbnail_src'] == image['thumbnail']) {
									changeVariation = index;
								}
							}
						});

						if ( $( '.jas-wc-single' ).is( '.wc-single-1, .wc-single-3' ) || window._inQuickview ) {
							var data_slick = '{"slidesToShow": 1,"slidesToScroll": 1,"asNavFor": ".p-nav","fade":true,"adaptiveHeight":true<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}';
						} else if ( $( '.jas-wc-single' ).is( '.wc-single-2' ) ) {
							var data_slick = '{"slidesToShow": 3,"slidesToScroll": 1,"centerMode":true<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>, "responsive":[{"breakpoint": 960,"settings":{"slidesToShow": 2, "centerMode":false<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}},{"breakpoint": 480,"settings":{"slidesToShow": 1, "centerMode":false<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}}]}';
						}

						var output = '<div class="p-thumb images jas-carousel" data-slick=\'' + data_slick + '\'>' + output_gal + '</div>';

						if ( $( '.jas-wc-single' ).hasClass( 'wc-single-1' ) ) {
							output += '<div class="p-nav oh jas-carousel" data-slick=\'{"slidesToShow": 4,"slidesToScroll": 1,"asNavFor": ".p-thumb","arrows": false, "focusOnSelect": true<?php echo ( is_rtl() ? ',"rtl":true' : '' ); ?>}\'>' + output_thumb + '</div>';
						}

						$( '#product-' + productId + ' .single-product-thumbnail' ).html( output );

						setTimeout(function() {
							$( '.jas-carousel' ).not( '.slick-initialized' ).slick();

							if ( $( '.jas-image-zoom' ).length > 0 ) {
								$( '.jas-image-zoom' ).zoom({
									touch: false,
								});
							}

							// Reset the index of image on product variation
							$( 'body' ).on( 'found_variation', '.variations_form', function( ev, variation ) {
								if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {
									$( '.jas-carousel' ).slick( 'slickGoTo', 0 );
								}
							});
						}, 10);

						// Trigger gallery
						if ( $( '.woocommerce-product-gallery' ).length > 0 && ! window._inQuickview ) {
							$( '.woocommerce-product-gallery' ).each( function () {
								$( this ).wc_product_gallery();
							});
							$( 'body' ).on( 'click', '.pswp__container, .pswp__button--close', function() {
								$( '.pswp' ).removeAttr( 'class' ).addClass( 'pswp' );
							});
						}

						<?php if ( isset( $options ) && ! empty( $options['wc-single-video-upload'] ) || ! empty( $options['wc-single-video-url'] ) ) : ?>
							output += '<div class="p-video pa">';
								<?php if ( $options['wc-single-video'] == 'url' ) { ?>
									output += '<a href="<?php echo esc_url( $options['wc-single-video-url'] ); ?>" class="br__50 tc db bghp jas-popup-url"><i class="pe-7s-play pr"></i></a>';
								<?php } else { ?>
									output += '<a href="#jas-vsh" class="br__50 tc db bghp jas-popup-mp4"><i class="pe-7s-play pr"></i></a>';
									output += '<div id="jas-vsh" class="mfp-hide"><?php do_shortcode( '[video src="' . esc_url( $options['wc-single-video-upload'] ) . '" width="640" height="320"]' ); ?></div>';
								<?php } ?>
							output +=  '</div>';
						<?php endif; ?>
					});
				})( jQuery );
			</script>
		<?php
	}
	add_action( 'wp_footer', 'jas_gecko_wcvs_modify_images', 1000 );
}