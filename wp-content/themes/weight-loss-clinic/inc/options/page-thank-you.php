<?php
/**
 * Editable content: Thank You / Confirmation page (template-thank-you.php).
 */

defined( 'ABSPATH' ) || exit;

add_filter( 'fc_defaults', function ( array $defaults ) : array {
	return array_merge( $defaults, [
		/* ── Header ─────────────────────────────────────────── */
		'thanks_hero_eyebrow'  => 'Submission received',
		'thanks_hero_headline' => 'Your assessment has been submitted',
		'thanks_hero_subhead'  => 'An Australian-registered clinician will review your information and contact you with the next step. Final suitability is determined after clinical review. Not all patients are approved.',

		/* ── Timeline (one per line: "Title|Detail") ────────── */
		'thanks_timeline_heading' => 'What happens next',
		'thanks_steps'            => implode( "\n", [
			'Clinician review|A registered Australian clinician reviews your assessment within 1–2 business days.',
			'We confirm the right next step|If a clinician-led consultation is appropriate, we send a confirmation email with your time and joining details. If a different pathway is safer, the clinic will contact you to discuss.',
			'Personalised plan, if clinically appropriate|If clinically appropriate, your clinician outlines a personalised next-step plan with structured follow-up and ongoing review.',
		] ),

		/* ── Prep checklist ─────────────────────────────────── */
		'thanks_prep_heading'    => 'Before your consultation',
		'thanks_prep_intro'      => 'A short prep checklist so the consultation makes the best use of your time.',
		'thanks_checklist_items' => implode( "\n", [
			'Have your current weight (kg) and height (cm) ready.',
			'Prepare any relevant medical history or recent results you would like to discuss.',
			'List current medications and any allergies.',
			'Check your email for confirmation — including your spam folder.',
		] ),
		'thanks_calendar_label' => 'Add to calendar',
		'thanks_calendar_note'  => 'A calendar invite is included with your confirmation email once your consultation time is set. If you don’t receive it within 24 hours, get in touch.',

		/* ── Important to know ──────────────────────────────── */
		'thanks_important_heading' => 'Important to know',
		'thanks_important_items'   => implode( "\n", [
			'This is a clinical review, not automatic approval. Final suitability is determined by an Australian-registered clinician.',
			'Your information is handled in accordance with the Australian Privacy Act and shared only with the clinical team reviewing your case.',
			'This pathway is not a replacement for your relationship with your GP. We recommend keeping your primary care provider informed.',
		] ),

		/* ── Support ────────────────────────────────────────── */
		// NOTE: get_theme_mod() sprintf()s string defaults with the theme URI,
		// so "%s" cannot be used as a placeholder here — "{email}" / "{contact}"
		// tokens are swapped in by the template instead.
		'thanks_support_heading'  => 'Need help?',
		// {email} is replaced by the support email link (Brand & Specialist → Support Email).
		'thanks_support_body'     => 'Our care team is at {email} and typically responds within one business day.',
		// Shown when no support email is set; {contact} is replaced by the contact-page link.
		'thanks_support_body_alt' => 'Our care team responds within one business day. {contact} if anything looks wrong.',

		/* ── CTAs ───────────────────────────────────────────── */
		'thanks_cta_booking_text' => 'Manage your booking',
		'thanks_cta_home_text'    => 'Return to homepage',
	] );
} );

add_action( 'customize_register', function ( WP_Customize_Manager $wp_customize ) {
	$wp_customize->add_section( 'fc_page_thank_you', [
		'panel'    => 'fc_theme_settings',
		'title'    => __( 'Page — Thank You', 'flavour-clinic' ),
		'priority' => 280,
	] );

	fc_customizer_add_field( $wp_customize, 'thanks_hero_eyebrow', 'fc_page_thank_you', __( 'Header — Eyebrow', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_hero_headline', 'fc_page_thank_you', __( 'Header — Headline', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_hero_subhead', 'fc_page_thank_you', __( 'Header — Subheading', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'thanks_timeline_heading', 'fc_page_thank_you', __( 'Timeline — Heading', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_steps', 'fc_page_thank_you', __( 'Timeline — Steps', 'flavour-clinic' ), 'textarea', __( 'One step per line: "Title|Detail".', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_prep_heading', 'fc_page_thank_you', __( 'Prep — Heading', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_prep_intro', 'fc_page_thank_you', __( 'Prep — Intro', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'thanks_checklist_items', 'fc_page_thank_you', __( 'Prep — Checklist Items', 'flavour-clinic' ), 'textarea', __( 'One item per line.', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_calendar_label', 'fc_page_thank_you', __( 'Calendar — Label', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_calendar_note', 'fc_page_thank_you', __( 'Calendar — Note', 'flavour-clinic' ), 'textarea' );
	fc_customizer_add_field( $wp_customize, 'thanks_important_heading', 'fc_page_thank_you', __( 'Important — Heading', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_important_items', 'fc_page_thank_you', __( 'Important — Items', 'flavour-clinic' ), 'textarea', __( 'One item per line.', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_support_heading', 'fc_page_thank_you', __( 'Support — Heading', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_support_body', 'fc_page_thank_you', __( 'Support — Body', 'flavour-clinic' ), 'textarea', __( 'Use {email} where the support email link should appear.', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_support_body_alt', 'fc_page_thank_you', __( 'Support — Body (no email set)', 'flavour-clinic' ), 'textarea', __( 'Shown when no support email is configured. Use {contact} where the contact-page link should appear.', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_cta_booking_text', 'fc_page_thank_you', __( 'CTA — Booking Button', 'flavour-clinic' ) );
	fc_customizer_add_field( $wp_customize, 'thanks_cta_home_text', 'fc_page_thank_you', __( 'CTA — Homepage Button', 'flavour-clinic' ) );
} );
