<?php
/**
 * Editable content: About & Clinical Governance page (template-about.php).
 *
 * Registers defaults (via the fc_defaults filter) and Customizer fields
 * for every editable string on the About page. Multi-item fields take one
 * item per line; two-part items use "First|Second".
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Hero ───────────────────────────────────────────── */
		'about_hero_image'    => '',
		'about_hero_eyebrow'  => 'About & clinical governance',
		'about_hero_headline' => 'Built for safer, more considered weight loss care.',
		'about_hero_accent'   => 'considered',
		// Empty = generated from the lead specialist name + title.
		'about_hero_intro'    => '',

		/* ── Why this clinic exists ─────────────────────────── */
		'about_intro_eyebrow'  => 'Why this clinic exists',
		'about_intro_headline' => 'A clinic, not a storefront.',
		'about_intro_p1'       => 'Australian patients deserve weight-management care that is calm, thorough, and clinically governed — not optimised for instant prescriptions or transactional volume. This service was built around three principles: real clinical assessment, honest decisions (including the ones that disappoint), and ongoing oversight that doesn’t end the moment a treatment is supplied.',
		'about_intro_p2'       => 'The pathway is designed to sit alongside your existing care — your GP, your specialists — not replace it. If telehealth isn’t the right tool for you, that’s the answer you’ll get. Suitability comes first; treatment comes second.',

		/* ── Lead specialist card ───────────────────────────── */
		'about_lead_eyebrow' => 'Lead specialist',
		'about_lead_image'   => '',
		// Empty = generated from the lead specialist title.
		'about_lead_role'    => '',
		'about_lead_p1'      => 'Dr Dolan leads the clinical pathway. He brings the discipline of a bariatric & general surgical practice to telehealth-supported weight management — with a strong emphasis on individual assessment, conservative prescribing, and continuity with each patient’s broader care.',
		'about_lead_p2'      => 'Where a case is best handled in person, by a specialist, or by a patient’s GP, that’s where it goes. The pathway is designed to sit alongside existing care, not replace it.',
		'about_lead_facts'   => implode( "\n", [
			'Specialty|Bariatric & general surgery',
			'Telehealth|Available Australia-wide',
			'Approach|Conservative, evidence-informed, individualised',
		] ),

		/* ── Governance principles ──────────────────────────── */
		'about_principles_eyebrow'  => 'Clinical governance principles',
		'about_principles_headline' => 'How we make clinical decisions',
		'about_principles_body'     => 'These principles aren’t marketing — they’re how the clinical service actually runs. If they ever conflict with a commercial incentive, clinical governance wins.',
		'about_principles_items'    => implode( "\n", [
			'stethoscope|Clinician independence|Every clinical decision is made by an AHPRA-registered clinician exercising independent judgment. Commercial targets do not influence clinical decisions. No automated approvals, no pressure to prescribe.',
			'shield|Safety-first prescribing|A real-time telehealth consultation is required before any prescribing decision. Completing the intake form alone is not a consultation. Prescribing that would not meet community standards of safe clinical practice is not offered.',
			'lock|A gated clinical pathway|Health history and clinical suitability are reviewed at every stage. Patients cannot bypass intake, consultation, or clinician review.',
			'heart|Ongoing oversight|Weight management is a long-term process, not a one-off prescription. Monitoring, check-ins, and care-plan reviews are built into the pathway. You are never left without clinical oversight.',
			'users|Escalation when required|If specialist input, in-person assessment, or additional diagnostic work is needed, we facilitate referral to appropriate providers. Escalation is a normal part of safe clinical care.',
			'clock|Continuity of care|We coordinate with your primary care provider where relevant and encourage patients to maintain that relationship. Telehealth sits alongside your existing care, not in place of it.',
		] ),

		/* ── Telehealth limitations ─────────────────────────── */
		'about_limits_eyebrow'       => 'Telehealth limitations',
		'about_limits_headline'      => 'Telehealth is not suitable for everyone',
		'about_limits_body'          => 'Telehealth is a tool, not a universal solution. There are clinical presentations that require in-person assessment, and there are patients for whom this pathway simply isn’t the right fit. We will tell you if that’s you.',
		'about_limits_decline_title' => 'When we decline',
		'about_limits_decline_items' => implode( "\n", [
			'Clinical presentations requiring in-person physical examination',
			'Conditions best managed by a specialist or your GP directly',
			'Significant comorbidities that fall outside the scope of this pathway',
			'Incomplete information preventing a safe clinical decision',
			'Any case where the clinician determines the pathway is not in your best interest',
		] ),
		'about_limits_refer_title'   => 'When we refer on',
		'about_limits_refer_items'   => implode( "\n", [
			'Endocrinology or specialist weight-management referral',
			'Your primary care provider for coordinated ongoing management',
			'Mental health support when clinically indicated',
			'Emergency care when urgent symptoms are identified',
			'Diagnostic pathways where further assessment is required',
		] ),
		'about_limits_footnote'      => 'If telehealth isn’t right for you, that’s a clinical decision, not a commercial one. Our care team can often point you toward a suitable alternative pathway.',

		/* ── Clinician standards ────────────────────────────── */
		'about_standards_eyebrow'  => 'Clinician standards',
		'about_standards_headline' => 'Who looks after your care',
		// Empty = generated from the lead specialist name + title.
		'about_standards_p1'       => '',
		'about_standards_p2'       => 'Clinical decisions are not delegated to non-clinical staff, automated systems, or algorithms. Commercial targets do not influence clinical outcomes.',
		'about_standards_facts'    => implode( "\n", [
			'AHPRA|All clinicians registered and in good standing',
			'Evidence-based|Practice aligned with current clinical guidelines',
			'Real-time consult|Required before any prescribing decision',
			'Australian privacy|Handling aligned with the Privacy Act',
		] ),

		/* ── Regulatory posture ─────────────────────────────── */
		'about_regulatory_headline' => 'Our regulatory posture',
		'about_regulatory_body'     => 'We do not advertise prescription-only medicines. This website provides general health information, describes the clinical service, and outlines the pathway. Any clinically prescribed items are discussed only within a consultation and are subject to independent clinician decision and appropriate dispensing channels.',
		'about_regulatory_items'    => implode( "\n", [
			'No direct-to-consumer advertising of prescription-only medicines',
			'No guaranteed outcomes or exaggerated claims',
			'No instant-prescribing or automated approvals',
			'Clear, visible telehealth limitations',
			'Independent clinician judgment on every case',
		] ),

		/* ── Final CTA ──────────────────────────────────────── */
		'about_cta_headline' => 'Decide if this pathway is right for you',
		'about_cta_body'     => 'Start with the eligibility check, review the full pathway, or read answers to the most common patient questions.',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_about', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — About & Governance', 'flavour-clinic' ),
		'priority' => 210,
	] );

	$add = function ( string $key, string $label, string $type = 'text', string $desc = '' ) use ( $wp_customize ) {
		fc_customizer_add_field( $wp_customize, $key, 'fc_page_about', $label, $type, $desc );
	};

	/* ── Hero ───────────────────────────────────────────────── */
	$add( 'about_hero_image',    __( 'Hero — Image', 'flavour-clinic' ), 'image' );
	$add( 'about_hero_eyebrow',  __( 'Hero — Eyebrow', 'flavour-clinic' ) );
	$add( 'about_hero_headline', __( 'Hero — Headline', 'flavour-clinic' ) );
	$add( 'about_hero_accent',   __( 'Hero — Accent words (part of headline to highlight)', 'flavour-clinic' ) );
	$add( 'about_hero_intro',    __( 'Hero — Intro', 'flavour-clinic' ), 'textarea', __( 'Leave empty to auto-generate from the lead specialist name and title.', 'flavour-clinic' ) );

	/* ── Why this clinic exists ─────────────────────────────── */
	$add( 'about_intro_eyebrow',  __( 'Intro — Eyebrow', 'flavour-clinic' ) );
	$add( 'about_intro_headline', __( 'Intro — Headline', 'flavour-clinic' ) );
	$add( 'about_intro_p1',       __( 'Intro — Paragraph 1', 'flavour-clinic' ), 'textarea' );
	$add( 'about_intro_p2',       __( 'Intro — Paragraph 2', 'flavour-clinic' ), 'textarea' );

	/* ── Lead specialist card ───────────────────────────────── */
	$add( 'about_lead_eyebrow', __( 'Lead specialist — Eyebrow', 'flavour-clinic' ) );
	$add( 'about_lead_image',   __( 'Lead specialist — Portrait', 'flavour-clinic' ), 'image' );
	$add( 'about_lead_role',    __( 'Lead specialist — Role line', 'flavour-clinic' ), 'text', __( 'Leave empty to auto-generate from the lead specialist title.', 'flavour-clinic' ) );
	$add( 'about_lead_p1',      __( 'Lead specialist — Paragraph 1', 'flavour-clinic' ), 'textarea' );
	$add( 'about_lead_p2',      __( 'Lead specialist — Paragraph 2', 'flavour-clinic' ), 'textarea' );
	$add( 'about_lead_facts',   __( 'Lead specialist — Facts (one per line: "Label|Detail")', 'flavour-clinic' ), 'textarea' );

	/* ── Governance principles ──────────────────────────────── */
	$add( 'about_principles_eyebrow',  __( 'Principles — Eyebrow', 'flavour-clinic' ) );
	$add( 'about_principles_headline', __( 'Principles — Headline', 'flavour-clinic' ) );
	$add( 'about_principles_body',     __( 'Principles — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'about_principles_items',    __( 'Principles (one per line: "icon|Title|Body")', 'flavour-clinic' ), 'textarea', __( 'Icons: stethoscope, shield, lock, heart, users, clock.', 'flavour-clinic' ) );

	/* ── Telehealth limitations ─────────────────────────────── */
	$add( 'about_limits_eyebrow',       __( 'Limitations — Eyebrow', 'flavour-clinic' ) );
	$add( 'about_limits_headline',      __( 'Limitations — Headline', 'flavour-clinic' ) );
	$add( 'about_limits_body',          __( 'Limitations — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'about_limits_decline_title', __( 'Limitations — "When we decline" title', 'flavour-clinic' ) );
	$add( 'about_limits_decline_items', __( 'Limitations — "When we decline" points (one per line)', 'flavour-clinic' ), 'textarea' );
	$add( 'about_limits_refer_title',   __( 'Limitations — "When we refer on" title', 'flavour-clinic' ) );
	$add( 'about_limits_refer_items',   __( 'Limitations — "When we refer on" points (one per line)', 'flavour-clinic' ), 'textarea' );
	$add( 'about_limits_footnote',      __( 'Limitations — Footnote', 'flavour-clinic' ), 'textarea' );

	/* ── Clinician standards ────────────────────────────────── */
	$add( 'about_standards_eyebrow',  __( 'Standards — Eyebrow', 'flavour-clinic' ) );
	$add( 'about_standards_headline', __( 'Standards — Headline', 'flavour-clinic' ) );
	$add( 'about_standards_p1',       __( 'Standards — Paragraph 1', 'flavour-clinic' ), 'textarea', __( 'Leave empty to auto-generate from the lead specialist name and title.', 'flavour-clinic' ) );
	$add( 'about_standards_p2',       __( 'Standards — Paragraph 2', 'flavour-clinic' ), 'textarea' );
	$add( 'about_standards_facts',    __( 'Standards — Facts (one per line: "Label|Detail")', 'flavour-clinic' ), 'textarea' );

	/* ── Regulatory posture ─────────────────────────────────── */
	$add( 'about_regulatory_headline', __( 'Regulatory — Headline', 'flavour-clinic' ) );
	$add( 'about_regulatory_body',     __( 'Regulatory — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'about_regulatory_items',    __( 'Regulatory — Points (one per line)', 'flavour-clinic' ), 'textarea' );

	/* ── Final CTA ──────────────────────────────────────────── */
	$add( 'about_cta_headline', __( 'Final CTA — Headline', 'flavour-clinic' ) );
	$add( 'about_cta_body',     __( 'Final CTA — Body', 'flavour-clinic' ), 'textarea' );
} );
