<?php
/**
 * Editable content: Booking page (template-booking.php).
 *
 * Registers defaults (via the fc_defaults filter) and Customizer controls
 * for every editable string on /book/. The Coviu / telehealth provider
 * plumbing (BRAND_TELEHEALTH_* constants) is untouched — only copy is
 * editable here.
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Hero ───────────────────────────────────────────── */
		'booking_hero_eyebrow'  => 'Telehealth consultation',
		'booking_hero_headline' => 'Start with a clinical eligibility check.',
		'booking_hero_accent'   => 'eligibility check',
		'booking_hero_intro'    => 'A clinical review with an Australian-registered clinician — not automatic approval. Your clinician reviews your assessment, discusses your goals, and decides whether this pathway is appropriate. Not all patients are approved.',
		'booking_hero_image'    => '',

		/* ── "What you're booking" grid ─────────────────────── */
		'booking_intro_eyebrow'  => 'What you’re booking',
		'booking_intro_headline' => 'A structured telehealth consultation, not an instant prescription',
		'booking_intro_body'     => 'Your consultation is a clinical assessment. Your clinician reviews the information you provide at intake, asks follow-up questions, and discusses whether a clinically reviewed weight management pathway is appropriate for you.',
		'booking_intro_items'    => implode( "\n", [
			'Duration|approximately 20–30 minutes, held over secure video.',
			'Prepared by|the clinical team reviewing your assessment ahead of time.',
			'Privacy|handled in accordance with the Australian Privacy Act — shared only with the clinical team reviewing your case.',
			'Outcome|a clinical decision. Not all patients are approved for this pathway.',
			'Next steps|if clinically appropriate, your clinician outlines a personalised next-step plan with structured follow-up.',
		] ),

		/* ── "Before you book" callout ──────────────────────── */
		'booking_callout_eyebrow' => 'Before you book',
		'booking_callout_body'    => 'If you haven’t yet completed your intake, the clinician may ask you to do so before the consultation can proceed.',

		/* ── 3-step expectation setter ──────────────────────── */
		'booking_steps_eyebrow'  => 'What to expect',
		'booking_steps_headline' => 'A structured clinical process',

		'booking_step1_title' => 'Complete your intake',
		'booking_step1_body'  => 'Share your health history, medications, and relevant medical information through the structured intake form before the consultation begins.',
		'booking_step2_title' => 'Meet your clinician on video',
		'booking_step2_body'  => 'A secure telehealth consultation. Your clinician reviews your intake, asks clarifying questions, and discusses your goals.',
		'booking_step3_title' => 'Receive a clinical decision',
		'booking_step3_body'  => 'If this program is clinically appropriate, your clinician will recommend a personalised care plan. If not, you’ll be informed directly and, where possible, directed to alternative care.',

		/* ── Booking widget card ────────────────────────────── */
		'booking_widget_eyebrow'  => 'Reserve your consultation',
		'booking_widget_headline' => 'Choose a time that works for you',

		// Intake-fallback placeholder (shown until the scheduler is live)
		'booking_placeholder_eyebrow' => 'Booking pathway',
		'booking_placeholder_title'   => 'Start with your clinical intake',
		'booking_placeholder_body'    => 'Our telehealth booking is staged. Complete your intake now — our clinical team reaches out within one business day to confirm a consultation time. Once our online scheduler is live, you’ll be able to self-book directly from this page.',
		'booking_placeholder_note'    => 'Already have a reference from our clinical team?',

		'booking_fineprint' => '<strong>Booking a consultation does not guarantee approval or a prescription.</strong> All clinical decisions are made by AHPRA-registered clinicians exercising independent judgment. Telehealth is not suitable for every patient or every clinical presentation — your clinician may refer you to in-person care or specialist review if appropriate.',

		/* ── Not-ready bridge / support ─────────────────────── */
		'booking_notready_text' => 'Not ready to book? Read how the pathway works first.',

		'booking_support_title' => 'Need to reschedule, cancel, or ask a question?',
		'booking_support_body'  => 'Our care team handles scheduling changes, technical questions, and general enquiries. Clinical questions are answered by your clinician during your consultation.',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_booking', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Booking', 'flavour-clinic' ),
		'priority' => 250,
	] );

	$add = function ( string $key, string $label, string $type = 'text', string $desc = '' ) use ( $wp_customize ) {
		fc_customizer_add_field( $wp_customize, $key, 'fc_page_booking', $label, $type, $desc );
	};

	/* Hero */
	$add( 'booking_hero_eyebrow',  __( 'Hero — Eyebrow', 'flavour-clinic' ) );
	$add( 'booking_hero_headline', __( 'Hero — Headline', 'flavour-clinic' ) );
	$add( 'booking_hero_accent',   __( 'Hero — Accent words (part of headline to highlight)', 'flavour-clinic' ) );
	$add( 'booking_hero_intro',    __( 'Hero — Intro', 'flavour-clinic' ), 'textarea' );
	$add( 'booking_hero_image',    __( 'Hero — Image', 'flavour-clinic' ), 'image' );

	/* What you're booking */
	$add( 'booking_intro_eyebrow',  __( 'Intro — Eyebrow', 'flavour-clinic' ) );
	$add( 'booking_intro_headline', __( 'Intro — Headline', 'flavour-clinic' ) );
	$add( 'booking_intro_body',     __( 'Intro — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'booking_intro_items',    __( 'Intro — Detail points (one per line: "Label|Detail")', 'flavour-clinic' ), 'textarea', __( 'A colon is added after each label automatically.', 'flavour-clinic' ) );

	/* Callout */
	$add( 'booking_callout_eyebrow', __( 'Callout — Eyebrow', 'flavour-clinic' ) );
	$add( 'booking_callout_body',    __( 'Callout — Body', 'flavour-clinic' ), 'textarea' );

	/* Expectation steps */
	$add( 'booking_steps_eyebrow',  __( 'Steps — Eyebrow', 'flavour-clinic' ) );
	$add( 'booking_steps_headline', __( 'Steps — Headline', 'flavour-clinic' ) );
	foreach ( [ 1, 2, 3 ] as $n ) {
		$add( "booking_step{$n}_title", sprintf( __( 'Steps — Step %d title', 'flavour-clinic' ), $n ) );
		$add( "booking_step{$n}_body",  sprintf( __( 'Steps — Step %d body', 'flavour-clinic' ), $n ), 'textarea' );
	}

	/* Booking widget card */
	$add( 'booking_widget_eyebrow',  __( 'Widget — Eyebrow', 'flavour-clinic' ) );
	$add( 'booking_widget_headline', __( 'Widget — Headline', 'flavour-clinic' ) );

	$add( 'booking_placeholder_eyebrow', __( 'Widget fallback — Eyebrow', 'flavour-clinic' ), 'text', __( 'Shown while the online scheduler is not yet live.', 'flavour-clinic' ) );
	$add( 'booking_placeholder_title',   __( 'Widget fallback — Title', 'flavour-clinic' ) );
	$add( 'booking_placeholder_body',    __( 'Widget fallback — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'booking_placeholder_note',    __( 'Widget fallback — Portal note (link is appended)', 'flavour-clinic' ) );

	$add( 'booking_fineprint', __( 'Widget — Fine print', 'flavour-clinic' ), 'richtext', __( 'Basic HTML such as <strong> is allowed.', 'flavour-clinic' ) );

	/* Bridge + support */
	$add( 'booking_notready_text', __( '"Not ready" bridge — Text', 'flavour-clinic' ) );
	$add( 'booking_support_title', __( 'Support — Title', 'flavour-clinic' ) );
	$add( 'booking_support_body',  __( 'Support — Body', 'flavour-clinic' ), 'textarea' );
} );
