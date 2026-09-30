<?php
/**
 * Template Name: Plans & Programs
 *
 * Service-structured plans page. NOT a medication retail page.
 *
 * All copy is editable in Customize → Theme Settings → Plans Page sections;
 * the starting price comes from Buttons & CTAs → Starting Price. Defaults
 * live in fc_plans_defaults() (inc/helpers/theme-options.php).
 *
 * MVP layout (May 2026):
 *   - Image hero (lifestyle imagery, "structured around your life")
 *   - What's included (4 service blocks, no box clutter)
 *   - Program pathway / pricing structure
 *   - Suitability split — who this is for / who this isn't for
 *   - Compliance + decline language
 *   - FAQ preview → /faq/
 *   - Final CTA
 *
 * COMPLIANCE:
 *   - No prescription medicine names
 *   - No direct-to-consumer medicine advertising
 *   - No outcome guarantees
 *   - Pricing expressed as program structure, not medication
 *
 * Page slug: /plans/  (auto-created by inc/setup/pages.php)
 *
 * @package WeightLossClinic
 */

get_header();

$quiz_url       = fc_setting( 'cta_url' );
$booking_url    = fc_setting( 'booking_url' );
$hiw_url        = fc_setting( 'how_it_works_url' );
$faq_url        = fc_setting( 'faq_url' );
$price_initial  = (int) fc_setting( 'price_from' );
$price_followup = (int) fc_setting( 'price_followup' );

// Per-tier price: explicit value wins; empty falls back to the global fees.
$tier_prices = [
    1 => fc_setting( 'plans_tier1_price', '' ) ?: '$' . $price_initial,
    2 => fc_setting( 'plans_tier2_price', '' ) ?: '$' . $price_followup,
    3 => fc_setting( 'plans_tier3_price' ),
];

$lifestyle_uri = FC_URI . '/assets/images/lifestyle';
$hero_image    = fc_setting_image( 'plans_hero_image', $lifestyle_uri . '/walking-outdoors.jpg' );
?>

