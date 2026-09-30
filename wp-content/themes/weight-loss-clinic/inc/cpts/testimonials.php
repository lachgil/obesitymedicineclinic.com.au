<?php
/**
 * Testimonials CPT.
 */
add_action( 'init', function () {
    register_post_type( 'fc_testimonial', [
        'labels' => [
            'name'          => __( 'Testimonials', 'flavour-clinic' ),
            'singular_name' => __( 'Testimonial', 'flavour-clinic' ),
            'add_new_item'  => __( 'Add Testimonial', 'flavour-clinic' ),
            'edit_item'     => __( 'Edit Testimonial', 'flavour-clinic' ),
        ],
        'public'       => false,
        'show_ui'      => true,
        'show_in_menu' => true,
        'menu_icon'    => 'dashicons-format-quote',
        'supports'     => [ 'title', 'thumbnail' ],
        'has_archive'  => false,
        'rewrite'      => false,
    ] );
} );
