<?php
/**
 * Template Name: About & Clinical Governance
 *
 * All copy is editable in Customize → Theme Settings → Page — About &
 * Governance; defaults live in inc/options/page-about.php.
 *
 * MVP layout (May 2026):
 *   - Image hero (clinician welcome portrait, dignified)
 *   - Why this clinic exists (short institutional intro)
 *   - Lead specialist card (Dr Dolan)
 *   - Governance principles (6 principle blocks)
 *   - Telehealth limitations (when we decline / when we refer on)
 *   - Clinician standards block
 *   - Regulatory posture
 *   - CTA
 *
 * @package WeightLossClinic
 */

get_header();

$quiz_url    = fc_setting( 'cta_url' );
$booking_url = fc_setting( 'booking_url' );
$hiw_url     = fc_setting( 'how_it_works_url' );
$faq_url     = fc_setting( 'faq_url' );
$contact_url = fc_setting( 'contact_url' );

$specialist_name  = fc_setting( 'specialist_name' );
$specialist_title = fc_setting( 'specialist_title' );
$clinician_uri    = FC_URI . '/assets/images/clinician';
$lifestyle_uri    = FC_URI . '/assets/images/lifestyle';

$hero_image = fc_setting_image( 'about_hero_image', $lifestyle_uri . '/clinician-welcome-portrait.jpg' );
$lead_image = fc_setting_image( 'about_lead_image', $clinician_uri . '/dr-dolan-portrait.jpg' );

// Specialist-derived strings: explicit setting wins; empty auto-generates.
$hero_intro = fc_setting( 'about_hero_intro', '' )
	?: 'A structured clinical service led by ' . $specialist_name . ', ' . $specialist_title . '. Every patient is individually assessed, every decision is clinical, and every safety limit is visible — including the cases we turn away.';
$lead_role = fc_setting( 'about_lead_role', '' )
	?: $specialist_title . ' · AHPRA-registered';
$standards_p1 = fc_setting( 'about_standards_p1', '' )
	?: 'The pathway is led by ' . $specialist_name . ', ' . $specialist_title . ', working alongside an AHPRA-registered clinical team. Every clinician follows evidence-based weight management guidelines, supported by a clinical governance framework that sets safety-first standards across the service.';
?>

