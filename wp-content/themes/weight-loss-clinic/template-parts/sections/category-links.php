<?php
/**
 * Section: Category Quick Links
 */
$data  = $args['data'] ?? [];
$items = $data['items'] ?? [];

if ( empty( $items ) ) return;
?>

<section class="fc-section fc-section--category-links">
    <div class="fc-container">
        <div class="fc-grid fc-grid--4">
            <?php foreach ( $items as $item ) : ?>
                <a href="<?php echo esc_url( $item['url'] ?? '#' ); ?>" class="fc-cat-card fc-reveal">
                    <?php if ( ! empty( $item['image'] ) ) : ?>
                        <div class="fc-cat-card__image">
                            <?php fc_image( $item['image'], 'fc-card' ); ?>
                        </div>
                    <?php endif; ?>
                    <span class="fc-cat-card__label">
                        <?php echo esc_html( $item['label'] ?? '' ); ?>
                        <?php echo fc_icon( 'arrow-right', 'fc-icon--sm' ); ?>
                    </span>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
