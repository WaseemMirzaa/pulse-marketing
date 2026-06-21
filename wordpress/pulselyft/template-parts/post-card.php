<?php
/**
 * Reusable blog post card (archive / index loops).
 *
 * @package PulseLyft
 */

$cats     = get_the_category();
$category = ! empty( $cats ) ? $cats[0]->name : __( 'Insights', 'pulselyft' );
?>
<li class="pl-reveal">
	<a href="<?php the_permalink(); ?>" class="pl-post">
		<?php if ( has_post_thumbnail() ) : ?>
			<div class="pl-post__media">
				<?php the_post_thumbnail( 'large', array( 'alt' => the_title_attribute( array( 'echo' => false ) ), 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
			</div>
		<?php endif; ?>
		<div class="pl-post__body">
			<div class="pl-post__meta">
				<span class="pl-post__cat"><?php echo esc_html( $category ); ?></span>
				<span><?php echo esc_html( get_the_date() ); ?></span>
				<span><?php echo esc_html( pulselyft_read_time() ); ?></span>
			</div>
			<h3 class="pl-post__title"><?php the_title(); ?></h3>
			<p class="pl-post__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 22 ) ); ?></p>
			<span class="pl-post__more"><?php esc_html_e( 'Read article →', 'pulselyft' ); ?></span>
		</div>
	</a>
</li>
