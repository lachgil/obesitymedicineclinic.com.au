<?php
/**
 * Theme options: defaults registry + settings resolution.
 *
 * Every editable value in the theme resolves through fc_setting():
 *
 *   1. Customizer value (theme_mod, prefixed `fc_`)
 *   2. Default from fc_defaults()
 *
 * Defaults are sourced from the BRAND_* constants in brand-config.php,
 * so that file remains the per-brand developer baseline while editors
 * override anything in Appearance → Customize without touching code.
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Central defaults registry: setting key => default value.
 *
 * Keys map 1:1 to Customizer settings named "fc_{key}".
 *
 * @return array<string, mixed>
 */
function fc_defaults() : array {
	static $defaults = null;

	if ( null !== $defaults ) {
		return $defaults;
	}

	$defaults = [
		/* ── Brand identity ─────────────────────────────────── */
		'brand_name'           => defined( 'BRAND_NAME' )    ? BRAND_NAME    : get_bloginfo( 'name' ),
		'brand_tagline'        => defined( 'BRAND_TAGLINE' ) ? BRAND_TAGLINE : '',

		/* ── Lead specialist ────────────────────────────────── */
		'specialist_name'      => defined( 'BRAND_SPECIALIST_NAME' )  ? BRAND_SPECIALIST_NAME  : '',
		'specialist_title'     => defined( 'BRAND_SPECIALIST_TITLE' ) ? BRAND_SPECIALIST_TITLE : '',
		'specialist_cred'      => defined( 'BRAND_SPECIALIST_CRED' )  ? BRAND_SPECIALIST_CRED  : '',

		/* ── CTAs ───────────────────────────────────────────── */
		'cta_text'             => defined( 'BRAND_CTA_TEXT' )         ? BRAND_CTA_TEXT         : 'Get Started',
		'cta_url'              => defined( 'BRAND_CTA_URL' )          ? BRAND_CTA_URL          : '/quiz/',
		'intake_cta_text'      => defined( 'BRAND_INTAKE_CTA_TEXT' )  ? BRAND_INTAKE_CTA_TEXT  : 'Start Your Assessment',
		'booking_cta_text'     => defined( 'BRAND_BOOKING_CTA_TEXT' ) ? BRAND_BOOKING_CTA_TEXT : 'Book Consultation',
		'portal_cta_text'      => defined( 'BRAND_PORTAL_CTA_TEXT' )  ? BRAND_PORTAL_CTA_TEXT  : 'Patient Portal',

		/* ── URLs / endpoints ───────────────────────────────── */
		'intake_url'           => defined( 'BRAND_INTAKE_URL' )       ? BRAND_INTAKE_URL       : '/patient-intake/',
		'dashboard_url'        => defined( 'BRAND_DASHBOARD_URL' )    ? BRAND_DASHBOARD_URL    : '/patient-dashboard/',
		'booking_url'          => defined( 'BRAND_BOOKING_URL' )      ? BRAND_BOOKING_URL      : '/book/',
		'portal_url'           => defined( 'BRAND_PORTAL_URL' )       ? BRAND_PORTAL_URL       : '/portal/',
		'plans_url'            => defined( 'BRAND_PLANS_URL' )        ? BRAND_PLANS_URL        : '/plans/',
		'how_it_works_url'     => defined( 'BRAND_HOW_IT_WORKS_URL' ) ? BRAND_HOW_IT_WORKS_URL : '/how-it-works/',
		'about_url'            => defined( 'BRAND_ABOUT_URL' )        ? BRAND_ABOUT_URL        : '/about/',
		'faq_url'              => defined( 'BRAND_FAQ_URL' )          ? BRAND_FAQ_URL          : '/faq/',
		'clinician_url'        => defined( 'BRAND_CLINICIAN_URL' )    ? BRAND_CLINICIAN_URL    : '/clinician-led-care/',
		'checkout_url'         => defined( 'BRAND_CHECKOUT_URL' )     ? BRAND_CHECKOUT_URL     : '/patient-intake/',
		'review_url'           => defined( 'BRAND_REVIEW_URL' )       ? BRAND_REVIEW_URL       : '/patient-intake/',
		'contact_url'          => defined( 'BRAND_CONTACT_URL' )      ? BRAND_CONTACT_URL      : '/contact/',
		'stripe_url'           => defined( 'BRAND_STRIPE_URL' )       ? BRAND_STRIPE_URL       : '#stripe-not-configured',
		'thankyou_url'         => defined( 'BRAND_THANKYOU_URL' )     ? BRAND_THANKYOU_URL     : '/thank-you/',

		/* ── Pricing / contact ──────────────────────────────── */
		'price_from'           => defined( 'BRAND_PRICE_FROM' )    ? (string) BRAND_PRICE_FROM : '299',
		'price_followup'       => '80',
		'support_email'        => defined( 'BRAND_SUPPORT_EMAIL' ) ? BRAND_SUPPORT_EMAIL       : '',
		'support_phone'        => defined( 'BRAND_SUPPORT_PHONE' ) ? BRAND_SUPPORT_PHONE       : '',

		/* ── Labels ─────────────────────────────────────────── */
		'nav_treatments_label' => defined( 'BRAND_NAV_TREATMENTS_LABEL' ) ? BRAND_NAV_TREATMENTS_LABEL : 'Programs',
		'testimonials_eyebrow' => defined( 'BRAND_TESTIMONIALS_EYEBROW' ) ? BRAND_TESTIMONIALS_EYEBROW : 'Patient Experiences',

		/* ── Hero defaults (used by non-carousel hero) ──────── */
		'hero_headline'        => defined( 'BRAND_HERO_HEADLINE' )   ? BRAND_HERO_HEADLINE   : '',
		'hero_accent'          => defined( 'BRAND_HERO_ACCENT' )     ? BRAND_HERO_ACCENT     : '',
		'hero_body'            => defined( 'BRAND_HERO_BODY' )       ? BRAND_HERO_BODY       : '',
		'hero_trust_line'      => defined( 'BRAND_HERO_TRUST_LINE' ) ? BRAND_HERO_TRUST_LINE : '',

		/* ── Brand colors (must match :root in main.css) ────── */
		'color_primary'        => '#1B7A5A',
		'color_primary_dark'   => '#145C43',
		'color_primary_light'  => '#2E936F',
		'color_cream'          => '#FAF8F5',
		'color_sand'           => '#F3EDE4',

		/* ── Announcement bar ───────────────────────────────── */
		'announcement_enabled'     => false,
		'announcement_text'        => '',
		'announcement_link_url'    => '',
		'announcement_link_text'   => __( 'Learn more', 'flavour-clinic' ),
		'announcement_dismissible' => true,

		/* ── Trust bar (one item per line) ──────────────────── */
		'trust_bar_enabled'    => true,
		'trust_bar_items'      => implode( "\n", [
			__( 'Clinically reviewed', 'flavour-clinic' ),
			__( 'AHPRA-registered clinicians', 'flavour-clinic' ),
			__( 'Not all patients approved', 'flavour-clinic' ),
			__( 'Telehealth pathway', 'flavour-clinic' ),
		] ),

		/* ── Disclaimers ────────────────────────────────────── */
		'global_medical_disclaimer' => '',

		/* ── Footer ─────────────────────────────────────────── */
		'footer_email'         => '',
		'footer_phone'         => '',
		'footer_address'       => '',
		'footer_disclaimer'    => '',
		// One per line: "Label|https://url"
		'footer_social'        => '',
	];

	$defaults = array_merge( $defaults, fc_home_defaults(), fc_plans_defaults() );

	/**
	 * Per-page option files (inc/options/*.php) extend the registry
	 * through this filter — each adds its own page's editable defaults.
	 */
	$defaults = apply_filters( 'fc_defaults', $defaults );

	return $defaults;
}

