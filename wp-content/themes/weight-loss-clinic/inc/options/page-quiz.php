<?php
/**
 * Editable content: Eligibility Quiz page (template-quiz.php).
 *
 * Only PHP-rendered chrome copy is editable here — the step-by-step quiz
 * screens themselves are injected by assets/js/quiz.js and remain untouched,
 * as do all data-* attributes and element IDs the JS relies on.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Form column chrome ─────────────────────────────── */
		'quiz_topbar_trust' => 'Private & encrypted',

		/* ── Persistent trust row (bottom of the card) ──────── */
		'quiz_trust_item1'  => 'Private & encrypted',
		'quiz_trust_item2'  => 'Clinician-reviewed',
		'quiz_trust_item3'  => 'Takes about 2 minutes',

		/* ── Desktop side panel quote ───────────────────────── */
		'quiz_quote_text'        => 'A calm, guided pathway — reviewed by Australian-registered clinicians.',
		'quiz_quote_attribution' => 'Telehealth weight management · Clinically supervised',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_quiz', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Eligibility Quiz', 'flavour-clinic' ),
		'priority' => 260,
	] );

	fc_customizer_add_field( $wp_customize, 'quiz_topbar_trust', 'fc_page_quiz', __( 'Top Bar — Trust Note', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'quiz_trust_item1', 'fc_page_quiz', __( 'Trust Row — Item 1 (lock icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'quiz_trust_item2', 'fc_page_quiz', __( 'Trust Row — Item 2 (shield icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'quiz_trust_item3', 'fc_page_quiz', __( 'Trust Row — Item 3 (clock icon)', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'quiz_quote_text', 'fc_page_quiz', __( 'Side Panel — Quote', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'quiz_quote_attribution', 'fc_page_quiz', __( 'Side Panel — Attribution', 'flavour-clinic' ) );
} );
