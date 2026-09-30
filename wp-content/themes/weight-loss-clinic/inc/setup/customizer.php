<?php
/**
 * Customizer registration.
 *
 * Registers every editable theme setting under Appearance → Customize →
 * Theme Settings. Defaults come from fc_defaults() / fc_page_hero_defaults()
 * (which in turn read brand-config.php), so an untouched Customizer renders
 * the site exactly as shipped.
 *
 * Field conventions:
 *   - Settings are theme_mods named "fc_{key}".
 *   - Multi-item fields are textareas, one item per line.
 *   - Two-part items use "First part|Second part" per line.
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Sanitize a checkbox value.
 */
function fc_sanitize_checkbox( $value ) : bool {
	return (bool) $value;
}

/**
 * Sanitize a URL that may be a relative path ("/quiz/") or absolute URL.
 */
function fc_sanitize_path_or_url( $value ) : string {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	// Allow bare fragments like "#stripe-not-configured".
	if ( 0 === strpos( $value, '#' ) ) {
		return sanitize_text_field( $value );
	}

	return esc_url_raw( $value );
}

/**
 * Sanitize limited inline HTML (span/br/strong/em) for headlines.
 */
function fc_sanitize_inline_html( $value ) : string {
	return wp_kses( (string) $value, [
		'span'   => [ 'class' => [] ],
		'br'     => [],
		'strong' => [],
		'em'     => [],
	] );
}

/**
 * Register a theme setting + Customizer control in one call.
 *
 * Shared by the core registration below and the per-page option files in
 * inc/options/ so every field behaves identically.
 *
 * @param WP_Customize_Manager $wp_customize Customizer instance.
 * @param string               $key          Setting key (theme_mod becomes fc_{key}).
 * @param string               $section      Section id.
 * @param string               $label        Control label.
 * @param string               $type         text|textarea|richtext|html|checkbox|url|color|image
 * @param string               $desc         Optional control description.
 */
