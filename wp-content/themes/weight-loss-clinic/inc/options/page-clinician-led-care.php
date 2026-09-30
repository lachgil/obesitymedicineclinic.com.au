<?php
/**
 * Editable content: Clinician-Led Care page (template-clinician-led-care.php).
 *
 * Registers defaults (via the fc_defaults filter) and Customizer fields
 * for every editable string on the Clinician-Led Care page. Multi-item
 * fields take one item per line; two-part items use "First|Second".
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Page header ────────────────────────────────────── */
		'clc_hero_eyebrow'  => 'Clinician-led care',
		'clc_hero_headline' => 'A telehealth pathway built on a specialist practice',
		'clc_hero_accent'   => 'specialist practice',
		'clc_hero_intro'    => 'This isn’t an online prescribing service that bolted on a clinician. The reverse is true: it’s an established specialist practice extending into telehealth, with the same clinical discipline carried across.',

		/* ── Specialist hero ────────────────────────────────── */
		'clc_specialist_eyebrow' => 'Lead specialist',
		'clc_specialist_image'   => '',
		'clc_specialist_p1'      => 'Dr Dolan brings the discipline of a long-running bariatric and general surgical practice to telehealth-supported weight management. The pathway you access through this clinic sits inside that broader specialist framework — not separate from it.',
		'clc_specialist_p2'      => 'Patients are individually assessed. Recommendations are conservative. Where in-person review, specialist input, or GP coordination would serve a patient better, the pathway hands off cleanly.',

		/* ── How decisions get made ─────────────────────────── */
		'clc_decisions_eyebrow'  => 'How decisions get made',
		'clc_decisions_headline' => 'A specialist’s judgment, on every case',
		'clc_decisions_body'     => 'No automated approvals. No targets. No pressure to prescribe. Every recommendation reflects clinical judgment applied to your individual case.',

		'clc_decision1_title' => 'Individual assessment',
		'clc_decision1_body'  => 'Your intake is reviewed against your full health history. A real-time consultation is required before any prescribing decision — the form alone is not enough.',
		'clc_decision2_title' => 'Conservative by default',
		'clc_decision2_body'  => 'When the clinical picture is uncertain, we slow down: more information, additional review, or a different pathway entirely. Erring toward safety is the rule, not the exception.',
		'clc_decision3_title' => 'Ongoing review',
		'clc_decision3_body'  => 'Care plans are reviewed and adjusted as your progress unfolds. Markers, side effects, and how you’re actually doing all feed back into the plan.',
		'clc_decision4_title' => 'Escalation when needed',
		'clc_decision4_body'  => 'If specialist input, in-person assessment, or coordination with your GP is the right next step, that’s what happens. Telehealth sits alongside your existing care, not in place of it.',

		/* ── Photography context band ───────────────────────── */
		'clc_context1_image'   => '',
		'clc_context1_caption' => 'Consultations',
		'clc_context2_image'   => '',
		'clc_context2_caption' => 'Patient education',
		'clc_context3_image'   => '',
		'clc_context3_caption' => 'Surgical practice',

		/* ── Final CTA ──────────────────────────────────────── */
		'clc_cta_headline' => 'Start with the eligibility check',
		'clc_cta_body'     => 'A brief, private assessment. If the pathway is appropriate for you, your clinician will recommend a personalised plan. If it isn’t, we’ll say so — clearly — and point you toward the right care.',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_clinician_led_care', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Clinician-Led Care', 'flavour-clinic' ),
		'priority' => 220,
	] );

	$add = function ( string $key, string $label, string $type = 'text', string $desc = '' ) use ( $wp_customize ) {
		fc_customizer_add_field( $wp_customize, $key, 'fc_page_clinician_led_care', $label, $type, $desc );
	};

	/* ── Page header ────────────────────────────────────────── */
	$add( 'clc_hero_eyebrow',  __( 'Header — Eyebrow', 'flavour-clinic' ) );
	$add( 'clc_hero_headline', __( 'Header — Headline', 'flavour-clinic' ) );
	$add( 'clc_hero_accent',   __( 'Header — Accent words (part of headline to highlight)', 'flavour-clinic' ) );
	$add( 'clc_hero_intro',    __( 'Header — Intro', 'flavour-clinic' ), 'textarea' );

	/* ── Specialist hero ────────────────────────────────────── */
	$add( 'clc_specialist_eyebrow', __( 'Specialist — Eyebrow', 'flavour-clinic' ) );
	$add( 'clc_specialist_image',   __( 'Specialist — Portrait', 'flavour-clinic' ), 'image' );
	$add( 'clc_specialist_p1',      __( 'Specialist — Paragraph 1', 'flavour-clinic' ), 'textarea' );
	$add( 'clc_specialist_p2',      __( 'Specialist — Paragraph 2', 'flavour-clinic' ), 'textarea' );

	/* ── How decisions get made ─────────────────────────────── */
	$add( 'clc_decisions_eyebrow',  __( 'Decisions — Eyebrow', 'flavour-clinic' ) );
	$add( 'clc_decisions_headline', __( 'Decisions — Headline', 'flavour-clinic' ) );
	$add( 'clc_decisions_body',     __( 'Decisions — Body', 'flavour-clinic' ), 'textarea' );
	foreach ( [ 1, 2, 3, 4 ] as $n ) {
		$add( "clc_decision{$n}_title", sprintf( __( 'Decision %d — Title', 'flavour-clinic' ), $n ) );
		$add( "clc_decision{$n}_body",  sprintf( __( 'Decision %d — Body', 'flavour-clinic' ), $n ), 'textarea' );
	}

	/* ── Photography context band ───────────────────────────── */
	foreach ( [ 1, 2, 3 ] as $n ) {
		$add( "clc_context{$n}_image",   sprintf( __( 'Photo %d — Image', 'flavour-clinic' ), $n ), 'image' );
		$add( "clc_context{$n}_caption", sprintf( __( 'Photo %d — Caption', 'flavour-clinic' ), $n ) );
	}

	/* ── Final CTA ──────────────────────────────────────────── */
	$add( 'clc_cta_headline', __( 'Final CTA — Headline', 'flavour-clinic' ) );
	$add( 'clc_cta_body',     __( 'Final CTA — Body', 'flavour-clinic' ), 'textarea' );
} );
