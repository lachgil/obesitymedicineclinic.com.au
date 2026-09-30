<?php
/**
 * Enqueue styles and scripts.
 */

/* ── Font preconnect hints ──────────────────────────────────── */
add_action( 'wp_head', function () {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
}, 1 );

/* ── Assets ─────────────────────────────────────────────────── */
add_action( 'wp_enqueue_scripts', function () {

    /* ── CSS ──────────────────────────────────────────────── */
    wp_enqueue_style(
        'fc-fonts',
        'https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,700&family=DM+Serif+Display&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'fc-main',
        FC_URI . '/assets/css/main.css',
        [ 'fc-fonts' ],
        fc_asset_ver( 'assets/css/main.css' )
    );

    /* ── JS ───────────────────────────────────────────────── */
    wp_enqueue_script(
        'fc-main',
        FC_URI . '/assets/js/main.js',
        [],
        fc_asset_ver( 'assets/js/main.js' ),
        true
    );

    /* ── Tracking (all pages) ────────────────────────────── */
    wp_enqueue_script(
        'fc-tracking',
        FC_URI . '/assets/js/tracking.js',
        [],
        fc_asset_ver( 'assets/js/tracking.js' ),
        true
    );

    /* ── Quiz JS (only on quiz template) ─────────────────── */
    if ( is_page_template( 'template-quiz.php' ) ) {
        wp_enqueue_style(
            'fc-quiz',
            FC_URI . '/assets/css/quiz.css',
            [ 'fc-main' ],
            fc_asset_ver( 'assets/css/quiz.css' )
        );
        wp_enqueue_script(
            'fc-quiz',
            FC_URI . '/assets/js/quiz.js',
            [ 'fc-tracking' ],
            fc_asset_ver( 'assets/js/quiz.js' ),
            true
        );
    }

    /* ── Funnel pages (pre-checkout, thank-you) ──────────── */
    if ( is_page_template( 'template-start-treatment.php' ) || is_page_template( 'template-thank-you.php' ) ) {
        wp_enqueue_style(
            'fc-funnel',
            FC_URI . '/assets/css/funnel.css',
            [ 'fc-main' ],
            fc_asset_ver( 'assets/css/funnel.css' )
        );
    }

} );
