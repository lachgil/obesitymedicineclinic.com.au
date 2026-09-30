<?php
/**
 * Section: Benefits Grid
 */
$data    = $args['data'] ?? [];
$eyebrow = $data['eyebrow'] ?? '';
$headline = $data['headline'] ?? '';
$items   = $data['items'] ?? [];

if ( empty( $items ) ) return;

$cols = count( $items ) <= 3 ? 3 : ( count( $items ) === 4 ? 2 : 3 );
?>

<section class="fc-section fc-section--benefits-grid">
    <div class="fc-container">
        <?php if ( $eyebrow || $headline ) : ?>
            <div class="fc-section-header fc-section-header--center fc-reveal">
                <?php if ( $eyebrow ) : ?>
                    <p class="fc-eyebrow"><?php echo esc_html( $eyebrow ); ?></p>
                <?php endif; ?>
                <?php if ( $headline ) : ?>
                    <h2 class="fc-h2"><?php echo esc_html( $headline ); ?></h2>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="fc-grid fc-grid--<?php echo esc_attr( $cols ); ?>">
            <?php foreach ( $items as $item ) : ?>
                <div class="fc-benefit-card fc-reveal">
                    <?php if ( ! empty( $item['image'] ) ) : ?>
                        <div class="fc-benefit-card__image">
                            <?php fc_image( $item['image'], 'fc-card' ); ?>
                        </div>
                    <?php elseif ( ! empty( $item['icon'] ) ) : ?>
                        <div class="fc-benefit-card__icon">
                            <?php echo fc_icon( $item['icon'] ); ?>
                        </div>
                    <?php endif; ?>
                    <h3 class="fc-benefit-card__title"><?php echo esc_html( $item['title'] ?? '' ); ?></h3>
                    <?php if ( ! empty( $item['description'] ) ) : ?>
                        <p class="fc-benefit-card__desc"><?php echo esc_html( $item['description'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
