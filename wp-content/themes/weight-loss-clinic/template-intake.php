<?php
/**
 * Template Name: Patient Intake
 *
 * Canonical clinical intake shell. Shares the fc-assessment chrome with
 * template-quiz.php so the quiz → intake handoff reads as one continuous
 * pathway. The [wlc_intake_form] shortcode (from wlc-clinical-pathway)
 * outputs only its data payload + script bootstrap inside the viewport;
 * the JS injects screens (welcome → basic info → medical → evidence →
 * consent → success) one at a time.
 *
 * Assign this template to the /patient-intake/ page (the plugin sets the
 * _wp_page_template meta on activation; the page_template filter is the
 * fallback for already-existing installs).
 */

get_header();

$img_base   = FC_URI . '/assets/images/intake';
$portal_url = fc_setting( 'portal_url' );
?>

<section class="fc-assessment" id="fc-intake"
    data-portal-url="<?php echo esc_attr( $portal_url ); ?>"
    data-img-welcome="<?php echo esc_attr( $img_base . '/intake-welcome.jpg' ); ?>"
    data-img-basic="<?php echo esc_attr( $img_base . '/intake-questions.jpg' ); ?>"
    data-img-medical="<?php echo esc_attr( $img_base . '/intake-medical.jpg' ); ?>"
    data-img-evidence="<?php echo esc_attr( $img_base . '/intake-review.jpg' ); ?>"
    data-img-consent="<?php echo esc_attr( $img_base . '/intake-clinical.jpg' ); ?>"
    data-img-pathway="<?php echo esc_attr( $img_base . '/intake-pathway.jpg' ); ?>">

    <div class="fc-assessment__shell">

        <!-- ── Form column ── -->
        <div class="fc-assessment__form">

            <header class="fc-intake__progress-header">
                <div class="fc-intake__progress-row">
                    <span class="fc-intake__progress-label" id="fc-intake-counter">Clinical intake</span>
                    <span class="fc-intake__progress-pct" id="fc-intake-pct">0%</span>
                </div>
                <div class="fc-intake__progress-track" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    <div class="fc-intake__progress-fill" id="fc-intake-progress"></div>
                </div>
            </header>

            <div class="fc-intake__topbar">
                <button class="fc-intake__back" id="fc-intake-back" type="button" aria-label="Go back" style="visibility: hidden;">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                    <span>Back</span>
                </button>
                <span class="fc-intake__trust" aria-hidden="true">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <?php echo esc_html( fc_setting( 'intake_topbar_trust' ) ); ?>
                </span>
            </div>

            <!-- Viewport — the plugin's intake.js injects screens here -->
            <div class="fc-intake__viewport" id="fc-intake-viewport">
                <?php echo do_shortcode( '[wlc_intake_form]' ); ?>
            </div>

            <footer class="fc-assessment__trustrow" aria-hidden="false">
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    <?php echo esc_html( fc_setting( 'intake_trust_item1' ) ); ?>
                </span>
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9 12l2 2 4-4"/></svg>
                    <?php echo esc_html( fc_setting( 'intake_trust_item2' ) ); ?>
                </span>
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0110 0v4"/></svg>
                    <?php echo esc_html( fc_setting( 'intake_trust_item3' ) ); ?>
                </span>
                <span class="fc-assessment__trustrow-item">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h4l3-9 4 18 3-9h4"/></svg>
                    <?php echo esc_html( fc_setting( 'intake_trust_item4' ) ); ?>
                </span>
            </footer>
        </div>

        <!-- ── Desktop side panel (quiet trust signal) ── -->
        <aside class="fc-assessment__sidepanel" aria-hidden="true">
            <div class="fc-intake__image-layer fc-intake__image-layer--active"
                 id="fc-intake-image-a"
                 style="background-image:url('<?php echo esc_url( $img_base . '/intake-welcome.jpg' ); ?>');"></div>
            <div class="fc-intake__image-layer" id="fc-intake-image-b"></div>
            <div class="fc-intake__image-gradient"></div>
            <div class="fc-assessment__sidepanel-overlay">
                <div class="fc-intake__imagequote" id="fc-intake-imagequote">
                    <p class="fc-intake__imagequote-text"><?php echo esc_html( fc_setting( 'intake_quote_text' ) ); ?></p>
                    <p class="fc-intake__imagequote-attribution"><?php echo esc_html( fc_setting( 'intake_quote_attribution' ) ); ?></p>
                </div>
            </div>
        </aside>

    </div>
</section>

<?php get_footer(); ?>
