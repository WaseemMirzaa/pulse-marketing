<?php
/**
 * Blog index (posts page) + fallback template.
 *
 * @package PulseLyft
 */

get_header();

$posts_page = (int) get_option( 'page_for_posts' );
$blog_title = ( is_home() && $posts_page ) ? get_the_title( $posts_page ) : __( 'Insights', 'pulselyft' );
$paged      = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

pulselyft_page_hero(
	__( 'Blog', 'pulselyft' ),
	$blog_title,
	__( 'Playbooks for paid, search, and measurement — practical notes from the programs we run. No fluff, no recycled listicles.', 'pulselyft' )
);
?>

<div class="pl-blogwrap">
	<div class="pl-container">
		<?php
		$cats = get_categories( array( 'orderby' => 'count', 'order' => 'DESC', 'number' => 6 ) );
		if ( $cats && ! is_wp_error( $cats ) ) :
			?>
			<div class="pl-blog-head pl-reveal" style="margin-bottom:2.5rem;">
				<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'Latest articles', 'pulselyft' ); ?></p>
				<nav class="pl-blog-cats" aria-label="<?php esc_attr_e( 'Categories', 'pulselyft' ); ?>">
					<?php foreach ( $cats as $cat ) : ?>
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>"><?php echo esc_html( $cat->name ); ?></a>
					<?php endforeach; ?>
				</nav>
			</div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
			<?php
			$show_featured = ( 1 === $paged );
			$grid_open     = false;
			while ( have_posts() ) :
				the_post();
				if ( $show_featured ) {
					get_template_part( 'template-parts/post-featured' );
					$show_featured = false;
					continue;
				}
				if ( ! $grid_open ) {
					echo '<ul class="pl-blog__grid" style="margin-top:1.5rem;">';
					$grid_open = true;
				}
				get_template_part( 'template-parts/post-card' );
			endwhile;
			if ( $grid_open ) {
				echo '</ul>';
			}

			the_posts_pagination( array(
				'mid_size'  => 1,
				'prev_text' => __( '← Newer', 'pulselyft' ),
				'next_text' => __( 'Older →', 'pulselyft' ),
			) );
			?>
		<?php else : ?>
			<p class="pl-lede"><?php esc_html_e( 'No posts yet — check back soon.', 'pulselyft' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
