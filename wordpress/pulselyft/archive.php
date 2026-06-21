<?php
/**
 * Archive template (categories, tags, dates, author).
 *
 * @package PulseLyft
 */

get_header();

$desc = get_the_archive_description();
pulselyft_page_hero(
	__( 'Archive', 'pulselyft' ),
	wp_strip_all_tags( get_the_archive_title() ),
	$desc ? wp_strip_all_tags( $desc ) : ''
);
?>

<div class="pl-blogwrap">
	<div class="pl-container">
		<?php if ( have_posts() ) : ?>
			<ul class="pl-blog__grid">
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
			<p class="pl-lede"><?php esc_html_e( 'Nothing here yet.', 'pulselyft' ); ?></p>
		<?php endif; ?>
	</div>
</div>
<?php
get_footer();
