<?php
/**
 * Template Name: Clinician-Led Care
 *
 * Dedicated page profiling the lead specialist (Dr Kevin Dolan) and the
 * clinician-led model that sits behind the telehealth pathway. Threads
 * real clinic photography for trust and credibility.
 *
 * All copy is editable in Customize → Theme Settings → Page —
 * Clinician-Led Care; defaults live in inc/options/page-clinician-led-care.php.
 *
 * Page slug: /clinician-led-care/
 *
 * @package WeightLossClinic
 */

defined( 'ABSPATH' ) || exit;

get_header();

$quiz_url      = fc_setting( 'cta_url' );
$about_url     = fc_setting( 'about_url' );
$faq_url       = fc_setting( 'faq_url' );
$booking_url   = fc_setting( 'booking_url' );

$specialist_name  = fc_setting( 'specialist_name' );
$specialist_title = fc_setting( 'specialist_title' );
$clinician_uri    = FC_URI . '/assets/images/clinician';

$specialist_image = fc_setting_image( 'clc_specialist_image', $clinician_uri . '/dr-dolan-surgical-portrait.jpg' );

// Photography band: image fallbacks + alt text per figure.
$context_figures = [
	1 => [
		'image' => fc_setting_image( 'clc_context1_image', $clinician_uri . '/dr-dolan-consultation.jpg' ),
		'alt'   => $specialist_name . ' in consultation',
	],
	2 => [
		'image' => fc_setting_image( 'clc_context2_image', $clinician_uri . '/dr-dolan-explaining.jpg' ),
		'alt'   => $specialist_name . ' explaining clinical anatomy',
	],
	3 => [
		'image' => fc_setting_image( 'clc_context3_image', $clinician_uri . '/dr-dolan-surgical.jpg' ),
		'alt'   => $specialist_name . ', surgical practice',
	],
];
?>

<article class="fc-page fc-page--clinician-led">

    <div class="fc-page__header-wrap fc-page__header-wrap--branded">
        <div class="fc-container">
            <header class="fc-page__header fc-page__header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'clc_hero_eyebrow' ) ); ?></p>
                <h1 class="fc-h1"><?php echo fc_accent_headline( fc_setting( 'clc_hero_headline' ), fc_setting( 'clc_hero_accent' ) ); ?></h1>
                <p class="fc-page__intro"><?php echo esc_html( fc_setting( 'clc_hero_intro' ) ); ?></p>
            </header>
        </div>
    </div>

    <!-- ── Specialist hero ── -->
    <section class="fc-section fc-section--cl-hero">
        <div class="fc-container">
            <div class="fc-cl-hero fc-reveal">
                <div class="fc-cl-hero__media">
                    <img
                        src="<?php echo esc_url( $specialist_image ); ?>"
                        alt="<?php echo esc_attr( $specialist_name . ' in operating theatre' ); ?>"
                        width="1400"
                        height="1750"
                        loading="lazy">
                </div>
                <div class="fc-cl-hero__body">
                    <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'clc_specialist_eyebrow' ) ); ?></p>
                    <h2 class="fc-h2"><?php echo esc_html( $specialist_name ); ?></h2>
                    <p class="fc-cl-hero__role"><?php echo wp_kses_post( $specialist_title ); ?></p>
                    <p><?php echo esc_html( fc_setting( 'clc_specialist_p1' ) ); ?></p>
                    <p><?php echo esc_html( fc_setting( 'clc_specialist_p2' ) ); ?></p>
                    <div class="fc-cl-hero__cta">
                        <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                        <a href="<?php echo esc_url( $about_url ); ?>" class="fc-btn fc-btn--ghost">About &amp; governance</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ── How decisions get made ── -->
    <section class="fc-section fc-section--cl-decisions">
        <div class="fc-container">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <p class="fc-eyebrow"><?php echo esc_html( fc_setting( 'clc_decisions_eyebrow' ) ); ?></p>
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'clc_decisions_headline' ) ); ?></h2>
                <p class="fc-section-header__body"><?php echo esc_html( fc_setting( 'clc_decisions_body' ) ); ?></p>
            </div>

            <div class="fc-cl-decisions">
                <?php foreach ( [ 1, 2, 3, 4 ] as $n ) : ?>
                <div class="fc-cl-decision fc-reveal">
                    <span class="fc-cl-decision__num"><?php echo esc_html( sprintf( '%02d', $n ) ); ?></span>
                    <h3 class="fc-h4"><?php echo esc_html( fc_setting( "clc_decision{$n}_title" ) ); ?></h3>
                    <p><?php echo esc_html( fc_setting( "clc_decision{$n}_body" ) ); ?></p>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── Specialist context band (photography) ── -->
    <section class="fc-section fc-section--cl-context">
        <div class="fc-container">
            <div class="fc-cl-context fc-reveal">
                <?php foreach ( $context_figures as $n => $figure ) : ?>
                <figure>
                    <img
                        src="<?php echo esc_url( $figure['image'] ); ?>"
                        alt="<?php echo esc_attr( $figure['alt'] ); ?>"
                        loading="lazy">
                    <figcaption><?php echo esc_html( fc_setting( "clc_context{$n}_caption" ) ); ?></figcaption>
                </figure>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ── CTA ── -->
    <section class="fc-section fc-section--cl-cta">
        <div class="fc-container fc-container--narrow">
            <div class="fc-plan-cta fc-reveal">
                <h2 class="fc-h2"><?php echo esc_html( fc_setting( 'clc_cta_headline' ) ); ?></h2>
                <p><?php echo esc_html( fc_setting( 'clc_cta_body' ) ); ?></p>
                <div class="fc-plan-cta__actions">
                    <a href="<?php echo esc_url( $quiz_url ); ?>" class="fc-btn fc-btn--primary">Check eligibility</a>
                    <a href="<?php echo esc_url( $faq_url ); ?>" class="fc-btn fc-btn--ghost">Read the FAQ</a>
                </div>
            </div>
        </div>
    </section>

</article>

<?php get_footer(); ?>
