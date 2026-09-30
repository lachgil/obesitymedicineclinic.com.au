<?php
/**
 * Editable content: Patient Intake page (template-intake.php).
 *
 * Only the PHP-rendered shell chrome is editable here — the intake screens
 * themselves are injected by the wlc-clinical-pathway plugin's JS via the
 * [wlc_intake_form] shortcode and remain untouched, as do all data-*
 * attributes and element IDs that JS relies on.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Form column chrome ─────────────────────────────── */
		'intake_topbar_trust' => 'Private & encrypted',

		/* ── Persistent trust row (bottom of the card) ──────── */
		'intake_trust_item1'  => 'Clinician reviewed',
		'intake_trust_item2'  => 'AHPRA-registered clinicians',
		'intake_trust_item3'  => 'Not all patients approved',
		'intake_trust_item4'  => 'Telehealth pathway',

		/* ── Desktop side panel quote ───────────────────────── */
		'intake_quote_text'        => 'Considered care begins with honest answers.',
		'intake_quote_attribution' => 'Clinical governance · Australian-registered clinicians',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_intake', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Patient Intake', 'flavour-clinic' ),
		'priority' => 290,
	] );

	fc_customizer_add_field( $wp_customize, 'intake_topbar_trust', 'fc_page_intake', __( 'Top Bar — Trust Note', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'intake_trust_item1', 'fc_page_intake', __( 'Trust Row — Item 1 (shield icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'intake_trust_item2', 'fc_page_intake', __( 'Trust Row — Item 2 (check icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'intake_trust_item3', 'fc_page_intake', __( 'Trust Row — Item 3 (lock icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'intake_trust_item4', 'fc_page_intake', __( 'Trust Row — Item 4 (pulse icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'intake_quote_text', 'fc_page_intake', __( 'Side Panel — Quote', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'intake_quote_attribution', 'fc_page_intake', __( 'Side Panel — Attribution', 'flavour-clinic' ) );
} );
