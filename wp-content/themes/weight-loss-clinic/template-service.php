<?php
/**
 * Template Name: Service Page
 *
 * Reusable treatment/service page template for Digital Clinic brands.
 * Structured sections powered by ACF fields with safe fallbacks.
 */
get_header();

$has_acf = function_exists( 'get_field' );

/* ── Hero fields ── */
$title      = get_the_title();
$intro      = $has_acf ? get_field( 'svc_hero_intro' ) : '';
$trust      = $has_acf ? get_field( 'svc_hero_trust' ) : '';
$cta_text   = $has_acf ? ( get_field( 'svc_hero_cta_text' ) ?: '' ) : '';
$cta_url    = $has_acf ? ( get_field( 'svc_hero_cta_url' ) ?: '#' ) : '#';
$cta2_text  = $has_acf ? ( get_field( 'svc_hero_cta2_text' ) ?: '' ) : '';
$cta2_url   = $has_acf ? ( get_field( 'svc_hero_cta2_url' ) ?: '#' ) : '#';
$hero_image = $has_acf ? get_field( 'svc_hero_image' ) : null;

/* ── Section fields ── */
$process_heading = $has_acf ? get_field( 'svc_process_heading' ) : '';
$process_steps   = $has_acf ? get_field( 'svc_process_steps' ) : [];
$elig_heading    = $has_acf ? get_field( 'svc_elig_heading' ) : '';
$elig_intro      = $has_acf ? get_field( 'svc_elig_intro' ) : '';
$elig_items      = $has_acf ? get_field( 'svc_elig_items' ) : [];
$ben_heading     = $has_acf ? get_field( 'svc_benefits_heading' ) : '';
$ben_items       = $has_acf ? get_field( 'svc_benefits_items' ) : [];
$faq_heading     = $has_acf ? get_field( 'svc_faq_heading' ) : '';
$faq_items       = $has_acf ? get_field( 'svc_faq_items' ) : [];
$cta_heading     = $has_acf ? get_field( 'svc_cta_heading' ) : '';
$cta_body        = $has_acf ? get_field( 'svc_cta_body' ) : '';
$cta_btn_text    = $has_acf ? ( get_field( 'svc_cta_btn_text' ) ?: '' ) : '';
$cta_btn_url     = $has_acf ? ( get_field( 'svc_cta_btn_url' ) ?: '#' ) : '#';
$disclaimer      = $has_acf ? get_field( 'svc_disclaimer' ) : '';
$show_clinicians = $has_acf ? get_field( 'svc_show_clinicians' ) : false;
?>