/**
 * Plans page defaults (template-plans.php).
 *
 * Multi-item fields use one-item-per-line strings.
 *
 * @return array<string, mixed>
 */
function fc_plans_defaults() : array {
	return [
		/* ── Hero ───────────────────────────────────────────── */
		'plans_hero_eyebrow'  => 'Plans & programs',
		'plans_hero_headline' => 'Clinician-led weight loss support, structured around your life.',
		'plans_hero_accent'   => 'structured around your life',
		'plans_hero_intro'    => 'A clear pathway from eligibility to consultation, clinical review, treatment decision and ongoing support — without crash diets, pressure, or guaranteed approvals.',
		'plans_hero_image'    => '',

		/* ── What's included ────────────────────────────────── */
		'plans_inclusions_eyebrow'  => "What's included",
		'plans_inclusions_headline' => 'A structured care layer, not a product',
		'plans_inclusions_body'     => 'Every patient receives the same clinical service. Your individual care plan is shaped by your clinician — the structure underneath stays the same.',

		'plans_inclusion1_title' => 'Initial clinical consultation',
		'plans_inclusion1_body'  => 'A structured 20–30 minute telehealth consultation with an AHPRA-registered clinician. They review your intake, discuss your goals, and decide whether this pathway is clinically appropriate.',
		'plans_inclusion1_items' => "Secure video, conducted in private\nClinical assessment of your full health profile\nClear decision: approved, declined, or referred onward",

		'plans_inclusion2_title' => 'A personalised care plan',
		'plans_inclusion2_body'  => 'If your clinician determines the pathway is appropriate, you receive a personalised care plan reviewed and adjusted in response to your progress, health markers and goals.',
		'plans_inclusion2_items' => "Personalised plan from your clinician\nReviewed and adjusted over time\nContinuity with a consistent care team",

		'plans_inclusion3_title' => 'Ongoing monitoring & support',
		'plans_inclusion3_body'  => 'Scheduled clinician check-ins, lifestyle and behavioural guidance, and secure messaging between appointments. You are never left without oversight.',
		'plans_inclusion3_items' => "Scheduled clinician check-ins and reviews\nNutrition and behaviour-change resources\nSecure messaging with your care team",

		'plans_inclusion4_title' => 'Escalation & long-term continuity',
		'plans_inclusion4_body'  => 'Specialist referral when clinically indicated, coordinated handover to your GP, and a graduated maintenance pathway as your goals evolve. No lock-in: exit at any time.',
		'plans_inclusion4_items' => "Facilitated specialist referral when needed\nGraduated maintenance & reduced check-in cadence\nNo lock-in contracts — cancel any time",

		/* ── Pathway tiers / pricing ────────────────────────── */
		'plans_tiers_eyebrow'  => 'Pricing',
		'plans_tiers_headline' => 'Simple, transparent consultation fees',
		'plans_tiers_body'     => 'You pay for clinical care, not a subscription. Two fees, no hidden extras — and your clinician confirms what is appropriate for you before anything is charged.',

		// Tier prices are free text; leave empty to use the global fees
		// (Buttons & CTAs → Initial / Follow-up consultation fee).
		'plans_tier1_label'        => 'Getting started',
		'plans_tier1_title'        => 'Initial consultation',
		'plans_tier1_price'        => '',
		'plans_tier1_price_detail' => 'One-off fee · includes your intake review and clinical decision',
		'plans_tier1_summary'      => 'A comprehensive telehealth consultation with an AHPRA-registered clinician who reviews your intake, discusses your goals, and decides whether this pathway is clinically appropriate.',
		'plans_tier1_items'        => "Structured intake review\n20–30 minute video consultation\nClear decision: approved, declined, or referred onward\nPersonalised care plan if approved",

		'plans_tier2_label'        => 'Ongoing care',
		'plans_tier2_title'        => 'Follow-up consultations',
		'plans_tier2_price'        => '',
		'plans_tier2_price_detail' => 'Per consultation · script renewals and progress reviews',
		'plans_tier2_summary'      => 'Shorter reviews to renew scripts, track your progress, and adjust your care plan as your needs change.',
		'plans_tier2_items'        => "Script renewals where clinically appropriate\nProgress and health-marker reviews\nCare plan adjustments over time\nContinuity with your care team",

		'plans_tier3_label'        => 'Between visits',
		'plans_tier3_title'        => 'Support & continuity',
		'plans_tier3_price'        => 'Included',
		'plans_tier3_price_detail' => 'No additional cost between consultations',
		'plans_tier3_summary'      => 'Ongoing support between consultations, plus coordinated handover to your GP or a specialist whenever that’s the right next step.',
		'plans_tier3_items'        => "Patient portal and secure messaging\nNutrition and behaviour-change resources\nFacilitated specialist referral when needed\nNo lock-in — cancel any time",

		'plans_tiers_fineprint' => 'Consultation fees cover the clinical service only. Any clinically prescribed items are separate and subject to independent clinician decision, appropriate dispensing channels, and relevant pharmacy fees. No medication is advertised, recommended, or supplied via this website.',

		/* ── Suitability ────────────────────────────────────── */
		'plans_fit_eyebrow'   => 'Suitability',
		'plans_fit_headline'  => 'Who this is — and isn’t — for',
		'plans_fit_body'      => 'A clear, honest read on whether this pathway is the right fit before you start.',
		'plans_fit_yes_title' => 'This may suit you if',
		'plans_fit_yes_items' => "You want a structured, clinician-led pathway\nYou’re ready to commit to ongoing reviews and behaviour change\nYou’re comfortable with secure telehealth consultations\nYou value continuity over quick fixes",
		'plans_fit_no_title'  => 'This may not be right if',
		'plans_fit_no_items'  => "You’re seeking instant prescriptions without clinical review\nYour clinical presentation requires in-person assessment\nYou require urgent or specialist-only care\nYou’re looking for one-off transactional treatment",

		/* ── Compliance block ───────────────────────────────── */
		'plans_compliance_title' => 'Not every patient is approved',
		'plans_compliance_body'  => "Our clinicians exercise independent clinical judgment on every case. If this pathway isn't clinically appropriate for you, you'll be informed directly and, where possible, directed to alternative care or your primary care provider. Telehealth is not a substitute for in-person assessment when that's what your clinical presentation requires.",
		'plans_compliance_items' => "No automated approvals — every case is individually assessed\nA real-time consultation is required before any prescribing decision\nSome patients are referred to specialist or in-person care\nAll clinicians hold current AHPRA registration",

		/* ── FAQ preview ────────────────────────────────────── */
		'plans_faq_eyebrow'  => 'Common questions',
		'plans_faq_headline' => 'Before you start',
		'plans_faq_q1' => 'Am I guaranteed treatment if I book a consultation?',
		'plans_faq_a1' => 'No. A consultation is a clinical review, not a pre-approval step. Your clinician determines whether this pathway is clinically appropriate for you.',
		'plans_faq_q2' => 'What do the consultation fees cover?',
		'plans_faq_a2' => 'The initial consultation fee covers your full clinical review, suitability decision, and care plan. Follow-up consultation fees cover script renewals, progress reviews, and care-plan adjustments. Any clinically prescribed items are separate and subject to independent clinician decision and appropriate dispensing channels.',
		'plans_faq_q3' => 'Can I cancel at any time?',
		'plans_faq_a3' => 'Yes. There are no long-term contracts or cancellation fees. You can pause or cancel through your patient portal or by contacting our care team.',

		/* ── Final CTA ──────────────────────────────────────── */
		'plans_cta_headline' => 'Start with a 60-second eligibility check',
		'plans_cta_body'     => 'Answer a few structured questions. If this pathway looks suitable, you’ll be invited to complete your intake and book a consultation.',
	];
}

