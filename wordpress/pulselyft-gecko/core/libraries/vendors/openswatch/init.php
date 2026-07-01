<?php
/**
 * Initialize openswatch.
 *
 * @since   1.0.0
 * @package Gecko
 */

if ( class_exists( 'ColorSwatch' ) && class_exists( 'WooCommerce' ) ) {
	/**
	 * Change default template folder of openswatch.
	 *
	 * @since 1.0.0
	 */
	function jas_gecko_os_locate_template( $located, $template_name, $args, $template_path, $default_path ) {
		if ( $template_name == 'single-product/add-to-cart/variable.php' ) {
			global $post;

			$tmp = get_post_meta( $post->ID, '_allow_openswatch', true );
			if ( $tmp != 0 ) {
				return JAS_GECKO_PATH . '/core/libraries/vendors/openswatch/templates/variable.php';
			}
		}
		return $located;
	}
	add_filter( 'wc_get_template','jas_gecko_os_locate_template', 20, 5 );

	/**
	 * Change image variable for openswatch.
	 *
	 * @since 1.0.0
	 */
	function jas_gecko_os_images( $images, $productId, $attachment_ids ) {
		// Count attachment
		$attachment_ids   = array_filter( $attachment_ids );
		$attachment_count = count( $attachment_ids );
		if ( $attachment_count > 0 ) {

			// Get page options
			$options = get_post_meta( $productId, '_custom_wc_options', true );

			// Get product single style
			$style = ( isset( $options ) && $options['wc-single-style'] ) ? $options['wc-single-style'] : cs_get_option( 'wc-single-style' );

			if ( $style == '1' || $style == '3' ) {
				$attr = 'data-slick=\'{"slidesToShow": 1, "slidesToScroll": 1, "asNavFor": ".p-nav", "fade":true'. ( is_rtl() ? ',"rtl":true' : '' ) .'}\'';
			} elseif ( $style == 2 ) {
				$attr = 'data-slick=\'{"slidesToShow": 3,"slidesToScroll": 1,"centerMode":true, "responsive":[{"breakpoint": 960,"settings":{"slidesToShow": 2, "centerMode":false}},{"breakpoint": 480,"settings":{"slidesToShow": 1, "centerMode":false}}]'. ( is_rtl() ? ',"rtl":true' : '' ) .'}\'';
			}
			?>
			<div class="p-thumb images jas-carousel" <?php echo wp_kses_post( $attr ); ?>>
				<?php
				if ( $attachment_ids ) {
					foreach ( $attachment_ids as $attachment_id ) {
						$image_link = wp_get_attachment_url( $attachment_id );
						if ( ! $image_link )
							continue;

						$image_title   = esc_attr( get_the_title( $attachment_id ) );
						$image_caption = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );
						$attr = array(
							'alt'      => $image_title,
							'data-src' => $image_link
						);

						$image = wp_get_attachment_image(
							$attachment_id,
							apply_filters( 'single_product_small_thumbnail_size', 'shop_single' ), 0,
							$attr
						);

						$zoom = '';
						if ( cs_get_option( 'wc-single-zoom' ) ) {
							$zoom = ' jas-image-zoom';
						}

						echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="p-item woocommerce-product-gallery__image' . $zoom . '"><a href="%s" itemprop="image" class="woocommerce-product-gallery__trigger" title="%s">%s</a></div>', $image_link, $image_caption, $image ), $attachment_id, $productId );
					}
				}
				?>
			</div>

			<?php if ( $style == 1 && $attachment_ids ) { ?>
				<div class="p-nav oh jas-carousel"
					 data-slick='{"slidesToShow": 4,"slidesToScroll": 1,"asNavFor": ".p-thumb","arrows": false, "focusOnSelect": true}'>
					<?php
						foreach ( $attachment_ids as $attachment_id ) {
							$image_link = wp_get_attachment_url( $attachment_id );

							if ( ! $image_link )
								continue;

							$image_title   = esc_attr( get_the_title( $attachment_id ) );
							$image_caption = esc_attr( get_post_field( 'post_excerpt', $attachment_id ) );

							$image = wp_get_attachment_image($attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $attr = array(
								'title'    => $image_title,
								'alt'      => $image_title,
								'data-src' => $image_link
							) );

							echo apply_filters( 'woocommerce_single_product_image_thumbnail_html', sprintf( '<div class="p-item">%s</div>', $image ), $attachment_id, $productId );
						}
					?>
				</div>
			<?php }
		}
	}
	add_filter( 'openswatch_image_swatch_html', 'jas_gecko_os_images', 20, 3 );
}