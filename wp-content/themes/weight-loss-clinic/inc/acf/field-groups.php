<?php
/**
 * ACF Field Group Registration
 *
 * Registers all field groups programmatically so they ship with the theme.
 * Operators can still override via the ACF UI; these serve as defaults.
 */

add_action( 'acf/include_fields', function () {

    if ( ! function_exists( 'acf_add_local_field_group' ) ) {
        return;
    }

    /* ═══════════════════════════════════════════════════════════
       GLOBAL OPTIONS – Announcement Bar
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'      => 'group_fc_announcement',
        'title'    => 'Announcement Bar',
        'fields'   => [
            [
                'key'   => 'field_fc_ann_enabled',
                'label' => 'Enable Announcement Bar',
                'name'  => 'announcement_enabled',
                'type'  => 'true_false',
                'ui'    => 1,
            ],
            [
                'key'         => 'field_fc_ann_text',
                'label'       => 'Text',
                'name'        => 'announcement_text',
                'type'        => 'text',
                'placeholder' => 'Free shipping on all treatment plans this month',
                'instructions' => 'Short promotional or informational message displayed site-wide.',
            ],
            [
                'key'   => 'field_fc_ann_link',
                'label' => 'Link',
                'name'  => 'announcement_link',
                'type'  => 'link',
            ],
            [
                'key'           => 'field_fc_ann_dismissible',
                'label'         => 'Dismissible',
                'name'          => 'announcement_dismissible',
                'type'          => 'true_false',
                'ui'            => 1,
                'default_value' => 1,
            ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-announcement-bar' ] ] ],
    ] );

    /* ═══════════════════════════════════════════════════════════
       GLOBAL OPTIONS – Brand Colors
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'      => 'group_fc_brand_colors',
        'title'    => 'Brand Colors',
        'fields'   => [
            [
                'key'           => 'field_fc_brand_primary',
                'label'         => 'Primary',
                'name'          => 'brand_primary',
                'type'          => 'color_picker',
                'default_value' => '#1B7A5A',
                'instructions'  => 'Main brand color used for buttons, links, and accents. Choose a mid-tone that works on both light and dark backgrounds.',
                'wrapper'       => [ 'width' => '33' ],
            ],
            [
                'key'           => 'field_fc_brand_primary_dark',
                'label'         => 'Primary Dark',
                'name'          => 'brand_primary_dark',
                'type'          => 'color_picker',
                'default_value' => '#145C43',
                'instructions'  => 'Darker variant of primary. Used for hover states and gradients. Should be noticeably darker than Primary.',
                'wrapper'       => [ 'width' => '33' ],
            ],
            [
                'key'           => 'field_fc_brand_primary_light',
                'label'         => 'Primary Light',
                'name'          => 'brand_primary_light',
                'type'          => 'color_picker',
                'default_value' => '#2E936F',
                'instructions'  => 'Lighter variant of primary. Used for secondary accents and per-section tinting.',
                'wrapper'       => [ 'width' => '33' ],
            ],
            [
                'key'           => 'field_fc_brand_cream',
                'label'         => 'Soft Background',
                'name'          => 'brand_cream',
                'type'          => 'color_picker',
                'default_value' => '#FAF8F5',
                'instructions'  => 'Warm off-white used for alternating section backgrounds, page headers, and card surfaces. Should be very light.',
                'wrapper'       => [ 'width' => '50' ],
            ],
            [
                'key'           => 'field_fc_brand_sand',
                'label'         => 'Sand / Muted Surface',
                'name'          => 'brand_sand',
                'type'          => 'color_picker',
                'default_value' => '#F3EDE4',
                'instructions'  => 'Slightly deeper warm tone for trust strips and alternate surfaces. Should be between Soft Background and the gray scale.',
                'wrapper'       => [ 'width' => '50' ],
            ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-brand-colors' ] ] ],
    ] );

    /* ═══════════════════════════════════════════════════════════
       GLOBAL OPTIONS – Global Content
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'      => 'group_fc_global',
        'title'    => 'Global Content',
        'fields'   => [
            [
                'key'          => 'field_fc_global_cta_text',
                'label'        => 'Global CTA Button Text',
                'name'         => 'global_cta_text',
                'type'         => 'text',
                'default_value' => 'Get Started',
                'placeholder'  => 'Get Started',
                'instructions' => 'Default text for the main call-to-action button in the header and mobile nav.',
            ],
            [
                'key'          => 'field_fc_global_cta_url',
                'label'        => 'Global CTA URL',
                'name'         => 'global_cta_url',
                'type'         => 'url',
                'placeholder'  => 'https://example.com/start',
                'instructions' => 'Where the header CTA button links to.',
            ],
            [
                'key'    => 'field_fc_global_trust_items',
                'label'  => 'Trust Marquee Items',
                'name'   => 'global_trust_items',
                'type'   => 'repeater',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'key'   => 'field_fc_gti_icon',
                        'label' => 'Icon Name',
                        'name'  => 'icon',
                        'type'  => 'text',
                        'instructions' => 'shield, truck, dollar, lock, heart, clock, stethoscope, package, users',
                        'wrapper' => [ 'width' => '30' ],
                    ],
                    [
                        'key'   => 'field_fc_gti_text',
                        'label' => 'Text',
                        'name'  => 'text',
                        'type'  => 'text',
                        'wrapper' => [ 'width' => '70' ],
                    ],
                ],
            ],
            [
                'key'          => 'field_fc_global_disclaimer',
                'label'        => 'Medical Disclaimer',
                'name'         => 'global_medical_disclaimer',
                'type'         => 'wysiwyg',
                'media_upload' => 0,
                'toolbar'      => 'basic',
                'instructions' => 'Displayed at the bottom of blog posts, service pages (when no page-specific disclaimer is set), and clinician profiles. Keep brief and professionally worded.',
                'default_value' => '<p>This content is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare provider regarding any medical condition or treatment.</p>',
            ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-global-content' ] ] ],
    ] );

    /* ═══════════════════════════════════════════════════════════
       GLOBAL OPTIONS – Footer
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'      => 'group_fc_footer',
        'title'    => 'Footer Settings',
        'fields'   => [
            [
                'key'         => 'field_fc_footer_email',
                'label'       => 'Contact Email',
                'name'        => 'footer_email',
                'type'        => 'email',
                'placeholder' => 'hello@example.com',
            ],
            [
                'key'         => 'field_fc_footer_phone',
                'label'       => 'Phone Number',
                'name'        => 'footer_phone',
                'type'        => 'text',
                'placeholder' => '(555) 123-4567',
                'instructions' => 'Displayed in the footer and used for the click-to-call link.',
            ],
            [
                'key'   => 'field_fc_footer_address',
                'label' => 'Address',
                'name'  => 'footer_address',
                'type'  => 'textarea',
                'rows'  => 2,
            ],
            [
                'key'   => 'field_fc_footer_disclaimer',
                'label' => 'Legal Disclaimer',
                'name'  => 'footer_disclaimer',
                'type'  => 'wysiwyg',
                'media_upload' => 0,
                'toolbar'      => 'basic',
            ],
            [
                'key'    => 'field_fc_footer_social',
                'label'  => 'Social Links',
                'name'   => 'footer_social',
                'type'   => 'repeater',
                'layout' => 'table',
                'sub_fields' => [
                    [
                        'key'   => 'field_fc_fs_label',
                        'label' => 'Platform',
                        'name'  => 'label',
                        'type'  => 'text',
                    ],
                    [
                        'key'   => 'field_fc_fs_url',
                        'label' => 'URL',
                        'name'  => 'url',
                        'type'  => 'url',
                    ],
                ],
            ],
        ],
        'location' => [ [ [ 'param' => 'options_page', 'operator' => '==', 'value' => 'acf-options-footer' ] ] ],
    ] );

    /* ═══════════════════════════════════════════════════════════
       CLINICIAN FIELDS
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'    => 'group_fc_clinician',
        'title'  => 'Clinician Details',
        'fields' => [
            [
                'key'          => 'field_fc_clin_title',
                'label'        => 'Professional Title',
                'name'         => 'clinician_title',
                'type'         => 'text',
                'instructions' => 'Displayed beneath the name on the card and profile page. e.g. "MD, Internal Medicine" or "NP, Hormone Health"',
                'placeholder'  => 'MD, Board-Certified Internist',
            ],
            [
                'key'          => 'field_fc_clin_credentials',
                'label'        => 'Credentials',
                'name'         => 'clinician_credentials',
                'type'         => 'textarea',
                'rows'         => 3,
                'instructions' => 'Licenses, board certifications, and education. One per line.',
                'placeholder'  => "Board Certified, Internal Medicine\nMD, University of Example\nState Medical License #12345",
            ],
            [
                'key'        => 'field_fc_clin_specialties',
                'label'      => 'Specialties / Focus Areas',
                'name'       => 'clinician_specialties',
                'type'       => 'repeater',
                'layout'     => 'table',
                'max'        => 10,
                'button_label' => 'Add Specialty',
                'sub_fields' => [
                    [ 'key' => 'field_fc_clin_spec_text', 'label' => 'Specialty', 'name' => 'text', 'type' => 'text' ],
                ],
            ],
            [
                'key'          => 'field_fc_clin_cta_text',
                'label'        => 'Profile CTA Text',
                'name'         => 'clinician_cta_text',
                'type'         => 'text',
                'instructions' => 'Optional button text for profile page. Falls back to global CTA if empty.',
                'wrapper'      => [ 'width' => '50' ],
            ],
            [
                'key'          => 'field_fc_clin_cta_url',
                'label'        => 'Profile CTA URL',
                'name'         => 'clinician_cta_url',
                'type'         => 'url',
                'instructions' => 'Optional button URL. Falls back to global CTA if empty.',
                'wrapper'      => [ 'width' => '50' ],
            ],
        ],
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'fc_clinician' ] ] ],
    ] );

    /* ═══════════════════════════════════════════════════════════
       TESTIMONIAL FIELDS
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'    => 'group_fc_testimonial',
        'title'  => 'Testimonial Details',
        'fields' => [
            [
                'key'   => 'field_fc_test_quote',
                'label' => 'Quote',
                'name'  => 'testimonial_quote',
                'type'  => 'textarea',
                'rows'  => 3,
            ],
            [
                'key'   => 'field_fc_test_name',
                'label' => 'Name',
                'name'  => 'testimonial_name',
                'type'  => 'text',
            ],
            [
                'key'   => 'field_fc_test_treatment',
                'label' => 'Treatment Type',
                'name'  => 'testimonial_treatment',
                'type'  => 'text',
            ],
            [
                'key'           => 'field_fc_test_rating',
                'label'         => 'Rating (1–5)',
                'name'          => 'testimonial_rating',
                'type'          => 'number',
                'min'           => 1,
                'max'           => 5,
                'default_value' => 5,
            ],
        ],
        'location' => [ [ [ 'param' => 'post_type', 'operator' => '==', 'value' => 'fc_testimonial' ] ] ],
    ] );

    /* ═══════════════════════════════════════════════════════════
       SERVICE PAGE TEMPLATE
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'      => 'group_fc_service_page',
        'title'    => 'Service Page',
        'fields'   => [

            /* ── Hero ── */
            [
                'key'   => 'field_fc_svc_hero_tab',
                'label' => 'Hero',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_hero_intro',
                'label'        => 'Intro Text',
                'name'         => 'svc_hero_intro',
                'type'         => 'textarea',
                'rows'         => 2,
                'instructions' => 'Short supporting copy beneath the page title.',
            ],
            [
                'key'          => 'field_fc_svc_hero_trust',
                'label'        => 'Trust Line',
                'name'         => 'svc_hero_trust',
                'type'         => 'text',
                'instructions' => 'Optional trust/social-proof line. Supports <strong> tags.',
            ],
            [
                'key'          => 'field_fc_svc_hero_cta_text',
                'label'        => 'Primary CTA Text',
                'name'         => 'svc_hero_cta_text',
                'type'         => 'text',
                'default_value' => 'Start Your Visit',
                'wrapper'      => [ 'width' => '50' ],
            ],
            [
                'key'          => 'field_fc_svc_hero_cta_url',
                'label'        => 'Primary CTA URL',
                'name'         => 'svc_hero_cta_url',
                'type'         => 'url',
                'wrapper'      => [ 'width' => '50' ],
            ],
            [
                'key'          => 'field_fc_svc_hero_cta2_text',
                'label'        => 'Secondary CTA Text',
                'name'         => 'svc_hero_cta2_text',
                'type'         => 'text',
                'wrapper'      => [ 'width' => '50' ],
            ],
            [
                'key'          => 'field_fc_svc_hero_cta2_url',
                'label'        => 'Secondary CTA URL',
                'name'         => 'svc_hero_cta2_url',
                'type'         => 'url',
                'wrapper'      => [ 'width' => '50' ],
            ],
            [
                'key'          => 'field_fc_svc_hero_image',
                'label'        => 'Hero Image',
                'name'         => 'svc_hero_image',
                'type'         => 'image',
                'return_format' => 'array',
                'preview_size' => 'medium',
                'instructions' => 'Optional hero image displayed alongside the intro.',
            ],

            /* ── How It Works ── */
            [
                'key'   => 'field_fc_svc_process_tab',
                'label' => 'How It Works',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_process_heading',
                'label'        => 'Heading',
                'name'         => 'svc_process_heading',
                'type'         => 'text',
                'default_value' => 'How it works',
            ],
            [
                'key'        => 'field_fc_svc_process_steps',
                'label'      => 'Steps',
                'name'       => 'svc_process_steps',
                'type'       => 'repeater',
                'layout'     => 'block',
                'max'        => 5,
                'button_label' => 'Add Step',
                'sub_fields' => [
                    [ 'key' => 'field_fc_svc_ps_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
                    [ 'key' => 'field_fc_svc_ps_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2 ],
                ],
            ],

            /* ── Eligibility ── */
            [
                'key'   => 'field_fc_svc_elig_tab',
                'label' => 'Eligibility',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_elig_heading',
                'label'        => 'Heading',
                'name'         => 'svc_elig_heading',
                'type'         => 'text',
                'default_value' => 'Is this right for you?',
            ],
            [
                'key'          => 'field_fc_svc_elig_intro',
                'label'        => 'Intro',
                'name'         => 'svc_elig_intro',
                'type'         => 'textarea',
                'rows'         => 2,
                'instructions' => 'Optional short paragraph before the eligibility items.',
            ],
            [
                'key'        => 'field_fc_svc_elig_items',
                'label'      => 'Items',
                'name'       => 'svc_elig_items',
                'type'       => 'repeater',
                'layout'     => 'table',
                'button_label' => 'Add Item',
                'sub_fields' => [
                    [ 'key' => 'field_fc_svc_ei_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ],
                ],
            ],

            /* ── Benefits ── */
            [
                'key'   => 'field_fc_svc_benefits_tab',
                'label' => 'Benefits',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_benefits_heading',
                'label'        => 'Heading',
                'name'         => 'svc_benefits_heading',
                'type'         => 'text',
                'default_value' => 'Key benefits',
            ],
            [
                'key'        => 'field_fc_svc_benefits_items',
                'label'      => 'Items',
                'name'       => 'svc_benefits_items',
                'type'       => 'repeater',
                'layout'     => 'block',
                'max'        => 8,
                'button_label' => 'Add Benefit',
                'sub_fields' => [
                    [ 'key' => 'field_fc_svc_bi_icon',  'label' => 'Icon', 'name' => 'icon', 'type' => 'text', 'instructions' => 'Icon key (e.g. shield, heart, check, clock). Leave blank for a default checkmark.' ],
                    [ 'key' => 'field_fc_svc_bi_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ],
                    [ 'key' => 'field_fc_svc_bi_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2 ],
                ],
            ],

            /* ── FAQ ── */
            [
                'key'   => 'field_fc_svc_faq_tab',
                'label' => 'FAQ',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_faq_heading',
                'label'        => 'Heading',
                'name'         => 'svc_faq_heading',
                'type'         => 'text',
                'default_value' => 'Frequently asked questions',
            ],
            [
                'key'        => 'field_fc_svc_faq_items',
                'label'      => 'Questions',
                'name'       => 'svc_faq_items',
                'type'       => 'repeater',
                'layout'     => 'block',
                'button_label' => 'Add Question',
                'sub_fields' => [
                    [ 'key' => 'field_fc_svc_fq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ],
                    [ 'key' => 'field_fc_svc_fq_a', 'label' => 'Answer',   'name' => 'answer',   'type' => 'wysiwyg', 'media_upload' => 0, 'toolbar' => 'basic' ],
                ],
            ],

            /* ── CTA ── */
            [
                'key'   => 'field_fc_svc_cta_tab',
                'label' => 'CTA Block',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_cta_heading',
                'label'        => 'Heading',
                'name'         => 'svc_cta_heading',
                'type'         => 'text',
                'default_value' => 'Ready to get started?',
            ],
            [
                'key'          => 'field_fc_svc_cta_body',
                'label'        => 'Body',
                'name'         => 'svc_cta_body',
                'type'         => 'textarea',
                'rows'         => 2,
            ],
            [
                'key'          => 'field_fc_svc_cta_btn_text',
                'label'        => 'Button Text',
                'name'         => 'svc_cta_btn_text',
                'type'         => 'text',
                'default_value' => 'Start Your Visit',
                'wrapper'      => [ 'width' => '50' ],
            ],
            [
                'key'          => 'field_fc_svc_cta_btn_url',
                'label'        => 'Button URL',
                'name'         => 'svc_cta_btn_url',
                'type'         => 'url',
                'wrapper'      => [ 'width' => '50' ],
            ],

            /* ── Disclaimer ── */
            [
                'key'   => 'field_fc_svc_extra_tab',
                'label' => 'Extras',
                'type'  => 'tab',
            ],
            [
                'key'          => 'field_fc_svc_disclaimer',
                'label'        => 'Disclaimer',
                'name'         => 'svc_disclaimer',
                'type'         => 'wysiwyg',
                'media_upload' => 0,
                'toolbar'      => 'basic',
                'instructions' => 'Optional medical/legal disclaimer shown at the bottom of the page.',
            ],
            [
                'key'          => 'field_fc_svc_show_clinicians',
                'label'        => 'Show Clinicians Section',
                'name'         => 'svc_show_clinicians',
                'type'         => 'true_false',
                'ui'           => 1,
                'default_value' => 0,
                'instructions' => 'Display the clinician cards section on this page.',
            ],
        ],
        'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'template-service.php' ] ] ],
        'menu_order' => 0,
        'position'   => 'normal',
        'style'      => 'default',
    ] );

    /* ═══════════════════════════════════════════════════════════
       HOMEPAGE – Flexible Content
       ═══════════════════════════════════════════════════════════ */
    acf_add_local_field_group( [
        'key'    => 'group_fc_homepage',
        'title'  => 'Homepage Sections',
        'fields' => [
            [
                'key'        => 'field_fc_hp_sections',
                'label'      => 'Sections',
                'name'       => 'homepage_sections',
                'type'       => 'flexible_content',
                'button_label' => 'Add Section',
                'layouts'    => fc_acf_homepage_layouts(),
            ],
        ],
        'location' => [ [ [ 'param' => 'page_template', 'operator' => '==', 'value' => 'front-page.php' ] ] ],
    ] );

} );

/**
 * Returns all flexible content layout definitions for the homepage.
 */
function fc_acf_homepage_layouts() : array {
    return [

        /* ── Hero ─────────────────────────────────────── */
        [
            'key'        => 'layout_fc_hero',
            'name'       => 'hero',
            'label'      => 'Hero',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_hero_eyebrow',      'label' => 'Eyebrow',         'name' => 'eyebrow',      'type' => 'text', 'placeholder' => 'Modern Healthcare', 'instructions' => 'Small uppercase label above the headline. Optional.' ],
                [ 'key' => 'field_fc_hero_headline',      'label' => 'Headline',        'name' => 'headline',     'type' => 'text', 'placeholder' => 'Healthcare, reimagined for modern life', 'instructions' => 'The main hero heading. Keep under 10 words for impact.' ],
                [ 'key' => 'field_fc_hero_headline_accent','label' => 'Accent Word(s)', 'name' => 'headline_accent','type' => 'text', 'instructions' => 'Word(s) from headline to style in accent color' ],
                [ 'key' => 'field_fc_hero_body',          'label' => 'Body Text',       'name' => 'body',         'type' => 'textarea', 'rows' => 3, 'instructions' => '1-2 sentences below the headline. Keep concise.' ],
                [ 'key' => 'field_fc_hero_cta_text',      'label' => 'Primary CTA Text','name' => 'cta_text',     'type' => 'text', 'placeholder' => 'Start Your Visit', 'default_value' => 'Start Your Visit' ],
                [ 'key' => 'field_fc_hero_cta_url',       'label' => 'Primary CTA URL', 'name' => 'cta_url',      'type' => 'url' ],
                [ 'key' => 'field_fc_hero_cta2_text',     'label' => 'Secondary CTA Text', 'name' => 'cta2_text', 'type' => 'text', 'placeholder' => 'See How It Works', 'instructions' => 'Optional ghost-style link below the primary CTA.' ],
                [ 'key' => 'field_fc_hero_cta2_url',      'label' => 'Secondary CTA URL','name' => 'cta2_url',    'type' => 'url' ],
                [ 'key' => 'field_fc_hero_trust_line',    'label' => 'Trust Line',      'name' => 'trust_line',   'type' => 'text', 'instructions' => 'e.g. "Trusted by 100,000+ patients"' ],
                [ 'key' => 'field_fc_hero_image',         'label' => 'Hero Image',      'name' => 'image',        'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
            ],
        ],

        /* ── Category Quick Links ─────────────────────── */
        [
            'key'        => 'layout_fc_categories',
            'name'       => 'category_links',
            'label'      => 'Category Quick Links',
            'display'    => 'block',
            'sub_fields' => [
                [
                    'key'        => 'field_fc_cat_items',
                    'label'      => 'Categories',
                    'name'       => 'items',
                    'type'       => 'repeater',
                    'layout'     => 'block',
                    'sub_fields' => [
                        [ 'key' => 'field_fc_cat_label', 'label' => 'Label', 'name' => 'label', 'type' => 'text', 'wrapper' => [ 'width' => '30' ] ],
                        [ 'key' => 'field_fc_cat_url',   'label' => 'URL',   'name' => 'url',   'type' => 'url',  'wrapper' => [ 'width' => '30' ] ],
                        [ 'key' => 'field_fc_cat_image', 'label' => 'Image', 'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail', 'wrapper' => [ 'width' => '20' ] ],
                        [ 'key' => 'field_fc_cat_icon',  'label' => 'Icon',  'name' => 'icon',  'type' => 'text', 'wrapper' => [ 'width' => '20' ], 'instructions' => 'check, shield, truck, heart, dollar, clock, users, lock, star, package, stethoscope' ],
                    ],
                ],
            ],
        ],

        /* ── Trust Marquee ────────────────────────────── */
        [
            'key'        => 'layout_fc_trust_marquee',
            'name'       => 'trust_marquee',
            'label'      => 'Trust Marquee Bar',
            'display'    => 'block',
            'sub_fields' => [
                [
                    'key'           => 'field_fc_tm_use_global',
                    'label'         => 'Use Global Trust Items',
                    'name'          => 'use_global',
                    'type'          => 'true_false',
                    'ui'            => 1,
                    'default_value' => 1,
                    'instructions'  => 'Toggle off to use custom items below',
                ],
                [
                    'key'        => 'field_fc_tm_items',
                    'label'      => 'Custom Items',
                    'name'       => 'items',
                    'type'       => 'repeater',
                    'layout'     => 'table',
                    'conditional_logic' => [ [ [ 'field' => 'field_fc_tm_use_global', 'operator' => '!=', 'value' => '1' ] ] ],
                    'sub_fields' => [
                        [ 'key' => 'field_fc_tm_icon', 'label' => 'Icon', 'name' => 'icon', 'type' => 'text', 'wrapper' => [ 'width' => '30' ] ],
                        [ 'key' => 'field_fc_tm_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text', 'wrapper' => [ 'width' => '70' ] ],
                    ],
                ],
            ],
        ],

        /* ── Service Band ─────────────────────────────── */
        [
            'key'        => 'layout_fc_service',
            'name'       => 'service_band',
            'label'      => 'Service / Program Band',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_svc_eyebrow',  'label' => 'Eyebrow',       'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_svc_headline',  'label' => 'Headline',      'name' => 'headline', 'type' => 'text' ],
                [ 'key' => 'field_fc_svc_accent',    'label' => 'Accent Word(s)','name' => 'headline_accent', 'type' => 'text' ],
                [ 'key' => 'field_fc_svc_color',     'label' => 'Accent Color',  'name' => 'accent_color', 'type' => 'color_picker', 'default_value' => '#2E936F', 'instructions' => 'Themes the eyebrow, accent headline words, checkmark icons, stat number, and CTA button for this section.' ],
                [ 'key' => 'field_fc_svc_subhead',   'label' => 'Subheading',    'name' => 'subheading','type' => 'text' ],
                [ 'key' => 'field_fc_svc_body',      'label' => 'Body',          'name' => 'body',     'type' => 'textarea', 'rows' => 3 ],
                [ 'key' => 'field_fc_svc_cta_text',  'label' => 'CTA Text',      'name' => 'cta_text', 'type' => 'text', 'placeholder' => 'Get Started', 'default_value' => 'Get Started' ],
                [ 'key' => 'field_fc_svc_cta_url',   'label' => 'CTA URL',       'name' => 'cta_url',  'type' => 'url' ],
                [ 'key' => 'field_fc_svc_image',     'label' => 'Primary Image', 'name' => 'image',    'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'instructions' => 'Main product or lifestyle image. Recommended 800×900px.' ],
                [ 'key' => 'field_fc_svc_image2',    'label' => 'Secondary Image','name' => 'image_2', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'instructions' => 'Optional supporting lifestyle image. Square works best.' ],
                [ 'key' => 'field_fc_svc_image3',    'label' => 'Tertiary Image','name' => 'image_3',  'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium', 'instructions' => 'Optional third image. Square works best.' ],
                [
                    'key'        => 'field_fc_svc_benefits',
                    'label'      => 'Benefits',
                    'name'       => 'benefits',
                    'type'       => 'repeater',
                    'layout'     => 'table',
                    'sub_fields' => [
                        [ 'key' => 'field_fc_svc_ben_text', 'label' => 'Benefit', 'name' => 'text', 'type' => 'text' ],
                    ],
                ],
                [
                    'key'           => 'field_fc_svc_layout',
                    'label'         => 'Image Position',
                    'name'          => 'image_position',
                    'type'          => 'select',
                    'choices'       => [ 'left' => 'Image Left', 'right' => 'Image Right' ],
                    'default_value' => 'left',
                ],
                [ 'key' => 'field_fc_svc_stat_number', 'label' => 'Stat Number', 'name' => 'stat_number', 'type' => 'text', 'instructions' => 'e.g. 95%' ],
                [ 'key' => 'field_fc_svc_stat_label',  'label' => 'Stat Label',  'name' => 'stat_label',  'type' => 'text' ],
            ],
        ],

        /* ── Trust Strip ──────────────────────────────── */
        [
            'key'        => 'layout_fc_trust_strip',
            'name'       => 'trust_strip',
            'label'      => 'Trust / Guarantee Strip',
            'display'    => 'block',
            'sub_fields' => [
                [
                    'key'        => 'field_fc_ts_items',
                    'label'      => 'Items',
                    'name'       => 'items',
                    'type'       => 'repeater',
                    'layout'     => 'block',
                    'sub_fields' => [
                        [ 'key' => 'field_fc_ts_icon',  'label' => 'Icon',        'name' => 'icon',  'type' => 'text', 'wrapper' => [ 'width' => '20' ], 'instructions' => 'shield, truck, heart, dollar, clock, users, lock, package, stethoscope' ],
                        [ 'key' => 'field_fc_ts_title', 'label' => 'Title',       'name' => 'title', 'type' => 'text', 'wrapper' => [ 'width' => '35' ] ],
                        [ 'key' => 'field_fc_ts_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'text', 'wrapper' => [ 'width' => '45' ] ],
                    ],
                ],
            ],
        ],

        /* ── Benefits Grid ────────────────────────────── */
        [
            'key'        => 'layout_fc_benefits',
            'name'       => 'benefits_grid',
            'label'      => 'Benefits Grid',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_bg_eyebrow',  'label' => 'Eyebrow',  'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_bg_headline',  'label' => 'Headline', 'name' => 'headline', 'type' => 'text' ],
                [
                    'key'        => 'field_fc_bg_items',
                    'label'      => 'Benefits',
                    'name'       => 'items',
                    'type'       => 'repeater',
                    'layout'     => 'block',
                    'sub_fields' => [
                        [ 'key' => 'field_fc_bg_icon',  'label' => 'Icon',        'name' => 'icon',  'type' => 'text', 'wrapper' => [ 'width' => '15' ], 'instructions' => 'shield, truck, heart, dollar, clock, users, lock, package, stethoscope' ],
                        [ 'key' => 'field_fc_bg_title', 'label' => 'Title',       'name' => 'title', 'type' => 'text', 'wrapper' => [ 'width' => '35' ] ],
                        [ 'key' => 'field_fc_bg_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'wrapper' => [ 'width' => '35' ] ],
                        [ 'key' => 'field_fc_bg_image', 'label' => 'Image',       'name' => 'image', 'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail', 'wrapper' => [ 'width' => '15' ] ],
                    ],
                ],
            ],
        ],

        /* ── Split Content ────────────────────────────── */
        [
            'key'        => 'layout_fc_split',
            'name'       => 'split_content',
            'label'      => 'Split Content (Editorial)',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_sp_eyebrow',  'label' => 'Eyebrow',  'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_sp_headline',  'label' => 'Headline', 'name' => 'headline', 'type' => 'text' ],
                [ 'key' => 'field_fc_sp_accent',    'label' => 'Accent Word(s)', 'name' => 'headline_accent', 'type' => 'text' ],
                [ 'key' => 'field_fc_sp_body',      'label' => 'Body',     'name' => 'body',     'type' => 'wysiwyg', 'media_upload' => 0, 'toolbar' => 'basic' ],
                [ 'key' => 'field_fc_sp_cta_text',  'label' => 'CTA Text', 'name' => 'cta_text', 'type' => 'text' ],
                [ 'key' => 'field_fc_sp_cta_url',   'label' => 'CTA URL',  'name' => 'cta_url',  'type' => 'url' ],
                [ 'key' => 'field_fc_sp_image',     'label' => 'Image',    'name' => 'image',    'type' => 'image', 'return_format' => 'array', 'preview_size' => 'medium' ],
                [
                    'key'           => 'field_fc_sp_layout',
                    'label'         => 'Image Position',
                    'name'          => 'image_position',
                    'type'          => 'select',
                    'choices'       => [ 'left' => 'Image Left', 'right' => 'Image Right' ],
                    'default_value' => 'right',
                ],
            ],
        ],

        /* ── How It Works ─────────────────────────────── */
        [
            'key'        => 'layout_fc_process',
            'name'       => 'how_it_works',
            'label'      => 'How It Works',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_hw_eyebrow',  'label' => 'Eyebrow',  'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_hw_headline',  'label' => 'Headline', 'name' => 'headline', 'type' => 'text' ],
                [
                    'key'        => 'field_fc_hw_steps',
                    'label'      => 'Steps',
                    'name'       => 'steps',
                    'type'       => 'repeater',
                    'layout'     => 'block',
                    'sub_fields' => [
                        [ 'key' => 'field_fc_hw_title', 'label' => 'Title',       'name' => 'title', 'type' => 'text', 'wrapper' => [ 'width' => '30' ] ],
                        [ 'key' => 'field_fc_hw_desc',  'label' => 'Description', 'name' => 'description', 'type' => 'textarea', 'rows' => 2, 'wrapper' => [ 'width' => '50' ] ],
                        [ 'key' => 'field_fc_hw_icon',  'label' => 'Icon',        'name' => 'icon', 'type' => 'text', 'wrapper' => [ 'width' => '20' ], 'instructions' => 'Optional. shield, truck, heart, dollar, clock, users, lock, package, stethoscope' ],
                    ],
                ],
            ],
        ],

        /* ── Clinicians ───────────────────────────────── */
        [
            'key'        => 'layout_fc_clinicians',
            'name'       => 'clinicians',
            'label'      => 'Clinicians / Team',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_cl_eyebrow',  'label' => 'Eyebrow',  'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_cl_headline',  'label' => 'Headline', 'name' => 'headline', 'type' => 'text' ],
                [ 'key' => 'field_fc_cl_body',      'label' => 'Body',     'name' => 'body',     'type' => 'textarea', 'rows' => 2 ],
                [
                    'key'           => 'field_fc_cl_source',
                    'label'         => 'Clinician Source',
                    'name'          => 'source',
                    'type'          => 'select',
                    'choices'       => [ 'cpt' => 'All Published Clinicians (automatic)', 'manual' => 'Pick Specific Clinicians' ],
                    'default_value' => 'cpt',
                    'instructions'  => '"All Published" automatically shows clinician posts. "Pick Specific" lets you choose and order them.',
                ],
                [
                    'key'        => 'field_fc_cl_manual',
                    'label'      => 'Select Clinicians',
                    'name'       => 'manual_clinicians',
                    'type'       => 'relationship',
                    'post_type'  => [ 'fc_clinician' ],
                    'return_format' => 'object',
                    'conditional_logic' => [ [ [ 'field' => 'field_fc_cl_source', 'operator' => '==', 'value' => 'manual' ] ] ],
                ],
            ],
        ],

        /* ── Testimonials ─────────────────────────────── */
        [
            'key'        => 'layout_fc_testimonials',
            'name'       => 'testimonials',
            'label'      => 'Testimonials',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_tl_eyebrow',  'label' => 'Eyebrow',  'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_tl_headline',  'label' => 'Headline', 'name' => 'headline', 'type' => 'text' ],
                [
                    'key'           => 'field_fc_tl_source',
                    'label'         => 'Testimonial Source',
                    'name'          => 'source',
                    'type'          => 'select',
                    'choices'       => [ 'cpt' => 'All Published Testimonials (automatic)', 'manual' => 'Enter Manually Below' ],
                    'default_value' => 'cpt',
                    'instructions'  => '"All Published" pulls from the Testimonials post type. "Enter Manually" lets you type them directly here.',
                ],
                [
                    'key'        => 'field_fc_tl_manual',
                    'label'      => 'Testimonials',
                    'name'       => 'manual_testimonials',
                    'type'       => 'repeater',
                    'layout'     => 'block',
                    'conditional_logic' => [ [ [ 'field' => 'field_fc_tl_source', 'operator' => '==', 'value' => 'manual' ] ] ],
                    'sub_fields' => [
                        [ 'key' => 'field_fc_tl_m_quote',     'label' => 'Quote',     'name' => 'quote',     'type' => 'textarea', 'rows' => 2 ],
                        [ 'key' => 'field_fc_tl_m_name',      'label' => 'Name',      'name' => 'name',      'type' => 'text' ],
                        [ 'key' => 'field_fc_tl_m_treatment', 'label' => 'Treatment', 'name' => 'treatment', 'type' => 'text' ],
                        [ 'key' => 'field_fc_tl_m_rating',    'label' => 'Rating',    'name' => 'rating',    'type' => 'number', 'min' => 1, 'max' => 5, 'default_value' => 5 ],
                        [ 'key' => 'field_fc_tl_m_image',     'label' => 'Photo',     'name' => 'image',     'type' => 'image', 'return_format' => 'array', 'preview_size' => 'thumbnail' ],
                    ],
                ],
            ],
        ],

        /* ── CTA Banner ───────────────────────────────── */
        [
            'key'        => 'layout_fc_cta_banner',
            'name'       => 'cta_banner',
            'label'      => 'CTA Banner',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_cb_headline',  'label' => 'Headline',       'name' => 'headline',  'type' => 'text' ],
                [ 'key' => 'field_fc_cb_body',      'label' => 'Body',           'name' => 'body',      'type' => 'textarea', 'rows' => 2 ],
                [ 'key' => 'field_fc_cb_cta_text',  'label' => 'CTA Text',       'name' => 'cta_text',  'type' => 'text' ],
                [ 'key' => 'field_fc_cb_cta_url',   'label' => 'CTA URL',        'name' => 'cta_url',   'type' => 'url' ],
                [ 'key' => 'field_fc_cb_cta2_text', 'label' => 'Secondary CTA',  'name' => 'cta2_text', 'type' => 'text' ],
                [ 'key' => 'field_fc_cb_cta2_url',  'label' => 'Secondary URL',  'name' => 'cta2_url',  'type' => 'url' ],
                [
                    'key'           => 'field_fc_cb_style',
                    'label'         => 'Background Style',
                    'name'          => 'style',
                    'type'          => 'select',
                    'choices'       => [ 'dark' => 'Dark (near-black)', 'light' => 'Light (cream)', 'accent' => 'Brand Green Gradient' ],
                    'default_value' => 'dark',
                    'instructions'  => 'Controls the banner background. Button colors adapt automatically.',
                ],
            ],
        ],

        /* ── FAQ ──────────────────────────────────────── */
        [
            'key'        => 'layout_fc_faq',
            'name'       => 'faq',
            'label'      => 'FAQ',
            'display'    => 'block',
            'sub_fields' => [
                [ 'key' => 'field_fc_faq_eyebrow',  'label' => 'Eyebrow',  'name' => 'eyebrow',  'type' => 'text' ],
                [ 'key' => 'field_fc_faq_headline',  'label' => 'Headline', 'name' => 'headline', 'type' => 'text' ],
                [
                    'key'        => 'field_fc_faq_items',
                    'label'      => 'Questions',
                    'name'       => 'items',
                    'type'       => 'repeater',
                    'layout'     => 'block',
                    'sub_fields' => [
                        [ 'key' => 'field_fc_faq_q', 'label' => 'Question', 'name' => 'question', 'type' => 'text' ],
                        [ 'key' => 'field_fc_faq_a', 'label' => 'Answer',   'name' => 'answer',   'type' => 'wysiwyg', 'media_upload' => 0, 'toolbar' => 'basic' ],
                    ],
                ],
            ],
        ],

    ];
}
