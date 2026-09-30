<?php
/**
 * Section: Trust / Guarantee Strip
 */
$data  = $args['data'] ?? [];
$items = $data['items'] ?? [];

if ( empty( $items ) ) return;
?>

<section class="fc-section fc-section--trust-strip" aria-label="<?php esc_attr_e( 'Our guarantees', 'flavour-clinic' ); ?>">
    <div class="fc-container">
        <div class="fc-trust-strip">
            <?php foreach ( $items as $item ) : ?>
                <?php if ( empty( $item['title'] ) ) continue; ?>
                <div class="fc-trust-item fc-reveal">
                    <?php if ( ! empty( $item['icon'] ) ) : ?>
                        <div class="fc-trust-item__icon" aria-hidden="true">
                            <?php echo fc_icon( $item['icon'] ); ?>
                        </div>
                    <?php endif; ?>
                    <p class="fc-trust-item__title"><?php echo esc_html( $item['title'] ); ?></p>
                    <?php if ( ! empty( $item['description'] ) ) : ?>
                        <p class="fc-trust-item__desc"><?php echo esc_html( $item['description'] ); ?></p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
