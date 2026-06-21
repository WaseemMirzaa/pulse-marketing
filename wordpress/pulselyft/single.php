<?php
/**
 * Single post template — matches the web app's article layout.
 *
 * @package PulseLyft
 */

get_header();

while ( have_posts() ) :
	the_post();
	$cats     = get_the_category();
	$category = ! empty( $cats ) ? $cats[0]->name : __( 'Insights', 'pulselyft' );
	$blog_url = get_permalink( get_option( 'page_for_posts' ) );
	?>
	<article class="pl-page-wrap">
		<div class="pl-article">
			<?php if ( $blog_url ) : ?>
				<a href="<?php echo esc_url( $blog_url ); ?>" class="pl-article__back"><?php esc_html_e( '← Back to blog', 'pulselyft' ); ?></a>
			<?php endif; ?>

			<div class="pl-article__meta">
				<span class="pl-post__cat"><?php echo esc_html( $category ); ?></span>
				<span><?php echo esc_html( get_the_date() ); ?></span>
				<span><?php echo esc_html( pulselyft_read_time() ); ?></span>
			</div>

			<h1 class="pl-article__title pl-balance"><?php the_title(); ?></h1>

			<?php if ( has_excerpt() ) : ?>
				<p class="pl-hero__sub" style="margin-top:1.5rem;"><?php echo esc_html( get_the_excerpt() ); ?></p>
			<?php endif; ?>

			<?php if ( has_post_thumbnail() ) : ?>
				<div class="pl-article__hero">
					<?php the_post_thumbnail( 'large', array( 'decoding' => 'async' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="pl-prose">
				<?php
				the_content();
				wp_link_pages( array(
					'before' => '<div class="pl-pagination">',
					'after'  => '</div>',
				) );
				?>
			</div>

			<?php
			$tags = get_the_tag_list( '<div class="pl-article__meta" style="margin-top:2rem;">', '', '</div>' );
			if ( $tags ) {
				echo wp_kses_post( $tags );
			}
			?>

			<div class="pl-postcta">
				<p class="pl-postcta__title"><?php esc_html_e( 'Want help running this in your stack?', 'pulselyft' ); ?></p>
				<p class="pl-postcta__sub"><?php esc_html_e( 'Book a call or send a note—we reply within one business day.', 'pulselyft' ); ?></p>
				<div class="pl-postcta__row">
					<a href="<?php echo esc_url( home_url( '/#book-call' ) ); ?>" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?></a>
					<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="pl-btn pl-btn--secondary"><?php esc_html_e( 'Contact', 'pulselyft' ); ?></a>
				</div>
			</div>

			<?php
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
