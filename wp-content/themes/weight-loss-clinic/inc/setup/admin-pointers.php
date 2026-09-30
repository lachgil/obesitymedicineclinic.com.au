<?php
/**
 * Admin pointers for template-backed pages.
 *
 * Several pages (Plans, FAQ, Homepage, …) render from theme templates whose
 * content is edited in the Customizer, not in the page editor. Without a
 * pointer, opening one of those pages in Pages → Edit shows an empty editor
 * and looks broken. This adds a notice on those edit screens with a direct
 * "Edit content" link into the matching Customizer section.
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Map: page template file => where its content is edited.
 *
 * 'section' / 'panel' become the Customizer autofocus target.
 * 'extra' is an optional additional hint rendered after the main message.
 */
function fc_template_edit_locations() : array {
	return [
		'template-plans.php' => [
			'section' => 'fc_plans_top',
			'label'   => __( 'Theme Settings → Plans Page', 'flavour-clinic' ),
			'extra'   => __( 'The consultation fees ($ amounts) live under Theme Settings → Buttons & CTAs.', 'flavour-clinic' ),
		],
		'template-faq.php' => [
			'section' => 'fc_page_faq',
			'label'   => __( 'Theme Settings → Page Hero — FAQ Page', 'flavour-clinic' ),
			'extra'   => __( 'The questions and answers themselves are managed under the FAQs menu in the admin sidebar (grouped via FAQ Groups).', 'flavour-clinic' ),
		],
		'front-page.php' => [
			'section' => 'fc_home_hero',
			'label'   => __( 'Theme Settings → Homepage sections', 'flavour-clinic' ),
		],
		'template-how-it-works.php'        => [ 'section' => 'fc_page_how_it_works', 'label' => __( 'Theme Settings → Page — How It Works', 'flavour-clinic' ) ],
		'template-about.php'               => [ 'section' => 'fc_page_about', 'label' => __( 'Theme Settings → Page — About', 'flavour-clinic' ) ],
		'template-clinician-led-care.php'  => [ 'section' => 'fc_page_clinician_led_care', 'label' => __( 'Theme Settings → Page — Clinician-Led Care', 'flavour-clinic' ) ],
		'template-contact.php'             => [ 'section' => 'fc_page_contact', 'label' => __( 'Theme Settings → Page — Contact', 'flavour-clinic' ) ],
		'template-booking.php'             => [ 'section' => 'fc_page_booking', 'label' => __( 'Theme Settings → Page — Booking', 'flavour-clinic' ) ],
		'template-quiz.php'                => [ 'section' => 'fc_page_quiz', 'label' => __( 'Theme Settings → Page — Quiz', 'flavour-clinic' ) ],
		'template-start-treatment.php'     => [ 'section' => 'fc_page_start_treatment', 'label' => __( 'Theme Settings → Page — Start Treatment', 'flavour-clinic' ) ],
		'template-thank-you.php'           => [ 'section' => 'fc_page_thank_you', 'label' => __( 'Theme Settings → Page — Thank You', 'flavour-clinic' ) ],
		'template-intake.php'              => [ 'section' => 'fc_page_intake', 'label' => __( 'Theme Settings → Page — Intake', 'flavour-clinic' ) ],
		'template-portal.php'              => [ 'panel' => 'fc_theme_settings', 'label' => __( 'Theme Settings', 'flavour-clinic' ) ],
	];
}

add_action( 'admin_notices', function () {
	$screen = function_exists( 'get_current_screen' ) ? get_current_screen() : null;

	if ( ! $screen || 'post' !== $screen->base || 'page' !== $screen->post_type ) {
		return;
	}

	$post_id = isset( $_GET['post'] ) ? (int) $_GET['post'] : 0;
	if ( ! $post_id ) {
		return;
	}

	$template  = get_post_meta( $post_id, '_wp_page_template', true );

	// The homepage may use front-page.php implicitly (no template meta).
	if ( ( ! $template || 'default' === $template ) && (int) get_option( 'page_on_front' ) === $post_id ) {
		$template = 'front-page.php';
	}

	$locations = fc_template_edit_locations();
	if ( ! isset( $locations[ $template ] ) ) {
		return;
	}

	$loc  = $locations[ $template ];
	$args = [ 'url' => urlencode( get_permalink( $post_id ) ) ];
	if ( isset( $loc['section'] ) ) {
		$args['autofocus[section]'] = $loc['section'];
	} elseif ( isset( $loc['panel'] ) ) {
		$args['autofocus[panel]'] = $loc['panel'];
	}
	$customize_url = add_query_arg( $args, admin_url( 'customize.php' ) );

	printf(
		'<div class="notice notice-info"><p><strong>%s</strong> %s <a class="button button-primary" href="%s" style="margin-left:8px;">%s</a></p>%s</div>',
		esc_html__( 'This page is rendered by a theme template.', 'flavour-clinic' ),
		sprintf(
			/* translators: %s: Customizer location label */
			esc_html__( 'Its content is edited in the Customizer under %s — not in the editor below.', 'flavour-clinic' ),
			'<em>' . esc_html( $loc['label'] ) . '</em>'
		),
		esc_url( $customize_url ),
		esc_html__( 'Edit content', 'flavour-clinic' ),
		! empty( $loc['extra'] ) ? '<p>' . esc_html( $loc['extra'] ) . '</p>' : ''
	);
} );
