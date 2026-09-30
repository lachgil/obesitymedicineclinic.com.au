<?php
/**
 * Section: Trust Marquee Bar
 */
$data      = $args['data'] ?? [];
$use_global = $data['use_global'] ?? true;

if ( $use_global && function_exists( 'get_field' ) ) {
    $items = get_field( 'global_trust_items', 'option' ) ?: [];
} else {
    $items = $data['items'] ?? [];
}

if ( empty( $items ) ) return;
?>

<section class="fc-section fc-section--trust-marquee" aria-label="<?php esc_attr_e( 'Trust signals', 'flavour-clinic' ); ?>">
    <div class="fc-marquee" role="marquee">
        <?php /* Render the same set 4× so the track always exceeds the viewport.
                 Animation shifts by exactly one set width (25%) for seamless loop. */ ?>
        <?php for ( $i = 0; $i < 4; $i++ ) : ?>
            <span class="fc-marquee__set">
                <?php foreach ( $items as $item ) : ?>
                    <span class="fc-marquee__item">
                        <?php if ( ! empty( $item['icon'] ) ) echo fc_icon( $item['icon'], 'fc-icon--md' ); ?>
                        <?php echo esc_html( $item['text'] ?? '' ); ?>
                    </span>
                <?php endforeach; ?>
            </span>
        <?php endfor; ?>
    </div>
</section>
