<?php
/**
 * Brand Color Overrides
 *
 * Reads configured brand colors from the Customizer (Appearance → Customize
 * → Theme Settings → Brand Colors), with ACF Options taking precedence when
 * ACF is active and a value is set. Outputs CSS custom property overrides
 * via wp_add_inline_style. Falls back silently to the hardcoded defaults in
 * main.css when values match the defaults.
 */

defined( 'ABSPATH' ) || exit;

add_action( 'wp_enqueue_scripts', function () {

	/*
	 * Map: setting key => [ ACF field name, CSS custom property, default ].
	 *
	 * The default values match main.css :root so an untouched value produces
	 * no override — the stylesheet value wins automatically.
	 */
	$tokens = [
		'color_primary'       => [ 'brand_primary',       '--fc-green',       '#1B7A5A' ],
		'color_primary_dark'  => [ 'brand_primary_dark',  '--fc-green-dark',  '#145C43' ],
		'color_primary_light' => [ 'brand_primary_light', '--fc-green-light', '#2E936F' ],
		'color_cream'         => [ 'brand_cream',         '--fc-cream',       '#FAF8F5' ],
		'color_sand'          => [ 'brand_sand',          '--fc-sand',        '#F3EDE4' ],
	];

	$has_acf   = function_exists( 'get_field' );
	$overrides = [];
	$cream     = '';

	foreach ( $tokens as $key => list( $acf_field, $prop, $default ) ) {
		// ACF option (legacy) wins when set; otherwise the Customizer value.
		$value = $has_acf ? get_field( $acf_field, 'option' ) : '';
		if ( ! $value ) {
			$value = fc_setting( $key );
		}

		$safe = $value ? sanitize_hex_color( trim( (string) $value ) ) : '';

		if ( 'color_cream' === $key && $safe ) {
			$cream = $safe;
		}

		// Only output an override when the value differs from the default.
		if ( $safe && strtolower( $safe ) !== strtolower( $default ) ) {
			$overrides[] = $prop . ':' . $safe;
		}
	}

	if ( empty( $overrides ) ) {
		return;
	}

	/*
	 * Derive --fc-warm-white from the cream value when cream changes, by
	 * lightening it slightly. Keeps the warm-white / cream pairing coherent
	 * without adding another admin field.
	 */
	if ( $cream && strtolower( $cream ) !== '#faf8f5' ) {
		$overrides[] = '--fc-warm-white:' . fc_lighten_hex( $cream, 0.4 );
	}

	$css = ':root{' . implode( ';', $overrides ) . '}';

	wp_add_inline_style( 'fc-main', $css );

}, 20 ); // Priority 20 — runs after the main enqueue at default 10.


/**
 * Lighten a hex color by mixing it toward white.
 *
 * @param string $hex    Hex color (#RRGGBB).
 * @param float  $amount Mix ratio toward white (0 = unchanged, 1 = pure white).
 * @return string        Hex color.
 */
function fc_lighten_hex( $hex, $amount ) {
	$hex = ltrim( $hex, '#' );
	$r   = hexdec( substr( $hex, 0, 2 ) );
	$g   = hexdec( substr( $hex, 2, 2 ) );
	$b   = hexdec( substr( $hex, 4, 2 ) );

	$r = (int) round( $r + ( 255 - $r ) * $amount );
	$g = (int) round( $g + ( 255 - $g ) * $amount );
	$b = (int) round( $b + ( 255 - $b ) * $amount );

	return sprintf( '#%02x%02x%02x', $r, $g, $b );
}
