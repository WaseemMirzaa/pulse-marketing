<?php
/**
 * Blog teaser — pulls recent WP posts, falls back to default articles.
 *
 * @package PulseLyft
 */

$kicker = pulselyft_get( 'blog.kicker' );
$title  = pulselyft_get( 'blog.title' );
$intro  = pulselyft_get( 'blog.intro' );
$posts  = pulselyft_recent_posts( 3 );
if ( ! $posts ) {
	return;
}
$blog_url = get_permalink( get_option( 'page_for_posts' ) );
if ( ! $blog_url ) {
	$blog_url = '#contact';
}
?>
<section id="blog" class="pl-section pl-section--page pl-scroll-anchor" aria-labelledby="pl-blog-title">
	<div class="pl-container">
		<div class="pl-sec-head pl-reveal" style="align-items:flex-end;">
			<div class="pl-sec-head__main">
				<p class="pl-kicker pl-kicker--lift"><?php echo esc_html( $kicker ); ?></p>
				<h2 id="pl-blog-title" class="pl-h2 pl-balance"><?php echo esc_html( $title ); ?></h2>
				<p class="pl-lede" style="margin-top:1rem;max-width:36rem;"><?php echo esc_html( $intro ); ?></p>
			</div>
			<a href="<?php echo esc_url( $blog_url ); ?>" class="pl-btn pl-btn--secondary pl-btn--sm"><?php esc_html_e( 'View all posts', 'pulselyft' ); ?> <span aria-hidden="true">→</span></a>
		</div>

		<ul class="pl-blog__grid">
			<?php foreach ( $posts as $post ) : ?>
				<li class="pl-reveal">
					<a href="<?php echo esc_url( $post['href'] ); ?>" class="pl-post">
						<?php if ( ! empty( $post['img'] ) ) : ?>
							<div class="pl-post__media">
								<img src="<?php echo esc_url( $post['img'] ); ?>" alt="<?php echo esc_attr( $post['title'] ); ?>" loading="lazy" decoding="async">
							</div>
						<?php endif; ?>
						<div class="pl-post__body">
							<div class="pl-post__meta">
								<span class="pl-post__cat"><?php echo esc_html( $post['category'] ); ?></span>
								<span><?php echo esc_html( $post['readTime'] ); ?></span>
							</div>
							<h3 class="pl-post__title"><?php echo esc_html( $post['title'] ); ?></h3>
							<p class="pl-post__excerpt"><?php echo esc_html( $post['excerpt'] ); ?></p>
							<span class="pl-post__more"><?php esc_html_e( 'Read article →', 'pulselyft' ); ?></span>
						</div>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