function fc_customizer_add_field( WP_Customize_Manager $wp_customize, string $key, string $section, string $label, string $type = 'text', string $desc = '' ) : void {

	$defaults   = fc_defaults();
	$sanitizers = [
		'text'     => 'sanitize_text_field',
		'textarea' => 'sanitize_textarea_field',
		'richtext' => 'wp_kses_post',
		'html'     => 'fc_sanitize_inline_html',
		'checkbox' => 'fc_sanitize_checkbox',
		'url'      => 'fc_sanitize_path_or_url',
		'color'    => 'sanitize_hex_color',
		'image'    => 'esc_url_raw',
	];

	$wp_customize->add_setting( 'fc_' . $key, [
		'type'              => 'theme_mod',
		'default'           => $defaults[ $key ] ?? '',
		'sanitize_callback' => $sanitizers[ $type ] ?? 'sanitize_text_field',
	] );

	$control_args = [
		'section'     => $section,
		'label'       => $label,
		'description' => $desc,
	];

	if ( 'color' === $type ) {
		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'fc_' . $key, $control_args ) );
		return;
	}

	if ( 'image' === $type ) {
		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'fc_' . $key, $control_args ) );
		return;
	}

	$control_args['type'] = in_array( $type, [ 'textarea', 'richtext', 'html' ], true ) ? 'textarea' : ( 'url' === $type ? 'text' : $type );
	$wp_customize->add_control( 'fc_' . $key, $control_args );
}

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {

	$defaults = fc_defaults();

	/* ═══════════════════════════════════════════════════════════
	   Panel
	   ═══════════════════════════════════════════════════════════ */
	$wp_customize->add_panel( 'fc_theme_settings', [
		'title'       => __( 'Theme Settings', 'flavour-clinic' ),
		'description' => __( 'Brand content, colors, CTAs, and homepage sections. Multi-item fields take one item per line; use "First|Second" for two-part items.', 'flavour-clinic' ),
		'priority'    => 10,
	] );

	$sections = [
		'fc_brand'        => __( 'Brand & Specialist', 'flavour-clinic' ),
		'fc_ctas'         => __( 'Buttons & CTAs', 'flavour-clinic' ),
		'fc_urls'         => __( 'Page URLs & Endpoints', 'flavour-clinic' ),
		'fc_colors'       => __( 'Brand Colors', 'flavour-clinic' ),
		'fc_announcement' => __( 'Announcement Bar', 'flavour-clinic' ),
		'fc_trust_bar'    => __( 'Trust Bar', 'flavour-clinic' ),
		'fc_footer'       => __( 'Footer', 'flavour-clinic' ),
		'fc_home_hero'    => __( 'Homepage — Hero Carousel', 'flavour-clinic' ),
		'fc_home_body'    => __( 'Homepage — Sections', 'flavour-clinic' ),
		'fc_plans_top'    => __( 'Plans Page — Hero & Inclusions', 'flavour-clinic' ),
		'fc_plans_body'   => __( 'Plans Page — Pathway & Sections', 'flavour-clinic' ),
	];

	$priority = 10;
	foreach ( $sections as $id => $title ) {
		$wp_customize->add_section( $id, [
			'panel'    => 'fc_theme_settings',
			'title'    => $title,
			'priority' => $priority,
		] );
		$priority += 10;
	}

	$add = function ( string $key, string $section, string $label, string $type = 'text', string $desc = '' ) use ( $wp_customize ) {
		fc_customizer_add_field( $wp_customize, $key, $section, $label, $type, $desc );
	};

	/* ═══════════════════════════════════════════════════════════
	   Brand & Specialist
	   ═══════════════════════════════════════════════════════════ */
	$add( 'brand_name',       'fc_brand', __( 'Brand Name', 'flavour-clinic' ), 'text', __( 'Used in emails and admin notices. The site logo/title comes from Site Identity.', 'flavour-clinic' ) );
	$add( 'brand_tagline',    'fc_brand', __( 'Tagline', 'flavour-clinic' ) );
	$add( 'specialist_name',  'fc_brand', __( 'Lead Specialist — Name', 'flavour-clinic' ), 'text', __( 'Threaded across the hero, about, and clinician-led pages.', 'flavour-clinic' ) );
	$add( 'specialist_title', 'fc_brand', __( 'Lead Specialist — Title', 'flavour-clinic' ), 'html' );
	$add( 'specialist_cred',  'fc_brand', __( 'Lead Specialist — Credential', 'flavour-clinic' ) );

	/* ═══════════════════════════════════════════════════════════
	   Buttons & CTAs
	   ═══════════════════════════════════════════════════════════ */
	$add( 'cta_text',         'fc_ctas', __( 'Primary CTA — Text', 'flavour-clinic' ) );
	$add( 'cta_url',          'fc_ctas', __( 'Primary CTA — URL', 'flavour-clinic' ), 'url' );
	$add( 'booking_cta_text', 'fc_ctas', __( 'Booking CTA — Text', 'flavour-clinic' ) );
	$add( 'portal_cta_text',  'fc_ctas', __( 'Portal Link — Text', 'flavour-clinic' ) );
	$add( 'intake_cta_text',  'fc_ctas', __( 'Intake CTA — Text', 'flavour-clinic' ) );
	$add( 'price_from',       'fc_ctas', __( 'Initial Consultation Fee (dollars, number only)', 'flavour-clinic' ), 'text', __( 'Shown on the Plans page, homepage pricing slide, and funnel.', 'flavour-clinic' ) );
	$add( 'price_followup',   'fc_ctas', __( 'Follow-up Consultation Fee (dollars, number only)', 'flavour-clinic' ), 'text', __( 'Fee for script-renewal / progress-review consultations.', 'flavour-clinic' ) );
	$add( 'support_email',    'fc_ctas', __( 'Support Email', 'flavour-clinic' ) );
	$add( 'support_phone',    'fc_ctas', __( 'Support Phone', 'flavour-clinic' ) );
	$add( 'nav_treatments_label', 'fc_ctas', __( 'Footer Nav — Treatments Column Label', 'flavour-clinic' ) );
	$add( 'testimonials_eyebrow', 'fc_ctas', __( 'Testimonials Section — Eyebrow', 'flavour-clinic' ) );

	/* ═══════════════════════════════════════════════════════════
	   Page URLs & Endpoints
	   ═══════════════════════════════════════════════════════════ */
	$urls = [
		'booking_url'      => __( 'Booking page', 'flavour-clinic' ),
		'portal_url'       => __( 'Patient portal', 'flavour-clinic' ),
		'intake_url'       => __( 'Patient intake', 'flavour-clinic' ),
		'dashboard_url'    => __( 'Patient dashboard', 'flavour-clinic' ),
		'plans_url'        => __( 'Plans page', 'flavour-clinic' ),
		'how_it_works_url' => __( 'How It Works page', 'flavour-clinic' ),
		'about_url'        => __( 'About page', 'flavour-clinic' ),
		'faq_url'          => __( 'FAQ page', 'flavour-clinic' ),
		'clinician_url'    => __( 'Clinician-Led Care page', 'flavour-clinic' ),
		'contact_url'      => __( 'Contact page', 'flavour-clinic' ),
		'checkout_url'     => __( 'Checkout endpoint', 'flavour-clinic' ),
		'review_url'       => __( 'Review endpoint', 'flavour-clinic' ),
		'stripe_url'       => __( 'Stripe payment link', 'flavour-clinic' ),
		'thankyou_url'     => __( 'Thank-you page', 'flavour-clinic' ),
	];
	foreach ( $urls as $key => $label ) {
		$add( $key, 'fc_urls', $label, 'url' );
	}

	/* ═══════════════════════════════════════════════════════════
	   Brand Colors
	   ═══════════════════════════════════════════════════════════ */
	$add( 'color_primary',       'fc_colors', __( 'Primary', 'flavour-clinic' ), 'color', __( 'Buttons, links, and accents.', 'flavour-clinic' ) );
	$add( 'color_primary_dark',  'fc_colors', __( 'Primary Dark', 'flavour-clinic' ), 'color', __( 'Hover states and gradients.', 'flavour-clinic' ) );
	$add( 'color_primary_light', 'fc_colors', __( 'Primary Light', 'flavour-clinic' ), 'color', __( 'Secondary accents and section tinting.', 'flavour-clinic' ) );
	$add( 'color_cream',         'fc_colors', __( 'Soft Background', 'flavour-clinic' ), 'color', __( 'Alternating section backgrounds and cards.', 'flavour-clinic' ) );
	$add( 'color_sand',          'fc_colors', __( 'Sand / Muted Surface', 'flavour-clinic' ), 'color', __( 'Trust strips and alternate surfaces.', 'flavour-clinic' ) );

	/* ═══════════════════════════════════════════════════════════
	   Announcement Bar
	   ═══════════════════════════════════════════════════════════ */
	$add( 'announcement_enabled',     'fc_announcement', __( 'Enable announcement bar', 'flavour-clinic' ), 'checkbox' );
	$add( 'announcement_text',        'fc_announcement', __( 'Text', 'flavour-clinic' ) );
	$add( 'announcement_link_url',    'fc_announcement', __( 'Link URL (optional)', 'flavour-clinic' ), 'url' );
	$add( 'announcement_link_text',   'fc_announcement', __( 'Link text', 'flavour-clinic' ) );
	$add( 'announcement_dismissible', 'fc_announcement', __( 'Dismissible', 'flavour-clinic' ), 'checkbox' );

	/* ═══════════════════════════════════════════════════════════
	   Trust Bar
	   ═══════════════════════════════════════════════════════════ */
	$add( 'trust_bar_enabled', 'fc_trust_bar', __( 'Show trust bar', 'flavour-clinic' ), 'checkbox' );
	$add( 'trust_bar_items',   'fc_trust_bar', __( 'Items (one per line)', 'flavour-clinic' ), 'textarea' );

	/* ═══════════════════════════════════════════════════════════
	   Footer
	   ═══════════════════════════════════════════════════════════ */
	$add( 'footer_email',      'fc_footer', __( 'Contact email', 'flavour-clinic' ) );
	$add( 'footer_phone',      'fc_footer', __( 'Contact phone', 'flavour-clinic' ) );
	$add( 'footer_address',    'fc_footer', __( 'Address', 'flavour-clinic' ) );
	$add( 'footer_disclaimer', 'fc_footer', __( 'Disclaimer', 'flavour-clinic' ), 'richtext', __( 'Leave empty to use the built-in compliant disclaimer.', 'flavour-clinic' ) );
	$add( 'footer_social',     'fc_footer', __( 'Social links (one per line: "Label|https://url")', 'flavour-clinic' ), 'textarea' );
	$add( 'global_medical_disclaimer', 'fc_footer', __( 'Global medical disclaimer (shown by in-page disclaimer blocks)', 'flavour-clinic' ), 'richtext' );

	/* ═══════════════════════════════════════════════════════════
	   Homepage — Hero Carousel
	   ═══════════════════════════════════════════════════════════ */
	$add( 'home_slide1_eyebrow',     'fc_home_hero', __( 'Slide 1 — Eyebrow', 'flavour-clinic' ) );
	$add( 'home_slide1_headline',    'fc_home_hero', __( 'Slide 1 — Headline', 'flavour-clinic' ) );
	$add( 'home_slide1_body',        'fc_home_hero', __( 'Slide 1 — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'home_slide1_cta_text',    'fc_home_hero', __( 'Slide 1 — Button text', 'flavour-clinic' ) );
	$add( 'home_slide1_image',       'fc_home_hero', __( 'Slide 1 — Image', 'flavour-clinic' ), 'image' );
	$add( 'home_slide1_reassurance', 'fc_home_hero', __( 'Slide 1 — Reassurance points (one per line)', 'flavour-clinic' ), 'textarea' );

	$add( 'home_slide2_eyebrow',  'fc_home_hero', __( 'Slide 2 — Eyebrow', 'flavour-clinic' ) );
	$add( 'home_slide2_headline', 'fc_home_hero', __( 'Slide 2 — Headline', 'flavour-clinic' ) );
	$add( 'home_slide2_body',     'fc_home_hero', __( 'Slide 2 — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'home_slide2_stats',    'fc_home_hero', __( 'Slide 2 — Stat blocks (one per line: "Label|Detail")', 'flavour-clinic' ), 'textarea' );

	$add( 'home_slide3_eyebrow',       'fc_home_hero', __( 'Slide 3 — Eyebrow', 'flavour-clinic' ) );
	$add( 'home_slide3_headline',      'fc_home_hero', __( 'Slide 3 — Headline', 'flavour-clinic' ) );
	$add( 'home_slide3_body',          'fc_home_hero', __( 'Slide 3 — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'home_slide3_image',         'fc_home_hero', __( 'Slide 3 — Image', 'flavour-clinic' ), 'image' );
	$add( 'home_slide3_price_lead',    'fc_home_hero', __( 'Slide 3 — Price figure (e.g. "$180")', 'flavour-clinic' ), 'text', __( 'Leave empty to use the Initial Consultation Fee from Buttons & CTAs.', 'flavour-clinic' ) );
	$add( 'home_slide3_price_suffix',  'fc_home_hero', __( 'Slide 3 — Price suffix', 'flavour-clinic' ) );
	$add( 'home_slide3_price_caption', 'fc_home_hero', __( 'Slide 3 — Price caption', 'flavour-clinic' ), 'text', __( 'Leave empty to auto-generate from the Follow-up Consultation Fee.', 'flavour-clinic' ) );
	$add( 'home_slide3_footnote',      'fc_home_hero', __( 'Slide 3 — Footnote', 'flavour-clinic' ) );

	/* ═══════════════════════════════════════════════════════════
	   Homepage — Sections
	   ═══════════════════════════════════════════════════════════ */
	$add( 'home_governance_points', 'fc_home_body', __( 'Governance strip (one per line: "icon|Title")', 'flavour-clinic' ), 'textarea', __( 'Icons: shield, stethoscope, lock, heart.', 'flavour-clinic' ) );

	$add( 'home_pathway_eyebrow',  'fc_home_body', __( 'Pathway — Eyebrow', 'flavour-clinic' ) );
	$add( 'home_pathway_headline', 'fc_home_body', __( 'Pathway — Headline', 'flavour-clinic' ), 'html', __( 'Supports <br> and <span> for the accent line.', 'flavour-clinic' ) );
	$add( 'home_pathway_intro',    'fc_home_body', __( 'Pathway — Intro', 'flavour-clinic' ), 'textarea', __( 'Leave empty to auto-generate from the lead specialist name.', 'flavour-clinic' ) );
	foreach ( [ 1, 2, 3 ] as $n ) {
		$add( "home_pathway_step{$n}_title", 'fc_home_body', sprintf( __( 'Pathway — Step %d title', 'flavour-clinic' ), $n ) );
		$add( "home_pathway_step{$n}_body",  'fc_home_body', sprintf( __( 'Pathway — Step %d body', 'flavour-clinic' ), $n ), 'textarea' );
		$add( "home_pathway_step{$n}_image", 'fc_home_body', sprintf( __( 'Pathway — Step %d image', 'flavour-clinic' ), $n ), 'image' );
	}

	$add( 'home_split_headline', 'fc_home_body', __( 'Specialist intro — Headline', 'flavour-clinic' ) );
	$add( 'home_split_accent',   'fc_home_body', __( 'Specialist intro — Accent words', 'flavour-clinic' ), 'text', __( 'Part of the headline to highlight.', 'flavour-clinic' ) );
	$add( 'home_split_body',     'fc_home_body', __( 'Specialist intro — Body', 'flavour-clinic' ), 'textarea', __( 'Leave empty to auto-generate from the lead specialist name.', 'flavour-clinic' ) );
	$add( 'home_split_image',    'fc_home_body', __( 'Specialist intro — Image', 'flavour-clinic' ), 'image' );

	$add( 'home_starter_eyebrow',   'fc_home_body', __( 'Final CTA — Eyebrow', 'flavour-clinic' ) );
	$add( 'home_starter_headline',  'fc_home_body', __( 'Final CTA — Headline', 'flavour-clinic' ) );
	$add( 'home_starter_body',      'fc_home_body', __( 'Final CTA — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'home_starter_cta_text',  'fc_home_body', __( 'Final CTA — Button text', 'flavour-clinic' ) );
	$add( 'home_starter_question',  'fc_home_body', __( 'Final CTA — Starter question', 'flavour-clinic' ) );
	$add( 'home_starter_options',   'fc_home_body', __( 'Final CTA — Answer options (one per line: "Label|value")', 'flavour-clinic' ), 'textarea' );
	$add( 'home_starter_microcopy', 'fc_home_body', __( 'Final CTA — Microcopy', 'flavour-clinic' ), 'textarea' );

	/* ═══════════════════════════════════════════════════════════
	   Plans Page — Hero & Inclusions
	   ═══════════════════════════════════════════════════════════ */
	$add( 'plans_hero_eyebrow',  'fc_plans_top', __( 'Hero — Eyebrow', 'flavour-clinic' ) );
	$add( 'plans_hero_headline', 'fc_plans_top', __( 'Hero — Headline', 'flavour-clinic' ) );
	$add( 'plans_hero_accent',   'fc_plans_top', __( 'Hero — Accent words', 'flavour-clinic' ) );
	$add( 'plans_hero_intro',    'fc_plans_top', __( 'Hero — Intro', 'flavour-clinic' ), 'textarea' );
	$add( 'plans_hero_image',    'fc_plans_top', __( 'Hero — Image', 'flavour-clinic' ), 'image' );

	$add( 'plans_inclusions_eyebrow',  'fc_plans_top', __( 'Inclusions — Eyebrow', 'flavour-clinic' ) );
	$add( 'plans_inclusions_headline', 'fc_plans_top', __( 'Inclusions — Headline', 'flavour-clinic' ) );
	$add( 'plans_inclusions_body',     'fc_plans_top', __( 'Inclusions — Body', 'flavour-clinic' ), 'textarea' );

	foreach ( [ 1, 2, 3, 4 ] as $n ) {
		$add( "plans_inclusion{$n}_title", 'fc_plans_top', sprintf( __( 'Inclusion %d — Title', 'flavour-clinic' ), $n ) );
		$add( "plans_inclusion{$n}_body",  'fc_plans_top', sprintf( __( 'Inclusion %d — Body', 'flavour-clinic' ), $n ), 'textarea' );
		$add( "plans_inclusion{$n}_items", 'fc_plans_top', sprintf( __( 'Inclusion %d — Bullet points (one per line)', 'flavour-clinic' ), $n ), 'textarea' );
	}

	/* ═══════════════════════════════════════════════════════════
	   Plans Page — Pathway & Sections
	   ═══════════════════════════════════════════════════════════ */
	$add( 'plans_tiers_eyebrow',  'fc_plans_body', __( 'Pathway — Eyebrow', 'flavour-clinic' ) );
	$add( 'plans_tiers_headline', 'fc_plans_body', __( 'Pathway — Headline', 'flavour-clinic' ) );
	$add( 'plans_tiers_body',     'fc_plans_body', __( 'Pathway — Body', 'flavour-clinic' ), 'textarea' );

	foreach ( [ 1, 2, 3 ] as $n ) {
		$add( "plans_tier{$n}_label",        'fc_plans_body', sprintf( __( 'Tier %d — Label', 'flavour-clinic' ), $n ) );
		$add( "plans_tier{$n}_title",        'fc_plans_body', sprintf( __( 'Tier %d — Title', 'flavour-clinic' ), $n ) );
		$add( "plans_tier{$n}_price",        'fc_plans_body', sprintf( __( 'Tier %d — Price (e.g. "$180" or "Included")', 'flavour-clinic' ), $n ), 'text', __( 'Leave empty to use the consultation fees from Buttons & CTAs.', 'flavour-clinic' ) );
		$add( "plans_tier{$n}_price_detail", 'fc_plans_body', sprintf( __( 'Tier %d — Price detail line', 'flavour-clinic' ), $n ) );
		$add( "plans_tier{$n}_summary",      'fc_plans_body', sprintf( __( 'Tier %d — Summary', 'flavour-clinic' ), $n ), 'textarea' );
		$add( "plans_tier{$n}_items",        'fc_plans_body', sprintf( __( 'Tier %d — Bullet points (one per line)', 'flavour-clinic' ), $n ), 'textarea' );
	}
	$add( 'plans_tiers_fineprint', 'fc_plans_body', __( 'Pathway — Fine print', 'flavour-clinic' ), 'textarea' );

	$add( 'plans_fit_eyebrow',   'fc_plans_body', __( 'Suitability — Eyebrow', 'flavour-clinic' ) );
	$add( 'plans_fit_headline',  'fc_plans_body', __( 'Suitability — Headline', 'flavour-clinic' ) );
	$add( 'plans_fit_body',      'fc_plans_body', __( 'Suitability — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'plans_fit_yes_title', 'fc_plans_body', __( 'Suitability — "Suits you" card title', 'flavour-clinic' ) );
	$add( 'plans_fit_yes_items', 'fc_plans_body', __( 'Suitability — "Suits you" points (one per line)', 'flavour-clinic' ), 'textarea' );
	$add( 'plans_fit_no_title',  'fc_plans_body', __( 'Suitability — "Not right" card title', 'flavour-clinic' ) );
	$add( 'plans_fit_no_items',  'fc_plans_body', __( 'Suitability — "Not right" points (one per line)', 'flavour-clinic' ), 'textarea' );

	$add( 'plans_compliance_title', 'fc_plans_body', __( 'Compliance — Title', 'flavour-clinic' ) );
	$add( 'plans_compliance_body',  'fc_plans_body', __( 'Compliance — Body', 'flavour-clinic' ), 'textarea' );
	$add( 'plans_compliance_items', 'fc_plans_body', __( 'Compliance — Points (one per line)', 'flavour-clinic' ), 'textarea' );

	$add( 'plans_faq_eyebrow',  'fc_plans_body', __( 'FAQ preview — Eyebrow', 'flavour-clinic' ) );
	$add( 'plans_faq_headline', 'fc_plans_body', __( 'FAQ preview — Headline', 'flavour-clinic' ) );
	foreach ( [ 1, 2, 3 ] as $n ) {
		$add( "plans_faq_q{$n}", 'fc_plans_body', sprintf( __( 'FAQ preview — Question %d', 'flavour-clinic' ), $n ) );
		$add( "plans_faq_a{$n}", 'fc_plans_body', sprintf( __( 'FAQ preview — Answer %d', 'flavour-clinic' ), $n ), 'textarea' );
	}

	$add( 'plans_cta_headline', 'fc_plans_body', __( 'Final CTA — Headline', 'flavour-clinic' ) );
	$add( 'plans_cta_body',     'fc_plans_body', __( 'Final CTA — Body', 'flavour-clinic' ), 'textarea' );

	/* ═══════════════════════════════════════════════════════════
	   Page Heroes (one section per templated page)
	   ═══════════════════════════════════════════════════════════ */
	foreach ( fc_page_hero_defaults() as $page => $fields ) {
		$section_id = 'fc_page_' . $page;

		$wp_customize->add_section( $section_id, [
			'panel'    => 'fc_theme_settings',
			'title'    => sprintf( __( 'Page Hero — %s', 'flavour-clinic' ), $fields['label'] ?? ucfirst( $page ) ),
			'priority' => $priority,
		] );
		$priority += 10;

		$hero_fields = [
			'eyebrow'  => [ __( 'Eyebrow', 'flavour-clinic' ), 'text' ],
			'headline' => [ __( 'Headline', 'flavour-clinic' ), 'text' ],
			'accent'   => [ __( 'Accent words (part of headline to highlight)', 'flavour-clinic' ), 'text' ],
			'intro'    => [ __( 'Intro paragraph', 'flavour-clinic' ), 'textarea' ],
		];

		foreach ( $hero_fields as $field => $meta ) {
			$setting_id = 'fc_page_' . $page . '_' . $field;

			$wp_customize->add_setting( $setting_id, [
				'type'              => 'theme_mod',
				'default'           => $fields[ $field ] ?? '',
				'sanitize_callback' => 'textarea' === $meta[1] ? 'wp_kses_post' : 'sanitize_text_field',
			] );

			$wp_customize->add_control( $setting_id, [
				'section' => $section_id,
				'label'   => $meta[0],
				'type'    => $meta[1],
			] );
		}
	}
} );