/**
 * Homepage section defaults (front-page.php fallback content).
 *
 * Multi-item fields use one-item-per-line strings; pipe-separated
 * columns where an item has two parts (e.g. "Label|Detail").
 *
 * @return array<string, mixed>
 */
function fc_home_defaults() : array {
	return [
		/* ── Hero slide 1: clinician-led care ───────────────── */
		'home_slide1_eyebrow'     => 'Specialist-led telehealth',
		'home_slide1_headline'    => 'Clinician-led weight management.',
		'home_slide1_body'        => 'A structured pathway reviewed by registered Australian clinicians.',
		'home_slide1_cta_text'    => 'Check Eligibility',
		'home_slide1_image'       => '',
		'home_slide1_reassurance' => "Private & secure\nClinician-reviewed\nTakes about 2 minutes",

		/* ── Hero slide 2: outcomes ─────────────────────────── */
		'home_slide2_eyebrow'  => 'Structured clinical support',
		'home_slide2_headline' => 'Built around consistency, accountability, and long-term care.',
		'home_slide2_body'     => 'Patients follow a structured pathway with clinician oversight, ongoing reviews, and personalised support where clinically appropriate.',
		'home_slide2_stats'    => implode( "\n", [
			'Australian-registered clinicians|Reviewed by AHPRA-registered doctors',
			'Ongoing clinical reviews|Structured check-ins, not one-offs',
			'Private telehealth pathway|No waiting rooms, no pharmacy queues',
			'Doctor-led assessment|Suitability decided by a clinician',
		] ),

		/* ── Hero slide 3: pricing / private pathway ────────── */
		'home_slide3_eyebrow'       => 'Private weight management',
		'home_slide3_headline'      => 'A structured pathway, built around you.',
		'home_slide3_body'          => 'Start with a structured intake and an initial consultation with a registered clinician. If suitable, your clinician outlines a personalised treatment and support plan, with discreet delivery where clinically appropriate.',
		'home_slide3_image'         => '',
		'home_slide3_price_lead'    => '', // empty = "$" + initial consultation fee
		'home_slide3_price_suffix'  => 'initial consultation',
		'home_slide3_price_caption' => '', // empty = generated from follow-up fee
		'home_slide3_footnote'      => 'Final suitability is determined through clinical review. Not all patients are approved.',

		/* ── Governance strip (one per line: "icon|Title") ──── */
		'home_governance_points' => implode( "\n", [
			'shield|AHPRA-registered clinicians',
			'stethoscope|Doctor-led decisions',
			'lock|Australian Privacy Act',
			'heart|Not all patients approved',
		] ),

		/* ── Specialist pathway (how it works) ──────────────── */
		'home_pathway_eyebrow'    => 'How it works',
		'home_pathway_headline'   => 'A short pathway,<br><span>three quiet steps.</span>',
		'home_pathway_intro'      => '', // empty = generated from specialist name
		'home_pathway_step1_title'=> 'Complete a short assessment',
		'home_pathway_step1_body' => 'Answer a few confidential questions so the clinical team can understand your goals, medical history, and suitability for care.',
		'home_pathway_step1_image'=> '',
		'home_pathway_step2_title'=> 'Book your doctor consultation',
		'home_pathway_step2_body' => '', // empty = generated from specialist name
		'home_pathway_step2_image'=> '',
		'home_pathway_step3_title'=> 'Receive your personalised pathway',
		'home_pathway_step3_body' => 'If suitable, your clinician outlines a structured treatment and support plan, with discreet delivery where clinically appropriate.',
		'home_pathway_step3_image'=> '',

		/* ── Split content (led by specialist) ──────────────── */
		'home_split_headline'  => 'Experienced. Measured. Clinically led.',
		'home_split_accent'    => 'Clinically led.',
		'home_split_body'      => '', // empty = generated from specialist name
		'home_split_image'     => '',

		/* ── CTA starter (inline assessment) ────────────────── */
		'home_starter_eyebrow'   => 'Eligibility check',
		'home_starter_headline'  => 'Start with a short eligibility check',
		'home_starter_body'      => 'Answer the first question now. It takes about 2 minutes, and your answers are reviewed before any next steps are confirmed.',
		'home_starter_cta_text'  => 'Continue assessment',
		'home_starter_question'  => 'What is your main reason for seeking support?',
		'home_starter_options'   => implode( "\n", [
			'I want to lose weight safely|lose-safely',
			'I have struggled to maintain weight loss|maintain',
			'I want clinician-led guidance|clinician-led',
			'I want to understand whether I may be suitable|eligibility',
		] ),
		'home_starter_microcopy' => 'Private and secure. Not all patients are approved. Final suitability is determined by a registered Australian clinician.',
	];
}

