<?php
/**
 * Editable content: How It Works page (template-how-it-works.php).
 *
 * Registers defaults (via the fc_defaults filter) and Customizer controls
 * for every editable string on /how-it-works/. Multi-item fields take one
 * item per line; two-part items use "First part|Second part".
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Hero ───────────────────────────────────────────── */
		'hiw_hero_eyebrow'  => 'How it works',
		'hiw_hero_headline' => 'From eligibility check to ongoing support — a clear clinical pathway.',
		'hiw_hero_accent'   => 'a clear clinical pathway',
		'hiw_hero_intro'    => 'A clinician-led telehealth pathway designed to be straightforward, private, and clinically supervised from start to finish.',
		'hiw_hero_image'    => '',

		/* ── Three-step pathway (shared partial) ────────────── */
		'hiw_pathway_eyebrow'  => 'The pathway in three steps',
		'hiw_pathway_headline' => 'Easy to start.<br><span>Clinically supervised throughout.</span>',
		'hiw_pathway_intro'    => '', // empty = generated from specialist name

		'hiw_pathway_step1_title' => 'Check your eligibility',
		'hiw_pathway_step1_body'  => 'Answer a short set of structured questions so the clinical team can understand your goals, medical history, and suitability.',
		'hiw_pathway_step1_meta'  => 'Takes about 2 minutes',
		'hiw_pathway_step1_image' => '',

		'hiw_pathway_step2_title' => 'Complete your clinical intake',
		'hiw_pathway_step2_body'  => 'Share medical history, medications, and goals through a structured intake. Your clinician uses this to prepare for the consultation.',
		'hiw_pathway_step2_meta'  => 'Confidential and secure',
		'hiw_pathway_step2_image' => '',

		'hiw_pathway_step3_title' => 'Practitioner review & next steps',
		'hiw_pathway_step3_body'  => 'A 20–30 minute telehealth consultation. Your clinician makes an independent decision and outlines next steps.',
		'hiw_pathway_step3_meta'  => 'Decision: approved, declined, or referred',
		'hiw_pathway_step3_image' => '',

		/* ── Quiet reassurance strip (one per line: "Label|Detail") ── */
		'hiw_promise_items' => implode( "\n", [
			'Clinician-led|Reviewed by Australian-registered clinicians.',
			'Private|Secure and confidential telehealth pathway.',
			'Ongoing support|Structured check-ins and continued oversight.',
			'Transparent|No lock-in contracts.',
		] ),

		/* ── Full 8-step pathway (collapsible detail) ───────── */
		'hiw_detail_eyebrow'  => 'The full pathway',
		'hiw_detail_headline' => 'Eight steps, in detail',
		'hiw_detail_body'     => 'For patients who want to see exactly how each stage runs — from first eligibility check through to long-term maintenance.',

		'hiw_detail_step1_title' => 'Eligibility check',
		'hiw_detail_step1_body'  => 'A short, structured set of questions that filters out obvious exclusions up front. Takes about two minutes and tells you whether it’s worth proceeding.',
		'hiw_detail_step2_title' => 'Clinical intake',
		'hiw_detail_step2_body'  => 'A confidential health questionnaire covering medical history, medications, lifestyle, and goals. Your clinician uses this to prepare for the consultation.',
		'hiw_detail_step3_title' => 'Telehealth consultation',
		'hiw_detail_step3_body'  => '', // empty = generated from specialist name
		'hiw_detail_step4_title' => 'Clinical review',
		'hiw_detail_step4_body'  => 'Your clinician reviews everything together: intake, history, conversation. They make an independent decision on whether this pathway is right for you.',
		'hiw_detail_step5_title' => 'Treatment decision',
		'hiw_detail_step5_body'  => 'Approved, declined, or referred onward. If approved, your clinician proposes a personalised care plan. If declined, you’re told directly and, where possible, redirected to a more suitable pathway.',
		'hiw_detail_step6_title' => 'Pharmacy & delivery',
		'hiw_detail_step6_body'  => 'Where clinically prescribed items are part of your plan, they’re dispensed by an appropriate pharmacy and delivered discreetly. This step is independent of website browsing.',
		'hiw_detail_step7_title' => 'Scheduled follow-up',
		'hiw_detail_step7_body'  => 'Regular check-ins to track progress, monitor health markers, and adjust your care plan. Cadence is more frequent early on, easing as your progress stabilises.',
		'hiw_detail_step8_title' => 'Maintenance & review',
		'hiw_detail_step8_body'  => 'A long-term continuity layer with reduced check-in frequency once your clinician confirms maintenance is appropriate. Re-engagement pathway available if circumstances change.',

		/* ── Compliance block ───────────────────────────────── */
		'hiw_compliance_title' => 'Not every patient is approved',
		'hiw_compliance_body'  => 'Our clinicians exercise independent clinical judgment on every case. If this pathway isn’t clinically appropriate for you, you’ll be informed directly and, where possible, directed to alternative care or your primary care provider. Telehealth is not a substitute for in-person assessment when that’s what your clinical presentation requires.',
		'hiw_compliance_items' => implode( "\n", [
			'No automated approvals — every case is individually assessed',
			'A real-time consultation is required before any prescribing decision',
			'Some patients are referred to specialist or in-person care',
			'All clinicians hold current AHPRA registration',
		] ),

		/* ── Suitability ────────────────────────────────────── */
		'hiw_fit_eyebrow'   => 'Suitability',
		'hiw_fit_headline'  => 'Is this right for me?',
		'hiw_fit_body'      => 'Honest about who this pathway suits — and who it doesn’t.',
		'hiw_fit_yes_title' => 'Suitable if',
		'hiw_fit_yes_items' => implode( "\n", [
			'You want a structured, clinician-led pathway',
			'You’re comfortable with telehealth consultations',
			'You’re open to ongoing clinical support and reviews',
			'You value continuity over a one-off transaction',
		] ),
		'hiw_fit_no_title'  => 'Not suitable if',
		'hiw_fit_no_items'  => implode( "\n", [
			'You’re seeking instant prescriptions without clinical review',
			'You require urgent or specialist-only care',
			'Your clinician determines in-person assessment is necessary',
			'You’re looking for a quick-fix or one-off pathway',
		] ),
		'hiw_fit_footnote'  => 'If telehealth isn’t right for you, our care team can often point you toward a suitable alternative pathway.',

		/* ── Final CTA ──────────────────────────────────────── */
		'hiw_cta_headline' => 'Start with the eligibility check.',
		'hiw_cta_body'     => 'Most patients complete the first step in under two minutes.',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_how_it_works', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — How It Works', 'flavour-clinic' ),
		'priority' => 230,
	] );

	$add = function ( string $key, string $label, string $type = 'text', string $desc = '' ) use ( $wp_customize ) {
		fc_customizer_add_field( $wp_customize, $key, 'fc_page_how_it_works', $label, $type, $desc );
	};

	/* Hero */
	$add( 'hiw_hero_eyebrow',  __( 'Hero — Eyebrow', 'flavour-clinic' ) );
	$add( 'hiw_hero_headline', __( 'Hero — Headline', 'flavour-clinic' ) );
	$add( 'hiw_hero_accent',   __( 'Hero — Accent words (part of headline to highlight)', 'flavour-clinic' ) );
	$add( 'hiw_hero_intro',    __( 'Hero — Intro', 'flavour-clinic' ), 'textarea' );
	$add( 'hiw_hero_image',    __( 'Hero — Image', 'flavour-clinic' ), 'image' );

	/* Three-step pathway */
	$add( 'hiw_pathway_eyebrow',  __( 'Pathway — Eyebrow', 'flavour-clinic' ) );
	$add( 'hiw_pathway_headline', __( 'Pathway — Headline', 'flavour-clinic' ), 'html', __( 'Supports <br> and <span> for the accent line.', 'flavour-clinic' ) );
	$add( 'hiw_pathway_intro',    __( 'Pathway — Intro', 'flavour-clinic' ), 'textarea', __( 'Leave empty to auto-generate from the lead specialist name.', 'flavour-clinic' ) );
	foreach ( [ 1, 2, 3 ] as $n ) {
		$add( "hiw_pathway_step{$n}_title", sprintf( __( 'Pathway — Step %d title', 'flavour-clinic' ), $n ) );
		$add( "hiw_pathway_step{$n}_body",  sprintf( __( 'Pathway — Step %d body', 'flavour-clinic' ), $n ), 'textarea' );
		$add( "hiw_pathway_step{$n}_meta",  sprintf( __( 'Pathway — Step %d meta line', 'flavour-clinic' ), $n ) );
		$add( "hiw_pathway_step{$n}_image", sprintf( __( 'Pathway — Step %d image', 'flavour-clinic' ), $n ), 'image' );
	}

	/* Reassurance strip */
	$add( 'hiw_promise_items', __( 'Reassurance strip (one per line: "Label|Detail")', 'flavour-clinic' ), 'textarea' );

	/* Full 8-step detail */
	$add( 'hiw_detail_eyebrow',  __( 'Full pathway — Eyebrow', 'flavour-clinic' ) );
	$add( 'hiw_detail_headline', __( 'Full pathway — Headline', 'flavour-clinic' ) );
	$add( 'hiw_detail_body',     __( 'Full pathway — Body', 'flavour-clinic' ), 'textarea' );
	foreach ( range( 1, 8 ) as $n ) {
		$add( "hiw_detail_step{$n}_title", sprintf( __( 'Full pathway — Step %d title', 'flavour-clinic' ), $n ) );
		$add(
			"hiw_detail_step{$n}_body",
			sprintf( __( 'Full pathway — Step %d body', 'flavour-clinic' ), $n ),
			'textarea',
			3 === $n ? __( 'Leave empty to auto-generate from the lead specialist name.', 'flavour-clinic' ) : ''
		);
	}

	/* Compliance */
	$add( 'hiw_compliance_title', __( 'Compliance — Title', 'flavour-clinic' ) );
	$add( 'hiw_compliance_body',  __( 'Compliance — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'hiw_compliance_items', __( 'Compliance — Points (one per line)', 'flavour-clinic' ), 'textarea' );

	/* Suitability */
	$add( 'hiw_fit_eyebrow',   __( 'Suitability — Eyebrow', 'flavour-clinic' ) );
	$add( 'hiw_fit_headline',  __( 'Suitability — Headline', 'flavour-clinic' ) );
	$add( 'hiw_fit_body',      __( 'Suitability — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'hiw_fit_yes_title', __( 'Suitability — "Suitable if" card title', 'flavour-clinic' ) );
	$add( 'hiw_fit_yes_items', __( 'Suitability — "Suitable if" points (one per line)', 'flavour-clinic' ), 'textarea' );
	$add( 'hiw_fit_no_title',  __( 'Suitability — "Not suitable if" card title', 'flavour-clinic' ) );
	$add( 'hiw_fit_no_items',  __( 'Suitability — "Not suitable if" points (one per line)', 'flavour-clinic' ), 'textarea' );
	$add( 'hiw_fit_footnote',  __( 'Suitability — Footnote (link to FAQ is appended)', 'flavour-clinic' ), 'textarea' );

	/* Final CTA */
	$add( 'hiw_cta_headline', __( 'Final CTA — Headline', 'flavour-clinic' ) );
	$add( 'hiw_cta_body',     __( 'Final CTA — Body', 'flavour-clinic' ), 'textarea' );
} );
