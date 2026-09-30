<?php
/**
 * FAQ Custom Post Type
 *
 * FAQs are managed in the admin (FAQs menu): the post title is the
 * question, the editor content is the answer, and the "FAQ Group"
 * taxonomy provides the on-page category sections. Order within a group
 * uses the page attributes "Order" field (menu_order).
 *
 * template-faq.php renders published FAQs grouped by term; when none are
 * published it falls back to the compliant defaults that ship with the
 * theme, so a fresh install still renders a complete FAQ page.
 *
 * @package DigitalClinic
 */

defined( 'ABSPATH' ) || exit;

add_action( 'init', function () {

	register_post_type( 'fc_faq', [
		'labels' => [
			'name'          => __( 'FAQs', 'flavour-clinic' ),
			'singular_name' => __( 'FAQ', 'flavour-clinic' ),
			'add_new_item'  => __( 'Add New FAQ', 'flavour-clinic' ),
			'edit_item'     => __( 'Edit FAQ', 'flavour-clinic' ),
			'menu_name'     => __( 'FAQs', 'flavour-clinic' ),
		],
		'public'              => false,
		'show_ui'             => true,
		'show_in_rest'        => true,
		'menu_icon'           => 'dashicons-editor-help',
		'menu_position'       => 21,
		'supports'            => [ 'title', 'editor', 'page-attributes' ],
		'has_archive'         => false,
		'rewrite'             => false,
		'exclude_from_search' => true,
	] );

	register_taxonomy( 'fc_faq_group', 'fc_faq', [
		'labels' => [
			'name'          => __( 'FAQ Groups', 'flavour-clinic' ),
			'singular_name' => __( 'FAQ Group', 'flavour-clinic' ),
		],
		'public'            => false,
		'show_ui'           => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'hierarchical'      => true,
		'rewrite'           => false,
	] );

} );

/**
 * Fetch published FAQs grouped for template-faq.php.
 *
 * Returns the same shape as the hardcoded fallback groups:
 *   [ [ 'label' => ..., 'title' => ..., 'items' => [ [ 'q' =>, 'a' => ] ] ], ... ]
 *
 * Group label = term name; group title = term description's first line
 * (falls back to the term name). Ungrouped FAQs land in a final
 * "General" group. Returns [] when no FAQs are published.
 *
 * @return array
 */
function fc_get_faq_groups() : array {
	$posts = get_posts( [
		'post_type'        => 'fc_faq',
		'posts_per_page'   => -1,
		'orderby'          => [ 'menu_order' => 'ASC', 'date' => 'ASC' ],
		'suppress_filters' => false,
	] );

	if ( empty( $posts ) ) {
		return [];
	}

	$terms = get_terms( [
		'taxonomy'   => 'fc_faq_group',
		'hide_empty' => true,
		'orderby'    => 'term_order',
	] );
	if ( is_wp_error( $terms ) ) {
		$terms = [];
	}

	$groups    = [];
	$assigned  = [];

	foreach ( $terms as $term ) {
		$items = [];

		foreach ( $posts as $post ) {
			if ( has_term( $term->term_id, 'fc_faq_group', $post ) ) {
				$items[] = [
					'q' => get_the_title( $post ),
					'a' => apply_filters( 'the_content', $post->post_content ),
				];
				$assigned[ $post->ID ] = true;
			}
		}

		if ( $items ) {
			$groups[] = [
				'label' => $term->name,
				'title' => $term->description ? wp_strip_all_tags( $term->description ) : $term->name,
				'items' => $items,
			];
		}
	}

	// FAQs without a group.
	$loose = [];
	foreach ( $posts as $post ) {
		if ( empty( $assigned[ $post->ID ] ) ) {
			$loose[] = [
				'q' => get_the_title( $post ),
				'a' => apply_filters( 'the_content', $post->post_content ),
			];
		}
	}
	if ( $loose ) {
		$groups[] = [
			'label' => __( 'General', 'flavour-clinic' ),
			'title' => __( 'General questions', 'flavour-clinic' ),
			'items' => $loose,
		];
	}

	return $groups;
}