<article class="fc-page fc-page--plans">

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
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'plans_hero_eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo fc_accent_headline( fc_setting( 'plans_hero_headline' ), fc_setting( 'plans_hero_accent' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo esc_html( fc_setting( 'plans_hero_intro' ) ); ?></p>
                <div class="fc-page__header-actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="fc-btn fc-btn--ghost-light">Book a consultation</a>
                </div>
            </header>
        </div>
    </div>

    <!-- ── Pricing (consultation fees — first thing visitors look for) ── -->
    <section class="fc-section fc-section--plan-tiers">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'plans_tiers_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'plans_tiers_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'plans_tiers_body' ) ); ?></p>
            </div>

            <div class="fc-plan-tiers">
                <?php
                $tier_ctas = [
                    1 => [ 'url' => $booking_url, 'style' => 'primary', 'text' => 'Book a consultation' ],
                    2 => [ 'url' => $quiz_url,    'style' => 'ghost',   'text' => 'Check eligibility' ],
                    3 => [ 'url' => $hiw_url,     'style' => 'ghost',   'text' => 'See the full pathway' ],
                ];
                foreach ( [ 1, 2, 3 ] as $n ) :
                    // The initial consultation is the entry point — feature it.
                    $featured = ( 1 === $n );
                    $cta      = $tier_ctas[ $n ];
                    $price    = $tier_prices[ $n ];
                    $detail   = fc_setting( "plans_tier{$n}_price_detail" );
                ?>
                <div class="fc-plan-tier<?php echo $featured ? ' fc-plan-tier--featured' : ''; ?> fc-reveal">
                    <p class="fc-plan-tier__label"><?php echo esc_html( fc_setting( "plans_tier{$n}_label" ) ); ?></p>
                    <h3 class="fc-h3"><?php echo esc_html( fc_setting( "plans_tier{$n}_title" ) ); ?></h3>
                    <?php if ( $price ) : ?>
                        <p class="fc-plan-tier__price"><strong><?php echo esc_html( $price ); ?></strong><?php if ( $detail ) : ?> <span>&middot; <?php echo esc_html( $detail ); ?></span><?php endif; ?></p>
                    <?php endif; ?>
                    <p class="fc-plan-tier__summary"><?php echo esc_html( fc_setting( "plans_tier{$n}_summary" ) ); ?></p>
                    <ul class="fc-plan-tier__list">
                        <?php foreach ( fc_setting_lines( "plans_tier{$n}_items" ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <a href="<?php echo esc_url( $cta['url'] ); ?>" class="fc-btn fc-btn--<?php echo esc_attr( $cta['style'] ); ?>"><?php echo esc_html( $cta['text'] ); ?></a>
                </div>
                <?php endforeach; ?>
            </div>

            <p class="fc-plan-tiers__fineprint"><?php echo esc_html( fc_setting( 'plans_tiers_fineprint' ) ); ?></p>
        </div>
    </section>

    <!-- ── What's included ── -->
    <section class="fc-section fc-section--plan-inclusions">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'plans_inclusions_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'plans_inclusions_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'plans_inclusions_body' ) ); ?></p>
            </div>

            <div class="fc-plan-inclusions">
                <?php foreach ( [ 1, 2, 3, 4 ] as $n ) :
                    $title = fc_setting( "plans_inclusion{$n}_title" );
                    if ( ! $title ) {
                        continue;
                    }
                ?>
                <div class="fc-plan-inclusion fc-reveal">
                    <span class="fc-plan-inclusion__num"><?php echo esc_html( str_pad( (string) $n, 2, '0', STR_PAD_LEFT ) ); ?></span>
                    <h3 class="fc-h3"><?php echo esc_html( $title ); ?></h3>
                    <p><?php echo esc_html( fc_setting( "plans_inclusion{$n}_body" ) ); ?></p>
                    <ul class="fc-plan-inclusion__list">
                        <?php foreach ( fc_setting_lines( "plans_inclusion{$n}_items" ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── Suitability split (mirrors /how-it-works/ pattern) ── -->
    <section class="fc-section fc-section--hiw-fit">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'plans_fit_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'plans_fit_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'plans_fit_body' ) ); ?></p>
            </div>
            <div class="fc-hiw-fit">
                <div class="fc-hiw-fit__card fc-reveal">
                    <h3 class="fc-h3"><?php echo esc_html( fc_setting( 'plans_fit_yes_title' ) ); ?></h3>
                    <ul class="fc-hiw-fit__list fc-hiw-fit__list--positive">
                        <?php foreach ( fc_setting_lines( 'plans_fit_yes_items' ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <div class="fc-hiw-fit__card fc-reveal">
                    <h3 class="fc-h3"><?php echo esc_html( fc_setting( 'plans_fit_no_title' ) ); ?></h3>
                    <ul class="fc-hiw-fit__list fc-hiw-fit__list--negative">
                        <?php foreach ( fc_setting_lines( 'plans_fit_no_items' ) as $item ) : ?>
                            <li><?php echo esc_html( $item ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Compliance + decline language ── -->
    <section class="fc-section fc-section--plan-compliance">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-compliance fc-reveal">
                <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'plans_compliance_title' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'plans_compliance_body' ) ); ?></p>
                <ul class="fc-plan-compliance__list">
                    <?php foreach ( fc_setting_lines( 'plans_compliance_items' ) as $item ) : ?>
                        <li><?php echo esc_html( $item ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- ── FAQ preview ── -->
    <section class="fc-section fc-section--plan-faq-preview">
        <div class="fc-container fc-container--narrow">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'plans_faq_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'plans_faq_headline' ) ); ?></h2>
            </div>

            <div class="fc-faq-group__items fc-reveal">
                <?php foreach ( [ 1, 2, 3 ] as $n ) :
                    $q = fc_setting( "plans_faq_q{$n}" );
                    $a = fc_setting( "plans_faq_a{$n}" );
                    if ( ! $q || ! $a ) {
                        continue;
                    }
                ?>
                <details class="fc-faq-item"<?php echo 1 === $n ? ' open' : ''; ?>>
                    <summary class="fc-faq-item__summary">
                        <span class="fc-faq-item__question"><?php echo esc_html( $q ); ?></span>
                        <span class="fc-faq-item__icon" aria-hidden="true">+</span>
                    </summary>
                    <div class="fc-faq-item__answer">
                        <p><?php echo esc_html( $a ); ?></p>
                    </div>
                </details>
                <?php endforeach; ?>
            </div>

            <p class="fc-section-header__body fc-reveal" style="text-align:center;margin-top:var(--fc-space-xl);">
                <a href="<?php echo esc_url( $faq_url ); ?>" class="fc-btn fc-btn--ghost">Read the full FAQ</a>
            </p>
        </div>
    </section>

    <!-- ── Final CTA ── -->
    <section class="fc-section fc-section--plan-cta">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-cta fc-reveal">
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'plans_cta_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'plans_cta_body' ) ); ?></p>
                <div class="fc-plan-cta__actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $booking_url ); ?>" class="fc-btn fc-btn--ghost">Book consultation</a>
                </div>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
