<?php
/**
 * Section: Service / Program Band
 *
 * MEDVi-style layout:
 *   Left sidebar  (~35%): primary image + benefits heading + checklist
 *   Right main    (~65%): eyebrow + headline + dual inline images + subheading + body + CTA
 */
$data = $args['data'] ?? [];

$eyebrow          = $data['eyebrow'] ?? '';
$headline         = $data['headline'] ?? '';
$accent           = $data['headline_accent'] ?? '';
$color            = $data['accent_color'] ?? '#2E936F';
$subheading       = $data['subheading'] ?? '';
$body             = $data['body'] ?? '';
$cta_text         = $data['cta_text'] ?? '';
$cta_url          = ( $data['cta_url'] ?? '' ) ?: '#';
$cta_style        = $data['cta_style'] ?? 'primary'; // 'primary' or 'disabled'
$image            = $data['image'] ?? null;
$image2           = $data['image_2'] ?? null;
$image3           = $data['image_3'] ?? null;
$benefits         = $data['benefits'] ?? [];
$benefits_heading = $data['benefits_heading'] ?? '';
$stat_num         = $data['stat_number'] ?? '';
$stat_label       = $data['stat_label'] ?? '';

if ( ! $headline ) return;

$headline_html = fc_accent_headline( $headline, $accent );
?>

<section class="fc-section fc-section--service-band" style="--section-accent:<?php echo esc_attr( $color ); ?>">
    <div class="fc-container">
        <div class="fc-service-band">

            <!-- LEFT SIDEBAR: primary image + benefits -->
            <div class="fc-service-band__sidebar fc-reveal">
                <?php if ( $image ) : ?>
                    <div class="fc-service-band__primary-img">
                        <?php fc_image( $image, 'fc-service' ); ?>
                    </div>
                <?php else : ?>
                    <div class="fc-service-band__primary-img fc-service-band__placeholder">
                        <div class="fc-service-band__placeholder-inner">
                            <span class="fc-service-band__placeholder-label"><?php echo esc_html( $eyebrow ?: 'Image' ); ?></span>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ( ! empty( $benefits ) ) : ?>
                    <div class="fc-service-band__benefits">
                        <?php if ( $benefits_heading ) : ?>
                            <p class="fc-service-band__benefits-heading"><?php echo esc_html( $benefits_heading ); ?></p>
                        <?php endif; ?>
                        <ul class="fc-checklist" role="list">
                            <?php foreach ( $benefits as $benefit ) : ?>
                                <?php if ( ! empty( $benefit['text'] ) ) : ?>
                                    <li class="fc-checklist__item">
                                        <span class="fc-checklist__icon" aria-hidden="true"><?php echo fc_icon( 'check' ); ?></span>
                                        <span><?php echo esc_html( $benefit['text'] ); ?></span>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            </div>

            <!-- RIGHT MAIN: content + inline images -->
            <div class="fc-service-band__main fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow fc-service-band__eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>

                <h2 class="fc-h2 fc-service-band__headline"><?php echo $headline_html; ?></h2>

                <!-- Dual inline images -->
                <div class="fc-service-band__inline-images">
                    <?php if ( $image2 ) : ?>
                        <div class="fc-service-band__inline-img">
                            <?php fc_image( $image2, 'fc-lifestyle' ); ?>
                        </div>
                    <?php else : ?>
                        <div class="fc-service-band__inline-img fc-service-band__placeholder-inline">
                            <span class="fc-service-band__placeholder-label"><?php echo esc_html( $eyebrow ?: 'Photo' ); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ( $image3 ) : ?>
                        <div class="fc-service-band__inline-img">
                            <?php fc_image( $image3, 'fc-lifestyle' ); ?>
                        </div>
                    <?php else : ?>
                        <div class="fc-service-band__inline-img fc-service-band__placeholder-inline">
                            <span class="fc-service-band__placeholder-label">Lifestyle</span>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if ( $subheading ) : ?>
                    <p class="fc-h3 fc-service-band__subheading"><?php echo esc_html( $subheading ); ?></p>
                <?php endif; ?>

                <?php if ( $body ) : ?>
                    <p class="fc-service-band__body"><?php echo esc_html( $body ); ?></p>
                <?php endif; ?>

                <?php if ( $stat_num ) : ?>
                    <div class="fc-service-band__stat">
                        <span class="fc-service-band__stat-number"><?php echo esc_html( $stat_num ); ?></span>
                        <?php if ( $stat_label ) : ?>
                            <span class="fc-service-band__stat-label"><?php echo esc_html( $stat_label ); ?></span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ( $cta_text ) : ?>
                    <div class="fc-service-band__cta">
                        <?php if ( $cta_style === 'disabled' ) : ?>
                            <span class="fc-btn fc-btn--disabled"><?php echo esc_html( $cta_text ); ?></span>
                        <?php else : ?>
                            <?php fc_button( $cta_text, $cta_url, 'primary' ); ?>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
