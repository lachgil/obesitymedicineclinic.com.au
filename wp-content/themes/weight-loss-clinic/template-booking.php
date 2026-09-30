<?php
/**
 * Template Name: Booking
 *
 * MVP layout (May 2026):
 *   - Image hero (lifestyle, "considered first step")
 *   - "Before you book" trust panel
 *   - 3-step expectation setter
 *   - Booking widget (Coviu when provisioned, intake-fallback otherwise)
 *   - Compliance fineprint
 *   - Alternative CTA: "Not ready? Read how it works"
 *   - Care-team support / contact bridge
 *
 * All copy is editable in Customize → Theme Settings → Page — Booking;
 * defaults live in inc/options/page-booking.php.
 *
 * The booking widget is provider-agnostic: reads BRAND_TELEHEALTH_PROVIDER
 * and swaps between Coviu (when provisioned) and an intake-fallback flow
 * without further template changes. See docs/coviu-integration.md.
 *
 * Page slug: /book/  (auto-created by inc/setup/pages.php)
 *
 * @package WeightLossClinic
 */

get_header();

$provider    = fc_setting( 'telehealth_provider' );
$coviu_url   = fc_setting( 'coviu_booking_url' );
$quiz_url    = fc_setting( 'cta_url' );
$intake_url  = fc_setting( 'intake_url' );
$contact_url = fc_setting( 'contact_url' );
$portal_url  = fc_setting( 'portal_url' );
$hiw_url     = fc_setting( 'how_it_works_url' );
$support     = fc_setting( 'support_email' );

$is_coviu_live = ( $provider === 'coviu' && ! empty( $coviu_url ) );

$lifestyle_uri = FC_URI . '/assets/images/lifestyle';
$hero_image    = fc_setting_image( 'booking_hero_image', $lifestyle_uri . '/coastal-coffee-reflection.jpg' );
?>

<article class="fc-page fc-page--booking">

    <div class="fc-page__hero" role="presentation" data-fc-track="booking_viewed">
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
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'booking_hero_eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo fc_accent_headline( fc_setting( 'booking_hero_headline' ), fc_setting( 'booking_hero_accent' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo esc_html( fc_setting( 'booking_hero_intro' ) ); ?></p>
                <div class="fc-page__header-actions">
                    <a href="#book-now" class="fc-btn fc-btn--primary">Book consultation</a>
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--ghost-light">Check eligibility first</a>
                </div>
            </header>
        </div>
    </div>

    <!-- ── Before you book trust panel + what you're booking ── -->
    <section class="fc-section fc-section--booking-intro">
        <div class="fc-container">
            <div class="fc-booking-grid">

                <div class="fc-booking-grid__primary fc-reveal">
                    <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'booking_intro_eyebrow' ) ); ?></p>
                    <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'booking_intro_headline' ) ); ?></h2>
                    <p><?php echo esc_html( fc_setting( 'booking_intro_body' ) ); ?></p>

                    <ul class="fc-booking-list">
                        <?php foreach ( fc_setting_pairs( 'booking_intro_items', [ 'label', 'detail' ] ) as $item ) : ?>
                            <li><strong><?php echo esc_html( $item['label'] ); ?>:</strong> <?php echo esc_html( $item['detail'] ); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <aside class="fc-booking-grid__aside fc-reveal">
                    <div class="fc-booking-callout">
                        <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'booking_callout_eyebrow' ) ); ?></p>
                        <p><?php echo esc_html( fc_setting( 'booking_callout_body' ) ); ?></p>
                        <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--ghost">Check eligibility first</a>
                    </div>
                </aside>

            </div>
        </div>
    </section>

    <!-- ── 3-step expectation setter ── -->
    <section class="fc-section fc-section--booking-expectations">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'booking_steps_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'booking_steps_headline' ) ); ?></h2>
            </div>

            <div class="fc-booking-steps">
                <?php foreach ( [ 1, 2, 3 ] as $n ) :
                    $title = fc_setting( "booking_step{$n}_title" );
                    if ( ! $title ) {
                        continue;
                    }
                ?>
                <div class="fc-booking-step fc-reveal">
                    <span class="fc-booking-step__num"><?php echo esc_html( (string) $n ); ?></span>
                    <h3 class="fc-h4"><?php echo esc_html( $title ); ?></h3>
                    <p><?php echo esc_html( fc_setting( "booking_step{$n}_body" ) ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── Booking widget ── -->
    <section class="fc-section fc-section--booking-widget" id="book-now">
        <div class="fc-container fc-container--narrow">

            <div class="fc-booking-card fc-reveal">
                <div class="fc-booking-card__header">
                    <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'booking_widget_eyebrow' ) ); ?></p>
                    <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'booking_widget_headline' ) ); ?></h2>
                </div>

                <?php if ( $is_coviu_live ) : ?>
                    <div class="fc-booking-card__embed" data-provider="coviu">
                        <iframe
                            src="<?php echo esc_url( $coviu_url ); ?>"
                            title="Coviu — book a telehealth consultation"
                            loading="lazy"
                            allow="camera; microphone; fullscreen"
                            referrerpolicy="strict-origin-when-cross-origin"
                            class="fc-booking-card__iframe"
                        ></iframe>
                    </div>
                <?php else : ?>
                    <div class="fc-booking-card__placeholder" data-provider="placeholder">
                        <p class="fc-booking-card__placeholder-eyebrow"><?php echo esc_html( fc_setting( 'booking_placeholder_eyebrow' ) ); ?></p>
                        <h3 class="fc-h3"><?php echo esc_html( fc_setting( 'booking_placeholder_title' ) ); ?></h3>
                        <p><?php echo esc_html( fc_setting( 'booking_placeholder_body' ) ); ?></p>

                        <div class="fc-booking-card__actions">
                            <a href="<?php echo esc_url( $intake_url ); ?>" class="fc-btn fc-btn--primary" data-fc-track="booking_completed">Start intake now</a>
                            <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--ghost">Check eligibility first</a>
                        </div>

                        <p class="fc-booking-card__note"><?php echo esc_html( fc_setting( 'booking_placeholder_note' ) ); ?> <a href="<?php echo esc_url( $portal_url ); ?>">Access the patient portal</a>.</p>
                    </div>
                <?php endif; ?>

                <div class="fc-booking-card__fineprint">
                    <p><?php echo wp_kses_post( fc_setting( 'booking_fineprint' ) ); ?></p>
                </div>
            </div>

        </div>
    </section>

    <!-- ── Not ready? Bridge to /how-it-works/ ── -->
    <section class="fc-section fc-section--booking-not-ready">
        <div class="fc-container fc-container--narrow">
            <div class="fc-faq-midcta fc-reveal">
                <div class="fc-faq-midcta__inner">
                    <p><?php echo esc_html( fc_setting( 'booking_notready_text' ) ); ?></p>
                    <a href="<?php echo esc_url( $hiw_url ); ?>" class="fc-btn fc-btn--ghost">How it works</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Care-team support / contact bridge ── -->
    <section class="fc-section fc-section--booking-support">
        <div class="fc-container">
            <div class="fc-booking-support fc-reveal">
                <div class="fc-booking-support__text">
                    <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'booking_support_title' ) ); ?></h2>
                    <p><?php echo esc_html( fc_setting( 'booking_support_body' ) ); ?></p>
                </div>
                <div class="fc-booking-support__links">
                    <?php if ( $support ) : ?>
                        <a href="mailto:<?php echo esc_attr( $support ); ?>" class="fc-btn fc-btn--secondary">Email our care team</a>
                    <?php endif; ?>
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="fc-btn fc-btn--ghost">Visit contact page</a>
                </div>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