/**
 * Page hero defaults, keyed by page: eyebrow / headline / accent / intro.
 *
 * Each page template's hero reads these via fc_page_hero(); the Customizer
 * registers a section per page so editors can change hero copy without code.
 *
 * @return array<string, array<string, string>>
 */
function fc_page_hero_defaults() : array {
	return [
		'faq' => [
			'label'    => __( 'FAQ Page', 'flavour-clinic' ),
			'eyebrow'  => 'Questions before you begin',
			'headline' => 'Straight answers, no fine print.',
			'accent'   => 'no fine print',
			'intro'    => 'The questions patients actually ask before starting the pathway. If something you need isn&rsquo;t covered here, our care team will answer directly.',
		],
	];
}

/**
 * Resolve a theme setting: Customizer value with registry default.
 *
 * A saved empty string falls back to the default when the default is
 * non-empty — this keeps required values (URLs, button labels) from
 * silently breaking when a control is cleared. Optional fields (empty
 * default) stay clearable.
 *
 * @param string $key      Setting key (without the fc_ prefix).
 * @param mixed  $fallback Optional explicit default (overrides registry).
 * @return mixed
 */
function fc_setting( string $key, $fallback = null ) {
	$defaults = fc_defaults();
	$default  = $fallback ?? ( $defaults[ $key ] ?? '' );

	$value = get_theme_mod( 'fc_' . $key, $default );

	if ( is_string( $value ) && '' === trim( $value ) && is_string( $default ) && '' !== $default ) {
		return $default;
	}

	return $value;
}

