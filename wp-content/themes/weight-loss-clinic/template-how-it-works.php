<?php
/**
 * Template Name: How It Works
 *
 * MVP layout (May 2026):
 *   - Image hero (lifestyle, "considered first step")
 *   - Three-step summary above fold (shared partial with homepage)
 *   - Quiet reassurance strip
 *   - Full 8-step pathway (collapsible details — clean, not bloated)
 *   - "Not every patient is approved" trust block
 *   - Suitability split — fit / not fit
 *   - Final CTA
 *
 * All copy is editable in Customize → Theme Settings → Page — How It Works;
 * defaults live in inc/options/page-how-it-works.php.
 *
 * Operational detail belongs in FAQs, not here.
 *
 * Page slug: /how-it-works/
 *
 * @package WeightLossClinic
 */

get_header();

$quiz_url    = fc_setting( 'cta_url' );
$booking_url = fc_setting( 'booking_url' );
$faq_url     = fc_setting( 'faq_url' );
$pathway_uri   = FC_URI . '/assets/images/pathway';
$lifestyle_uri = FC_URI . '/assets/images/lifestyle';

$specialist = fc_setting( 'specialist_name' );

$hero_image = fc_setting_image( 'hiw_hero_image', $lifestyle_uri . '/healthy-meal-prep.jpg' );

// Specialist-threaded copy: empty settings fall back to generated strings.
$pathway_intro = fc_setting( 'hiw_pathway_intro', '' )
    ?: 'Most patients complete the first step in under two minutes. Every decision is reviewed by ' . $specialist . ' or an Australian-registered clinician.';
$detail_step3_body = fc_setting( 'hiw_detail_step3_body', '' )
    ?: 'A 20–30 minute video consultation with an AHPRA-registered clinician — ' . $specialist . ' or another member of the clinical team.';

// Full 8-step pathway used in the collapsible detail section
$pathway_steps = [];
foreach ( range( 1, 8 ) as $n ) {
    $title = fc_setting( "hiw_detail_step{$n}_title" );
    $body  = 3 === $n ? $detail_step3_body : fc_setting( "hiw_detail_step{$n}_body" );
    if ( ! $title || ! $body ) {
        continue;
    }
    $pathway_steps[] = [
        'n'     => str_pad( (string) $n, 2, '0', STR_PAD_LEFT ),
        'title' => $title,
        'body'  => $body,
    ];
}

// Three-step summary (shared partial); image fallbacks ship with the theme.
$step_images = [
    1 => [ 'image' => $pathway_uri . '/03-ongoing.jpg',                'alt' => 'A patient at home reviewing her clinical assessment on her phone.', 'pos' => 'center 30%' ],
    2 => [ 'image' => $pathway_uri . '/02-specialist.jpg',             'alt' => $specialist . ' in consultation at his desk.',                       'pos' => 'center 32%' ],
    3 => [ 'image' => $pathway_uri . '/delivery-box-clinic-tick.webp', 'alt' => 'Discreet delivery box outside a home for clinician-led weight management programme', 'pos' => 'center center' ],
];
$summary_steps = [];
foreach ( [ 1, 2, 3 ] as $n ) {
    $summary_steps[] = [
        'n'               => str_pad( (string) $n, 2, '0', STR_PAD_LEFT ),
        'title'           => fc_setting( "hiw_pathway_step{$n}_title" ),
        'body'            => fc_setting( "hiw_pathway_step{$n}_body" ),
        'meta'            => fc_setting( "hiw_pathway_step{$n}_meta" ),
        'image'           => fc_setting_image( "hiw_pathway_step{$n}_image", $step_images[ $n ]['image'] ),
        'alt'             => $step_images[ $n ]['alt'],
        'object_position' => $step_images[ $n ]['pos'],
    ];
}
?>

