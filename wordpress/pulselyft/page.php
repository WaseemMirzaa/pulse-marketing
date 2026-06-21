<?php
/**
 * Generic page template.
 *
 * @package PulseLyft
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>
	<article class="pl-page-wrap">
		<div class="pl-article">
			<h1 class="pl-article__title pl-balance"><?php the_title(); ?></h1>
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
			if ( comments_open() || get_comments_number() ) {
				comments_template();
			}
			?>
		</div>
	</article>
	<?php
endwhile;

get_footer();
