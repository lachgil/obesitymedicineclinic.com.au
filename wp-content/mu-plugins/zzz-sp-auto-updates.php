<?php
/**
 * Plugin Name: SP Fleet Auto-Updates
 * Description: Fleet-wide security policy - automatic updates for WordPress core, all plugins, and all themes (current and future).
 * Author:      SurfPacific IR
 * Version:     1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugins: auto-update ALL, including plugins installed in the future.
add_filter( 'auto_update_plugins', '__return_true' );

// Themes: auto-update ALL repo themes (custom themes have no update source, so unaffected).
add_filter( 'auto_update_themes', '__return_true' );

// Core: security + minor releases (essential for security).
add_filter( 'auto_update_core_minor', '__return_true' );

// Core: MAJOR releases (e.g. 7.0 -> 7.1). Set to __return_false for security/minor-only.
add_filter( 'auto_update_core_major', '__return_true' );

// Never auto-install nightly / beta / RC development builds.
add_filter( 'auto_update_core_dev', '__return_false' );

// Ensure the background updater is not globally disabled.
add_filter( 'automatic_updater_disabled', '__return_false' );
