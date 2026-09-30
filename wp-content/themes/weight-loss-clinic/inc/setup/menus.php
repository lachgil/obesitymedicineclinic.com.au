<?php
/**
 * Register navigation menus.
 */
add_action( 'after_setup_theme', function () {
    register_nav_menus( [
        'primary'   => __( 'Primary Navigation', 'flavour-clinic' ),
        'footer'    => __( 'Footer Navigation', 'flavour-clinic' ),
        'legal'     => __( 'Legal Links', 'flavour-clinic' ),
    ] );
} );
