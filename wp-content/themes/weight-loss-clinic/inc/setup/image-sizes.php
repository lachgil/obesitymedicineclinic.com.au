<?php
/**
 * Custom image sizes.
 */
add_action( 'after_setup_theme', function () {
    add_image_size( 'fc-hero',        1400, 800, true );
    add_image_size( 'fc-service',     800,  900, true );
    add_image_size( 'fc-lifestyle',   600,  700, true );
    add_image_size( 'fc-card',        480,  540, true );
    add_image_size( 'fc-clinician',   400,  500, true );
    add_image_size( 'fc-testimonial', 80,   80,  true );
    add_image_size( 'fc-blog-card',   720,  420, true );
} );
