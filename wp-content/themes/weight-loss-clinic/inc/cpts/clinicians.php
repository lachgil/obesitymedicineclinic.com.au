<?php
/**
 * Clinicians CPT.
 */
add_action( 'init', function () {
    register_post_type( 'fc_clinician', [
        'labels' => [
            'name'          => __( 'Clinicians', 'flavour-clinic' ),
            'singular_name' => __( 'Clinician', 'flavour-clinic' ),
            'add_new_item'  => __( 'Add Clinician', 'flavour-clinic' ),
            'edit_item'     => __( 'Edit Clinician', 'flavour-clinic' ),
        ],
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'menu_icon'          => 'dashicons-businessman',
        'supports'           => [ 'title', 'thumbnail', 'editor', 'excerpt' ],
        'has_archive'        => false,
        'rewrite'            => [ 'slug' => 'team', 'with_front' => false ],
        'exclude_from_search' => true,
    ] );
} );
