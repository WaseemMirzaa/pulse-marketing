<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;

$class = $data = $sizer = '';

global $jassc;

// Get wc layout
$class = '';

$term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
if ( $term ) {
	$term_options = get_term_meta( $term->term_id, '_custom_product_cat_options', true );
}
if ( is_product_category() && isset( $term_options ) && $term_options && $term_options['product-cat-layout'] ) {
	$layout = $term_options['product-cat-layout'];
	$sidebar = $term_options['product-cat-sidebar'];
} else {
	$layout = cs_get_option( 'wc-layout' );
	$sidebar = cs_get_option( 'wc-sidebar' );
}

if ( cs_get_option( 'wc-sub-cat-layout' ) == 'masonry' ) {
	$class = 'jas-masonry';
	$data  = 'data-masonry=\'{"selector":".product", "columnWidth":".grid-sizer","layoutMode":"masonry"}\'';
	$sizer = '<div class="grid-sizer size-' . cs_get_option( 'wc-sub-cat-column' ) . '"></div>';
}
get_header( 'shop' ); ?>
	<?php
		/**
		 * woocommerce_before_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

	<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

		<h1 class="woocommerce-products-header__title page-title"><?php woocommerce_page_title(); ?></h1>

	<?php endif; ?>
	
	<?php
		/**
		 * woocommerce_archive_description hook.
		 *
		 * @hooked woocommerce_taxonomy_archive_description - 10
		 * @hooked woocommerce_product_archive_description - 10
		 */
		do_action( 'woocommerce_archive_description' );
	?>

	<?php if ( have_posts() ) : ?>
		<?php if ( is_product_category() && get_option( 'woocommerce_category_archive_display' ) ) { ?>
			<div class="jas-container sub-categories">
				<div class="jas-row <?php echo esc_attr( $class ); ?>" <?php echo wp_kses_post( $data ); ?>>
					<?php
						echo wp_kses_post( $sizer );
						woocommerce_product_subcategories();
					?>
				</div>
			</div>
		<?php } ?>
		<?php if ( ! is_product_category() && get_option( 'woocommerce_shop_page_display' ) ) { ?>
			<div class="jas-container sub-categories">
				<div class="jas-row <?php echo esc_attr( $class ); ?>" <?php echo wp_kses_post( $data ); ?>>
					<?php
						echo wp_kses_post( $sizer );
						woocommerce_product_subcategories();
					?>
				</div>
			</div>
		<?php } ?>

		<?php wc_print_notices(); ?>

		<?php if ( ! $jassc ) echo '<div class="jas-container">'; ?>
			<?php
				if ( $layout != 'no-sidebar' && ! $jassc ) {
					echo '<div class="jas-row"><div class="jas-col-md-9 jas-col-sm-9 jas-col-xs-12">';
				}
			?>

				<?php
					/**
					 * woocommerce_before_shop_loop hook.
					 *
					 * @hooked woocommerce_result_count - 20
					 * @hooked woocommerce_catalog_ordering - 30
					 */
					do_action( 'woocommerce_before_shop_loop' );
				?>
				<div class="jas-top-sidebar">
					<div class="jas-container">
						<?php
							if ( is_active_sidebar( 'wc-top' ) ) {
								dynamic_sidebar( 'wc-top' );
							}
						?>
					</div>
				</div>
				<?php woocommerce_product_loop_start(); ?>
				
					<?php
					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) : the_post(); ?>

							<?php
								/**
								 * woocommerce_shop_loop hook.
								 *
								 * @hooked WC_Structured_Data::generate_product_data() - 10
								 */
								do_action( 'woocommerce_shop_loop' );
							?>

							<?php wc_get_template( 'content-product.php' ); ?>

					 	<?php endwhile; ?>

				 <?php } ?>

				<?php woocommerce_product_loop_end(); ?>

			<?php if ( $layout == 'right-sidebar' ) {
				$class = 'jas-col-md-3 jas-col-sm-3 jas-col-xs-12 mt__30';
			} elseif ( $layout == 'left-sidebar' ) {
				$class = 'jas-col-md-3 jas-col-sm-3 jas-col-xs-12 mt__30 first-md first-sm';
			}
				if ( $layout != 'no-sidebar' && ! $jassc ) {

					// Render pagination
					do_action( 'jas_pagination' );

					//woocommerce_after_shop_loop hook.
					do_action( 'woocommerce_after_shop_loop' );
					
					echo '</div><!-- .jas-columns-* -->';

					echo '<div class="' . esc_attr( $class ) . '">';
						if ( is_active_sidebar( $sidebar ) ) {
							dynamic_sidebar( $sidebar );
						}
					echo '</div>';
				}
			?>
			</div><!-- .jas-row -->
		
			<?php
				if ( $layout == 'no-sidebar' && ! $jassc ) {
					do_action( 'jas_pagination' );

					//woocommerce_after_shop_loop hook.
					do_action( 'woocommerce_after_shop_loop' );
				}
			?>

	<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

		<?php wc_get_template( 'loop/no-products-found.php' ); ?>

	<?php endif; ?>

<?php
	/**
	 * woocommerce_after_main_content hook.
	 *
	 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
	 */
	do_action( 'woocommerce_after_main_content' );
?>
<?php get_footer( 'shop' ); ?>