<article class="fc-service" id="post-<?php the_ID(); ?>">

    <!-- ═══════════════ HERO ═══════════════ -->
    <section class="fc-section fc-section--svc-hero">
        <div class="fc-container">
            <div class="fc-svc-hero <?php echo $hero_image ? 'fc-svc-hero--has-image' : ''; ?>">
                <div class="fc-svc-hero__content">
                    <?php if ( $trust ) : ?>
                        <p class="fc-svc-hero__trust fc-reveal"><?php echo wp_kses_post( $trust ); ?></p>
                    <?php endif; ?>

                    <h1 class="fc-svc-hero__title fc-reveal"><?php echo esc_html( $title ); ?></h1>

                    <?php if ( $intro ) : ?>
                        <p class="fc-svc-hero__intro fc-reveal"><?php echo esc_html( $intro ); ?></p>
                    <?php endif; ?>

                    <?php if ( $cta_text || $cta2_text ) : ?>
                        <div class="fc-svc-hero__actions fc-reveal">
                            <?php if ( $cta_text ) : ?>
                                <?php fc_button( $cta_text, $cta_url, 'primary' ); ?>
                            <?php endif; ?>
                            <?php if ( $cta2_text ) : ?>
                                <?php fc_button( $cta2_text, $cta2_url, 'ghost' ); ?>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( $hero_image ) : ?>
                    <div class="fc-svc-hero__image fc-reveal">
                        <?php fc_image( $hero_image, 'large', 'fc-svc-hero__img' ); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- ═══════════════ HOW IT WORKS ═══════════════ -->
    <?php if ( ! empty( $process_steps ) ) : ?>
        <?php
        get_template_part( 'template-parts/sections/how-it-works', null, [
            'data' => [
                'eyebrow'  => '',
                'headline' => $process_heading ?: 'How it works',
                'steps'    => $process_steps,
            ],
        ] );
        ?>
    <?php endif; ?>

    <!-- ═══════════════ ELIGIBILITY ═══════════════ -->
    <?php if ( ! empty( $elig_items ) ) : ?>
        <section class="fc-section fc-section--svc-eligibility">
            <div class="fc-container">
                <div class="fc-svc-elig">
                    <div class="fc-svc-elig__header fc-reveal">
                        <h2 class="fc-h2"><?php echo esc_html( $elig_heading ?: 'Is this right for you?' ); ?></h2>
                        <?php if ( $elig_intro ) : ?>
                            <p class="fc-svc-elig__intro"><?php echo esc_html( $elig_intro ); ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="fc-svc-elig__list fc-reveal">
                        <ul class="fc-checklist">
                            <?php foreach ( $elig_items as $item ) : ?>
                                <?php if ( empty( $item['text'] ) ) continue; ?>
                                <li class="fc-checklist__item">
                                    <span class="fc-checklist__icon"><?php echo fc_icon( 'check' ); ?></span>
                                    <span><?php echo esc_html( $item['text'] ); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ═══════════════ MID-PAGE CTA ═══════════════ -->
    <?php if ( $cta_text ) : ?>
        <?php
        get_template_part( 'template-parts/sections/cta-banner', null, [
            'data' => [
                'headline'  => 'Ready to take the next step?',
                'body'      => '',
                'cta_text'  => $cta_text,
                'cta_url'   => $cta_url,
                'cta2_text' => '',
                'cta2_url'  => '',
                'style'     => 'accent',
            ],
        ] );
        ?>
    <?php endif; ?>

    <!-- ═══════════════ BENEFITS ═══════════════ -->
    <?php if ( ! empty( $ben_items ) ) : ?>
        <section class="fc-section fc-section--svc-benefits">
            <div class="fc-container">
                <div class="fc-section-header fc-section-header--center fc-reveal">
                    <h2 class="fc-h2"><?php echo esc_html( $ben_heading ?: 'Key benefits' ); ?></h2>
                </div>

                <?php
                $cols = count( $ben_items ) <= 3 ? 3 : ( count( $ben_items ) === 4 ? 2 : 3 );
                ?>
                <div class="fc-grid fc-grid--<?php echo esc_attr( $cols ); ?>">
                    <?php foreach ( $ben_items as $item ) : ?>
                        <div class="fc-benefit-card fc-reveal">
                            <?php
                            $icon = ! empty( $item['icon'] ) ? $item['icon'] : 'check';
                            ?>
                            <div class="fc-benefit-card__icon">
                                <?php echo fc_icon( $icon ); ?>
                            </div>
                            <?php if ( ! empty( $item['title'] ) ) : ?>
                                <h3 class="fc-benefit-card__title"><?php echo esc_html( $item['title'] ); ?></h3>
                            <?php endif; ?>
                            <?php if ( ! empty( $item['description'] ) ) : ?>
                                <p class="fc-benefit-card__desc"><?php echo esc_html( $item['description'] ); ?></p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- ═══════════════ CLINICIANS ═══════════════ -->
    <?php if ( $show_clinicians ) : ?>
        <?php
        get_template_part( 'template-parts/sections/clinicians', null, [
            'data' => [
                'eyebrow'  => 'Your Care Team',
                'headline' => 'Meet our clinicians',
            ],
        ] );
        ?>
    <?php endif; ?>

    <!-- ═══════════════ FAQ ═══════════════ -->
    <?php if ( ! empty( $faq_items ) ) : ?>
        <?php
        get_template_part( 'template-parts/sections/faq', null, [
            'data' => [
                'eyebrow'  => 'Questions',
                'headline' => $faq_heading ?: 'Frequently asked questions',
                'items'    => $faq_items,
            ],
        ] );
        ?>
    <?php endif; ?>

    <!-- ═══════════════ FINAL CTA ═══════════════ -->
    <?php
    $final_cta_heading = $cta_heading ?: 'Ready to get started?';
    $final_cta_btn     = $cta_btn_text ?: $cta_text;
    $final_cta_url     = $cta_btn_url ?: $cta_url;

    if ( $final_cta_heading ) :
        get_template_part( 'template-parts/sections/cta-banner', null, [
            'data' => [
                'headline'  => $final_cta_heading,
                'body'      => $cta_body,
                'cta_text'  => $final_cta_btn ?: ( fc_setting( 'cta_text' ) ),
                'cta_url'   => $final_cta_url ?: '#',
                'cta2_text' => '',
                'cta2_url'  => '',
                'style'     => 'dark',
            ],
        ] );
    endif;
    ?>

    <!-- ═══════════════ DISCLAIMER ═══════════════ -->
    <?php fc_disclaimer( $disclaimer ); ?>

</article>

<?php get_footer(); ?>
