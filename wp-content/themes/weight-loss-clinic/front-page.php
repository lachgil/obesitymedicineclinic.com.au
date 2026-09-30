<?php
/**
 * Template Name: Homepage
 *
 * Renders the modular homepage using ACF Flexible Content.
 * Each layout maps to a template part in /template-parts/sections/.
 *
 * When ACF is not active or no sections are configured, renders
 * a compliant, conversion-optimised homepage aligned with AHPRA,
 * Medical Board, and Australian regulatory requirements.
 *
 * COMPLIANCE NOTES:
 * - No prescription-only medicine names (semaglutide, tirzepatide, GLP-1, Ozempic)
 * - No medication pricing
 * - No guaranteed outcomes or exaggerated claims
 * - Clear intake → review → consult → decision pathway
 * - Telehealth limitations disclosed
 * - "Not all patients approved" reinforced throughout
 */

get_header();

$has_acf     = function_exists( 'have_rows' );
$has_content = $has_acf && have_rows( 'homepage_sections' );

if ( $has_content ) :
    while ( have_rows( 'homepage_sections' ) ) : the_row();

        $layout = get_row_layout();
        $data   = get_row( true );

        $template_map = [
            'hero'                 => 'hero',
            'category_links'       => 'category-links',
            'trust_marquee'        => 'trust-marquee',
            'service_band'         => 'service-band',
            'support_cards'        => 'support-cards',
            'trust_strip'          => 'trust-strip',
            'benefits_grid'        => 'benefits-grid',
            'proof_cards'          => 'proof-cards',
            'split_content'        => 'split-content',
            'how_it_works'         => 'how-it-works',
            'clinicians'           => 'clinicians',
            'testimonials'         => 'testimonials',
            'testimonials_marquee' => 'testimonials-marquee',
            'cta_banner'           => 'cta-banner',
            'faq'                  => 'faq',
            'sticky_trust_bar'     => 'sticky-trust-bar',
            'program_pathways'     => 'program-pathways',
            'goal_calculator'      => 'goal-calculator',
            'clinical_governance'  => 'clinical-governance',
            'pathway_highlights'   => 'pathway-highlights',
            'cta_starter'          => 'cta-starter',
        ];

        if ( isset( $template_map[ $layout ] ) ) {
            get_template_part(
                'template-parts/sections/' . $template_map[ $layout ],
                null,
                [ 'data' => $data ]
            );
        }

    endwhile;
