<?php
/**
 * Fallback template (also used for the blog posts index).
 *
 * @package PulseLyft
 */

get_header();
?>
<div class="pl-archive">
	<div class="pl-container">
		<header class="pl-archive__head pl-reveal">
			<?php if ( is_home() && ! is_front_page() ) : ?>
				<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'Blog', 'pulselyft' ); ?></p>
				<h1 class="pl-h2"><?php echo esc_html( get_the_title( get_option( 'page_for_posts' ) ) ? get_the_title( get_option( 'page_for_posts' ) ) : __( 'Insights', 'pulselyft' ) ); ?></h1>
			<?php else : ?>
				<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'Latest', 'pulselyft' ); ?></p>
				<h1 class="pl-h2"><?php esc_html_e( 'From the studio', 'pulselyft' ); ?></h1>
			<?php endif; ?>
		</header>

		<?php if ( have_posts() ) : ?>
			<ul class="pl-blog__grid" style="margin-top:3.5rem;">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/post-card' );
				endwhile;
				?>
			</ul>
			<?php
			the_posts_pagination( array(
				'mid_size'  => 1,
				'prev_text' => __( '← Newer', 'pulselyft' ),
				'next_text' => __( 'Older →', 'pulselyft' ),
				'class'     => 'pl-pagination',
			) );
			?>
		<?php else : ?>
			<p class="pl-lede" style="margin-top:2rem;"><?php esc_html_e( 'No posts yet — check back soon.', 'pulselyft' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
