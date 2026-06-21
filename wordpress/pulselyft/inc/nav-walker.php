<?php
/**
 * Minimal nav walker that renders plain anchor tags (no <ul>/<li> wrappers) so
 * the WordPress menu matches the flat, flex-based header from the web app.
 *
 * @package PulseLyft
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Pulselyft_Link_Walker
 */
class Pulselyft_Link_Walker extends Walker_Nav_Menu {

	/**
	 * CSS class applied to each anchor.
	 *
	 * @var string
	 */
	protected $link_class;

	/**
	 * Constructor.
	 *
	 * @param string $link_class Anchor class. Defaults to the desktop nav link.
	 */
	public function __construct( $link_class = 'pl-nav__link' ) {
		$this->link_class = $link_class;
	}

	/**
	 * No nested lists.
	 *
	 * @param string $output Output.
	 * @param int    $depth  Depth.
	 * @param array  $args   Args.
	 */
	public function start_lvl( &$output, $depth = 0, $args = null ) {}

	/**
	 * No nested list close.
	 *
	 * @param string $output Output.
	 * @param int    $depth  Depth.
	 * @param array  $args   Args.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {}

	/**
	 * Render a single anchor.
	 *
	 * @param string   $output Output.
	 * @param WP_Post  $item   Menu item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 * @param int      $id     ID.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$url   = ! empty( $item->url ) ? $item->url : '#';
		$title = apply_filters( 'the_title', $item->title, $item->ID );
		$output .= sprintf(
			'<a class="%1$s" href="%2$s">%3$s</a>',
			esc_attr( $this->link_class ),
			esc_url( $url ),
			esc_html( $title )
		);
	}

	/**
	 * No closing tag needed beyond the anchor.
	 *
	 * @param string   $output Output.
	 * @param WP_Post  $item   Item.
	 * @param int      $depth  Depth.
	 * @param stdClass $args   Args.
	 */
	public function end_el( &$output, $item, $depth = 0, $args = null ) {}
}