else :
    // ─── Compliant Demo / Fallback Homepage ────────────────────
    // AHPRA-aligned. No drug names. No outcome guarantees.
    // Structured clinical pathway framing throughout.

    $quiz_url    = fc_setting( 'cta_url' );
    $hiw_url     = fc_setting( 'how_it_works_url' );
    $clinician_uri = FC_URI . '/assets/images/clinician';

    // Trust bar now renders globally from header.php (see
    // template-parts/header/trust-bar.php). Intentionally not rendered
    // again here to prevent a duplicate green bar at the top of the page.

    // ── CINEMATIC HERO (Dr Kevin Dolan poster / optional 8s video) ──
    // Hero video file (if present) should be uploaded to:
    //   /wp-content/uploads/wlc-hero/hero-clinic.mp4  (≤ 6 MB, h.264, 1080p, ~8s)
    // The poster image always renders and prevents layout shift.
    $hero_video    = trailingslashit( wp_upload_dir()['baseurl'] ) . 'wlc-hero/hero-clinic.mp4';
    $hero_video_fs = trailingslashit( wp_upload_dir()['basedir'] ) . 'wlc-hero/hero-clinic.mp4';
    $has_hero_video = file_exists( $hero_video_fs );

    // ── HERO — 3-slide premium carousel ──
    //
    //   Slide 01 — Clinician-led care (keeps existing hero imagery & tone)
    //   Slide 02 — Outcomes / structured-care reassurance (editorial stat blocks)
    //   Slide 03 — Pricing / accessibility (calm, transparent)
    //
    // All copy and imagery is editable in Customize → Theme Settings →
    // Homepage — Hero Carousel; the values below only supply theme-asset
    // image fallbacks and layout constants.
    //
    // Compliance: no drug names, no efficacy percentages, no guaranteed
    // outcomes. Stat blocks describe pathway facts, not medical claims.
    $pathway_uri     = FC_URI . '/assets/images/pathway';
    $specialist_name  = fc_setting( 'specialist_name' );
    $specialist_title = wp_strip_all_tags( fc_setting( 'specialist_title' ) );

    get_template_part( 'template-parts/sections/hero-carousel', null, [ 'data' => [
        'autoplay_ms' => 7000,
        'aria_label'  => 'Introduction',
        'slides'      => [
            // ── Slide 01: Clinician-led care ──────────────────────
            [
                'kind'         => 'clinical',
                'eyebrow'      => fc_setting( 'home_slide1_eyebrow' ),
                'headline'     => fc_setting( 'home_slide1_headline' ),
                'body'         => fc_setting( 'home_slide1_body' ),
                'cta_text'     => fc_setting( 'home_slide1_cta_text' ),
                'cta_url'      => $quiz_url,
                'poster_image' => fc_setting_image( 'home_slide1_image', $clinician_uri . '/hero-poster.jpg' ),
                'poster_alt'   => $specialist_name . ' in consultation',
                'reassurance'  => fc_setting_lines( 'home_slide1_reassurance' ),
                'attribution'  => $specialist_name . ' · ' . $specialist_title,
            ],

            // ── Slide 02: Outcomes / editorial reassurance ────────
            [
                'kind'        => 'outcomes',
                'eyebrow'     => fc_setting( 'home_slide2_eyebrow' ),
                'headline'    => fc_setting( 'home_slide2_headline' ),
                'body'        => fc_setting( 'home_slide2_body' ),
                'cta_text'    => fc_setting( 'home_slide1_cta_text' ),
                'cta_url'     => $quiz_url,
                'stats'       => fc_setting_pairs( 'home_slide2_stats', [ 'label', 'detail' ] ),
            ],

            // ── Slide 03: Private pathway / discreet delivery ─────
            [
                'kind'          => 'pricing',
                'eyebrow'       => fc_setting( 'home_slide3_eyebrow' ),
                'headline'      => fc_setting( 'home_slide3_headline' ),
                'body'          => fc_setting( 'home_slide3_body' ),
                'cta_text'      => fc_setting( 'home_slide1_cta_text' ),
                'cta_url'       => $quiz_url,
                'poster_image'  => fc_setting_image( 'home_slide3_image', $pathway_uri . '/delivery-box-clinic-tick.webp' ),
                'poster_alt'    => 'Discreet delivery box outside a home for clinician-led weight management programme',
                'price_lead'    => fc_setting( 'home_slide3_price_lead', '' ) ?: '$' . fc_setting( 'price_from' ),
                'price_suffix'  => fc_setting( 'home_slide3_price_suffix' ),
                'price_caption' => fc_setting( 'home_slide3_price_caption', '' )
                    ?: 'Follow-up consultations $' . fc_setting( 'price_followup' ) . ' · script renewals and reviews. No lock-in contracts.',
                'footnote'      => fc_setting( 'home_slide3_footnote' ),
            ],
        ],
    ] ] );

    // ── QUIET INSTITUTIONAL STRIP — moved high so the regulatory framing
    //    (AHPRA, doctor-led, privacy, "not all approved") sits between the
    //    hero and the pathway, matching the brief's recommended order. ──
    $governance_points = array_map( function ( $row ) {
        return [ 'icon' => $row['label'], 'title' => $row['value'], 'description' => '' ];
    }, fc_setting_pairs( 'home_governance_points' ) );

    get_template_part( 'template-parts/sections/clinical-governance', null, [ 'data' => [
        'eyebrow'  => '',
        'headline' => '',
        'body'     => '',
        'compact'  => true,
        'points'   => $governance_points,
    ] ] );

    // ── HOW IT WORKS — vertical clinical pathway (MEDVi-inspired) ──
    $pathway_intro = fc_setting( 'home_pathway_intro', '' )
        ?: 'Every step is reviewed by ' . $specialist_name . ' or an Australian-registered clinician. Suitability is assessed before treatment is recommended.';
    $step2_body = fc_setting( 'home_pathway_step2_body', '' )
        ?: 'Speak with ' . $specialist_name . ' or an Australian-registered clinician to review your information, ask questions, and discuss appropriate next steps.';

    get_template_part( 'template-parts/sections/specialist-pathway', null, [ 'data' => [
        'eyebrow'    => fc_setting( 'home_pathway_eyebrow' ),
        'headline'   => fc_setting( 'home_pathway_headline' ),
        'intro_body' => $pathway_intro,
        'cta_text'   => 'Check eligibility',
        'cta_url'    => $quiz_url,
        'steps'      => [
            [
                'n'               => '01',
                'title'           => fc_setting( 'home_pathway_step1_title' ),
                'body'            => fc_setting( 'home_pathway_step1_body' ),
                'image'           => fc_setting_image( 'home_pathway_step1_image', $pathway_uri . '/03-ongoing.jpg' ),
                'alt'             => 'A patient at home reviewing her clinical assessment on her phone.',
                'object_position' => 'center 30%',
            ],
            [
                'n'               => '02',
                'title'           => fc_setting( 'home_pathway_step2_title' ),
                'body'            => $step2_body,
                'image'           => fc_setting_image( 'home_pathway_step2_image', $pathway_uri . '/02-specialist.jpg' ),
                'alt'             => $specialist_name . ' in consultation at his desk.',
                'object_position' => 'center 32%',
            ],
            [
                'n'               => '03',
                'title'           => fc_setting( 'home_pathway_step3_title' ),
                'body'            => fc_setting( 'home_pathway_step3_body' ),
                'image'           => fc_setting_image( 'home_pathway_step3_image', $pathway_uri . '/delivery-box-clinic-tick.webp' ),
                'alt'             => 'Discreet delivery box outside a home for clinician-led weight management programme',
                'object_position' => 'center center',
            ],
        ],
        'footnote'  => '',
    ] ] );

    // ── LED BY THE SPECIALIST — one image, one paragraph ──
    $split_body = fc_setting( 'home_split_body', '' );
    $split_body = $split_body
        ? '<p>' . esc_html( $split_body ) . '</p>'
        : '<p>' . esc_html( $specialist_name ) . ' has spent years helping patients navigate structured, clinician-led weight management pathways with an emphasis on safety, long-term outcomes, and ongoing support.</p>';

    get_template_part( 'template-parts/sections/split-content', null, [ 'data' => [
        'eyebrow'          => 'Led by ' . $specialist_name,
        'headline'         => fc_setting( 'home_split_headline' ),
        'headline_accent'  => fc_setting( 'home_split_accent' ),
        'body'             => $split_body,
        'cta_text'         => '',
        'cta_url'          => '',
        'image'            => [
            'url'    => fc_setting_image( 'home_split_image', $clinician_uri . '/dr-dolan-explaining.jpg' ),
            'alt'    => $specialist_name . ', ' . $specialist_title,
            'width'  => 1600,
            'height' => 900,
            'sizes'  => [],
        ],
        'image_position'   => 'left',
    ] ] );

    // ── FINAL CTA — inline assessment starter (frictionless entry into /quiz/) ──
    get_template_part( 'template-parts/sections/cta-starter', null, [ 'data' => [
        'eyebrow'   => fc_setting( 'home_starter_eyebrow' ),
        'headline'  => fc_setting( 'home_starter_headline' ),
        'body'      => fc_setting( 'home_starter_body' ),
        'quiz_url'  => $quiz_url,
        'cta_text'  => fc_setting( 'home_starter_cta_text' ),
        'question'  => fc_setting( 'home_starter_question' ),
        'field_name'=> 'starter_intent',
        'options'   => fc_setting_pairs( 'home_starter_options' ),
        'microcopy' => fc_setting( 'home_starter_microcopy' ),
    ] ] );

endif;

get_footer();
