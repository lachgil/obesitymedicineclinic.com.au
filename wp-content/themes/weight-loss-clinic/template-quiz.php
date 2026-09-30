<?php
/**
 * Template Name: Eligibility Quiz
 *
 * Dedicated assessment shell — a focused conversion flow, not a normal
 * WordPress page. The active step always sits comfortably inside the
 * viewport; the footer is pushed below the fold via `min-height: 100vh`
 * on the section. An optional trust panel sits beside the form on
 * desktop (it never dominates the page).
 *
 * Create a WordPress page with slug "quiz" and assign this template.
 */

get_header();

$checkout_url = fc_setting( 'checkout_url' );
$booking_url  = fc_setting( 'booking_url' );
$review_url   = fc_setting( 'review_url' );
$contact_url  = fc_setting( 'contact_url' );
$price_from   = (int) fc_setting( 'price_from' );

$img_base = FC_URI . '/assets/images/intake';
?>

<section class="fc-assessment" id="fc-quiz"
    data-checkout-url="<?php echo esc_attr( $checkout_url ); ?>"
    data-booking-url="<?php echo esc_attr( $booking_url ); ?>"
    data-review-url="<?php echo esc_attr( $review_url ); ?>"
    data-contact-url="<?php echo esc_attr( $contact_url ); ?>"
    data-price-from="<?php echo esc_attr( $price_from ); ?>"
    data-img-welcome="<?php echo esc_attr( $img_base . '/intake-welcome.jpg' ); ?>"
    data-img-questions="<?php echo esc_attr( $img_base . '/intake-questions.jpg' ); ?>"
    data-img-clinical="<?php echo esc_attr( $img_base . '/intake-clinical.jpg' ); ?>"
    data-img-medical="<?php echo esc_attr( $img_base . '/intake-medical.jpg' ); ?>"
    data-img-review="<?php echo esc_attr( $img_base . '/intake-review.jpg' ); ?>"
    data-img-pathway="<?php echo esc_attr( $img_base . '/intake-pathway.jpg' ); ?>">

    <div class="fc-assessment__shell">

        <!-- ── Form column (dominates the page) ── -->
        <div class="fc-assessment__form">

            <!-- Persistent progress (logo lives in the global header) -->
            <header class="fc-intake__progress-header">
                <div class="fc-intake__progress-row">
                    <span class="fc-intake__progress-label" id="fc-quiz-counter">Welcome</span>
                    <span class="fc-intake__progress-pct" id="fc-intake-pct">0%</span>
                </div>
                <div class="fc-intake__progress-track" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div class="fc-intake__progress-fill" id="fc-quiz-progress"></div>
                </div>
            </header>

            <!-- Back button (visible from step 2 onward) -->
            <div class="fc-intake__topbar">
                <button class="fc-intake__back" id="fc-quiz-back" type="button" aria-label="Go back" style="visibility: hidden;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    <span>Back</span>
                </button>
                <span class="fc-intake__trust" aria-hidden="true">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <?php echo esc_html( fc_setting( 'quiz_topbar_trust' ) ); ?>
                </span>
            </div>

            <!-- Active step — injected by JS -->
            <div class="fc-intake__viewport" id="fc-quiz-viewport"></div>

            <!-- Persistent trust row at the bottom of the card -->
            <footer class="fc-assessment__trustrow" aria-hidden="false">
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <?php echo esc_html( fc_setting( 'quiz_trust_item1' ) ); ?>
                </span>
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <?php echo esc_html( fc_setting( 'quiz_trust_item2' ) ); ?>
                </span>
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <?php echo esc_html( fc_setting( 'quiz_trust_item3' ) ); ?>
                </span>
            </footer>
        </div>

        <!-- ── Optional trust panel (desktop only — never dominates) ── -->
        <aside class="fc-assessment__sidepanel" aria-hidden="true">
            <div class="fc-intake__image-layer fc-intake__image-layer--active"
                 id="fc-intake-image-a"
                 style="background-image:url('<?php echo esc_url( $img_base . '/intake-welcome.jpg' ); ?>');"></div>
            <div class="fc-intake__image-layer" id="fc-intake-image-b"></div>
            <div class="fc-intake__image-gradient"></div>
            <div class="fc-assessment__sidepanel-overlay">
                <div class="fc-intake__imagequote" id="fc-intake-imagequote">
                    <p class="fc-intake__imagequote-text"><?php echo esc_html( fc_setting( 'quiz_quote_text' ) ); ?></p>
                    <p class="fc-intake__imagequote-attribution"><?php echo esc_html( fc_setting( 'quiz_quote_attribution' ) ); ?></p>
                </div>
            </div>
        </aside>

    </div>
</section>

<?php get_footer(); ?>