<article class="fc-page fc-page--about">

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
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'about_hero_eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo fc_accent_headline( fc_setting( 'about_hero_headline' ), fc_setting( 'about_hero_accent' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo wp_kses_post( $hero_intro ); ?></p>
                <div class="fc-page__header-actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $hiw_url ); ?>" class="fc-btn fc-btn--ghost-light">How it works</a>
                </div>
            </header>
        </div>
    </div>

    <!-- ── Why this clinic exists ── -->
    <section class="fc-section fc-section--about-intro">
        <div class="fc-container fc-container--narrow">
            <div class="fc-about-intro fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'about_intro_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'about_intro_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'about_intro_p1' ) ); ?></p>
                <p><?php echo esc_html( fc_setting( 'about_intro_p2' ) ); ?></p>
            </div>
        </div>
    </section>

    <!-- ── Lead specialist ── -->
    <section class="fc-section fc-section--about-lead">
        <div class="fc-container">
            <div class="fc-specialist-card fc-reveal">
                <div class="fc-specialist-card__media">
                    <img
                        src="<?php echo esc_url( $lead_image ); ?>"
                        alt="<?php echo esc_attr( $specialist_name . ', ' . wp_strip_all_tags( $specialist_title ) ); ?>"
                        width="1400"
                        height="1750"
                        loading="lazy">
                </div>
                <div class="fc-specialist-card__body">
                    <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'about_lead_eyebrow' ) ); ?></p>
                    <h2 class="fc-h2"><?php echo esc_html( $specialist_name ); ?></h2>
                    <p class="fc-specialist-card__role"><?php echo wp_kses_post( $lead_role ); ?></p>
                    <p><?php echo esc_html( fc_setting( 'about_lead_p1' ) ); ?></p>
                    <p><?php echo esc_html( fc_setting( 'about_lead_p2' ) ); ?></p>
                    <ul class="fc-specialist-card__facts" role="list">
                        <?php foreach ( fc_setting_pairs( 'about_lead_facts', [ 'label', 'detail' ] ) as $fact ) : ?>
                            <li><strong><?php echo esc_html( $fact['label'] ); ?></strong><span><?php echo esc_html( $fact['detail'] ); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Governance principles ── -->
    <section class="fc-section fc-section--about-principles">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'about_principles_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'about_principles_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'about_principles_body' ) ); ?></p>
            </div>

            <div class="fc-about-principles">

                <?php foreach ( fc_setting_pairs( 'about_principles_items', [ 'icon', 'title', 'body' ] ) as $principle ) : ?>
                <div class="fc-about-principle fc-reveal">
                    <div class="fc-about-principle__icon" aria-hidden="true"><?php echo function_exists( 'fc_icon' ) ? fc_icon( $principle['icon'], 'fc-icon--lg' ) : ''; ?></div>
                    <h3 class="fc-h3"><?php echo esc_html( $principle['title'] ); ?></h3>
                    <p><?php echo esc_html( $principle['body'] ); ?></p>
                </div>
                <?php endforeach; ?>

            </div>
        </div>
    </section>

    <!-- ── Telehealth limitations ── -->
    <section class="fc-section fc-section--about-limits">
        <div class="fc-container fc-container--narrow">
            <div class="fc-about-limits fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'about_limits_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'about_limits_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'about_limits_body' ) ); ?></p>

                <div class="fc-about-limits__grid">
                    <div class="fc-about-limits__column">
                        <h3 class="fc-h4"><?php echo esc_html( fc_setting( 'about_limits_decline_title' ) ); ?></h3>
                        <ul class="fc-about-limits__list">
                            <?php foreach ( fc_setting_lines( 'about_limits_decline_items' ) as $item ) : ?>
                                <li><?php echo esc_html( $item ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <div class="fc-about-limits__column">
                        <h3 class="fc-h4"><?php echo esc_html( fc_setting( 'about_limits_refer_title' ) ); ?></h3>
                        <ul class="fc-about-limits__list">
                            <?php foreach ( fc_setting_lines( 'about_limits_refer_items' ) as $item ) : ?>
                                <li><?php echo esc_html( $item ); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>

                <p class="fc-about-limits__footnote"><?php echo esc_html( fc_setting( 'about_limits_footnote' ) ); ?></p>
            </div>
        </div>
    </section>

    <!-- ── Clinician standards ── -->
    <section class="fc-section fc-section--about-standards">
        <div class="fc-container">
            <div class="fc-about-standards fc-reveal">
                <div class="fc-about-standards__text">
                    <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'about_standards_eyebrow' ) ); ?></p>
                    <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'about_standards_headline' ) ); ?></h2>
                    <p><?php echo wp_kses_post( $standards_p1 ); ?></p>
                    <p><?php echo esc_html( fc_setting( 'about_standards_p2' ) ); ?></p>
                </div>
                <div class="fc-about-standards__facts">
                    <?php foreach ( fc_setting_pairs( 'about_standards_facts', [ 'label', 'detail' ] ) as $fact ) : ?>
                    <div class="fc-about-fact">
                        <strong><?php echo esc_html( $fact['label'] ); ?></strong>
                        <span><?php echo esc_html( $fact['detail'] ); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- ── Regulatory posture ── -->
    <section class="fc-section fc-section--about-regulatory">
        <div class="fc-container fc-container--narrow">
            <div class="fc-about-regulatory fc-reveal">
                <h2 class="fc-h3"><?php echo esc_html( fc_setting( 'about_regulatory_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'about_regulatory_body' ) ); ?></p>
                <ul class="fc-about-regulatory__list">
                    <?php foreach ( fc_setting_lines( 'about_regulatory_items' ) as $item ) : ?>
                        <li><?php echo esc_html( $item ); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </section>

    <!-- ── CTA ── -->
    <section class="fc-section fc-section--about-cta">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-cta fc-reveal">
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'about_cta_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'about_cta_body' ) ); ?></p>
                <div class="fc-plan-cta__actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $hiw_url ); ?>" class="fc-btn fc-btn--ghost">How it works</a>
                    <a href="<?php echo esc_url( $faq_url ); ?>" class="fc-btn fc-btn--ghost">Read the FAQ</a>
                </div>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
