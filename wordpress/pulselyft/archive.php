<?php
/**
 * Archive template (categories, tags, dates, author).
 *
 * @package PulseLyft
 */

get_header();
?>
<div class="pl-archive">
	<div class="pl-container">
		<header class="pl-archive__head pl-reveal">
			<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'Archive', 'pulselyft' ); ?></p>
			<h1 class="pl-h2"><?php the_archive_title(); ?></h1>
			<?php if ( get_the_archive_description() ) : ?>
				<div class="pl-lede" style="margin-top:1rem;"><?php the_archive_description(); ?></div>
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
			) );
			?>
		<?php else : ?>
			<p class="pl-lede" style="margin-top:2rem;"><?php esc_html_e( 'Nothing here yet.', 'pulselyft' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
