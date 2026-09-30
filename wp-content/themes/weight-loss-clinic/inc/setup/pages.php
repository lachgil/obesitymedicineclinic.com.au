<?php
/**
 * Ensure required funnel pages exist.
 *
 * Creates the Quiz and Contact pages on theme activation (or first admin
 * load if they are missing). Each page is assigned its corresponding page
 * template and published with the canonical slug the CTAs expect.
 *
 * Rewrite rules are flushed once after pages are created so permalinks
 * resolve immediately — no manual "Save Permalinks" step required.
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

/**
 * Required pages: slug → template file & title.
 *
 * Add entries here when the funnel gains new template-backed pages.
 */
function fc_get_required_pages() : array {
    return [
        'quiz' => [
            'title'    => 'Quiz',
            'template' => 'template-quiz.php',
        ],
        'contact' => [
            'title'    => 'Contact',
            'template' => 'template-contact.php',
        ],
        'start-treatment' => [
            'title'    => 'Start Treatment',
            'template' => 'template-start-treatment.php',
        ],
        'thank-you' => [
            'title'    => 'Thank You',
            'template' => 'template-thank-you.php',
        ],
        'privacy-policy' => [
            'title'    => 'Privacy Policy',
            'template' => '',
        ],
        'terms' => [
            'title'    => 'Terms of Service',
            'template' => '',
        ],
        'medical-disclaimer' => [
            'title'    => 'Medical Disclaimer',
            'template' => '',
        ],
        // ── 2026 site architecture ──
        'book' => [
            'title'    => 'Book a Consultation',
            'template' => 'template-booking.php',
        ],
        'portal' => [
            'title'    => 'Patient Portal',
            'template' => 'template-portal.php',
        ],
        'plans' => [
            'title'    => 'Plans & Programs',
            'template' => 'template-plans.php',
        ],
        'how-it-works' => [
            'title'    => 'How It Works',
            'template' => 'template-how-it-works.php',
        ],
        'about' => [
            'title'    => 'About & Clinical Governance',
            'template' => 'template-about.php',
        ],
        'faq' => [
            'title'    => 'Frequently Asked Questions',
            'template' => 'template-faq.php',
        ],
        'clinician-led-care' => [
            'title'    => 'Clinician-Led Care',
            'template' => 'template-clinician-led-care.php',
        ],
    ];
}

/**
 * Create any missing required pages and flush rewrites once.
 *
 * Hooked to `after_switch_theme` (runs on theme activation) and also
 * called on `admin_init` with a transient guard so it only runs once
 * per missing-page state — not on every admin load.
 */
function fc_maybe_create_required_pages() : void {
    $created = false;

    foreach ( fc_get_required_pages() as $slug => $page ) {
        // Check if a published page with this slug already exists.
        $existing = get_page_by_path( $slug );

        if ( $existing && $existing->post_status === 'publish' ) {
            // Page exists and is published — ensure template is assigned.
            $current_template = get_post_meta( $existing->ID, '_wp_page_template', true );
            if ( $current_template !== $page['template'] ) {
                update_post_meta( $existing->ID, '_wp_page_template', $page['template'] );
                $created = true;
            }
            continue;
        }

        // If the page exists but is trashed/draft, update it instead of creating a duplicate.
        if ( $existing ) {
            wp_update_post( [
                'ID'          => $existing->ID,
                'post_status' => 'publish',
            ] );
            update_post_meta( $existing->ID, '_wp_page_template', $page['template'] );
            $created = true;
            continue;
        }

        // Create the page.
        $page_id = wp_insert_post( [
            'post_title'   => $page['title'],
            'post_name'    => $slug,
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '',
        ], true );

        if ( ! is_wp_error( $page_id ) ) {
            update_post_meta( $page_id, '_wp_page_template', $page['template'] );
            $created = true;
        }
    }

    // Flush rewrite rules once so the new slugs resolve immediately.
    if ( $created ) {
        flush_rewrite_rules();
    }
}

// Run on theme activation (first install or re-activation).
add_action( 'after_switch_theme', 'fc_maybe_create_required_pages' );

/**
 * Front-end self-heal: if the required-pages list has changed since the
 * last check, re-run creation. Hash-keyed so adding new entries to
 * fc_get_required_pages() automatically triggers seeding on the next
 * front-end request — no admin visit required.
 */
add_action( 'init', function () {
    $pages = fc_get_required_pages();
    $hash  = md5( wp_json_encode( $pages ) );

    if ( get_option( 'fc_pages_hash' ) === $hash ) {
        return;
    }

    fc_maybe_create_required_pages();
    update_option( 'fc_pages_hash', $hash, false );
}, 20 );

/**
 * Admin notice when required funnel pages are missing.
 *
 * This is a safety net — if page creation failed for any reason (permissions,
 * DB issue, etc.), the admin sees a clear warning instead of a silent 404.
 */
add_action( 'admin_notices', function () {
    if ( ! current_user_can( 'edit_pages' ) ) {
        return;
    }

    $missing = [];
    foreach ( fc_get_required_pages() as $slug => $page ) {
        $existing = get_page_by_path( $slug );
        if ( ! $existing || $existing->post_status !== 'publish' ) {
            $missing[] = '/' . $slug . '/ (' . $page['title'] . ')';
        }
    }

    if ( empty( $missing ) ) {
        return;
    }

    printf(
        '<div class="notice notice-warning"><p><strong>%s</strong> %s %s</p></div>',
        esc_html( fc_setting( 'brand_name' ) ),
        esc_html__( '— required funnel pages are missing:', 'flavour-clinic' ),
        esc_html( implode( ', ', $missing ) )
    );
} );
