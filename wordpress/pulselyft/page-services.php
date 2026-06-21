<?php
/**
 * Template for the Services page (slug "services").
 *
 * Editable in wp-admin: Title → hero heading, Excerpt → hero sub, Content →
 * intro copy. The services grid, checklist, process, and metrics come from the
 * content tree / Customizer.
 *
 * @package PulseLyft
 */

get_header();

$s        = pulselyft_get( 'pages.services' );
$included = isset( $s['included'] ) ? $s['included'] : array();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post();
		$sub = has_excerpt() ? get_the_excerpt() : $s['sub'];
		pulselyft_page_hero( $s['kicker'], get_the_title(), $sub );
		pulselyft_editable_intro();
	endwhile;
endif;

pulselyft_section( 'services' );

if ( $included ) :
	?>
	<section class="pl-section pl-section--paper pl-section--bordered" aria-labelledby="pl-svc-included">
		<div class="pl-container">
			<div class="pl-reveal">
				<p class="pl-kicker pl-kicker--lift"><?php esc_html_e( 'What is included', 'pulselyft' ); ?></p>
				<h2 id="pl-svc-included" class="pl-h2 pl-balance"><?php esc_html_e( 'Everything you need to scale, in one team', 'pulselyft' ); ?></h2>
			</div>
			<ul class="pl-features">
				<?php foreach ( $included as $item ) : ?>
					<li class="pl-feature pl-reveal">
						<span class="pl-feature__check" aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 13l4 4L19 7" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</span>
						<div>
							<h3 class="pl-feature__title"><?php echo esc_html( $item['title'] ); ?></h3>
							<p class="pl-feature__body"><?php echo esc_html( $item['body'] ); ?></p>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</section>
	<?php
endif;

pulselyft_section( 'process' );
pulselyft_section( 'metrics' );
pulselyft_section( 'cta-band' );

get_footer();
