<?php
/**
 * Editable content: Start Treatment page (template-start-treatment.php).
 *
 * Pre-checkout conviction page. The consultation fees themselves come from
 * the global settings (Buttons & CTAs → Initial / Follow-up consultation
 * fee); only the surrounding copy is edited here.
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Eligibility confirmation ───────────────────────── */
		'stt_hero_headline' => 'You may be eligible for a clinician-guided weight management program',
		'stt_hero_subhead'  => 'Based on your assessment, you can proceed to the next step. A licensed clinician will review your information and, if appropriate, recommend a personalised treatment plan.',

		/* ── 3-step process (one per line: "Title|Detail") ──── */
		'stt_process_heading' => 'What happens next',
		'stt_steps'           => implode( "\n", [
			'Secure your consultation|Complete payment to reserve your clinician review. You are not charged for medication until a plan is approved.',
			'Clinician reviews your profile|A licensed healthcare provider assesses your health information and determines clinical suitability. A telehealth consultation may be required.',
			'Receive your treatment plan|If appropriate, your personalised plan is prepared and medication is dispatched discreetly to your door.',
		] ),

		/* ── Pricing block (fees come from global settings) ─── */
		'stt_price_initial_label'  => 'Initial consultation',
		'stt_price_followup_label' => 'follow-ups',
		'stt_price_note'           => 'Consultation fees cover the clinical service: clinician review, personalised treatment plan, and ongoing support. Any prescribed items are dispensed separately by Australian-registered pharmacies with discreet delivery. No lock-in contracts.',

		/* ── Trust signals (one per line: "Icon|Text") ──────── */
		'stt_trust_items' => implode( "\n", [
			'⚕|Australian-registered clinicians',
			'🔒|Secure & confidential',
			'📦|Discreet home delivery',
			'✕|No lock-in contracts',
		] ),

		/* ── Primary CTA ────────────────────────────────────── */
		'stt_cta_text' => 'Continue to Secure Checkout',
		'stt_cta_note' => 'Secure payment powered by Stripe. Your details are encrypted and never stored on our servers.',

		/* ── Compliance disclaimer ──────────────────────────── */
		'stt_disclaimer' => 'All treatment is subject to clinical assessment and approval by a registered healthcare provider. Completing payment does not guarantee a prescription. If treatment is deemed clinically unsuitable, you will be contacted by our team and offered a full refund. Individual results vary and depend on clinical factors, adherence, and lifestyle. This service does not replace your relationship with your primary care provider.',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_start_treatment', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Start Treatment', 'flavour-clinic' ),
		'priority' => 270,
	] );

	fc_customizer_add_field( $wp_customize, 'stt_hero_headline', 'fc_page_start_treatment', __( 'Header — Headline', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'stt_hero_subhead', 'fc_page_start_treatment', __( 'Header — Subheading', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'stt_process_heading', 'fc_page_start_treatment', __( 'Process — Heading', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'stt_steps', 'fc_page_start_treatment', __( 'Process — Steps', 'flavour-clinic' ), 'textarea', __( 'One step per line: "Title|Detail".', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'stt_price_initial_label', 'fc_page_start_treatment', __( 'Pricing — Initial Fee Label', 'flavour-clinic' ), 'text', __( 'The dollar amount comes from Buttons & CTAs → Initial Consultation Fee.', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'stt_price_followup_label', 'fc_page_start_treatment', __( 'Pricing — Follow-up Fee Label', 'flavour-clinic' ), 'text', __( 'The dollar amount comes from Buttons & CTAs → Follow-up Consultation Fee.', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'stt_price_note', 'fc_page_start_treatment', __( 'Pricing — Note', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'stt_trust_items', 'fc_page_start_treatment', __( 'Trust Signals', 'flavour-clinic' ), 'textarea', __( 'One per line: "Icon|Text" (icon is an emoji or symbol).', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'stt_cta_text', 'fc_page_start_treatment', __( 'CTA — Button Text', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'stt_cta_note', 'fc_page_start_treatment', __( 'CTA — Note', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'stt_disclaimer', 'fc_page_start_treatment', __( 'Compliance Disclaimer', 'flavour-clinic' ), 'textarea' );
} );
