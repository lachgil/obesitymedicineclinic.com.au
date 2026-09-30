<?php
/**
 * Section: FAQ
 */
$data     = $args['data'] ?? [];
$eyebrow  = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$items    = $data['items'] ?? [];

if ( empty( $items ) ) return;

$faq_id = 'fc-faq-' . wp_unique_id();
?>

<section class="fc-section fc-section--faq" id="common-questions">
    <div class="fc-container">
        <div class="fc-faq-layout">
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
            </div>

            <div class="fc-accordion fc-reveal" role="region" aria-label="<?php echo esc_attr( $headline ?: __( 'Frequently asked questions', 'flavour-clinic' ) ); ?>">
                <?php foreach ( $items as $index => $item ) :
                    if ( empty( $item['question'] ) ) continue;
                    $panel_id   = $faq_id . '-panel-' . $index;
                    $trigger_id = $faq_id . '-trigger-' . $index;
                ?>
                    <div class="fc-accordion__item">
                        <h3>
                            <button class="fc-accordion__trigger"
                                    id="<?php echo esc_attr( $trigger_id ); ?>"
                                    aria-expanded="false"
                                    aria-controls="<?php echo esc_attr( $panel_id ); ?>">
                                <span><?php echo esc_html( $item['question'] ); ?></span>
                                <?php echo fc_icon( 'chevron-down', 'fc-icon--sm' ); ?>
                            </button>
                        </h3>
                        <div class="fc-accordion__panel"
                             id="<?php echo esc_attr( $panel_id ); ?>"
                             role="region"
                             aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>"
                             aria-hidden="true">
                            <div class="fc-accordion__content">
                                <?php echo wp_kses_post( $item['answer'] ?? '' ); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
