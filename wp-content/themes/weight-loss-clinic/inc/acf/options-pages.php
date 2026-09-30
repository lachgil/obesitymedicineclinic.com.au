<?php
/**
 * ACF Options Pages.
 */
add_action( 'acf/init', function () {

    acf_add_options_page( [
        'page_title' => 'Theme Settings',
        'menu_title' => 'Theme Settings',
        'menu_slug'  => 'fc-theme-settings',
        'capability' => 'edit_posts',
        'redirect'   => true,
        'icon_url'   => 'dashicons-admin-generic',
        'position'   => 2,
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Brand Colors',
        'menu_title'  => 'Brand Colors',
        'parent_slug' => 'fc-theme-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Global Content',
        'menu_title'  => 'Global Content',
        'parent_slug' => 'fc-theme-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Announcement Bar',
        'menu_title'  => 'Announcement Bar',
        'parent_slug' => 'fc-theme-settings',
    ] );

    acf_add_options_sub_page( [
        'page_title'  => 'Footer Settings',
        'menu_title'  => 'Footer',
        'parent_slug' => 'fc-theme-settings',
    ] );

} );