<article class="fc-page fc-page--hiw">

    <div class="fc-page__hero" role="presentation">
        <img
            src="<?php echo esc_url( $hero_image ); ?>"
            alt=""
            class="fc-page__hero-img"
            width="2400"
            height="1600"
            loading="eager"
            decoding="async"
            fetchpriority="high">
        <div class="fc-page__hero-overlay" aria-hidden="true"></div>
        <div class="fc-container">
            <header class="fc-page__header fc-page__header--over-image fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'hiw_hero_eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo fc_accent_headline( fc_setting( 'hiw_hero_headline' ), fc_setting( 'hiw_hero_accent' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo esc_html( fc_setting( 'hiw_hero_intro' ) ); ?></p>
                <div class="fc-page__header-actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="fc-btn fc-btn--ghost-light">Book a consultation</a>
                </div>
            </header>
        </div>
    </div>

    <?php
    // ── The three-step pathway (shared partial with the homepage) ──
    get_template_part( 'template-parts/sections/specialist-pathway', null, [ 'data' => [
        'eyebrow'    => fc_setting( 'hiw_pathway_eyebrow' ),
        'headline'   => fc_setting( 'hiw_pathway_headline' ),
        'intro_body' => $pathway_intro,
        'cta_text'   => 'Check eligibility',
        'cta_url'    => $quiz_url,
        'steps'      => $summary_steps,
        'footnote'   => '',
    ] ] );
    ?>

    <!-- ── Quiet reassurance strip ── -->
    <section class="fc-section fc-section--hiw-promise">
        <div class="fc-container">
            <div class="fc-hiw-promise fc-reveal">
                <?php foreach ( fc_setting_pairs( 'hiw_promise_items', [ 'label', 'detail' ] ) as $item ) : ?>
                    <div class="fc-hiw-promise__item">
                        <p class="fc-eyebrow"><?php echo esc_html( $item['label'] ); ?></p>
                        <p><?php echo esc_html( $item['detail'] ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── Full 8-step pathway (collapsible detail) ── -->
    <section class="fc-section fc-section--hiw-detail">
        <div class="fc-container fc-container--narrow">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'hiw_detail_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'hiw_detail_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'hiw_detail_body' ) ); ?></p>
            </div>

            <div class="fc-faq-group__items fc-reveal">
                <?php foreach ( $pathway_steps as $i => $step ) : ?>
                    <details class="fc-faq-item"<?php echo $i === 0 ? ' open' : ''; ?>>
                        <summary class="fc-faq-item__summary">
                            <span class="fc-faq-item__question"><span class="fc-pathway-step-num"><?php echo esc_html( $step['n'] ); ?></span> <?php echo esc_html( $step['title'] ); ?></span>
                            <span class="fc-faq-item__icon" aria-hidden="true">+</span>
                        </summary>
                        <div class="fc-faq-item__answer">
                            <p><?php echo esc_html( $step['body'] ); ?></p>
                        </div>
                    </details>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── Not every patient is approved ── -->
    <section class="fc-section fc-section--plan-compliance">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-compliance fc-reveal">
                <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'hiw_compliance_title' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'hiw_compliance_body' ) ); ?></p>
                <ul class="fc-plan-compliance__list">
                    <?php foreach ( fc_setting_lines( 'hiw_compliance_items' ) as $item ) : ?>
                        <li><?php echo esc_html( $item ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- ── Suitability ── -->
    <section class="fc-section fc-section--hiw-fit">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'hiw_fit_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'hiw_fit_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'hiw_fit_body' ) ); ?></p>
            </div>
            <div class="fc-hiw-fit">
                <div class="fc-hiw-fit__card fc-reveal">
                    <h3 class="fc-h3"><?php echo esc_html( fc_setting( 'hiw_fit_yes_title' ) ); ?></h3>
                    <ul class="fc-hiw-fit__list fc-hiw-fit__list--positive">
                        <?php foreach ( fc_setting_lines( 'hiw_fit_yes_items' ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="fc-hiw-fit__card fc-reveal">
                    <h3 class="fc-h3"><?php echo esc_html( fc_setting( 'hiw_fit_no_title' ) ); ?></h3>
                    <ul class="fc-hiw-fit__list fc-hiw-fit__list--negative">
                        <?php foreach ( fc_setting_lines( 'hiw_fit_no_items' ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <p class="fc-section-header__body fc-reveal" style="text-align:center;margin-top:var(--fc-space-xl);">
                <?php echo esc_html( fc_setting( 'hiw_fit_footnote' ) ); ?> <a href="<?php echo esc_url( $faq_url ); ?>">Read more in the FAQ</a>.
            </p>
        </div>
    </section>

    <!-- ── Final CTA ── -->
    <section class="fc-section fc-section--hiw-cta">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-cta fc-reveal">
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'hiw_cta_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'hiw_cta_body' ) ); ?></p>
                <div class="fc-plan-cta__actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="fc-btn fc-btn--ghost">Book a consultation</a>
                </div>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
