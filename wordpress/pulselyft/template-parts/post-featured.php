<?php
/**
 * Featured lead post (first post on the blog index, page 1).
 *
 * @package PulseLyft
 */

$cats     = get_the_category();
$category = ! empty( $cats ) ? $cats[0]->name : __( 'Insights', 'pulselyft' );
?>
<a href="<?php the_permalink(); ?>" class="pl-feat pl-reveal">
	<div class="pl-feat__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'large', array( 'alt' => the_title_attribute( array( 'echo' => false ) ), 'loading' => 'eager', 'decoding' => 'async' ) ); ?>
		<?php endif; ?>
		<span class="pl-feat__flag"><?php esc_html_e( 'Featured', 'pulselyft' ); ?></span>
	</div>
	<div class="pl-feat__body">
		<div class="pl-post__meta">
			<span class="pl-post__cat"><?php echo esc_html( $category ); ?></span>
			<span><?php echo esc_html( get_the_date() ); ?></span>
			<span><?php echo esc_html( pulselyft_read_time() ); ?></span>
		</div>
		<h2 class="pl-feat__title"><?php the_title(); ?></h2>
		<p class="pl-feat__excerpt"><?php echo esc_html( wp_trim_words( get_the_excerpt(), 34 ) ); ?></p>
		<span class="pl-byline">
			<span class="pl-byline__avatar"><?php echo get_avatar( get_the_author_meta( 'ID' ), 64 ); ?></span>
			<span>
				<span class="pl-byline__name"><?php echo esc_html( get_the_author() ); ?></span><br>
				<span class="pl-byline__date"><?php echo esc_html( get_the_date() ); ?></span>
			</span>
		</span>
	</div>
</a>