/**
 * Resolve a multi-line setting into a clean array of lines.
 *
 * @param string $key Setting key.
 * @return string[]
 */
function fc_setting_lines( string $key ) : array {
	$raw   = (string) fc_setting( $key );
	$lines = array_map( 'trim', preg_split( '/\r\n|\r|\n/', $raw ) );

	return array_values( array_filter( $lines, 'strlen' ) );
}

/**
 * Resolve a multi-line "A|B" setting into an array of associative rows.
 *
 * @param string $key  Setting key.
 * @param array  $cols Column names, e.g. [ 'label', 'value' ].
 * @return array<int, array<string, string>>
 */
function fc_setting_pairs( string $key, array $cols = [ 'label', 'value' ] ) : array {
	$rows = [];

	foreach ( fc_setting_lines( $key ) as $line ) {
		$parts = array_map( 'trim', explode( '|', $line ) );
		$row   = [];
		foreach ( $cols as $i => $col ) {
			$row[ $col ] = $parts[ $i ] ?? '';
		}
		$rows[] = $row;
	}

	return $rows;
}

/**
 * Resolve an image setting to a URL, with a theme-asset fallback.
 *
 * Customizer image controls store a URL; empty means "use the default
 * image that ships with the theme".
 *
 * @param string $key          Setting key.
 * @param string $fallback_url Default image URL.
 * @return string
 */
function fc_setting_image( string $key, string $fallback_url = '' ) : string {
	$url = (string) fc_setting( $key, '' );

	return $url ?: $fallback_url;
}

/**
 * Resolve a page-hero value for a given page key.
 *
 * @param string $page  Page key from fc_page_hero_defaults().
 * @param string $field eyebrow|headline|accent|intro.
 * @return string
 */
function fc_page_hero( string $page, string $field ) : string {
	$pages   = fc_page_hero_defaults();
	$default = $pages[ $page ][ $field ] ?? '';

	$value = get_theme_mod( 'fc_page_' . $page . '_' . $field, $default );

	if ( is_string( $value ) && '' === trim( $value ) ) {
		return $default;
	}

	return (string) $value;
}
