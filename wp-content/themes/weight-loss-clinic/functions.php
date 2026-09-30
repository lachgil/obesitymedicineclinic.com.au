<?php
/**
 * Digital Clinic – Theme Functions
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

define( 'FC_VERSION', '1.2.0-' . filemtime( __DIR__ . '/assets/css/main.css' ) );
define( 'FC_DIR', get_template_directory() );
define( 'FC_URI', get_template_directory_uri() );

/**
 * Cache-busting version for a single theme asset, based on its own
 * modified-time. Falls back to FC_VERSION if the file is missing. Use this
 * instead of FC_VERSION so editing one asset busts only that file's cache.
 *
 * @param string $rel Path relative to the theme root, e.g. 'assets/js/quiz.js'.
 */
function fc_asset_ver( string $rel ): string {
	$path = FC_DIR . '/' . ltrim( $rel, '/' );
	return file_exists( $path ) ? (string) filemtime( $path ) : FC_VERSION;
}

/* ── Brand Config (developer defaults; editors override via Customizer) ── */
require_once FC_DIR . '/brand-config.php';
require_once FC_DIR . '/inc/helpers/theme-options.php';

/* ── Setup ────────────────────────────────────────────────── */
require_once FC_DIR . '/inc/setup/theme-support.php';
require_once FC_DIR . '/inc/setup/enqueue.php';
require_once FC_DIR . '/inc/setup/menus.php';
require_once FC_DIR . '/inc/setup/image-sizes.php';
require_once FC_DIR . '/inc/setup/seo.php';
require_once FC_DIR . '/inc/setup/brand-colors.php';
require_once FC_DIR . '/inc/setup/pages.php';
require_once FC_DIR . '/inc/setup/customizer.php';
require_once FC_DIR . '/inc/setup/admin-pointers.php';

/* ── Per-page editable content (one file per templated page) ── */
foreach ( glob( FC_DIR . '/inc/options/*.php' ) ?: [] as $fc_options_file ) {
	require_once $fc_options_file;
}
unset( $fc_options_file );

/* ── Helpers ──────────────────────────────────────────────── */
require_once FC_DIR . '/inc/helpers/template-tags.php';
require_once FC_DIR . '/inc/helpers/svg-icons.php';

/* ── Custom Post Types ────────────────────────────────────── */
require_once FC_DIR . '/inc/cpts/clinicians.php';
require_once FC_DIR . '/inc/cpts/testimonials.php';
require_once FC_DIR . '/inc/cpts/faqs.php';

/* ── Email Templates ─────────────────────────────────────────── */
require_once FC_DIR . '/inc/email-templates.php';

/* ── ACF ──────────────────────────────────────────────────── */
if ( class_exists( 'ACF' ) ) {
    require_once FC_DIR . '/inc/acf/options-pages.php';
    require_once FC_DIR . '/inc/acf/field-groups.php';
}
