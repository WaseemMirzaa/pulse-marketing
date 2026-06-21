<?php
/**
 * Template for the About page (auto-applied to the page with slug "about").
 *
 * Editable in wp-admin: the page Title drives the hero heading, the Excerpt
 * drives the hero sub-headline, and the page Content (the_content) drives the
 * "Our story" copy. Structured blocks (values, metrics, testimonials) come from
 * the content tree / Customizer.
 *
 * @package PulseLyft
 */

get_header();

$a      = pulselyft_get( 'pages.about' );
$values = isset( $a['values'] ) ? $a['values'] : array();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$sub = has_excerpt() ? get_the_excerpt() : $a['sub'];
		pulselyft_page_hero( $a['kicker'], get_the_title(), $sub );
		?>
		<section class="pl-section pl-section--paper pl-section--bordered" aria-labelledby="pl-about-story">
			<div class="pl-container">
				<div class="pl-split">
					<div class="pl-split__aside--4 pl-reveal">
						<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'Our story', 'pulselyft' ); ?></p>
						<h2 id="pl-about-story" class="pl-h2 pl-balance"><?php echo esc_html( $a['storyHeading'] ); ?></h2>
					</div>
					<div class="pl-split__main--8 pl-reveal">
						<div class="pl-prose entry-content" style="margin-top:0;"><?php the_content(); ?></div>
					</div>
				</div>
			</div>
		</section>
		<?php
	endwhile;
endif;

if ( $values ) :
	?>
	<section class="pl-section pl-section--page" aria-labelledby="pl-about-values">
		<div class="pl-container">
			<div class="pl-reveal">
				<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'Principles', 'pulselyft' ); ?></p>
				<h2 id="pl-about-values" class="pl-h2 pl-balance"><?php esc_html_e( 'How we operate', 'pulselyft' ); ?></h2>
			</div>
			<ul class="pl-values">
				<?php foreach ( $values as $i => $v ) : ?>
					<li class="pl-value pl-reveal">
						<span class="pl-value__n" aria-hidden="true"><?php echo esc_html( str_pad( (string) ( $i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<h3 class="pl-value__title"><?php echo esc_html( $v['title'] ); ?></h3>
						<p class="pl-value__body"><?php echo esc_html( $v['body'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php
endif;

pulselyft_section( 'metrics' );
pulselyft_section( 'testimonials' );
pulselyft_section( 'cta-band' );

get_footer();
