<?php
/**
 * Single post template — article layout with byline, share, and related posts.
 *
 * @package PulseLyft
 */

get_header();

while ( have_posts() ) :
	the_post();
	$cats     = get_the_category();
	$category = ! empty( $cats ) ? $cats[0]->name : __( 'Insights', 'pulselyft' );
	$blog_url = get_permalink( get_option( 'page_for_posts' ) );
	$permalink = get_permalink();
	$share_t   = rawurlencode( get_the_title() );
	$share_u   = rawurlencode( $permalink );
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

			<div class="pl-byline" style="margin-top:1.75rem;">
				<span class="pl-byline__avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?></span>
				<span>
					<span class="pl-byline__name"><?php echo esc_html( get_the_author() ); ?></span><br>
					<span class="pl-byline__date"><?php echo esc_html( get_the_date() ); ?> · <?php echo esc_html( pulselyft_read_time() ); ?></span>
				</span>
			</div>

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

			<div class="pl-share">
				<span class="pl-share__label"><?php esc_html_e( 'Share', 'pulselyft' ); ?></span>
				<a class="pl-share__btn" target="_blank" rel="noopener noreferrer" aria-label="Share on X" href="<?php echo esc_url( "https://twitter.com/intent/tweet?text={$share_t}&url={$share_u}" ); ?>">
					<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.66l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231 5.45-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/></svg>
				</a>
				<a class="pl-share__btn" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn" href="<?php echo esc_url( "https://www.linkedin.com/sharing/share-offsite/?url={$share_u}" ); ?>">
					<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M4.98 3.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5ZM3 9h4v12H3V9Zm6 0h3.8v1.64h.05c.53-.95 1.83-1.95 3.77-1.95 4.03 0 4.78 2.45 4.78 5.64V21H17.6v-5.3c0-1.26-.02-2.9-1.77-2.9-1.77 0-2.04 1.38-2.04 2.8V21H9V9Z"/></svg>
				</a>
				<a class="pl-share__btn" target="_blank" rel="noopener noreferrer" aria-label="Share by email" href="<?php echo esc_url( "mailto:?subject={$share_t}&body={$share_u}" ); ?>">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m4 7 8 6 8-6" stroke-linecap="round" stroke-linejoin="round"/></svg>
				</a>
			</div>

			<?php
			// Related posts from the same category.
			$related_ids = array();
			if ( ! empty( $cats ) ) {
				$related = new WP_Query( array(
					'category__in'        => array( $cats[0]->term_id ),
					'post__not_in'        => array( get_the_ID() ),
					'posts_per_page'      => 3,
					'ignore_sticky_posts' => true,
					'no_found_rows'       => true,
				) );
				if ( $related->have_posts() ) :
					?>
					<section class="pl-related">
						<h2 class="pl-related__title"><?php esc_html_e( 'Keep reading', 'pulselyft' ); ?></h2>
						<ul class="pl-blog__grid" style="margin-top:1.5rem;">
							<?php
							while ( $related->have_posts() ) :
								$related->the_post();
								get_template_part( 'template-parts/post-card' );
							endwhile;
							?>
						</ul>
					</section>
					<?php
					wp_reset_postdata();
				endif;
			}
			?>

			<div class="pl-postcta">
				<p class="pl-postcta__title"><?php esc_html_e( 'Want help running this in your stack?', 'pulselyft' ); ?></p>
				<p class="pl-postcta__sub"><?php esc_html_e( 'Book a call or send a note—we reply within one business day.', 'pulselyft' ); ?></p>
				<div class="pl-postcta__row">
					<a href="<?php echo esc_url( home_url( '/#book-call' ) ); ?>" class="pl-btn pl-btn--primary"><?php esc_html_e( 'Book a call', 'pulselyft' ); ?></a>
					<?php
					$contact = function_exists( 'pulselyft_page_url' ) ? pulselyft_page_url( 'contact' ) : '';
					?>
					<a href="<?php echo esc_url( $contact ? $contact : home_url( '/#contact' ) ); ?>" class="pl-btn pl-btn--secondary"><?php esc_html_e( 'Contact', 'pulselyft' ); ?></a>
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
