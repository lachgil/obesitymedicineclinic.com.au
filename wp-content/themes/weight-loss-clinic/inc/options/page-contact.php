<?php
/**
 * Editable content: Contact page (template-contact.php).
 *
 * Registers defaults (via the fc_defaults filter) and Customizer controls
 * for every editable string on /contact/. The email address itself comes
 * from the global Support Email setting (Buttons & CTAs).
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Header ─────────────────────────────────────────── */
		'contact_hero_eyebrow'  => 'Contact',
		'contact_hero_headline' => 'Get in touch',
		'contact_hero_intro'    => '', // empty = generated from specialist name
		'contact_photo'         => '',

		/* ── Email block ────────────────────────────────────── */
		'contact_email_title' => 'Email us',
		'contact_email_body'  => 'The fastest way to reach our team. We aim to respond within one business day.',

		/* ── What to include ────────────────────────────────── */
		'contact_include_title' => 'What to include',
		'contact_include_intro' => 'To help us respond quickly, please include:',
		'contact_include_items' => implode( "\n", [
			'Your full name',
			'The nature of your enquiry (eligibility, treatment, billing, etc.)',
			'Any relevant details or reference numbers',
		] ),

		/* ── Response times ─────────────────────────────────── */
		'contact_response_title' => 'Response times',
		'contact_response_body'  => 'Our team typically responds within <strong>24 hours</strong> on business days. For urgent medical concerns, please contact your local emergency services or primary care provider.',

		/* ── Trust note ─────────────────────────────────────── */
		'contact_trust_body' => 'All communications are confidential and handled in accordance with our privacy policy. Your information is never shared with third parties without your consent.',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_contact', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Contact', 'flavour-clinic' ),
		'priority' => 240,
	] );

	$add = function ( string $key, string $label, string $type = 'text', string $desc = '' ) use ( $wp_customize ) {
		fc_customizer_add_field( $wp_customize, $key, 'fc_page_contact', $label, $type, $desc );
	};

	$add( 'contact_hero_eyebrow',  __( 'Header — Eyebrow', 'flavour-clinic' ) );
	$add( 'contact_hero_headline', __( 'Header — Headline', 'flavour-clinic' ) );
	$add( 'contact_hero_intro',    __( 'Header — Intro', 'flavour-clinic' ), 'textarea', __( 'Leave empty to auto-generate from the lead specialist name.', 'flavour-clinic' ) );
	$add( 'contact_photo',         __( 'Photo', 'flavour-clinic' ), 'image' );

	$add( 'contact_email_title', __( 'Email block — Title', 'flavour-clinic' ) );
	$add( 'contact_email_body',  __( 'Email block — Body', 'flavour-clinic' ), 'textarea', __( 'The address itself comes from Buttons & CTAs → Support Email.', 'flavour-clinic' ) );

	$add( 'contact_include_title', __( '"What to include" — Title', 'flavour-clinic' ) );
	$add( 'contact_include_intro', __( '"What to include" — Intro line', 'flavour-clinic' ) );
	$add( 'contact_include_items', __( '"What to include" — Points (one per line)', 'flavour-clinic' ), 'textarea' );

	$add( 'contact_response_title', __( 'Response times — Title', 'flavour-clinic' ) );
	$add( 'contact_response_body',  __( 'Response times — Body', 'flavour-clinic' ), 'richtext', __( 'Basic HTML such as <strong> is allowed.', 'flavour-clinic' ) );

	$add( 'contact_trust_body', __( 'Trust note', 'flavour-clinic' ), 'textarea' );
} );
